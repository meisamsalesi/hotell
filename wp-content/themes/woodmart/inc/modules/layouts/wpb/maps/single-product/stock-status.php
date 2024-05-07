<?php
/**
 * Stock status map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_single_product_stock_status' ) ) {
	/**
	 * Content map.
	 */
	function woodmart_get_vc_map_single_product_stock_status() {
		return array(
			'base'        => 'woodmart_single_product_stock_status',
			'name'        => esc_html__( 'Product stock status', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
			'description' => esc_html__( 'Show product stock status', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-stock-status.svg',
			'params'      => array(
				array(
					'group'      => esc_html__( 'Style', 'js_composer' ),
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				/**
				 * Style options Tab.
				 */
				array(
					'heading'    => esc_html__( 'Inner margin', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'hint'        => esc_html__( 'Useful for variable products where the \'Stock status\' label appears after selecting a variation.', 'woodmart' ),
					'type'       => 'wd_dimensions',
					'param_name' => 'inner_margin',
					'selectors'  => array(
						'{{WRAPPER}} p.stock' => array(
							'margin-top: {{TOP}}{{UNIT}};',
							'margin-right: {{RIGHT}}{{UNIT}};',
							'margin-bottom: {{BOTTOM}}{{UNIT}};',
							'margin-left: {{LEFT}}{{UNIT}};',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'unit' => 'px',
						),
						'tablet' => array(
							'unit' => 'px',
						),
						'mobile' => array(
							'unit' => 'px',
						),
					),
					'range'      => array(
						'px'  => array(),
						'%'   => array(),
					),
				),

				/**
				 * Design options Tab.
				 */
				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),

				/**
				 * Advanced Tab.
				 */
				woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),

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
