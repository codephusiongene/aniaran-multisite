<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

if ( confidant_sidebar_present() ) {
	
	$confidant_sidebar_type = confidant_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $confidant_sidebar_type && ! confidant_is_layouts_available() ) {
		$confidant_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $confidant_sidebar_type ) {
		// Default sidebar with widgets
		$confidant_sidebar_name = confidant_get_theme_option( 'sidebar_widgets' );
		confidant_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $confidant_sidebar_name ) ) {
			dynamic_sidebar( $confidant_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$confidant_sidebar_id = confidant_get_custom_sidebar_id();
		do_action( 'confidant_action_show_layout', $confidant_sidebar_id );
	}
	$confidant_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $confidant_out ) ) {
		$confidant_sidebar_position    = confidant_get_theme_option( 'sidebar_position' );
		$confidant_sidebar_position_ss = confidant_get_theme_option( 'sidebar_position_ss', 'below' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $confidant_sidebar_position );
			echo ' sidebar_' . esc_attr( $confidant_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $confidant_sidebar_type );

			$confidant_sidebar_scheme = apply_filters( 'confidant_filter_sidebar_scheme', confidant_get_theme_option( 'sidebar_scheme', 'inherit' ) );
			if ( ! empty( $confidant_sidebar_scheme ) && ! confidant_is_inherit( $confidant_sidebar_scheme ) && 'custom' != $confidant_sidebar_type ) {
				echo ' scheme_' . esc_attr( $confidant_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="confidant_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'confidant_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $confidant_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$confidant_title = apply_filters( 'confidant_filter_sidebar_control_title', 'float' == $confidant_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'confidant' ) : '' );
				$confidant_text  = apply_filters( 'confidant_filter_sidebar_control_text', 'above' == $confidant_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'confidant' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $confidant_title ); ?>"><?php echo esc_html( $confidant_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'confidant_action_before_sidebar', 'sidebar' );
				confidant_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $confidant_out ) );
				do_action( 'confidant_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'confidant_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
