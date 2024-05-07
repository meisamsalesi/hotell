<?php
/**
 * Cart totals map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_cart_totals' ) ) {
	function woodmart_get_vc_map_cart_totals() {
		$title_typography = woodmart_get_typography_map(
			array(
				'key'      => 'title_typography',
				'group'    => esc_html__( 'Style', 'woodmart' ),
				'selector' => '{{WRAPPER}} .cart-totals-inner > h2',
				'dependency' => array(
					'element' => 'show_title',
					'value' => 'yes',
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			)
		);

		return array(
			'base'        => 'woodmart_cart_totals',
			'name'        => esc_html__( 'Cart totals', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Cart elements', 'woodmart' ), 'cart' ),
			'description' => esc_html__( 'Totals and checkout button', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/ct-icons/ct-cart-totals.svg',
			'params'      => array(
				array(
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				array(
					'title'      => esc_html__( 'Title', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'title_style_section',
				),
				array(
					'heading'     => esc_html__( 'Enable title', 'woodmart' ),
					'group'       => esc_html__( 'Style', 'woodmart' ),
					'type'        => 'woodmart_switch',
					'param_name'  => 'show_title',
					'true_state'  => 'yes',
					'false_state' => 'no',
					'default'     => 'yes',
				),
				$title_typography['font_family'],
				$title_typography['font_size'],
				$title_typography['font_weight'],
				$title_typography['text_transform'],
				$title_typography['font_style'],
				$title_typography['line_height'],
				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'title_color',
					'selectors'        => array(
						'{{WRAPPER}} .cart-totals-inner > h2' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'show_title',
						'value'   => 'yes',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Alignment', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'title_alignment',
					'type'             => 'woodmart_image_select',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'std'              => 'left',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
					'dependency'       => array(
						'element' => 'show_title',
						'value'   => 'yes',
					),
				),
				array(
					'title'      => esc_html__( 'Button', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'general_style_section',
				),
				array(
					'heading'    => esc_html__( 'Button position', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_select',
					'param_name' => 'button_alignment',
					'style'      => 'select',
					'selectors'  => array(),
					'devices'    => array(
						'desktop' => array(
							'value' => 'left',
						),
					),
					'value'      => array(
						esc_html__( 'Left', 'woodmart' )       => 'left',
						esc_html__( 'Center', 'woodmart' )     => 'center',
						esc_html__( 'Right', 'woodmart' )      => 'right',
						esc_html__( 'Full width', 'woodmart' ) => 'full-width',
					),
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
