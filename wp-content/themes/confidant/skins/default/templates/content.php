<?php
/**
 * The default template to display the content of the single post or attachment
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */
?>
<article id="post-<?php the_ID(); ?>"
	<?php
	post_class( 'post_item_single'
		. ' post_type_' . esc_attr( get_post_type() ) 
		. ' post_format_' . esc_attr( str_replace( 'post-format-', '', get_post_format() ) )
	);
	confidant_add_seo_itemprops();
	?>
>
<?php

	do_action( 'confidant_action_before_post_data' );
	confidant_add_seo_snippets();
	do_action( 'confidant_action_after_post_data' );

	do_action( 'confidant_action_before_post_content' );

	// Post content
	$confidant_meta_components = confidant_array_get_keys_by_value( confidant_get_theme_option( 'meta_parts' ) );
	$confidant_share_position  = confidant_array_get_keys_by_value( confidant_get_theme_option( 'share_position' ) );
	?>
	<div class="post_content post_content_single entry-content<?php
		if ( in_array( 'left', $confidant_share_position ) && in_array( 'share', $confidant_meta_components ) ) {
			echo ' post_info_vertical_present' . ( in_array( 'top', $confidant_share_position ) ? ' post_info_vertical_hide_on_mobile' : '' );
		}
	?>" itemprop="mainEntityOfPage">
		<?php
		if ( in_array( 'left', $confidant_share_position ) && in_array( 'share', $confidant_meta_components ) ) {
			?><div class="post_info_vertical<?php
				if ( confidant_get_theme_option( 'share_fixed' ) > 0 ) {
					echo ' post_info_vertical_fixed';
				}
			?>"><?php
				confidant_show_post_meta(
					apply_filters(
						'confidant_filter_post_meta_args',
						array(
							'components'      => 'share',
							'class'           => 'post_share_vertical',
							'share_type'      => 'block',
							'share_direction' => 'vertical',
						),
						'single',
						1
					)
				);
			?></div><?php
		}
		the_content();
		?>
	</div><!-- .entry-content -->
	<?php

	do_action( 'confidant_action_after_post_content' );
	
	// Post footer: Tags, likes, share, author, prev/next links and comments
	do_action( 'confidant_action_before_post_footer' );
	?>
	<div class="post_footer post_footer_single entry-footer">
		<?php
		confidant_show_post_pagination();
		if ( is_single() && ! is_attachment() ) {
			confidant_show_post_footer();
		}
		?>
	</div>
	<?php
	do_action( 'confidant_action_after_post_footer' );
	?>
</article>
