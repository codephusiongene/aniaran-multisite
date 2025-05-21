<?php
/**
 * The Portfolio template to display the content
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

$confidant_post_format = get_post_format();
$confidant_post_format = empty( $confidant_post_format ) ? 'standard' : str_replace( 'post-format-', '', $confidant_post_format );

?><div class="
<?php
if ( ! empty( $confidant_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( confidant_is_blog_style_use_masonry( $confidant_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $confidant_columns ) : esc_attr( $confidant_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $confidant_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $confidant_columns )
		. ( 'portfolio' != $confidant_blog_style[0] ? ' ' . esc_attr( $confidant_blog_style[0] )  . '_' . esc_attr( $confidant_columns ) : '' )
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

	$confidant_hover   = ! empty( $confidant_template_args['hover'] ) && ! confidant_is_inherit( $confidant_template_args['hover'] )
								? $confidant_template_args['hover']
								: confidant_get_theme_option( 'image_hover' );

	if ( 'dots' == $confidant_hover ) {
		$confidant_post_link = empty( $confidant_template_args['no_links'] )
								? ( ! empty( $confidant_template_args['link'] )
									? $confidant_template_args['link']
									: get_permalink()
									)
								: '';
		$confidant_target    = ! empty( $confidant_post_link ) && confidant_is_external_url( $confidant_post_link )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$confidant_components = ! empty( $confidant_template_args['meta_parts'] )
							? ( is_array( $confidant_template_args['meta_parts'] )
								? $confidant_template_args['meta_parts']
								: explode( ',', $confidant_template_args['meta_parts'] )
								)
							: confidant_array_get_keys_by_value( confidant_get_theme_option( 'meta_parts' ) );

	// Featured image
	confidant_show_post_featured( apply_filters( 'confidant_filter_args_featured',
        array(
			'hover'         => $confidant_hover,
			'no_links'      => ! empty( $confidant_template_args['no_links'] ),
			'thumb_size'    => ! empty( $confidant_template_args['thumb_size'] )
								? $confidant_template_args['thumb_size']
								: confidant_get_thumb_size(
									confidant_is_blog_style_use_masonry( $confidant_blog_style[0] )
										? (	strpos( confidant_get_theme_option( 'body_style' ), 'full' ) !== false || $confidant_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( confidant_get_theme_option( 'body_style' ), 'full' ) !== false || $confidant_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => confidant_is_blog_style_use_masonry( $confidant_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $confidant_components,
			'class'         => 'dots' == $confidant_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $confidant_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $confidant_post_link )
												? '<a href="' . esc_url( $confidant_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $confidant_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $confidant_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $confidant_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!