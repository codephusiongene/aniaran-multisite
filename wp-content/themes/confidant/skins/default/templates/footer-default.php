<?php
/**
 * The template to display default site footer
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$confidant_footer_scheme = confidant_get_theme_option( 'footer_scheme' );
if ( ! empty( $confidant_footer_scheme ) && ! confidant_is_inherit( $confidant_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $confidant_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
