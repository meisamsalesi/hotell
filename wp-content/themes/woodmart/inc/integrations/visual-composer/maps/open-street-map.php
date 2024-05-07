<?php
/**
 * Open street map.
 *
 * @package Elements
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_open_street_map' ) ) {
	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_get_vc_map_open_street_map() {
		return array(
			'base'            => 'woodmart_open_street_map',
			'name'            => esc_html__( 'Open street map', 'woodmart' ),
			'description'     => esc_html__( 'Show Open street map', 'woodmart' ),
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'as_parent'       => array( 'except' => 'testimonial' ),
			'content_element' => true,
			'js_view'         => 'VcColumnView',
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/open-street-map.svg',
			'params'          => array(
				array(
					'param_name' => 'woodmart_css_id',
					'type'       => 'woodmart_css_id',
				),
				/**
				 * Settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Settings', 'woodmart' ),
					'param_name' => 'title_divider',
				),
				array(
					'type'       => 'param_group',
					'param_name' => 'marker_list',
					'heading'    => esc_html__( 'Marker list', 'woodmart' ),
					'params'     => array(
						array(
							'type'          => 'woodmart_title_divider',
							'holder'        => 'div',
							'title'         => esc_html__( 'Content', 'woodmart' ),
							'param_name'    => 'marker_content_title_divider',
							'without_group' => true,
						),
						array(
							'param_name'  => 'marker_title',
							'type'        => 'textfield',
							'admin_label' => true,
							'heading'     => esc_html__( 'Title', 'woodmart' ),
						),
						array(
							'param_name' => 'marker_coords',
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Coordinates', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'param_name'  => 'marker_description',
							'type'        => 'textarea',
							'admin_label' => true,
							'heading'     => esc_html__( 'Description', 'woodmart' ),
						),
						array(
							'heading'    => esc_html__( 'Behavior', 'woodmart' ),
							'type'       => 'dropdown',
							'param_name' => 'marker_behavior',
							'value'      => array(
								esc_html__( 'Popup', 'woodmart' ) => 'popup',
								esc_html__( 'Tooltip', 'woodmart' ) => 'tooltip',
								esc_html__( 'Static with close', 'woodmart' ) => 'static_close_on',
								esc_html__( 'Static without close', 'woodmart' ) => 'static_close_off',
								esc_html__( 'None', 'woodmart' ) => 'none',
							),
						),
						array(
							'type'        => 'woodmart_switch',
							'heading'     => esc_html__( 'Show button', 'woodmart' ),
							'param_name'  => 'show_button',
							'true_state'  => esc_html__( 'yes', 'woodmart' ),
							'false_state' => esc_html__( 'no', 'woodmart' ),
							'default'     => 'no',
						),
						array(
							'param_name' => 'button_text',
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Button text', 'woodmart' ),
							'dependency' => array(
								'element' => 'show_button',
								'value'   => array( 'yes' ),
							),
						),
						array(
							'param_name' => 'button_url',
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Button URL', 'woodmart' ),
							'dependency' => array(
								'element' => 'show_button',
								'value'   => array( 'yes' ),
							),
						),
						array(
							'heading'    => esc_html__( 'URL target', 'woodmart' ),
							'type'       => 'dropdown',
							'param_name' => 'button_url_target',
							'value'      => array(
								esc_html__( 'Same Window', 'woodmart' ) => '_self',
								esc_html__( 'New Window/Tab', 'woodmart' ) => '_blank',
							),
							'std'        => '_blank',
							'dependency' => array(
								'element'            => 'button_url',
								'value_not_equal_to' => array( '' ),
							),
						),
						array(
							'type'          => 'woodmart_title_divider',
							'holder'        => 'div',
							'title'         => esc_html__( 'Marker', 'woodmart' ),
							'param_name'    => 'marker_image_title_divider',
							'without_group' => true,
						),
						array(
							'type'       => 'attach_image',
							'heading'    => esc_html__( 'Image', 'woodmart' ),
							'param_name' => 'image',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Image size', 'woodmart' ),
							'param_name'  => 'image_size',
							'description' => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
							'value'       => 'full',
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
					),
				),
				/**
				 * Marker settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Marker settings', 'woodmart' ),
					'param_name' => 'title_divider',
				),
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Marker icon', 'woodmart' ),
					'param_name' => 'marker_icon',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Image size', 'woodmart' ),
					'param_name'  => 'marker_icon_size',
					'description' => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
					'value'       => 'full',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Map settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Map settings', 'woodmart' ),
					'param_name' => 'title_divider',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Map mask', 'woodmart' ),
					'hint'             => esc_html__( 'Add an overlay to your map to make the content look cleaner on the map.', 'woodmart' ),
					'param_name'       => 'mask',
					'value'            => array(
						esc_html__( 'Without', 'woodmart' ) => '',
						esc_html__( 'Dark', 'woodmart' )  => 'dark',
						esc_html__( 'Light', 'woodmart' ) => 'light',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Zoom', 'woodmart' ),
					'hint'             => esc_html__( 'Zoom level when focus the marker 1 - 20', 'woodmart' ),
					'type'             => 'wd_slider',
					'param_name'       => 'zoom',
					'selectors'        => array(
						'{{WRAPPER}}' => array(),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '15',
							'unit'  => 'level',
						),
					),
					'range'            => array(
						'level' => array(
							'min' => 1,
							'max' => 20,
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Map Height', 'woodmart' ),
					'type'             => 'wd_slider',
					'param_name'       => 'height',
					'selectors'        => array(
						'{{WRAPPER}}.wd-osm-map-container .wd-osm-map-wrapper' => array(
							'height: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '400',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '200',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '200',
							'unit'  => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 40,
							'max'  => 2000,
							'step' => 10,
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Zoom control', 'woodmart' ),
					'param_name'       => 'zoom_control',
					'true_state'       => esc_html__( 'yes', 'woodmart' ),
					'false_state'      => esc_html__( 'no', 'woodmart' ),
					'default'          => 'yes',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Zoom with mouse wheel', 'woodmart' ),
					'param_name'       => 'scroll_zoom',
					'true_state'       => esc_html__( 'yes', 'woodmart' ),
					'false_state'      => esc_html__( 'no', 'woodmart' ),
					'default'          => 'yes',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Pan control', 'woodmart' ),
					'param_name'       => 'pan_control',
					'true_state'       => esc_html__( 'yes', 'woodmart' ),
					'false_state'      => esc_html__( 'no', 'woodmart' ),
					'default'          => 'yes',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'Map style (Tile)', 'woodmart' ),
					'type'       => 'dropdown',
					'param_name' => 'geoapify_tile',
					'value'      => array(
						esc_html__( 'OSM carto', 'woodmart' ) => 'osm-carto',
						esc_html__( 'Stamen toner', 'woodmart' ) => 'stamen-toner',
						esc_html__( 'Stamen terrain', 'woodmart' ) => 'stamen-terrain',
						esc_html__( 'Stamen watercolor', 'woodmart' ) => 'stamen-watercolor',
						esc_html__( 'Custom map tile', 'woodmart' ) => 'custom-tile',
					),
				),
				array(
					'param_name'  => 'geoapify_custom_tile',
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Custom map tile URL', 'woodmart' ),
					'description' => sprintf(
						__( 'You can find more Open Street Maps styles on the website: %1$s OpenStreetMap Wiki %2$s %3$s Just copy url and paste it here %3$s For example: %4$s', 'woodmart' ),
						'<a target="_blank" href="https://wiki.openstreetmap.org/wiki/Raster_tile_providers">',
						'</a>',
						'<br>',
						'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png'
					),
					'dependency'  => array(
						'element' => 'geoapify_tile',
						'value'   => array( 'custom-tile' ),
					),
				),
				array(
					'param_name' => 'osm_custom_attribution',
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Attribution title', 'woodmart' ),
					'dependency' => array(
						'element' => 'geoapify_tile',
						'value'   => array( 'custom-tile' ),
					),
				),
				array(
					'param_name' => 'osm_custom_attribution_url',
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Attribution URL', 'woodmart' ),
					'dependency' => array(
						'element' => 'geoapify_tile',
						'value'   => array( 'custom-tile' ),
					),
				),
				/**
				 * Extra.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				/**
				 * Content settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Content settings', 'woodmart' ),
					'group'      => esc_html__( 'Content', 'woodmart' ),
					'param_name' => 'content_set_divider',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Content on the map horizontal position', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'content_horizontal',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/left.png',
						'center' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/center.png',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/right.png',
					),
					'std'              => 'left',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Content on the map vertical position', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'content_vertical',
					'value'            => array(
						esc_html__( 'Top', 'woodmart' ) => 'top',
						esc_html__( 'Middle', 'woodmart' ) => 'middle',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
					),
					'images_value'     => array(
						'top'    => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/top.png',
						'middle' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/middle.png',
						'bottom' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/bottom.png',
					),
					'std'              => 'top',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
				),
				array(
					'type'             => 'woodmart_slider',
					'heading'          => esc_html__( 'Content width', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'content_width',
					'min'              => '100',
					'max'              => '2000',
					'step'             => '10',
					'default'          => '300',
					'units'            => 'px',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Default: 300', 'woodmart' ),
				),
				/**
				 * Loading settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Lazy loading settings', 'woodmart' ),
					'group'      => esc_html__( 'Content', 'woodmart' ),
					'param_name' => 'loading_set_divider',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Init event', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'init_type',
					'value'            => array(
						esc_html__( 'On page load', 'woodmart' ) => 'page_load',
						esc_html__( 'On scroll', 'woodmart' ) => 'scroll',
						esc_html__( 'On button click', 'woodmart' ) => 'button',
						esc_html__( 'On user interaction', 'woodmart' ) => 'interaction',
					),
					'hint'             => esc_html__( 'For a better performance you can initialize the Open street map only when you scroll down the page or when you click on it.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'woodmart_slider',
					'heading'          => esc_html__( 'Scroll offset', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'init_offset',
					'min'              => '0',
					'max'              => '1000',
					'step'             => '10',
					'default'          => '100',
					'units'            => 'px',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Default: 100', 'woodmart' ),
					'dependency'       => array(
						'element' => 'init_type',
						'value'   => array( 'scroll' ),
					),
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Placeholders', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'map_init_placeholder',
					'value'            => '',
					'hint'             => esc_html__( "Select image from media library.", 'woodmart' ), // phpcs:ignore.
					'dependency'       => array(
						'element' => 'init_type',
						'value'   => array( 'scroll', 'button', 'interaction' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Placeholder size', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'map_init_placeholder_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'init_type',
						'value'   => array( 'scroll', 'button', 'interaction' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
				),
				/**
				 * Design Options.
				 */
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',
			),
		);
	}
}

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container.
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_woodmart_open_street_map extends WPBakeryShortCodesContainer { // phpcs:ignore.

	}
}
