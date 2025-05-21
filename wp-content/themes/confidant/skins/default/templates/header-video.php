<?php
/**
 * The template to display the background video in the header
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0.14
 */
$confidant_header_video = confidant_get_header_video();
$confidant_embed_video  = '';
if ( ! empty( $confidant_header_video ) && ! confidant_is_from_uploads( $confidant_header_video ) ) {
	if ( confidant_is_youtube_url( $confidant_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $confidant_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php confidant_show_layout( confidant_get_embed_video( $confidant_header_video ) ); ?></div>
		<?php
	}
}
