<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$confidant_copyright_scheme = confidant_get_theme_option( 'copyright_scheme' );
if ( ! empty( $confidant_copyright_scheme ) && ! confidant_is_inherit( $confidant_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $confidant_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$confidant_copyright = confidant_get_theme_option( 'copyright' );
			if ( ! empty( $confidant_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$confidant_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $confidant_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$confidant_copyright = confidant_prepare_macros( $confidant_copyright );
				// Display copyright
				echo wp_kses( nl2br( $confidant_copyright ), 'confidant_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
