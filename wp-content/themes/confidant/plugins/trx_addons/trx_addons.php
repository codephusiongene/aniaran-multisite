<?php
/* ThemeREX Addons support functions
------------------------------------------------------------------------------- */

// Add theme-specific functions
require_once confidant_get_file_dir( 'plugins/trx_addons/trx_addons-setup.php' );

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if ( ! function_exists( 'confidant_trx_addons_theme_setup1' ) ) {
	add_action( 'after_setup_theme', 'confidant_trx_addons_theme_setup1', 1 );
	function confidant_trx_addons_theme_setup1() {
		if ( confidant_exists_trx_addons() ) {
			add_filter( 'confidant_filter_list_posts_types', 'confidant_trx_addons_list_post_types' );
			add_filter( 'confidant_filter_list_header_footer_types', 'confidant_trx_addons_list_header_footer_types' );
			add_filter( 'confidant_filter_list_header_styles', 'confidant_trx_addons_list_header_styles' );
			add_filter( 'confidant_filter_list_footer_styles', 'confidant_trx_addons_list_footer_styles' );
			add_filter( 'confidant_filter_list_sidebar_styles', 'confidant_trx_addons_list_sidebar_styles' );
			add_filter( 'confidant_filter_list_blog_styles', 'confidant_trx_addons_list_blog_styles', 10, 3 );
			add_action( 'admin_init', 'confidant_trx_addons_add_link_edit_layout' );          // Old way: 'confidant_action_load_options'
			add_action( 'customize_register', 'confidant_trx_addons_add_link_edit_layout' );  // Old way: 'confidant_action_load_options'
			add_action( 'confidant_action_save_options', 'confidant_trx_addons_action_save_options', 1 );
			add_action( 'confidant_action_before_body', 'confidant_trx_addons_action_before_body', 1);
			add_action( 'confidant_action_page_content_wrap', 'confidant_trx_addons_action_page_content_wrap', 10, 1 );
			add_action( 'confidant_action_before_header', 'confidant_trx_addons_action_before_header' );
			add_action( 'confidant_action_after_header', 'confidant_trx_addons_action_after_header' );
			add_action( 'confidant_action_before_footer', 'confidant_trx_addons_action_before_footer' );
			add_action( 'confidant_action_after_footer', 'confidant_trx_addons_action_after_footer' );
			add_action( 'confidant_action_before_sidebar_wrap', 'confidant_trx_addons_action_before_sidebar_wrap', 10, 1 );
			add_action( 'confidant_action_after_sidebar_wrap', 'confidant_trx_addons_action_after_sidebar_wrap', 10, 1 );
			add_action( 'confidant_action_before_sidebar', 'confidant_trx_addons_action_before_sidebar', 10, 1 );
			add_action( 'confidant_action_after_sidebar', 'confidant_trx_addons_action_after_sidebar', 10, 1 );
			add_action( 'confidant_action_between_posts', 'confidant_trx_addons_action_between_posts' );
			add_action( 'confidant_action_before_post_header', 'confidant_trx_addons_action_before_post_header' );
			add_action( 'confidant_action_after_post_header', 'confidant_trx_addons_action_after_post_header' );
			add_action( 'confidant_action_before_post_content', 'confidant_trx_addons_action_before_post_content' );
			add_action( 'confidant_action_after_post_content', 'confidant_trx_addons_action_after_post_content' );
			add_filter( 'trx_addons_filter_default_layouts', 'confidant_trx_addons_default_layouts' );
			add_filter( 'trx_addons_filter_load_options', 'confidant_trx_addons_default_components' );
			add_filter( 'trx_addons_cpt_list_options', 'confidant_trx_addons_cpt_list_options', 10, 2 );
			add_filter( 'trx_addons_filter_sass_import', 'confidant_trx_addons_sass_import', 10, 2 );
			add_filter( 'trx_addons_filter_override_options', 'confidant_trx_addons_override_options' );
			add_filter( 'trx_addons_filter_post_meta', 'confidant_trx_addons_post_meta', 10, 2 );
			add_filter( 'trx_addons_filter_post_meta_args',	'confidant_trx_addons_post_meta_args', 10, 3);
			add_filter( 'confidant_filter_post_meta_args', 'confidant_trx_addons_post_meta_args', 10, 3 );
			add_filter( 'confidant_filter_list_meta_parts', 'confidant_trx_addons_list_meta_parts' );
			add_filter( 'trx_addons_filter_get_list_meta_parts', 'confidant_trx_addons_get_list_meta_parts' );
			add_action( 'confidant_action_show_post_meta', 'confidant_trx_addons_show_post_meta', 10, 3 );
			add_filter( 'confidant_filter_list_hovers', 'confidant_trx_addons_custom_hover_list' );
			add_filter( 'trx_addons_filter_get_theme_info', 'confidant_trx_addons_get_theme_info', 9 );
			add_filter( 'trx_addons_filter_get_theme_data', 'confidant_trx_addons_get_theme_data', 9, 3 );
			add_filter( 'trx_addons_filter_get_theme_file_dir', 'confidant_trx_addons_get_theme_file_dir', 10, 3 );
			add_filter( 'trx_addons_filter_get_theme_folder_dir', 'confidant_trx_addons_get_theme_folder_dir', 10, 3 );
			add_action( 'trx_addons_action_create_layout', 'confidant_trx_addons_create_layout', 10, 5 );
			add_action( 'trx_addons_action_create_layouts', 'confidant_trx_addons_create_layouts', 10, 1 );
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'confidant_trx_addons_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'confidant_trx_addons_theme_setup9', 9 );
	function confidant_trx_addons_theme_setup9() {
		if ( confidant_exists_trx_addons() ) {
			add_filter( 'trx_addons_filter_add_thumb_names', 'confidant_trx_addons_add_thumb_sizes' );
			add_filter( 'trx_addons_filter_add_thumb_sizes', 'confidant_trx_addons_add_thumb_sizes' );
			add_filter( 'trx_addons_filter_get_thumb_size', 'confidant_trx_addons_get_thumb_size' );
			add_filter( 'trx_addons_filter_video_width', 'confidant_trx_addons_video_width', 10, 2 );
			add_filter( 'trx_addons_filter_video_dimensions', 'confidant_trx_addons_video_dimensions', 10, 2 );
			add_filter( 'confidant_filter_video_dimensions', 'confidant_trx_addons_video_dimensions_in_video_list', 10, 2 );
			add_action( 'confidant_action_before_featured', 'confidant_trx_addons_before_featured_image' );
			add_action( 'confidant_action_after_featured', 'confidant_trx_addons_after_featured_image' );
			add_filter( 'trx_addons_filter_featured_image', 'confidant_trx_addons_featured_image', 10, 2 );
			add_filter( 'trx_addons_filter_featured_hover', 'confidant_trx_addons_featured_hover', 10, 2);
			add_filter( 'confidant_filter_post_featured_classes', 'confidant_trx_addons_post_featured_classes', 10, 3 );
			add_filter( 'confidant_filter_post_featured_data', 'confidant_trx_addons_post_featured_data', 10, 3 );
			add_filter( 'confidant_filter_args_featured', 'confidant_trx_addons_args_featured', 10, 3 );
			add_action( 'confidant_action_custom_hover_icons', 'confidant_trx_addons_custom_hover_icons', 10, 2 );
			add_action( 'trx_addons_action_add_hover_icons', 'confidant_trx_addons_add_hover_icons', 10, 2 );
			add_filter( 'trx_addons_filter_get_list_sc_image_hover', 'confidant_trx_addons_get_list_sc_image_hover' );
			add_filter( 'trx_addons_filter_no_image', 'confidant_trx_addons_no_image', 10, 3 );
			add_filter( 'trx_addons_filter_sc_blogger_template', 'confidant_trx_addons_sc_blogger_template', 10, 2 );
			add_filter( 'trx_addons_filter_get_list_icons_classes', 'confidant_trx_addons_get_list_icons_classes', 10, 2 );
			add_filter( 'trx_addons_filter_clear_icon_name', 'confidant_trx_addons_clear_icon_name' );
			add_filter( 'confidant_filter_add_sort_order', 'confidant_trx_addons_add_sort_order', 10, 3 );
			add_filter( 'confidant_filter_post_content', 'confidant_trx_addons_filter_post_content' );
			add_filter( 'confidant_filter_get_post_categories', 'confidant_trx_addons_get_post_categories', 10, 2 );
			add_filter( 'confidant_filter_get_post_date', 'confidant_trx_addons_get_post_date' );
			add_filter( 'trx_addons_filter_get_post_date', 'confidant_trx_addons_get_post_date_wrap' );
			add_filter( 'confidant_filter_post_type_taxonomy', 'confidant_trx_addons_post_type_taxonomy', 10, 2 );
			add_filter( 'confidant_filter_term_name', 'confidant_trx_addons_term_name', 10, 2 );
			add_filter( 'trx_addons_filter_theme_logo', 'confidant_trx_addons_theme_logo', 10, 2 );
			add_filter( 'trx_addons_filter_show_site_name_as_logo', 'confidant_trx_addons_show_site_name_as_logo' );
			add_filter( 'confidant_filter_sidebar_present', 'confidant_trx_addons_sidebar_present' );
			add_filter( 'trx_addons_filter_privacy_text', 'confidant_trx_addons_privacy_text' );
			add_filter( 'trx_addons_filter_privacy_url', 'confidant_trx_addons_privacy_url' );
			add_action( 'confidant_action_show_layout', 'confidant_trx_addons_action_show_layout', 10, 2 );
			add_filter( 'trx_addons_filter_get_theme_accent_color', 'confidant_trx_addons_get_theme_accent_color' );
			add_filter( 'trx_addons_filter_get_theme_bg_color', 'confidant_trx_addons_get_theme_bg_color' );
			add_filter( 'trx_addons_filter_get_theme_color_name', 'confidant_trx_addons_get_theme_color_name' );
			add_filter( 'confidant_filter_detect_blog_mode', 'confidant_trx_addons_detect_blog_mode' );
			add_filter( 'confidant_filter_get_blog_title', 'confidant_trx_addons_get_blog_title' );
			add_filter( 'trx_addons_filter_get_blog_title', 'confidant_trx_addons_get_blog_title_from_blog_archive' );
			add_filter( 'confidant_filter_get_post_link', 'confidant_trx_addons_get_post_link');
			add_action( 'confidant_action_login', 'confidant_trx_addons_action_login' );
			add_action( 'confidant_action_cart', 'confidant_trx_addons_action_cart' );
			add_action( 'confidant_action_product_attributes', 'confidant_trx_addons_action_product_attributes', 10, 1 );
			add_action( 'confidant_action_breadcrumbs', 'confidant_trx_addons_action_breadcrumbs' );
			add_filter( 'confidant_filter_get_translated_layout', 'confidant_trx_addons_filter_get_translated_layout', 10, 1 );
			add_action( 'confidant_action_before_single_post_video', 'confidant_trx_addons_action_before_single_post_video', 10, 1 );
			add_action( 'confidant_action_after_single_post_video', 'confidant_trx_addons_action_after_single_post_video', 10, 1 );
			add_filter( 'trx_addons_filter_page_background_selector', 'confidant_trx_addons_get_page_background_selector' );
			if ( is_admin() ) {
				add_filter( 'confidant_filter_allow_override_options', 'confidant_trx_addons_allow_override_options', 10, 2 );
				add_filter( 'confidant_filter_allow_theme_icons', 'confidant_trx_addons_allow_theme_icons', 10, 2 );
				add_filter( 'trx_addons_filter_export_options', 'confidant_trx_addons_export_options' );
				add_filter( 'confidant_filter_options_get_list_choises', 'confidant_trx_addons_options_get_list_choises', 999, 2 );
				add_filter( 'trx_addons_filter_disallow_term_name_modify', 'confidant_trx_addons_disallow_term_name_modify', 10, 3 );
			} else {
				add_filter( 'trx_addons_filter_inc_views', 'confidant_trx_addons_inc_views' );
				add_filter( 'confidant_filter_related_thumb_size', 'confidant_trx_addons_related_thumb_size' );
				add_filter( 'confidant_filter_show_related_posts', 'confidant_trx_addons_show_related_posts' );
				add_filter( 'trx_addons_filter_show_related_posts_after_article', 'confidant_trx_addons_show_related_posts_after_article' );
				add_filter( 'trx_addons_filter_args_related', 'confidant_trx_addons_args_related' );
				add_filter( 'trx_addons_filter_seo_snippets', 'confidant_trx_addons_seo_snippets' );
				add_action( 'trx_addons_action_before_article', 'confidant_trx_addons_before_article', 10, 1 );
				add_action( 'trx_addons_action_article_start', 'confidant_trx_addons_article_start', 10, 1 );
				add_filter( 'confidant_filter_get_mobile_menu', 'confidant_trx_addons_get_mobile_menu' );
				add_action( 'confidant_action_user_meta', 'confidant_trx_addons_action_user_meta', 10, 1 );
				add_filter( 'trx_addons_filter_featured_image_override', 'confidant_trx_addons_featured_image_override' );
				add_filter( 'trx_addons_filter_get_current_mode_image', 'confidant_trx_addons_get_current_mode_image' );
				add_filter( 'confidant_filter_get_post_iframe', 'confidant_trx_addons_get_post_iframe', 10, 1 );
				add_action( 'confidant_action_before_full_post_content', 'confidant_trx_addons_before_full_post_content' );
				add_action( 'confidant_action_after_full_post_content', 'confidant_trx_addons_after_full_post_content' );
				add_filter( 'trx_addons_filter_disable_animation_on_mobile', 'confidant_trx_addons_disable_animation_on_mobile' );
				add_filter( 'trx_addons_filter_custom_meta_value_strip_tags', 'confidant_trx_addons_custom_meta_value_strip_tags' );
			}
			add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_responsive_styles', 2000 );
			//-- Separate loading styles of the ThemeREX Addons components (cpt, shortcodes, widgets)
			add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_frontend_scripts_separate', 1100 );
			add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_responsive_styles_separate', 2000 );
			if ( confidant_optimize_css_and_js_loading() && apply_filters( 'confidant_filters_separate_trx_addons_styles', false ) ) {
				$components = confidant_trx_addons_get_separate_components();
				foreach( $components as $component ) {
					add_action( "trx_addons_action_load_scripts_front_{$component}", 'confidant_trx_addons_frontend_scripts_separate', 10, 1 );
					add_action( "trx_addons_action_load_scripts_front_{$component}", 'confidant_trx_addons_responsive_styles_separate', 10, 1 );
				}
			}
			//-- /End separate loading
			add_filter( 'confidant_filter_merge_styles', 'confidant_trx_addons_merge_styles' );
			add_filter( 'confidant_filter_merge_styles_responsive', 'confidant_trx_addons_merge_styles_responsive' );
			add_filter( 'confidant_filter_merge_scripts', 'confidant_trx_addons_merge_scripts' );
			add_filter( 'confidant_filter_prepare_css', 'confidant_trx_addons_prepare_css', 10, 2 );
			add_filter( 'confidant_filter_prepare_js', 'confidant_trx_addons_prepare_js', 10, 2 );
			add_filter( 'confidant_filter_localize_script', 'confidant_trx_addons_localize_script' );
			add_filter( 'trx_addons_filter_load_tweenmax', 'confidant_trx_addons_load_tweenmax' );
			// The priority 0 is used to catch loading component before the component-specific action is triggered on priority 1
			add_action( 'trx_addons_action_load_scripts_front', 'confidant_trx_addons_load_frontend_scripts', 0, 2 );
		}

		// Add this filter any time: if plugin exists - load plugin's styles, if not exists - load layouts.css instead plugin's styles
		add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_layouts_styles' );

		if ( is_admin() ) {
			add_filter( 'confidant_filter_tgmpa_required_plugins', 'confidant_trx_addons_tgmpa_required_plugins', 1 );
			add_filter( 'confidant_filter_tgmpa_required_plugins', 'confidant_trx_addons_tgmpa_required_plugins_all', 999 );
		} else {
			add_action( 'confidant_action_search', 'confidant_trx_addons_action_search', 10, 1 );
			add_filter( 'confidant_filter_search_form_url', 'confidant_trx_addons_filter_search_form_url', 10, 1 );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'confidant_trx_addons_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter( 'confidant_filter_tgmpa_required_plugins', 'confidant_trx_addons_tgmpa_required_plugins', 1 );
	function confidant_trx_addons_tgmpa_required_plugins( $list = array() ) {
		if ( confidant_storage_isset( 'required_plugins', 'trx_addons' ) && confidant_storage_get_array( 'required_plugins', 'trx_addons', 'install' ) !== false ) {
			$path = confidant_get_plugin_source_path( 'plugins/trx_addons/trx_addons.zip' );
			if ( ! empty( $path ) || confidant_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => confidant_storage_get_array( 'required_plugins', 'trx_addons', 'title' ),
					'slug'     => 'trx_addons',
					'version'  => '2.32.2',
					'source'   => ! empty( $path ) ? $path : 'upload://trx_addons.zip',
					'required' => true,
				);
			}
		}
		return $list;
	}
}


/* Add options in the Theme Options Customizer
------------------------------------------------------------------------------- */

if ( ! function_exists( 'confidant_trx_addons_cpt_list_options' ) ) {
	// Handler of the add_filter( 'trx_addons_cpt_list_options', 'confidant_trx_addons_cpt_list_options', 10, 2);
	function confidant_trx_addons_cpt_list_options( $options, $cpt ) {
		if ( 'layouts' == $cpt && CONFIDANT_THEME_FREE ) {
			$options = array();
		} elseif ( is_array( $options ) ) {
			foreach ( $options as $k => $v ) {
				// Store this option in the external (not theme's) storage
				$options[ $k ]['options_storage'] = 'trx_addons_options';
				// Hide this option from plugin's options (only for overriden options)
				if ( in_array( $cpt, array( 'cars', 'cars_agents', 'certificates', 'courses', 'dishes', 'portfolio', 'properties', 'agents', 'resume', 'services', 'sport', 'team', 'testimonials' ) ) ) {
					$options[ $k ]['hidden'] = true;
				}
			}
		}
		return $options;
	}
}

// Return plugin's specific options for CPT
if ( ! function_exists( 'confidant_trx_addons_get_list_cpt_options' ) ) {
	function confidant_trx_addons_get_list_cpt_options( $cpt ) {
		$options = array();
		if ( 'cars' == $cpt ) {
			$options = array_merge(
				trx_addons_cpt_cars_get_list_options(),
				trx_addons_cpt_cars_agents_get_list_options()
			);
		} elseif ( 'certificates' == $cpt ) {
			$options = trx_addons_cpt_certificates_get_list_options();
		} elseif ( 'courses' == $cpt ) {
			$options = trx_addons_cpt_courses_get_list_options();
		} elseif ( 'dishes' == $cpt ) {
			$options = trx_addons_cpt_dishes_get_list_options();
		} elseif ( 'portfolio' == $cpt ) {
			$options = trx_addons_cpt_portfolio_get_list_options();
		} elseif ( 'resume' == $cpt ) {
			$options = trx_addons_cpt_resume_get_list_options();
		} elseif ( 'services' == $cpt ) {
			$options = trx_addons_cpt_services_get_list_options();
		} elseif ( 'properties' == $cpt ) {
			$options = array_merge(
				trx_addons_cpt_properties_get_list_options(),
				trx_addons_cpt_agents_get_list_options()
			);
		} elseif ( 'sport' == $cpt ) {
			$options = trx_addons_cpt_sport_get_list_options();
		} elseif ( 'team' == $cpt ) {
			$options = trx_addons_cpt_team_get_list_options();
		} elseif ( 'testimonials' == $cpt ) {
			$options = trx_addons_cpt_testimonials_get_list_options();
		}

		foreach ( $options as $k => $v ) {
			// Disable refresh the preview area on change any plugin's option
			$options[ $k ]['refresh'] = false;
			// Remove parameter 'hidden'
			if ( ! empty( $v['hidden'] ) ) {
				unset( $options[ $k ]['hidden'] );
			}
			// Add description
			if ( 'info' == $v['type'] ) {
				$options[ $k ]['desc'] = wp_kses_data( __( 'In order to see changes made by settings of this section, click "Save" and refresh the page', 'confidant' ) );
			}
			// Replace class 'trx_addons_column-' with 'confidant_column-'
			$options[ $k ] = confidant_array_str_replace( 'trx_addons_column-', 'confidant_column-', 'class', $options[ $k ] );
		}
		return $options;
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'confidant_trx_addons_setup3' ) ) {
	add_action( 'after_setup_theme', 'confidant_trx_addons_setup3', 3 );
	function confidant_trx_addons_setup3() {

		// Add option 'Show featured image' to the Single post options to override it in the CPT Portfolio and Services
		// (make option hidden to disable it in the main section Blog - Single posts and allow only in the post meta
		// for post types "Portfolio" and  "Services")
		$cpt_override = array();
		if ( confidant_exists_portfolio() ) {
			$cpt_override[] = TRX_ADDONS_CPT_PORTFOLIO_PT;
		}
		if ( confidant_exists_services() ) {
			$cpt_override[] = TRX_ADDONS_CPT_SERVICES_PT;
		}
		if ( count( apply_filters( 'confidant_filter_show_featured_cpt', $cpt_override ) ) > 0 ) {
			confidant_storage_set_array_before( 'options', 'single_style', 'show_featured_image', array(
							'title'    => esc_html__( 'Show featured image', 'confidant' ),
							'desc'     => wp_kses_data( __( "Show featured image on single post pages", 'confidant' ) ),
							'override' => array(
								'mode'    => join( ',', $cpt_override ),
								'section' => esc_html__( 'Content', 'confidant' ),
							),
							'hidden'   => true,
							'std'      => 1,
							'type'     => 'switch',
						) );
		}

		// Section 'Cars' - settings to show 'Cars' blog archive and single posts
		if ( confidant_exists_cars() ) {
			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'cars' => array(
							'title' => esc_html__( 'Cars', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the cars pages.', 'confidant' ) ),
							'icon'  => 'icon-cars',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'cars' ),
					confidant_options_get_list_cpt_options( 'cars' ),
					array(
						'single_info_cars'        => array(
							'title' => esc_html__( 'Single car', 'confidant' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'show_related_posts_cars' => array(
							'title' => esc_html__( 'Show related posts', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show 'Related posts' section on single post pages", 'confidant' ) ),
							'std'   => 1,
							'type'  => 'switch',
						),
						'related_posts_cars'      => array(
							'title'      => esc_html__( 'Related cars', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many related cars should be displayed on the single car page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_cars' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_cars'    => array(
							'title'      => esc_html__( 'Related columns', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output related cars on the single car page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_cars' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 2, 3 ),
							'type'       => 'select',
						),
					)
				)
			);
		}

		// Section 'Certificates'
		if ( confidant_exists_certificates() ) {
			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'certificates' => array(
							'title' => esc_html__( 'Certificates', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display "Certificates"', 'confidant' ) ),
							'icon'  => 'icon-certificates',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'certificates' )
				)
			);
		}

		// Section 'Courses' - settings to show 'Courses' blog archive and single posts
		if ( confidant_exists_courses() ) {

			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'courses' => array(
							'title' => esc_html__( 'Courses', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the courses pages', 'confidant' ) ),
							'icon'  => 'icon-courses',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'courses' ),
					confidant_options_get_list_cpt_options( 'courses' ),
					array(
						'single_info_courses'        => array(
							'title' => esc_html__( 'Single course', 'confidant' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'show_related_posts_courses' => array(
							'title' => esc_html__( 'Show related posts', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show 'Related posts' section on single post pages", 'confidant' ) ),
							'std'   => 1,
							'type'  => 'switch',
						),
						'related_posts_courses'      => array(
							'title'      => esc_html__( 'Related courses', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many related courses should be displayed on the single course page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_courses' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_courses'    => array(
							'title'      => esc_html__( 'Related columns', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output related courses on the single course page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_courses' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 2, 3 ),
							'type'       => 'select',
						),
					)
				)
			);
		}

		// Section 'Dishes' - settings to show 'Dishes' blog archive and single posts
		if ( confidant_exists_dishes() ) {

			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'dishes' => array(
							'title' => esc_html__( 'Dishes', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the dishes pages', 'confidant' ) ),
							'icon'  => 'icon-dishes',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'dishes' ),
					confidant_options_get_list_cpt_options( 'dishes' ),
					array(
						'single_info_dishes'        => array(
							'title' => esc_html__( 'Single dish', 'confidant' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'show_related_posts_dishes' => array(
							'title' => esc_html__( 'Show related posts', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show 'Related posts' section on single post pages", 'confidant' ) ),
							'std'   => 1,
							'type'  => 'switch',
						),
						'related_posts_dishes'      => array(
							'title'      => esc_html__( 'Related dishes', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many related dishes should be displayed on the single dish page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_dishes' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_dishes'    => array(
							'title'      => esc_html__( 'Related columns', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output related dishes on the single dish page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_dishes' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 2, 3 ),
							'type'       => 'select',
						),
					)
				)
			);
		}

		// Section 'Portfolio' - settings to show 'Portfolio' blog archive and single posts
		if ( confidant_exists_portfolio() ) {
			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'portfolio' => array(
							'title' => esc_html__( 'Portfolio', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the portfolio pages', 'confidant' ) ),
							'icon'  => 'icon-portfolio-1',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'portfolio' ),
					confidant_options_get_list_cpt_options( 'portfolio' ),
					array(
						'single_info_portfolio'        => array(
							'title' => esc_html__( 'Single portfolio item', 'confidant' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'show_featured_image_portfolio' => array(
							'title' => esc_html__( 'Show featured image', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show featured image on single post pages", 'confidant' ) ),
							'std'   => 1,
							'type'  => 'switch',
						),
						'show_related_posts_portfolio' => array(
							'title' => esc_html__( 'Show related posts', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show 'Related posts' section on single post pages", 'confidant' ) ),
							'std'   => 1,
							'type'  => 'switch',
						),
						'related_posts_portfolio'      => array(
							'title'      => esc_html__( 'Related portfolio items', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many related portfolio items should be displayed on the single portfolio page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_portfolio' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_portfolio'    => array(
							'title'      => esc_html__( 'Related columns', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output related portfolio on the single portfolio page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_portfolio' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 2, 4 ),
							'type'       => 'select',
						),
					)
				)
			);
		}

		// Section 'Properties' - settings to show 'Properties' blog archive and single posts
		if ( confidant_exists_properties() ) {

			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'properties' => array(
							'title' => esc_html__( 'Properties', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the properties pages', 'confidant' ) ),
							'icon'  => 'icon-building',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'properties' ),
					confidant_options_get_list_cpt_options( 'properties' ),
					array(
						'single_info_properties'        => array(
							'title' => esc_html__( 'Single property', 'confidant' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'show_related_posts_properties' => array(
							'title' => esc_html__( 'Show related posts', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show 'Related posts' section on single post pages", 'confidant' ) ),
							'std'   => 1,
							'type'  => 'switch',
						),
						'related_posts_properties'      => array(
							'title'      => esc_html__( 'Related properties', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many related properties should be displayed on the single property page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_properties' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_properties'    => array(
							'title'      => esc_html__( 'Related columns', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output related properties on the single property page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_properties' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 2, 3 ),
							'type'       => 'select',
						),
					)
				)
			);
		}

		// Section 'Resume'
		if ( confidant_exists_resume() ) {
			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'resume' => array(
							'title' => esc_html__( 'Resume', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display "Resume"', 'confidant' ) ),
							'icon'  => 'icon-resume',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'resume' )
				)
			);
		}

		// Section 'Services' - settings to show 'Services' blog archive and single posts
		if ( confidant_exists_services() ) {

			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'services' => array(
							'title' => esc_html__( 'Services', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the services pages', 'confidant' ) ),
							'icon'  => 'icon-services',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'services' ),
					confidant_options_get_list_cpt_options( 'services' ),
					array(
						'single_info_services'        => array(
							'title' => esc_html__( 'Single service item', 'confidant' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'show_featured_image_services' => array(
							'title' => esc_html__( 'Show featured image', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show featured image on single post pages", 'confidant' ) ),
							'std'   => 1,
							'type'  => 'switch',
						),
						'show_related_posts_services' => array(
							'title' => esc_html__( 'Show related posts', 'confidant' ),
							'desc'  => wp_kses_data( __( "Show 'Related posts' section on single post pages", 'confidant' ) ),
							'std'   => 0,
							'type'  => 'switch',
						),
						'related_posts_services'      => array(
							'title'      => esc_html__( 'Related services', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many related services should be displayed on the single service page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_services' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_services'    => array(
							'title'      => esc_html__( 'Related columns', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output related services on the single service page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_services' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 2, 3 ),
							'type'       => 'select',
						),
					)
				)
			);
		}

		// Section 'Sport' - settings to show 'Sport' blog archive and single posts
		if ( confidant_exists_sport() ) {
			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'sport' => array(
							'title' => esc_html__( 'Sport', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the sport pages', 'confidant' ) ),
							'icon'  => 'icon-sport',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'sport' ),
					confidant_options_get_list_cpt_options( 'sport' )
				)
			);
		}

		// Section 'Team' - settings to show 'Team' blog archive and single posts
		if ( confidant_exists_team() ) {
			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'team' => array(
							'title' => esc_html__( 'Team', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display the team members pages.', 'confidant' ) ),
							'icon'  => 'icon-team',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'team' ),
					confidant_options_get_list_cpt_options( 'team' ),
					array(
						'single_info_team'            => array(
							'title' => esc_html__( 'Team member single page', 'confidant' ),
							'desc'  => '',
							'type'  => 'info',
						),
						'show_related_posts_team'     => array(
							'title' => esc_html__( "Show team member's posts", 'confidant' ),
							'desc'  => wp_kses_data( __( "Display the section 'Team member's posts' on the single team page", 'confidant' ) ),
							'std'   => 0,
							'type'  => 'switch',
						),
						'related_posts_team'          => array(
							'title'      => esc_html__( 'Post count', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many posts should be displayed on the single team page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_team' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 1, 9 ),
							'type'       => 'select',
						),
						'related_columns_team'       => array(
							'title'      => esc_html__( 'Post columns', 'confidant' ),
							'desc'       => wp_kses_data( __( 'How many columns should be used to output posts on the single team page?', 'confidant' ) ),
							'dependency' => array(
								'show_related_posts_team' => array( 1 ),
							),
							'std'        => 3,
							'options'    => confidant_get_list_range( 2, 3 ),
							'type'       => 'select',
						),
					)
				)
			);
		}

		// Section 'Testimonials'
		if ( confidant_exists_testimonials() ) {
			confidant_storage_merge_array(
				'options', '', array_merge(
					array(
						'testimonials' => array(
							'title' => esc_html__( 'Testimonials', 'confidant' ),
							'desc'  => wp_kses_data( __( 'Select parameters to display "Testimonials"', 'confidant' ) ),
							'icon'  => 'icon-testimonials',
							'type'  => 'section',
						),
					),
					confidant_trx_addons_get_list_cpt_options( 'testimonials' )
				)
			);
		}
	}
}

// Add 'layout edit' link to the 'description' in the 'header_style' and 'footer_style' parameters
if ( ! function_exists( 'confidant_trx_addons_add_link_edit_layout' ) ) {
	//Old way: Handler of the add_action( 'confidant_action_load_options', 'confidant_trx_addons_add_link_edit_layout');
	//New way: Handler of the add_action( 'admin_init', 'confidant_trx_addons_add_link_edit_layout');
	//         Handler of the add_action( 'customize_register', 'confidant_trx_addons_add_link_edit_layout' );
	function confidant_trx_addons_add_link_edit_layout() {
		static $added = false;
		if ( $added ) {
			return;
		}
		$added   = true;
		global $CONFIDANT_STORAGE;
		foreach ( $CONFIDANT_STORAGE['options'] as $k => $v ) {
			if ( ! isset( $v['std'] ) ) {
				continue;
			}
			$k1 = substr( $k, 0, 12 );
			if ( 'header_style' == $k1 || 'footer_style' == $k1 ) {
				$layout = confidant_get_theme_option( $k );
				if ( confidant_is_inherit( $layout ) ) {
					$layout = confidant_get_theme_option( $k1 );
				}
				if ( ! empty( $layout ) ) {
					$layout = explode( '-', $layout );
					$layout = $layout[ count( $layout ) - 1 ];
					if ( (int) $layout > 0 ) {
						$CONFIDANT_STORAGE['options'][ $k ]['desc'] = $v['desc']
								. '<br>'
								. sprintf(
									'<a href="%1$s" class="confidant_post_editor' . ( intval( $layout ) == 0 ? ' confidant_hidden' : '' ) . '" target="_blank">%2$s</a>',
									admin_url( apply_filters( 'confidant_filter_post_edit_link', sprintf( 'post.php?post=%d&amp;action=edit', $layout ), $layout ) ),
									__( 'Open selected layout in a new tab to edit', 'confidant' )
								);
					}
				}
			}
		}
	}
}


// Setup internal plugin's parameters
if ( ! function_exists( 'confidant_trx_addons_init_settings' ) ) {
	add_filter( 'trx_addons_init_settings', 'confidant_trx_addons_init_settings' );
	function confidant_trx_addons_init_settings( $settings ) {
		$settings['socials_type']              = confidant_get_theme_setting( 'socials_type' );
		$settings['icons_type']                = confidant_get_theme_setting( 'icons_type' );
		$settings['icons_selector']            = confidant_get_theme_setting( 'icons_selector' );
		$settings['icons_source']              = confidant_get_theme_setting( 'icons_source' );
		$settings['gutenberg_safe_mode']       = confidant_get_theme_setting( 'gutenberg_safe_mode' );
		$settings['gutenberg_add_context']     = confidant_get_theme_setting( 'gutenberg_add_context' );
		$settings['modify_gutenberg_blocks']   = confidant_get_theme_setting( 'modify_gutenberg_blocks' );
		$settings['allow_gutenberg_blocks']    = confidant_get_theme_setting( 'allow_gutenberg_blocks' );
		$settings['subtitle_above_title']      = confidant_get_theme_setting( 'subtitle_above_title' );
		$settings['add_hide_on_xxx']           = confidant_get_theme_setting( 'add_hide_on_xxx' );
		$settings['options_tabs_position']     = confidant_get_theme_setting( 'options_tabs_position' );
		$settings['wrap_menu_items_with_span'] = confidant_get_theme_setting( 'wrap_menu_items_with_span' );
		$settings['remove_empty_menu_items']   = confidant_get_theme_setting( 'remove_empty_menu_items' );
		$settings['banners_show_effect']       = confidant_get_theme_setting( 'banners_show_effect' );
		$settings['add_render_attributes']     = confidant_get_theme_setting( 'add_render_attributes' );
		$settings['slider_round_lengths']      = confidant_get_theme_setting( 'slider_round_lengths' );
		return $settings;
	}
}


// Return theme-specific data by var name
if ( ! function_exists( 'confidant_trx_addons_get_theme_data' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_theme_data, 'confidant_trx_addons_get_theme_data', 9, 3 );
	function confidant_trx_addons_get_theme_data( $data, $name, $subkey = '' ) {
		if ( confidant_storage_isset( $name ) ) {
			$data = empty( $subkey ) ? confidant_storage_get( $name ) : confidant_storage_get_array( $name, $subkey );
		}
		return $data;
	}
}

// Return theme-specific data to the Dashboard Widget and Theme Panel
// Attention:
// 1) To show the item in the Dashboard Widget you need specify 'link' and 'link_text'
// 2) To show the item in the Theme Dashboard you need specify 'link', 'image', 'icon' (optional), 'title', 'description' and 'button'
if ( ! function_exists( 'confidant_trx_addons_get_theme_info' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_theme_info', 'confidant_trx_addons_get_theme_info', 9);
	function confidant_trx_addons_get_theme_info( $theme_info ) {
		$theme_info['theme_slug']       = apply_filters( 'confidant_filter_original_theme_slug', ! empty( $theme_info['theme_slug'] ) ? $theme_info['theme_slug'] : get_template() );
		$theme_info['theme_activated']  = (int) get_option( 'confidant_theme_activated' );
		$theme_info['theme_pro_key']    = confidant_get_theme_pro_key();
		$theme_info['theme_plugins']    = confidant_storage_get( 'theme_plugins' );
		$theme_info['theme_categories'] = explode( ',', confidant_storage_get( 'theme_categories' ) );
		$theme_info['theme_actions']    = array(
			'options'         => array(
				'link'        => admin_url() . 'customize.php',
				'image'       => confidant_get_file_url( 'theme-specific/theme-about/images/theme-panel-options.svg' ),
				'title'       => esc_html__( 'Theme Options', 'confidant' ),
				'description' => esc_html__( "Customize the appearance of your theme and adjust specific theme settings. Both WordPress Customizer and Theme Options are available.", 'confidant' ),
				'button'      => esc_html__( 'Customizer', 'confidant' ),
			),
			'demo'    => array(
				'link'        => confidant_storage_get( 'theme_demo_url' ),
				'link_text'   => esc_html__( 'Demo', 'confidant' ),                 // If not empty - action visible in "Dashboard widget"
			),
			'doc'     => array(
				'link'        => confidant_storage_get( 'theme_doc_url' ),
				'link_text'   => esc_html__( 'Docs', 'confidant' ),
				'image'       => confidant_get_file_url( 'theme-specific/theme-about/images/theme-panel-doc.svg' ),
				'title'       => esc_html__( 'Documentation', 'confidant' ),
				'description' => esc_html__( "Having questions? Learn all the ins and outs of the theme in our detailed documentation. That's the go-to place if you need advice.", 'confidant' ),
				'button'      => esc_html__( 'Open Documentation', 'confidant' ),   // If not empty - action visible in "Theme Panel"
			),
			'support' => array(
				'link'        => confidant_storage_get( 'theme_support_url' ),
				'link_text'   => esc_html__( 'Support', 'confidant' ),
				'image'       => confidant_get_file_url( 'theme-specific/theme-about/images/theme-panel-support.svg' ),
				'title'       => esc_html__( 'Support', 'confidant' ),
				'description' => esc_html__( "Are you stuck and need help? Don't worry, you can always submit a support ticket, and our team will help you out.", 'confidant' ),
				'button'      => esc_html__( 'Read Policy & Submit Ticket', 'confidant' ),
			),
		);
		if ( CONFIDANT_THEME_FREE ) {
			$theme_info['theme_name']          .= ' ' . esc_html__( 'Free', 'confidant' );
			$theme_info['theme_free']           = true;
			$theme_info['theme_actions']['pro'] = array(
				'link'        => confidant_storage_get( 'theme_download_url' ),
				'link_text'   => esc_html__( 'Go PRO', 'confidant' ),
				'image'       => confidant_get_file_url( 'theme-specific/theme-about/images/theme-panel-pro.svg' ),
				'title'       => esc_html__( 'Go Pro', 'confidant' ),
				'description' => esc_html__( 'Get Pro version to increase power of this theme in many times!', 'confidant' ),
				'button'      => esc_html__( 'Get PRO Version', 'confidant' ),
			);
		}
		return $theme_info;
	}
}

if ( ! function_exists( 'confidant_trx_addons_tgmpa_required_plugins_all' ) ) {
	//Handler of the add_filter( 'confidant_filter_tgmpa_required_plugins', 'confidant_trx_addons_tgmpa_required_plugins_all', 999 );
	function confidant_trx_addons_tgmpa_required_plugins_all( $list = array() ) {
		$theme_plugins = array();
		if ( is_array( $list ) ) {
			foreach( $list as $item ) {
				$theme_plugins[ $item['slug'] ] = confidant_storage_isset( 'required_plugins', $item['slug'] )
													? confidant_storage_get_array( 'required_plugins', $item['slug'] )
													: array(
															'title'       => $item['name'],
															'description' => '',
															'required'    => false,
															);
			}
		}
		confidant_storage_set( 'theme_plugins', apply_filters( 'confidant_filter_theme_plugins', $theme_plugins ) );
		return $list;
	}
}

// Hide sidebar on the news feed pages
if ( ! function_exists( 'confidant_trx_addons_sidebar_present' ) ) {
	//Handler of the add_filter( 'confidant_filter_sidebar_present', 'confidant_trx_addons_sidebar_present' );
	function confidant_trx_addons_sidebar_present( $present ) {
		return get_post_type() != 'trx_feed' && $present;
	}
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'confidant_trx_addons_privacy_text' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_privacy_text', 'confidant_trx_addons_privacy_text' );
	function confidant_trx_addons_privacy_text( $text='' ) {
		return confidant_get_privacy_text();
	}
}

// Return URI of the theme author's Privacy Policy page
if ( ! function_exists( 'confidant_trx_addons_privacy_url' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_privacy_url', 'confidant_trx_addons_privacy_url' );
	function confidant_trx_addons_privacy_url( $url='' ) {
		$new = confidant_storage_get('theme_privacy_url');
		if ( ! empty( $new ) ) {
			$url = $new;
		}
		return $url;
	}
}

// Hide sidebar on the news feed pages
if ( ! function_exists( 'confidant_trx_addons_disallow_term_name_modify' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_disallow_term_name_modify', 'confidant_trx_addons_disallow_term_name_modify', 10, 3 );
	function confidant_trx_addons_disallow_term_name_modify( $disallow, $term_name, $term_obj ) {
		if ( $disallow && wp_doing_ajax() && in_array( trx_addons_get_value_gp( 'action' ), array( 'confidant_ajax_get_posts' ) ) ) {
			$disallow = false;
		}
		return $disallow;
	}
}



/* Plugin's support utilities
------------------------------------------------------------------------------- */

// Check if plugin installed and activated
if ( ! function_exists( 'confidant_exists_trx_addons' ) ) {
	function confidant_exists_trx_addons() {
		return defined( 'TRX_ADDONS_VERSION' );
	}
}

// Return true if cars is supported
if ( ! function_exists( 'confidant_exists_cars' ) ) {
	function confidant_exists_cars() {
		return defined( 'TRX_ADDONS_CPT_CARS_PT' );
	}
}

// Return true if certificates is supported
if ( ! function_exists( 'confidant_exists_certificates' ) ) {
	function confidant_exists_certificates() {
		return defined( 'TRX_ADDONS_CPT_CERTIFICATES_PT' );
	}
}

// Return true if courses is supported
if ( ! function_exists( 'confidant_exists_courses' ) ) {
	function confidant_exists_courses() {
		return defined( 'TRX_ADDONS_CPT_COURSES_PT' );
	}
}

// Return true if dishes is supported
if ( ! function_exists( 'confidant_exists_dishes' ) ) {
	function confidant_exists_dishes() {
		return defined( 'TRX_ADDONS_CPT_DISHES_PT' );
	}
}

// Return true if layouts is supported
if ( ! function_exists( 'confidant_exists_layouts' ) ) {
	function confidant_exists_layouts() {
		return defined( 'TRX_ADDONS_CPT_LAYOUTS_PT' );
	}
}

// Return true if portfolio is supported
if ( ! function_exists( 'confidant_exists_portfolio' ) ) {
	function confidant_exists_portfolio() {
		return defined( 'TRX_ADDONS_CPT_PORTFOLIO_PT' );
	}
}

// Return true if properties is supported
if ( ! function_exists( 'confidant_exists_properties' ) ) {
	function confidant_exists_properties() {
		return defined( 'TRX_ADDONS_CPT_PROPERTIES_PT' );
	}
}

// Return true if resume is supported
if ( ! function_exists( 'confidant_exists_resume' ) ) {
	function confidant_exists_resume() {
		return defined( 'TRX_ADDONS_CPT_RESUME_PT' );
	}
}

// Return true if services is supported
if ( ! function_exists( 'confidant_exists_services' ) ) {
	function confidant_exists_services() {
		return defined( 'TRX_ADDONS_CPT_SERVICES_PT' );
	}
}

// Return true if sport is supported
if ( ! function_exists( 'confidant_exists_sport' ) ) {
	function confidant_exists_sport() {
		return defined( 'TRX_ADDONS_CPT_COMPETITIONS_PT' );
	}
}

// Return true if team is supported
if ( ! function_exists( 'confidant_exists_team' ) ) {
	function confidant_exists_team() {
		return defined( 'TRX_ADDONS_CPT_TEAM_PT' );
	}
}

// Return true if testimonials is supported
if ( ! function_exists( 'confidant_exists_testimonials' ) ) {
	function confidant_exists_testimonials() {
		return defined( 'TRX_ADDONS_CPT_TESTIMONIALS_PT' );
	}
}

// Return true if rating (reviews) is supported
if ( ! function_exists( 'confidant_exists_reviews' ) ) {
	function confidant_exists_reviews() {
		return function_exists( 'trx_addons_reviews_enable' ) && trx_addons_reviews_enable();
	}
}


// Return true if it's cars page
if ( ! function_exists( 'confidant_is_cars_page' ) ) {
	function confidant_is_cars_page() {
		return ( function_exists( 'trx_addons_is_cars_page' ) && trx_addons_is_cars_page() )
				|| confidant_is_cars_agents_page();
	}
}

// Return true if it's car's agents page
if ( ! function_exists( 'confidant_is_cars_agents_page' ) ) {
	function confidant_is_cars_agents_page() {
		return function_exists( 'trx_addons_is_cars_agents_page' ) && trx_addons_is_cars_agents_page();
	}
}

// Return true if it's courses page
if ( ! function_exists( 'confidant_is_courses_page' ) ) {
	function confidant_is_courses_page() {
		return function_exists( 'trx_addons_is_courses_page' ) && trx_addons_is_courses_page();
	}
}

// Return true if it's dishes page
if ( ! function_exists( 'confidant_is_dishes_page' ) ) {
	function confidant_is_dishes_page() {
		return function_exists( 'trx_addons_is_dishes_page' ) && trx_addons_is_dishes_page();
	}
}

// Return true if it's properties page
if ( ! function_exists( 'confidant_is_properties_page' ) ) {
	function confidant_is_properties_page() {
		return ( function_exists( 'trx_addons_is_properties_page' ) && trx_addons_is_properties_page() )
				|| confidant_is_properties_agents_page();
	}
}

// Return true if it's properties page
if ( ! function_exists( 'confidant_is_properties_agents_page' ) ) {
	function confidant_is_properties_agents_page() {
		return function_exists( 'trx_addons_is_agents_page' ) && trx_addons_is_agents_page();
	}
}

// Return true if it's portfolio page
if ( ! function_exists( 'confidant_is_portfolio_page' ) ) {
	function confidant_is_portfolio_page() {
		return function_exists( 'trx_addons_is_portfolio_page' ) && trx_addons_is_portfolio_page();
	}
}

// Return true if it's services page
if ( ! function_exists( 'confidant_is_services_page' ) ) {
	function confidant_is_services_page() {
		return function_exists( 'trx_addons_is_services_page' ) && trx_addons_is_services_page();
	}
}

// Return true if it's team page
if ( ! function_exists( 'confidant_is_team_page' ) ) {
	function confidant_is_team_page() {
		return function_exists( 'trx_addons_is_team_page' ) && trx_addons_is_team_page();
	}
}

// Return true if it's sport page
if ( ! function_exists( 'confidant_is_sport_page' ) ) {
	function confidant_is_sport_page() {
		return function_exists( 'trx_addons_is_sport_page' ) && trx_addons_is_sport_page();
	}
}

// Return true if custom layouts are available
if ( ! function_exists( 'confidant_is_layouts_available' ) ) {
	function confidant_is_layouts_available() {
		$required_plugins = confidant_storage_get( 'required_plugins' );
		return confidant_exists_trx_addons()
				&& (
					(
						! empty( $required_plugins['elementor'] )
						&& ( ! isset( $required_plugins['elementor']['install'] )
							|| $required_plugins['elementor']['install']
							)
						&& function_exists( 'confidant_exists_elementor' )
						&& confidant_exists_elementor()
					)
					||
					(
						! empty( $required_plugins['js_composer'] )
						&& ( ! isset( $required_plugins['js_composer']['install'] )
							|| $required_plugins['js_composer']['install']
							)
						&& function_exists( 'confidant_exists_vc' )
						&& confidant_exists_vc()
					)
					||
					(
						/*
						( empty( $required_plugins['elementor'] )
							|| ( isset( $required_plugins['elementor']['install'] )
								&& false == $required_plugins['elementor']['install']
								)
							)
						&& ( empty( $required_plugins['js_composer'] )
							|| ( isset( $required_plugins['js_composer']['install'] )
								&& false == $required_plugins['js_composer']['install']
								)
							)
						&&
						*/
						function_exists( 'confidant_exists_gutenberg' )
						&& confidant_exists_gutenberg()
					)
				);
	}
}

// Return true if theme is activated in the Theme Panel
if ( ! function_exists( 'confidant_is_theme_activated' ) ) {
	function confidant_is_theme_activated() {
		return function_exists( 'trx_addons_is_theme_activated' ) && trx_addons_is_theme_activated();
	}
}

// Return theme activation code
if ( ! function_exists( 'confidant_get_theme_activation_code' ) ) {
	function confidant_get_theme_activation_code() {
		return function_exists( 'trx_addons_get_theme_activation_code' ) ? trx_addons_get_theme_activation_code() : '';
	}
}

// Detect current blog mode
if ( ! function_exists( 'confidant_trx_addons_detect_blog_mode' ) ) {
	//Handler of the add_filter( 'confidant_filter_detect_blog_mode', 'confidant_trx_addons_detect_blog_mode' );
	function confidant_trx_addons_detect_blog_mode( $mode = '' ) {
		if ( confidant_is_cars_page() ) {
			$mode = 'cars';
		} elseif ( confidant_is_courses_page() ) {
			$mode = 'courses';
		} elseif ( confidant_is_dishes_page() ) {
			$mode = 'dishes';
		} elseif ( confidant_is_properties_page() ) {
			$mode = 'properties';
		} elseif ( confidant_is_portfolio_page() ) {
			$mode = 'portfolio';
		} elseif ( confidant_is_services_page() ) {
			$mode = 'services';
		} elseif ( confidant_is_sport_page() ) {
			$mode = 'sport';
		} elseif ( confidant_is_team_page() ) {
			$mode = 'team';
		}
		return $mode;
	}
}

// Disallow increment views counter on the blog archive
if ( ! function_exists( 'confidant_trx_addons_inc_views' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_inc_views', 'confidant_trx_addons_inc_views');
	function confidant_trx_addons_inc_views( $allow = false ) {
		return $allow && is_page() && confidant_storage_isset( 'blog_archive' ) ? false : $allow;
	}
}

// Add team, courses, etc. to the supported posts list
if ( ! function_exists( 'confidant_trx_addons_list_post_types' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_posts_types', 'confidant_trx_addons_list_post_types');
	function confidant_trx_addons_list_post_types( $list = array() ) {
		if ( function_exists( 'trx_addons_get_cpt_list' ) ) {
			$cpt_list = trx_addons_get_cpt_list();
			foreach ( $cpt_list as $cpt => $title ) {
				if (
					( defined( 'TRX_ADDONS_CPT_CARS_PT' ) && TRX_ADDONS_CPT_CARS_PT == $cpt )
					|| ( defined( 'TRX_ADDONS_CPT_COURSES_PT' ) && TRX_ADDONS_CPT_COURSES_PT == $cpt )
					|| ( defined( 'TRX_ADDONS_CPT_DISHES_PT' ) && TRX_ADDONS_CPT_DISHES_PT == $cpt )
					|| ( defined( 'TRX_ADDONS_CPT_PORTFOLIO_PT' ) && TRX_ADDONS_CPT_PORTFOLIO_PT == $cpt )
					|| ( defined( 'TRX_ADDONS_CPT_PROPERTIES_PT' ) && TRX_ADDONS_CPT_PROPERTIES_PT == $cpt )
					|| ( defined( 'TRX_ADDONS_CPT_SERVICES_PT' ) && TRX_ADDONS_CPT_SERVICES_PT == $cpt )
					|| ( defined( 'TRX_ADDONS_CPT_COMPETITIONS_PT' ) && TRX_ADDONS_CPT_COMPETITIONS_PT == $cpt )
					|| ( defined( 'TRX_ADDONS_CPT_TEAM_PT' ) && TRX_ADDONS_CPT_TEAM_PT == $cpt )
					) {
					$list[ $cpt ] = $title;
				}
			}
		}
		return $list;
	}
}

// Return taxonomy for current post type
if ( ! function_exists( 'confidant_trx_addons_post_type_taxonomy' ) ) {
	//Handler of the add_filter( 'confidant_filter_post_type_taxonomy',	'confidant_trx_addons_post_type_taxonomy', 10, 2 );
	function confidant_trx_addons_post_type_taxonomy( $tax = '', $post_type = '' ) {
		if ( defined( 'TRX_ADDONS_CPT_CARS_PT' ) && TRX_ADDONS_CPT_CARS_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_CARS_TAXONOMY_MAKER;
		} elseif ( defined( 'TRX_ADDONS_CPT_COURSES_PT' ) && TRX_ADDONS_CPT_COURSES_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_COURSES_TAXONOMY;
		} elseif ( defined( 'TRX_ADDONS_CPT_DISHES_PT' ) && TRX_ADDONS_CPT_DISHES_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_DISHES_TAXONOMY;
		} elseif ( defined( 'TRX_ADDONS_CPT_PORTFOLIO_PT' ) && TRX_ADDONS_CPT_PORTFOLIO_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY;
		} elseif ( defined( 'TRX_ADDONS_CPT_PROPERTIES_PT' ) && TRX_ADDONS_CPT_PROPERTIES_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE;
		} elseif ( defined( 'TRX_ADDONS_CPT_SERVICES_PT' ) && TRX_ADDONS_CPT_SERVICES_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_SERVICES_TAXONOMY;
		} elseif ( defined( 'TRX_ADDONS_CPT_COMPETITIONS_PT' ) && TRX_ADDONS_CPT_COMPETITIONS_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY;
		} elseif ( defined( 'TRX_ADDONS_CPT_TEAM_PT' ) && TRX_ADDONS_CPT_TEAM_PT == $post_type ) {
			$tax = TRX_ADDONS_CPT_TEAM_TAXONOMY;
		}
		return $tax;
	}
}

// Show categories of the team, courses, etc.
if ( ! function_exists( 'confidant_trx_addons_get_post_categories' ) ) {
	//Handler of the add_filter( 'confidant_filter_get_post_categories', 'confidant_trx_addons_get_post_categories', 10, 2 );
	function confidant_trx_addons_get_post_categories( $cats = '', $args = array() ) {

		$cat_sep = apply_filters(
								'confidant_filter_post_meta_cat_separator',
								'<span class="post_meta_item_cat_separator">' . ( ! isset( $args['cat_sep'] ) || ! empty( $args['cat_sep'] ) ? ', ' : ' ' ) . '</span>',
								$args
								);

		if ( defined( 'TRX_ADDONS_CPT_CARS_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_CARS_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_CARS_TAXONOMY_TYPE );
			}
		}
		if ( defined( 'TRX_ADDONS_CPT_COURSES_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_COURSES_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY );
			}
		}
		if ( defined( 'TRX_ADDONS_CPT_DISHES_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_DISHES_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_DISHES_TAXONOMY );
			}
		}
		if ( defined( 'TRX_ADDONS_CPT_PORTFOLIO_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_PORTFOLIO_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY );
			}
		}
		if ( defined( 'TRX_ADDONS_CPT_PROPERTIES_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_PROPERTIES_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE );
			}
		}
		if ( defined( 'TRX_ADDONS_CPT_SERVICES_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_SERVICES_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY );
			}
		}
		if ( defined( 'TRX_ADDONS_CPT_COMPETITIONS_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_COMPETITIONS_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY );
			}
		}
		if ( defined( 'TRX_ADDONS_CPT_TEAM_PT' ) ) {
			if ( get_post_type() == TRX_ADDONS_CPT_TEAM_PT ) {
				$cats = confidant_get_post_terms( $cat_sep, get_the_ID(), TRX_ADDONS_CPT_TEAM_TAXONOMY );
			}
		}
		return $cats;
	}
}

// Show post's date with the theme-specific format
if ( ! function_exists( 'confidant_trx_addons_get_post_date_wrap' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_post_date', 'confidant_trx_addons_get_post_date_wrap');
	function confidant_trx_addons_get_post_date_wrap( $dt = '' ) {
		return apply_filters( 'confidant_filter_get_post_date', $dt );
	}
}

// Show date of the courses
if ( ! function_exists( 'confidant_trx_addons_get_post_date' ) ) {
	//Handler of the add_filter( 'confidant_filter_get_post_date', 'confidant_trx_addons_get_post_date');
	function confidant_trx_addons_get_post_date( $dt = '' ) {

		if ( defined( 'TRX_ADDONS_CPT_COURSES_PT' ) && get_post_type() == TRX_ADDONS_CPT_COURSES_PT ) {
			$meta = get_post_meta( get_the_ID(), 'trx_addons_options', true );
			$dt   = $meta['date'];
			$dt   = sprintf(
				// Translators: Add formatted date to the output
				$dt < date( 'Y-m-d' ) ? esc_html__( 'Started on %s', 'confidant' ) : esc_html__( 'Starting %s', 'confidant' ),
				date_i18n( get_option( 'date_format' ), strtotime( $dt ) )
			);

		} elseif ( defined( 'TRX_ADDONS_CPT_COMPETITIONS_PT' ) && in_array( get_post_type(), array( TRX_ADDONS_CPT_COMPETITIONS_PT, TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_MATCHES_PT ) ) ) {
			$meta = get_post_meta( get_the_ID(), 'trx_addons_options', true );
			$dt   = $meta['date_start'];
			$dt   = sprintf(
				// Translators: Add formatted date to the output
				$dt < date( 'Y-m-d' ) . ( ! empty( $meta['time_start'] ) ? ' H:i' : '' ) ? esc_html__( 'Started on %s', 'confidant' ) : esc_html__( 'Starting %s', 'confidant' ),
				date_i18n( get_option( 'date_format' ) . ( ! empty( $meta['time_start'] ) ? ' ' . get_option( 'time_format' ) : '' ), strtotime( $dt . ( ! empty( $meta['time_start'] ) ? ' ' . trim( $meta['time_start'] ) : '' ) ) )
			);

		} elseif ( defined( 'TRX_ADDONS_CPT_COMPETITIONS_PT' ) && get_post_type() == TRX_ADDONS_CPT_PLAYERS_PT ) {
			// Uncomment (remove) next line if you want to show player's birthday in the page title block
			if ( false ) {
				$meta = get_post_meta( get_the_ID(), 'trx_addons_options', true );
				// Translators: Add formatted date to the output
				$dt = ! empty( $meta['birthday'] ) ? sprintf( esc_html__( 'Birthday: %s', 'confidant' ), date_i18n( get_option( 'date_format' ), strtotime( $meta['birthday'] ) ) ) : '';
			} else {
				$dt = '';
			}
		}
		return $dt;
	}
}

// Disable strip tags from the price
if ( ! function_exists( 'confidant_trx_addons_custom_meta_value_strip_tags' ) ) {
	// Handler of the add_filter( 'trx_addons_filter_custom_meta_value_strip_tags', 'confidant_trx_addons_custom_meta_value_strip_tags' );
	function confidant_trx_addons_custom_meta_value_strip_tags( $keys ) {
		return is_array( $keys ) ? confidant_array_delete_by_value( $keys, 'price' ) : $keys;
	}
}

// Parse layouts in the content
if ( ! function_exists( 'confidant_trx_addons_filter_post_content' ) ) {
	//Handler of the add_filter( 'confidant_filter_post_content', 'confidant_trx_addons_filter_post_content');
	function confidant_trx_addons_filter_post_content( $content ) {
		return apply_filters( 'trx_addons_filter_sc_layout_content', $content );
	}
}

// Check if meta box is allowed
if ( ! function_exists( 'confidant_trx_addons_allow_override_options' ) ) {
	//Handler of the add_filter( 'confidant_filter_allow_override_options', 'confidant_trx_addons_allow_override_options', 10, 2);
	function confidant_trx_addons_allow_override_options( $allow, $post_type ) {
		return $allow
					|| ( function_exists( 'trx_addons_extended_taxonomy_get_supported_post_types' ) && in_array( $post_type, trx_addons_extended_taxonomy_get_supported_post_types() ) )
					|| ( defined( 'TRX_ADDONS_CPT_CARS_PT' ) && in_array(
						$post_type, array(
							TRX_ADDONS_CPT_CARS_PT,
							TRX_ADDONS_CPT_CARS_AGENTS_PT,
						)
					) )
					|| ( defined( 'TRX_ADDONS_CPT_COURSES_PT' ) && TRX_ADDONS_CPT_COURSES_PT == $post_type )
					|| ( defined( 'TRX_ADDONS_CPT_DISHES_PT' ) && TRX_ADDONS_CPT_DISHES_PT == $post_type )
					|| ( defined( 'TRX_ADDONS_CPT_PORTFOLIO_PT' ) && TRX_ADDONS_CPT_PORTFOLIO_PT == $post_type )
					|| ( defined( 'TRX_ADDONS_CPT_PROPERTIES_PT' ) && in_array(
						$post_type, array(
							TRX_ADDONS_CPT_PROPERTIES_PT,
							TRX_ADDONS_CPT_AGENTS_PT,
						)
					) )
					|| ( defined( 'TRX_ADDONS_CPT_RESUME_PT' ) && TRX_ADDONS_CPT_RESUME_PT == $post_type )
					|| ( defined( 'TRX_ADDONS_CPT_SERVICES_PT' ) && TRX_ADDONS_CPT_SERVICES_PT == $post_type )
					|| ( defined( 'TRX_ADDONS_CPT_COMPETITIONS_PT' ) && in_array(
						$post_type, array(
							TRX_ADDONS_CPT_COMPETITIONS_PT,
							TRX_ADDONS_CPT_ROUNDS_PT,
							TRX_ADDONS_CPT_MATCHES_PT,
						)
					) )
					|| ( defined( 'TRX_ADDONS_CPT_TEAM_PT' ) && TRX_ADDONS_CPT_TEAM_PT == $post_type );
	}
}

// Check if theme icons is allowed
if ( ! function_exists( 'confidant_trx_addons_allow_theme_icons' ) ) {
	//Handler of the add_filter( 'confidant_filter_allow_theme_icons', 'confidant_trx_addons_allow_theme_icons', 10, 2);
	function confidant_trx_addons_allow_theme_icons( $allow, $post_type ) {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		return $allow
					|| ( defined( 'TRX_ADDONS_CPT_LAYOUTS_PT' ) && TRX_ADDONS_CPT_LAYOUTS_PT == $post_type )
					|| ( ! empty( $screen->id ) 
						&& ( false !== strpos($screen->id, '_page_trx_addons_options')
							|| in_array( $screen->id, array(
									'profile',
									'widgets',
									)
								)
							)
						);
	}
}

// Disable theme-specific fields in the exported options
if ( ! function_exists( 'confidant_trx_addons_export_options' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_export_options', 'confidant_trx_addons_export_options');
	function confidant_trx_addons_export_options( $options ) {
		// ThemeREX Addons
		if ( ! empty( $options['trx_addons_options'] ) ) {
			$options['trx_addons_options']['debug_mode']             = 0;
			$options['trx_addons_options']['api_google']             = '';
			$options['trx_addons_options']['api_google_analitics']   = '';
			$options['trx_addons_options']['api_google_remarketing'] = '';
			$options['trx_addons_options']['demo_enable']            = 0;
			$options['trx_addons_options']['demo_referer']           = '';
			$options['trx_addons_options']['demo_default_url']       = '';
			$options['trx_addons_options']['demo_logo']              = '';
			$options['trx_addons_options']['demo_post_type']         = '';
			$options['trx_addons_options']['demo_taxonomy']          = '';
			$options['trx_addons_options']['demo_logo']              = '';
			$options['trx_addons_options']['demo_logo']              = '';
			unset( $options['trx_addons_options']['themes_market_referals'] );
		}
		return $options;
	}
}

// Set related posts and columns for the plugin's output
if ( ! function_exists( 'confidant_trx_addons_args_related' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_args_related', 'confidant_trx_addons_args_related');
	function confidant_trx_addons_args_related( $args ) {
		if ( ! empty( $args['template_args_name'] )
			&& in_array(
				$args['template_args_name'],
				array(
					'trx_addons_args_sc_cars',
					'trx_addons_args_sc_courses',
					'trx_addons_args_sc_dishes',
					'trx_addons_args_sc_portfolio',
					'trx_addons_args_sc_properties',
					'trx_addons_args_sc_services',
					'trx_addons_args_sc_team',
				)
			) ) {
			$args['posts_per_page']    = (int) confidant_get_theme_option( 'show_related_posts' )
												? confidant_get_theme_option( 'related_posts' )
												: 0;
			$args['columns']           = confidant_get_theme_option( 'related_columns' );
			$args['slider']            = (int)confidant_get_theme_option( 'related_slider', 0 );
			$args['slides_space']      = (int)confidant_get_theme_option( 'related_slider_space', 30 );
			$args['slider_controls']   = confidant_get_theme_option( 'related_slider_controls', 'none' );
			$args['slider_pagination'] = confidant_get_theme_option( 'related_slider_pagination', 'bottom' );
		}
		return $args;
	}
}

// Redirect filter to the plugin
if ( ! function_exists( 'confidant_trx_addons_show_related_posts' ) ) {
	//Handler of the add_filter( 'confidant_filter_show_related_posts', 'confidant_trx_addons_show_related_posts' );
	function confidant_trx_addons_show_related_posts( $show ) {
		return apply_filters( 'trx_addons_filter_show_related_posts', $show );
	}
}

// Return false if related posts must be showed below page
if ( ! function_exists( 'confidant_trx_addons_show_related_posts_after_article' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_show_related_posts_after_article', 'confidant_trx_addons_show_related_posts_after_article' );
	function confidant_trx_addons_show_related_posts_after_article( $show ) {
		return $show && confidant_get_theme_option( 'related_position', 'below_content' ) == 'below_content';
	}
}

// Add 'custom' to the headers types list
if ( ! function_exists( 'confidant_trx_addons_list_header_footer_types' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_header_footer_types', 'confidant_trx_addons_list_header_footer_types');
	function confidant_trx_addons_list_header_footer_types( $list = array() ) {
		if ( confidant_exists_layouts() ) {
			$list['custom'] = esc_html__( 'Custom', 'confidant' );
		}
		return $list;
	}
}

// Add layouts to the headers list
if ( ! function_exists( 'confidant_trx_addons_list_header_styles' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_header_styles', 'confidant_trx_addons_list_header_styles');
	function confidant_trx_addons_list_header_styles( $list = array() ) {
		if ( confidant_exists_layouts() ) {
			$layouts  = confidant_get_list_posts(
				false, array(
					'post_type'    => TRX_ADDONS_CPT_LAYOUTS_PT,
					'meta_key'     => 'trx_addons_layout_type',
					'meta_value'   => 'header',
					'orderby'      => 'ID',
					'order'        => 'asc',
					'not_selected' => false,
				)
			);
			$new_list = array();
			foreach ( $layouts as $id => $title ) {
				if ( 'none' != $id ) {
					$new_list[ 'header-custom-' . intval( $id ) ] = $title;
				}
			}
			$list = confidant_array_merge( $new_list, $list );
		}
		return $list;
	}
}

// Add layouts to the footers list
if ( ! function_exists( 'confidant_trx_addons_list_footer_styles' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_footer_styles', 'confidant_trx_addons_list_footer_styles');
	function confidant_trx_addons_list_footer_styles( $list = array() ) {
		if ( confidant_exists_layouts() ) {
			$layouts  = confidant_get_list_posts(
				false, array(
					'post_type'    => TRX_ADDONS_CPT_LAYOUTS_PT,
					'meta_key'     => 'trx_addons_layout_type',
					'meta_value'   => 'footer',
					'orderby'      => 'ID',
					'order'        => 'asc',
					'not_selected' => false,
				)
			);
			$new_list = array();
			foreach ( $layouts as $id => $title ) {
				if ( 'none' != $id ) {
					$new_list[ 'footer-custom-' . intval( $id ) ] = $title;
				}
			}
			$list = confidant_array_merge( $new_list, $list );
		}
		return $list;
	}
}

// Add layouts to the sidebars list
if ( ! function_exists( 'confidant_trx_addons_list_sidebar_styles' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_sidebar_styles', 'confidant_trx_addons_list_sidebar_styles');
	function confidant_trx_addons_list_sidebar_styles( $list = array() ) {
		if ( confidant_exists_layouts() ) {
			$layouts  = confidant_get_list_posts(
				false, array(
					'post_type'    => TRX_ADDONS_CPT_LAYOUTS_PT,
					'meta_key'     => 'trx_addons_layout_type',
					'meta_value'   => 'sidebar',
					'orderby'      => 'ID',
					'order'        => 'asc',
					'not_selected' => false,
				)
			);
			$new_list = array();
			foreach ( $layouts as $id => $title ) {
				if ( 'none' != $id ) {
					$new_list[ 'sidebar-custom-' . intval( $id ) ] = $title;
				}
			}
			$list = confidant_array_merge( $new_list, $list );
		}
		return $list;
	}
}

// Add layouts to the blog styles list
if ( ! function_exists( 'confidant_trx_addons_list_blog_styles' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_blog_styles', 'confidant_trx_addons_list_blog_styles', 10, 3 );
	function confidant_trx_addons_list_blog_styles( $list, $filter, $need_custom = true ) {
		static $new_list = array();
		if ( $need_custom && confidant_exists_layouts() ) {
			if ( empty( $new_list[ $filter ] ) ) {
				$new_list[ $filter ] = array();
				$custom_blog_use_id = false;	// Use post ID or sanitized post title as part XXX of the layout key 'blog-custom-XXX_columns'
				$layouts  = confidant_get_list_posts(
					false, array(
						'post_type'    => TRX_ADDONS_CPT_LAYOUTS_PT,
						'meta_key'     => 'trx_addons_layout_type',
						'meta_value'   => 'blog',
						'orderby'      => 'title',
						'order'        => 'asc',
						'not_selected' => false,
					)
				);
				foreach ( $layouts as $id => $title ) {
					if ( $filter == 'arh' ) {
						$from = 1;
						$to = 1;
						$meta = get_post_meta( $id, 'trx_addons_options', true );
						if ( ! empty( $meta['columns_allowed'] ) ) {
							$parts = explode( ',', $meta['columns_allowed'] );
							if ( count($parts) == 1) {
								$to = min( 6, max( $from, (int) $parts[0] ) );
							} else {
								$from = min( 6, max( 1, (int) $parts[0] ) );
								$to = min( 6, max( $from, (int) $parts[1] ) );
							}
						}
						$new_row = $from < $to;
						for ( $i = $from; $i <= $to; $i++ ) {
							$new_list[ $filter ][ 'blog-custom-'
										. ( $custom_blog_use_id ? (int) $id : sanitize_title( $title ) ) 
										. ( $from < $to ? "_{$i}" : '')
									] = array(
											'title'   => $from < $to
															// Translators: Make blog style title: "Layout name /X columns/"
															? sprintf( _n( '%1$s /%2$d column/', '%1$s /%2$d columns/', $i, 'confidant'), $title, $i )
															: $title,
											'icon'    => 'images/theme-options/blog-style/custom.png',
											'new_row' => $new_row,
											);
							$new_row = false;
						}
					} else {
						$new_list[ $filter ][ 'blog-custom-'
										. ( $custom_blog_use_id ? (int) $id : sanitize_title( $title ) ) 
									] = $title;
					}
				}
			}
			if ( ! empty( $new_list[ $filter ] ) && count( $new_list[ $filter ] ) > 0 ) {
				$list = confidant_array_merge( $list, $new_list[ $filter ] );
			}
		}
		return $list;
	}
}


// Return id of the custom header or footer for current mode
if ( ! function_exists( 'confidant_get_custom_layout_id' ) ) {
	function confidant_get_custom_layout_id( $type, $layout_style = '' ) {
		$layout_id = 0;
		if ( empty( $layout_style ) ) {
			$layout_style = confidant_get_theme_option( "{$type}_style" );
		}
		$layout_prefix = '';
		if ( strpos( $layout_style, "{$type}-custom-" ) !== false ) {
			$layout_prefix = "{$type}-custom-";
			$layout_cpt = defined( 'TRX_ADDONS_CPT_LAYOUTS_PT' ) ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts';
		} else if ( defined( 'CONFIDANT_FSE_TEMPLATE_PART_PT' ) && strpos( $layout_style, "{$type}-fse-template-" ) !== false ) {
			$layout_prefix = "{$type}-fse-template-";
			$layout_cpt = defined( 'CONFIDANT_FSE_TEMPLATE_PART_PT' ) ? CONFIDANT_FSE_TEMPLATE_PART_PT : 'wp_template_part';
		}
		if ( ! empty( $layout_prefix ) ) {
			$layout_id = str_replace( $layout_prefix, '', $layout_style );
			if ( strpos( $layout_id, '_' ) !== false ) {
				$parts = explode( '_', $layout_id );
				$layout_id = $parts[0];
			}
			if ( 0 == (int)$layout_id ) {
				$post_id = confidant_get_post_id(
					array(
						'name'      => $layout_id,
						'post_type' => $layout_cpt,
					)
				);
				if ( (int)$post_id > 0 ) {
					$layout_id = $post_id;
				}
			}
			if ( (int)$layout_id > 0 ) {
				$layout_id = apply_filters( 'confidant_filter_get_translated_layout', $layout_id );
			}
		}
		return $layout_id;
	}
}

if ( ! function_exists( 'confidant_get_custom_header_id' ) ) {
	function confidant_get_custom_header_id() {
		static $layout_id = -1;
		if ( -1 == $layout_id && confidant_get_theme_option( 'header_type' ) == 'custom' ) {
			$layout_id = confidant_get_custom_layout_id( 'header' );
		}
		return $layout_id;
	}
}

if ( ! function_exists( 'confidant_get_custom_footer_id' ) ) {
	function confidant_get_custom_footer_id() {
		static $layout_id = -1;
		if ( -1 == $layout_id && confidant_get_theme_option( 'footer_type' ) == 'custom' ) {
			$layout_id = confidant_get_custom_layout_id( 'footer' );
		}
		return $layout_id;
	}
}

if ( ! function_exists( 'confidant_get_custom_sidebar_id' ) ) {
	function confidant_get_custom_sidebar_id() {
		static $layout_id = -1;
		if ( -1 == $layout_id && confidant_get_theme_option( 'sidebar_type' ) == 'custom' ) {
			$layout_id = confidant_get_custom_layout_id( 'sidebar' );
		}
		return $layout_id;
	}
}

if ( ! function_exists( 'confidant_get_custom_blog_id' ) ) {
	function confidant_get_custom_blog_id( $style ) {
		static $layout_id = array();
		if ( empty( $layout_id[ $style ] ) ) {
			$layout_id[ $style ] = confidant_get_custom_layout_id( 'blog', $style );
		}
		return $layout_id[ $style ];
	}
}

// Return meta data from custom layout
if ( ! function_exists( 'confidant_get_custom_layout_meta' ) ) {
	function confidant_get_custom_layout_meta( $id ) {
		static $meta = array();
		if ( empty( $meta[ $id ] ) ) {
			$meta[ $id ] = get_post_meta( $id, 'trx_addons_options', true );
		}
		return $meta[ $id ];
	}
}


// Add theme-specific layouts to the list
if ( ! function_exists( 'confidant_trx_addons_default_layouts' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_default_layouts',	'confidant_trx_addons_default_layouts');
	function confidant_trx_addons_default_layouts( $default_layouts = array() ) {
		if ( confidant_storage_isset( 'trx_addons_default_layouts' ) ) {
			$layouts = confidant_storage_get( 'trx_addons_default_layouts' );
		} else {
			include_once confidant_get_file_dir( 'theme-specific/trx_addons-layouts.php' );
			if ( ! isset( $layouts ) || ! is_array( $layouts ) ) {
				$layouts = array();
			} else if ( function_exists( 'trx_addons_url_replace' ) ) {
				// Replace demo-site urls with current site url
				$layouts = trx_addons_url_replace( confidant_storage_get( 'theme_demo_url' ), home_url(), $layouts );
			}
			confidant_storage_set( 'trx_addons_default_layouts', $layouts );
		}
		if ( count( $layouts ) > 0 ) {
			$default_layouts = array_merge( $default_layouts, $layouts );
		}
		return $default_layouts;
	}
}


// Collect created or updated layouts
if ( ! function_exists( 'confidant_trx_addons_create_layout' ) ) {
	//Handler of the add_action( 'trx_addons_action_create_layout', 'confidant_trx_addons_create_layout', 10, 5 );
	function confidant_trx_addons_create_layout( $old_slug, $layout, $args, $new_id, $exists ) {
		if ( empty( $new_id ) ) return;
		global $CONFIDANT_STORAGE;
		if ( ! isset( $CONFIDANT_STORAGE['update_layouts'] ) ) {
			$CONFIDANT_STORAGE['update_layouts'] = array();
		}
		$parts  = explode( '_', $old_slug );
		$type   = $parts[0];
		$old_id = ! empty( $parts[1] ) ? (int) $parts[1] : 0;
		if ( $old_id > 0 && $old_id != $new_id ) {
			$CONFIDANT_STORAGE['update_layouts']["{$type}-custom-{$old_id}"] = "{$type}-custom-{$new_id}";
		}
	}
}


// Replace created or updated layouts in options
if ( ! function_exists( 'confidant_trx_addons_create_layouts' ) ) {
	//Handler of the add_action( 'trx_addons_action_create_layouts', 'confidant_trx_addons_create_layouts', 10, 1 );
	function confidant_trx_addons_create_layouts( $layouts ) {
		global $CONFIDANT_STORAGE;
		if ( isset( $CONFIDANT_STORAGE['update_layouts'] ) ) {
			$options_name = sprintf( 'theme_mods_%s', get_stylesheet() );
			$options      = get_option( $options_name );
			$changed      = false;
			if ( ! empty( $options ) && is_array( $options ) ) {
				foreach ( $options as $k => $v ) {
					if ( is_string( $v ) ) {
						foreach ( $CONFIDANT_STORAGE['update_layouts'] as $old => $new ) {
							if ( $v == $old ) {
								$options[ $k ] = $new;
								$changed = true;
							}
						}
					}
				}
				if ( $changed ) {
					update_option( $options_name, $options );
				}
			}
		}
	}
}


// Add theme-specific components to the plugin's options
if ( ! function_exists( 'confidant_trx_addons_default_components' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_load_options',	'confidant_trx_addons_default_components');
	function confidant_trx_addons_default_components( $options = array() ) {
		// Load components from the theme
		if ( confidant_storage_isset( 'trx_addons_default_components' ) ) {
			$components = confidant_storage_get( 'trx_addons_default_components' );
		} else {
			include_once confidant_get_file_dir( 'theme-specific/trx_addons-components.php' );
			if ( ! isset( $components ) || ! is_array( $components ) ) {
				$components = array();
			}
			confidant_storage_set( 'trx_addons_default_components', $components );
		}
		// Merge components with the plugin's options
		if ( is_array( $options ) ) {
			if ( is_array( $components ) && count( $components ) > 0 ) {
				// If the Components Editor is enabled (dev mode) - saved components are preferred to the theme's components.
				// Otherwise (the demo site or user's site) - theme's components are preferred to the saved components
				//                                            (to allow the theme to add/remove components after the theme update)
				if ( apply_filters( 'trx_addons_filter_components_editor', false ) ) {
					$options = array_merge( $components, $options );
				} else {
					$options = array_merge( $options, $components );
				}
			}
		} else {
			$options = is_array( $components ) ? $components : array();
		}
		// Turn on API of the theme required plugins
		$plugins = confidant_storage_get( 'required_plugins' );
		foreach ( $plugins as $p => $v ) {
			//Disable check, because some components can be added after the plugin's options are saved
			if ( true || isset( $options[ "components_api_{$p}" ] ) ) {
				$options[ "components_api_{$p}" ] = 1;
			}
		}
		return $options;
	}
}


// Add theme-specific options to the post's options
if ( ! function_exists( 'confidant_trx_addons_override_options' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_override_options', 'confidant_trx_addons_override_options');
	function confidant_trx_addons_override_options( $options = array() ) {
		return apply_filters( 'confidant_filter_override_options', $options );
	}
}

// Enqueue custom styles
if ( ! function_exists( 'confidant_trx_addons_layouts_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_layouts_styles' );
	function confidant_trx_addons_layouts_styles() {
		if ( ! confidant_exists_trx_addons() ) {
			$confidant_url = confidant_get_file_url( 'plugins/trx_addons/layouts/layouts.css' );
			if ( '' != $confidant_url ) {
				wp_enqueue_style( 'confidant-trx-addons-layouts', $confidant_url, array(), null );
			}
			$confidant_url = confidant_get_file_url( 'plugins/trx_addons/layouts/layouts.responsive.css' );
			if ( '' != $confidant_url ) {
				wp_enqueue_style( 'confidant-trx-addons-layouts-responsive', $confidant_url, array(), null, confidant_media_for_load_css_responsive( 'trx-addons-layouts' ) );
			}
		}
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'confidant_trx_addons_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_frontend_scripts', 1100 );
	function confidant_trx_addons_frontend_scripts() {
		if ( confidant_is_on( confidant_get_theme_option( 'debug_mode' ) ) ) {
			$confidant_url = confidant_get_file_url( 'plugins/trx_addons/trx_addons.css' );
			if ( '' != $confidant_url ) {
				wp_enqueue_style( 'confidant-trx-addons', $confidant_url, array(), null );
			}
			$confidant_url = confidant_get_file_url( 'plugins/trx_addons/trx_addons.js' );
			if ( '' != $confidant_url ) {
				wp_enqueue_script( 'confidant-trx-addons', $confidant_url, array( 'jquery' ), null, true );
			}
		}
	}
}

// Enqueue responsive styles for frontend
if ( ! function_exists( 'confidant_trx_addons_responsive_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_responsive_styles', 2000 );
	function confidant_trx_addons_responsive_styles() {
		if ( confidant_is_on( confidant_get_theme_option( 'debug_mode' ) ) ) {
			$confidant_url = confidant_get_file_url( 'plugins/trx_addons/trx_addons-responsive.css' );
			if ( '' != $confidant_url ) {
				wp_enqueue_style( 'confidant-trx-addons-responsive', $confidant_url, array(), null, confidant_media_for_load_css_responsive( 'trx-addons' ) );
			}
		}
	}
}

// Enqueue separate styles for frontend
if ( ! function_exists( 'confidant_trx_addons_frontend_scripts_separate' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_frontend_scripts_separate', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_xxx', 'confidant_trx_addons_frontend_scripts_separate', 10, 1 );
	function confidant_trx_addons_frontend_scripts_separate( $force = false ) {
		static $loaded = array();

		if ( apply_filters( 'confidant_filters_separate_trx_addons_styles', false ) ) {

			// If current action is 'trx_addons_action_load_scripts_front_xxx' - load styles for the single component
			if ( current_action() != 'wp_enqueue_scripts' ) {
				$component = str_replace( 'trx_addons_action_load_scripts_front_', '', current_action() );
				if ( empty( $loaded[ $component ] ) && $force === true ) {
					$loaded[ $component ] = true;
					$file = confidant_esc( str_replace( '_', '-', $component ) );
					$confidant_url = confidant_get_file_url( sprintf( 'plugins/trx_addons/components/%s.css', $file ) );
					if ( '' != $confidant_url ) {
						wp_enqueue_style( sprintf( 'confidant-trx-addons-%s', $file ), $confidant_url, array(), null );
					}
				}

			// Else if current action is 'wp_enqueue_scripts' - check all components
			} else {
				$components = confidant_trx_addons_get_separate_components();
				foreach( $components as $component ) {
					if ( empty( $loaded[ $component ] ) && confidant_need_frontend_scripts( $component ) ) {
						$loaded[ $component ] = true;
						$file = confidant_esc( str_replace( '_', '-', $component ) );
						$confidant_url = confidant_get_file_url( sprintf( 'plugins/trx_addons/components/%s.css', $file ) );
						if ( '' != $confidant_url ) {
							wp_enqueue_style( sprintf( 'confidant-trx-addons-%s', $file ), $confidant_url, array(), null );
						}
					}
				}
			}
		}
	}
}

// Enqueue separate styles for frontend
if ( ! function_exists( 'confidant_trx_addons_responsive_styles_separate' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'confidant_trx_addons_responsive_styles_separate', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_xxx', 'confidant_trx_addons_responsive_styles_separate', 10, 1 );
	function confidant_trx_addons_responsive_styles_separate( $force = false ) {
		static $loaded = array();
		
		if ( apply_filters( 'confidant_filters_separate_trx_addons_styles', false ) ) {

			// If current action is 'trx_addons_action_load_scripts_front_xxx' - load styles for the single component
			if ( current_action() != 'wp_enqueue_scripts' ) {
				$component = str_replace( 'trx_addons_action_load_scripts_front_', '', current_action() );
				if ( empty( $loaded[ $component ] ) && $force === true ) {
					$loaded[ $component ] = true;
					$file = confidant_esc( str_replace( '_', '-', $component ) );
					$confidant_url = confidant_get_file_url( sprintf( 'plugins/trx_addons/components/%s-responsive.css', $file ) );
					if ( '' != $confidant_url ) {
						wp_enqueue_style( sprintf( 'confidant-trx-addons-%s-responsive', $file ), $confidant_url, array(), null );
					}
				}

			// Else if current action is 'wp_enqueue_scripts' - check all components
			} else {
				$components = confidant_trx_addons_get_separate_components();
				foreach( $components as $component ) {
					if ( empty( $loaded[ $component ] ) && confidant_need_frontend_scripts( $component ) ) {
						$loaded[ $component ] = true;
						$file = confidant_esc( str_replace( '_', '-', $component ) );
						$confidant_url = confidant_get_file_url( sprintf( 'plugins/trx_addons/components/%s-responsive.css', $file ) );
						if ( '' != $confidant_url ) {
							wp_enqueue_style( sprintf( 'confidant-trx-addons-%s-responsive', $file ), $confidant_url, array(), null );
						}
					}
				}
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'confidant_trx_addons_merge_styles' ) ) {
	//Handler of the add_filter( 'confidant_filter_merge_styles', 'confidant_trx_addons_merge_styles');
	function confidant_trx_addons_merge_styles( $list ) {
		$list[ 'plugins/trx_addons/trx_addons.css' ] = true;
		if ( apply_filters( 'confidant_filters_separate_trx_addons_styles', false ) ) {
			$components = confidant_trx_addons_get_separate_components();
			foreach( $components as $component ) {
				$list[ sprintf( 'plugins/trx_addons/components/%s.css', confidant_esc( str_replace( '_', '-', $component ) ) ) ] = false;
			}
		}
		return $list;
	}
}

// Merge responsive styles
if ( ! function_exists( 'confidant_trx_addons_merge_styles_responsive' ) ) {
	//Handler of the add_filter('confidant_filter_merge_styles_responsive', 'confidant_trx_addons_merge_styles_responsive');
	function confidant_trx_addons_merge_styles_responsive( $list ) {
		$list[ 'plugins/trx_addons/trx_addons-responsive.css' ] = true;
		if ( apply_filters( 'confidant_filters_separate_trx_addons_styles', false ) ) {
			$components = confidant_trx_addons_get_separate_components();
			foreach( $components as $component ) {
				$list[ sprintf( 'plugins/trx_addons/components/%s-responsive.css', confidant_esc( str_replace( '_', '-', $component ) ) ) ] = false;
			}
		}
		return $list;
	}
}

// Merge custom scripts
if ( ! function_exists( 'confidant_trx_addons_merge_scripts' ) ) {
	//Handler of the add_filter('confidant_filter_merge_scripts', 'confidant_trx_addons_merge_scripts');
	function confidant_trx_addons_merge_scripts( $list ) {
		$list[ 'plugins/trx_addons/trx_addons.js' ] = true;
		return $list;
	}
}

// Add theme-specific vars to the SASS files
if ( ! function_exists( 'confidant_trx_addons_sass_import' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_sass_import','confidant_trx_addons_sass_import', 10, 2);
	function confidant_trx_addons_sass_import( $output = '', $file = '' ) {
		if ( strpos( $file, 'vars.scss' ) !== false ) {
			$output .= "\n" . confidant_fgc( confidant_get_file_dir( 'css/_theme-vars.scss' ) )
						. "\n" . confidant_fgc( confidant_get_file_dir( 'css/_skin-vars.scss' ) )
						. "\n";
		}
		return $output;
	}
}

// Enqueue TweenMax on the single posts
if ( ! function_exists( 'confidant_trx_addons_load_tweenmax' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_load_tweenmax', 'confidant_trx_addons_load_tweenmax' );
	function confidant_trx_addons_load_tweenmax( $need ) {
		return $need || ( confidant_is_singular( 'post' ) && (int)confidant_get_theme_option( 'single_parallax', 0 ) > 0 );
	}
}

// Add styles to the list to future load
if ( ! function_exists( 'confidant_trx_addons_load_frontend_scripts' ) ) {
	//Handler of the add_action( 'trx_addons_action_load_scripts_front', 'confidant_trx_addons_load_frontend_scripts', 0, 2 );
	function confidant_trx_addons_load_frontend_scripts( $force = false, $slug = '' ) {
		confidant_storage_set_array( 'enqueue_list', $slug, 1 );
	}
}

// Check if the optimization of the loading css and js is enabled
if ( ! function_exists( 'confidant_optimize_css_and_js_loading' ) ) {
	function confidant_optimize_css_and_js_loading() {
		static $optimize = -1;
		if ( $optimize == -1 ) {
			$optimize = function_exists( 'trx_addons_get_option' )
							? ! trx_addons_is_off( trx_addons_get_option( 'optimize_css_and_js_loading', 'none' ) )
							: false;
		}
		return $optimize;
	}
}

// Check if need to load styles
if ( ! function_exists( 'confidant_need_frontend_scripts' ) ) {
	function confidant_need_frontend_scripts( $slug ) {
		return confidant_optimize_css_and_js_loading()
				? confidant_storage_isset( 'enqueue_list', $slug )
				: confidant_is_on( confidant_get_theme_option( 'debug_mode' ) );
	}
}

// Return list of slugs of ThemeREX components to separate load 
if ( ! function_exists( 'confidant_trx_addons_get_separate_components' ) ) {
	function confidant_trx_addons_get_separate_components() {
		return apply_filters( 'confidant_filters_separate_trx_addons_styles_list', array() );
	}
}


// Return a selector of the tag with a page background
if ( ! function_exists( 'confidant_trx_addons_get_page_background_selector' ) ) {
	//Handler of add_filter( 'trx_addons_filter_page_background_selector', 'confidant_trx_addons_get_page_background_selector' );
	function confidant_trx_addons_get_page_background_selector( $selector = '' ) {
		return 'body:not(.body_style_boxed) .page_content_wrap,body.body_style_boxed .page_wrap';
	}
}


// Plugin API - theme-specific wrappers for plugin functions
//------------------------------------------------------------------------

// Debug functions wrappers
if ( ! function_exists( 'ddo' ) ) {
	function ddo( $obj, $level = -1 ) {
		echo '<pre>' . esc_html( var_export( $obj, true ) ) . '</pre>';
	}
}
if ( ! function_exists( 'dcl' ) ) {
	function dcl( $msg, $level = -1 ) {
		echo '<pre>' . esc_html( $msg ) . '</pre>';
	}
}
if ( ! function_exists( 'dco' ) ) {
	function dco( $obj, $level = -1 ) {
		ddo( $obj );
	}
}
if ( ! function_exists('dcp') ) {
	function dcp( $var ) {
		ob_start();
		print_r( $var );
		$output = ob_get_contents();
		ob_end_clean();
		echo '<pre>' . esc_html( preg_replace( '/[\s]*\([\s]*\)/', '()', str_replace( "\n\n", "\n", $output ) ) ) . '</pre>';
	}
}
if ( ! function_exists( 'dcs' ) ) {
	function dcs( $level = -1 ) {
		$s = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, $level > 0 ? $level : 0 );
		dco( $s, $level );
	}
}
if ( ! function_exists( 'dfo' ) ) {
	function dfo( $obj, $level = -1 ) {}
}
if ( ! function_exists( 'dfl' ) ) {
	function dfl( $msg, $level = -1 ) {}
}

// Check if layouts components are showed or set new state
if ( ! function_exists( 'confidant_sc_layouts_showed' ) ) {
	function confidant_sc_layouts_showed( $name, $val = null ) {
		if ( function_exists( 'trx_addons_sc_layouts_showed' ) ) {
			if ( null !== $val ) {
				trx_addons_sc_layouts_showed( $name, $val );
			} else {
				return trx_addons_sc_layouts_showed( $name );
			}
		} else {
			if ( null !== $val ) {
				confidant_storage_set_array( 'sc_layouts_components', $name, $val );
			} else {
				return confidant_storage_get_array( 'sc_layouts_components', $name );
			}
		}
	}
}

// Return image size multiplier
if ( ! function_exists( 'confidant_get_retina_multiplier' ) ) {
	function confidant_get_retina_multiplier( $force_retina = 0 ) {
		$mult = function_exists( 'trx_addons_get_retina_multiplier' ) ? trx_addons_get_retina_multiplier( $force_retina ) : max( 1, $force_retina );
		return max( 1, $mult );
	}
}

// Return slider layout
if ( ! function_exists( 'confidant_get_slider_layout' ) ) {
	function confidant_get_slider_layout( $args, $images = array() ) {
		return function_exists( 'trx_addons_get_slider_layout' )
					? trx_addons_get_slider_layout( $args, $images )
					: '';
	}
}

// Return slider wrapper first part
if ( ! function_exists( 'confidant_get_slider_wrap_start' ) ) {
	function confidant_get_slider_wrap_start( $sc, $args ) {
		if ( function_exists( 'trx_addons_sc_show_slider_wrap_start' ) ) {
			trx_addons_sc_show_slider_wrap_start( $sc, $args );
		}
	}
}

// Return slider wrapper last part
if ( ! function_exists( 'confidant_get_slider_wrap_end' ) ) {
	function confidant_get_slider_wrap_end( $sc, $args ) {
		if ( function_exists( 'trx_addons_sc_show_slider_wrap_end' ) ) {
			trx_addons_sc_show_slider_wrap_end( $sc, $args );
		}
	}
}

// Return video frame layout
if ( ! function_exists( 'confidant_get_video_layout' ) ) {
	function confidant_get_video_layout( $args ) {
		return function_exists( 'trx_addons_get_video_layout' )
					? trx_addons_get_video_layout( $args )
					: '';
	}
}

// Include theme-specific blog style content
if ( ! function_exists( 'confidant_trx_addons_sc_blogger_template' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_sc_blogger_template', 'confidant_trx_addons_sc_blogger_template', 10, 2);
	function confidant_trx_addons_sc_blogger_template( $result, $args ) {
		if ( ! $result ) {
			$tpl = confidant_blog_item_get_template( $args['type'] );
			if ( '' != $tpl ) {
				$tpl = confidant_get_file_dir( $tpl . '.php' );
				if ( '' != $tpl ) {
					set_query_var( 'confidant_template_args', $args );
					include $tpl;
					set_query_var( 'confidant_template_args', false );
					$result = true;
				}
			}
		}
		return $result;
	}
}


// Redirect theme-specific action 'confidant_action_before_featured' to the plugin
if ( ! function_exists( 'confidant_trx_addons_before_featured_image' ) ) {
	//Handler of the add_action( 'confidant_action_before_featured', 'confidant_trx_addons_before_featured_image' );
	function confidant_trx_addons_before_featured_image() {
		do_action( 'trx_addons_action_before_featured' );
	}
}


// Redirect theme-specific action 'confidant_action_after_featured' to the plugin
if ( ! function_exists( 'confidant_trx_addons_after_featured_image' ) ) {
	//Handler of the add_action( 'confidant_action_after_featured', 'confidant_trx_addons_after_featured_image' );
	function confidant_trx_addons_after_featured_image() {
		do_action( 'trx_addons_action_after_featured' );
	}
}


// Return theme specific layout of the featured image block
if ( ! function_exists( 'confidant_trx_addons_featured_image' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_featured_image', 'confidant_trx_addons_featured_image', 10, 2);
	function confidant_trx_addons_featured_image( $processed = false, $args = array() ) {
		$args['hover'] = confidant_trx_addons_featured_hover( ! isset( $args['hover'] ) ? '!inherit' : $args['hover'] );
		confidant_show_post_featured( $args );
		return true;
	}
}


// Return theme specific hover for the featured image block
if ( ! function_exists( 'confidant_trx_addons_featured_hover' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_featured_hover', 'confidant_trx_addons_featured_hover', 10, 2);
	function confidant_trx_addons_featured_hover( $hover, $sc = '' ) {
		$hover = '' == $hover
					? ''
					: ( '!' == $hover[0] && '!inherit' != $hover
						? substr( $hover, 1 )
						: confidant_get_theme_option( 'image_hover' )
						);
		return $hover;
	}
}

// Redirect filter 'confidant_filter_post_featured_classes' to the plugin
if ( ! function_exists( 'confidant_trx_addons_post_featured_classes' ) ) {
	//Handler of the add_filter( 'confidant_filter_post_featured_classes', 'confidant_trx_addons_post_featured_classes', 10, 3 );
	function confidant_trx_addons_post_featured_classes( $classes, $args, $mode ) {
		return apply_filters( 'trx_addons_filter_post_featured_classes', $classes, $args, $mode );
	}
}

// Redirect filter 'confidant_filter_post_featured_data' to the plugin
if ( ! function_exists( 'confidant_trx_addons_post_featured_data' ) ) {
	//Handler of the add_filter( 'confidant_filter_post_featured_data', 'confidant_trx_addons_post_featured_data', 10, 3 );
	function confidant_trx_addons_post_featured_data( $data, $args, $mode ) {
		return apply_filters( 'trx_addons_filter_post_featured_data', $data, $args, $mode );
	}
}

// Redirect filter 'confidant_filter_args_featured' to the plugin
if ( ! function_exists( 'confidant_trx_addons_args_featured' ) ) {
	//Handler of the add_filter( 'confidant_filter_args_featured', 'confidant_trx_addons_args_featured', 10, 3 );
	function confidant_trx_addons_args_featured( $args, $mode, $template_args ) {
		return apply_filters( 'trx_addons_filter_args_featured', $args, $mode, $template_args );
	}
}

// Return list of plugin specific hovers
if ( ! function_exists( 'confidant_trx_addons_custom_hover_list' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_hovers', 'confidant_trx_addons_custom_hover_list' );
	function confidant_trx_addons_custom_hover_list( $list ) {
		return confidant_array_merge( $list, apply_filters( 'trx_addons_filter_custom_hover_list', array() ) );
	}
}

// Add plugin specific hover icons for the featured image block
if ( ! function_exists( 'confidant_trx_addons_custom_hover_icons' ) ) {
	//Handler of the add_action( 'confidant_action_custom_hover_icons', 'confidant_trx_addons_custom_hover_icons', 10, 2 );
	function confidant_trx_addons_custom_hover_icons( $args = array(), $hover = '' ) {
		do_action( 'trx_addons_action_custom_hover_icons', $args, $hover );
	}
}


// Add theme specific hover for the featured image block
if ( ! function_exists( 'confidant_trx_addons_add_hover_icons' ) ) {
	//Handler of the add_filter( 'trx_addons_action_add_hover_icons', 'confidant_trx_addons_add_hover_icons', 10, 2);
	function confidant_trx_addons_add_hover_icons( $hover, $args = array() ) {
		do_action( 'confidant_action_add_hover_icons', $hover, $args );
	}
}


// Return list of theme-specific hovers
if ( ! function_exists( 'confidant_trx_addons_get_list_sc_image_hover' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_list_sc_image_hover', 'confidant_trx_addons_get_list_sc_image_hover' );
	function confidant_trx_addons_get_list_sc_image_hover( $list ) {
		$list = array_merge(
					array(
						'inherit' => esc_html__('Inherit', 'confidant'),
						'none' => esc_html__('No hover', 'confidant'),
					),
					confidant_get_list_hovers()
		);
		return $list;
	}
}


// Remove some thumb-sizes from the ThemeREX Addons list
if ( ! function_exists( 'confidant_trx_addons_add_thumb_sizes' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_add_thumb_names', 'confidant_trx_addons_add_thumb_sizes');
	//Handler of the add_filter( 'trx_addons_filter_add_thumb_sizes', 'confidant_trx_addons_add_thumb_sizes');
	function confidant_trx_addons_add_thumb_sizes( $list = array() ) {
		if ( is_array( $list ) ) {
			$thumb_sizes = confidant_storage_get( 'theme_thumbs' );
			foreach ( $thumb_sizes as $v ) {
				if ( ! empty( $v['subst'] ) ) {
					if ( isset( $list[ $v['subst'] ] ) ) {
						unset( $list[ $v['subst'] ] );
					}
					if ( isset( $list[ $v['subst'] . '-@retina' ] ) ) {
						unset( $list[ $v['subst'] . '-@retina' ] );
					}
				}
			}
		}
		return $list;
	}
}

// and replace removed styles with theme-specific thumb size
if ( ! function_exists( 'confidant_trx_addons_get_thumb_size' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_thumb_size', 'confidant_trx_addons_get_thumb_size');
	function confidant_trx_addons_get_thumb_size( $thumb_size = '' ) {
		$thumb_sizes = confidant_storage_get( 'theme_thumbs' );
		foreach ( $thumb_sizes as $k => $v ) {
			if ( strpos( $thumb_size, $v['subst'] ) !== false ) {
				$thumb_size = str_replace( $thumb_size, $v['subst'], $k );
				break;
			}
		}
		return $thumb_size;
	}
}

// Return theme-specific video width
if ( ! function_exists( 'confidant_trx_addons_video_width' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_video_width', 'confidant_trx_addons_video_width', 10, 2 );
	function confidant_trx_addons_video_width( $width, $type = 'theme' ) {
		if ( $type == 'theme' ) {
			$width = confidant_get_content_width();
		}
		return $width;
	}
}

// Return theme-specific video size ( width = page - sidebar - gap, height = width / 16 * 9 )
if ( ! function_exists( 'confidant_trx_addons_video_dimensions' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_video_dimensions', 'confidant_trx_addons_video_dimensions', 10, 2 );
	function confidant_trx_addons_video_dimensions( $dim, $ratio = '16:9' ) {
		if ( $ratio == '16:9' ) {
			$parts = explode( ':', apply_filters( 'confidant_filter_video_ratio', $ratio ) );
			$dim['width']  = confidant_get_content_width();
			$dim['height'] = round( $dim['width'] / $parts[0] * $parts[1] );
		}
		return apply_filters( 'confidant_filter_video_dimensions', $dim, $ratio );
	}
}

// If inside "Video list" - reduce dimensions, because controller is present
if ( ! function_exists( 'confidant_trx_addons_video_dimensions_in_video_list' ) ) {
	//Handler of the add_filter( 'confidant_filter_video_dimensions', 'confidant_trx_addons_video_dimensions_in_video_list', 10, 2 );
	function confidant_trx_addons_video_dimensions_in_video_list( $dim, $ratio = '16:9' ) {
		// If inside "Video list" - reduce dimensions, because controller is present
		if ( $ratio == '16:9' && function_exists( 'trx_addons_sc_stack_check' ) && trx_addons_sc_stack_check('trx_widget_video_list') ) {
			$koef = max( 0.5, min( 1, apply_filters( 'confidant_filter_video_list_size_koef', 0.6667 ) ) );
			$dim['width']  = round( $dim['width'] * $koef );
			$dim['height'] = round( $dim['height'] * $koef );
		}
		return $dim;
	}
}


// Return theme specific 'no-image' picture
if ( ! function_exists( 'confidant_trx_addons_no_image' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_no_image', 'confidant_trx_addons_no_image', 10, 3);
	function confidant_trx_addons_no_image( $no_image = '', $need = false, $return_url = true ) {
		return confidant_get_no_image( $no_image, $need, $return_url );
	}
}

// Return theme-specific icons
if ( ! function_exists( 'confidant_trx_addons_get_list_icons_classes' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_list_icons_classes', 'confidant_trx_addons_get_list_icons_classes', 10, 2 );
	function confidant_trx_addons_get_list_icons_classes( $list, $prepend_inherit ) {
		return in_array( confidant_get_theme_setting( 'icons_source' ), array( 'theme', 'both' ) )
					? confidant_get_list_icons( 'icons', $prepend_inherit )
					: $list;
	}
}

// Remove 'icon-' from the name
if ( ! function_exists( 'confidant_trx_addons_clear_icon_name' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_clear_icon_name', 'confidant_trx_addons_clear_icon_name' );
	function confidant_trx_addons_clear_icon_name( $icon ) {
		return substr( $icon, 0, 5 ) == 'icon-' ? substr( $icon, 5 ) : $icon;
	}
}

// Return theme-specific accent color
if ( ! function_exists( 'confidant_trx_addons_get_theme_accent_color' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_theme_accent_color', 'confidant_trx_addons_get_theme_accent_color' );
	function confidant_trx_addons_get_theme_accent_color( $color ) {
		return confidant_get_scheme_color( 'text_link' );
	}
}

// Return theme-specific bg color
if ( ! function_exists( 'confidant_trx_addons_get_theme_bg_color' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_theme_bg_color', 'confidant_trx_addons_get_theme_bg_color' );
	function confidant_trx_addons_get_theme_bg_color( $color ) {
		return confidant_get_scheme_color( 'bg_color' );
	}
}

// Return theme-specific name of color
if ( ! function_exists( 'confidant_trx_addons_get_theme_color_name' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_theme_color_name', 'confidant_trx_addons_get_theme_color_name' );
	function confidant_trx_addons_get_theme_color_name( $color_name ) {
		return confidant_get_scheme_color_name( $color_name );
	}
}

// Return links to the social profiles
if ( ! function_exists( 'confidant_get_socials_links' ) ) {
	function confidant_get_socials_links( $style = 'icons' ) {
		return function_exists( 'trx_addons_get_socials_links' )
					? trx_addons_get_socials_links( $style )
					: '';
	}
}

// Return links to share post
if ( ! function_exists( 'confidant_get_share_links' ) ) {
	function confidant_get_share_links( $args = array() ) {
		return function_exists( 'trx_addons_get_share_links' )
					? trx_addons_get_share_links( $args )
					: '';
	}
}

// Display links to share post
if ( ! function_exists( 'confidant_show_share_links' ) ) {
	function confidant_show_share_links( $args = array() ) {
		if ( function_exists( 'trx_addons_get_share_links' ) ) {
			$args['echo'] = true;
			trx_addons_get_share_links( $args );
		}
	}
}

// Return post icon
if ( ! function_exists( 'confidant_get_post_icon' ) ) {
	function confidant_get_post_icon( $post_id = 0 ) {
		return function_exists( 'trx_addons_get_post_icon' )
					? trx_addons_get_post_icon( $post_id )
					: '';
	}
}

// Return image from the term
if ( ! function_exists( 'confidant_get_term_image' ) ) {
	function confidant_get_term_image( $term_id = 0 ) {
		return function_exists( 'trx_addons_get_term_image' )
					? trx_addons_get_term_image( $term_id )
					: '';
	}
}

// Return small image from the term
if ( ! function_exists( 'confidant_get_term_image_small' ) ) {
	function confidant_get_term_image_small( $term_id = 0 ) {
		return function_exists( 'trx_addons_get_term_image_small' )
					? trx_addons_get_term_image_small( $term_id )
					: '';
	}
}

// Enable/Disable animation effects on mobile devices
if ( ! function_exists( 'confidant_trx_addons_disable_animation_on_mobile' ) ) {
	// Handler of the add_filter( 'trx_addons_filter_disable_animation_on_mobile', 'confidant_trx_addons_disable_animation_on_mobile' );
	function confidant_trx_addons_disable_animation_on_mobile( $disable ) {
		return (int)confidant_get_theme_option( 'disable_animation_on_mobile', 0 ) == 1;
	}
}

// Return list with animation effects
if ( ! function_exists( 'confidant_get_list_animations_in' ) ) {
	function confidant_get_list_animations_in( $prepend_inherit=false ) {
		return function_exists( 'trx_addons_get_list_animations_in' )
					? trx_addons_get_list_animations_in( $prepend_inherit )
					: array( 'none' => esc_html__( '- ThemeREX Addons required -', 'confidant' ) );
	}
}

// Return classes list for the specified animation
if ( ! function_exists( 'confidant_get_animation_classes' ) ) {
	function confidant_get_animation_classes( $animation, $speed = 'normal', $loop = 'none' ) {
		return function_exists( 'trx_addons_get_animation_classes' )
					? trx_addons_get_animation_classes( $animation, $speed, $loop )
					: '';
	}
}

// Return parameter data-post-animation for the posts archive
if (!function_exists('confidant_add_blog_animation')) {
	function confidant_add_blog_animation($args=array()) {
		if ( ! isset( $args['count_extra'] ) ) {
			$animation = '';
			if ( !empty($args['animation'])) {
				$animation = $args['animation'];
			} else if ( ! confidant_is_preview() ) {
				$animation = confidant_get_theme_option( 'blog_animation', 'none' );
			}
			if ( ! confidant_is_off( $animation ) && empty( $args['slider'] ) ) {
				$animation_classes = confidant_get_animation_classes( $animation );
				if ( ! empty( $animation_classes ) ) {
					echo ' data-post-animation="' . esc_attr( $animation_classes ) . '"';
				}
			}
		}
	}
}

// Check if mouse helper is available
if ( ! function_exists( 'confidant_mouse_helper_enabled' ) ) {
	function confidant_mouse_helper_enabled() {
		if ( confidant_exists_trx_addons() ) {
			return trx_addons_check_option( 'mouse_helper' ) ? trx_addons_get_option( 'mouse_helper' ) > 0 : false;
		}
	}
}

// Return string with the likes counter for the specified comment
if ( ! function_exists( 'confidant_get_comment_counters' ) ) {
	function confidant_get_comment_counters( $counters = 'likes' ) {
		return function_exists( 'trx_addons_get_comment_counters' )
					? trx_addons_get_comment_counters( $counters )
					: '';
	}
}

// Display likes counter for the specified comment
if ( ! function_exists( 'confidant_show_comment_counters' ) ) {
	function confidant_show_comment_counters( $counters = 'likes' ) {
		if ( function_exists( 'trx_addons_get_comment_counters' ) ) {
			trx_addons_get_comment_counters( $counters, true );
		}
	}
}

// Add query params to sort posts by views or likes
if ( ! function_exists( 'confidant_trx_addons_add_sort_order' ) ) {
	//Handler of the add_filter('confidant_filter_add_sort_order', 'confidant_trx_addons_add_sort_order', 10, 3);
	function confidant_trx_addons_add_sort_order( $q = array(), $orderby = 'date', $order = 'desc' ) {
		return apply_filters( 'trx_addons_filter_add_sort_order', $q, $orderby, $order );
	}
}

// Return theme-specific logo to the plugin
if ( ! function_exists( 'confidant_trx_addons_theme_logo' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_theme_logo', 'confidant_trx_addons_theme_logo', 10, 2 );
	function confidant_trx_addons_theme_logo( $logo, $type = 'default' ) {
		return confidant_get_logo_image( $type == 'default' ? '' : $type );
	}
}

// Return true, if theme allow use site name as logo
if ( ! function_exists( 'confidant_trx_addons_show_site_name_as_logo' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_show_site_name_as_logo', 'confidant_trx_addons_show_site_name_as_logo');
	function confidant_trx_addons_show_site_name_as_logo( $allow = true ) {
		return $allow && confidant_is_on( confidant_get_theme_option( 'logo_text' ) );
	}
}

// Redirect action to the plugin
if ( ! function_exists( 'confidant_trx_addons_show_post_meta' ) ) {
	//Handler of the add_action( 'confidant_action_show_post_meta', 'confidant_trx_addons_show_post_meta', 10, 3 );
	function confidant_trx_addons_show_post_meta( $meta, $post_id, $args=array() ) {
		do_action( 'trx_addons_action_show_post_meta', $meta, $post_id, $args );
	}
}


// Return theme-specific post meta to the plugin
if ( ! function_exists( 'confidant_trx_addons_post_meta' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_post_meta',	'confidant_trx_addons_post_meta', 10, 2);
	function confidant_trx_addons_post_meta( $meta, $args = array() ) {
		return confidant_show_post_meta( apply_filters( 'confidant_filter_post_meta_args', $args, 'trx_addons', 1 ) );
	}
}

// Return theme-specific post meta args
if ( ! function_exists( 'confidant_trx_addons_post_meta_args' ) ) {
	//Handler of the add_filter( 'confidant_filter_post_meta_args', 'confidant_trx_addons_post_meta_args', 10, 3);
	//Handler of the add_filter( 'trx_addons_filter_post_meta_args', 'confidant_trx_addons_post_meta_get_args', 10, 3);
	function confidant_trx_addons_post_meta_args( $args = array(), $from = '', $columns = 1 ) {
		$theme_specific = ! isset( $args['theme_specific'] ) || $args['theme_specific'];
		if ( ( confidant_is_singular() && 'trx_addons' == $from && $theme_specific ) || empty( $args ) ) {
			$args['components'] = join( ',', confidant_array_get_keys_by_value( confidant_get_theme_option( 'meta_parts' ) ) );
			$args['seo']        = confidant_is_on( confidant_get_theme_option( 'seo_snippets' ) );
		}
		return $args;
	}
}

// Add Rating to the meta parts list
if ( ! function_exists( 'confidant_trx_addons_list_meta_parts' ) ) {
	//Handler of the add_filter( 'confidant_filter_list_meta_parts', 'confidant_trx_addons_list_meta_parts' );
	function confidant_trx_addons_list_meta_parts( $list ) {
		if ( confidant_exists_reviews() ) {
			$list['rating'] = esc_html__( 'Rating', 'confidant' );
		}
		return $list;
	}
}

// Return list of the meta parts
if ( ! function_exists( 'confidant_trx_addons_get_list_meta_parts' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_list_meta_parts', 'confidant_trx_addons_get_list_meta_parts' );
	function confidant_trx_addons_get_list_meta_parts( $list ) {
		return confidant_get_list_meta_parts();
	}
}

// Check if featured image override is allowed
if ( ! function_exists( 'confidant_trx_addons_featured_image_override' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_featured_image_override','confidant_trx_addons_featured_image_override');
	function confidant_trx_addons_featured_image_override( $flag = false ) {
		if ( $flag ) {
			$flag = confidant_is_on( confidant_get_theme_option( 'header_image_override', 0 ) )
					&& apply_filters( 'confidant_filter_allow_override_header_image', true );
		}		
		return $flag;
	}
}

// Return featured image for current mode (post/page/category/blog template ...)
if ( ! function_exists( 'confidant_trx_addons_get_current_mode_image' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_current_mode_image','confidant_trx_addons_get_current_mode_image');
	function confidant_trx_addons_get_current_mode_image( $img = '' ) {
		return confidant_get_current_mode_image( $img );
	}
}


// Return featured image size for related posts
if ( ! function_exists( 'confidant_trx_addons_related_thumb_size' ) ) {
	//Handler of the add_filter( 'confidant_filter_related_thumb_size', 'confidant_trx_addons_related_thumb_size');
	function confidant_trx_addons_related_thumb_size( $size = '' ) {
		if ( defined( 'TRX_ADDONS_CPT_CERTIFICATES_PT' ) && get_post_type() == TRX_ADDONS_CPT_CERTIFICATES_PT ) {
			$size = confidant_get_thumb_size( 'masonry-big' );
		}
		return $size;
	}
}

// Redirect action 'get_mobile_menu' to the plugin
// Return stored items as mobile menu
if ( ! function_exists( 'confidant_trx_addons_get_mobile_menu' ) ) {
	//Handler of the add_filter("confidant_filter_get_mobile_menu", 'confidant_trx_addons_get_mobile_menu');
	function confidant_trx_addons_get_mobile_menu( $menu ) {
		return apply_filters( 'trx_addons_filter_get_mobile_menu', $menu );
	}
}

// Redirect action 'login' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_login' ) ) {
	//Handler of the add_action( 'confidant_action_login', 'confidant_trx_addons_action_login');
	function confidant_trx_addons_action_login( $args = array() ) {
		do_action( 'trx_addons_action_login', $args );
	}
}

// Redirect action 'cart' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_cart' ) ) {
	//Handler of the add_action( 'confidant_action_cart', 'confidant_trx_addons_action_cart');
	function confidant_trx_addons_action_cart( $args = array() ) {
		do_action( 'trx_addons_action_cart', $args );
	}
}

// Redirect action 'product_attributes' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_product_attributes' ) ) {
	//Handler of the add_action( 'confidant_action_product_attributes', 'confidant_trx_addons_action_product_attributes', 10, 1 );
	function confidant_trx_addons_action_product_attributes( $attribute ) {
		do_action( 'trx_addons_action_product_attributes', $attribute );
	}
}

// Redirect action 'search' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_search' ) ) {
	//Handler of the add_action( 'confidant_action_search', 'confidant_trx_addons_action_search', 10, 1);
	function confidant_trx_addons_action_search( $args ) {
		if ( confidant_exists_trx_addons() ) {
			do_action( 'trx_addons_action_search', $args );
		} else {
			set_query_var( 'confidant_search_args', $args );
			get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/search-form' ) );
			set_query_var( 'confidant_search_args', array() );
		}
	}
}

// Redirect filter 'search_form_url' to the plugin
if ( ! function_exists( 'confidant_trx_addons_filter_search_form_url' ) ) {
	//Handler of the add_filter( 'confidant_filter_search_form_url', 'confidant_trx_addons_filter_search_form_url', 10, 1 );
	function confidant_trx_addons_filter_search_form_url( $url ) {
		return apply_filters( 'trx_addons_filter_search_form_url', $url );
	}
}

// Redirect filter 'confidant_filter_options_get_list_choises' to the plugin
if ( ! function_exists( 'confidant_trx_addons_options_get_list_choises' ) ) {
	//Handler of the add_filter( 'confidant_filter_options_get_list_choises', 'confidant_trx_addons_options_get_list_choises', 999, 2 );
	function confidant_trx_addons_options_get_list_choises( $list, $id ) {
		if ( is_array( $list ) && count( $list ) == 0 ) {
			$list = apply_filters( 'trx_addons_filter_options_get_list_choises', $list, $id );
		}
		return $list;
	}
}

// Redirect action 'confidant_action_save_options' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_save_options' ) ) {
	//Handler of the add_action( 'confidant_action_save_options', 'confidant_trx_addons_action_save_options', 1 );
	function confidant_trx_addons_action_save_options() {
		do_action( 'trx_addons_action_save_options_theme' );
	}
}

// Redirect action 'confidant_action_before_body' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_body' ) ) {
	//Handler of the add_action( 'confidant_action_before_body', 'confidant_trx_addons_action_before_body', 1);
	function confidant_trx_addons_action_before_body() {
		do_action( 'trx_addons_action_before_body' );
	}
}

// Redirect action 'confidant_action_page_content_wrap' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_page_content_wrap' ) ) {
	//Handler of the add_action( 'confidant_action_page_content_wrap', 'confidant_trx_addons_action_page_content_wrap', 10, 1 );
	function confidant_trx_addons_action_page_content_wrap( $ajax = false ) {
		do_action( 'trx_addons_action_page_content_wrap', $ajax );
	}
}

// Redirect action 'confidant_action_before_header' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_header' ) ) {
	//Handler of the add_action( 'confidant_action_before_header', 'confidant_trx_addons_action_before_header' );
	function confidant_trx_addons_action_before_header() {
		do_action( 'trx_addons_action_before_header' );
	}
}

// Redirect action 'confidant_action_after_header' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_after_header' ) ) {
	//Handler of the add_action( 'confidant_action_after_header', 'confidant_trx_addons_action_after_header' );
	function confidant_trx_addons_action_after_header() {
		do_action( 'trx_addons_action_after_header' );
	}
}

// Redirect action 'confidant_action_before_footer' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_footer' ) ) {
	//Handler of the add_action( 'confidant_action_before_footer', 'confidant_trx_addons_action_before_footer' );
	function confidant_trx_addons_action_before_footer() {
		do_action( 'trx_addons_action_before_footer' );
	}
}

// Redirect action 'confidant_action_after_footer' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_after_footer' ) ) {
	//Handler of the add_action( 'confidant_action_after_footer', 'confidant_trx_addons_action_after_footer' );
	function confidant_trx_addons_action_after_footer() {
		do_action( 'trx_addons_action_after_footer' );
	}
}

// Redirect action 'confidant_action_before_sidebar_wrap' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_sidebar_wrap' ) ) {
	//Handler of the add_action( 'confidant_action_before_sidebar_wrap', 'confidant_trx_addons_action_before_sidebar_wrap', 10, 1 );
	function confidant_trx_addons_action_before_sidebar_wrap( $sb = '' ) {
		do_action( 'trx_addons_action_before_sidebar_wrap', $sb );
	}
}

// Redirect action 'confidant_action_after_sidebar' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_after_sidebar_wrap' ) ) {
	//Handler of the add_action( 'confidant_action_after_sidebar_wrap', 'confidant_trx_addons_action_after_sidebar_wrap', 10, 1 );
	function confidant_trx_addons_action_after_sidebar_wrap( $sb = '' ) {
		do_action( 'trx_addons_action_after_sidebar_wrap', $sb );
	}
}

// Redirect action 'confidant_action_before_sidebar' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_sidebar' ) ) {
	//Handler of the add_action( 'confidant_action_before_sidebar', 'confidant_trx_addons_action_before_sidebar', 10, 1 );
	function confidant_trx_addons_action_before_sidebar( $sb = '' ) {
		do_action( 'trx_addons_action_before_sidebar', $sb );
	}
}

// Redirect action 'confidant_action_after_sidebar' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_after_sidebar' ) ) {
	//Handler of the add_action( 'confidant_action_after_sidebar', 'confidant_trx_addons_action_after_sidebar', 10, 1 );
	function confidant_trx_addons_action_after_sidebar( $sb = '' ) {
		do_action( 'trx_addons_action_after_sidebar', $sb );
	}
}

// Redirect action 'confidant_action_between_posts' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_between_posts' ) ) {
	//Handler of the add_action( 'confidant_action_between_posts', 'confidant_trx_addons_action_between_posts' );
	function confidant_trx_addons_action_between_posts() {
		do_action( 'trx_addons_action_between_posts' );
	}
}

// Redirect action 'confidant_action_before_post_header' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_post_header' ) ) {
	//Handler of the add_action( 'confidant_action_before_post_header', 'confidant_trx_addons_action_before_post_header' );
	function confidant_trx_addons_action_before_post_header() {
		do_action( 'trx_addons_action_before_post_header' );
	}
}

// Redirect action 'confidant_action_after_post_header' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_after_post_header' ) ) {
	//Handler of the add_action( 'confidant_action_after_post_header', 'confidant_trx_addons_action_after_post_header' );
	function confidant_trx_addons_action_after_post_header() {
		do_action( 'trx_addons_action_after_post_header' );
	}
}

// Redirect action 'confidant_action_before_post_content' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_post_content' ) ) {
	//Handler of the add_action( 'confidant_action_before_post_content', 'confidant_trx_addons_action_before_post_content' );
	function confidant_trx_addons_action_before_post_content() {
		do_action( 'trx_addons_action_before_post_content' );
	}
}

// Redirect action 'confidant_action_after_post_content' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_after_post_content' ) ) {
	//Handler of the add_action( 'confidant_action_after_post_content', 'confidant_trx_addons_action_after_post_content' );
	function confidant_trx_addons_action_after_post_content() {
		do_action( 'trx_addons_action_after_post_content' );
	}
}

// Redirect action 'breadcrumbs' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_breadcrumbs' ) ) {
	//Handler of the add_action( 'confidant_action_breadcrumbs',	'confidant_trx_addons_action_breadcrumbs' );
	function confidant_trx_addons_action_breadcrumbs() {
		do_action( 'trx_addons_action_breadcrumbs' );
	}
}

// Redirect action 'before_single_post_video' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_before_single_post_video' ) ) {
	//Handler of the add_action( 'confidant_action_before_single_post_video', 'confidant_trx_addons_action_before_single_post_video', 10, 1 );
	function confidant_trx_addons_action_before_single_post_video( $args = array() ) {
		do_action( 'trx_addons_action_before_single_post_video', $args );
	}
}

// Redirect action 'after_single_post_video' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_after_single_post_video' ) ) {
	//Handler of the add_action( 'confidant_action_after_single_post_video', 'confidant_trx_addons_action_after_single_post_video', 10, 1 );
	function confidant_trx_addons_action_after_single_post_video( $args = array() ) {
		do_action( 'trx_addons_action_after_single_post_video', $args );
	}
}

// Redirect action 'show_layout' to the plugin
if ( ! function_exists( 'confidant_trx_addons_action_show_layout' ) ) {
	//Handler of the add_action( 'confidant_action_show_layout', 'confidant_trx_addons_action_show_layout', 10, 2 );
	function confidant_trx_addons_action_show_layout( $layout_id = '', $post_id = 0 ) {
		if ( ! apply_filters( 'confidant_filter_custom_layout_shown', false, $layout_id, $post_id ) ) {
			do_action( 'trx_addons_action_show_layout', $layout_id, $post_id );
		}
	}
}

// Redirect action 'before_full_post_content' to the plugin
if ( ! function_exists( 'confidant_trx_addons_before_full_post_content' ) ) {
	//Handler of the add_action( 'confidant_action_before_full_post_content', 'confidant_trx_addons_before_full_post_content' );
	function confidant_trx_addons_before_full_post_content() {
		do_action( 'trx_addons_action_before_full_post_content' );
	}
}

// Redirect action 'after_full_post_content' to the plugin
if ( ! function_exists( 'confidant_trx_addons_after_full_post_content' ) ) {
	//Handler of the add_action( 'confidant_action_after_full_post_content', 'confidant_trx_addons_after_full_post_content' );
	function confidant_trx_addons_after_full_post_content() {
		do_action( 'trx_addons_action_after_full_post_content' );
	}
}

// Redirect filter 'get_translated_layout' to the plugin
if ( ! function_exists( 'confidant_trx_addons_filter_get_translated_layout' ) ) {
	//Handler of the add_filter( 'confidant_filter_get_translated_layout', 'confidant_trx_addons_filter_get_translated_layout', 10, 1);
	function confidant_trx_addons_filter_get_translated_layout( $layout_id = '' ) {
		return apply_filters( 'trx_addons_filter_get_translated_post', $layout_id );
	}
}

// Show user meta (socials)
if ( ! function_exists( 'confidant_trx_addons_action_user_meta' ) ) {
	//Handler of the add_action( 'confidant_action_user_meta', 'confidant_trx_addons_action_user_meta', 10, 1 );
	function confidant_trx_addons_action_user_meta( $from='' ) {
		do_action( 'trx_addons_action_user_meta' );
	}
}

// Redirect filter 'get_blog_title' to the plugin
if ( ! function_exists( 'confidant_trx_addons_get_blog_title' ) ) {
	//Handler of the add_filter( 'confidant_filter_get_blog_title', 'confidant_trx_addons_get_blog_title');
	function confidant_trx_addons_get_blog_title( $title = '' ) {
		return apply_filters( 'trx_addons_filter_get_blog_title', $title );
	}
}

// Return title of the blog archive page
if ( ! function_exists( 'confidant_trx_addons_get_blog_title_from_blog_archive' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_blog_title', 'confidant_trx_addons_get_blog_title_from_blog_archive' );
	function confidant_trx_addons_get_blog_title_from_blog_archive( $title = '' ) {
		$page = confidant_storage_get( 'blog_archive_template_post' );
		if ( is_object( $page ) && ! empty( $page->post_title ) ) {
			$title = apply_filters( 'the_title', $page->post_title, $page->ID );
		}
		return $title;
	}
}

// Redirect filter 'get_post_link' to the plugin
if ( ! function_exists( 'confidant_trx_addons_get_post_link' ) ) {
	//Handler of the add_filter( 'confidant_filter_get_post_link', 'confidant_trx_addons_get_post_link');
	function confidant_trx_addons_get_post_link( $link ) {
		return apply_filters( 'trx_addons_filter_get_post_link', $link );
	}
}


// Redirect filter 'term_name' to the plugin
if ( ! function_exists( 'confidant_trx_addons_term_name' ) ) {
	//Handler of the add_filter( 'confidant_filter_term_name', 'confidant_trx_addons_term_name', 10, 2 );
	function confidant_trx_addons_term_name( $term_name, $taxonomy ) {
		return apply_filters( 'trx_addons_filter_term_name', $term_name, $taxonomy );
	}
}

// Redirect filter 'get_post_iframe' to the plugin
if ( ! function_exists( 'confidant_trx_addons_get_post_iframe' ) ) {
	//Handler of the add_filter( 'confidant_filter_get_post_iframe', 'confidant_trx_addons_get_post_iframe', 10, 1);
	function confidant_trx_addons_get_post_iframe( $html = '' ) {
		return apply_filters( 'trx_addons_filter_get_post_iframe', $html );
	}
}

// Return true, if theme need a SEO snippets
if ( ! function_exists( 'confidant_trx_addons_seo_snippets' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_seo_snippets', 'confidant_trx_addons_seo_snippets');
	function confidant_trx_addons_seo_snippets( $enable = false ) {
		return confidant_is_on( confidant_get_theme_option( 'seo_snippets' ) );
	}
}

// Hide featured image in some post_types
if ( ! function_exists( 'confidant_trx_addons_before_article' ) ) {
	//Handler of the add_action( 'trx_addons_action_before_article', 'confidant_trx_addons_before_article', 10, 1 );
	function confidant_trx_addons_before_article( $page = '' ) {
		if ( in_array( $page, array( 'portfolio.single', 'services.single' ) ) ) {
			if ( (int) confidant_get_theme_option( 'show_featured_image', 1 ) == 0 ) {
				confidant_sc_layouts_showed( 'featured', true );
			}
		}
	}
}

// Show user meta (socials)
if ( ! function_exists( 'confidant_trx_addons_article_start' ) ) {
	//Handler of the add_action( 'trx_addons_action_article_start', 'confidant_trx_addons_article_start', 10, 1);
	function confidant_trx_addons_article_start( $page = '' ) {
		if ( confidant_is_on( confidant_get_theme_option( 'seo_snippets' ) ) ) {
			get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/seo' ) );
		}
	}
}

// Redirect filter 'prepare_css' to the plugin
if ( ! function_exists( 'confidant_trx_addons_prepare_css' ) ) {
	//Handler of the add_filter( 'confidant_filter_prepare_css',	'confidant_trx_addons_prepare_css', 10, 2);
	function confidant_trx_addons_prepare_css( $css = '', $remove_spaces = true ) {
		return apply_filters( 'trx_addons_filter_prepare_css', $css, $remove_spaces );
	}
}

// Redirect filter 'prepare_js' to the plugin
if ( ! function_exists( 'confidant_trx_addons_prepare_js' ) ) {
	//Handler of the add_filter( 'confidant_filter_prepare_js',	'confidant_trx_addons_prepare_js', 10, 2);
	function confidant_trx_addons_prepare_js( $js = '', $remove_spaces = true ) {
		return apply_filters( 'trx_addons_filter_prepare_js', $js, $remove_spaces );
	}
}

// Add plugin's specific variables to the scripts
if ( ! function_exists( 'confidant_trx_addons_localize_script' ) ) {
	//Handler of the add_filter( 'confidant_filter_localize_script',	'confidant_trx_addons_localize_script');
	function confidant_trx_addons_localize_script( $arr ) {
		$arr['trx_addons_exists'] = confidant_exists_trx_addons();
		return $arr;
	}
}

// Redirect filter 'trx_addons_filter_get_theme_file_dir' to the theme
if ( ! function_exists( 'confidant_trx_addons_get_theme_file_dir' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_theme_file_dir', 'confidant_trx_addons_get_theme_file_dir', 10, 3);
	function confidant_trx_addons_get_theme_file_dir( $dir, $file, $return_url ) {
		return apply_filters( 'confidant_filter_get_theme_file_dir', $dir, $file, $return_url );
	}
}

// Redirect filter 'trx_addons_filter_get_theme_folder_dir' to the theme
if ( ! function_exists( 'confidant_trx_addons_get_theme_folder_dir' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_theme_folder_dir', 'confidant_trx_addons_get_theme_folder_dir', 10, 3);
	function confidant_trx_addons_get_theme_folder_dir( $dir, $folder, $return_url ) {
		return apply_filters( 'confidant_filter_get_theme_file_dir', $dir, $folder, $return_url );
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( confidant_exists_trx_addons() ) {
	$confidant_fdir = confidant_get_file_dir( 'plugins/trx_addons/trx_addons-style.php' );
	if ( ! empty( $confidant_fdir ) ) {
		require_once $confidant_fdir;
	}
}
