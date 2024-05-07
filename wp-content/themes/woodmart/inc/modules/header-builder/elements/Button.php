<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 *  WPBakery Button element
 * ------------------------------------------------------------------------------------------------
 */

if ( ! class_exists( 'WOODMART_HB_Button' ) ) {
	class WOODMART_HB_Button extends WOODMART_HB_Element {

		public function __construct() {
			parent::__construct();
			$this->template_name = 'button';
		}

		public function map() {
			$this->args = array(
				'type'            => 'button',
				'title'           => esc_html__( 'Button', 'woodmart' ),
				'text'            => esc_html__( 'Button with link', 'woodmart' ),
				'icon'            => 'xts-i-button',
				'editable'        => true,
				'container'       => false,
				'edit_on_create'  => true,
				'drag_target_for' => array(),
				'drag_source'     => 'content_element',
				'removable'       => true,
				'addable'         => true,
				'params'          => array(
					'title'                       => array(
						'id'    => 'title',
						'title' => esc_html__( 'Title', 'woodmart' ),
						'tab'   => esc_html__( 'General', 'woodmart' ),
						'group' => esc_html__( 'Content', 'woodmart' ),
						'type'  => 'text',
						'value' => '',
					),
					'link'                        => array(
						'id'    => 'link',
						'title' => esc_html__( 'Link', 'woodmart' ),
						'tab'   => esc_html__( 'General', 'woodmart' ),
						'group' => esc_html__( 'Content', 'woodmart' ),
						'type'  => 'link',
						'value' => array( 'url' => '' ),
					),
					'button_smooth_scroll'        => array(
						'id'    => 'button_smooth_scroll',
						'title' => esc_html__( 'Smooth scroll', 'woodmart' ),
						'hint'  => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_button_smooth_scroll.mp4" autoplay loop muted></video>',
						'tab'   => esc_html__( 'General', 'woodmart' ),
						'group' => esc_html__( 'Extra', 'woodmart' ),
						'type'  => 'switcher',
						'value' => false,
						'description' => esc_html__( 'When you turn on this option you need to specify this button link with a hash symbol. For example #section-id Then you need to have a section with an ID of "section-id" and this button click will smoothly scroll the page to that section.', 'woodmart' ),
					),
					'button_smooth_scroll_time'   => array(
						'id'          => 'button_smooth_scroll_time',
						'title'       => esc_html__( 'Smooth scroll time (ms)', 'woodmart' ),
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'group'       => esc_html__( 'Extra', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'button_smooth_scroll' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'button_smooth_scroll_offset' => array(
						'id'          => 'button_smooth_scroll_offset',
						'title'       => esc_html__( 'Smooth scroll offset (px)', 'woodmart' ),
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'group'       => esc_html__( 'Extra', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'button_smooth_scroll' => array(
								'comparison' => 'equal',
								'value'      => true,
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'el_class'                    => array(
						'id'          => 'el_class',
						'title'       => esc_html__( 'Additional CSS class', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'General', 'woodmart' ),
						'group'       => esc_html__( 'Extra', 'woodmart' ),
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
					),
					'style'                       => array(
						'id'      => 'style',
						'title'   => esc_html__( 'Button style', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'General', 'woodmart' ),
						'type'    => 'selector',
						'value'   => 'default',
						'options' => array(
							'default'  => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => 'default',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/default.png',
							),
							'bordered' => array(
								'label' => esc_html__( 'Bordered', 'woodmart' ),
								'value' => 'bordered',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/bordered.png',
							),
							'link'     => array(
								'label' => esc_html__( 'Link button', 'woodmart' ),
								'value' => 'link',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/link.png',
							),
							'3d'       => array(
								'label' => esc_html__( '3D', 'woodmart' ),
								'value' => '3d',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/3d.png',
							),
						),
					),
					'shape'                       => array(
						'id'       => 'shape',
						'title'    => esc_html__( 'Button shape', 'woodmart' ),
						'tab'      => esc_html__( 'Style', 'woodmart' ),
						'group'    => esc_html__( 'General', 'woodmart' ),
						'type'     => 'selector',
						'value'    => 'rectangle',
						'options'  => array(
							'rectangle'  => array(
								'label' => esc_html__( 'Rectangle', 'woodmart' ),
								'value' => 'rectangle',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/rectangle.jpeg',
							),
							'round'      => array(
								'label' => esc_html__( 'Circle', 'woodmart' ),
								'value' => 'round',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/circle.jpeg',
							),
							'semi-round' => array(
								'label' => esc_html__( 'Round', 'woodmart' ),
								'value' => 'semi-round',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/round.jpeg',
							),
						),
						'requires' => array(
							'style' => array(
								'comparison' => 'not_equal',
								'value'      => array( 'round', 'link' ),
							),
						),
					),
					'size'                        => array(
						'id'      => 'size',
						'title'   => esc_html__( 'Button size', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'General', 'woodmart' ),
						'type'    => 'select',
						'value'   => 'default',
						'options' => array(
							'default'     => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => 'default',
							),
							'extra-small' => array(
								'label' => esc_html__( 'Extra Small', 'woodmart' ),
								'value' => 'extra-small',
							),
							'small'       => array(
								'label' => esc_html__( 'Small', 'woodmart' ),
								'value' => 'small',
							),
							'large'       => array(
								'label' => esc_html__( 'Large', 'woodmart' ),
								'value' => 'large',
							),
							'extra-large' => array(
								'label' => esc_html__( 'Extra Large', 'woodmart' ),
								'value' => 'extra-large',
							),
						),
					),
					'color'                       => array(
						'id'      => 'color',
						'title'   => esc_html__( 'Predefined button color', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'Colors', 'woodmart' ),
						'type'    => 'select',
						'value'   => 'default',
						'options' => array(
							'default' => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => 'default',
							),
							'primary' => array(
								'label' => esc_html__( 'Primary color', 'woodmart' ),
								'value' => 'primary',
							),
							'alt'     => array(
								'label' => esc_html__( 'Alternative color', 'woodmart' ),
								'value' => 'alt',
							),
							'white'   => array(
								'label' => esc_html__( 'White', 'woodmart' ),
								'value' => 'white',
							),
							'black'   => array(
								'label' => esc_html__( 'Black', 'woodmart' ),
								'value' => 'black',
							),
						),
					),
					'bg_color'                    => array(
						'id'          => 'bg_color',
						'title'       => esc_html__( 'Background color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Colors', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'extra_class' => 'xts-col-6',
					),
					'bg_color_hover'              => array(
						'id'          => 'bg_color_hover',
						'title'       => esc_html__( 'Background color on hover', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Colors', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'extra_class' => 'xts-col-6',
					),
					'color_scheme'                => array(
						'id'          => 'color_scheme',
						'title'       => esc_html__( 'Text color scheme', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Colors', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'light',
						'options'     => array(
							'light'  => array(
								'label' => esc_html__( 'Light', 'woodmart' ),
								'value' => 'light',
							),
							'dark'   => array(
								'label' => esc_html__( 'Dark', 'woodmart' ),
								'value' => 'dark',
							),
							'custom' => array(
								'label' => esc_html__( 'Custom', 'woodmart' ),
								'value' => 'custom',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'custom_color_scheme'         => array(
						'id'          => 'custom_color_scheme',
						'title'       => esc_html__( 'Custom text color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Colors', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}}.wd-button-wrapper a' => array(
								'color: {{VALUE}};',
							),
						),
						'type'        => 'color',
						'value'       => '',
						'requires'    => array(
							'color_scheme' => array(
								'comparison' => 'equal',
								'value'      => 'custom',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'color_scheme_divider'        => array(
						'id'    => 'color_scheme_divider',
						'type'  => 'divider',
						'tab'   => esc_html__( 'Style', 'woodmart' ),
						'group' => esc_html__( 'Colors', 'woodmart' ),
						'value' => '',
					),
					'color_scheme_hover'          => array(
						'id'          => 'color_scheme_hover',
						'title'       => esc_html__( 'Text color scheme on hover', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Colors', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'light',
						'options'     => array(
							'light'  => array(
								'label' => esc_html__( 'Light', 'woodmart' ),
								'value' => 'light',
							),
							'dark'   => array(
								'label' => esc_html__( 'Dark', 'woodmart' ),
								'value' => 'dark',
							),
							'custom' => array(
								'label' => esc_html__( 'Custom', 'woodmart' ),
								'value' => 'custom',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'custom_color_scheme_hover'   => array(
						'id'          => 'custom_color_scheme_hover',
						'title'       => esc_html__( 'Custom text color on hover', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Colors', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}}.wd-button-wrapper a:hover' => array(
								'color: {{VALUE}};',
							),
						),
						'type'        => 'color',
						'value'       => '',
						'requires'    => array(
							'color_scheme_hover' => array(
								'comparison' => 'equal',
								'value'      => 'custom',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_library'                => array(
						'id'          => 'icon_library',
						'title'       => esc_html__( 'Icon library', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'select',
						'value'       => 'fontawesome',
						'options'     => array(
							'fontawesome' => array(
								'label' => esc_html__( 'Font Awesome', 'woodmart' ),
								'value' => 'fontawesome',
							),
							'openiconic'  => array(
								'label' => esc_html__( 'Open Iconic', 'woodmart' ),
								'value' => 'openiconic',
							),
							'typicons'    => array(
								'label' => esc_html__( 'Typicons', 'woodmart' ),
								'value' => 'typicons',
							),
							'entypo'      => array(
								'label' => esc_html__( 'Entypo', 'woodmart' ),
								'value' => 'entypo',
							),
							'linecons'    => array(
								'label' => esc_html__( 'Linecons', 'woodmart' ),
								'value' => 'linecons',
							),
							'monosocial'  => array(
								'label' => esc_html__( 'Mono Social', 'woodmart' ),
								'value' => 'monosocial',
							),
							'material'    => array(
								'label' => esc_html__( 'Material', 'woodmart' ),
								'value' => 'material',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'icon_fontawesome'            => array(
						'id'          => 'icon_fontawesome',
						'title'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Enter the class name of the icon. For example "fas fa-check".', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'icon_library' => array(
								'comparison' => 'equal',
								'value'      => 'fontawesome',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'icon_openiconic'             => array(
						'id'          => 'icon_openiconic',
						'title'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Enter the class name of the icon. For example "oi oi-check".', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'icon_library' => array(
								'comparison' => 'equal',
								'value'      => 'openiconic',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'icon_typicons'               => array(
						'id'          => 'icon_typicons',
						'title'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Enter the class name of the icon. For example "typcn typcn-input-checked".', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'icon_library' => array(
								'comparison' => 'equal',
								'value'      => 'typicons',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'icon_entypo'                 => array(
						'id'          => 'icon_entypo',
						'title'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Enter the class name of the icon. For example "entypo-icon entypo-icon-check".', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'icon_library' => array(
								'comparison' => 'equal',
								'value'      => 'entypo',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'icon_linecons'               => array(
						'id'          => 'icon_linecons',
						'title'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Enter the class name of the icon. For example "vc_li vc_li-star".', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'icon_library' => array(
								'comparison' => 'equal',
								'value'      => 'linecons',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'icon_monosocial'             => array(
						'id'          => 'icon_monosocial',
						'title'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Enter the class name of the icon. For example "vc-mono vc-mono-addme".', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'icon_library' => array(
								'comparison' => 'equal',
								'value'      => 'monosocial',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'icon_material'               => array(
						'id'          => 'icon_material',
						'title'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Enter the class name of the icon. For example "vc-material vc-material-check".', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'text',
						'value'       => '',
						'requires'    => array(
							'icon_library' => array(
								'comparison' => 'equal',
								'value'      => 'material',
							),
						),
						'extra_class' => 'xts-hidden',
					),
					'image'                       => array(
						'id'          => 'image',
						'title'       => esc_html__( 'Image', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'image',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'value'       => '',
						'extra_class' => 'xts-col-6',
					),
					'img_size'                    => array(
						'id'          => 'img_size',
						'title'       => esc_html__( 'Image size', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Image', 'woodmart' ),
						'value'       => '',
						'description' => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
						'extra_class' => 'xts-col-6',
					),
					'icon_position'               => array(
						'id'      => 'icon_position',
						'title'   => esc_html__( 'Button image position', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'Image', 'woodmart' ),
						'type'    => 'selector',
						'value'   => 'left',
						'options' => array(
							'left'  => array(
								'label' => esc_html__( 'Left', 'woodmart' ),
								'value' => 'left',
							),
							'right' => array(
								'label' => esc_html__( 'Right', 'woodmart' ),
								'value' => 'right',
							),
						),
					),
				),
			);
		}
	}
}
