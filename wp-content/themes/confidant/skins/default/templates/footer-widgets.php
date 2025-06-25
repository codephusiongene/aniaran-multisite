<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.10
 */

// Footer sidebar
$confidant_footer_name    = confidant_get_theme_option( 'footer_widgets' );
$confidant_footer_present = ! confidant_is_off( $confidant_footer_name ) && is_active_sidebar( $confidant_footer_name );
if ( $confidant_footer_present ) {
	confidant_storage_set( 'current_sidebar', 'footer' );
	$confidant_footer_wide = confidant_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $confidant_footer_name ) ) {
		dynamic_sidebar( $confidant_footer_name );
	}
	$confidant_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $confidant_out ) ) {
		$confidant_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $confidant_out );
		$confidant_need_columns = true;   //or check: strpos($confidant_out, 'columns_wrap')===false;
		if ( $confidant_need_columns ) {
			$confidant_columns = max( 0, (int) confidant_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $confidant_columns ) {
				$confidant_columns = min( 4, max( 1, confidant_tags_count( $confidant_out, 'aside' ) ) );
			}
			if ( $confidant_columns > 1 ) {
				$confidant_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $confidant_columns ) . ' widget', $confidant_out );
			} else {
				$confidant_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $confidant_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'confidant_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $confidant_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $confidant_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'confidant_action_before_sidebar', 'footer' );
				confidant_show_layout( $confidant_out );
				do_action( 'confidant_action_after_sidebar', 'footer' );
				if ( $confidant_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $confidant_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'confidant_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
