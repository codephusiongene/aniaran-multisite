<?php
/**
 * Skin Setup
 *
 * @package CONFIDANT
 * @since CONFIDANT 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'confidant_theme_defaults' ) ) {
	function confidant_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// WOOCOMMERCE SETUP
//--------------------------------------------------

// Allow extended layouts for WooCommerce
if ( ! function_exists( 'confidant_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'confidant_filter_load_woocommerce_extensions', 'confidant_skin_woocommerce_allow_extensions' );
	function confidant_skin_woocommerce_allow_extensions( $allow ) {
		return false;
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'confidant_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'confidant_skin_setup', 1 );
	function confidant_skin_setup() {

		$GLOBALS['CONFIDANT_STORAGE'] = array_merge( $GLOBALS['CONFIDANT_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-axiom',

			'theme_doc_url'       => '//doc.themerex.net/confidant',

			'theme_demofiles_url' => '//demofiles.axiomthemes.com/confidant/',
			
			'theme_rate_url'      => '//themeforest.net/downloads',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/axiomthemes/portfolio',        // Axiom

			'theme_video_url'     => '//www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',   // Axiom

			'theme_privacy_url'   => '//axiomthemes.com/privacy-policy/',                   // Axiom

			'portfolio_url'       => '//themeforest.net/user/axiomthemes/portfolio',        // Axiom

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'confidant_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'confidant_skin_setup_settings', 1 );
	function confidant_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		confidant_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		confidant_storage_set_array2( 'required_plugins', 'woocommerce', 'install', true);
		confidant_storage_set_array2( 'required_plugins', 'ti-woocommerce-wishlist', 'install', true);
		confidant_storage_set_array2( 'required_plugins', 'latepoint', 'install', false);
		confidant_storage_set_array2( 'required_plugins', 'instagram-feed', 'install', false);  
	}
}



//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'confidant_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'confidant_skin_setup_fonts', 1 );
	function confidant_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		confidant_storage_set(
			'load_fonts', array(
				array(
					'name'   => 'halyard-display',
					'family' => 'sans-serif',
					'link'   => 'https://use.typekit.net/xog3vbp.css',
					'styles' => ''
				),
				// Google font
				array(
					'name'   => 'DM Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,400;0,500;0,700;1,400;1,500;1,700',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		confidant_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => confidant_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'confidant' );

		confidant_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'confidant' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.68em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.7em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'confidant' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '3.353em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.04em',
					'margin-bottom'   => '0.46em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '2.765em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.67em',
					'margin-bottom'   => '0.56em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '2.059em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.029em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.94em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '1.647em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.036em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.83em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '1.412em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.083em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.84em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '1.118em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.263em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '1.5px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'confidant' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'confidant' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
					'font-size'       => '17px',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'confidant' ) ),
					'font-family'     => '"DM Sans",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'confidant' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'confidant' ) ),
					'font-family'     => 'halyard-display,sans-serif',
				),
			)
		);

		// Font presets
		confidant_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'confidant' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'confidant' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'confidant' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'confidant_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'confidant_skin_setup_schemes', 1 );
	function confidant_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		confidant_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'confidant' ),
					'description' => esc_html__( 'Colors of the main content area', 'confidant' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'confidant' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'confidant' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'confidant' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'confidant' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'confidant' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'confidant' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'confidant' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'confidant' ),
				),
			)
		);

		confidant_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'confidant' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'confidant' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'confidant' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'confidant' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'confidant' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'confidant' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'confidant' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'confidant' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'confidant' ),
					'description' => esc_html__( 'Color of the text inside this block', 'confidant' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'confidant' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'confidant' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'confidant' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'confidant' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'confidant' ),
					'description' => esc_html__( 'Color of the links inside this block', 'confidant' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'confidant' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'confidant' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'confidant' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'confidant' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'confidant' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'confidant' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'confidant' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'confidant' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'confidant' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'confidant' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F2F7FE', // ok
					'bd_color'         => '#C6DEEE', // ok

					// Text and links colors
					'text'             => '#696F75', // ok
					'text_light'       => '#A5A6AA', // ok
					'text_dark'        => '#0D315B', // ok
					'text_link'        => '#EF5938', // ok
					'text_hover'       => '#D44728', // ok
					'text_link2'       => '#438A3C', // ok
					'text_hover2'      => '#32792B', // ok
					'text_link3'       => '#F2C438', // ok
					'text_hover3'      => '#DEB127', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //
					'alter_bg_hover'   => '#E9F2FE', //
					'alter_bd_color'   => '#C6DEEE', // ok
					'alter_bd_hover'   => '#AECEE2', //
					'alter_text'       => '#696F75', //
					'alter_light'      => '#A5A6AA', // ok
					'alter_dark'       => '#0D315B', // ok
					'alter_link'       => '#EF5938', // ok
					'alter_hover'      => '#D44728', // ok
					'alter_link2'      => '#438A3C', // ok
					'alter_hover2'     => '#32792B', // ok
					'alter_link3'      => '#F2C438', // ok
					'alter_hover3'     => '#DEB127', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#162231', // ok
					'extra_bg_hover'   => '#233142',
					'extra_bd_color'   => '#174171',
					'extra_bd_hover'   => '#255081',
					'extra_text'       => '#BDC3CA', //
					'extra_light'      => '#828CA7',
					'extra_dark'       => '#ECEFF2', //
					'extra_link'       => '#EF5938', // ok
					'extra_hover'      => '#ECEFF2', //
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C6DEEE', // ok
					'input_bd_hover'   => '#0D315B', // ok
					'input_text'       => '#696F75', // ok
					'input_light'      => '#A5A6AA', // ok
					'input_dark'       => '#0D315B', // ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#0D315B', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#ffffff', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#050F1B', // ok
					'bd_color'         => '#174171', //

					// Text and links colors
					'text'             => '#BDC3CA', // ok
					'text_light'       => '#828CA7', // ok
					'text_dark'        => '#ECEFF2', // ok
					'text_link'        => '#EF5938', // ok
					'text_hover'       => '#D44728', // ok
					'text_link2'       => '#438A3C', // ok
					'text_hover2'      => '#32792B', // ok
					'text_link3'       => '#F2C438', // ok
					'text_hover3'      => '#DEB127', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0D315B', // ok
					'alter_bg_hover'   => '#0B2C52', //
					'alter_bd_color'   => '#174171', //
					'alter_bd_hover'   => '#255081', //
					'alter_text'       => '#BDC3CA', //
					'alter_light'      => '#828CA7', //
					'alter_dark'       => '#ECEFF2', //
					'alter_link'       => '#EF5938', // ok
					'alter_hover'      => '#D44728', // ok
					'alter_link2'      => '#438A3C', // ok
					'alter_hover2'     => '#32792B', // ok
					'alter_link3'      => '#F2C438', // ok
					'alter_hover3'     => '#DEB127', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#162231', // ok
					'extra_bg_hover'   => '#233142',
					'extra_bd_color'   => '#174171',
					'extra_bd_hover'   => '#255081',
					'extra_text'       => '#BDC3CA',
					'extra_light'      => '#828CA7',
					'extra_dark'       => '#ECEFF2',
					'extra_link'       => '#EF5938', //ok
					'extra_hover'      => '#ECEFF2',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //
					'input_bg_hover'   => '#transparent', //
					'input_bd_color'   => '#174171', //
					'input_bd_hover'   => '#255081', //
					'input_text'       => '#D2D3D5', //
					'input_light'      => '#D2D3D5', //
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#E9F2FE', //
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#0D315B', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#0D315B', // ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light'
			'light' => array(
				'title'    => esc_html__( 'Light', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //
					'bd_color'         => '#C6DEEE', // ok

					// Text and links colors
					'text'             => '#696F75', // ok
					'text_light'       => '#A5A6AA', // ok
					'text_dark'        => '#0D315B', // ok
					'text_link'        => '#EF5938', // ok
					'text_hover'       => '#D44728', // ok
					'text_link2'       => '#438A3C', // ok
					'text_hover2'      => '#32792B', // ok
					'text_link3'       => '#F2C438', // ok
					'text_hover3'      => '#DEB127', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F2F7FE', // ok
					'alter_bg_hover'   => '#ffffff', //
					'alter_bd_color'   => '#C6DEEE', // ok
					'alter_bd_hover'   => '#AECEE2', //
					'alter_text'       => '#696F75', //
					'alter_light'      => '#A5A6AA', // ok
					'alter_dark'       => '#0D315B', // ok
					'alter_link'       => '#EF5938', // ok
					'alter_hover'      => '#D44728', // ok
					'alter_link2'      => '#438A3C', // ok
					'alter_hover2'     => '#32792B', // ok
					'alter_link3'      => '#F2C438', // ok
					'alter_hover3'     => '#DEB127', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#162231', // ok
					'extra_bg_hover'   => '#233142',
					'extra_bd_color'   => '#174171',
					'extra_bd_hover'   => '#255081',
					'extra_text'       => '#BDC3CA', //
					'extra_light'      => '#828CA7',
					'extra_dark'       => '#ECEFF2', //
					'extra_link'       => '#EF5938', // ok
					'extra_hover'      => '#ECEFF2', //
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#C6DEEE', // ok
					'input_bd_hover'   => '#0D315B', // ok
					'input_text'       => '#696F75', // ok
					'input_light'      => '#A5A6AA', // ok
					'input_dark'       => '#0D315B', // ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#0D315B', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#ffffff', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'default_soft'
			'default_soft' => array(
				'title'    => esc_html__( 'Default Soft', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F8F5EC', // ok
					'bd_color'         => '#E7E2D6', // ok

					// Text and links colors
					'text'             => '#565655', // ok
					'text_light'       => '#949494', // ok
					'text_dark'        => '#20201F', // ok
					'text_link'        => '#E2725B', // ok
					'text_hover'       => '#DD644C', // ok
					'text_link2'       => '#7DA189', // ok
					'text_hover2'      => '#6D967A', // ok
					'text_link3'       => '#9D7246', // ok
					'text_hover3'      => '#5B3918', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //
					'alter_bg_hover'   => '#F4EED9', //
					'alter_bd_color'   => '#E7E2D6', // ok
					'alter_bd_hover'   => '#E1DCCB', //
					'alter_text'       => '#565655', //
					'alter_light'      => '#949494', // ok
					'alter_dark'       => '#20201F', // ok
					'alter_link'       => '#E2725B', // ok
					'alter_hover'      => '#DD644C', // ok
					'alter_link2'      => '#7DA189', // ok
					'alter_hover2'     => '#6D967A', // ok
					'alter_link3'      => '#9D7246', // ok
					'alter_hover3'     => '#5B3918', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#310A57', // ok
					'extra_bg_hover'   => '#461575',
					'extra_bd_color'   => '#424040',
					'extra_bd_hover'   => '#535353',
					'extra_text'       => '#DEDDDB', //
					'extra_light'      => '#848484',
					'extra_dark'       => '#EFE8CE', //
					'extra_link'       => '#E2725B', // ok
					'extra_hover'      => '#EFE8CE', //
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#E7E2D6', // ok
					'input_bd_hover'   => '#20201F', // ok
					'input_text'       => '#565655', // ok
					'input_light'      => '#949494', // ok
					'input_dark'       => '#20201F', // ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#20201F', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#ffffff', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark_soft'
			'dark_soft'    => array(
				'title'    => esc_html__( 'Dark Soft', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#141414', // ok
					'bd_color'         => '#424040', //

					// Text and links colors
					'text'             => '#DEDDDB', // ok
					'text_light'       => '#848484', // ok
					'text_dark'        => '#EFE8CE', // ok
					'text_link'        => '#E2725B', // ok
					'text_hover'       => '#DD644C', // ok
					'text_link2'       => '#7DA189', // ok
					'text_hover2'      => '#6D967A', // ok
					'text_link3'       => '#9D7246', // ok
					'text_hover3'      => '#5B3918', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#292828', // ok
					'alter_bg_hover'   => '#353535', //
					'alter_bd_color'   => '#424040', //
					'alter_bd_hover'   => '#535353', //
					'alter_text'       => '#DEDDDB', //
					'alter_light'      => '#848484', //
					'alter_dark'       => '#EFE8CE', //
					'alter_link'       => '#E2725B', // ok
					'alter_hover'      => '#DD644C', // ok
					'alter_link2'      => '#7DA189', // ok
					'alter_hover2'     => '#6D967A', // ok
					'alter_link3'      => '#9D7246', // ok
					'alter_hover3'     => '#5B3918', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#2E2E2E', // ok
					'extra_bg_hover'   => '#3B3B3B',
					'extra_bd_color'   => '#424040',
					'extra_bd_hover'   => '#535353',
					'extra_text'       => '#DEDDDB',
					'extra_light'      => '#848484',
					'extra_dark'       => '#EFE8CE',
					'extra_link'       => '#E2725B', //ok
					'extra_hover'      => '#EFE8CE',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //
					'input_bg_hover'   => '#transparent', //
					'input_bd_color'   => '#424040', //
					'input_bd_hover'   => '#EFE8CE', //
					'input_text'       => '#DEDDDB', //
					'input_light'      => '#848484', //
					'input_dark'       => '#EFE8CE',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#E9F2FE', //
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#292828', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#292828', // ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark_alter_soft'
			'dark_alter_soft'    => array(
				'title'    => esc_html__( 'Dark Alter Soft', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#292828', // ok
					'bd_color'         => '#424040', //

					// Text and links colors
					'text'             => '#DEDDDB', // ok
					'text_light'       => '#848484', // ok
					'text_dark'        => '#EFE8CE', // ok
					'text_link'        => '#E2725B', // ok
					'text_hover'       => '#DD644C', // ok
					'text_link2'       => '#7DA189', // ok
					'text_hover2'      => '#6D967A', // ok
					'text_link3'       => '#9D7246', // ok
					'text_hover3'      => '#5B3918', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#141414', // ok
					'alter_bg_hover'   => '#353535', //
					'alter_bd_color'   => '#424040', //
					'alter_bd_hover'   => '#535353', //
					'alter_text'       => '#DEDDDB', //
					'alter_light'      => '#848484', //
					'alter_dark'       => '#EFE8CE', //
					'alter_link'       => '#E2725B', // ok
					'alter_hover'      => '#DD644C', // ok
					'alter_link2'      => '#7DA189', // ok
					'alter_hover2'     => '#6D967A', // ok
					'alter_link3'      => '#9D7246', // ok
					'alter_hover3'     => '#5B3918', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#2E2E2E', // ok
					'extra_bg_hover'   => '#3B3B3B',
					'extra_bd_color'   => '#424040',
					'extra_bd_hover'   => '#535353',
					'extra_text'       => '#DEDDDB',
					'extra_light'      => '#848484',
					'extra_dark'       => '#EFE8CE',
					'extra_link'       => '#E2725B', //ok
					'extra_hover'      => '#EFE8CE',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //
					'input_bg_hover'   => '#transparent', //
					'input_bd_color'   => '#424040', //
					'input_bd_hover'   => '#EFE8CE', //
					'input_text'       => '#DEDDDB', //
					'input_light'      => '#848484', //
					'input_dark'       => '#EFE8CE',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#E9F2FE', //
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#141414', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#141414', // ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light_soft'
			'light_soft' => array(
				'title'    => esc_html__( 'Light Soft', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //
					'bd_color'         => '#E7E2D6', // ok

					// Text and links colors
					'text'             => '#565655', // ok
					'text_light'       => '#949494', // ok
					'text_dark'        => '#20201F', // ok
					'text_link'        => '#E2725B', // ok
					'text_hover'       => '#DD644C', // ok
					'text_link2'       => '#7DA189', // ok
					'text_hover2'      => '#6D967A', // ok
					'text_link3'       => '#9D7246', // ok
					'text_hover3'      => '#5B3918', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F8F5EC', // ok
					'alter_bg_hover'   => '#F4EED9', //
					'alter_bd_color'   => '#E7E2D6', // ok
					'alter_bd_hover'   => '#E1DCCB', //
					'alter_text'       => '#565655', //
					'alter_light'      => '#949494', // ok
					'alter_dark'       => '#20201F', // ok
					'alter_link'       => '#E2725B', // ok
					'alter_hover'      => '#DD644C', // ok
					'alter_link2'      => '#7DA189', // ok
					'alter_hover2'     => '#6D967A', // ok
					'alter_link3'      => '#9D7246', // ok
					'alter_hover3'     => '#5B3918', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#162231', // ok
					'extra_bg_hover'   => '#233142',
					'extra_bd_color'   => '#174171',
					'extra_bd_hover'   => '#255081',
					'extra_text'       => '#BDC3CA', //
					'extra_light'      => '#828CA7',
					'extra_dark'       => '#ECEFF2', //
					'extra_link'       => '#E2725B', // ok
					'extra_hover'      => '#ECEFF2', //
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#E7E2D6', // ok
					'input_bd_hover'   => '#20201F', // ok
					'input_text'       => '#565655', // ok
					'input_light'      => '#949494', // ok
					'input_dark'       => '#20201F', // ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#20201F', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#ffffff', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'default_success'
			'default_success' => array(
				'title'    => esc_html__( 'Default Success', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F8F6F4', // ok
					'bd_color'         => '#E4DDD8', // ok

					// Text and links colors
					'text'             => '#54605E', // ok
					'text_light'       => '#ABABAB', // ok
					'text_dark'        => '#151515', // ok
					'text_link'        => '#155247', // ok
					'text_hover'       => '#0D453B', // ok
					'text_link2'       => '#E1DABB', // ok
					'text_hover2'      => '#D9D0AB', // ok
					'text_link3'       => '#A17C48', // ok
					'text_hover3'      => '#8F6932', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //
					'alter_bg_hover'   => '#F1EDE8', //
					'alter_bd_color'   => '#E4DDD8', // ok
					'alter_bd_hover'   => '#D8CDC7', //
					'alter_text'       => '#54605E', //
					'alter_light'      => '#ABABAB', // ok
					'alter_dark'       => '#151515', // ok
					'alter_link'       => '#155247', // ok
					'alter_hover'      => '#0D453B', // ok
					'alter_link2'      => '#E1DABB', // ok
					'alter_hover2'     => '#D9D0AB', // ok
					'alter_link3'      => '#A17C48', // ok
					'alter_hover3'     => '#8F6932', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#081D19', // ok
					'extra_bg_hover'   => '#0C2722',
					'extra_bd_color'   => '#354744',
					'extra_bd_hover'   => '#465653',
					'extra_text'       => '#BDCBC9', //
					'extra_light'      => '#7B8E8B',
					'extra_dark'       => '#F9F9F9', //
					'extra_link'       => '#155247', // ok
					'extra_hover'      => '#F9F9F9', //
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#E4DDD8', // ok
					'input_bd_hover'   => '#151515', // ok
					'input_text'       => '#54605E', // ok
					'input_light'      => '#ABABAB', // ok
					'input_dark'       => '#151515', // ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#151515', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#ffffff', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark_success'
			'dark_success'    => array(
				'title'    => esc_html__( 'Dark Success', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#141515', // ok
					'bd_color'         => '#354744', //

					// Text and links colors
					'text'             => '#BDCBC9', // ok
					'text_light'       => '#7B8E8B', // ok
					'text_dark'        => '#F9F9F9', // ok
					'text_link'        => '#155247', // ok
					'text_hover'       => '#0D453B', // ok
					'text_link2'       => '#E1DABB', // ok
					'text_hover2'      => '#D9D0AB', // ok
					'text_link3'       => '#A17C48', // ok
					'text_hover3'      => '#8F6932', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#032B24', // ok
					'alter_bg_hover'   => '#073931', //
					'alter_bd_color'   => '#354744', //
					'alter_bd_hover'   => '#465653', //
					'alter_text'       => '#BDCBC9', //
					'alter_light'      => '#7B8E8B', //
					'alter_dark'       => '#F9F9F9', //
					'alter_link'       => '#155247', // ok
					'alter_hover'      => '#0D453B', // ok
					'alter_link2'      => '#E1DABB', // ok
					'alter_hover2'     => '#D9D0AB', // ok
					'alter_link3'      => '#A17C48', // ok
					'alter_hover3'     => '#8F6932', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#081D19', // ok
					'extra_bg_hover'   => '#0C2722',
					'extra_bd_color'   => '#354744',
					'extra_bd_hover'   => '#465653',
					'extra_text'       => '#BDCBC9',
					'extra_light'      => '#7B8E8B',
					'extra_dark'       => '#F9F9F9',
					'extra_link'       => '#155247', //ok
					'extra_hover'      => '#F9F9F9',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //
					'input_bg_hover'   => '#transparent', //
					'input_bd_color'   => '#354744', //
					'input_bd_hover'   => '#F9F9F9', //
					'input_text'       => '#BDCBC9', //
					'input_light'      => '#7B8E8B', //
					'input_dark'       => '#F9F9F9',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#E9F2FE', //
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#032B24', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#032B24', // ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light_success'
			'light_success' => array(
				'title'    => esc_html__( 'Light Success', 'confidant' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //
					'bd_color'         => '#E4DDD8', // ok

					// Text and links colors
					'text'             => '#54605E', // ok
					'text_light'       => '#ABABAB', // ok
					'text_dark'        => '#151515', // ok
					'text_link'        => '#155247', // ok
					'text_hover'       => '#0D453B', // ok
					'text_link2'       => '#E1DABB', // ok
					'text_hover2'      => '#D9D0AB', // ok
					'text_link3'       => '#A17C48', // ok
					'text_hover3'      => '#8F6932', // ok

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F8F6F4', // ok
					'alter_bg_hover'   => '#F1EDE8', //
					'alter_bd_color'   => '#E4DDD8', // ok
					'alter_bd_hover'   => '#D8CDC7', //
					'alter_text'       => '#54605E', //
					'alter_light'      => '#ABABAB', // ok
					'alter_dark'       => '#151515', // ok
					'alter_link'       => '#155247', // ok
					'alter_hover'      => '#0D453B', // ok
					'alter_link2'      => '#E1DABB', // ok
					'alter_hover2'     => '#D9D0AB', // ok
					'alter_link3'      => '#A17C48', // ok
					'alter_hover3'     => '#8F6932', // ok

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#162231', // ok
					'extra_bg_hover'   => '#233142',
					'extra_bd_color'   => '#174171',
					'extra_bd_hover'   => '#255081',
					'extra_text'       => '#BDC3CA', //
					'extra_light'      => '#828CA7',
					'extra_dark'       => '#ECEFF2', //
					'extra_link'       => '#155247', // ok
					'extra_hover'      => '#ECEFF2', //
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //
					'input_bg_hover'   => 'transparent', //
					'input_bd_color'   => '#E4DDD8', // ok
					'input_bd_hover'   => '#151515', // ok
					'input_text'       => '#54605E', // ok
					'input_light'      => '#ABABAB', // ok
					'input_dark'       => '#151515', // ok

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#151515', // ok
					'inverse_link'     => '#ffffff', //
					'inverse_hover'    => '#ffffff', //

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		confidant_storage_set( 'schemes', $schemes );
		confidant_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> confidant_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'confidant' ),
		//---> 	'description' => __( 'Description of the new color 1', 'confidant' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		confidant_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		confidant_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		confidant_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		confidant_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'confidant' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'confidant' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}

// Enqueue extra styles for frontend
if ( ! function_exists( 'confidant_clone_extra_styles' ) ) {
    add_action( 'wp_enqueue_scripts', 'confidant_clone_extra_styles', 2060 );
    function confidant_clone_extra_styles() {
        $confidant_url = confidant_get_file_url( 'extra-styles.css' );
        if ( '' != $confidant_url ) {
            wp_enqueue_style( 'confidant-clone-extra-styles', $confidant_url, array(), null );
        }
    }
}

// Activation methods
if ( ! function_exists( 'confidant_clone_filter_activation_methods2' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'confidant_clone_filter_activation_methods2', 11, 1 );
    function confidant_clone_filter_activation_methods2( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}

// Change thumb size for Accent team
if ( ! function_exists( 'confidant_clone_thumb_size_team' ) ) {
	add_filter( 'trx_addons_filter_args_featured', 'confidant_clone_thumb_size_team', 10, 2 );
	function confidant_clone_thumb_size_team( $args=array(), $type = '' ) {
	   if ($type == 'team-accent') {
		  $args['thumb_size'] = confidant_get_thumb_size('full');
	   }
	   return $args;
	}
  }