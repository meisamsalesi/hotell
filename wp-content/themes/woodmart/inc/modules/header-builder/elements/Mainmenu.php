<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 *  Main navigtaion menu
 * ------------------------------------------------------------------------------------------------
 */

if ( ! class_exists( 'WOODMART_HB_Mainmenu' ) ) {
	class WOODMART_HB_Mainmenu extends WOODMART_HB_Element {

		public function __construct() {
			parent::__construct();
			$this->template_name = 'main-menu';
		}

		public function map() {
			$this->args = array(
				'type'            => 'mainmenu',
				'title'           => esc_html__( 'Main menu', 'woodmart' ),
				'text'            => esc_html__( 'Main navigation', 'woodmart' ),
				'icon'            => 'xts-i-main-menu',
				'editable'        => true,
				'container'       => false,
				'drg'             => false,
				'drag_target_for' => array(),
				'drag_source'     => 'content_element',
				'edit_on_create'  => true,
				'removable'       => true,
				'desktop'         => true,
				'addable'         => true,
				'params'          => array(
					'menu_id'             => array(
						'id'          => 'menu_id',
						'title'       => esc_html__( 'Choose menu', 'woodmart' ),
						'type'        => 'select',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'value'       => '',
						'callback'    => 'get_menu_options_with_empty',
						'description' => esc_html__( 'Choose which menu to display in the header.', 'woodmart' ),
					),
					'full_screen'         => array(
						'id'          => 'full_screen',
						'title'       => esc_html__( 'Full screen menu', 'woodmart' ),
						'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_full_screen.mp4" autoplay loop muted></video>',
						'type'        => 'switcher',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'value'       => false,
						'description' => esc_html__( 'Enable to show your menu in full screen style on burger icon click.', 'woodmart' ),
					),
					'style'               => array(
						'id'          => 'style',
						'title'       => esc_html__( 'Display', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'value'       => 'text',
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
						'requires'    => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
						),
					),
					'icon_design'         => array(
						'id'       => 'icon_design',
						'title'    => esc_html__( 'Icon design', 'woodmart' ),
						'type'     => 'selector',
						'tab'      => esc_html__( 'Style', 'woodmart' ),
						'group'    => esc_html__( 'Icon', 'woodmart' ),
						'value'    => '1',
						'options'  => array(
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
						'requires' => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
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
						'requires'    => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => true,
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
					'menu_style'          => array(
						'id'          => 'menu_style',
						'title'       => esc_html__( 'Style', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Menu', 'woodmart' ),
						'value'       => 'default',
						'options'     => array(
							'default'   => array(
								'value' => 'default',
								'hint'   => '<img src="' . WOODMART_TOOLTIP_URL . 'hb_menu_style_default.jpg" alt="">',
								'label' => esc_html__( 'Default', 'woodmart' ),
							),
							'underline' => array(
								'value' => 'underline',
								'hint'   => '<img src="' . WOODMART_TOOLTIP_URL . 'hb_menu_style_underline.jpg" alt="">',
								'label' => esc_html__( 'Underline', 'woodmart' ),
							),
							'bordered'  => array(
								'value' => 'bordered',
								'hint'   => '<img src="' . WOODMART_TOOLTIP_URL . 'hb_menu_style_bordered.jpg" alt="">',
								'label' => esc_html__( 'Bordered', 'woodmart' ),
							),
							'separated' => array(
								'value' => 'separated',
								'hint'   => '<img src="' . WOODMART_TOOLTIP_URL . 'hb_menu_style_separated.jpg" alt="">',
								'label' => esc_html__( 'Separated', 'woodmart' ),
							),
							'bg'        => array(
								'value' => 'bg',
								'hint'   => '<img src="' . WOODMART_TOOLTIP_URL . 'hb_menu_style_bg.jpg" alt="">',
								'label' => esc_html__( 'Background', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'You can change menu style in the header.', 'woodmart' ),
						'requires'    => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => false,
							),
						),
					),
					'menu_align'          => array(
						'id'          => 'menu_align',
						'title'       => esc_html__( 'Menu align', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Menu', 'woodmart' ),
						'value'       => 'left',
						'options'     => array(
							'left'   => array(
								'value' => 'left',
								'label' => esc_html__( 'Left', 'woodmart' ),
							),
							'center' => array(
								'value' => 'center',
								'label' => esc_html__( 'Center', 'woodmart' ),
							),
							'right'  => array(
								'value' => 'right',
								'label' => esc_html__( 'Right', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'Set the menu items text align.', 'woodmart' ),
						'requires'    => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => false,
							),
						),
					),
					'items_gap'           => array(
						'id'          => 'items_gap',
						'title'       => esc_html__( 'Items gap', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Menu', 'woodmart' ),
						'value'       => 's',
						'options'     => array(
							's' => array(
								'value' => 's',
								'label' => esc_html__( 'Small', 'woodmart' ),
							),
							'm' => array(
								'value' => 'm',
								'label' => esc_html__( 'Medium', 'woodmart' ),
							),
							'l' => array(
								'value' => 'l',
								'label' => esc_html__( 'Large', 'woodmart' ),
							),
						),
						'description' => esc_html__( 'Set the items gap.', 'woodmart' ),
						'requires'    => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => false,
							),
						),
					),
					'bg_overlay'          => array(
						'id'          => 'bg_overlay',
						'title'       => esc_html__( 'Background overlay', 'woodmart' ),
						'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_bg_overlay.mp4" autoplay loop muted></video>',
						'description' => __( 'Highlight dropdowns by darkening the background behind.', 'woodmart' ),
						'type'        => 'switcher',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Menu', 'woodmart' ),
						'value'       => false,
						'requires'    => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => false,
							),
						),
					),
					'inline'              => array(
						'id'          => 'inline',
						'title'       => esc_html__( 'Display inline', 'woodmart' ),
						'type'        => 'switcher',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Menu', 'woodmart' ),
						'value'       => false,
						'description' => esc_html__( 'The width of the element will depend on its content', 'woodmart' ),
						'requires'    => array(
							'full_screen' => array(
								'comparison' => 'equal',
								'value'      => false,
							),
						),
					),
				),
			);
		}

	}

}
