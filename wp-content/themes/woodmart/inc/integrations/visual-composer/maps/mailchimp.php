<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_mailchimp' ) ) {
	function woodmart_get_vc_map_mailchimp() {
		return array(
			'name'        => esc_html__( 'Mailchimp', 'woodmart' ),
			'base'        => 'woodmart_mailchimp',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Newsletter subscription form', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/mailchimp.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Form', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Select form', 'woodmart' ),
					'param_name'       => 'form_id',
					'callback'         => 'woodmart_get_mailchimp_forms',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Color Scheme', 'woodmart' ),
					'param_name'       => 'color_scheme',
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Alignment', 'woodmart' ),
					'param_name'       => 'alignment',
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
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
					'std'              => 'center',
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'form_width',
					'heading'          => esc_html__( 'Form Width', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit'  => '%',
							'value' => 100,
						),
						'tablet'  => array(
							'unit'  => '%',
							'value' => '',
						),
						'mobile'  => array(
							'unit'  => '%',
							'value' => '',
						),
					),
					'range'            => array(
						'%'  => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
						'px' => array(
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}}' => array(
							'--wd-max-width: {{VALUE}}{{UNIT}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Form', 'woodmart' ),
					'param_name' => 'form_divider',
				),

				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_color',
					'selectors'        => array(
						'{{WRAPPER}} .mc4wp-form' => array(
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
						'{{WRAPPER}} .mc4wp-form' => array(
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
						'{{WRAPPER}} .mc4wp-form' => array(
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
						'{{WRAPPER}} .mc4wp-form' => array(
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
						'{{WRAPPER}} .mc4wp-form' => array(
							'--wd-form-bg: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'button_divider',
				),

				array(
					'type'       => 'woodmart_button_set',
					'param_name' => 'button_color_tabs',
					'tabs'       => true,
					'value'      => array(
						esc_html__( 'IDLE', 'woodmart' ) => 'idle',
						esc_html__( 'Hover', 'woodmart' ) => 'hover',
					),
					'default'    => 'idle',
				),

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_text_color',
					'selectors'        => array(
						'{{WRAPPER}} .mc4wp-form input[type="submit"]' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'idle' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_bg_color',
					'selectors'        => array(
						'{{WRAPPER}} .mc4wp-form input[type="submit"]' => array(
							'background-color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'idle' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_text_color_hover',
					'selectors'        => array(
						'{{WRAPPER}} .mc4wp-form input[type="submit"]:hover' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'hover' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_bg_color_hover',
					'selectors'        => array(
						'{{WRAPPER}} .mc4wp-form input[type="submit"]:hover' => array(
							'background-color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'hover' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Extra
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'extra_classes',
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
