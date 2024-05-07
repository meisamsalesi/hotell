<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Account links in the header. Login / register, my account, logout.
 * ------------------------------------------------------------------------------------------------
 */

if ( ! class_exists( 'WOODMART_HB_Account' ) ) {
	class WOODMART_HB_Account extends WOODMART_HB_Element {

		public function __construct() {
			parent::__construct();
			$this->template_name = 'account';
		}

		public function map() {
			$this->args = array(
				'type'            => 'account',
				'title'           => esc_html__( 'Account', 'woodmart' ),
				'text'            => esc_html__( 'Login/register links', 'woodmart' ),
				'icon'            => 'xts-i-account',
				'editable'        => true,
				'container'       => false,
				'edit_on_create'  => true,
				'drag_target_for' => array(),
				'drag_source'     => 'content_element',
				'removable'       => true,
				'addable'         => true,
				'params'          => array(
					'with_username'       => array(
						'id'          => 'with_username',
						'title'       => esc_html__( 'Show username', 'woodmart' ),
						'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_account_with_username.mp4" autoplay loop muted></video>',
						'type'        => 'switcher',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'value'       => false,
						'description' => esc_html__( 'Display username when user is logged in.', 'woodmart' ),
					),
					'login_dropdown'      => array(
						'id'          => 'login_dropdown',
						'title'       => esc_html__( 'Show login form', 'woodmart' ),
						'type'        => 'switcher',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'value'       => true,
						'description' => esc_html__( 'Display login form dropdown on hover when user is not logged in.', 'woodmart' ),
						'extra_class' => 'xts-col-6',
					),
					'form_display'        => array(
						'id'          => 'form_display',
						'title'       => esc_html__( 'Form display', 'woodmart' ),
						'type'        => 'selector',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'value'       => 'dropdown',
						'options'     => array(
							'side'     => array(
								'value' => 'side',
								'hint'   => '<img src="' . WOODMART_TOOLTIP_URL . 'hb_account_form_display_sidebar.jpg" alt="">',
								'label' => esc_html__( 'Sidebar', 'woodmart' ),
							),
							'dropdown' => array(
								'value' => 'dropdown',
								'hint'   => '<img src="' . WOODMART_TOOLTIP_URL . 'hb_account_form_display_dropdown.jpg" alt="">',
								'label' => esc_html__( 'Dropdown', 'woodmart' ),
							),
						),
						'requires'    => array(
							'login_dropdown' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'display'             => array(
						'id'      => 'display',
						'title'   => esc_html__( 'Display', 'woodmart' ),
						'type'    => 'selector',
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'Icon', 'woodmart' ),
						'value'   => 'text',
						'options' => array(
							'icon' => array(
								'value' => 'icon',
								'label' => esc_html__( 'Icon', 'woodmart' ),
							),
							'text' => array(
								'value' => 'text',
								'label' => esc_html__( 'Only text', 'woodmart' ),
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
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/account-icons/first.jpg',
							),
							'6' => array(
								'value' => '6',
								'label' => esc_html__( 'Second', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/account-icons/second.jpg',
							),
							'7' => array(
								'value' => '7',
								'label' => esc_html__( 'Third', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/account-icons/third.jpg',
							),
							'8' => array(
								'value' => '8',
								'label' => esc_html__( 'Fourth', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/account-icons/fourth.jpg',
							),
						),
						'requires' => array(
							'display' => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/bg-wrap-type/account-wrap-icon.jpg',
							),
							'icon_and_text' => array(
								'value' => 'icon_and_text',
								'label' => esc_html__( 'Icon and text', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/bg-wrap-type/account-wrap-icon-and-text.jpg',
							),
						),
						'requires' => array(
							'display'       => array(
								'comparison' => 'equal',
								'value'      => 'icon',
							),
							'with_username' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
							'icon_design'   => array(
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
							'display'     => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/default-icons/account-default.jpg',
							),
							'custom'  => array(
								'value' => 'custom',
								'label' => esc_html__( 'Custom', 'woodmart' ),
								'image' => WOODMART_ASSETS_IMAGES . '/header-builder/upload.jpg',
							),
						),
						'requires'    => array(
							'display' => array(
								'comparison' => 'equal',
								'value'      => 'icon',
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
					'bg_overlay'          => array(
						'id'          => 'bg_overlay',
						'title'       => esc_html__( 'Background overlay', 'woodmart' ),
						'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_account_bg_overlay.mp4" autoplay loop muted></video>',
						'description' => esc_html__( 'Highlight dropdowns by darkening the background behind.', 'woodmart' ),
						'type'        => 'switcher',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Extra', 'woodmart' ),
						'value'       => false,
					),
				),
			);
		}

	}

}
