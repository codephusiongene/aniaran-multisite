<?php
/**
 * The default template to displaying related posts
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.54
 */

$confidant_link        = get_permalink();
$confidant_post_format = get_post_format();
$confidant_post_format = empty( $confidant_post_format ) ? 'standard' : str_replace( 'post-format-', '', $confidant_post_format );
?><div id="post-<?php the_ID(); ?>" <?php post_class( 'related_item post_format_' . esc_attr( $confidant_post_format ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php
	confidant_show_post_featured(
		array(
			'thumb_size' => apply_filters( 'confidant_filter_related_thumb_size', confidant_get_thumb_size( (int) confidant_get_theme_option( 'related_posts' ) == 1 ? 'huge' : 'big' ) ),
		)
	);
	?>
	<div class="post_header entry-header">
		<h6 class="post_title entry-title"><a href="<?php echo esc_url( $confidant_link ); ?>"><?php
			if ( '' == get_the_title() ) {
				esc_html_e( '- No title -', 'confidant' );
			} else {
				the_title();
			}
		?></a></h6>
		<?php
		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			?>
			<span class="post_date"><a href="<?php echo esc_url( $confidant_link ); ?>"><?php echo wp_kses_data( confidant_get_date() ); ?></a></span>
			<?php
		}
		?>
	</div>
</div>
