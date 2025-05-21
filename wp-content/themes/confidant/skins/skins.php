<?php
/**
 * Skins support
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.46
 */

// Return name of the active skin
if ( ! function_exists( 'confidant_skins_get_active_skin_name' ) ) {
	function confidant_skins_get_active_skin_name() {
		static $confidant_active_skin_saved = false;
		$confidant_active_skin = '';
		if ( ! is_admin() ) {
			$confidant_active_skin = confidant_get_value_gp( 'skin' );
			if ( CONFIDANT_REMEMBER_SKIN ) {
				if ( empty( $confidant_active_skin ) ) {
					$confidant_active_skin = confidant_get_cookie( 'confidant_current_skin' );
				} else if ( ! $confidant_active_skin_saved ) {
					confidant_set_cookie( 'confidant_current_skin', $confidant_active_skin );
					$confidant_active_skin_saved = true;
				}
			}
		}
		if ( empty( $confidant_active_skin ) ) {
			$confidant_active_skin = get_option( sprintf( 'theme_skin_%s', get_stylesheet() ), CONFIDANT_DEFAULT_SKIN );
		}
		return $confidant_active_skin;
	}
}

// Show admin notice
if ( ! function_exists( 'confidant_skins_admin_notice_skin_missing' ) ) {
	//Handler of the add_action('admin_notices', 'confidant_skins_admin_notice_skin_missing');
	function confidant_skins_admin_notice_skin_missing() {
		get_template_part( apply_filters( 'confidant_filter_get_template_part', 'skins/skins-notice-missing' ) );
	}
}

// Define constants for the current skin
if ( ! defined( 'CONFIDANT_SKIN_NAME' ) ) {
	$confidant_current_skin = confidant_skins_get_active_skin_name();
	// Set current 
	if ( ! file_exists( CONFIDANT_THEME_DIR . "skins/{$confidant_current_skin}/skin.php" )
		&&
		( CONFIDANT_CHILD_DIR == CONFIDANT_THEME_DIR || ! file_exists( CONFIDANT_CHILD_DIR . "skins/{$confidant_current_skin}/skin.php" ) )
	) {
		if ( is_admin() ) {
			add_action( 'admin_notices', 'confidant_skins_admin_notice_skin_missing' );
		}
		$confidant_current_skin = 'default';
		// Remove condition to set 'default' as an active skin if current skin is absent
		if ( false ) {
			update_option( sprintf( 'theme_skin_%s', get_stylesheet() ), $confidant_current_skin );
		}
	}
	define( 'CONFIDANT_SKIN_NAME', $confidant_current_skin );
}



// Return name of the current skin (can be overriden on the page)
if ( ! function_exists( 'confidant_skins_get_current_skin_name' ) ) {
	function confidant_skins_get_current_skin_name() {
		return confidant_esc( CONFIDANT_SKIN_NAME );
	}
}

