<?php
/**
 * The template to display the 404 page
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

get_header();

get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/content', '404' ), '404' );

get_footer();
