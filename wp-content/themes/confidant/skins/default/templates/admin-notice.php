<?php
/**
 * The template to display Admin notices
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.1
 */

$confidant_theme_slug = get_option( 'template' );
$confidant_theme_obj  = wp_get_theme( $confidant_theme_slug );
?>
<div class="confidant_admin_notice confidant_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$confidant_theme_img = confidant_get_file_url( 'screenshot.jpg' );
	if ( '' != $confidant_theme_img ) {
		?>
		<div class="confidant_notice_image"><img src="<?php echo esc_url( $confidant_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'confidant' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="confidant_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'confidant' ),
				$confidant_theme_obj->get( 'Name' ) . ( CONFIDANT_THEME_FREE ? ' ' . __( 'Free', 'confidant' ) : '' ),
				$confidant_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="confidant_notice_text">
		<p class="confidant_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $confidant_theme_obj->description ) );
			?>
		</p>
		<p class="confidant_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'confidant' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="confidant_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=confidant_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'confidant' );
			?>
		</a>
	</div>
</div>
