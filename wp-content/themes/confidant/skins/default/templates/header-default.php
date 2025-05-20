<?php
/**
 * The template to display default site header
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

$confidant_header_css   = '';
$confidant_header_image = get_header_image();
$confidant_header_video = confidant_get_header_video();
if ( ! empty( $confidant_header_image ) && confidant_trx_addons_featured_image_override( is_singular() || confidant_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$confidant_header_image = confidant_get_current_mode_image( $confidant_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $confidant_header_image ) || ! empty( $confidant_header_video ) ? ' with_bg_image' : ' without_bg_image';
	if ( '' != $confidant_header_video ) {
		echo ' with_bg_video';
	}
	if ( '' != $confidant_header_image ) {
		echo ' ' . esc_attr( confidant_add_inline_css_class( 'background-image: url(' . esc_url( $confidant_header_image ) . ');' ) );
	}
	if ( is_single() && has_post_thumbnail() ) {
		echo ' with_featured_image';
	}
	if ( confidant_is_on( confidant_get_theme_option( 'header_fullheight' ) ) ) {
		echo ' header_fullheight confidant-full-height';
	}
	$confidant_header_scheme = confidant_get_theme_option( 'header_scheme' );
	if ( ! empty( $confidant_header_scheme ) && ! confidant_is_inherit( $confidant_header_scheme  ) ) {
		echo ' scheme_' . esc_attr( $confidant_header_scheme );
	}
	?>
">
	<?php

	// Background video
	if ( ! empty( $confidant_header_video ) ) {
		get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-video' ) );
	}

	// Main menu
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( confidant_is_on( confidant_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
