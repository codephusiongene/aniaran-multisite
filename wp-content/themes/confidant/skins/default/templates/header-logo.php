<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

$confidant_args = get_query_var( 'confidant_logo_args' );

// Site logo
$confidant_logo_type   = isset( $confidant_args['type'] ) ? $confidant_args['type'] : '';
$confidant_logo_image  = confidant_get_logo_image( $confidant_logo_type );
$confidant_logo_text   = confidant_is_on( confidant_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$confidant_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $confidant_logo_image['logo'] ) || ! empty( $confidant_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $confidant_logo_image['logo'] ) ) {
			if ( empty( $confidant_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($confidant_logo_image['logo']) && (int) $confidant_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$confidant_attr = confidant_getimagesize( $confidant_logo_image['logo'] );
				echo '<img src="' . esc_url( $confidant_logo_image['logo'] ) . '"'
						. ( ! empty( $confidant_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $confidant_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $confidant_logo_text ) . '"'
						. ( ! empty( $confidant_attr[3] ) ? ' ' . wp_kses_data( $confidant_attr[3] ) : '' )
						. '>';
			}
		} else {
			confidant_show_layout( confidant_prepare_macros( $confidant_logo_text ), '<span class="logo_text">', '</span>' );
			confidant_show_layout( confidant_prepare_macros( $confidant_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
