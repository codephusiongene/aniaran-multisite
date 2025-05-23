<?php
/**
 * The Header: Logo and main menu
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( confidant_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'confidant_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'confidant_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('confidant_action_body_wrap_attributes'); ?>>

		<?php do_action( 'confidant_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'confidant_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('confidant_action_page_wrap_attributes'); ?>>

			<?php do_action( 'confidant_action_page_wrap_start' ); ?>

			<?php
			$confidant_full_post_loading = ( confidant_is_singular( 'post' ) || confidant_is_singular( 'attachment' ) ) && confidant_get_value_gp( 'action' ) == 'full_post_loading';
			$confidant_prev_post_loading = ( confidant_is_singular( 'post' ) || confidant_is_singular( 'attachment' ) ) && confidant_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $confidant_full_post_loading && ! $confidant_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="confidant_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'confidant_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'confidant' ); ?></a>
				<?php if ( confidant_sidebar_present() ) { ?>
				<a class="confidant_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'confidant_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'confidant' ); ?></a>
				<?php } ?>
				<a class="confidant_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'confidant_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'confidant' ); ?></a>

				<?php
				do_action( 'confidant_action_before_header' );

				// Header
				$confidant_header_type = confidant_get_theme_option( 'header_type' );
				if ( 'custom' == $confidant_header_type && ! confidant_is_layouts_available() ) {
					$confidant_header_type = 'default';
				}
				get_template_part( apply_filters( 'confidant_filter_get_template_part', "templates/header-" . sanitize_file_name( $confidant_header_type ) ) );

				// Side menu
				if ( in_array( confidant_get_theme_option( 'menu_side', 'none' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				if ( apply_filters( 'confidant_filter_use_navi_mobile', true ) ) {
					get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-navi-mobile' ) );
				}

				do_action( 'confidant_action_after_header' );

			}
			?>

			<?php do_action( 'confidant_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( confidant_is_off( confidant_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $confidant_header_type ) ) {
						$confidant_header_type = confidant_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $confidant_header_type && confidant_is_layouts_available() ) {
						$confidant_header_id = confidant_get_custom_header_id();
						if ( $confidant_header_id > 0 ) {
							$confidant_header_meta = confidant_get_custom_layout_meta( $confidant_header_id );
							if ( ! empty( $confidant_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$confidant_footer_type = confidant_get_theme_option( 'footer_type' );
					if ( 'custom' == $confidant_footer_type && confidant_is_layouts_available() ) {
						$confidant_footer_id = confidant_get_custom_footer_id();
						if ( $confidant_footer_id ) {
							$confidant_footer_meta = confidant_get_custom_layout_meta( $confidant_footer_id );
							if ( ! empty( $confidant_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'confidant_action_page_content_wrap_class', $confidant_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'confidant_filter_is_prev_post_loading', $confidant_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( confidant_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'confidant_action_page_content_wrap_data', $confidant_prev_post_loading );
			?>>
				<?php
				do_action( 'confidant_action_page_content_wrap', $confidant_full_post_loading || $confidant_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'confidant_filter_single_post_header', confidant_is_singular( 'post' ) || confidant_is_singular( 'attachment' ) ) ) {
					if ( $confidant_prev_post_loading ) {
						if ( confidant_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) != 'article' ) {
							do_action( 'confidant_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$confidant_path = apply_filters( 'confidant_filter_get_template_part', 'templates/single-styles/' . confidant_get_theme_option( 'single_style' ) );
					if ( confidant_get_file_dir( $confidant_path . '.php' ) != '' ) {
						get_template_part( $confidant_path );
					}
				}

				// Widgets area above page
				$confidant_body_style   = confidant_get_theme_option( 'body_style' );
				$confidant_widgets_name = confidant_get_theme_option( 'widgets_above_page', 'hide' );
				$confidant_show_widgets = ! confidant_is_off( $confidant_widgets_name ) && is_active_sidebar( $confidant_widgets_name );
				if ( $confidant_show_widgets ) {
					if ( 'fullscreen' != $confidant_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					confidant_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $confidant_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'confidant_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $confidant_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'confidant_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'confidant_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="confidant_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( confidant_is_singular( 'post' ) || confidant_is_singular( 'attachment' ) )
							&& $confidant_prev_post_loading 
							&& confidant_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) == 'article'
						) {
							do_action( 'confidant_action_between_posts' );
						}

						// Widgets area above content
						confidant_create_widgets_area( 'widgets_above_content' );

						do_action( 'confidant_action_page_content_start_text' );
