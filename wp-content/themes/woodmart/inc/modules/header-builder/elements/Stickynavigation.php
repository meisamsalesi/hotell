<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 *  Compare icon in the header elements
 * ------------------------------------------------------------------------------------------------
 */

if ( ! class_exists( 'WOODMART_HB_Stickynavigation' ) ) {
	class WOODMART_HB_Stickynavigation extends WOODMART_HB_Element {

		public function __construct() {
			parent::__construct();
			$this->template_name = 'sticky-navigation';
		}

		public function map() {
			$this->args = array(
				'type'            => 'stickynavigation',
				'title'           => esc_html__( 'Sticky navigation', 'woodmart' ),
				'text'            => esc_html__( 'Navigation opener', 'woodmart' ),
				'icon'            => 'xts-i-sticky-nav',
				'editable'        => true,
				'container'       => false,
				'edit_on_create'  => true,
				'drag_target_for' => array(),
				'drag_source'     => 'content_element',
				'desktop'         => true,
				'removable'       => true,
				'addable'         => true,
				'params'          => array(
					'sticky_notice'       => array(
						'id'          => 'sticky_notice',
						'description' => esc_html__( 'Before using this element, make sure that you have configured the sticky navigation menu via options located in Theme settings - Genaral - Sticky navigation.', 'woodmart' ),
						'type'        => 'notice',
						'style'       => 'info',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'value'       => '',
					),
					'style'               => array(
						'id'          => 'style',
						'title'       => esc_html__( 'Display', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'value'       => 'icon',
						'options'     => array(
							'icon' => array(
								'value' => 'icon',
								'label' => esc_html__( 'Icon', 'woodmart' ),
							),
							'text' => array(
								'value' => 'text',
								'label' => esc_html__( 'Icon with text', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'You can show the icon only or display "Menu" text too.', 'woodmart' ),
					),
					'title'               => array(
						'id'          => 'title',
						'title'       => esc_html__( 'Icon text', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'value'       => '',
						'description' => esc_html__( 'Specify your custom text for this menu or leave it empty to keep "Menu".', 'woodmart' ),
						'requires'    => array(
							'style' => array(
								'comparison' => 'equal',
								'value'      => 'text',
							),
						),
					),
					'icon_design'         => array(
						'id'      => 'icon_design',
						'title'   => esc_html__( 'Icon design', 'woodmart' ),
						'type'    => 'selector',
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'Icon', 'woodmart' ),
						'value'   => '1',
						'options' => array(
							'1' => array(
								'value' => '1',
								'label' => esc_html__( 'First', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/mobile-menu-icons/first.jpg',
							),
							'6' => array(
								'value' => '6',
								'label' => esc_html__( 'Second', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/mobile-menu-icons/second.jpg',
							),
							'7' => array(
								'value' => '7',
								'label' => esc_html__( 'Third', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/mobile-menu-icons/third.jpg',
							),
							'8' => array(
								'value' => '8',
								'label' => esc_html__( 'Fourth', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/mobile-menu-icons/fourth.jpg',
							),
						),
					),
					'wrap_type'           => array(
						'id'       => 'wrap_type',
						'title'    => esc_html__( 'Background wrap type', 'woodmart' ),
						'type'     => 'selector',
						'tab'      => esc_html__( 'Style', 'woodmart' ),
						'group'    => esc_html__( 'Icon', 'woodmart' ),
						'value'    => 'icon_only',
						'options'  => array(
							'icon_only'     => array(
								'value' => 'icon_only',
								'label' => esc_html__( 'Icon only', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/bg-wrap-type/menu-wrap-icon.jpg',
							),
							'icon_and_text' => array(
								'value' => 'icon_and_text',
								'label' => esc_html__( 'Icon and text', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/bg-wrap-type/menu-wrap-icon-and-text.jpg',
							),
						),
						'requires' => array(
							'style'       => array(
								'comparison' => 'equal',
								'value'      => 'text',
							),
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => array( '6', '7' ),
							),
						),
					),
					'color'               => array(
						'id'          => 'color',
						'title'       => esc_html__( 'Color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'whb-row .{{WRAPPER}}.wd-tools-element .wd-tools-inner, .whb-row .{{WRAPPER}}.wd-tools-element > a > .wd-tools-icon' => array(
								'color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => array( '7', '8' ),
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'hover_color'         => array(
						'id'          => 'hover_color',
						'title'       => esc_html__( 'Hover color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'whb-row .{{WRAPPER}}.wd-tools-element:hover .wd-tools-inner, .whb-row .{{WRAPPER}}.wd-tools-element:hover > a > .wd-tools-icon' => array(
								'color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => array( '7', '8' ),
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'bg_color'            => array(
						'id'          => 'bg_color',
						'title'       => esc_html__( 'Background color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'whb-row .{{WRAPPER}}.wd-tools-element .wd-tools-inner, .whb-row .{{WRAPPER}}.wd-tools-element > a > .wd-tools-icon' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => array( '7', '8' ),
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'bg_hover_color'      => array(
						'id'          => 'bg_hover_color',
						'title'       => esc_html__( 'Hover background color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'whb-row .{{WRAPPER}}.wd-tools-element:hover .wd-tools-inner, .whb-row .{{WRAPPER}}.wd-tools-element:hover > a > .wd-tools-icon' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => array( '7', '8' ),
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_color'          => array(
						'id'          => 'icon_color',
						'title'       => esc_html__( 'Icon color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}}.wd-tools-element.wd-design-8 .wd-tools-icon' => array(
								'color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => '8',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_hover_color'    => array(
						'id'          => 'icon_hover_color',
						'title'       => esc_html__( 'Hover icon color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}}.wd-tools-element.wd-design-8:hover .wd-tools-icon' => array(
								'color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => '8',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_bg_color'       => array(
						'id'          => 'icon_bg_color',
						'title'       => esc_html__( 'Icon background color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}}.wd-tools-element.wd-design-8 .wd-tools-icon' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => '8',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_bg_hover_color' => array(
						'id'          => 'icon_bg_hover_color',
						'title'       => esc_html__( 'Hover icon background color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}}.wd-tools-element.wd-design-8:hover .wd-tools-icon' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_design' => array(
								'comparison' => 'equal',
								'value'      => '8',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_type'           => array(
						'id'          => 'icon_type',
						'title'       => esc_html__( 'Icon type', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'value'       => 'default',
						'options'     => array(
							'default' => array(
								'value' => 'default',
								'label' => esc_html__( 'Default', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/default-icons/burger-default.jpg',
							),
							'custom'  => array(
								'value' => 'custom',
								'label' => esc_html__( 'Custom', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/upload.jpg',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'custom_icon'         => array(
						'id'          => 'custom_icon',
						'title'       => esc_html__( 'Upload an image', 'woodmart' ),
						'type'        => 'image',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'value'       => '',
						'description' => '',
						'requires'    => array(
							'icon_type' => array(
								'comparison' => 'equal',
								'value'      => 'custom',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'mouse_event'         => array(
						'id'          => 'mouse_event',
						'title'       => esc_html__( 'Open on mouse event', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Extra', 'woodmart' ),
						'type'        => 'selector',
						'options'     => array(
							'click' => array(
								'value' => 'click',
								'label' => esc_html__( 'Click', 'woodmart' ),
							),
							'hover' => array(
								'value' => 'hover',
								'label' => esc_html__( 'Hover', 'woodmart' ),
							),
						),
						'value'       => 'click',
						'extra_class' => 'xts-col-6',
					),
					'close_menu_mouseout' => array(
						'id'          => 'close_menu_mouseout',
						'title'       => esc_html__( 'Close menu on mouse leave', 'woodmart' ),
						'type'        => 'switcher',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Extra', 'woodmart' ),
						'value'       => false,
						'requires'    => array(
							'mouse_event' => array(
								'comparison' => 'equal',
								'value'      => 'click',
							),
						),
						'extra_class' => 'xts-col-6',
					),
				),
			);
		}
	}
}
