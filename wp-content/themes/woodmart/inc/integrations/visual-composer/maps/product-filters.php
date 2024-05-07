<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}
/**
* ------------------------------------------------------------------------------------------------
* Product filters
* ------------------------------------------------------------------------------------------------
*/
if ( ! function_exists( 'woodmart_get_vc_map_product_filters' ) ) {
	function woodmart_get_vc_map_product_filters() {
		$title_typography = woodmart_get_typography_map(
			array(
				'key'      => 'title_typography',
				'selector' => '{{WRAPPER}} .wd-pf-title .title-text',
				'group'    => esc_html__( 'Style', 'woodmart' ),
			)
		);

		return array(
			'name'                    => esc_html__( 'Product filters', 'woodmart' ),
			'base'                    => 'woodmart_product_filters',
			'class'                   => '',
			'category'                => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description'             => esc_html__( 'Add filters by category, attribute or price', 'woodmart' ),
			'icon'                    => WOODMART_ASSETS . '/images/vc-icon/product-filter.svg',
			'as_parent'               => array( 'only' => 'woodmart_filter_categories, woodmart_filters_attribute, woodmart_filters_price_slider, woodmart_stock_status, woodmart_filters_orderby' ),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'params'                  => array(
				/**
				 * General tab.
				 */
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Submit form on', 'woodmart' ),
					'param_name'       => 'submit_form_on',
					'value'            => array(
						esc_html__( 'Button click', 'woodmart' ) => 'click',
						esc_html__( 'Dropdown select', 'woodmart' ) => 'select',
					),
					'std'              => 'click',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show selected values in dropdown', 'woodmart' ),
					'param_name'       => 'show_selected_values',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'yes',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Show dropdown on', 'woodmart' ),
					'param_name'       => 'show_dropdown_on',
					'value'            => array(
						esc_html__( 'Hover', 'woodmart' ) => 'hover',
						esc_html__( 'Click', 'woodmart' ) => 'click',
					),
					'std'              => 'click',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),

				/**
				 * Style tab.
				 */

				/**
				 * General settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'General', 'woodmart' ),
					'param_name' => 'title_style_section',
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'holder'     => 'div',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'style',
					'value'            => array(
						esc_html__( 'Simplified', 'woodmart' ) => 'simplified',
						esc_html__( 'Form', 'woodmart' )       => 'form',
						esc_html__( 'Form underlined', 'woodmart' ) => 'form-underlined',
					),
					'std'              => 'form',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Display grid', 'woodmart' ),
					'param_name'       => 'display_grid',
					'value'            => array(
						esc_html__( 'Stretch', 'woodmart' ) => 'stretch',
						esc_html__( 'Inline', 'woodmart' )  => 'inline',
						esc_html__( 'Number', 'woodmart' )  => 'number',
					),
					'std'              => 'stretch',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'wd_slider',
					'heading'          => esc_html__( 'Columns', 'woodmart' ),
					'param_name'       => 'display_grid_col',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit'  => '-',
							'value' => 4,
						),
						'tablet'  => array(
							'unit'  => '-',
							'value' => 0,
						),
						'mobile'  => array(
							'unit'  => '-',
							'value' => 0,
						),
					),
					'range'            => array(
						'-' => array(
							'min'  => 1,
							'max'  => 12,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}} [class*="wd-grid-col"]' => array(
							'--wd-col: {{VALUE}}',
						),
					),
					'dependency'       => array(
						'element' => 'display_grid',
						'value'   => array( 'number' ),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'wd_select',
					'heading'          => esc_html__( 'Space between', 'woodmart' ),
					'param_name'       => 'space_between',
					'style'            => 'select',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(),
					'devices'          => array(
						'desktop' => array(
							'value' => '10',
						),
					),
					'value'            => array(
						esc_html__( '0 px', 'woodmart' )  => '0',
						esc_html__( '2 px', 'woodmart' )  => '2',
						esc_html__( '6 px', 'woodmart' )  => '6',
						esc_html__( '10 px', 'woodmart' ) => '10',
						esc_html__( '20 px', 'woodmart' ) => '20',
						esc_html__( '30 px', 'woodmart' ) => '30',
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Color Scheme', 'woodmart' ),
					'param_name' => 'woodmart_color_scheme',
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'value'      => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' )  => 'dark',
					),
				),

				/**
				 * Title settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title_style_section',
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'holder'     => 'div',
				),
				array(
					'type'             => 'wd_colorpicker',
					'heading'          => esc_html__( 'Idle color', 'woodmart' ),
					'param_name'       => 'title_idle_color',
					'selectors'        => array(
						'{{WRAPPER}} .title-text' => array(
							'color: {{VALUE}};',
						),
					),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_colorpicker',
					'heading'          => esc_html__( 'Hover color', 'woodmart' ),
					'param_name'       => 'title_hover_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-pf-checkboxes:hover .title-text, {{WRAPPER}} .wd-pf-checkboxes.wd-opened .title-text' => array(
							'color: {{VALUE}};',
						),
					),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Border color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_brd_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-product-filters' => array(
							'--wd-form-brd-color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'style',
						'value'   => array( 'form', 'form-underlined' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Border color focus', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_brd_color_focus',
					'selectors'        => array(
						'{{WRAPPER}} .wd-product-filters' => array(
							'--wd-form-brd-color-focus: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'style',
						'value'   => array( 'form', 'form-underlined' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_bg',
					'selectors'        => array(
						'{{WRAPPER}} .wd-product-filters' => array(
							'--wd-form-bg: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'style',
						'value'   => array( 'form' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				$title_typography['font_family'],
				$title_typography['font_size'],
				$title_typography['font_weight'],
				$title_typography['text_transform'],
				$title_typography['font_style'],
				$title_typography['line_height'],
				/**
				 * Design Options tab.
				 */
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'woodmart' ),
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
			'js_view'                 => 'VcColumnView',
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_filter_categories' ) ) {
	function woodmart_get_vc_map_filter_categories() {
		return array(
			'name'            => esc_html__( 'Filter categories', 'woodmart' ),
			'base'            => 'woodmart_filter_categories',
			'as_child'        => array( 'only' => 'woodmart_product_filters' ),
			'content_element' => true,
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/product-filter-categories.svg',
			'params'          => array(
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'General options', 'woodmart' ),
					'param_name' => 'general_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Order by', 'woodmart' ),
					'param_name'       => 'order_by',
					'value'            => array(
						esc_html__( 'Name', 'woodmart' ) => 'name',
						esc_html__( 'ID', 'woodmart' ) => 'ID',
						esc_html__( 'Slug', 'woodmart' ) => 'slug',
						esc_html__( 'Count', 'woodmart' ) => 'count',
						esc_html__( 'Category order', 'woodmart' ) => 'order',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show hierarchy', 'woodmart' ),
					'param_name'       => 'hierarchical',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide empty categories', 'woodmart' ),
					'param_name'       => 'hide_empty',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 0,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show current category ancestors', 'woodmart' ),
					'param_name'       => 'show_categories_ancestors',
					'hint'             => esc_html__( 'If you visit category Man, for example, only man\'s subcategories will be shown in the page title like T-shirts, Coats, Shoes etc.', 'woodmart' ),
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 0,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name'       => 'el_class',
					'hint'             => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
			),
			array(
				'type' => 'woodmart_switch',
				'heading' => esc_html__( 'Show labels', 'woodmart' ),
				'param_name' => 'labels',
				'true_state' => 1,
				'false_state' => 0,
				'default' => 1,
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'woodmart_title_divider',
				'holder' => 'div',
				'title' => esc_html__( 'Extra options', 'woodmart' ),
				'param_name' => 'extra_divider'
			),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_filters_attribute' ) ) {
	function woodmart_get_vc_map_filters_attribute() {
		$attribute_array = array( '' => '' );

		if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
			$attribute_taxonomies = wc_get_attribute_taxonomies();

			if ( $attribute_taxonomies ) {
				foreach ( $attribute_taxonomies as $tax ) {
					$attribute_array[ $tax->attribute_name ] = $tax->attribute_name;
				}
			}
		}

		return array(
			'name'            => esc_html__( 'Filter attribute', 'woodmart' ),
			'base'            => 'woodmart_filters_attribute',
			'as_child'        => array( 'only' => 'woodmart_product_filters' ),
			'content_element' => true,
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/product-filter-atribute.svg',
			'params'          => array(
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'General options', 'woodmart' ),
					'param_name' => 'general_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Attribute', 'woodmart' ),
					'param_name'       => 'attribute',
					'value'            => $attribute_array,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'autocomplete',
					'heading'          => esc_html__( 'Show in categories', 'woodmart' ),
					'param_name'       => 'categories',
					'settings'         => array(
						'multiple' => true,
						'sortable' => true,
					),
					'save_always'      => true,
					'hint'             => esc_html__( 'Choose on which categories pages you want to display this filter. Or leave empty to show on all pages.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Query type', 'woodmart' ),
					'param_name'       => 'query_type',
					'hint'             => esc_html__( 'If you select “AND”, you will be allowed to select only one attribute. In case of “OR”, you will be able to select multiple values.', 'woodmart' ),
					'value'            => array(
						esc_html__( 'AND', 'woodmart' ) => 'and',
						esc_html__( 'OR', 'woodmart' ) => 'or',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Swatches size', 'woodmart' ),
					'param_name'       => 'size',
					'value'            => array(
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Medium', 'woodmart' ) => 'normal',
						esc_html__( 'Large', 'woodmart' ) => 'large',
					),
					'std'              => 'normal',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Swatches shape', 'woodmart' ),
					'param_name'       => 'shape',
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Round', 'woodmart' ) => 'round',
						esc_html__( 'Rounded', 'woodmart' ) => 'rounded',
						esc_html__( 'Square', 'woodmart' ) => 'square',
					),
					'std'              => 'inherit',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Swatch style', 'woodmart' ),
					'param_name'       => 'swatch_style',
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Style 1', 'woodmart' ) => '1',
						esc_html__( 'Style 2', 'woodmart' ) => '2',
						esc_html__( 'Style 3', 'woodmart' ) => '3',
						esc_html__( 'Style 4', 'woodmart' ) => '4',
					),
					'std'              => 'inherit',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Layout', 'woodmart' ),
					'param_name'       => 'display',
					'value'            => array(
						esc_html__( 'List', 'woodmart' )   => 'list',
						esc_html__( '2 columns', 'woodmart' ) => 'double',
						esc_html__( 'Inline', 'woodmart' ) => 'inline',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show labels', 'woodmart' ),
					'param_name'       => 'labels',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' )
				)
			),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_stock_status' ) ) {
	function woodmart_get_vc_map_stock_status() {
		return array(
			'name'            => esc_html__( 'Stock status', 'woodmart' ),
			'base'            => 'woodmart_stock_status',
			'as_child'        => array( 'only' => 'woodmart_product_filters' ),
			'content_element' => true,
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/product-filter-atribute.svg',
			'params'          => array(
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'General options', 'woodmart' ),
					'param_name' => 'general_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show labels', 'woodmart' ),
					'param_name'       => 'labels',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'On Sale filter', 'woodmart' ),
					'param_name'       => 'onsale',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-4 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'In Stock filter', 'woodmart' ),
					'param_name'       => 'instock',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-4 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'On backorder filter', 'woodmart' ),
					'param_name'       => 'onbackorder',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-4 vc_column',
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
			),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_filters_price_slider' ) ) {
	function woodmart_get_vc_map_filters_price_slider() {
		return array(
			'name'            => esc_html__( 'Filter price', 'woodmart' ),
			'base'            => 'woodmart_filters_price_slider',
			'as_child'        => array( 'only' => 'woodmart_product_filters' ),
			'content_element' => true,
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/product-filter-price.svg',
			'params'          => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
			),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_filters_orderby' ) ) {
	function woodmart_get_vc_map_filters_orderby() {
		return array(
			'name'            => esc_html__( 'Order by', 'woodmart' ),
			'base'            => 'woodmart_filters_orderby',
			'as_child'        => array( 'only' => 'woodmart_product_filters' ),
			'content_element' => true,
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/product-filter-atribute.svg',
			'params'          => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
			),
		);
	}
}

add_filter( 'vc_autocomplete_woodmart_filters_attribute_categories_callback', 'woodmart_productCategoryCategoryAutocompleteSuggester', 10, 1 );

add_filter( 'vc_autocomplete_woodmart_filters_attribute_categories_render', 'woodmart_productCategoryCategoryRenderByIdExact', 10, 1 );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_woodmart_product_filters extends WPBakeryShortCodesContainer {}

	class WPBakeryShortCode_woodmart_filter_categories extends WPBakeryShortCode {}

	class WPBakeryShortCode_woodmart_filters_attribute extends WPBakeryShortCode {}

	class WPBakeryShortCode_woodmart_filters_price_slider extends WPBakeryShortCode {}

	class WPBakeryShortCode_woodmart_filters_orderby extends WPBakeryShortCode {}

	class WPBakeryShortCode_woodmart_stock_status extends WPBakeryShortCode {}
}