// Return dir of the current skin (can be overriden on the page)
if ( ! function_exists( 'confidant_skins_get_current_skin_dir' ) ) {
	function confidant_skins_get_current_skin_dir( $skin=false ) {
		return 'skins/' . trailingslashit( $skin ? $skin : confidant_skins_get_current_skin_name() );
	}
}

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
if ( ! function_exists( 'confidant_skins_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'confidant_skins_theme_setup1', 1 );
	function confidant_skins_theme_setup1() {
		confidant_storage_set( 'skins', apply_filters( 'confidant_filter_skins_list', array() ) );
	}
}


// Add class to the body with current skin name
if ( ! function_exists( 'confidant_skins_add_body_class' ) ) {
	add_filter( 'body_class', 'confidant_skins_add_body_class' );
	function confidant_skins_add_body_class( $classes ) {
		$classes[] = sprintf( 'skin_%s', confidant_skins_get_current_skin_name() );
		return $classes;
	}
}


// Retrieve available skins from the upgrade-server
if ( ! function_exists( 'confidant_skins_get_available_skins' ) ) {
	add_filter( 'confidant_filter_skins_list', 'confidant_skins_get_available_skins' );
	function confidant_skins_get_available_skins( $skins = array() ) {
		$skins_file      = confidant_get_file_dir( 'skins/skins.json' );
		$skins_installed = json_decode( confidant_fgc( $skins_file ), true );
		$skins           = get_transient( 'confidant_list_skins' );
		if ( ! is_array( $skins ) || count( $skins ) == 0 ) {
			$skins_available = confidant_get_upgrade_data( array(
				'action' => 'info_skins'
			) );
			if ( empty( $skins_available['error'] ) && ! empty( $skins_available['data'] ) && $skins_available['data'][0] == '{' ) {
				$skins = json_decode( $skins_available['data'], true );
			}
			if ( ! is_array( $skins ) || count( $skins ) == 0 ) {
				$skins = $skins_installed;
			}
			set_transient( 'confidant_list_skins', $skins, 2 * 24 * 60 * 60 );       // Store to the cache for 2 days
		}
		// Check if new skins appears after the theme update
		// (included in the folder 'skins' inside the theme)
		if ( is_array( $skins_installed ) && count( $skins_installed ) > 0 ) {
			foreach( $skins_installed as $k => $v ) {
				if ( ! isset( $skins[ $k ] ) ) {
					$skins[ $k ] = $v;
				}
			}
		}
		// Check the state of each skin
		if ( is_array( $skins ) && count( $skins ) > 0 ) {
			foreach( $skins as $k => $v ) {
				if ( ! is_array( $v ) ) {
					unset( $skins[ $k ] );
				} else {
					$skins[ $k ][ 'installed' ] = confidant_skins_get_file_dir( "skin.php", $k ) != '' && ! empty( $skins_installed[ $k ][ 'version' ] )
													? $skins_installed[ $k ][ 'version' ]
													: '';
				}
			}
		}
		return $skins;
	}
}

// Delete the cache with a skins list on any plugin activated
if ( ! function_exists( 'confidant_skins_delete_skins_list' ) ) {
	add_action( 'activated_plugin', 'confidant_skins_delete_skins_list');
	function confidant_skins_delete_skins_list( $plugin = '', $network = false) {
		if ( strpos( $plugin, 'trx_addons' ) !== false ) {
			delete_transient( 'confidant_list_skins' );
		}
	}
}



// Notice with info about new skins or new versions of installed skins
//------------------------------------------------------------------------

// Show admin notice
if ( ! function_exists( 'confidant_skins_admin_notice' ) ) {
	add_action('admin_notices', 'confidant_skins_admin_notice');
	function confidant_skins_admin_notice() {
		// Check if new skins are available
		if ( current_user_can( 'update_themes' ) && confidant_is_theme_activated() ) {
			$skins  = confidant_storage_get( 'skins' );
			$update = 0;
			$free   = 0;
			$pay    = 0;
			foreach ( $skins as $skin => $data ) {
				if ( ! empty( $data['installed'] ) ) {
					if ( version_compare( $data['installed'], $data['version'], '<' ) ) {
						$update++;
					}
				} else if ( ! empty( $data['buy_url'] ) ) {
					$pay++;
				} else { 
					$free++;
				}
			}
			// Show notice
			$hide = get_transient( 'confidant_hide_notice_skins' );
			if ( $hide || $update + $free + $pay == 0 || ! confidant_exists_trx_addons() ) {
				return;
			}
			set_query_var( 'confidant_skins_notice_args', compact( 'update', 'free', 'pay' ) );
			get_template_part( apply_filters( 'confidant_filter_get_template_part', 'skins/skins-notice' ) );
		}
	}
}

// Hide admin notice
if ( ! function_exists( 'confidant_callback_hide_skins_notice' ) ) {
	add_action('wp_ajax_confidant_hide_skins_notice', 'confidant_callback_hide_skins_notice');
	function confidant_callback_hide_skins_notice() {
		confidant_verify_nonce();
		if ( current_user_can( 'update_themes' ) ) {
			set_transient( 'confidant_hide_notice_skins', true, 7 * 24 * 60 * 60 );	// 7 days
		}
		confidant_exit();
	}
}


// Add skins folder to the theme-specific file search
//------------------------------------------------------------

// Check if file exists in the skin folder and return its path or empty string if file is not found
if ( ! function_exists( 'confidant_skins_get_file_dir' ) ) {
	function confidant_skins_get_file_dir( $file, $skin = false, $return_url = false ) {
		if ( confidant_is_url( $file ) ) {
			$dir = $file;
		} else {
			$dir = '';
			if ( CONFIDANT_ALLOW_SKINS ) {
				$skin_dir = confidant_skins_get_current_skin_dir( $skin );
				if ( strpos( $file, $skin_dir ) === 0 ) {
					$skin_dir = '';
				}
				if ( CONFIDANT_CHILD_DIR != CONFIDANT_THEME_DIR && file_exists( CONFIDANT_CHILD_DIR . ( $skin_dir ) . ( $file ) ) ) {
					$dir = ( $return_url ? CONFIDANT_CHILD_URL : CONFIDANT_CHILD_DIR ) . ( $skin_dir ) . confidant_check_min_file( $file, CONFIDANT_CHILD_DIR . ( $skin_dir ) );
				} elseif ( file_exists( CONFIDANT_THEME_DIR . ( $skin_dir ) . ( $file ) ) ) {
					$dir = ( $return_url ? CONFIDANT_THEME_URL : CONFIDANT_THEME_DIR ) . ( $skin_dir ) . confidant_check_min_file( $file, CONFIDANT_THEME_DIR . ( $skin_dir ) );
				}
			}
		}
		return $dir;
	}
}

// Check if file exists in the skin folder and return its url or empty string if file is not found
if ( ! function_exists( 'confidant_skins_get_file_url' ) ) {
	function confidant_skins_get_file_url( $file, $skin = false ) {
		return confidant_skins_get_file_dir( $file, $skin, true );
	}
}


// Add skins folder to the theme-specific files search
if ( ! function_exists( 'confidant_skins_get_theme_file_dir' ) ) {
	add_filter( 'confidant_filter_get_theme_file_dir', 'confidant_skins_get_theme_file_dir', 10, 3 );
	function confidant_skins_get_theme_file_dir( $dir, $file, $return_url = false ) {
		return confidant_skins_get_file_dir( $file, confidant_skins_get_current_skin_name(), $return_url );
	}
}


// Check if folder exists in the current skin folder and return its path or empty string if the folder is not found
if ( ! function_exists( 'confidant_skins_get_folder_dir' ) ) {
	function confidant_skins_get_folder_dir( $folder, $skin = false, $return_url = false ) {
		$dir = '';
		if ( CONFIDANT_ALLOW_SKINS ) {
			$skin_dir = confidant_skins_get_current_skin_dir( $skin );
			if ( CONFIDANT_CHILD_DIR != CONFIDANT_THEME_DIR && is_dir( CONFIDANT_CHILD_DIR . ( $skin_dir ) . ( $folder ) ) ) {
				$dir = ( $return_url ? CONFIDANT_CHILD_URL : CONFIDANT_CHILD_DIR ) . ( $skin_dir ) . ( $folder );
			} elseif ( is_dir( CONFIDANT_THEME_DIR . ( $skin_dir ) . ( $folder ) ) ) {
				$dir = ( $return_url ? CONFIDANT_THEME_URL : CONFIDANT_THEME_DIR ) . ( $skin_dir ) . ( $folder );
			}
		}
		return $dir;
	}
}

// Check if folder exists in the skin folder and return its url or empty string if folder is not found
if ( ! function_exists( 'confidant_skins_get_folder_url' ) ) {
	function confidant_skins_get_folder_url( $folder, $skin = false ) {
		return confidant_skins_get_folder_dir( $folder, $skin, true );
	}
}

// Add skins folder to the theme-specific folders search
if ( ! function_exists( 'confidant_skins_get_theme_folder_dir' ) ) {
	add_filter( 'confidant_filter_get_theme_folder_dir', 'confidant_skins_get_theme_folder_dir', 10, 3 );
	function confidant_skins_get_theme_folder_dir( $dir, $folder, $return_url = false ) {
		return confidant_skins_get_folder_dir( $folder, confidant_skins_get_current_skin_name(), $return_url );
	}
}


// Add skins folder to the get_template_part
if ( ! function_exists( 'confidant_skins_get_template_part' ) ) {
	add_filter( 'confidant_filter_get_template_part', 'confidant_skins_get_template_part', 10, 2 );
	function confidant_skins_get_template_part( $slug, $part = '' ) {
		if ( ! empty( $part ) ) {
			$part = "-{$part}";
		}
		$slug_in_skins = str_replace( '//', '/', sprintf( 'skins/%1$s/%2$s', confidant_skins_get_current_skin_name(), $slug ) );
		if ( confidant_skins_get_file_dir( "{$slug}{$part}.php" ) != '' ) {
			$slug = $slug_in_skins;
		} else {
			if ( confidant_get_file_dir( "{$slug}{$part}.php" ) == '' && confidant_skins_get_file_dir( "{$slug}.php" ) != '' ) {
				$slug = $slug_in_skins;
			}
		}
		return $slug;
	}
}



// Add skin-specific styles to the Gutenberg preview
//------------------------------------------------------

if ( ! function_exists( 'confidant_skins_gutenberg_get_styles' ) ) {
	add_filter( 'confidant_filter_gutenberg_get_styles', 'confidant_skins_gutenberg_get_styles' );
	function confidant_skins_gutenberg_get_styles( $css ) {
		$css .= confidant_fgc( confidant_get_file_dir( confidant_skins_get_current_skin_dir() . 'css/style.css' ) );
		return $css;
	}
}



// Add tab with skins to the 'Theme Panel'
//------------------------------------------------------

// Return a list of categories from the skins list
if ( ! function_exists( 'confidant_skins_theme_panel_section_filters' ) ) {
	function confidant_skins_theme_panel_section_filters( $skins ) {
		$list = array();
		if ( is_array( $skins ) ) {
			foreach ( $skins as $skin ) {
				if ( ! empty( $skin['category'] ) ) {
					$parts = array_map( 'trim', explode( ',', $skin['category'] ) );
					foreach ( $parts as $cat ) {
						if ( ! in_array( $cat, $list ) ) {
							$list[] = $cat;
						}
					}
				}
			}
			if ( count( $list ) > 0 ) {
				sort( $list );
				array_unshift( $list, esc_html__( 'All', 'confidant' ) );
			}
		}
		return $list;
	}
}

// Add step 'Skins'
if ( ! function_exists( 'confidant_skins_theme_panel_steps' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_steps', 'confidant_skins_theme_panel_steps' );
	function confidant_skins_theme_panel_steps( $steps ) {
		if ( CONFIDANT_ALLOW_SKINS ) {
			$steps = confidant_array_merge( array( 'skins' => wp_kses_data( __( 'Select a skin for your website.', 'confidant' ) ) ), $steps );
		}
		return $steps;
	}
}

// Add tab link 'Skins'
if ( ! function_exists( 'confidant_skins_theme_panel_tabs' ) ) {
	add_filter( 'trx_addons_filter_theme_panel_tabs', 'confidant_skins_theme_panel_tabs' );
	function confidant_skins_theme_panel_tabs( $tabs ) {
		if ( CONFIDANT_ALLOW_SKINS ) {
			confidant_array_insert_after( $tabs, 'general', array( 'skins' => esc_html__( 'Skins', 'confidant' ) ) );
		}
		return $tabs;
	}
}

// Display 'Skins' section in the Theme Panel
if ( ! function_exists( 'confidant_skins_theme_panel_section' ) ) {
	add_action( 'trx_addons_action_theme_panel_section', 'confidant_skins_theme_panel_section', 10, 2);
	function confidant_skins_theme_panel_section( $tab_id, $theme_info ) {

		if ( 'skins' !== $tab_id ) return;

		$theme_activated = trx_addons_is_theme_activated();
		$skins = $theme_activated ? confidant_storage_get( 'skins' ) : false;

		?>
		<div id="trx_addons_theme_panel_section_<?php echo esc_attr($tab_id); ?>"
			class="trx_addons_tabs_section trx_addons_section_mode_thumbs">

			<?php
			do_action('trx_addons_action_theme_panel_section_start', $tab_id, $theme_info);

			if ( $theme_activated ) {
				?>
				<div class="trx_addons_theme_panel_section_content trx_addons_theme_panel_skins_selector">

					<?php do_action('trx_addons_action_theme_panel_before_section_title', $tab_id, $theme_info); ?>

					<h1 class="trx_addons_theme_panel_section_title">
						<?php esc_html_e( 'Choose a Skin', 'confidant' ); ?>
					</h1>

					<?php do_action('trx_addons_action_theme_panel_after_section_title', $tab_id, $theme_info); ?>

					<div class="trx_addons_theme_panel_section_description">
						<p><?php echo wp_kses_data( __( 'Select the desired style of your website. Some skins may require you to install additional plugins.', 'confidant' ) ); ?></p>
					</div>

					<div class="trx_addons_theme_panel_section_toolbar">
						<div class="trx_addons_theme_panel_section_filters">
							<form class="trx_addons_theme_panel_section_filters_form">
								<input class="trx_addons_theme_panel_section_filters_search" type="text" placeholder="<?php esc_attr_e( 'Search for skin', 'confidant' ); ?>" value="" />
							</form>
							<?php
							$cats = confidant_skins_theme_panel_section_filters( $skins );
							if ( is_array( $cats ) && count( $cats ) > 2 ) {
								?>
								<ul class="trx_addons_theme_panel_section_filters_list">
									<?php
									foreach( $cats as $k => $cat ) {
										?>
										<li class="trx_addons_theme_panel_section_filters_list_item<?php
												if ( $k == 0 ) { echo ' filter_active'; }
											?>"
											data-filter="<?php echo esc_attr( $cat ); ?>"
										>
											<a href="#"><?php echo esc_html( ucfirst( $cat ) ); ?></a>
										</li>
										<?php
									}
									?>
								</ul>
								<?php
							}
							?>
						</div>
						<?php
						// View mode buttons: thumbs | list
						if ( apply_filters( 'confidant_filter_skins_view_mode', true ) ) {
							?>
							<div class="trx_addons_theme_panel_section_view_mode">
								<span class="trx_addons_theme_panel_section_view_mode_thumbs" data-mode="thumbs" title="<?php esc_attr_e( 'Large thumbnails', 'confidant' ); ?>"></span>
								<span class="trx_addons_theme_panel_section_view_mode_list" data-mode="list" title="<?php esc_attr_e( 'List with details', 'confidant' ); ?>"></span>
							</div>
							<?php
						}
						?>
					</div>

					<?php do_action('trx_addons_action_theme_panel_before_list_items', $tab_id, $theme_info); ?>
					
					<div class="trx_addons_theme_panel_skins_list trx_addons_image_block_wrap">
						<?php
						if ( is_array( $skins ) ) {
							// Time to show new skins at the start of the list
							$time_new = strtotime( apply_filters( 'confidant_filter_time_to_show_new_skins', '-2 weeks' ) );
							// Sort skins by slug
							uksort( $skins, function( $a, $b ) use ( $skins, $time_new ) {
								$rez = apply_filters( 'confidant_filter_skins_sorted', true )
										? strcmp( $a, $b )
										: -1;
								// Move an active skin to the top of the list
								if ( $a == CONFIDANT_SKIN_NAME ) $rez = -1;
								else if ( $b == CONFIDANT_SKIN_NAME ) $rez = 1;
								// Move the skin 'Default' to the top of the list (after the active skin)
								else if ( $a == 'default' ) $rez = -1;
								else if ( $b == 'default' ) $rez = 1;
								// Move installed skins to the top of the list (after skin 'Default')
								else if ( ! empty( $skins[ $a ]['installed'] ) && ! empty( $skins[ $b ]['installed'] ) ) $rez = strcmp( $a, $b );
								else if ( ! empty( $skins[ $a ]['installed'] ) ) $rez = -1;
								else if ( ! empty( $skins[ $b ]['installed'] ) ) $rez = 1;
								// Move new skins to the top of the list (after installed skins)
								else if ( ! empty( $skins[ $a ]['uploaded'] ) && strtotime( $skins[ $a ]['uploaded'] ) > $time_new && ! empty( $skins[ $b ]['uploaded'] ) && strtotime( $skins[ $b ]['uploaded'] ) > $time_new ) $rez = strcmp( $a, $b );
								else if ( ! empty( $skins[ $a ]['uploaded'] ) && strtotime( $skins[ $a ]['uploaded'] ) > $time_new ) $rez = -1;
								else if ( ! empty( $skins[ $b ]['uploaded'] ) && strtotime( $skins[ $b ]['uploaded'] ) > $time_new ) $rez = 1;
								// Move updated skins to the top of the list (after new skins)
								else if ( ! empty( $skins[ $a ]['updated'] ) && strtotime( $skins[ $a ]['updated'] ) > $time_new && ! empty( $skins[ $b ]['updated'] ) && strtotime( $skins[ $b ]['updated'] ) > $time_new ) $rez = strcmp( $a, $b );
								else if ( ! empty( $skins[ $a ]['updated'] ) && strtotime( $skins[ $a ]['updated'] ) > $time_new ) $rez = -1;
								else if ( ! empty( $skins[ $b ]['updated'] ) && strtotime( $skins[ $b ]['updated'] ) > $time_new ) $rez = 1;
								return $rez;
							} );
							foreach ( $skins as $skin => $data ) {
								$skin_classes = array();
								if ( CONFIDANT_SKIN_NAME == $skin ) {
									$skin_classes[] = 'skin_active';
								}
								if ( ! empty( $data['installed'] ) ) {
									$skin_classes[] = 'skin_installed';
								} else if ( ! empty( $data['buy_url'] ) ) {
									$skin_classes[] = 'skin_buy';
								} else {
									$skin_classes[] = 'skin_free';
								}
								if ( ! empty( $data['updated'] ) && ( empty( $data['uploaded'] ) || $data['updated'] > $data['uploaded'] ) && strtotime( $data['updated'] ) > $time_new ) {
									$skin_classes[] = 'skin_updated';
								} else if ( empty( $data['installed'] ) && ! empty( $data['uploaded'] ) && strtotime( $data['uploaded'] ) > $time_new ) {
									$skin_classes[] = 'skin_new';
								}
								// 'trx_addons_image_block' is a inline-block element and spaces around it are not allowed
								?><div class="trx_addons_image_block <?php echo esc_attr( join( ' ', $skin_classes ) ); ?>"<?php
									if ( ! empty( $data['category'] ) ) {
										?> data-filter-value="<?php echo esc_attr( $data['category'] ); ?>"<?php
									}
									?> data-search-value="<?php
										if ( ! empty( $data['title'] ) ) {
											echo esc_attr( strtolower( $data['title'] ) );
										} else {
											echo esc_attr( $skin );
										}
									?>"<?php
								?>>
									<div class="trx_addons_image_block_inner" tabindex="0">
										<div class="trx_addons_image_block_image
										 	<?php 
											$theme_slug  = get_template();
											// Skin image
											$img = ! empty( $data['installed'] )
													? confidant_skins_get_file_url( 'skin.jpg', $skin )
													: trailingslashit( confidant_storage_get( 'theme_upgrade_url' ) ) . 'skins/' . urlencode( apply_filters( 'confidant_filter_original_theme_slug', $theme_slug ) ) . '/' . urlencode( $skin ) . '/skin.jpg';
											if ( ! empty( $img ) ) {
												echo confidant_add_inline_css_class( 'background-image: url(' . esc_url( $img ) . ');' );
											}				 	
										 	?>">
										 	<?php
											// Link to demo site
											if ( ! empty( $data['demo_url'] ) ) {
												?>
												<a href="<?php echo esc_url( $data['demo_url'] ); ?>"
													class="trx_addons_image_block_link trx_addons_image_block_link_view_demo"
													target="_blank"
													tabindex="-1"
													title="<?php esc_attr_e( 'Live Preview', 'confidant' ); ?>"
												>
													<span class="trx_addons_image_block_link_caption">
														<?php
														esc_html_e( 'Live Preview', 'confidant' );
														?>
													</span>
												</a>
												<?php
											}
											// Labels
											if ( ! empty( $data['updated'] ) && ( empty( $data['uploaded'] ) || $data['updated'] > $data['uploaded'] ) && strtotime( $data['updated'] ) > $time_new ) {
												?><span class="skin_label"><?php esc_html_e( 'Updated', 'confidant' ); ?></span><?php
											} else if ( ! empty( $data['installed'] ) && strtotime( $data['installed'] ) > $time_new ) {
												?><span class="skin_label"><?php esc_html_e( 'Downloaded', 'confidant' ); ?></span><?php
											} else if ( ! empty( $data['uploaded'] ) && strtotime( $data['uploaded'] ) > $time_new ) {
												?><span class="skin_label"><?php esc_html_e( 'New', 'confidant' ); ?></span><?php
											}
											?>
									 	</div>
									 	<div class="trx_addons_image_block_footer">
											<?php
											// Links to choose skin, update, download, purchase
											if ( ! empty( $data['installed'] ) ) {
												// Active skin
												if ( CONFIDANT_SKIN_NAME == $skin ) {
													?>
													<span class="trx_addons_image_block_link trx_addons_image_block_link_active">
														<?php
														esc_html_e( 'Active', 'confidant' );
														?>
													</span>
													<?php
												} else {
													// Button 'Delete'
													?>
													<a href="#" tabindex="0"
														class="trx_addons_image_block_link trx_addons_image_block_link_delete trx_addons_image_block_link_delete_skin trx_addons_button trx_addons_button_small trx_addons_button_fail"
														data-skin="<?php echo esc_attr( $skin ); ?>"
													>
														<span data-tooltip-text="<?php
															esc_html_e( 'Delete', 'confidant' );
														?>"></span>
														<span class="trx_addons_image_block_link_caption"><?php
															esc_html_e( 'Delete', 'confidant' );
														?></span>
													</a>
													<?php
													// Button 'Activate'
													?>
													<a href="#" tabindex="0"
														class="trx_addons_image_block_link trx_addons_image_block_link_activate trx_addons_image_block_link_choose_skin trx_addons_button trx_addons_button_small trx_addons_button_accent trx_addons_image_block_icon_hidden"
														data-skin="<?php echo esc_attr( $skin ); ?>">
															<?php
															esc_html_e( 'Activate', 'confidant' );
															?>
													</a>
													<?php
												}
												// Button 'Update'
												if ( version_compare( $data['installed'], $data['version'], '<' ) ) {
													?>
													<a href="#"
														class="trx_addons_image_block_link trx_addons_image_block_link_update trx_addons_image_block_link_update_skin trx_addons_button trx_addons_button_small trx_addons_button_warning trx_addons_image_block_icon_hidden"
														data-skin="<?php echo esc_attr( $skin ); ?>">
															<?php
															//esc_html_e( 'Update', 'confidant' );
															// Translators: Add new version of the skin to the string
															echo esc_html( sprintf( __( 'Update to v.%s', 'confidant' ), $data['version'] ) );
															?>
													</a>
													<?php
												}

											} else if ( ! empty( $data['buy_url'] ) ) {
												// Button 'Purchase'
												?>
												<a href="#" tabindex="0"
													class="trx_addons_image_block_link trx_addons_image_block_link_download trx_addons_image_block_link_buy_skin trx_addons_button trx_addons_button_small trx_addons_button_success trx_addons_image_block_icon_hidden"
													data-skin="<?php echo esc_attr( $skin ); ?>"
													data-buy="<?php echo esc_url( $data['buy_url'] ); ?>">
														<?php
														esc_html_e( 'Purchase', 'confidant' );
														?>
												</a>
												<?php

											} else {
												// Button 'Download'
												?>
												<a href="#" tabindex="0"
													class="trx_addons_image_block_link trx_addons_image_block_link_download trx_addons_image_block_link_download_skin trx_addons_button trx_addons_button_small trx_addons_image_block_icon_hidden"
													data-skin="<?php echo esc_attr( $skin ); ?>">
														<?php
														esc_html_e( 'Download', 'confidant' );
														?>
												</a>
												<?php
											}
											// Skin title
											if ( ! empty( $data['title'] ) ) {
												?>
												<h5 class="trx_addons_image_block_title">
													<?php
													echo esc_html( $data['title'] );
													?>
												</h5>
												<?php
											}
											// Skin version
											if ( ! empty( $data['installed'] ) ) {
												?>
												<div class="trx_addons_image_block_description">
													<?php
													echo esc_html( sprintf( __( 'Version %s', 'confidant' ), $data['installed'] ) );
													?>
												</div>
												<?php
											}
											?>
										</div>
									</div>
								</div><?php // No spaces allowed after this <div>, because it is an inline-block element
							}
						}
						?>
					</div>

					<?php do_action('trx_addons_action_theme_panel_after_list_items', $tab_id, $theme_info); ?>

				</div>
				<?php
				do_action('trx_addons_action_theme_panel_after_section_data', $tab_id, $theme_info);
			} else {
				?>
				<div class="<?php
					if ( confidant_exists_trx_addons() ) {
						echo 'trx_addons_info_box trx_addons_info_box_warning';
					} else {
						echo 'error';
					}
				?>"><p>
					<?php esc_html_e( 'Activate your theme in order to be able to change skins.', 'confidant' ); ?>
				</p></div>
				<?php
			}

			do_action('trx_addons_action_theme_panel_section_end', $tab_id, $theme_info);
			?>
		</div>
		<?php
	}
}


// Load page-specific scripts and styles
if ( ! function_exists( 'confidant_skins_about_enqueue_scripts' ) ) {
	add_action( 'admin_enqueue_scripts', 'confidant_skins_about_enqueue_scripts' );
	function confidant_skins_about_enqueue_scripts() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( ! empty( $screen->id ) && ( false !== strpos($screen->id, '_page_trx_addons_theme_panel') || in_array( $screen->id, array( 'update-core', 'update-core-network' ) ) ) ) {
			wp_enqueue_style( 'confidant-skins-admin', confidant_get_file_url( 'skins/skins-admin.css' ), array(), null );
			wp_enqueue_script( 'confidant-skins-admin', confidant_get_file_url( 'skins/skins-admin.js' ), array( 'jquery' ), null, true );
		}
	}
}

// Add page-specific vars to the localize array
if ( ! function_exists( 'confidant_skins_localize_script' ) ) {
	add_filter( 'confidant_filter_localize_script_admin', 'confidant_skins_localize_script' );
	function confidant_skins_localize_script( $arr ) {

		// Switch an active skin
		$arr['msg_switch_skin_caption']           = esc_html__( "Attention!", 'confidant' );
		$arr['msg_switch_skin']                   = apply_filters( 'confidant_filter_msg_switch_skin',
			'<p>'
			. esc_html__( "Some skins require installation of additional plugins.", 'confidant' )
			. '</p><p>'
			. esc_html__( "After selecting a new skin, your theme settings will be changed.", 'confidant' )
			. '</p>'
		);
		$arr['msg_switch_skin_success']           = esc_html__( 'A new skin is selected. The page will be reloaded.', 'confidant' );
		$arr['msg_switch_skin_success_caption']   = esc_html__( 'Skin is changed!', 'confidant' );

		// Delete a skin
		$arr['msg_delete_skin_caption']           = esc_html__( "Delete skin", 'confidant' );
		$arr['msg_delete_skin']                   = apply_filters( 'confidant_filter_msg_delete_skin',
			'<p>'
			. esc_html__( "Attention! This skin will be deleted from the 'skins' folder inside your theme folder.", 'confidant' )
			. '</p>'
		);
		$arr['msg_delete_skin_success']           = esc_html__( 'Specified skin is deleted. The page will be reloaded.', 'confidant' );
		$arr['msg_delete_skin_success_caption']   = esc_html__( 'Skin is deleted!', 'confidant' );
		$arr['msg_delete_skin_error_caption']     = esc_html__( 'Skin delete error!', 'confidant' );

		// Download a new skin
		$arr['msg_download_skin_caption']         = esc_html__( "Download skin", 'confidant' );
		$arr['msg_download_skin']                 = apply_filters( 'confidant_filter_msg_download_skin',
			'<p>'
			. esc_html__( "The new skin will be installed in the 'skins' folder inside your theme folder.", 'confidant' )
			. '</p><p>'
			. esc_html__( "Attention! Do not forget to activate the new skin after installation.", 'confidant' )
			. '</p>'
		);
		$arr['msg_download_skin_success']         = esc_html__( 'A new skin is installed. The page will be reloaded.', 'confidant' );
		$arr['msg_download_skin_success_caption'] = esc_html__( 'Skin is installed!', 'confidant' );
		$arr['msg_download_skin_error_caption']   = esc_html__( 'Skin download error!', 'confidant' );

		// Buy a new skin
		$arr['msg_buy_skin_caption']              = esc_html__( "Download purchased skin", 'confidant' );
		$arr['msg_buy_skin']                      = apply_filters( 'confidant_filter_msg_buy_skin',
			'<p>'
			. esc_html__( "1. Follow the link below and purchase the selected skin. After payment you will receive a purchase code.", 'confidant' )
			. '</p><p>'
			. '<a href="#" target="_blank">' . esc_html__( "Purchase the selected skin.", 'confidant' ) . '</a>'
			. '</p><p>'
			. esc_html__( "2. Enter the purchase code of the selected skin in the field below and press the button 'Apply'.", 'confidant' )
			. '</p><p>'
			. esc_html__( "3. The new skin will be installed to the folder 'skins' inside your theme folder.", 'confidant' )
			. '</p><p>'
			. esc_html__( "Attention! Do not forget to activate the new skin after installation.", 'confidant' )
			. '</p>'
		);
		$arr['msg_buy_skin_placeholder']          = esc_html__( 'Enter the purchase code of the skin.', 'confidant' );
		$arr['msg_buy_skin_success']              = esc_html__( 'A new skin is installed. The page will be reloaded.', 'confidant' );
		$arr['msg_buy_skin_success_caption']      = esc_html__( 'Skin is installed!', 'confidant' );
		$arr['msg_buy_skin_error_caption']        = esc_html__( 'Skin download error!', 'confidant' );

		// Update an installed skin
		$arr['msg_update_skin_caption']         = esc_html__( "Update skin", 'confidant' );
		$arr['msg_update_skin']                 = apply_filters( 'confidant_filter_msg_update_skin',
			'<p>'
			. esc_html__( "Attention! The new version of the skin will be installed in the same folder instead the current version!", 'confidant' )
			. '</p><p>'
			. esc_html__( "If you made any changes in the files from the folder of the selected skin - they will be lost.", 'confidant' )
			. '</p>'
		);
		$arr['msg_update_skin_success']         = esc_html__( 'The skin is updated. The page will be reloaded.', 'confidant' );
		$arr['msg_update_skin_success_caption'] = esc_html__( 'Skin is updated!', 'confidant' );
		$arr['msg_update_skin_error_caption']   = esc_html__( 'Skin update error!', 'confidant' );
		$arr['msg_update_skins_result']         = esc_html__( 'Selected skins are updated.', 'confidant' );
		$arr['msg_update_skins_error']          = esc_html__( 'Not all selected skins have been updated.', 'confidant' );

		return $arr;
	}
}


// AJAX handler for the 'confidant_switch_skin' action
if ( ! function_exists( 'confidant_skins_ajax_switch_skin' ) ) {
	add_action( 'wp_ajax_confidant_switch_skin', 'confidant_skins_ajax_switch_skin' );
	function confidant_skins_ajax_switch_skin() {

		confidant_verify_nonce();

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			confidant_forbidden( esc_html__( 'Sorry, you are not allowed to switch skins.', 'confidant' ) );
		}

		$response = array( 'error' => '' );

		$skin  = confidant_esc( confidant_get_value_gp( 'skin' ) );
		$skins = confidant_storage_get( 'skins' );

		if ( empty( $skin ) || ! isset( $skins[ $skin ] ) || empty( $skins[ $skin ]['installed'] ) ) {
			// Translators: Add the skin's name to the message
			$response['error'] = sprintf( esc_html__( 'Can not switch to the skin %s', 'confidant' ), $skin );

		} elseif ( CONFIDANT_SKIN_NAME == $skin ) {
			// Translators: Add the skin's name to the message
			$response['error'] = sprintf( esc_html__( 'Skin %s is already active', 'confidant' ), $skin );

		} else {
			// Get current theme slug
			$theme_slug = get_stylesheet();
			// Get previously saved options for new skin
			$skin_mods = get_option( sprintf( 'theme_mods_%1$s_skin_%2$s', $theme_slug, $skin ), false );
			if ( ! $skin_mods ) {
				// First activation of the skin - get options from the file
				if ( file_exists( CONFIDANT_THEME_DIR . 'skins/skins-options.php' ) ) {
					require_once CONFIDANT_THEME_DIR . 'skins/skins-options.php';
					if ( isset( $skins_options[ $skin ]['options'] ) ) {
						$skin_mods = apply_filters(
										'confidant_filter_skin_options_restore_from_file',
										confidant_unserialize( $skins_options[ $skin ]['options'] )
										);
					}
				}
			}
			if ( empty( $skin_mods ) ) {
				$response['success'] = esc_html__( 'A new skin is selected, but options of the new skin are not found!', 'confidant' );
			}
			// Save current options
			update_option( sprintf( 'theme_mods_%1$s_skin_%2$s', $theme_slug, CONFIDANT_SKIN_NAME ), apply_filters( 'confidant_filter_skin_options_store', get_theme_mods() ) );
			// Replace theme mods with options from new skin
			if ( ! empty( $skin_mods ) ) {
				confidant_options_update( apply_filters( 'confidant_filter_skin_options_restore', $skin_mods ) );
			}
			// Replace current skin
			update_option( sprintf( 'theme_skin_%s', $theme_slug ), $skin );
			// Clear current skin from visitor's storage
			if ( CONFIDANT_REMEMBER_SKIN ) {
				confidant_set_cookie( 'skin_current', '' );
			}
			// Set a flag to recreate custom layouts
			update_option('trx_addons_cpt_layouts_created', 0);
			// Set a flag to regenerate styles and scripts on first run
			if ( apply_filters( 'confidant_filter_regenerate_merged_files_after_switch_skin', true ) ) {
				confidant_set_action_save_options();
			}
			// Clear a list with posts for the importer
			delete_transient( 'trx_addons_installer_posts' );
			// Trigger action
			do_action( 'confidant_action_skin_switched', $skin, CONFIDANT_SKIN_NAME );
		}

		confidant_ajax_response( $response );
	}
}

