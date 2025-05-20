<?php
/**
 * The template to display Admin notices
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.1
 */

$confidant_theme_slug = get_template();
$confidant_theme_obj  = wp_get_theme( $confidant_theme_slug );

?>
<div class="confidant_admin_notice confidant_rate_notice notice notice-info is-dismissible" data-notice="rate">
	<?php
	// Theme image
	$confidant_theme_img = confidant_get_file_url( 'screenshot.jpg' );
	if ( '' != $confidant_theme_img ) {
		?>
		<div class="confidant_notice_image"><img src="<?php echo esc_url( $confidant_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'confidant' ); ?>"></div>
		<?php
	}

	// Title
	$confidant_theme_name = '"' . $confidant_theme_obj->get( 'Name' ) . ( CONFIDANT_THEME_FREE ? ' ' . __( 'Free', 'confidant' ) : '' ) . '"';
	?>
	<h3 class="confidant_notice_title"><a href="<?php echo esc_url( confidant_storage_get( 'theme_rate_url' ) ); ?>" target="_blank">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name to the 'Welcome' message
				__( 'Help Us Grow - Rate %s Today!', 'confidant' ),
				$confidant_theme_name
			)
		);
		?>
	</a></h3>
	<?php

	// Description
	?>
	<div class="confidant_notice_text">
		<p><?php
			// Translators: Add theme name to the 'Welcome' message
			echo wp_kses_data( sprintf( __( "Thank you for choosing the %s theme for your website! We're excited to see how you've customized your site, and we hope you've enjoyed working with our theme.", 'confidant' ), $confidant_theme_name ) );
		?></p>
		<p><?php
			// Translators: Add theme name to the 'Welcome' message
			echo wp_kses_data( sprintf( __( "Your feedback really matters to us! If you've had a positive experience, we'd love for you to take a moment to rate %s and share your thoughts on the customer service you received.", 'confidant' ), $confidant_theme_name ) );
		?></p>
	</div>
	<?php

	// Buttons
	?>
	<div class="confidant_notice_buttons">
		<?php
		// Link to the theme download page
		?>
		<a href="<?php echo esc_url( confidant_storage_get( 'theme_rate_url' ) ); ?>" class="button button-primary" target="_blank"><i class="dashicons dashicons-star-filled"></i> 
			<?php
			// Translators: Add the theme name to the button caption
			echo esc_html( sprintf( __( 'Rate %s Now', 'confidant' ), $confidant_theme_name ) );
			?>
		</a>
		<?php
		// Link to the theme support
		?>
		<a href="<?php echo esc_url( confidant_storage_get( 'theme_support_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-sos"></i> 
			<?php
			esc_html_e( 'Support', 'confidant' );
			?>
		</a>
		<?php
		// Link to the theme documentation
		?>
		<a href="<?php echo esc_url( confidant_storage_get( 'theme_doc_url' ) ); ?>" class="button" target="_blank"><i class="dashicons dashicons-book"></i> 
			<?php
			esc_html_e( 'Documentation', 'confidant' );
			?>
		</a>
	</div>
</div>
