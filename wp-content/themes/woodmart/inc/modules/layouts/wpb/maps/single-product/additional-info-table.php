<?php
/**
 * Additional info table map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_single_product_additional_info_table' ) ) {
	/**
	 * Additional info table map.
	 */
	function woodmart_get_vc_map_single_product_additional_info_table() {
		$typography = woodmart_get_typography_map(
			array(
				'key'      => 'title',
				'selector' => '{{WRAPPER}} .title-text',
			)
		);

		$name_typography = woodmart_get_typography_map(
			array(
				'title'         => esc_html__( 'Name typography', 'woodmart' ),
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'key'           => 'attr_name',
				'selector'      => '{{WRAPPER}} .woocommerce-product-attributes-item__label',
				'wd_dependency' => array(
					'element' => 'attributes_style_tabs',
					'value'   => array( 'name' ),
				),
			)
		);
		$term_typography = woodmart_get_typography_map(
			array(
				'title'         => esc_html__( 'Term typography', 'woodmart' ),
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'key'           => 'attr_term',
				'selector'      => '{{WRAPPER}} .woocommerce-product-attributes-item__value',
				'wd_dependency' => array(
					'element' => 'attributes_style_tabs',
					'value'   => array( 'term' ),
				),
			)
		);

		return array(
			'base'        => 'woodmart_single_product_additional_info_table',
			'name'        => esc_html__( 'Product additional information table', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
			'description' => esc_html__( 'Attributes, dimensions, and weight', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-additional-information-table.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				array(
					'title'      => esc_html__( 'Title', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'title_divider',
				),

				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Element title', 'woodmart' ),
					'param_name' => 'title',
					'holder'     => 'div',
				),

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'title_color',
					'selectors'        => array(
						'{{WRAPPER}} .title-text' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				$typography['font_family'],
				$typography['font_size'],
				$typography['font_weight'],
				$typography['text_transform'],
				$typography['font_style'],
				$typography['line_height'],

				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Icon type', 'woodmart' ),
					'param_name'       => 'icon_type',
					'value'            => array(
						esc_html__( 'Without icon', 'woodmart' ) => 'without',
						esc_html__( 'With icon', 'woodmart' ) => 'icon',
						esc_html__( 'With image', 'woodmart' ) => 'image',
					),
					'std'              => 'without',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x50 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x50\'.', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Icon library', 'woodmart' ),
					'param_name'       => 'icon_library',
					'value'            => array(
						esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'woodmart' ) => 'openiconic',
						esc_html__( 'Typicons', 'woodmart' ) => 'typicons',
						esc_html__( 'Entypo', 'woodmart' ) => 'entypo',
						esc_html__( 'Linecons', 'woodmart' ) => 'linecons',
						esc_html__( 'Mono Social', 'woodmart' ) => 'monosocial',
						esc_html__( 'Material', 'woodmart' ) => 'material',
					),
					'hint'             => esc_html__( 'Select icon library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'icon',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'icon_fontawesome',
					'value'            => 'far fa-bell',
					'settings'         => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'fontawesome',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'icon_openiconic',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'openiconic',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'icon_typicons',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'typicons',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'icon_entypo',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'entypo',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'icon_linecons',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'linecons',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'icon_monosocial',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'monosocial',
					),
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'iconpicker',
					'heading'          => esc_html__( 'Icon', 'woodmart' ),
					'param_name'       => 'icon_material',
					'settings'         => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 50,
					),
					'dependency'       => array(
						'element' => 'icon_library',
						'value'   => 'material',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'heading'          => esc_html__( 'Icons color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'icons_color',
					'selectors'        => array(
						'{{WRAPPER}} .title-icon' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => array( 'icon' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Icon size', 'woodmart' ),
					'type'             => 'wd_slider',
					'param_name'       => 'icon_size',
					'selectors'        => array(
						'{{WRAPPER}} .title-icon' => array(
							'font-size: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1,
						),
					),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => array( 'icon' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'title'      => esc_html__( 'Data source', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'general_divider',
				),

				array(
					'heading'          => '',
					'type'             => 'woodmart_button_set',
					'param_name'       => 'data_source',
					'value'            => array(
						esc_html__( 'All', 'woodmart' ) => 'all',
						esc_html__( 'Include', 'woodmart' ) => 'include',
						esc_html__( 'Exclude', 'woodmart' )     => 'exclude',
					),
					'default'          => 'all',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				array(
					'type'       => 'autocomplete',
					'heading'    => esc_html__( 'Include', 'woodmart' ),
					'param_name' => 'include',
					'settings'   => array(
						'multiple'   => true,
						'sortable'   => true,
						'min_length' => 1,
					),
					'dependency' => array(
						'element' => 'data_source',
						'value'   => array( 'include' ),
					),
				),

				array(
					'type'       => 'autocomplete',
					'heading'    => esc_html__( 'Exclude', 'woodmart' ),
					'param_name' => 'exclude',
					'settings'   => array(
						'multiple'   => true,
						'sortable'   => true,
						'min_length' => 1,
					),
					'dependency' => array(
						'element' => 'data_source',
						'value'   => array( 'exclude' ),
					),
				),

				// General.
				array(
					'title'      => esc_html__( 'General', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'general_divider',
				),

				array(
					'heading'          => esc_html__( 'Layout', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'dropdown',
					'param_name'       => 'layout',
					'value'            => array(
						esc_html__( 'List', 'woodmart' ) => 'list',
						esc_html__( 'Grid', 'woodmart' ) => 'grid',
					),
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Style', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'dropdown',
					'param_name'       => 'style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' )  => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
					),
					'std'              => 'bordered',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'    => esc_html__( 'Columns', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'columns',
					'selectors'  => array(
						'{{WRAPPER}} .shop_attributes' => array(
							'--wd-attr-col: {{VALUE}};',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => '',
							'unit'  => '-',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => '-',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => '-',
						),
					),
					'range'      => array(
						'-' => array(
							'min'  => 1,
							'max'  => 6,
							'step' => 1,
						),
					),
				),

				array(
					'heading'    => esc_html__( 'Vertical spacing', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'vertical_gap',
					'selectors'  => array(
						'{{WRAPPER}} .shop_attributes' => array(
							'--wd-attr-v-gap: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 150,
							'step' => 1,
						),
					),
				),

				array(
					'heading'    => esc_html__( 'Horizontal spacing', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'horizontal_gap',
					'selectors'  => array(
						'{{WRAPPER}} .shop_attributes' => array(
							'--wd-attr-h-gap: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 150,
							'step' => 1,
						),
					),
				),

				// Attributes.
				array(
					'title'      => esc_html__( 'Attributes', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'attributes_divider',
				),

				array(
					'heading'     => esc_html__( 'Image width', 'woodmart' ),
					'group'       => esc_html__( 'Style', 'woodmart' ),
					'description' => esc_html__( 'Attribute image container width', 'woodmart' ),
					'type'        => 'wd_slider',
					'param_name'  => 'image_width',
					'selectors'   => array(
						'{{WRAPPER}} .shop_attributes' => array(
							'--wd-attr-img-width: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'     => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'       => array(
						'px' => array(
							'min'  => 0,
							'max'  => 300,
							'step' => 1,
						),
					),
				),

				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Typography', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'attributes_style_tabs',
					'tabs'       => true,
					'value'      => array(
						esc_html__( 'Name', 'woodmart' ) => 'name',
						esc_html__( 'Term', 'woodmart' ) => 'term',
					),
					'default'    => 'name',
				),

				$name_typography['font_family'],
				$name_typography['font_size'],
				$name_typography['font_weight'],
				$name_typography['text_transform'],
				$name_typography['font_style'],
				$name_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Name color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'attr_name_color',
					'selectors'        => array(
						'{{WRAPPER}} .woocommerce-product-attributes-item__label' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'attributes_style_tabs',
						'value'   => array( 'name' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				$term_typography['font_family'],
				$term_typography['font_size'],
				$term_typography['font_weight'],
				$term_typography['text_transform'],
				$term_typography['font_style'],
				$term_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Term color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'attr_term_color',
					'selectors'        => array(
						'{{WRAPPER}} .woocommerce-product-attributes-item__value' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'attributes_style_tabs',
						'value'   => array( 'term' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),

				// Width option (with dependency Columns option, responsive).
				woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
				woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),
			),
		);
	}
}

if ( ! function_exists( 'wd_autocomplete_products_attributes_field_search' ) ) {
	/**
	 * Output search autocomplete results.
	 *
	 * @param string $search Search attribute.
	 *
	 * @return array
	 */
	function wd_autocomplete_products_attributes_field_search( $search ) {
		$data       = array();
		$attributes = woodmart_get_products_attributes();

		if ( $attributes ) {
			foreach ( $attributes as $key => $attribute ) {
				if ( false === strpos( strtolower( $attribute ), strtolower( $search ) ) ) {
					continue;
				}

				$data[] = array(
					'value' => $key,
					'label' => $attribute,
				);
			}
		}

		return $data;
	}

	add_filter( 'vc_autocomplete_woodmart_single_product_additional_info_table_include_callback', 'wd_autocomplete_products_attributes_field_search', 10, 1 );
	add_filter( 'vc_autocomplete_woodmart_single_product_additional_info_table_exclude_callback', 'wd_autocomplete_products_attributes_field_search', 10, 1 );
}

if ( ! function_exists( 'wd_autocomplete_products_attributes_field_render' ) ) {
	/**
	 * Render controls field.
	 *
	 * @param array $value Save value.
	 *
	 * @return array|bool
	 */
	function wd_autocomplete_products_attributes_field_render( $value ) {
		if ( empty( $value['value'] ) ) {
			return false;
		}

		$wc_attributes  = wc_get_attribute_taxonomy_labels();
		$all_attributes = array();

		$all_attributes['weight']     = esc_html__( 'Weight', 'woocommerce' );
		$all_attributes['dimensions'] = esc_html__( 'Dimensions', 'woocommerce' );

		if ( $wc_attributes ) {
			foreach ( $wc_attributes as $key => $attribute ) {
				$all_attributes[ 'pa_' . $key ] = $attribute . ' (pa_' . $key . ')';
			}
		}

		return empty( $all_attributes[ $value['value'] ] ) ? false : array(
			'label' => $all_attributes[ $value['value'] ],
			'value' => $value['value'],
		);
	}

	add_filter( 'vc_autocomplete_woodmart_single_product_additional_info_table_include_render', 'wd_autocomplete_products_attributes_field_render', 10, 1 );
	add_filter( 'vc_autocomplete_woodmart_single_product_additional_info_table_exclude_render', 'wd_autocomplete_products_attributes_field_render', 10, 1 );
}