// Remove saved shapes list
if ( ! function_exists( 'confidant_skins_clear_saved_shapes_list' ) ) {
	add_action( 'confidant_action_skin_switched', 'confidant_skins_clear_saved_shapes_list', 10, 2 );
	function confidant_skins_clear_saved_shapes_list( $skin = '', $skin_name = '' ) {
		delete_transient( 'trx_addons_shapes' );
	}
}

// Remove all entries with media from options restored from file
if ( ! function_exists( 'confidant_skins_options_restore_from_file' ) ) {
	add_filter( 'confidant_filter_skin_options_restore_from_file', 'confidant_skins_options_restore_from_file' );
	function confidant_skins_options_restore_from_file( $mods ) {
		$options = confidant_storage_get( 'options' );
		if ( is_array( $options ) ) {
			foreach( $options as $k => $v ) {
				if ( ! empty( $v['type'] ) && in_array( $v['type'], array( 'image', 'media', 'video', 'audio' ) ) && isset( $mods[ $k ] ) ) {
					unset( $mods[ $k ] );
				}
			}
		}
		return $mods;
	}
}


// AJAX handler for the 'confidant_delete_skin' action
if ( ! function_exists( 'confidant_skins_ajax_delete_skin' ) ) {
	add_action( 'wp_ajax_confidant_delete_skin', 'confidant_skins_ajax_delete_skin' );
	function confidant_skins_ajax_delete_skin() {

		confidant_verify_nonce();

		$response = array( 'error' => '' );

		if ( ! current_user_can( 'update_themes' ) ) {
			$response['error'] = esc_html__( 'Sorry, you are not allowed to delete skins.', 'confidant' );

		} else {
			$skin            = confidant_get_value_gp( 'skin' );
			$skins_file      = confidant_get_file_dir( 'skins/skins.json' );
			$skins_installed = json_decode( confidant_fgc( $skins_file ), true );

			$dest = CONFIDANT_THEME_DIR . 'skins'; // Used instead confidant_get_folder_dir( 'skins' ) to prevent install skin to the child-theme

			if ( empty( $skin ) || ! isset( $skins_installed[ $skin ] ) ) {
				// Translators: Add the skin's name to the message
				$response['error'] = sprintf( esc_html__( 'Can not delete the skin "%s"', 'confidant' ), $skin );

			} else if ( empty( $skins_installed[ $skin ] ) ) {
				// Translators: Add the skin's name to the message
				$response['error'] = sprintf( esc_html__( 'Skin "%s" is not installed', 'confidant' ), $skin );

			} else if ( confidant_skins_get_current_skin_name() == $skin ) {
				// Translators: Add the skin's name to the message
				$response['error'] = sprintf( esc_html__( 'Can not delete the active skin "%s"', 'confidant' ), $skin );

			} else if ( ! is_dir( "{$dest}/{$skin}" ) ) {
				// Translators: Add the skin's name to the message
				$response['error'] = sprintf( esc_html__( 'A skin folder "%s" is not exists', 'confidant' ), $skin );

			} else {
				// Delete a skin folder
				confidant_unlink( "{$dest}/{$skin}" );
				// Remove a skin from json
				unset( $skins_installed[ $skin ] );
				confidant_fpc( $skins_file, json_encode( $skins_installed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT ) );
				// Remove a stored list to reload it while next site visit occurs
				delete_transient( 'confidant_list_skins' );

			}
		}

		confidant_ajax_response( $response );
	}
}


