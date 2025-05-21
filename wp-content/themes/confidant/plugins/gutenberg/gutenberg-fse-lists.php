<?php
/**
 * Gutenberg Full-Site Editor (FSE) lists with different templates: headers, footers, sidebars.
 */

if ( ! function_exists( 'confidant_gutenberg_fse_list_header_styles' ) ) {
	add_filter( 'confidant_filter_list_header_styles', 'confidant_gutenberg_fse_list_header_styles');
	/**
	 * Add a WordPress FSE templates to the headers list.
	 * 
	 * Hooks: add_filter( 'confidant_filter_list_header_styles', 'confidant_gutenberg_fse_list_header_styles');
	 * 
	 * @param array $list  Optional. An array with a list of headers from other available Page Builders.
	 */
	function confidant_gutenberg_fse_list_header_styles( $list = array() ) {
		if ( ! confidant_gutenberg_is_fse_theme() ) {
			return $list;
		}
		$new_list = array();
		// Add a changed templates and new templates (created by user)
		$layouts = confidant_get_list_posts(
			false, array(
				'post_type'    => CONFIDANT_FSE_TEMPLATE_PART_PT,
				'orderby'      => 'ID',
				'order'        => 'asc',
				'not_selected' => false,
				//'return'       => 'post_name',
				'tax_query'    => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'wp_theme',
											'field'    => 'name',
											'terms'    => get_stylesheet(),
										),
										array(
											'taxonomy' => 'wp_template_part_area',
											'field'    => 'name',
											'terms'    => CONFIDANT_FSE_TEMPLATE_PART_AREA_HEADER,
										)
									)
			)
		);
		foreach ( $layouts as $id => $title ) {
			if ( 'none' != $id && ! in_array( $title, $new_list ) ) {
				$new_list[ 'header-fse-template-' . trim( $id ) ] = $title;
			}
		}
		// Add a default templates
		$data = confidant_gutenberg_fse_theme_json_data();
		if ( ! empty( $data['templateParts'] ) && is_array( $data['templateParts'] ) ) {
			foreach ( $data['templateParts'] as $template ) {
				if ( ! empty( $template['area'] )
					&& CONFIDANT_FSE_TEMPLATE_PART_AREA_HEADER == $template['area']
					&& ! in_array( $template['title'], $new_list )
				) {
					$new_list[ 'header-fse-template-' . trim( $template['name'] ) ] = $template['title'];
				}
			}
		}
		// Merge to the list
		$list = confidant_array_merge( $new_list, $list );
		return $list;
	}
}

if ( ! function_exists( 'confidant_gutenberg_fse_list_footer_styles' ) ) {
	add_filter( 'confidant_filter_list_footer_styles', 'confidant_gutenberg_fse_list_footer_styles');
	/**
	 * Add a WordPress FSE templates to the footers list.
	 * 
	 * Hooks: add_filter( 'confidant_filter_list_footer_styles', 'confidant_gutenberg_fse_list_footer_styles');
	 * 
	 * @param array $list  Optional. An array with a list of footers from other available Page Builders.
	 */
	function confidant_gutenberg_fse_list_footer_styles( $list = array() ) {
		if ( ! confidant_gutenberg_is_fse_theme() ) {
			return $list;
		}
		$new_list = array();
		// Add a changed templates and new templates (created by user)
		$layouts = confidant_get_list_posts(
			false, array(
				'post_type'    => CONFIDANT_FSE_TEMPLATE_PART_PT,
				'orderby'      => 'ID',
				'order'        => 'asc',
				'not_selected' => false,
				//'return'       => 'post_name',
				'tax_query'    => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'wp_theme',
											'field'    => 'name',
											'terms'    => get_stylesheet(),
										),
										array(
											'taxonomy' => 'wp_template_part_area',
											'field'    => 'name',
											'terms'    => CONFIDANT_FSE_TEMPLATE_PART_AREA_FOOTER,
										)
									)
			)
		);
		foreach ( $layouts as $id => $title ) {
			if ( 'none' != $id && ! in_array( $title, $new_list ) ) {
				$new_list[ 'footer-fse-template-' . trim( $id ) ] = $title;
			}
		}
		// Add a default templates
		$data = confidant_gutenberg_fse_theme_json_data();
		if ( ! empty( $data['templateParts'] ) && is_array( $data['templateParts'] ) ) {
			foreach ( $data['templateParts'] as $template ) {
				if ( ! empty( $template['area'] )
					&& CONFIDANT_FSE_TEMPLATE_PART_AREA_FOOTER == $template['area']
					&& ! in_array( $template['title'], $new_list )
				) {
					$new_list[ 'footer-fse-template-' . trim( $template['name'] ) ] = $template['title'];
				}
			}
		}
		// Merge to the list
		$list = confidant_array_merge( $new_list, $list );
		return $list;
	}
}

if ( ! function_exists( 'confidant_gutenberg_fse_list_sidebar_styles' ) ) {
	add_filter( 'confidant_filter_list_sidebar_styles', 'confidant_gutenberg_fse_list_sidebar_styles');
	/**
	 * Add a WordPress FSE templates to the sidebars list.
	 * 
	 * Hooks: add_filter( 'confidant_filter_list_sidebar_styles', 'confidant_gutenberg_fse_list_sidebar_styles');
	 * 
	 * @param array $list  Optional. An array with a list of sidebars from other available Page Builders.
	 */
	function confidant_gutenberg_fse_list_sidebar_styles( $list = array() ) {
		if ( ! confidant_gutenberg_is_fse_theme() ) {
			return $list;
		}
		$new_list = array();
		// Add a changed templates and new templates (created by user)
		$layouts = confidant_get_list_posts(
			false, array(
				'post_type'    => CONFIDANT_FSE_TEMPLATE_PART_PT,
				'orderby'      => 'ID',
				'order'        => 'asc',
				'not_selected' => false,
				//'return'       => 'post_name',
				'tax_query'    => array(
										'relation' => 'AND',
										array(
											'taxonomy' => 'wp_theme',
											'field'    => 'name',
											'terms'    => get_stylesheet(),
										),
										// FSE is have not a separate area for sidebars
										array(
											'taxonomy' => 'wp_template_part_area',
											'field'    => 'name',
											'terms'    => CONFIDANT_FSE_TEMPLATE_PART_AREA_SIDEBAR,
										)
									)
			)
		);
		foreach ( $layouts as $id => $title ) {
			if ( 'none' != $id && ! in_array( $title, $new_list ) ) {
				$new_list[ 'sidebar-fse-template-' . trim( $id ) ] = $title;
			}
		}
		// Add a default templates
		$data = confidant_gutenberg_fse_theme_json_data();
		if ( ! empty( $data['templateParts'] ) && is_array( $data['templateParts'] ) ) {
			foreach ( $data['templateParts'] as $template ) {
				if ( ! empty( $template['area'] )
					&& CONFIDANT_FSE_TEMPLATE_PART_AREA_SIDEBAR == $template['area']
					&& ! in_array( $template['title'], $new_list )
				) {
					$new_list[ 'sidebar-fse-template-' . trim( $template['name'] ) ] = $template['title'];
				}
			}
		}
		// Merge to the list
		$list = confidant_array_merge( $new_list, $list );
		return $list;
	}
}
