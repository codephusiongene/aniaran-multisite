<?php
/**
 * The template to show mobile menu (used only header_style == 'default')
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.0
 */

$confidant_show_widgets = confidant_get_theme_option( 'widgets_menu_mobile_fullscreen' );
$confidant_show_socials = confidant_get_theme_option( 'menu_mobile_socials' );

?>
<div class="menu_mobile_overlay scheme_dark"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( confidant_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> scheme_dark">
	<div class="menu_mobile_inner<?php echo esc_attr( $confidant_show_widgets == 1  ? ' with_widgets' : '' ); ?>">
        <div class="menu_mobile_header_wrap">
            <?php
            // Logo
            set_query_var( 'confidant_logo_args', array( 'type' => 'mobile' ) );
            get_template_part( apply_filters( 'confidant_filter_get_template_part', 'templates/header-logo' ) );
            set_query_var( 'confidant_logo_args', array() ); ?>

            <a class="menu_mobile_close menu_button_close" tabindex="0"><span class="menu_button_close_text"><?php esc_html_e('Close', 'confidant')?></span><span class="menu_button_close_icon"></span></a>
        </div>
        <div class="menu_mobile_content_wrap content_wrap">
            <div class="menu_mobile_content_wrap_inner<?php echo esc_attr($confidant_show_socials ? '' : ' without_socials'); ?>"><?php
            // Mobile menu
            $confidant_menu_mobile = confidant_get_nav_menu( 'menu_mobile' );
            if ( empty( $confidant_menu_mobile ) ) {
                $confidant_menu_mobile = apply_filters( 'confidant_filter_get_mobile_menu', '' );
                if ( empty( $confidant_menu_mobile ) ) {
                    $confidant_menu_mobile = confidant_get_nav_menu( 'menu_main' );
                    if ( empty( $confidant_menu_mobile ) ) {
                        $confidant_menu_mobile = confidant_get_nav_menu();
                    }
                }
            }
            if ( ! empty( $confidant_menu_mobile ) ) {
                // Change attribute 'id' - add prefix 'mobile-' to prevent duplicate id on the page
                $confidant_menu_mobile = preg_replace( '/([\s]*id=")/', '${1}mobile-', $confidant_menu_mobile );
                // Change main menu classes
                $confidant_menu_mobile = str_replace(
                array( 'menu_main',   'sc_layouts_menu_nav', 'sc_layouts_menu ' ), // , 'sc_layouts_hide_on_mobile', 'hide_on_mobile'
                array( 'menu_mobile', '', ' ' ), // , '', ''
                    $confidant_menu_mobile
                );
                // Wrap menu to the <nav> if not present
                if ( strpos( $confidant_menu_mobile, '<nav ' ) !== 0 ) {	// condition !== false is not allowed, because menu can contain inner <nav> elements (in the submenu layouts)
                    $confidant_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area" itemscope="itemscope" itemtype="%1$s//schema.org/SiteNavigationElement">%2$s</nav>', esc_attr( confidant_get_protocol( true ) ), $confidant_menu_mobile );
                }
                // Show menu
                confidant_show_layout( apply_filters( 'confidant_filter_menu_mobile_layout', $confidant_menu_mobile ) );
            }
            // Social icons
            if($confidant_show_socials) {
                confidant_show_layout( confidant_get_socials_links(), '<div class="socials_mobile">', '</div>' );
            }            
            ?>
            </div>
		</div><?php

        if ( $confidant_show_widgets == 1 )  {
            ?><div class="menu_mobile_widgets_area"><?php
            // Create Widgets Area
            confidant_create_widgets_area( 'widgets_additional_menu_mobile_fullscreen' );
            ?></div><?php
        } ?>

    </div>
</div>
