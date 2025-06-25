<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

							do_action( 'confidant_action_page_content_end_text' );
							
							// Widgets area below the content
							confidant_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'confidant_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'confidant_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'confidant_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'confidant_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$confidant_body_style = confidant_get_theme_option( 'body_style' );
					$confidant_widgets_name = confidant_get_theme_option( 'widgets_below_page', 'hide' );
					$confidant_show_widgets = ! confidant_is_off( $confidant_widgets_name ) && is_active_sidebar( $confidant_widgets_name );
					$confidant_show_related = confidant_is_single() && confidant_get_theme_option( 'related_position', 'below_content' ) == 'below_page';
					if ( $confidant_show_widgets || $confidant_show_related ) {
						if ( 'fullscreen' != $confidant_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $confidant_show_related ) {
							do_action( 'confidant_action_related_posts' );
						}

						// Widgets area below page content
						if ( $confidant_show_widgets ) {
							confidant_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $confidant_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'confidant_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'confidant_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! confidant_is_singular( 'post' ) && ! confidant_is_singular( 'attachment' ) ) || ! in_array ( confidant_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="confidant_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'confidant_action_before_footer' );

				// Footer
				$confidant_footer_type = confidant_get_theme_option( 'footer_type' );
				if ( 'custom' == $confidant_footer_type && ! confidant_is_layouts_available() ) {
					$confidant_footer_type = 'default';
				}
				get_template_part( apply_filters( 'confidant_filter_get_template_part', "templates/footer-" . sanitize_file_name( $confidant_footer_type ) ) );

				do_action( 'confidant_action_after_footer' );

			}
			?>

			<?php do_action( 'confidant_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'confidant_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'confidant_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>