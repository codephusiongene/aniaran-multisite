<div class="front_page_section front_page_section_features<?php
	$confidant_scheme = confidant_get_theme_option( 'front_page_features_scheme' );
	if ( ! empty( $confidant_scheme ) && ! confidant_is_inherit( $confidant_scheme ) ) {
		echo ' scheme_' . esc_attr( $confidant_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( confidant_get_theme_option( 'front_page_features_paddings' ) );
	if ( confidant_get_theme_option( 'front_page_features_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$confidant_css      = '';
		$confidant_bg_image = confidant_get_theme_option( 'front_page_features_bg_image' );
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
	$confidant_anchor_icon = confidant_get_theme_option( 'front_page_features_anchor_icon' );
	$confidant_anchor_text = confidant_get_theme_option( 'front_page_features_anchor_text' );
if ( ( ! empty( $confidant_anchor_icon ) || ! empty( $confidant_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_features"'
									. ( ! empty( $confidant_anchor_icon ) ? ' icon="' . esc_attr( $confidant_anchor_icon ) . '"' : '' )
									. ( ! empty( $confidant_anchor_text ) ? ' title="' . esc_attr( $confidant_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_features_inner
	<?php
	if ( confidant_get_theme_option( 'front_page_features_fullheight' ) ) {
		echo ' confidant-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$confidant_css      = '';
			$confidant_bg_mask  = confidant_get_theme_option( 'front_page_features_bg_mask' );
			$confidant_bg_color_type = confidant_get_theme_option( 'front_page_features_bg_color_type' );
			if ( 'custom' == $confidant_bg_color_type ) {
				$confidant_bg_color = confidant_get_theme_option( 'front_page_features_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_features_content_wrap content_wrap">
			<?php
			// Caption
			$confidant_caption = confidant_get_theme_option( 'front_page_features_caption' );
			if ( ! empty( $confidant_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_features_caption front_page_block_<?php echo ! empty( $confidant_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $confidant_caption, 'confidant_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$confidant_description = confidant_get_theme_option( 'front_page_features_description' );
			if ( ! empty( $confidant_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_features_description front_page_block_<?php echo ! empty( $confidant_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $confidant_description ), 'confidant_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_features_output">
				<?php
				if ( is_active_sidebar( 'front_page_features_widgets' ) ) {
					dynamic_sidebar( 'front_page_features_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! confidant_exists_trx_addons() ) {
						confidant_customizer_need_trx_addons_message();
					} else {
						confidant_customizer_need_widgets_message( 'front_page_features_caption', 'ThemeREX Addons - Services' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
