<?php
/**
 * The template to display single post
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

// Full post loading
$full_post_loading          = confidant_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = confidant_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = confidant_get_theme_option( 'posts_navigation_scroll_which_block', 'article' );

// Position of the related posts
$confidant_related_position   = confidant_get_theme_option( 'related_position', 'below_content' );

// Type of the prev/next post navigation
$confidant_posts_navigation   = confidant_get_theme_option( 'posts_navigation' );
$confidant_prev_post          = false;
$confidant_prev_post_same_cat = (int)confidant_get_theme_option( 'posts_navigation_scroll_same_cat', 1 );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( confidant_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	confidant_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'confidant_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $confidant_posts_navigation ) {
		$confidant_prev_post = get_previous_post( $confidant_prev_post_same_cat );  // Get post from same category
		if ( ! $confidant_prev_post && $confidant_prev_post_same_cat ) {
			$confidant_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $confidant_prev_post ) {
			$confidant_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $confidant_prev_post ) ) {
		confidant_sc_layouts_showed( 'featured', false );
		confidant_sc_layouts_showed( 'title', false );
		confidant_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $confidant_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/content', 'single-' . confidant_get_theme_option( 'single_style' ) ), 'single-' . confidant_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $confidant_related_position, 'inside' ) === 0 ) {
		$confidant_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'confidant_action_related_posts' );
		$confidant_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $confidant_related_content ) ) {
			$confidant_related_position_inside = max( 0, min( 9, confidant_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $confidant_related_position_inside ) {
				$confidant_related_position_inside = mt_rand( 1, 9 );
			}

			$confidant_p_number         = 0;
			$confidant_related_inserted = false;
			$confidant_in_block         = false;
			$confidant_content_start    = strpos( $confidant_content, '<div class="post_content' );
			$confidant_content_end      = strrpos( $confidant_content, '</div>' );

			for ( $i = max( 0, $confidant_content_start ); $i < min( strlen( $confidant_content ) - 3, $confidant_content_end ); $i++ ) {
				if ( $confidant_content[ $i ] != '<' ) {
					continue;
				}
				if ( $confidant_in_block ) {
					if ( strtolower( substr( $confidant_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$confidant_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $confidant_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $confidant_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$confidant_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $confidant_content[ $i + 1 ] && in_array( $confidant_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$confidant_p_number++;
					if ( $confidant_related_position_inside == $confidant_p_number ) {
						$confidant_related_inserted = true;
						$confidant_content = ( $i > 0 ? substr( $confidant_content, 0, $i ) : '' )
											. $confidant_related_content
											. substr( $confidant_content, $i );
					}
				}
			}
			if ( ! $confidant_related_inserted ) {
				if ( $confidant_content_end > 0 ) {
					$confidant_content = substr( $confidant_content, 0, $confidant_content_end ) . $confidant_related_content . substr( $confidant_content, $confidant_content_end );
				} else {
					$confidant_content .= $confidant_related_content;
				}
			}
		}

		confidant_show_layout( $confidant_content );
	}

	// Comments
	do_action( 'confidant_action_before_comments' );
	comments_template();
	do_action( 'confidant_action_after_comments' );

	// Related posts
	if ( 'below_content' == $confidant_related_position
		&& ( 'scroll' != $confidant_posts_navigation || (int)confidant_get_theme_option( 'posts_navigation_scroll_hide_related', 0 ) == 0 )
		&& ( ! $full_post_loading || (int)confidant_get_theme_option( 'open_full_post_hide_related', 1 ) == 0 )
	) {
		do_action( 'confidant_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $confidant_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $confidant_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $confidant_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $confidant_prev_post ) ); ?>"
			data-cur-post-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-cur-post-title="<?php the_title_attribute(); ?>"
			<?php do_action( 'confidant_action_nav_links_single_scroll_data', $confidant_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
