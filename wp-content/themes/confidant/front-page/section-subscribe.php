<div class="front_page_section front_page_section_subscribe<?php
	$confidant_scheme = confidant_get_theme_option( 'front_page_subscribe_scheme' );
	if ( ! empty( $confidant_scheme ) && ! confidant_is_inherit( $confidant_scheme ) ) {
		echo ' scheme_' . esc_attr( $confidant_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( confidant_get_theme_option( 'front_page_subscribe_paddings' ) );
	if ( confidant_get_theme_option( 'front_page_subscribe_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$confidant_css      = '';
		$confidant_bg_image = confidant_get_theme_option( 'front_page_subscribe_bg_image' );
		if ( ! empty( $confidant_bg_image ) ) {
			$confidant_css .= 'background-image: url(' . esc_url( confidant_get_attachment_url( $confidant_bg_image ) ) . ');';
		}
		if ( ! empty( $confidant_css ) ) {
			echo ' style="' . esc_attr( $confidant_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$confidant_anchor_icon = confidant_get_theme_option( 'front_page_subscribe_anchor_icon' );
	$confidant_anchor_text = confidant_get_theme_option( 'front_page_subscribe_anchor_text' );
if ( ( ! empty( $confidant_anchor_icon ) || ! empty( $confidant_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_subscribe"'
									. ( ! empty( $confidant_anchor_icon ) ? ' icon="' . esc_attr( $confidant_anchor_icon ) . '"' : '' )
									. ( ! empty( $confidant_anchor_text ) ? ' title="' . esc_attr( $confidant_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_subscribe_inner
	<?php
	if ( confidant_get_theme_option( 'front_page_subscribe_fullheight' ) ) {
		echo ' confidant-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$confidant_css      = '';
			$confidant_bg_mask  = confidant_get_theme_option( 'front_page_subscribe_bg_mask' );
			$confidant_bg_color_type = confidant_get_theme_option( 'front_page_subscribe_bg_color_type' );
			if ( 'custom' == $confidant_bg_color_type ) {
				$confidant_bg_color = confidant_get_theme_option( 'front_page_subscribe_bg_color' );
			} elseif ( 'scheme_bg_color' == $confidant_bg_color_type ) {
				$confidant_bg_color = confidant_get_scheme_color( 'bg_color', $confidant_scheme );
			} else {
				$confidant_bg_color = '';
			}
			if ( ! empty( $confidant_bg_color ) && $confidant_bg_mask > 0 ) {
				$confidant_css .= 'background-color: ' . esc_attr(
					1 == $confidant_bg_mask ? $confidant_bg_color : confidant_hex2rgba( $confidant_bg_color, $confidant_bg_mask )
				) . ';';
			}
			if ( ! empty( $confidant_css ) ) {
				echo ' style="' . esc_attr( $confidant_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_subscribe_content_wrap content_wrap">
			<?php
			// Caption
			$confidant_caption = confidant_get_theme_option( 'front_page_subscribe_caption' );
			if ( ! empty( $confidant_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_subscribe_caption front_page_block_<?php echo ! empty( $confidant_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $confidant_caption, 'confidant_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$confidant_description = confidant_get_theme_option( 'front_page_subscribe_description' );
			if ( ! empty( $confidant_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_subscribe_description front_page_block_<?php echo ! empty( $confidant_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $confidant_description ), 'confidant_kses_content' ); ?></div>
				<?php
			}

			// Content
			$confidant_sc = confidant_get_theme_option( 'front_page_subscribe_shortcode' );
			if ( ! empty( $confidant_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_subscribe_output front_page_block_<?php echo ! empty( $confidant_sc ) ? 'filled' : 'empty'; ?>">
				<?php
					confidant_show_layout( do_shortcode( $confidant_sc ) );
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