// AJAX handler for the 'confidant_download_skin' action
if ( ! function_exists( 'confidant_skins_ajax_download_skin' ) ) {
	add_action( 'wp_ajax_confidant_download_skin', 'confidant_skins_ajax_download_skin' );
	add_action( 'wp_ajax_confidant_buy_skin', 'confidant_skins_ajax_download_skin' );
	add_action( 'wp_ajax_confidant_update_skin', 'confidant_skins_ajax_download_skin' );
	function confidant_skins_ajax_download_skin() {

		confidant_verify_nonce();

		$response = array( 'error' => '' );

		if ( ! current_user_can( 'update_themes' ) ) {
			$response['error'] = esc_html__( 'Sorry, you are not allowed to download/update skins.', 'confidant' );

		} else {
			$action = current_action() == 'wp_ajax_confidant_download_skin'
							? 'download'
							: ( current_action() == 'wp_ajax_confidant_buy_skin'
								? 'buy'
								: 'update' );

			$key    = confidant_get_theme_activation_code();

			$skin   = confidant_get_value_gp( 'skin' );
			$code   = 'update' == $action
							? get_option( sprintf( 'purchase_code_%s_%s', get_template(), $skin ), '' )
							: confidant_get_value_gp( 'code' );

			$skins  = confidant_storage_get( 'skins' );

			if ( empty( $key ) ) {
				$response['error'] = esc_html__( 'Theme is not activated!', 'confidant' );

			} else if ( empty( $skin ) || ! isset( $skins[ $skin ] ) ) {
				// Translators: Add the skin's name to the message
				$response['error'] = sprintf( esc_html__( 'Can not download the skin %s', 'confidant' ), $skin );

			} else if ( ! empty( $skins[ $skin ]['installed'] ) && 'update' != $action ) {
				// Translators: Add the skin's name to the message
				$response['error'] = sprintf( esc_html__( 'Skin %s is already installed', 'confidant' ), $skin );

			} else {
				$result = confidant_get_upgrade_data( array(
					'action'   => 'download_skin',
					'key'      => $key,
					'skin'     => $skin,
					'skin_key' => $code,
				) );
				if ( substr( $result['data'], 0, 2 ) == 'PK' ) {
					confidant_allow_upload_archives();
					$tmp_name = 'tmp-' . rand() . '.zip';
					$tmp      = wp_upload_bits( $tmp_name, null, $result['data'] );
					confidant_disallow_upload_archives();
					if ( $tmp['error'] ) {
						$response['error'] = esc_html__( 'Problem with save upgrade file to the folder with uploads', 'confidant' );
					} else {
						$response['error'] .= confidant_skins_install_skin( $skin, $tmp['file'], $result['info'], $action );
						// Store purchase code to update skins in the future
						if ( ! empty( $code ) && empty( $response['error'] ) ) {
							update_option( sprintf( 'purchase_code_%s_%s', get_template(), $skin ), $code );
						}
					}
				} else {
					$response['error'] = ! empty( $result['error'] )
											? $result['error']
											: esc_html__( 'Package with skin is corrupt', 'confidant' );
				}
			}
		}

		confidant_ajax_response( $response );
	}
}


