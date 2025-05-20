<?php
/**
 * The template to display the widgets area in the header
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

// Header sidebar
$confidant_header_name    = confidant_get_theme_option( 'header_widgets' );
$confidant_header_present = ! confidant_is_off( $confidant_header_name ) && is_active_sidebar( $confidant_header_name );
if ( $confidant_header_present ) {
	confidant_storage_set( 'current_sidebar', 'header' );
	$confidant_header_wide = confidant_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $confidant_header_name ) ) {
		dynamic_sidebar( $confidant_header_name );
	}
	$confidant_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $confidant_widgets_output ) ) {
		$confidant_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $confidant_widgets_output );
		$confidant_need_columns   = strpos( $confidant_widgets_output, 'columns_wrap' ) === false;
		if ( $confidant_need_columns ) {
			$confidant_columns = max( 0, (int) confidant_get_theme_option( 'header_columns' ) );
			if ( 0 == $confidant_columns ) {
				$confidant_columns = min( 6, max( 1, confidant_tags_count( $confidant_widgets_output, 'aside' ) ) );
			}
			if ( $confidant_columns > 1 ) {
				$confidant_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $confidant_columns ) . ' widget', $confidant_widgets_output );
			} else {
				$confidant_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $confidant_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'confidant_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $confidant_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $confidant_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'confidant_action_before_sidebar', 'header' );
				confidant_show_layout( $confidant_widgets_output );
				do_action( 'confidant_action_after_sidebar', 'header' );
				if ( $confidant_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $confidant_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'confidant_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
