<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

$confidant_link        = get_permalink();
$confidant_post_format = get_post_format();
$confidant_post_format = empty( $confidant_post_format ) ? 'standard' : str_replace( 'post-format-', '', $confidant_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $confidant_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	confidant_show_post_featured(
		array(
			'thumb_size'    => apply_filters( 'confidant_filter_related_thumb_size', confidant_get_thumb_size( (int) confidant_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
			'post_info'     => '<div class="post_header entry-header">'
									. '<div class="post_categories">' . wp_kses( confidant_get_post_categories( '' ), 'confidant_kses_content' ) . '</div>'
									. '<h6 class="post_title entry-title"><a href="' . esc_url( $confidant_link ) . '">'
										. wp_kses_data( '' == get_the_title() ? esc_html__( '- No title -', 'confidant' ) : get_the_title() )
									. '</a></h6>'
									. ( in_array( get_post_type(), array( 'post', 'attachment' ) )
											? '<div class="post_meta"><a href="' . esc_url( $confidant_link ) . '" class="post_meta_item post_date">' . wp_kses_data( confidant_get_date() ) . '</a></div>'
											: '' )
								. '</div>',
		)
	);
	?>
</div>
