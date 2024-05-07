<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
/**
* ------------------------------------------------------------------------------------------------
*  Google map element map
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_get_vc_map_google_map' ) ) {
	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_get_vc_map_google_map() {
		return array(
			'name'            => esc_html__( 'Google map', 'woodmart' ),
			'description'     => esc_html__( 'Shows Google map block', 'woodmart' ),
			'base'            => 'woodmart_google_map',
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'as_parent'       => array( 'except' => 'testimonial' ),
			'content_element' => true,
			'js_view'         => 'VcColumnView',
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/google-maps.svg',
			'params'          => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				/**
				 * Settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Settings', 'woodmart' ),
					'param_name' => 'settings_divider',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Google API key', 'woodmart' ),
					'param_name' => 'google_key',
					'hint'       => wp_kses(
						__( 'Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google map VC element.', 'woodmart' ),
						array(
							'a' => array(
								'href'   => array(),
								'target' => array(),
							),
						)
					),
				),
				array(
					'type'        => 'woodmart_switch',
					'heading'     => esc_html__( 'Multiple markers', 'woodmart' ),
					'param_name'  => 'multiple_markers',
					'true_state'  => 'yes',
					'false_state' => 'no',
					'default'     => 'no',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Latitude (required)', 'woodmart' ),
					'param_name'       => 'lat',
					'hint'             => wp_kses(
						__( 'You can use <a href="https://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">this service</a> to get coordinates of your location.', 'woodmart' ),
						array(
							'a' => array(
								'href'   => array(),
								'target' => array(),
							),
						)
					),
					'dependency'       => array(
						'element' => 'multiple_markers',
						'value'   => array( 'no' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Longitude (required)', 'woodmart' ),
					'param_name'       => 'lon',
					'dependency'       => array(
						'element' => 'multiple_markers',
						'value'   => array( 'no' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'param_group',
					'param_name' => 'marker_list',
					'heading'    => esc_html__( 'Marker list', 'woodmart' ),
					'dependency' => array(
						'element' => 'multiple_markers',
						'value'   => array( 'yes' ),
					),
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
							'param_name'       => 'marker_lat',
							'type'             => 'textfield',
							'hint'             => wp_kses(
								__( 'You can use <a href="https://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">this service</a> to get coordinates of your location.', 'woodmart' ),
								array(
									'a' => array(
										'href'   => array(),
										'target' => array(),
									),
								)
							),
							'admin_label'      => true,
							'heading'          => esc_html__( 'Latitude (required)', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'param_name'       => 'marker_lon',
							'type'             => 'textfield',
							'admin_label'      => true,
							'heading'          => esc_html__( 'Longitude (required)', 'woodmart' ),
							'edit_field_class' => 'vc_col-sm-6 vc_column',
						),
						array(
							'param_name'  => 'marker_description',
							'type'        => 'textarea',
							'admin_label' => true,
							'heading'     => esc_html__( 'Description', 'woodmart' ),
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
							'value'       => '',
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
					'param_name' => 'marker_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Marker icon', 'woodmart' ),
					'param_name'       => 'marker_icon',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Image size', 'woodmart' ),
					'param_name'  => 'marker_icon_size',
					'description' => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
					'value'       => '',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'dependency'       => array(
						'element' => 'multiple_markers',
						'value'   => array( 'no' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textarea',
					'heading'          => esc_html__( 'Text on marker', 'woodmart' ),
					'param_name'       => 'marker_text',
					'dependency'       => array(
						'element' => 'multiple_markers',
						'value'   => array( 'no' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Map settings.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Map settings', 'woodmart' ),
					'param_name' => 'map_set_divider',
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
					'type'             => 'woodmart_slider',
					'heading'          => esc_html__( 'Zoom', 'woodmart' ),
					'param_name'       => 'zoom',
					'min'              => '0',
					'max'              => '19',
					'step'             => '1',
					'default'          => '15',
					'units'            => '',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Zoom level when focus the marker 0 - 19', 'woodmart' ),
				),
				array(
					'type'             => 'wd_slider',
					'heading'          => esc_html__( 'Map Height', 'woodmart' ),
					'param_name'       => 'new_height',
					'selectors'        => array(
						'{{WRAPPER}}' => array(
							'height: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'transfer'         => 'height',
				),
				array(
					'type'             => 'woodmart_slider',
					'heading'          => esc_html__( 'Map height', 'woodmart' ),
					'param_name'       => 'height',
					'min'              => '100',
					'max'              => '2000',
					'step'             => '10',
					'default'          => '400',
					'units'            => 'px',
					'edit_field_class' => 'vc_col-sm-6 vc_column xts-hidden',
					'hint'             => esc_html__( 'Default: 400', 'woodmart' ),
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Zoom with mouse wheel', 'woodmart' ),
					'param_name'       => 'scroll',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'        => 'textarea_raw_html',
					'heading'     => esc_html__( 'Styles (JSON)', 'woodmart' ),
					'param_name'  => 'style_json',
					'description' => sprintf(
						__( 'Styled maps allow you to customize the presentation of the standard Google base maps, changing the visual display of such elements as roads, parks, and built-up areas. %3$s You can find more Google maps styles on the website: %1$s Snazzy Maps %2$s %3$s Just copy JSON code and paste it here %3$s For example: %3$s %4$s', 'woodmart' ),
						'<a target="_blank" href="https://snazzymaps.com/">',
						'</a>',
						'<br>',
						'[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]'
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
					'hint'             => esc_html__( 'For a better performance you can initialize the Google map only when you scroll down the page or when you click on it.', 'woodmart' ),
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
	class WPBakeryShortCode_woodmart_google_map extends WPBakeryShortCodesContainer { // phpcs:ignore.

	}
}
