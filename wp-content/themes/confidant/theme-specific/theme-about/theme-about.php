<?php
/**
 * Information about this theme
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.30
 */


if ( ! function_exists( 'confidant_about_after_switch_theme' ) ) {
	add_action( 'after_switch_theme', 'confidant_about_after_switch_theme', 1000 );
	/**
	 * Update option 'confidant_about_page' after switch a theme to redirect to the page 'About Theme' on next page load.
	 *
	 * Hooks: add_action( 'after_switch_theme', 'confidant_about_after_switch_theme', 1000 );
	 */
	function confidant_about_after_switch_theme() {
		update_option( 'confidant_about_page', 1 );
	}
}

if ( ! function_exists( 'confidant_about_after_setup_theme' ) ) {
	add_action( 'init', 'confidant_about_after_setup_theme', 1000 );
	/**
	 * Redirect to the page 'About Theme' after switch a theme.
	 *
	 * Hooks: add_action( 'init', 'confidant_about_after_setup_theme', 1000 );
	 */
	function confidant_about_after_setup_theme() {
		if ( ! defined( 'WP_CLI' ) && get_option( 'confidant_about_page' ) == 1 ) {
			update_option( 'confidant_about_page', 0 );
			wp_safe_redirect( admin_url() . 'themes.php?page=confidant_about' );
			exit();
		} else {
			if ( confidant_get_value_gp( 'page' ) == 'confidant_about' && confidant_exists_trx_addons() ) {
				wp_safe_redirect( admin_url() . 'admin.php?page=trx_addons_theme_panel' );
				exit();
			}
		}
	}
}

if ( ! function_exists( 'confidant_about_add_menu_items' ) ) {
	add_action( 'admin_menu', 'confidant_about_add_menu_items' );
	/**
	 * Add the item 'About Theme' to the admin menu 'Appearance'.
	 *
	 * Hooks: add_action( 'admin_menu', 'confidant_about_add_menu_items' );
	 */
	function confidant_about_add_menu_items() {
		if ( ! confidant_exists_trx_addons() ) {
			$theme_slug  = get_template();
			$theme_name  = wp_get_theme( $theme_slug )->get( 'Name' ) . ( CONFIDANT_THEME_FREE ? ' ' . esc_html__( 'Free', 'confidant' ) : '' );
			add_theme_page(
				// Translators: Add theme name to the page title
				sprintf( esc_html__( 'About %s', 'confidant' ), $theme_name ),    //page_title
				// Translators: Add theme name to the menu title
				sprintf( esc_html__( 'About %s', 'confidant' ), $theme_name ),    //menu_title
				'manage_options',                                               //capability
				'confidant_about',                                                //menu_slug
				'confidant_about_page_builder'                                    //callback
			);
		}
	}
}

if ( ! function_exists( 'confidant_about_enqueue_scripts' ) ) {
	add_action( 'admin_enqueue_scripts', 'confidant_about_enqueue_scripts' );
	/**
	 * Load a page-specific scripts and styles for the page 'About'
	 *
	 * Hooks: add_action( 'admin_enqueue_scripts', 'confidant_about_enqueue_scripts' );
	 */
	function confidant_about_enqueue_scripts() {
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;
		if ( ! empty( $screen->id ) && false !== strpos( $screen->id, '_page_confidant_about' ) ) {
			// Scripts
			if ( ! confidant_exists_trx_addons() && function_exists( 'confidant_plugins_installer_enqueue_scripts' ) ) {
				confidant_plugins_installer_enqueue_scripts();
			}
			// Styles
			$fdir = confidant_get_file_url( 'theme-specific/theme-about/theme-about.css' );
			if ( '' != $fdir ) {
				wp_enqueue_style( 'confidant-about', $fdir, array(), null );
			}
		}
	}
}

if ( ! function_exists( 'confidant_about_page_builder' ) ) {
	/**
	 * Build the page 'About Theme'
	 */
	function confidant_about_page_builder() {
		$theme_slug = get_template();
		$theme      = wp_get_theme( $theme_slug );
		?>
		<div class="confidant_about">

			<?php do_action( 'confidant_action_theme_about_start', $theme ); ?>

			<?php do_action( 'confidant_action_theme_about_before_logo', $theme ); ?>

			<div class="confidant_about_logo">
				<?php
				$logo = confidant_get_file_url( 'theme-specific/theme-about/icon.jpg' );
				if ( empty( $logo ) ) {
					$logo = confidant_get_file_url( 'screenshot.jpg' );
				}
				if ( ! empty( $logo ) ) {
					?>
					<img src="<?php echo esc_url( $logo ); ?>">
					<?php
				}
				?>
			</div>

			<?php do_action( 'confidant_action_theme_about_before_title', $theme ); ?>

			<h1 class="confidant_about_title">
			<?php
				echo esc_html(
					sprintf(
						// Translators: Add theme name and version to the 'Welcome' message
						__( 'Welcome to %1$s %2$s v.%3$s', 'confidant' ),
						$theme->get( 'Name' ),
						CONFIDANT_THEME_FREE ? __( 'Free', 'confidant' ) : '',
						$theme->get( 'Version' )
					)
				);
			?>
			</h1>

			<?php do_action( 'confidant_action_theme_about_before_description', $theme ); ?>

			<div class="confidant_about_description">
				<p>
					<?php
					echo wp_kses_data( __( 'In order to continue, please install and activate <b>ThemeREX Addons plugin</b>.', 'confidant' ) );
					?>
					<sup>*</sup>
				</p>
			</div>

			<?php do_action( 'confidant_action_theme_about_before_buttons', $theme ); ?>

			<div class="confidant_about_buttons">
				<?php confidant_plugins_installer_get_button_html( 'trx_addons' ); ?>
			</div>

			<?php do_action( 'confidant_action_theme_about_before_buttons', $theme ); ?>

			<div class="confidant_about_notes">
				<p>
					<sup>*</sup>
					<?php
					echo wp_kses_data( __( "<i>ThemeREX Addons plugin</i> will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options.", 'confidant' ) );
					?>
				</p>
			</div>

			<?php do_action( 'confidant_action_theme_about_end', $theme ); ?>

		</div>
		<?php
	}
}

if ( ! function_exists( 'confidant_about_page_disable_tgmpa_notice' ) ) {
	add_filter( 'tgmpa_show_admin_notice_capability', 'confidant_about_page_disable_tgmpa_notice' );
	/**
	 * Hide a TGMPA notice on the page 'About Theme'
	 *
	 * @param $cap  Capability of the current page.
	 *
	 * @return string  A filtered capability.
	 */
	function confidant_about_page_disable_tgmpa_notice($cap) {
		if ( confidant_get_value_gp( 'page' ) == 'confidant_about' ) {
			$cap = 'unfiltered_upload';
		}
		return $cap;
	}
}

require_once CONFIDANT_THEME_DIR . 'includes/plugins-installer/plugins-installer.php';
