<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

// Page (category, tag, archive, author) title

if ( confidant_need_page_title() ) {
	confidant_sc_layouts_showed( 'title', true );
	confidant_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								confidant_show_post_meta(
									apply_filters(
										'confidant_filter_post_meta_args', array(
											'components' => join( ',', confidant_array_get_keys_by_value( confidant_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', confidant_array_get_keys_by_value( confidant_get_theme_option( 'counters' ) ) ),
											'seo'        => confidant_is_on( confidant_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$confidant_blog_title           = confidant_get_blog_title();
							$confidant_blog_title_text      = '';
							$confidant_blog_title_class     = '';
							$confidant_blog_title_link      = '';
							$confidant_blog_title_link_text = '';
							if ( is_array( $confidant_blog_title ) ) {
								$confidant_blog_title_text      = $confidant_blog_title['text'];
								$confidant_blog_title_class     = ! empty( $confidant_blog_title['class'] ) ? ' ' . $confidant_blog_title['class'] : '';
								$confidant_blog_title_link      = ! empty( $confidant_blog_title['link'] ) ? $confidant_blog_title['link'] : '';
								$confidant_blog_title_link_text = ! empty( $confidant_blog_title['link_text'] ) ? $confidant_blog_title['link_text'] : '';
							} else {
								$confidant_blog_title_text = $confidant_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $confidant_blog_title_class ); ?>">
								<?php
								$confidant_top_icon = confidant_get_term_image_small();
								if ( ! empty( $confidant_top_icon ) ) {
									$confidant_attr = confidant_getimagesize( $confidant_top_icon );
									?>
									<img src="<?php echo esc_url( $confidant_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'confidant' ); ?>"
										<?php
										if ( ! empty( $confidant_attr[3] ) ) {
											confidant_show_layout( $confidant_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $confidant_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $confidant_blog_title_link ) && ! empty( $confidant_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $confidant_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $confidant_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'confidant_action_breadcrumbs' );
						$confidant_breadcrumbs = ob_get_contents();
						ob_end_clean();
						confidant_show_layout( $confidant_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
