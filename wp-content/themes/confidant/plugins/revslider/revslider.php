<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'confidant_revslider_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'confidant_revslider_theme_setup9', 9 );
	function confidant_revslider_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'confidant_filter_tgmpa_required_plugins', 'confidant_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'confidant_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('confidant_filter_tgmpa_required_plugins',	'confidant_revslider_tgmpa_required_plugins');
	function confidant_revslider_tgmpa_required_plugins( $list = array() ) {
		if ( confidant_storage_isset( 'required_plugins', 'revslider' ) && confidant_storage_get_array( 'required_plugins', 'revslider', 'install' ) !== false && confidant_is_theme_activated() ) {
			$path = confidant_get_plugin_source_path( 'plugins/revslider/revslider.zip' );
			if ( ! empty( $path ) || confidant_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => confidant_storage_get_array( 'required_plugins', 'revslider', 'title' ),
					'slug'     => 'revslider',
					'source'   => ! empty( $path ) ? $path : 'upload://revslider.zip',
					'version'  => '6.4.11',
					'required' => false,
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( ! function_exists( 'confidant_exists_revslider' ) ) {
	function confidant_exists_revslider() {
		return function_exists( 'rev_slider_shortcode' ) || class_exists( 'RevSliderData' );
	}
}


// Allow loading RevSlider scripts and styles
// if it present in the content of the current page
if (!function_exists('confidant_revslider_check_revslider_in_content')) {
	add_filter( 'revslider_include_libraries', 'confidant_revslider_check_revslider_in_content' );
	function confidant_revslider_check_revslider_in_content( $load ) {
		if ( ! $load && function_exists( 'trx_addons_check_revslider_in_content' ) && confidant_is_layouts_available() ) {
			// Check slider in the page header
			if ( apply_filters( 'confidant_filter_check_revslider_in_header', true ) ) {
				$header_type = confidant_get_theme_option( 'header_type' );
				if ( 'custom' == $header_type ) {
					$header_id = confidant_get_custom_header_id();
					if ( $header_id > 0 ) {
						$load = trx_addons_check_revslider_in_content( false, $header_id );
					}
				}
			}
			// Check slider in the page footer
			if ( apply_filters( 'confidant_filter_check_revslider_in_footer', false ) ) {
				$footer_type = confidant_get_theme_option( 'footer_type' );
				if ( 'custom' == $footer_type ) {
					$footer_id = confidant_get_custom_footer_id();
					if ( $footer_id > 0 ) {
						$load = trx_addons_check_revslider_in_content( false, $footer_id );
					}
				}
			}
		}
		return $load;
	}
}
