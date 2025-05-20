<?php
/**
 * The Front Page template file.
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( confidant_is_on( confidant_get_theme_option( 'front_page_enabled', false ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$confidant_sections = confidant_array_get_keys_by_value( confidant_get_theme_option( 'front_page_sections' ) );
		if ( is_array( $confidant_sections ) ) {
			foreach ( $confidant_sections as $confidant_section ) {
				get_template_part( apply_filters( 'confidant_filter_get_template_part', 'front-page/section', $confidant_section ), $confidant_section );
			}
		}

		// Else if this page is a blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'confidant_filter_get_template_part', 'blog' ) );

		// Else - display a native page content
	} else {
		get_template_part( apply_filters( 'confidant_filter_get_template_part', 'page' ) );
	}

	// Else get the template 'index.php' to show posts
} else {
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'index' ) );
}

get_footer();
