<?php
/**
 * Required plugins
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$confidant_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'confidant' ),
	'page_builders' => esc_html__( 'Page Builders', 'confidant' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'confidant' ),
	'socials'       => esc_html__( 'Socials and Communities', 'confidant' ),
	'events'        => esc_html__( 'Events and Appointments', 'confidant' ),
	'content'       => esc_html__( 'Content', 'confidant' ),
	'other'         => esc_html__( 'Other', 'confidant' ),
);
$confidant_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'confidant' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'confidant' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $confidant_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'confidant' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'confidant' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $confidant_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'confidant' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'confidant' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $confidant_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'confidant' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'confidant' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $confidant_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'confidant' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'confidant' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'woocommerce.png',
		'group'       => $confidant_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'confidant' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'confidant' ),
		'required'    => false,
		'install'     => false, // TRX_addons has marked the "Elegro Crypto Payment" plugin as obsolete and no longer recommends it for installation, even if it had been previously recommended by the theme
		'logo'        => 'elegro-payment.png',
		'group'       => $confidant_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'confidant' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'confidant' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $confidant_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'confidant' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'confidant' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $confidant_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $confidant_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'quickcal.png',
		'group'       => $confidant_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $confidant_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'confidant' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'confidant' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $confidant_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'confidant' ),
		'description' => '',
		'required'    => false,
		'logo'        => confidant_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $confidant_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'confidant' ),
		'description' => '',
		'required'    => false,
		'logo'        => confidant_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $confidant_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => confidant_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $confidant_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => confidant_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $confidant_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => confidant_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $confidant_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => confidant_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $confidant_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'confidant' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $confidant_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'confidant' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $confidant_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'confidant' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'confidant' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $confidant_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'confidant' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'confidant' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $confidant_theme_required_plugins_groups['other'],
	),
	'gdpr-framework'         => array(
		'title'       => esc_html__( 'The GDPR Framework', 'confidant' ),
		'description' => esc_html__( "Tools to help make your website GDPR-compliant. Fully documented, extendable and developer-friendly.", 'confidant' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'gdpr-framework.png',
		'group'       => $confidant_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'confidant' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'confidant' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $confidant_theme_required_plugins_groups['other'],
	),
);

if ( CONFIDANT_THEME_FREE ) {
	unset( $confidant_theme_required_plugins['js_composer'] );
	unset( $confidant_theme_required_plugins['booked'] );
	unset( $confidant_theme_required_plugins['quickcal'] );
	unset( $confidant_theme_required_plugins['the-events-calendar'] );
	unset( $confidant_theme_required_plugins['calculated-fields-form'] );
	unset( $confidant_theme_required_plugins['essential-grid'] );
	unset( $confidant_theme_required_plugins['revslider'] );
	unset( $confidant_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $confidant_theme_required_plugins['trx_updater'] );
	unset( $confidant_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
confidant_storage_set( 'required_plugins', $confidant_theme_required_plugins );