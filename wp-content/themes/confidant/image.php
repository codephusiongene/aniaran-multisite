<?php
/**
 * The template to display the attachment
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/content', 'single-' . confidant_get_theme_option( 'single_style' ) ), 'single-' . confidant_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$confidant_posts_navigation = confidant_get_theme_option( 'posts_navigation' );
	if ( 'links' == $confidant_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! confidant_is_off( confidant_get_theme_option( 'posts_navigation_fixed', 0 ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'confidant_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'confidant' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'confidant' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'confidant_action_before_comments' );
	comments_template();
	do_action( 'confidant_action_after_comments' );
}

get_footer();
