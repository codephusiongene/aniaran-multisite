<?php
/**
 * The template to display the socials in the footer
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.10
 */


// Socials
if ( confidant_is_on( confidant_get_theme_option( 'socials_in_footer' ) ) ) {
	$confidant_output = confidant_get_socials_links();
	if ( '' != $confidant_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php confidant_show_layout( $confidant_output ); ?>
			</div>
		</div>
		<?php
	}
}