// Unpack and install skin
if ( ! function_exists( 'confidant_skins_install_skin' ) ) {
	function confidant_skins_install_skin( $skin, $file, $info, $action ) {
		if ( file_exists( $file ) ) {
			ob_start();
			// Unpack skin
			$dest = CONFIDANT_THEME_DIR . 'skins'; // Used instead confidant_get_folder_dir( 'skins' ) to prevent install skin to the child-theme
			if ( ! empty( $dest ) ) {
				confidant_unzip_file( $file, $dest );
			}
			// Remove uploaded archive
			unlink( $file );
			$log = ob_get_contents();
			ob_end_clean();
			// Save skin options (if an action is not 'update')
			if ( 'update' != $action && ! empty( $info['skin_options'] ) ) {
				if ( is_string( $info['skin_options'] ) && is_serialized( $info['skin_options'] ) ) {
					$info['skin_options'] = confidant_unserialize( stripslashes( $info['skin_options'] ) );
				}
				if ( is_array( $info['skin_options'] ) ) {
					$theme_slug  = get_stylesheet();
					update_option( sprintf( 'theme_mods_%1$s_skin_%2$s', $theme_slug, $skin ), $info['skin_options'] );
				}
			}
			// Update skins list
			$skins_file      = confidant_get_file_dir( 'skins/skins.json' );
			$skins_installed = json_decode( confidant_fgc( $skins_file ), true );
			$skins_available = confidant_storage_get( 'skins' );
			if ( isset( $skins_available[ $skin ][ 'installed' ] ) ) {
				unset( $skins_available[ $skin ][ 'installed' ] );
			}
			$skins_installed[ $skin ] = $skins_available[ $skin ];
			confidant_fpc( $skins_file, json_encode( $skins_installed, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_FORCE_OBJECT ) );
			// Remove a stored list to reload it while next site visit occurs
			delete_transient( 'confidant_list_skins' );
			// Set a flag to regenerate styles and scripts on first run if a current skin is updated
			if ( 'update' == $action
				&& confidant_skins_get_current_skin_name() == $skin
				&& apply_filters( 'confidant_filter_regenerate_merged_files_after_switch_skin', true )
			) {
				confidant_set_action_save_options();
			}
			// Trigger action
			do_action( 'confidant_action_skin_updated', $skin );
		} else {
			return esc_html__( 'Uploaded file with skin package is not available', 'confidant' );
		}
	}
}



