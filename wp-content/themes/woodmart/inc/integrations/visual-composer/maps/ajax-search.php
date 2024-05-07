<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
*  AJAX search element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_vc_map_ajax_search' ) ) {
	function woodmart_get_vc_map_ajax_search() {
		return array(
			'name'        => esc_html__( 'AJAX Search', 'woodmart' ),
			'description' => esc_html__( 'Shows AJAX search form', 'woodmart' ),
			'base'        => 'woodmart_ajax_search',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/ajax-search.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				/**
				 * Search results
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Search results', 'woodmart' ),
					'param_name' => 'results_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Number results to show', 'woodmart' ),
					'param_name'       => 'number',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Search post type', 'woodmart' ),
					'param_name'       => 'search_post_type',
					'value'            => array(
						esc_html__( 'Product', 'woodmart' ) => 'product',
						esc_html__( 'Post', 'woodmart' ) => 'post',
						esc_html__( 'Portfolio', 'woodmart' ) => 'portfolio',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show price', 'woodmart' ),
					'param_name'       => 'price',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show thumbnail', 'woodmart' ),
					'param_name'       => 'thumbnail',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Show category', 'woodmart' ),
					'param_name'       => 'category',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 1,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Categories selector style', 'woodmart' ),
					'param_name'       => 'cat_selector_style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Separated', 'woodmart' ) => 'separated',
					),
					'std'              => 'bordered',
					'dependency'       => array(
						'element' => 'category',
						'value'   => '1',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Style
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Form', 'woodmart' ),
					'param_name' => 'style_divider',
				),
				array(
					'heading'          => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'woodmart_image_select',
					'param_name'       => 'form_style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With background', 'woodmart' ) => 'with-bg',
						esc_html__( 'With background 2', 'woodmart' ) => 'with-bg-2',
					),
					'images_value'     => array(
						'default'   => WOODMART_ASSETS_IMAGES . '/header-builder/search/default.jpg',
						'with-bg'   => WOODMART_ASSETS_IMAGES . '/header-builder/search/with-bg.jpg',
						'with-bg-2' => WOODMART_ASSETS_IMAGES . '/header-builder/search/with-bg-2.jpg',
					),
					'std'              => 'default',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-12 vc_column wd-form-style',
				),
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Color Scheme', 'woodmart' ),
					'param_name' => 'woodmart_color_scheme',
					'value'      => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' )  => 'dark',
					),
				),
				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_color',
					'selectors'        => array(
						'{{WRAPPER}} .searchform' => array(
							'--wd-form-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Placeholder color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_placeholder_color',
					'selectors'        => array(
						'{{WRAPPER}} .searchform' => array(
							'--wd-form-placeholder-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Border color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_brd_color',
					'selectors'        => array(
						'{{WRAPPER}} .searchform' => array(
							'--wd-form-brd-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Border color focus', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_brd_color_focus',
					'selectors'        => array(
						'{{WRAPPER}} .searchform' => array(
							'--wd-form-brd-color-focus: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_bg',
					'selectors'        => array(
						'{{WRAPPER}} .searchform' => array(
							'--wd-form-bg: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'       => esc_html__( 'Form shape', 'woodmart' ),
					'type'          => 'wd_select',
					'param_name'    => 'form_shape',
					'selectors'     => array(
						'{{WRAPPER}}' => array(
							'--wd-form-brd-radius: {{VALUE}}px;',
						),
					),
					'devices'       => array(
						'desktop' => array(
							'value' => '',
						),
					),
					'value'         => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Square', 'woodmart' ) => '0',
						esc_html__( 'Rounded', 'woodmart' ) => '5',
						esc_html__( 'Round', 'woodmart' )   => '35',
					),
					'generate_zero' => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_options_divider',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				woodmart_get_vc_responsive_spacing_map(),
			),
		);
	}
}
