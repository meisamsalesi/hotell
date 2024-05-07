<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 *  WPBakery Button element
 * ------------------------------------------------------------------------------------------------
 */

if ( ! class_exists( 'WOODMART_HB_Infobox' ) ) {
	class WOODMART_HB_Infobox extends WOODMART_HB_Element {

		public function __construct() {
			parent::__construct();
			$this->template_name = 'info-box';
		}

		public function map() {
			$secondary_font = woodmart_get_opt( 'secondary-font' );
			$text_font      = woodmart_get_opt( 'text-font' );
			$primary_font   = woodmart_get_opt( 'primary-font' );

			$secondary_font_title = isset( $secondary_font[0] ) ? esc_html__( 'Secondary font', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary font', 'woodmart' );
			$text_font_title      = isset( $text_font[0] ) ? esc_html__( 'Text font', 'woodmart' ) . ' (' . $text_font[0]['font-family'] . ')' : esc_html__( 'Text', 'woodmart' );
			$primary_font_title   = isset( $primary_font[0] ) ? esc_html__( 'Title font', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Title font', 'woodmart' );

			$this->args = array(
				'type'            => 'infobox',
				'title'           => esc_html__( 'Information box', 'woodmart' ),
				'text'            => esc_html__( 'Text with icon', 'woodmart' ),
				'icon'            => 'xts-i-alert-info',
				'editable'        => true,
				'container'       => false,
				'edit_on_create'  => true,
				'drag_target_for' => array(),
				'drag_source'     => 'content_element',
				'removable'       => true,
				'addable'         => true,
				'params'          => array(
					'icon_type'                   => array(
						'id'          => 'icon_type',
						'title'       => esc_html__( 'Icon type', 'woodmart' ),
						'tab'         => esc_html__( 'Content', 'woodmart' ),
						'description' => esc_html__( 'You can display icon based on image or just write some text like 01., 02., M, X etc.', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'icon',
						'options'     => array(
							'icon' => array(
								'label' => esc_html__( 'Icon', 'woodmart' ),
								'value' => 'icon',
							),
							'text' => array(
								'label' => esc_html__( 'Text', 'woodmart' ),
								'value' => 'text',
							),
						),
					),
					'icon_text'                   => array(
						'id'       => 'icon_text',
						'title'    => esc_html__( 'Icon text', 'woodmart' ),
						'type'     => 'text',
						'tab'      => esc_html__( 'Content', 'woodmart' ),
						'group'    => esc_html__( 'Icon', 'woodmart' ),
						'value'    => '',
						'requires' => array(
							'icon_type' => array(
								'comparison' => 'equal',
								'value'      => 'text',
							),
						),
					),
					'image'                       => array(
						'id'          => 'image',
						'title'       => esc_html__( 'Image', 'woodmart' ),
						'type'        => 'image',
						'tab'         => esc_html__( 'Content', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'value'       => '',
						'requires'    => array(
							'icon_type' => array(
								'comparison' => 'equal',
								'value'      => 'icon',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'img_size'                    => array(
						'id'          => 'img_size',
						'title'       => esc_html__( 'Image size', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Content', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'description' => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
						'value'       => '',
						'requires'    => array(
							'icon_type' => array(
								'comparison' => 'equal',
								'value'      => 'icon',
							),
						),
						'extra_class' => 'xts-col-6',
					),

					'subtitle'                    => array(
						'id'    => 'subtitle',
						'title' => esc_html__( 'Subtitle text', 'woodmart' ),
						'type'  => 'textarea',
						'tab'   => esc_html__( 'Content', 'woodmart' ),
						'group' => esc_html__( 'Content', 'woodmart' ),
						'value' => '',
					),
					'title'                       => array(
						'id'    => 'title',
						'title' => esc_html__( 'Title text', 'woodmart' ),
						'type'  => 'textarea',
						'tab'   => esc_html__( 'Content', 'woodmart' ),
						'group' => esc_html__( 'Content', 'woodmart' ),
						'value' => '',
					),
					'content'                     => array(
						'id'    => 'content',
						'title' => esc_html__( 'Content', 'woodmart' ),
						'type'  => 'editor',
						'tab'   => esc_html__( 'Content', 'woodmart' ),
						'group' => esc_html__( 'Content', 'woodmart' ),
						'value' => '',
					),
					'btn_text'                    => array(
						'id'    => 'btn_text',
						'title' => esc_html__( 'Button text', 'woodmart' ),
						'type'  => 'text',
						'tab'   => esc_html__( 'Content', 'woodmart' ),
						'group' => esc_html__( 'Content', 'woodmart' ),
						'value' => '',
					),
					'link'                        => array(
						'id'    => 'link',
						'title' => esc_html__( 'Link', 'woodmart' ),
						'type'  => 'link',
						'tab'   => esc_html__( 'Content', 'woodmart' ),
						'group' => esc_html__( 'Content', 'woodmart' ),
						'value' => '',
					),
					'el_class'                    => array(
						'id'          => 'el_class',
						'title'       => esc_html__( 'Additional CSS class', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Content', 'woodmart' ),
						'group'       => esc_html__( 'Extra', 'woodmart' ),
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
					),

					'style'                       => array(
						'id'      => 'style',
						'title'   => esc_html__( 'Box style', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'General', 'woodmart' ),
						'type'    => 'select',
						'value'   => 'base',
						'options' => array(
							'base'     => array(
								'label' => esc_html__( 'Base', 'woodmart' ),
								'value' => 'base',
							),
							'border'   => array(
								'label' => esc_html__( 'Bordered', 'woodmart' ),
								'value' => 'border',
							),
							'shadow'   => array(
								'label' => esc_html__( 'Shadow', 'woodmart' ),
								'value' => 'shadow',
							),
							'bg-hover' => array(
								'label' => esc_html__( 'Background on hover', 'woodmart' ),
								'value' => 'bg-hover',
							),
						),
					),
					'bg_hover_color'              => array(
						'id'        => 'bg_hover_color',
						'title'     => esc_html__( 'Background color on hover', 'woodmart' ),
						'tab'       => esc_html__( 'Style', 'woodmart' ),
						'group'     => esc_html__( 'General', 'woodmart' ),
						'type'      => 'color',
						'value'     => '',
						'selectors' => array(
							'{{WRAPPER}} .wd-info-box:after' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'  => array(
							'style' => array(
								'comparison' => 'equal',
								'value'      => 'bg-hover',
							),
						),
					),
					'woodmart_color_scheme'       => array(
						'id'          => 'woodmart_color_scheme',
						'title'       => esc_html__( 'Color scheme', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'General', 'woodmart' ),
						'type'        => 'selector',
						'value'       => '',
						'options'     => array(
							''      => array(
								'label' => esc_html__( 'Inherit', 'woodmart' ),
								'value' => '',
							),
							'light' => array(
								'label' => esc_html__( 'Light', 'woodmart' ),
								'value' => 'light',
							),
							'dark'  => array(
								'label' => esc_html__( 'Dark', 'woodmart' ),
								'value' => 'dark',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'woodmart_hover_color_scheme' => array(
						'id'          => 'woodmart_hover_color_scheme',
						'title'       => esc_html__( 'Color scheme on hover', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'General', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'light',
						'options'     => array(
							'light' => array(
								'label' => esc_html__( 'Light', 'woodmart' ),
								'value' => 'light',
							),
							'dark'  => array(
								'label' => esc_html__( 'Dark', 'woodmart' ),
								'value' => 'dark',
							),
						),
						'requires'    => array(
							'style' => array(
								'comparison' => 'equal',
								'value'      => 'bg-hover',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'alignment'                   => array(
						'id'      => 'alignment',
						'title'   => esc_html__( 'Text alignment', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'General', 'woodmart' ),
						'type'    => 'selector',
						'value'   => 'left',
						'options' => array(
							'left'   => array(
								'label' => esc_html__( 'Left', 'woodmart' ),
								'value' => 'left',
							),
							'center' => array(
								'label' => esc_html__( 'Center', 'woodmart' ),
								'value' => 'center',
							),
							'right'  => array(
								'label' => esc_html__( 'Right', 'woodmart' ),
								'value' => 'right',
							),
						),
					),
					'image_alignment'             => array(
						'id'          => 'image_alignment',
						'title'       => esc_html__( 'Alignment', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'top',
						'options'     => array(
							'left'  => array(
								'label' => esc_html__( 'Left', 'woodmart' ),
								'value' => 'left',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/left.png',
							),
							'top'   => array(
								'label' => esc_html__( 'Top', 'woodmart' ),
								'value' => 'top',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/top.png',
							),
							'right' => array(
								'label' => esc_html__( 'Right', 'woodmart' ),
								'value' => 'right',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/right.png',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'image_vertical_alignment'    => array(
						'id'          => 'image_vertical_alignment',
						'title'       => esc_html__( 'Vertical alignment', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'top',
						'options'     => array(
							'top'    => array(
								'label' => esc_html__( 'Top', 'woodmart' ),
								'value' => 'top',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/vertical-position/top.png',
							),
							'middle' => array(
								'label' => esc_html__( 'Middle', 'woodmart' ),
								'value' => 'middle',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/vertical-position/middle.png',
							),
							'bottom' => array(
								'label' => esc_html__( 'Bottom', 'woodmart' ),
								'value' => 'bottom',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/vertical-position/bottom.png',
							),
						),
						'requires'    => array(
							'image_alignment' => array(
								'comparison' => 'equal',
								'value'      => array( 'left', 'right' ),
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_style'                  => array(
						'id'      => 'icon_style',
						'title'   => esc_html__( 'Style', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'Icon', 'woodmart' ),
						'type'    => 'selector',
						'value'   => 'simple',
						'options' => array(
							'simple'      => array(
								'label' => esc_html__( 'Simple', 'woodmart' ),
								'value' => 'simple',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/style/simple.png',
							),
							'with-bg'     => array(
								'label' => esc_html__( 'With background', 'woodmart' ),
								'value' => 'with-bg',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/style/with-bg.png',
							),
							'with-border' => array(
								'label' => esc_html__( 'With border', 'woodmart' ),
								'value' => 'with-border',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/style/with-border.png',
							),
						),
					),
					'icon_bg_color'               => array(
						'id'          => 'icon_bg_color',
						'title'       => esc_html__( 'Background color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .info-box-icon' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_style' => array(
								'comparison' => 'equal',
								'value'      => 'with-bg',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_bg_hover_color'         => array(
						'id'          => 'icon_bg_hover_color',
						'title'       => esc_html__( 'Background color on hover', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .info-box-icon:hover' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_style' => array(
								'comparison' => 'equal',
								'value'      => 'with-bg',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_border_color'           => array(
						'id'          => 'icon_border_color',
						'title'       => esc_html__( 'Border color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .info-box-icon' => array(
								'border-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_style' => array(
								'comparison' => 'equal',
								'value'      => 'with-border',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_border_hover_color'     => array(
						'id'          => 'icon_border_hover_color',
						'title'       => esc_html__( 'Border color on hover', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .info-box-icon:hover' => array(
								'border-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_style' => array(
								'comparison' => 'equal',
								'value'      => 'with-border',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_text_size'              => array(
						'id'          => 'icon_text_size',
						'title'       => esc_html__( 'Text size', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'select',
						'value'       => 'default',
						'options'     => array(
							'default' => array(
								'label' => esc_html__( 'Default (52px)', 'woodmart' ),
								'value' => 'default',
							),
							'small'   => array(
								'label' => esc_html__( 'Small (38px)', 'woodmart' ),
								'value' => 'small',
							),
							'large'   => array(
								'label' => esc_html__( 'Large (74px)', 'woodmart' ),
								'value' => 'large',
							),
						),
						'requires'    => array(
							'icon_type' => array(
								'comparison' => 'equal',
								'value'      => 'text',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'icon_text_color'             => array(
						'id'          => 'icon_text_color',
						'title'       => esc_html__( 'Text color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Icon', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .box-with-text' => array(
								'color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'icon_type' => array(
								'comparison' => 'equal',
								'value'      => 'text',
							),
						),
						'extra_class' => 'xts-col-6',
					),

					'subtitle_style'              => array(
						'id'          => 'subtitle_style',
						'title'       => esc_html__( 'Style', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'default',
						'options'     => array(
							'default'    => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => 'default',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/subtitle-style/default.png',
							),
							'background' => array(
								'label' => esc_html__( 'Background', 'woodmart' ),
								'value' => 'background',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/subtitle-style/background.png',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'subtitle_custom_bg_color'    => array(
						'id'          => 'subtitle_custom_bg_color',
						'title'       => esc_html__( 'Background color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .info-box-subtitle' => array(
								'background-color: {{VALUE}};',
							),
						),
						'requires'    => array(
							'subtitle_style' => array(
								'comparison' => 'equal',
								'value'      => 'background',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'subtitle_style_divider'      => array(
						'id'    => 'subtitle_style_divider',
						'type'  => 'divider',
						'tab'   => esc_html__( 'Style', 'woodmart' ),
						'group' => esc_html__( 'Subtitle', 'woodmart' ),
						'value' => '',
					),
					'subtitle_color'              => array(
						'id'          => 'subtitle_color',
						'title'       => esc_html__( 'Predefined color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'type'        => 'select',
						'value'       => 'default',
						'options'     => array(
							'default' => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => 'default',
							),
							'primary' => array(
								'label' => esc_html__( 'Primary', 'woodmart' ),
								'value' => 'primary',
							),
							'alt'     => array(
								'label' => esc_html__( 'Alternative', 'woodmart' ),
								'value' => 'alt',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'subtitle_custom_color'       => array(
						'id'          => 'subtitle_custom_color',
						'title'       => esc_html__( 'Custom color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .info-box-subtitle' => array(
								'color: {{VALUE}};',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'subtitle_font'               => array(
						'id'          => 'subtitle_font',
						'title'       => esc_html__( 'Font family', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'type'        => 'select',
						'value'       => '',
						'options'     => array(
							''        => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => '',
							),
							'text'    => array(
								'label' => $text_font_title,
								'value' => 'text',
							),
							'primary' => array(
								'label' => $primary_font_title,
								'value' => 'primary',
							),
							'alt'     => array(
								'label' => $secondary_font_title,
								'value' => 'alt',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'subtitle_font_weight'        => array(
						'id'          => 'subtitle_font_weight',
						'title'       => esc_html__( 'Font weight', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'type'        => 'select',
						'value'       => '',
						'options'     => array(
							''  => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => '',
							),
							100 => array(
								'label' => esc_html__( 'Ultra-Light 100', 'woodmart' ),
								'value' => 100,
							),
							200 => array(
								'label' => esc_html__( 'Light 200', 'woodmart' ),
								'value' => 200,
							),
							300 => array(
								'label' => esc_html__( 'Book 300', 'woodmart' ),
								'value' => 300,
							),
							400 => array(
								'label' => esc_html__( 'Normal 400', 'woodmart' ),
								'value' => 400,
							),
							500 => array(
								'label' => esc_html__( 'Medium 500', 'woodmart' ),
								'value' => 500,
							),
							600 => array(
								'label' => esc_html__( 'Semi-Bold 600', 'woodmart' ),
								'value' => 600,
							),
							700 => array(
								'label' => esc_html__( 'Bold 700', 'woodmart' ),
								'value' => 700,
							),
							800 => array(
								'label' => esc_html__( 'Extra-Bold 800', 'woodmart' ),
								'value' => 800,
							),
							900 => array(
								'label' => esc_html__( 'Ultra-Bold 900', 'woodmart' ),
								'value' => 900,
							),
						),
						'selectors'   => array(
							'{{WRAPPER}} .info-box-subtitle' => array(
								'font-weight: {{VALUE}};',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'subtitle_font_size'          => array(
						'id'          => 'subtitle_font_size',
						'title'       => esc_html__( 'Font size', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}} .info-box-subtitle' => array(
								'font-size: {{VALUE}};',
							),
						),
						'description' => esc_html__( 'Insert value including units. For example: "14px" or "1.5em".', 'woodmart' ),
						'value'       => '',
						'extra_class' => 'xts-col-6',
					),
					'subtitle_line_height'        => array(
						'id'          => 'subtitle_line_height',
						'title'       => esc_html__( 'Line height', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Subtitle', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}} .wd-info-box .info-box-content .info-box-subtitle' => array(
								'line-height: {{VALUE}};',
							),
						),
						'value'       => '',
						'description' => esc_html__( 'Insert default or reletive value. For example: "14px" or "1.2".', 'woodmart' ),
						'extra_class' => 'xts-col-6',
					),

					'title_style'                 => array(
						'id'          => 'title_style',
						'title'       => esc_html__( 'Style', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'type'        => 'selector',
						'value'       => 'default',
						'options'     => array(
							'default'    => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => 'default',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/title-style/default.png',
							),
							'underlined' => array(
								'label' => esc_html__( 'Underline', 'woodmart' ),
								'value' => 'underlined',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/title-style/underlined.png',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'title_color'                 => array(
						'id'          => 'title_color',
						'title'       => esc_html__( 'Color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'type'        => 'color',
						'value'       => '',
						'selectors'   => array(
							'{{WRAPPER}} .info-box-title' => array(
								'color: {{VALUE}};',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'title_font'                  => array(
						'id'          => 'title_font',
						'title'       => esc_html__( 'Font family', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'type'        => 'select',
						'value'       => '',
						'options'     => array(
							''        => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => '',
							),
							'text'    => array(
								'label' => $text_font_title,
								'value' => 'text',
							),
							'primary' => array(
								'label' => $primary_font_title,
								'value' => 'primary',
							),
							'alt'     => array(
								'label' => $secondary_font_title,
								'value' => 'alt',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'title_font_weight'           => array(
						'id'          => 'title_font_weight',
						'title'       => esc_html__( 'Font weight', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'type'        => 'select',
						'value'       => '',
						'options'     => array(
							''  => array(
								'label' => esc_html__( 'Default', 'woodmart' ),
								'value' => '',
							),
							100 => array(
								'label' => esc_html__( 'Ultra-Light 100', 'woodmart' ),
								'value' => 100,
							),
							200 => array(
								'label' => esc_html__( 'Light 200', 'woodmart' ),
								'value' => 200,
							),
							300 => array(
								'label' => esc_html__( 'Book 300', 'woodmart' ),
								'value' => 300,
							),
							400 => array(
								'label' => esc_html__( 'Normal 400', 'woodmart' ),
								'value' => 400,
							),
							500 => array(
								'label' => esc_html__( 'Medium 500', 'woodmart' ),
								'value' => 500,
							),
							600 => array(
								'label' => esc_html__( 'Semi-Bold 600', 'woodmart' ),
								'value' => 600,
							),
							700 => array(
								'label' => esc_html__( 'Bold 700', 'woodmart' ),
								'value' => 700,
							),
							800 => array(
								'label' => esc_html__( 'Extra-Bold 800', 'woodmart' ),
								'value' => 800,
							),
							900 => array(
								'label' => esc_html__( 'Ultra-Bold 900', 'woodmart' ),
								'value' => 900,
							),
						),
						'selectors'   => array(
							'{{WRAPPER}} .info-box-title' => array(
								'font-weight: {{VALUE}};',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'title_size'                  => array(
						'id'          => 'title_size',
						'title'       => esc_html__( 'Predefined font size', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'type'        => 'select',
						'value'       => 'default',
						'options'     => array(
							'default'     => array(
								'label' => esc_html__( 'Default (18px)', 'woodmart' ),
								'value' => 'default',
							),
							'small'       => array(
								'label' => esc_html__( 'Small (16px)', 'woodmart' ),
								'value' => 'small',
							),
							'large'       => array(
								'label' => esc_html__( 'Large (26px)', 'woodmart' ),
								'value' => 'primary',
							),
							'extra-large' => array(
								'label' => esc_html__( 'Extra Large (36px)', 'woodmart' ),
								'value' => 'extra-large',
							),
						),
						'extra_class' => 'xts-col-6',
					),
					'title_font_size'             => array(
						'id'          => 'title_font_size',
						'title'       => esc_html__( 'Font size', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}} .info-box-title' => array(
								'font-size: {{VALUE}};',
							),
						),
						'value'       => '',
						'description' => esc_html__( 'Insert value including units. For example: "14px" or "1.5em".', 'woodmart' ),
						'extra_class' => 'xts-col-6',
					),
					'title_line_height'           => array(
						'id'          => 'title_line_height',
						'title'       => esc_html__( 'Line height', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}} .wd-info-box .info-box-title' => array(
								'line-height: {{VALUE}};',
							),
						),
						'value'       => '',
						'extra_class' => 'xts-col-6',
						'description' => esc_html__( 'Insert default or reletive value. For example: "14px" or "1.2".', 'woodmart' ),
					),
					'title_tag'                   => array(
						'id'          => 'title_tag',
						'title'       => esc_html__( 'Tag', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Title', 'woodmart' ),
						'type'        => 'select',
						'value'       => 'h4',
						'options'     => array(
							'h1'   => array(
								'label' => 'h1',
								'value' => 'h1',
							),
							'h2'   => array(
								'label' => 'h2',
								'value' => 'h2',
							),
							'h3'   => array(
								'label' => 'h3',
								'value' => 'h3',
							),
							'h4'   => array(
								'label' => 'h4',
								'value' => 'h4',
							),
							'h5'   => array(
								'label' => 'h5',
								'value' => 'h5',
							),
							'h6'   => array(
								'label' => 'h6',
								'value' => 'h6',
							),
							'p'    => array(
								'label' => 'p',
								'value' => 'p',
							),
							'div'  => array(
								'label' => 'div',
								'value' => 'div',
							),
							'span' => array(
								'label' => 'span',
								'value' => 'span',
							),
						),
						'extra_class' => 'xts-col-6',
					),

					'custom_text_color'           => array(
						'id'        => 'custom_text_color',
						'title'     => esc_html__( 'Text Color', 'woodmart' ),
						'tab'       => esc_html__( 'Style', 'woodmart' ),
						'group'     => esc_html__( 'Content', 'woodmart' ),
						'type'      => 'color',
						'value'     => '',
						'selectors' => array(
							'{{WRAPPER}} .info-box-inner' => array(
								'color: {{VALUE}};',
							),
						),
					),
					'content_font_size'           => array(
						'id'          => 'content_font_size',
						'title'       => esc_html__( 'Font size', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Content', 'woodmart' ),
						'description' => esc_html__( 'Insert value including units. For example: "14px" or "1.5em".', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}} .info-box-inner' => array(
								'font-size: {{VALUE}};',
							),
						),
						'value'       => '',
						'extra_class' => 'xts-col-6',
					),
					'content_line_height'         => array(
						'id'          => 'content_line_height',
						'title'       => esc_html__( 'Line height', 'woodmart' ),
						'type'        => 'text',
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Content', 'woodmart' ),
						'description' => esc_html__( 'Insert default or reletive value. For example: "14px" or "1.2".', 'woodmart' ),
						'selectors'   => array(
							'{{WRAPPER}} .info-box-inner' => array(
								'line-height: {{VALUE}};',
							),
						),
						'value'       => '',
						'extra_class' => 'xts-col-6',
					),

					'btn_style'                   => array(
						'id'      => 'btn_style',
						'title'   => esc_html__( 'Style', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'Button', 'woodmart' ),
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

					'btn_shape'                   => array(
						'id'       => 'btn_shape',
						'title'    => esc_html__( 'Shape', 'woodmart' ),
						'tab'      => esc_html__( 'Style', 'woodmart' ),
						'group'    => esc_html__( 'Button', 'woodmart' ),
						'type'     => 'selector',
						'value'    => 'rectangle',
						'options'  => array(
							'rectangle'  => array(
								'label' => esc_html__( 'Rectangle', 'woodmart' ),
								'value' => 'rectangle',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/rectangle.jpeg',
							),
							'round'      => array(
								'label' => esc_html__( 'Round', 'woodmart' ),
								'value' => 'round',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/circle.jpeg',
							),
							'semi-round' => array(
								'label' => esc_html__( 'Rounded', 'woodmart' ),
								'value' => 'semi-round',
								'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/round.jpeg',
							),
						),
						'requires' => array(
							'btn_style' => array(
								'comparison' => 'not_equal',
								'value'      => 'link',
							),
						),
					),
					'btn_size'                    => array(
						'id'          => 'btn_size',
						'title'       => esc_html__( 'Predefined size', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Button', 'woodmart' ),
						'type'        => 'select',
						'value'       => 'default',
						'options'     => array(
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
						'extra_class' => 'xts-col-6',
					),
					'btn_color'                   => array(
						'id'          => 'btn_color',
						'title'       => esc_html__( 'Predefined color', 'woodmart' ),
						'tab'         => esc_html__( 'Style', 'woodmart' ),
						'group'       => esc_html__( 'Button', 'woodmart' ),
						'type'        => 'select',
						'value'       => 'default',
						'options'     => array(
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
						'extra_class' => 'xts-col-6',
					),
					'btn_position'                => array(
						'id'      => 'btn_position',
						'title'   => esc_html__( 'Button position', 'woodmart' ),
						'tab'     => esc_html__( 'Style', 'woodmart' ),
						'group'   => esc_html__( 'Button', 'woodmart' ),
						'type'    => 'select',
						'value'   => 'hover',
						'options' => array(
							'hover'  => array(
								'label' => esc_html__( 'Show on hover', 'woodmart' ),
								'value' => 'hover',
							),
							'static' => array(
								'label' => esc_html__( 'Static', 'woodmart' ),
								'value' => 'static',
							),
						),
					),
				),
			);
		}
	}
}
