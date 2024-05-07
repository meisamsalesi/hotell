<?php
/**
 * Frequently bought together map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_single_product_fbt_products' ) ) {
	/**
	 * Frequently bought together map.
	 */
	function woodmart_get_vc_map_single_product_fbt_products() {
		$typography = woodmart_get_typography_map(
			array(
				'key'      => 'title',
				'selector' => '{{WRAPPER}} .element-title',
			)
		);

		return array(
			'base'        => 'woodmart_single_product_fbt_products',
			'name'        => esc_html__( 'Frequently bought together', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
			'description' => esc_html__( 'Bought together table', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-frequently-bought-together.svg',
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
				),

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'title_color',
					'selectors'        => array(
						'{{WRAPPER}} .element-title' => array(
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
					'title'      => esc_html__( 'Carousel', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'carousel_divider',
				),

				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Products columns', 'woodmart' ),
					'param_name'       => 'slides_per_view_tabs',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
						esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
						esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
					),
					'default'          => 'desktop',
					'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'slides_per_view',
					'value'            => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
					'std'              => '3',
					'wd_dependency'    => array(
						'element' => 'slides_per_view_tabs',
						'value'   => array( 'desktop' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'slides_per_view_tablet',
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1' => '1',
						'2' => '2',
						'3' => '3',
					),
					'std'              => 'auto',
					'wd_dependency'    => array(
						'element' => 'slides_per_view_tabs',
						'value'   => array( 'tablet' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'slides_per_view_mobile',
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1' => '1',
						'2' => '2',
					),
					'std'              => 'auto',
					'wd_dependency'    => array(
						'element' => 'slides_per_view_tabs',
						'value'   => array( 'mobile' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),

				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide pagination control', 'woodmart' ),
					'param_name'       => 'hide_pagination_control',
					'hint'             => esc_html__( 'If "YES" pagination control will be removed', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
					'param_name'       => 'hide_prev_next_buttons',
					'hint'             => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'title'      => esc_html__( 'Settings', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'settings_divider',
				),

				array(
					'heading'    => esc_html__( 'Form width', 'woodmart' ),
					'type'       => 'wd_slider',
					'param_name' => 'form_width',
					'selectors'  => array(
						'{{WRAPPER}} .wd-fbt.wd-design-side' => array( '--wd-form-width: {{VALUE}}{{UNIT}};' ),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'      => array(
						'px' => array(
							'min'  => 250,
							'max'  => 600,
							'step' => 1,
						),
						'%'  => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
				),

				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),
			),
		);
	}
}
