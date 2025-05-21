<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.06
 */

$confidant_header_css   = '';
$confidant_header_image = get_header_image();
$confidant_header_video = confidant_get_header_video();
if ( ! empty( $confidant_header_image ) && confidant_trx_addons_featured_image_override( is_singular() || confidant_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$confidant_header_image = confidant_get_current_mode_image( $confidant_header_image );
}

$confidant_header_id = confidant_get_custom_header_id();
$confidant_header_meta = get_post_meta( $confidant_header_id, 'trx_addons_options', true );
if ( ! empty( $confidant_header_meta['margin'] ) ) {
	confidant_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( confidant_prepare_css_value( $confidant_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $confidant_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $confidant_header_id ) ) ); ?>
				<?php
				echo ! empty( $confidant_header_image ) || ! empty( $confidant_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
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

	// Custom header's layout
	do_action( 'confidant_action_show_layout', $confidant_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
