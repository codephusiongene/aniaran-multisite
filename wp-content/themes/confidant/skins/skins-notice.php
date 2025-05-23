<?php
/**
 * The template to display Admin notices
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.64
 */

$confidant_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$confidant_skins_args = get_query_var( 'confidant_skins_notice_args' );
?>
<div class="confidant_admin_notice confidant_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'confidant' ); ?>
	</h3>
	<?php

	// Description
	$confidant_total      = $confidant_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$confidant_skins_msg  = $confidant_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $confidant_total, 'confidant' ), $confidant_total ) . '</strong>'
							: '';
	$confidant_total      = $confidant_skins_args['free'];
	$confidant_skins_msg .= $confidant_total > 0
							? ( ! empty( $confidant_skins_msg ) ? ' ' . esc_html__( 'and', 'confidant' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $confidant_total, 'confidant' ), $confidant_total ) . '</strong>'
							: '';
	$confidant_total      = $confidant_skins_args['pay'];
	$confidant_skins_msg .= $confidant_skins_args['pay'] > 0
							? ( ! empty( $confidant_skins_msg ) ? ' ' . esc_html__( 'and', 'confidant' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $confidant_total, 'confidant' ), $confidant_total ) . '</strong>'
							: '';
	?>
	<div class="confidant_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'confidant' ), $confidant_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="confidant_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $confidant_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'confidant' );
			?>
		</a>
	</div>
</div>
