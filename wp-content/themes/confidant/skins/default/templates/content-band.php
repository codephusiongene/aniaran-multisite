<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.71.0
 */

$confidant_template_args = get_query_var( 'confidant_template_args' );
if ( ! is_array( $confidant_template_args ) ) {
	$confidant_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$confidant_columns       = 1;

$confidant_expanded      = ! confidant_sidebar_present() && confidant_get_theme_option( 'expand_content' ) == 'expand';

$confidant_post_format   = get_post_format();
$confidant_post_format   = empty( $confidant_post_format ) ? 'standard' : str_replace( 'post-format-', '', $confidant_post_format );

if ( is_array( $confidant_template_args ) ) {
	$confidant_columns    = empty( $confidant_template_args['columns'] ) ? 1 : max( 1, $confidant_template_args['columns'] );
	$confidant_blog_style = array( $confidant_template_args['type'], $confidant_columns );
	if ( ! empty( $confidant_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $confidant_columns > 1 ) {
	    $confidant_columns_class = confidant_get_column_class( 1, $confidant_columns, ! empty( $confidant_template_args['columns_tablet']) ? $confidant_template_args['columns_tablet'] : '', ! empty($confidant_template_args['columns_mobile']) ? $confidant_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $confidant_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $confidant_post_format ) );
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
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $confidant_template_args['thumb_size'] )
								? $confidant_template_args['thumb_size']
								: confidant_get_thumb_size( 
								in_array( $confidant_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( confidant_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $confidant_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$confidant_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$confidant_show_title = get_the_title() != '';
		$confidant_show_meta  = count( $confidant_components ) > 0 && ! in_array( $confidant_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $confidant_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'confidant_filter_show_blog_categories', $confidant_show_meta && in_array( 'categories', $confidant_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'confidant_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						confidant_show_post_meta( apply_filters(
															'confidant_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $confidant_hover, 1
															)
											);
						?>
					</div>
					<?php
					$confidant_components = confidant_array_delete_by_value( $confidant_components, 'categories' );
					do_action( 'confidant_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'confidant_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'confidant_action_before_post_title' );
					if ( empty( $confidant_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'confidant_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $confidant_template_args['excerpt_length'] ) && ! in_array( $confidant_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$confidant_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'confidant_filter_show_blog_excerpt', empty( $confidant_template_args['hide_excerpt'] ) && confidant_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				confidant_show_post_content( $confidant_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'confidant_filter_show_blog_meta', $confidant_show_meta, $confidant_components, 'band' ) ) {
			if ( count( $confidant_components ) > 0 ) {
				do_action( 'confidant_action_before_post_meta' );
				confidant_show_post_meta(
					apply_filters(
						'confidant_filter_post_meta_args', array(
							'components' => join( ',', $confidant_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'confidant_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'confidant_filter_show_blog_readmore', ! $confidant_show_title || ! empty( $confidant_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $confidant_template_args['no_links'] ) ) {
				do_action( 'confidant_action_before_post_readmore' );
				confidant_show_post_more_link( $confidant_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'confidant_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $confidant_template_args ) ) {
	if ( ! empty( $confidant_template_args['slider'] ) || $confidant_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