//-------------------------------------------------------
//-- Update skins via WordPress update screen
//-------------------------------------------------------

// Add new skins versions to the WordPress update screen
if ( ! function_exists( 'confidant_skins_update_list' ) ) {
	add_action('core_upgrade_preamble', 'confidant_skins_update_list');
	function confidant_skins_update_list() {
		if ( current_user_can( 'update_themes' ) && confidant_is_theme_activated() ) {
			$skins  = confidant_storage_get( 'skins' );
			$update = 0;
			foreach ( $skins as $skin => $data ) {
				if ( ! empty( $data['installed'] ) && version_compare( $data['installed'], $data['version'], '<' ) ) {
					$update++;
				}
			}
			?>
			<h2>
				<?php esc_html_e( 'Active theme components: Skins', 'confidant' ); ?>
			</h2>
			<?php
			if ( $update == 0 ) {
				?>
				<p><?php esc_html_e( 'Skins of the current theme are all up to date.', 'confidant' ); ?></p>
				<?php
				return;
			}
			?>
			<p>
				<?php esc_html_e( 'The following skins have new versions available. Check the ones you want to update and then click &#8220;Update Skins&#8221;.', 'confidant' ); ?>
			</p>
			<p>
				<?php echo wp_kses_data( __( '<strong>Please Note:</strong> Any customizations you have made to skin files will be lost.', 'confidant' ) ); ?>
			</p>
			<div class="upgrade confidant_upgrade_skins">
				<p><input id="upgrade-skins" class="button confidant_upgrade_skins_button" type="button" value="<?php esc_attr_e( 'Update Skins', 'confidant' ); ?>" /></p>
				<table class="widefat updates-table" id="update-skins-table">
					<thead>
					<tr>
						<td class="manage-column check-column"><input type="checkbox" id="skins-select-all" /></td>
						<td class="manage-column"><label for="skins-select-all"><?php esc_html_e( 'Select All', 'confidant' ); ?></label></td>
					</tr>
					</thead>
					<tbody class="plugins">
						<?php
						foreach ( $skins as $skin => $data ) {
							if ( empty( $data['installed'] ) || ! version_compare( $data['installed'], $data['version'], '<' ) ) {
								continue;
							}
							$checkbox_id = 'checkbox_' . md5( $skin );
							?>
							<tr>
								<td class="check-column">
									<input type="checkbox" name="checked[]" id="<?php echo esc_attr( $checkbox_id ); ?>" value="<?php echo esc_attr( $skin ); ?>" />
									<label for="<?php echo esc_attr( $checkbox_id ); ?>" class="screen-reader-text">
										<?php
										// Translators: %s: Skin name
										printf( esc_html__( 'Select %s', 'confidant' ), $data['title'] );
										?>
									</label>
								</td>
								<td class="plugin-title"><p>
									<img src="<?php echo esc_url( confidant_skins_get_file_url( 'skin.jpg', $skin ) ); ?>" width="85" class="updates-table-screenshot" alt="<?php echo esc_attr( $data['title'] ); ?>" />
									<strong><?php echo esc_html( $data['title'] ); ?></strong>
									<?php
									// Translators: 1: skin version, 2: new version
									printf(
										esc_html__( 'You have version %1$s installed. Update to %2$s.', 'confidant' ),
										$data['installed'],
										$data['version']
									);
									?>
								</p></td>
							</tr>
							<?php
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td class="manage-column check-column"><input type="checkbox" id="skins-select-all-2" /></td>
							<td class="manage-column"><label for="skins-select-all-2"><?php esc_html_e( 'Select All', 'confidant' ); ?></label></td>
						</tr>
					</tfoot>
				</table>
				<p><input id="upgrade-skins-2" class="button confidant_upgrade_skins_button" type="button" value="<?php esc_attr_e( 'Update Skins', 'confidant' ); ?>" /></p>
			</div>
			<?php
		}
	}
}


// Add new skins count to the WordPress updates count
if ( ! function_exists( 'confidant_skins_update_counts' ) ) {
	add_filter('wp_get_update_data', 'confidant_skins_update_counts', 10, 2);
	function confidant_skins_update_counts($update_data, $titles) {
		if ( current_user_can( 'update_themes' ) ) {
			$skins  = confidant_storage_get( 'skins' );
			$update = 0;
			foreach ( $skins as $skin => $data ) {
				if ( ! empty( $data['installed'] ) && version_compare( $data['installed'], $data['version'], '<' ) ) {
					$update++;
				}
			}
			if ( $update > 0 ) {
				$update_data[ 'counts' ][ 'skins' ]  = $update;
				$update_data[ 'counts' ][ 'total' ] += $update;
				// Translators: %d: number of updates available to installed skins
				$titles['skins']                     = sprintf( _n( '%d Skin Update', '%d Skin Updates', $update, 'confidant' ), $update );
				$update_data[ 'title' ]              = esc_attr( implode( ', ', $titles ) );
			}
		}
		return $update_data;
	}
}


// One-click import support
//------------------------------------------------------------------------

// Export custom layouts
if ( ! function_exists( 'confidant_skins_importer_export' ) ) {
	if ( false && is_admin() ) {
		add_action( 'trx_addons_action_importer_export', 'confidant_skins_importer_export', 10, 1 );
	}
	function confidant_skins_importer_export( $importer ) {
		$skins  = confidant_storage_get( 'skins' );
		$output = '';
		if ( is_array( $skins ) && count( $skins ) > 0 ) {
			$output     = '<?php'
						. "\n//" . esc_html__( 'Skins', 'confidant' )
						. "\n\$skins_options = array(";
			$counter    = 0;
			$theme_mods = get_theme_mods();
			$theme_slug = get_stylesheet();
			foreach ( $skins as $skin => $skin_data ) {
				$options = $skin != confidant_skins_get_current_skin_name()
								? get_option( sprintf( 'theme_mods_%1$s_skin_%2$s', $theme_slug, $skin ), false )
								: false;
				if ( false === $options ) {
					$options = $theme_mods;
				}
				$output .= ( $counter++ ? ',' : '' )
						. "\n\t'{$skin}' => array("
						. "\n\t\t'options' => " . "'" . str_replace( array( "\r", "\n" ), array( '\r', '\n' ), serialize( apply_filters( 'confidant_filter_export_skin_options', $options, $skin ) ) ) . "'"
						. "\n\t)";
			}
			$output .= "\n);"
					. "\n?>";
		}
		confidant_fpc( $importer->export_file_dir( 'skins.txt' ), $output );
	}
}

// Display exported data in the fields
if ( ! function_exists( 'confidant_skins_importer_export_fields' ) ) {
	if ( is_admin() ) {
		add_action( 'trx_addons_action_importer_export_fields', 'confidant_skins_importer_export_fields', 12, 1 );
	}
	function confidant_skins_importer_export_fields( $importer ) {
		$importer->show_exporter_fields(
			array(
				'slug'     => 'skins',
				'title'    => esc_html__( 'Skins', 'confidant' ),
				'download' => 'skins-options.php',
			)
		);
	}
}

// Set a name for the archive with demo data
if ( ! function_exists( 'confidant_skins_importer_set_archive_name' ) ) {
	add_action( 'after_setup_theme', 'confidant_skins_importer_set_archive_name', 1 );
	function confidant_skins_importer_set_archive_name() {
		$GLOBALS['CONFIDANT_STORAGE']['theme_demofiles_archive_name'] = sprintf( 'demo/%s.zip', confidant_skins_get_active_skin_name() );
	}
}


// Load file with current skin
//----------------------------------------------------------
$confidant_skin_file = confidant_skins_get_file_dir( 'skin.php' );
if ( '' != $confidant_skin_file ) {
	require_once $confidant_skin_file;
}
