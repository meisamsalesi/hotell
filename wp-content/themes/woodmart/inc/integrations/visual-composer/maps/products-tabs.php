<?php

use XTS\Modules\Layouts\Main;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );
/**
* ------------------------------------------------------------------------------------------------
* AJAX Products tabs element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_vc_map_products_tabs' ) ) {
	function woodmart_get_vc_map_products_tabs() {
		$heading_typography = woodmart_get_typography_map(
			array(
				'title'    => esc_html__( 'Heading typography', 'woodmart' ),
				'key'      => 'heading_title',
				'selector' => '{{WRAPPER}}.wd-tabs .tabs-name',
			)
		);

		$tabs_typography = woodmart_get_typography_map(
			array(
				'title'    => esc_html__( 'Typography', 'woodmart' ),
				'key'      => 'tabs_title',
				'group'    => esc_html__( 'Tab title', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-nav.wd-nav-tabs .wd-nav-link',
			)
		);

		return array(
			'name' => esc_html__( 'AJAX Products tabs', 'woodmart' ),
			'base' => 'products_tabs',
			'as_parent' => array( 'only' => 'products_tab' ),
			'content_element' => true,
			'show_settings_on_create' => true,
			'category' => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Product tabs for your marketplace', 'woodmart' ),
			'icon' => WOODMART_ASSETS . '/images/vc-icon/ajax-products-tabs.svg',
			'params' => array(
				array(
					'type' => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id'
				),
				/**
				 * Style
				 */
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'HEADING', 'woodmart' ),
					'param_name' => 'style_divider'
				),
				array(
					'type' => 'woodmart_image_select',
					'heading' => esc_html__( 'Design', 'woodmart' ),
					'param_name' => 'design',
					'value' => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
						esc_html__( 'Alternative', 'woodmart' ) => 'alt',
						esc_html__( 'Aside', 'woodmart' ) => 'aside',
					),
					'images_value' => array(
						'default' => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/default.png',
						'simple' => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/simple.png',
						'alt' => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/alternative.png',
						'aside' => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/aside.png',
					),
					'std' => 'default',
					'wood_tooltip' => true,
					'edit_field_class' => 'vc_col-xs-12 vc_column tab-design',
				),
				array(
					'type' => 'woodmart_colorpicker',
					'heading' => esc_html__( 'Tabs primary color', 'woodmart' ),
					'param_name' => 'color',
					'css_args' => array(
						'color' => array(
							'.wd-tabs .wd-nav-tabs.wd-style-default li.wd-active a',
							'.wd-tabs .wd-nav-tabs.wd-style-default li:hover a',
						),
						'border-color' => array(
							'.tabs-design-simple .tabs-name'
						),
						'background-color' => array(
							'.wd-tabs .wd-nav-tabs.wd-style-underline .nav-link-text:after',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Heading color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_title_color',
					'selectors'        => array(
						'{{WRAPPER}} .tabs-name' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				$heading_typography['font_family'],
				$heading_typography['font_size'],
				$heading_typography['font_weight'],
				$heading_typography['text_transform'],
				$heading_typography['font_style'],
				$heading_typography['line_height'],
				array(
					'heading'          => esc_html__( 'Description color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_description_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-tabs-desc' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'default', 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'tabs_side_width',
					'heading'          => esc_html__( 'Side heading width', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit' => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 100,
							'max'  => 500,
							'step' => 1,
						),
						'%'  => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}}.wd-tabs.tabs-design-aside' => array(
							'--wd-side-width: {{VALUE}}{{UNIT}};',
						),
					),
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type' => 'woodmart_image_select',
					'heading' => esc_html__( 'Alignment', 'woodmart' ),
					'param_name' => 'alignment',
					'value' => array(
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'images_value' => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'dependency' => array(
						'element' => 'design',
						'value' => array( 'default' )
					),
					'std' => 'center',
					'wood_tooltip' => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				/**
				 * Heading
				 */
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Heading content', 'woodmart' ),
					'param_name' => 'title_divider'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Description', 'woodmart' ),
					'param_name' => 'description',
					'dependency' => array(
						'element' => 'design',
						'value'   => array( 'default', 'aside' ),
					),
				),
				/**
				 * Image
				 */
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Icon settings', 'woodmart' ),
					'param_name' => 'image_divider'
				),
				array(
					'type' => 'attach_image',
					'heading' => esc_html__( 'Icon image', 'woodmart' ),
					'param_name' => 'image',
					'value' => '',
					'hint' => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Images size', 'woodmart' ),
					'param_name' => 'img_size',
					'hint' => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description' => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
				),
				/**
				 * Other
				 */
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Other', 'woodmart' ),
					'param_name' => 'image_divider'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				/**
				 * Tabs Layout
				 */
				array(
					'param_name' => 'tabs_layout_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Layout', 'woodmart' ),
					'group'      => esc_html__( 'Tab title', 'woodmart' ),
					'holder'     => 'div',
				),
				array(
					'param_name'       => 'tabs_style',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Style', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Underline', 'woodmart' ) => 'underline',
					),
					'std'              => 'underline',
					'dependency'       => array(
						'element'            => 'design',
						'value_not_equal_to' => 'simple',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'icon_position',
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Icon position', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )  => 'left',
						esc_html__( 'Top', 'woodmart' )   => 'top',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'images_value'     => array(
						'top'   => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/top.png',
						'left'  => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/left.png',
						'right' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/right.png',
					),
					'std'              => 'left',
					'wood_tooltip'     => true,
					'dependency'       => array(
						'element'            => 'design',
						'value_not_equal_to' => 'default',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'param_name'       => 'icon_position_design_default',
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Icon position', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )  => 'left',
						esc_html__( 'Top', 'woodmart' )   => 'top',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'images_value'     => array(
						'top'   => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/top.png',
						'left'  => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/left.png',
						'right' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/right.png',
					),
					'std'              => 'top',
					'wood_tooltip'     => true,
					'dependency'       => array(
						'element' => 'design',
						'value'   => 'default',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'tabs_title_space_between_vertical',
					'heading'          => esc_html__( 'Vertical spacing', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit' => 'px',
						),
						'tablet'  => array(
							'unit' => 'px',
						),
						'mobile'  => array(
							'unit' => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 0,
							'max'  => 150,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}}.wd-tabs div.wd-tabs-header' => array(
							'margin-bottom: {{VALUE}}{{UNIT}};',
						),
					),
					'dependency'       => array(
						'element'            => 'design',
						'value_not_equal_to' => array( 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'tabs_title_space_between_horizontal',
					'heading'          => esc_html__( 'Horizontal spacing', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit' => 'px',
						),
						'tablet'  => array(
							'unit' => 'px',
						),
						'mobile'  => array(
							'unit' => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 0,
							'max'  => 150,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}} .wd-nav-tabs > li:not(:last-child)' => array(
							'margin-inline-end: {{VALUE}}{{UNIT}};',
						),
					),
					'dependency'       => array(
						'element'            => 'design',
						'value_not_equal_to' => array( 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name' => 'tabs_layout_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Typography', 'woodmart' ),
					'group'      => esc_html__( 'Tab title', 'woodmart' ),
					'holder'     => 'div',
				),
				$tabs_typography['font_family'],
				$tabs_typography['font_size'],
				$tabs_typography['font_weight'],
				$tabs_typography['text_transform'],
				$tabs_typography['font_style'],
				$tabs_typography['line_height'],
				array(
					'param_name'       => 'tabs_title_color_scheme',
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'style'            => array(
						'dark' => '#2d2a2a',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_title_text_color',
					'selectors'        => array(
						'{{WRAPPER}}.wd-tabs .wd-nav-wrapper .wd-nav > li > a' => array(
							'color: {{VALUE}} !important;',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_color_scheme',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Text hover color', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_text_hover_color',
					'selectors'        => array(
						'{{WRAPPER}}.wd-tabs .wd-nav-wrapper .wd-nav > li:hover > a' => array(
							'color: {{VALUE}} !important;',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_color_scheme',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Text active color', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_text_hover_active',
					'selectors'        => array(
						'{{WRAPPER}}.wd-tabs:not(.wd-inited) .wd-nav.wd-nav-tabs li:first-child a' => array(
							'color: {{VALUE}} !important;',
						),
						'{{WRAPPER}}.wd-tabs .wd-nav-wrapper .wd-nav > li.wd-active > a' => array(
							'color: {{VALUE}} !important;',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_color_scheme',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Design options.
				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'woodmart' ),
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

				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Woodmart Animation', 'woodmart' ),
					'hint'             => esc_html__( 'Use custom theme animations if you want to run them in the slider element.' ),
					'param_name'       => 'wd_animation',
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'admin_label'      => true,
					'value'            => array(
						esc_html__( 'None', 'woodmart' )       => '',
						esc_html__( 'Slide from top', 'woodmart' ) => 'slide-from-top',
						esc_html__( 'Slide from bottom', 'woodmart' ) => 'slide-from-bottom',
						esc_html__( 'Slide from left', 'woodmart' ) => 'slide-from-left',
						esc_html__( 'Slide from right', 'woodmart' ) => 'slide-from-right',
						esc_html__( 'Slide short from left', 'woodmart' ) => 'slide-short-from-left',
						esc_html__( 'Slide short from right', 'woodmart' ) => 'slide-short-from-right',
						esc_html__( 'Flip X bottom', 'woodmart' ) => 'bottom-flip-x',
						esc_html__( 'Flip X top', 'woodmart' ) => 'top-flip-x',
						esc_html__( 'Flip Y left', 'woodmart' ) => 'left-flip-y',
						esc_html__( 'Flip Y right', 'woodmart' ) => 'right-flip-y',
						esc_html__( 'Zoom in', 'woodmart' )    => 'zoom-in',
					),
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Woodmart Animation Delay (ms)', 'woodmart' ),
					'param_name'       => 'wd_animation_delay',
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency'       => array(
						'element'            => 'wd_animation',
						'value_not_equal_to' => array( '' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Woodmart Animation duration', 'woodmart' ),
					'param_name'       => 'wd_animation_duration',
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'value'            => array(
						esc_html__( 'Slow', 'woodmart' )   => 'slow',
						esc_html__( 'Normal', 'woodmart' ) => 'normal',
						esc_html__( 'Fast', 'woodmart' )   => 'fast',
					),
					'dependency'       => array(
						'element'            => 'wd_animation',
						'value_not_equal_to' => array( '' ),
					),
					'std'              => 'normal',
				),

				woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),
			),
			'js_view' => 'VcColumnView'
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_products_tab' ) ) {
	function woodmart_get_vc_map_products_tab() {
		$woodmart_prdoucts_params = vc_map_integrate_shortcode( woodmart_get_products_shortcode_map_params(), '', '', array(
			'exclude' => array(
				'highlighted_products',
				'title_divider',
				'element_title',
				'source_divider',
				'shop_tools',
				'css',
				'responsive_spacing',
				'responsive_tabs',
				'width_desktop',
				'width_tablet',
				'width_mobile',
				'custom_width_desktop',
				'custom_width_tablet',
				'custom_width_mobile',
				'post_type',
				'title_color',
				'title_font_family',
				'title_font_size',
				'title_font_weight',
				'title_text_transform',
				'title_font_style',
				'title_line_height',
			),
		) );

		$post_type_array            = array(
			esc_html__( 'All Products', 'woodmart' )       => 'product',
			esc_html__( 'Featured Products', 'woodmart' )  => 'featured',
			esc_html__( 'Sale Products', 'woodmart' )      => 'sale',
			esc_html__( 'Products with NEW label', 'woodmart' ) => 'new',
			esc_html__( 'Bestsellers', 'woodmart' )        => 'bestselling',
			esc_html__( 'List of IDs', 'woodmart' )        => 'ids',
			esc_html__( 'Top Rated Products', 'woodmart' ) => 'top_rated_products',
		);
		$post_type_additional_array = array(
			'single_product' => array(
				esc_html__( 'Related (Single product)', 'woodmart' ) => 'related',
				esc_html__( 'Upsells (Single product)', 'woodmart' ) => 'upsells',
			),
			'cart'           => array(
				esc_html__( 'Cross Sells', 'woodmart' ) => 'cross-sells',
			),
		);

		foreach ( $post_type_additional_array as $needed_builder => $additional_options ) {
			if ( Main::is_layout_type( $needed_builder ) ) {
				$post_type_array = array_merge( $post_type_array, $additional_options );
			}
		}

		return array(
			'name' => esc_html__( 'Products tab', 'woodmart' ),
			'base' => 'products_tab',
			'as_child' => array( 'only' => 'products_tabs' ),
			'content_element' => true,
			'category' => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Products block', 'woodmart' ),
			'icon' => WOODMART_ASSETS . '/images/vc-icon/product-categories.svg',
			'params' => array_merge( array(
				array(
					'type' => 'woodmart_title_divider',
					'holder' => 'div',
					'title' => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'image_divider'
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title for the tab', 'woodmart' ),
					'param_name' => 'title'
				),
				/**
				 * Icon
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Icon setting', 'woodmart' ),
					'param_name' => 'icon_divider',
				),

				array(
					'heading'          => esc_html__( 'Icon type', 'woodmart' ),
					'param_name'       => 'title_icon_type',
					'type'             => 'dropdown',
					'value'            => array(
						esc_html__( 'With icon', 'woodmart' ) => 'icon',
						esc_html__( 'With image', 'woodmart' ) => 'image',
					),
					'std'              => 'image',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Icon for the tab', 'woodmart' ),
					'param_name'       => 'icon',
					'hint'             => esc_html__( 'Select icon from media library.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'title_icon_type',
						'value'   => array( 'image' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Icon size', 'woodmart' ),
					'param_name'       => 'icon_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'title_icon_type',
						'value'   => array( 'image' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
				),
				array(
					'param_name'       => 'tabs_icon_libraries',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Icon library', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'woodmart' )  => 'openiconic',
						esc_html__( 'Typicons', 'woodmart' )     => 'typicons',
						esc_html__( 'Entypo', 'woodmart' )       => 'entypo',
						esc_html__( 'Linecons', 'woodmart' )     => 'linecons',
						esc_html__( 'Mono Social', 'woodmart' )  => 'monosocial',
						esc_html__( 'Material', 'woodmart' )     => 'material',
					),
					'dependency'       => array(
						'element' => 'title_icon_type',
						'value'   => 'icon',
					),
					'hint'             => esc_html__( 'Select icon library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name' => 'icon_fontawesome',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'fontawesome',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_openiconic',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'openiconic',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'openiconic',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_typicons',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'typicons',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'typicons',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_entypo',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'entypo',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'entypo',
					),
				),
				array(
					'param_name' => 'icon_linecons',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'linecons',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'linecons',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_monosocial',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'monosocial',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'monosocial',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_material',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'material',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'material',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Product source', 'woodmart' ),
					'param_name' => 'product_source_divider',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Data source', 'woodmart' ),
					'param_name'       => 'post_type',
					'value'            => $post_type_array,
					'hint'             => esc_html__( 'Select content type for your grid.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
			), $woodmart_prdoucts_params )
		);
	}
}

// Necessary hooks for blog autocomplete fields
add_filter( 'vc_autocomplete_products_tab_include_callback', 'woodmart_productIdAutocompleteSuggester_new', 10, 1 );
add_filter( 'vc_autocomplete_products_tab_include_render', 'woodmart_productIdAutocompleteRender', 10, 1 );

// Narrow data taxonomies
add_filter( 'vc_autocomplete_products_tab_taxonomies_callback', 'woodmart_vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_products_tab_taxonomies_render', 'woodmart_vc_autocomplete_taxonomies_field_render', 10, 1 );

// Narrow data taxonomies for exclude_filter
add_filter( 'vc_autocomplete_products_tab_exclude_filter_callback', 'vc_autocomplete_taxonomies_field_search', 10, 1 );
add_filter( 'vc_autocomplete_products_tab_exclude_filter_render', 'vc_autocomplete_taxonomies_field_render', 10, 1 );

add_filter( 'vc_autocomplete_products_tab_exclude_callback',	'vc_exclude_field_search', 10, 1 ); // Get suggestion(find). Must return an array
add_filter( 'vc_autocomplete_products_tab_exclude_render', 'vc_exclude_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if( class_exists( 'WPBakeryShortCodesContainer' ) ){
    class WPBakeryShortCode_products_tabs extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if( class_exists( 'WPBakeryShortCode' ) ){
    class WPBakeryShortCode_products_tab extends WPBakeryShortCode {

    }
}
