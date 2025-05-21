<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.50
 */

$confidant_template_args = get_query_var( 'confidant_template_args' );
if ( is_array( $confidant_template_args ) ) {
	$confidant_columns    = empty( $confidant_template_args['columns'] ) ? 2 : max( 1, $confidant_template_args['columns'] );
	$confidant_blog_style = array( $confidant_template_args['type'], $confidant_columns );
} else {
	$confidant_template_args = array();
	$confidant_blog_style = explode( '_', confidant_get_theme_option( 'blog_style' ) );
	$confidant_columns    = empty( $confidant_blog_style[1] ) ? 2 : max( 1, $confidant_blog_style[1] );
}
$confidant_blog_id       = confidant_get_custom_blog_id( join( '_', $confidant_blog_style ) );
$confidant_blog_style[0] = str_replace( 'blog-custom-', '', $confidant_blog_style[0] );
$confidant_expanded      = ! confidant_sidebar_present() && confidant_get_theme_option( 'expand_content' ) == 'expand';
$confidant_components    = ! empty( $confidant_template_args['meta_parts'] )
							? ( is_array( $confidant_template_args['meta_parts'] )
								? join( ',', $confidant_template_args['meta_parts'] )
								: $confidant_template_args['meta_parts']
								)
							: confidant_array_get_keys_by_value( confidant_get_theme_option( 'meta_parts' ) );
$confidant_post_format   = get_post_format();
$confidant_post_format   = empty( $confidant_post_format ) ? 'standard' : str_replace( 'post-format-', '', $confidant_post_format );

$confidant_blog_meta     = confidant_get_custom_layout_meta( $confidant_blog_id );
$confidant_custom_style  = ! empty( $confidant_blog_meta['scripts_required'] ) ? $confidant_blog_meta['scripts_required'] : 'none';

if ( ! empty( $confidant_template_args['slider'] ) || $confidant_columns > 1 || ! confidant_is_off( $confidant_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $confidant_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( confidant_is_off( $confidant_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $confidant_custom_style ) ) . "-1_{$confidant_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $confidant_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $confidant_columns )
					. ' post_layout_' . esc_attr( $confidant_blog_style[0] )
					. ' post_layout_' . esc_attr( $confidant_blog_style[0] ) . '_' . esc_attr( $confidant_columns )
					. ( ! confidant_is_off( $confidant_custom_style )
						? ' post_layout_' . esc_attr( $confidant_custom_style )
							. ' post_layout_' . esc_attr( $confidant_custom_style ) . '_' . esc_attr( $confidant_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'confidant_action_show_layout', $confidant_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $confidant_template_args['slider'] ) || $confidant_columns > 1 || ! confidant_is_off( $confidant_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
