<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

$confidant_template_args = get_query_var( 'confidant_template_args' );
$confidant_columns = 1;
if ( is_array( $confidant_template_args ) ) {
	$confidant_columns    = empty( $confidant_template_args['columns'] ) ? 1 : max( 1, $confidant_template_args['columns'] );
	$confidant_blog_style = array( $confidant_template_args['type'], $confidant_columns );
	if ( ! empty( $confidant_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $confidant_columns > 1 ) {
	    $confidant_columns_class = confidant_get_column_class( 1, $confidant_columns, ! empty( $confidant_template_args['columns_tablet']) ? $confidant_template_args['columns_tablet'] : '', ! empty($confidant_template_args['columns_mobile']) ? $confidant_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $confidant_columns_class ); ?>">
		<?php
	}
} else {
	$confidant_template_args = array();
}
$confidant_expanded    = ! confidant_sidebar_present() && confidant_get_theme_option( 'expand_content' ) == 'expand';
$confidant_post_format = get_post_format();
$confidant_post_format = empty( $confidant_post_format ) ? 'standard' : str_replace( 'post-format-', '', $confidant_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $confidant_post_format ) );
	confidant_add_blog_animation( $confidant_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$confidant_hover      = ! empty( $confidant_template_args['hover'] ) && ! confidant_is_inherit( $confidant_template_args['hover'] )
							? $confidant_template_args['hover']
							: confidant_get_theme_option( 'image_hover' );
	$confidant_components = ! empty( $confidant_template_args['meta_parts'] )
							? ( is_array( $confidant_template_args['meta_parts'] )
								? $confidant_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $confidant_template_args['meta_parts'] ) )
								)
							: confidant_array_get_keys_by_value( confidant_get_theme_option( 'meta_parts' ) );
	confidant_show_post_featured( apply_filters( 'confidant_filter_args_featured',
		array(
			'no_links'   => ! empty( $confidant_template_args['no_links'] ),
			'hover'      => $confidant_hover,
			'meta_parts' => $confidant_components,
			'thumb_size' => ! empty( $confidant_template_args['thumb_size'] )
							? $confidant_template_args['thumb_size']
							: confidant_get_thumb_size( strpos( confidant_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $confidant_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$confidant_template_args
	) );

	// Title and post meta
	$confidant_show_title = get_the_title() != '';
	$confidant_show_meta  = count( $confidant_components ) > 0 && ! in_array( $confidant_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $confidant_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'confidant_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'confidant_action_before_post_title' );
				if ( empty( $confidant_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'confidant_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'confidant_filter_show_blog_excerpt', empty( $confidant_template_args['hide_excerpt'] ) && confidant_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'confidant_filter_show_blog_meta', $confidant_show_meta, $confidant_components, 'excerpt' ) ) {
				if ( count( $confidant_components ) > 0 ) {
					do_action( 'confidant_action_before_post_meta' );
					confidant_show_post_meta(
						apply_filters(
							'confidant_filter_post_meta_args', array(
								'components' => join( ',', $confidant_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'confidant_action_after_post_meta' );
				}
			}

			if ( confidant_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'confidant_action_before_full_post_content' );
					the_content( '' );
					do_action( 'confidant_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'confidant' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'confidant' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				confidant_show_post_content( $confidant_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'confidant_filter_show_blog_readmore',  ! isset( $confidant_template_args['more_button'] ) || ! empty( $confidant_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $confidant_template_args['no_links'] ) ) {
					do_action( 'confidant_action_before_post_readmore' );
					if ( confidant_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						confidant_show_post_more_link( $confidant_template_args, '<p>', '</p>' );
					} else {
						confidant_show_post_comments_link( $confidant_template_args, '<p>', '</p>' );
					}
					do_action( 'confidant_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $confidant_template_args ) ) {
	if ( ! empty( $confidant_template_args['slider'] ) || $confidant_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
