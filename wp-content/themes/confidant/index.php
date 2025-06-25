<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

$confidant_template = apply_filters( 'confidant_filter_get_template_part', confidant_blog_archive_get_template() );

if ( ! empty( $confidant_template ) && 'index' != $confidant_template ) {

	get_template_part( $confidant_template );

} else {

	confidant_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$confidant_stickies   = is_home()
								|| ( in_array( confidant_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) confidant_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$confidant_post_type  = confidant_get_theme_option( 'post_type' );
		$confidant_args       = array(
								'blog_style'     => confidant_get_theme_option( 'blog_style' ),
								'post_type'      => $confidant_post_type,
								'taxonomy'       => confidant_get_post_type_taxonomy( $confidant_post_type ),
								'parent_cat'     => confidant_get_theme_option( 'parent_cat' ),
								'posts_per_page' => confidant_get_theme_option( 'posts_per_page' ),
								'sticky'         => confidant_get_theme_option( 'sticky_style', 'inherit' ) == 'columns'
															&& is_array( $confidant_stickies )
															&& count( $confidant_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		confidant_blog_archive_start();

		do_action( 'confidant_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'confidant_action_before_page_author' );
			get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'confidant_action_after_page_author' );
		}

		if ( confidant_get_theme_option( 'show_filters', 0 ) ) {
			do_action( 'confidant_action_before_page_filters' );
			confidant_show_filters( $confidant_args );
			do_action( 'confidant_action_after_page_filters' );
		} else {
			do_action( 'confidant_action_before_page_posts' );
			confidant_show_posts( array_merge( $confidant_args, array( 'cat' => $confidant_args['parent_cat'] ) ) );
			do_action( 'confidant_action_after_page_posts' );
		}

		do_action( 'confidant_action_blog_archive_end' );

		confidant_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
