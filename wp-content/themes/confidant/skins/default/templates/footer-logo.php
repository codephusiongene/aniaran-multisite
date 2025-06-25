<?php
/**
 * The template to display the site logo in the footer
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.10
 */

// Logo
if ( confidant_is_on( confidant_get_theme_option( 'logo_in_footer' ) ) ) {
	$confidant_logo_image = confidant_get_logo_image( 'footer' );
	$confidant_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $confidant_logo_image['logo'] ) || ! empty( $confidant_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $confidant_logo_image['logo'] ) ) {
					$confidant_attr = confidant_getimagesize( $confidant_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $confidant_logo_image['logo'] ) . '"'
								. ( ! empty( $confidant_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $confidant_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'confidant' ) . '"'
								. ( ! empty( $confidant_attr[3] ) ? ' ' . wp_kses_data( $confidant_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $confidant_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $confidant_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
