<?php
/**
 * Coupon form map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_checkout_coupon_form' ) ) {
	function woodmart_get_vc_map_checkout_coupon_form() {
		$toggle_typography = woodmart_get_typography_map(
			array(
				'key'      => 'toggle_typography',
				'group'    => esc_html__( 'Style', 'woodmart' ),
				'selector' => '{{WRAPPER}} .woocommerce-form-coupon-toggle > div',
			)
		);

		return array(
			'base'        => 'woodmart_checkout_coupon_form',
			'name'        => esc_html__( 'Coupon form', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Checkout', 'woodmart' ), 'checkout_content' ),
			'description' => esc_html__( 'Apply coupon form', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/ch-icons/ch-coupon-form.svg',
			'params'      => array(
				array(
					'title'      => esc_html__( 'General', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'general_style_section',
				),
				array(
					'heading'          => esc_html__( 'Alignment', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'alignment',
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
				),
				array(
					'title'      => esc_html__( 'Toggle', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'toggle_style_section',
				),
				$toggle_typography['font_family'],
				$toggle_typography['font_size'],
				$toggle_typography['font_weight'],
				$toggle_typography['text_transform'],
				$toggle_typography['font_style'],
				$toggle_typography['line_height'],
				array(
					'title'      => esc_html__( 'Form', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'form_style_section',
				),
				array(
					'heading'          => esc_html__( 'Width', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_slider',
					'param_name'       => 'form_width',
					'devices'          => array(
						'desktop' => array(
							'unit'  => 'px',
							'value' => 470,
						),
						'tablet' => array(
							'unit'  => 'px',
							'value' => 0,
						),
						'mobile' => array(
							'unit'  => 'px',
							'value' => 0,
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 0,
							'max'  => 1200,
							'step' => 1,
						),
						'%' => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}} .checkout_coupon' => array(
							'max-width: {{VALUE}}{{UNIT}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_bg_color',
					'selectors'        => array(
						'{{WRAPPER}} .checkout_coupon' => array(
							'background-color: {{VALUE}};',
						),
					),
				),
				array(
					'heading'          => esc_html__( 'Border type', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_select',
					'param_name'       => 'border_type',
					'style'            => 'select',
					'selectors'        => array(
						'{{WRAPPER}} .checkout_coupon' => array(
							'border-style: {{VALUE}};',
						),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '',
						),
					),
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'None', 'woodmart' )    => 'none',
						esc_html__( 'Solid', 'woodmart' )   => 'solid',
						esc_html__( 'Dotted', 'woodmart' )  => 'dotted',
						esc_html__( 'Double', 'woodmart' )  => 'double',
						esc_html__( 'Dashed', 'woodmart' )  => 'dashed',
						esc_html__( 'Groove', 'woodmart' )  => 'groove',
					),
				),
				array(
					'heading'    => esc_html__( 'Border width', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_dimensions',
					'param_name' => 'border_width',
					'selectors'  => array(
						'{{WRAPPER}} .checkout_coupon' => array(
							'border-top-width: {{TOP}}px;',
							'border-right-width: {{RIGHT}}px;',
							'border-bottom-width: {{BOTTOM}}px;',
							'border-left-width: {{LEFT}}px;',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'unit' => 'px',
						),
					),
					'range'      => array(
						'px' => array(),
					),
					'dependency' => array(
						'element'            => 'border_type',
						'value_not_equal_to' => array( '', 'eyJkZXZpY2VzIjp7ImRlc2t0b3AiOnsidmFsdWUiOiJub25lIn19fQ==' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Border color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'border_color',
					'selectors'        => array(
						'{{WRAPPER}} .checkout_coupon' => array(
							'border-color: {{VALUE}};',
						),
					),
					'dependency' => array(
						'element'            => 'border_type',
						'value_not_equal_to' => array( '', 'eyJkZXZpY2VzIjp7ImRlc2t0b3AiOnsidmFsdWUiOiJub25lIn19fQ==' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'Border radius', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_dimensions',
					'param_name' => 'border_radius',
					'selectors'  => array(
						'{{WRAPPER}} .checkout_coupon' => array(
							'border-top-left-radius: {{TOP}}{{UNIT}};',
							'border-top-right-radius: {{RIGHT}}{{UNIT}};',
							'border-bottom-right-radius: {{BOTTOM}}{{UNIT}};',
							'border-bottom-left-radius: {{LEFT}}{{UNIT}};',
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
						'px' => array(),
					),
					'dependency' => array(
						'element'            => 'border_type',
						'value_not_equal_to' => array( '', 'eyJkZXZpY2VzIjp7ImRlc2t0b3AiOnsidmFsdWUiOiJub25lIn19fQ==' ),
					),
				),
				array(
					'heading'    => esc_html__( 'Padding', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_dimensions',
					'param_name' => 'form_padding',
					'selectors'  => array(
						'{{WRAPPER}} .checkout_coupon' => array(
							'padding-top: {{TOP}}{{UNIT}};',
							'padding-left: {{LEFT}}{{UNIT}};',
							'padding-right: {{RIGHT}}{{UNIT}};',
							'padding-bottom: {{BOTTOM}}{{UNIT}};',
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
						'px' => array(),
					),
				),

				array(
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
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
			)
		);
	}
}
