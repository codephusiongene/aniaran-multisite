<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

$confidant_template_args = get_query_var( 'confidant_template_args' );

if ( is_array( $confidant_template_args ) ) {
	$confidant_columns    = empty( $confidant_template_args['columns'] ) ? 2 : max( 1, $confidant_template_args['columns'] );
	$confidant_blog_style = array( $confidant_template_args['type'], $confidant_columns );
    $confidant_columns_class = confidant_get_column_class( 1, $confidant_columns, ! empty( $confidant_template_args['columns_tablet']) ? $confidant_template_args['columns_tablet'] : '', ! empty($confidant_template_args['columns_mobile']) ? $confidant_template_args['columns_mobile'] : '' );
} else {
	$confidant_template_args = array();
	$confidant_blog_style = explode( '_', confidant_get_theme_option( 'blog_style' ) );
	$confidant_columns    = empty( $confidant_blog_style[1] ) ? 2 : max( 1, $confidant_blog_style[1] );
    $confidant_columns_class = confidant_get_column_class( 1, $confidant_columns );
}
$confidant_expanded   = ! confidant_sidebar_present() && confidant_get_theme_option( 'expand_content' ) == 'expand';

$confidant_post_format = get_post_format();
$confidant_post_format = empty( $confidant_post_format ) ? 'standard' : str_replace( 'post-format-', '', $confidant_post_format );

?><div class="<?php
	if ( ! empty( $confidant_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( confidant_is_blog_style_use_masonry( $confidant_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $confidant_columns ) : esc_attr( $confidant_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $confidant_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $confidant_columns )
				. ' post_layout_' . esc_attr( $confidant_blog_style[0] )
				. ' post_layout_' . esc_attr( $confidant_blog_style[0] ) . '_' . esc_attr( $confidant_columns )
	);
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
								: explode( ',', $confidant_template_args['meta_parts'] )
								)
							: confidant_array_get_keys_by_value( confidant_get_theme_option( 'meta_parts' ) );

	confidant_show_post_featured( apply_filters( 'confidant_filter_args_featured',
		array(
			'thumb_size' => ! empty( $confidant_template_args['thumb_size'] )
				? $confidant_template_args['thumb_size']
				: confidant_get_thumb_size(
					'classic' == $confidant_blog_style[0]
						? ( strpos( confidant_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $confidant_columns > 2 ? 'big' : 'huge' )
								: ( $confidant_columns > 2
									? ( $confidant_expanded ? 'square' : 'square' )
									: ($confidant_columns > 1 ? 'square' : ( $confidant_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( confidant_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $confidant_columns > 2 ? 'masonry-big' : 'full' )
								: ($confidant_columns === 1 ? ( $confidant_expanded ? 'huge' : 'big' ) : ( $confidant_columns <= 2 && $confidant_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $confidant_hover,
			'meta_parts' => $confidant_components,
			'no_links'   => ! empty( $confidant_template_args['no_links'] ),
        ),
        'content-classic',
        $confidant_template_args
    ) );

	// Title and post meta
	$confidant_show_title = get_the_title() != '';
	$confidant_show_meta  = count( $confidant_components ) > 0 && ! in_array( $confidant_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $confidant_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'confidant_filter_show_blog_meta', $confidant_show_meta, $confidant_components, 'classic' ) ) {
				if ( count( $confidant_components ) > 0 ) {
					do_action( 'confidant_action_before_post_meta' );
					confidant_show_post_meta(
						apply_filters(
							'confidant_filter_post_meta_args', array(
							'components' => join( ',', $confidant_components ),
							'seo'        => false,
							'echo'       => true,
						), $confidant_blog_style[0], $confidant_columns
						)
					);
					do_action( 'confidant_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'confidant_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'confidant_action_before_post_title' );
				if ( empty( $confidant_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'confidant_action_after_post_title' );
			}

			if( !in_array( $confidant_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'confidant_filter_show_blog_readmore', ! $confidant_show_title || ! empty( $confidant_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $confidant_template_args['no_links'] ) ) {
						do_action( 'confidant_action_before_post_readmore' );
						confidant_show_post_more_link( $confidant_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'confidant_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $confidant_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('confidant_filter_show_blog_excerpt', empty($confidant_template_args['hide_excerpt']) && confidant_get_theme_option('excerpt_length') > 0, 'classic')) {
			confidant_show_post_content($confidant_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $confidant_template_args['more_button'] )) {
			if ( empty( $confidant_template_args['no_links'] ) ) {
				do_action( 'confidant_action_before_post_readmore' );
				confidant_show_post_more_link( $confidant_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'confidant_action_after_post_readmore' );
			}
		}
		$confidant_content = ob_get_contents();
		ob_end_clean();
		confidant_show_layout($confidant_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
