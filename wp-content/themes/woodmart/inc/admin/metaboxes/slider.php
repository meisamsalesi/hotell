<?php
/**
 * Slider metaboxes
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Metaboxes;

if ( ! function_exists( 'woodmart_register_slider_metaboxes' ) ) {
	/**
	 * Register slider metaboxes
	 *
	 * @since 1.0.0
	 */
	function woodmart_register_slider_metaboxes() {
		$slide_metabox = Metaboxes::add_metabox(
			array(
				'id'         => 'xts_slide_metaboxes',
				'title'      => esc_html__( 'Slide Settings', 'woodmart' ),
				'post_types' => array( 'woodmart_slide' ),
			)
		);

		$slide_metabox->add_section(
			array(
				'id'       => 'slide_content',
				'name'     => esc_html__( 'Layout', 'woodmart' ),
				'icon'     => 'xts-i-layout',
				'priority' => 10,
			)
		);

		$slide_metabox->add_section(
			array(
				'id'       => 'image_settings',
				'name'     => esc_html__( 'Background', 'woodmart' ),
				'icon'     => 'xts-i-image',
				'priority' => 20,
			)
		);

		$slide_metabox->add_section(
			array(
				'id'       => 'slide_link',
				'name'     => esc_html__( 'Settings', 'woodmart' ),
				'icon'     => 'xts-i-setting-slider-in-square',
				'priority' => 30,
			)
		);

		$slide_metabox->add_field(
			array(
				'id'        => 'bg_color',
				'name'      => esc_html__( 'Color', 'woodmart' ),
				'type'      => 'color',
				'section'   => 'image_settings',
				'default'   => '#fefefe',
				'data_type' => 'hex',
				'priority'  => 19,
			)
		);

		// Desktop.
		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_desktop',
				'name'     => esc_html__( 'Background image', 'woodmart' ),
				'type'     => 'upload',
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'slide_image_settings_tab',
						'compare' => 'equals',
						'value'   => 'desktop',
					),
				),
				't_tab'    => [
					'id'    => 'settings_tabs',
					'tab'   => esc_html__( 'Desktop', 'woodmart' ),
					'title' => esc_html__( 'Image', 'woodmart' ),
					'style' => 'default',
				],
				'priority' => 20,
				'class'    => 'xts-tab-field',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'           => 'bg_image_size_desktop',
				'name'         => esc_html__( 'Background size', 'woodmart' ),
				'type'         => 'select',
				'empty_option' => true,
				'select2'      => true,
				'section'      => 'image_settings',
				'options'      => array(
					'cover'   => array(
						'name'  => esc_html__( 'Cover', 'woodmart' ),
						'value' => 'cover',
					),
					'contain' => array(
						'name'  => esc_html__( 'Contain', 'woodmart' ),
						'value' => 'contain',
					),
				),
				'default'      => 'cover',
				't_tab'        => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-desktop',
					'tab'  => esc_html__( 'Desktop', 'woodmart' ),
				],
				'priority'     => 30,
				'class'        => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'           => 'bg_image_position_desktop',
				'name'         => esc_html__( 'Background position', 'woodmart' ),
				'type'         => 'select',
				'empty_option' => true,
				'select2'      => true,
				'section'      => 'image_settings',
				'options'      => array(
					'left-top'      => array(
						'name'  => esc_html__( 'Left Top', 'woodmart' ),
						'value' => 'left top',
					),
					'left-center'   => array(
						'name'  => esc_html__( 'Left Center', 'woodmart' ),
						'value' => 'left center',
					),
					'left-bottom'   => array(
						'name'  => esc_html__( 'Left Bottom', 'woodmart' ),
						'value' => 'left bottom',
					),
					'center-top'    => array(
						'name'  => esc_html__( 'Center Top', 'woodmart' ),
						'value' => 'center top',
					),
					'center-center' => array(
						'name'  => esc_html__( 'Center Center', 'woodmart' ),
						'value' => 'center center',
					),
					'center-bottom' => array(
						'name'  => esc_html__( 'Center Bottom', 'woodmart' ),
						'value' => 'center bottom',
					),
					'right-top'     => array(
						'name'  => esc_html__( 'Right Top', 'woodmart' ),
						'value' => 'right top',
					),
					'right-center'  => array(
						'name'  => esc_html__( 'Right Center', 'woodmart' ),
						'value' => 'right center',
					),
					'right-bottom'  => array(
						'name'  => esc_html__( 'Right Bottom', 'woodmart' ),
						'value' => 'right bottom',
					),
					'custom'        => array(
						'name'  => esc_html__( 'Custom', 'woodmart' ),
						'value' => 'custom',
					),
				),
				'default'      => 'center center',
				't_tab'        => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-desktop',
					'tab'  => esc_html__( 'Desktop', 'woodmart' ),
				],
				'priority'     => 40,
				'class'        => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_position_x_desktop',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Position by X (px)', 'woodmart' ),
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'bg_image_position_desktop',
						'compare' => 'equals',
						'value'   => 'custom',
					),
				),
				't_tab'    => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-desktop',
					'tab'  => esc_html__( 'Desktop', 'woodmart' ),
				],
				'priority' => 50,
				'class'    => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_position_y_desktop',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Position by Y (px)', 'woodmart' ),
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'bg_image_position_desktop',
						'compare' => 'equals',
						'value'   => 'custom',
					),
				),
				't_tab'    => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-desktop',
					'tab'  => esc_html__( 'Desktop', 'woodmart' ),
				],
				'priority' => 60,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		// Tablet.
		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_tablet',
				'name'     => esc_html__( 'Background image', 'woodmart' ),
				'type'     => 'upload',
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'slide_image_settings_tab',
						'compare' => 'equals',
						'value'   => 'tablet',
					),
				),
				't_tab'    => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-tablet',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
				],
				'priority' => 80,
				'class'    => 'xts-tab-field',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'           => 'bg_image_size_tablet',
				'name'         => esc_html__( 'Background size', 'woodmart' ),
				'type'         => 'select',
				'empty_option' => true,
				'select2'      => true,
				'section'      => 'image_settings',
				'options'      => array(
					'cover'   => array(
						'name'  => esc_html__( 'Cover', 'woodmart' ),
						'value' => 'cover',
					),
					'contain' => array(
						'name'  => esc_html__( 'Contain', 'woodmart' ),
						'value' => 'contain',
					),
					'inherit' => array(
						'name'  => esc_html__( 'Inherit', 'woodmart' ),
						'value' => 'inherit',
					),
				),
				't_tab'        => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-tablet',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
				],
				'priority'     => 90,
				'class'        => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'           => 'bg_image_position_tablet',
				'name'         => esc_html__( 'Background position', 'woodmart' ),
				'type'         => 'select',
				'empty_option' => true,
				'select2'      => true,
				'section'      => 'image_settings',
				'options'      => array(
					'left-top'      => array(
						'name'  => esc_html__( 'Left Top', 'woodmart' ),
						'value' => 'left top',
					),
					'left-center'   => array(
						'name'  => esc_html__( 'Left Center', 'woodmart' ),
						'value' => 'left center',
					),
					'left-bottom'   => array(
						'name'  => esc_html__( 'Left Bottom', 'woodmart' ),
						'value' => 'left bottom',
					),
					'center-top'    => array(
						'name'  => esc_html__( 'Center Top', 'woodmart' ),
						'value' => 'center top',
					),
					'center-center' => array(
						'name'  => esc_html__( 'Center Center', 'woodmart' ),
						'value' => 'center center',
					),
					'center-bottom' => array(
						'name'  => esc_html__( 'Center Bottom', 'woodmart' ),
						'value' => 'center bottom',
					),
					'right-top'     => array(
						'name'  => esc_html__( 'Right Top', 'woodmart' ),
						'value' => 'right top',
					),
					'right-center'  => array(
						'name'  => esc_html__( 'Right Center', 'woodmart' ),
						'value' => 'right center',
					),
					'right-bottom'  => array(
						'name'  => esc_html__( 'Right Bottom', 'woodmart' ),
						'value' => 'right bottom',
					),
					'custom'        => array(
						'name'  => esc_html__( 'Custom', 'woodmart' ),
						'value' => 'custom',
					),
				),
				't_tab'        => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-tablet',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
				],
				'priority'     => 100,
				'class'        => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_position_x_tablet',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Position by X (px)', 'woodmart' ),
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'bg_image_position_tablet',
						'compare' => 'equals',
						'value'   => 'custom',
					),
				),
				't_tab'    => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-tablet',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
				],
				'priority' => 110,
				'class'    => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_position_y_tablet',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Position by Y (px)', 'woodmart' ),
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'bg_image_position_tablet',
						'compare' => 'equals',
						'value'   => 'custom',
					),
				),
				't_tab'    => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-tablet',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
				],
				'priority' => 120,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		// Mobile.
		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_mobile',
				'name'     => esc_html__( 'Background image', 'woodmart' ),
				'type'     => 'upload',
				'section'  => 'image_settings',
				't_tab'    => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-phone',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
				],
				'priority' => 140,
				'class'    => 'xts-tab-field',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'           => 'bg_image_size_mobile',
				'name'         => esc_html__( 'Background size', 'woodmart' ),
				'type'         => 'select',
				'empty_option' => true,
				'select2'      => true,
				'section'      => 'image_settings',
				'options'      => array(
					'cover'   => array(
						'name'  => esc_html__( 'Cover', 'woodmart' ),
						'value' => 'cover',
					),
					'contain' => array(
						'name'  => esc_html__( 'Contain', 'woodmart' ),
						'value' => 'contain',
					),
					'inherit' => array(
						'name'  => esc_html__( 'Inherit', 'woodmart' ),
						'value' => 'inherit',
					),
				),
				't_tab'        => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-phone',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
				],
				'priority'     => 150,
				'class'        => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'           => 'bg_image_position_mobile',
				'name'         => esc_html__( 'Background position', 'woodmart' ),
				'type'         => 'select',
				'empty_option' => true,
				'select2'      => true,
				'section'      => 'image_settings',
				'options'      => array(
					'left-top'      => array(
						'name'  => esc_html__( 'Left Top', 'woodmart' ),
						'value' => 'left top',
					),
					'left-center'   => array(
						'name'  => esc_html__( 'Left Center', 'woodmart' ),
						'value' => 'left center',
					),
					'left-bottom'   => array(
						'name'  => esc_html__( 'Left Bottom', 'woodmart' ),
						'value' => 'left bottom',
					),
					'center-top'    => array(
						'name'  => esc_html__( 'Center Top', 'woodmart' ),
						'value' => 'center top',
					),
					'center-center' => array(
						'name'  => esc_html__( 'Center Center', 'woodmart' ),
						'value' => 'center center',
					),
					'center-bottom' => array(
						'name'  => esc_html__( 'Center Bottom', 'woodmart' ),
						'value' => 'center bottom',
					),
					'right-top'     => array(
						'name'  => esc_html__( 'Right Top', 'woodmart' ),
						'value' => 'right top',
					),
					'right-center'  => array(
						'name'  => esc_html__( 'Right Center', 'woodmart' ),
						'value' => 'right center',
					),
					'right-bottom'  => array(
						'name'  => esc_html__( 'Right Bottom', 'woodmart' ),
						'value' => 'right bottom',
					),
					'custom'        => array(
						'name'  => esc_html__( 'Custom', 'woodmart' ),
						'value' => 'custom',
					),
				),
				't_tab'        => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-phone',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
				],
				'priority'     => 160,
				'class'        => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_position_x_mobile',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Position by X (px)', 'woodmart' ),
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'bg_image_position_mobile',
						'compare' => 'equals',
						'value'   => 'custom',
					),
				),
				't_tab'    => [
					'id'  => 'settings_tabs',
					'tab' => esc_html__( 'Mobile', 'woodmart' ),
				],
				'priority' => 170,
				'class'    => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'bg_image_position_y_mobile',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Position by Y (px)', 'woodmart' ),
				'section'  => 'image_settings',
				'requires' => array(
					array(
						'key'     => 'bg_image_position_mobile',
						'compare' => 'equals',
						'value'   => 'custom',
					),
				),
				't_tab'    => [
					'id'   => 'settings_tabs',
					'icon' => 'xts-i-phone',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
				],
				'priority' => 180,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		// General.
		$slide_metabox->add_field(
			array(
				'id'          => 'content_without_padding',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Content no space', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'content-without-padding.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'The content block will not have any paddings', 'woodmart' ),
				'section'     => 'slide_content',
				'priority'    => 10,
			)
		);

		$slide_metabox->add_field(
			array(
				'id'          => 'content_full_width',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Full width content', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'content-full-width.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Takes the slider\'s width', 'woodmart' ),
				'section'     => 'slide_content',
				'priority'    => 20,
			)
		);

		$slide_metabox->add_field(
			array(
				'id'          => 'content_width',
				'name'        => esc_html__( 'Content width', 'woodmart' ),
				'description' => esc_html__( 'Set your value in pixels.', 'woodmart' ),
				'type'        => 'range',
				'min'         => '100',
				'max'         => '1200',
				'step'        => '5',
				'default'     => '1200',
				'section'     => 'slide_content',
				'requires'    => array(
					array(
						'key'     => 'content_full_width',
						'compare' => 'not_equals',
						'value'   => 'on',
					),
				),
				't_tab'       => [
					'id'       => 'slide_content_width_tabs',
					'tab'      => esc_html__( 'Desktop', 'woodmart' ),
					'icon'     => 'xts-i-desktop',
					'style'    => 'devices',
					'requires' => array(
						array(
							'key'     => 'content_full_width',
							'compare' => 'not_equals',
							'value'   => 'on',
						),
					),
				],
				'priority'    => 30,
				'unit'        => 'px',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'          => 'content_width_tablet',
				'name'        => esc_html__( 'Content width', 'woodmart' ),
				'description' => esc_html__( 'Set your value in pixels.', 'woodmart' ),
				'type'        => 'range',
				'min'         => '100',
				'max'         => '1200',
				'step'        => '5',
				'default'     => '1200',
				'section'     => 'slide_content',
				'requires'    => array(
					array(
						'key'     => 'content_full_width',
						'compare' => 'not_equals',
						'value'   => 'on',
					),
				),
				't_tab'       => [
					'id'   => 'slide_content_width_tabs',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
					'icon' => 'xts-i-tablet',
				],
				'priority'    => 40,
				'unit'        => 'px',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'          => 'content_width_mobile',
				'name'        => esc_html__( 'Content width', 'woodmart' ),
				'description' => esc_html__( 'Set your value in pixels.', 'woodmart' ),
				'type'        => 'range',
				'min'         => '50',
				'max'         => '800',
				'step'        => '5',
				'default'     => '500',
				'section'     => 'slide_content',
				'requires'    => array(
					array(
						'key'     => 'content_full_width',
						'compare' => 'not_equals',
						'value'   => 'on',
					),
				),
				't_tab'       => [
					'id'   => 'slide_content_width_tabs',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
					'icon' => 'xts-i-phone',
				],
				'priority'    => 50,
				'unit'        => 'px',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'vertical_align',
				'name'     => esc_html__( 'Vertical content align', 'woodmart' ),
				'type'     => 'buttons',
				'default'  => 'middle',
				'section'  => 'slide_content',
				'options'  => array(
					'top'    => array(
						'name'  => esc_html__( 'Top', 'woodmart' ),
						'value' => 'top',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/top.jpg',
					),
					'middle' => array(
						'name'  => esc_html__( 'Middle', 'woodmart' ),
						'value' => 'middle',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/middle.jpg',
					),
					'bottom' => array(
						'name'  => esc_html__( 'Bottom', 'woodmart' ),
						'value' => 'bottom',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/bottom.jpg',
					),
				),
				't_tab'    => [
					'id'    => 'content_settings_tabs',
					'tab'   => esc_html__( 'Desktop', 'woodmart' ),
					'title' => esc_html__( 'Content position', 'woodmart' ),
					'icon'  => 'xts-i-desktop',
					'style' => 'default',
				],
				'priority' => 191,
				'class'    => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'horizontal_align',
				'name'     => esc_html__( 'Horizontal content align', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'slide_content',
				'options'  => array(
					'left'   => array(
						'name'  => esc_html__( 'Left', 'woodmart' ),
						'value' => 'left',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/left.jpg',
					),
					'center' => array(
						'name'  => esc_html__( 'Center', 'woodmart' ),
						'value' => 'center',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/center.jpg',
					),
					'right'  => array(
						'name'  => esc_html__( 'Right', 'woodmart' ),
						'value' => 'right',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/right.jpg',
					),
				),
				't_tab'    => [
					'id'   => 'content_settings_tabs',
					'tab'  => esc_html__( 'Desktop', 'woodmart' ),
					'icon' => 'xts-i-desktop',
				],
				'default'  => 'left',
				'priority' => 192,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'vertical_align_tablet',
				'name'     => esc_html__( 'Vertical content align', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'slide_content',
				'options'  => array(
					'top'    => array(
						'name'  => esc_html__( 'Top', 'woodmart' ),
						'value' => 'top',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/top.jpg',
					),
					'middle' => array(
						'name'  => esc_html__( 'Middle', 'woodmart' ),
						'value' => 'middle',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/middle.jpg',
					),
					'bottom' => array(
						'name'  => esc_html__( 'Bottom', 'woodmart' ),
						'value' => 'bottom',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/bottom.jpg',
					),
				),
				't_tab'    => [
					'id'   => 'content_settings_tabs',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
					'icon' => 'xts-i-tablet',
				],
				'priority' => 193,
				'class'    => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'horizontal_align_tablet',
				'name'     => esc_html__( 'Horizontal content align', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'slide_content',
				'options'  => array(
					'left'   => array(
						'name'  => esc_html__( 'Left', 'woodmart' ),
						'value' => 'left',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/left.jpg',
					),
					'center' => array(
						'name'  => esc_html__( 'Center', 'woodmart' ),
						'value' => 'center',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/center.jpg',
					),
					'right'  => array(
						'name'  => esc_html__( 'Right', 'woodmart' ),
						'value' => 'right',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/right.jpg',
					),
				),
				't_tab'    => [
					'id'   => 'content_settings_tabs',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
					'icon' => 'xts-i-tablet',
				],
				'priority' => 194,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'vertical_align_mobile',
				'name'     => esc_html__( 'Vertical content align', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'slide_content',
				'options'  => array(
					'top'    => array(
						'name'  => esc_html__( 'Top', 'woodmart' ),
						'value' => 'top',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/top.jpg',
					),
					'middle' => array(
						'name'  => esc_html__( 'Middle', 'woodmart' ),
						'value' => 'middle',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/middle.jpg',
					),
					'bottom' => array(
						'name'  => esc_html__( 'Bottom', 'woodmart' ),
						'value' => 'bottom',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/bottom.jpg',
					),
				),
				't_tab'    => [
					'id'   => 'content_settings_tabs',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
					'icon' => 'xts-i-phone',
				],
				'priority' => 195,
				'class'    => 'xts-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'horizontal_align_mobile',
				'name'     => esc_html__( 'Horizontal content align', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'slide_content',
				'options'  => array(
					'left'   => array(
						'name'  => esc_html__( 'Left', 'woodmart' ),
						'value' => 'left',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/left.jpg',
					),
					'center' => array(
						'name'  => esc_html__( 'Center', 'woodmart' ),
						'value' => 'center',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/center.jpg',
					),
					'right'  => array(
						'name'  => esc_html__( 'Right', 'woodmart' ),
						'value' => 'right',
						'image' => WOODMART_ASSETS_IMAGES . '/settings/cmb2-align/right.jpg',
					),
				),
				't_tab'    => [
					'id'   => 'content_settings_tabs',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
					'icon' => 'xts-i-phone',
				],
				'priority' => 196,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'          => 'slide_animation',
				'name'        => esc_html__( 'Animation', 'woodmart' ),
				'description' => esc_html__( 'Select a content appearance animation', 'woodmart' ),
				'type'        => 'select',
				'section'     => 'slide_link',
				'group'       => esc_html__( 'Animation', 'woodmart' ),
				'options'     => array(
					'none'              => array(
						'name'  => esc_html__( 'None', 'woodmart' ),
						'value' => 'none',
					),
					'slide-from-top'    => array(
						'name'  => esc_html__( 'Slide from top', 'woodmart' ),
						'value' => 'slide-from-top',
					),
					'slide-from-bottom' => array(
						'name'  => esc_html__( 'Slide from bottom', 'woodmart' ),
						'value' => 'slide-from-bottom',
					),
					'slide-from-right'  => array(
						'name'  => esc_html__( 'Slide from right', 'woodmart' ),
						'value' => 'slide-from-right',
					),
					'slide-from-left'   => array(
						'name'  => esc_html__( 'Slide from left', 'woodmart' ),
						'value' => 'slide-from-left',
					),
					'top-flip-x'        => array(
						'name'  => esc_html__( 'Top flip X', 'woodmart' ),
						'value' => 'top-flip-x',
					),
					'bottom-flip-x'     => array(
						'name'  => esc_html__( 'Bottom flip X', 'woodmart' ),
						'value' => 'bottom-flip-x',
					),
					'right-flip-y'      => array(
						'name'  => esc_html__( 'Right flip Y', 'woodmart' ),
						'value' => 'right-flip-y',
					),
					'left-flip-y'       => array(
						'name'  => esc_html__( 'Left flip Y', 'woodmart' ),
						'value' => 'left-flip-y',
					),
					'zoom-in'           => array(
						'name'  => esc_html__( 'Zoom in', 'woodmart' ),
						'value' => 'zoom-in',
					),
				),
				'is_animation' => true,
				'priority'     => 230,
			)
		);

		$slide_metabox->add_field(
			array(
				'id'          => 'link',
				'type'        => 'text_input',
				'name'        => esc_html__( 'Link', 'woodmart' ),
				'description' => esc_html__( 'Add URL to make whole slide clickable', 'woodmart' ),
				'section'     => 'slide_link',
				'group'       => esc_html__( 'Slide link', 'woodmart' ),
				'attributes'  => array(
					'type' => 'url',
				),
				'priority'    => 240,
				'class'       => 'xts-col-6',
			)
		);

		$slide_metabox->add_field(
			array(
				'id'       => 'link_target_blank',
				'type'     => 'checkbox',
				'name'     => esc_html__( 'Open link in new tab', 'woodmart' ),
				'section'  => 'slide_link',
				'group'    => esc_html__( 'Slide link', 'woodmart' ),
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority' => 250,
				'class'    => 'xts-col-6',
			)
		);
	}

	add_action( 'init', 'woodmart_register_slider_metaboxes', 100 );
}

$slider_metabox = Metaboxes::add_metabox(
	array(
		'id'         => 'xts_slider_metaboxes',
		'title'      => esc_html__( 'Slide Settings', 'woodmart' ),
		'object'     => 'term',
		'taxonomies' => array( 'woodmart_slider' ),
	)
);

$slider_metabox->add_section(
	array(
		'id'       => 'slide_content',
		'name'     => esc_html__( 'Slide content', 'woodmart' ),
		'icon'     => 'xts-i-footer',
		'priority' => 10,
	)
);

$slider_metabox->add_field(
	array(
		'id'       => 'animation',
		'name'     => esc_html__( 'Slide change animation', 'woodmart' ),
		'type'     => 'buttons',
		'group'    => esc_html__( 'Layout', 'woodmart' ),
		'section'  => 'slide_content',
		'default'  => 'slide',
		'options'  => array(
			'slide'      => array(
				'name'  => esc_html__( 'Slide', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'slide-change-animation-slide.mp4" autoplay loop muted></video>',
				'value' => 'slide',
			),
			'fade'       => array(
				'name'  => esc_html__( 'Fade', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'slide-change-animation-fade.mp4" autoplay loop muted></video>',
				'value' => 'fade',
			),
			'parallax'   => array(
				'name'  => esc_html__( 'Parallax', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'slide-change-animation-parallax.mp4" autoplay loop muted></video>',
				'value' => 'parallax',
			),
			'distortion' => array(
				'name'  => esc_html__( 'Distortion', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'slide-change-animation-distortion.mp4" autoplay loop muted></video>',
				'value' => 'distortion',
			),
		),
		'priority' => 8,
	)
);

$slider_metabox->add_field(
	array(
		'id'          => 'stretch_slider',
		'name'        => esc_html__( 'Stretch slider', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'stretch-slider.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Make slider full width', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'checkbox',
		'section'     => 'slide_content',
		'class'       => 'xts-col-6',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 10,
	)
);

$slider_metabox->add_field(
	array(
		'id'          => 'stretch_content',
		'name'        => esc_html__( 'Full width content', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'slider-full-with-content.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Make content full width', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'checkbox',
		'section'     => 'slide_content',
		'requires'    => array(
			array(
				'key'     => 'stretch_slider',
				'compare' => 'equals',
				'value'   => 'on',
			),
		),
		'class'       => 'xts-col-6',
		'priority'    => 11,
	)
);

$slider_metabox->add_field(
	array(
		'id'          => 'height',
		'name'        => esc_html__( 'Height on desktop', 'woodmart' ),
		'description' => esc_html__( 'Set your value in pixels.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'range',
		'min'         => '100',
		'max'         => '1200',
		'step'        => '5',
		'default'     => '500',
		'section'     => 'slide_content',
		't_tab'       => [
			'id'    => 'slider_height_settings_tabs',
			'tab'   => esc_html__( 'Desktop', 'woodmart' ),
			'icon'  => 'xts-i-desktop',
			'style' => 'devices',
		],
		'priority'    => 20,
		'unit'        => 'px',
	)
);

$slider_metabox->add_field(
	array(
		'id'          => 'height_tablet',
		'name'        => esc_html__( 'Height on tablet', 'woodmart' ),
		'description' => esc_html__( 'Set your value in pixels.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'range',
		'min'         => '100',
		'max'         => '1200',
		'step'        => '5',
		'default'     => '500',
		'section'     => 'slide_content',
		't_tab'       => [
			'id'   => 'slider_height_settings_tabs',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
			'icon' => 'xts-i-tablet',
		],
		'priority'    => 30,
		'unit'        => 'px',
	)
);

$slider_metabox->add_field(
	array(
		'id'          => 'height_mobile',
		'name'        => esc_html__( 'Height on mobile', 'woodmart' ),
		'description' => esc_html__( 'Set your value in pixels.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'range',
		'min'         => '100',
		'max'         => '1200',
		'step'        => '5',
		'default'     => '500',
		'section'     => 'slide_content',
		't_tab'       => [
			'id'   => 'slider_height_settings_tabs',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
			'icon' => 'xts-i-phone',
		],
		'priority'    => 40,
		'unit'        => 'px',
	)
);

$slider_metabox->add_field(
	array(
		'id'       => 'arrows_style',
		'name'     => esc_html__( 'Arrows style', 'woodmart' ),
		'group'    => esc_html__( 'Navigation', 'woodmart' ),
		'type'     => 'buttons',
		'default'  => '1',
		'section'  => 'slide_content',
		'options'  => array(
			'1' => array(
				'name'  => esc_html__( 'Style 1', 'woodmart' ),
				'value' => '1',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/arrow-style-1.jpg',
			),
			'2' => array(
				'name'  => esc_html__( 'Style 2', 'woodmart' ),
				'value' => '2',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/arrow-style-2.jpg',
			),
			'3' => array(
				'name'  => esc_html__( 'Style 3', 'woodmart' ),
				'value' => '3',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/arrow-style-3.jpg',
			),
			'0' => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'value' => '0',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/navigation-disable.jpg',
			),
		),
		'priority' => 45,
	)
);

$slider_metabox->add_field(
	array(
		'id'       => 'pagination_style',
		'name'     => esc_html__( 'Pagination style', 'woodmart' ),
		'group'    => esc_html__( 'Navigation', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'slide_content',
		'default'  => '1',
		'options'  => array(
			'1' => array(
				'name'  => esc_html__( 'Style 1', 'woodmart' ),
				'value' => '1',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-style-1.jpg',
			),
			'2' => array(
				'name'  => esc_html__( 'Style 2', 'woodmart' ),
				'value' => '2',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-style-2.jpg',
			),
			'3' => array(
				'name'  => esc_html__( 'Style 3', 'woodmart' ),
				'value' => '3',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-style-3.jpg',
			),
			'0' => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'value' => '0',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/navigation-disable.jpg',
			),
		),
		'priority' => 50,
	)
);

	$slider_metabox->add_field(
		array(
			'id'       => 'pagination_horizon_align',
			'name'     => esc_html__( 'Pagination horizontal alignment', 'woodmart' ),
			'group'    => esc_html__( 'Navigation', 'woodmart' ),
			'type'     => 'buttons',
			'section'  => 'slide_content',
			'default'  => 'center',
			'options'  => array(
				'left'   => array(
					'name'  => esc_html__( 'Left', 'woodmart' ),
					'value' => 'left',
					'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-horizontal-alignment-left.jpg',
				),
				'center' => array(
					'name'  => esc_html__( 'Center', 'woodmart' ),
					'value' => 'center',
					'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-horizontal-alignment-center.jpg',
				),
				'right'  => array(
					'name'  => esc_html__( 'Right', 'woodmart' ),
					'value' => 'right',
					'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-horizontal-alignment-right.jpg',
				),
			),
			'priority' => 50,
		)
	);

$slider_metabox->add_field(
	array(
		'id'       => 'pagination_color',
		'name'     => esc_html__( 'Navigation color scheme', 'woodmart' ),
		'group'    => esc_html__( 'Navigation', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'slide_content',
		'default'  => '1',
		'options'  => array(
			'light' => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-color-light.jpg',
			),
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/slider-navigation/pagination-color-dark.jpg',
			),
		),
		'priority' => 55,
	)
);

$slider_metabox->add_field(
	array(
		'id'          => 'autoplay',
		'name'        => esc_html__( 'Enable autoplay', 'woodmart' ),
		'description' => esc_html__( 'Rotate slider images automatically.', 'woodmart' ),
		'group'       => esc_html__( 'Settings', 'woodmart' ),
		'type'        => 'checkbox',
		'section'     => 'slide_content',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 60,
	)
);

$slider_metabox->add_field(
	array(
		'id'       => 'autoplay_speed',
		'name'     => esc_html__( 'Autoplay speed', 'woodmart' ),
		'group'    => esc_html__( 'Settings', 'woodmart' ),
		'type'     => 'range',
		'min'      => '1000',
		'max'      => '30000',
		'step'     => '100',
		'default'  => '9000',
		'section'  => 'slide_content',
		'priority' => 61,
		'unit'     => 'ms',
		'requires' => array(
			array(
				'key'     => 'autoplay',
				'compare' => 'equals',
				'value'   => 'on',
			),
		),
	)
);

$slider_metabox->add_field(
	array(
		'id'          => 'scroll_carousel_init',
		'name'        => esc_html__( 'Init carousel on scroll', 'woodmart' ),
		'description' => esc_html__( 'This option allows you to init carousel script only when visitor scroll the page to the slider. Useful for performance optimization.', 'woodmart' ),
		'group'       => esc_html__( 'Settings', 'woodmart' ),
		'type'        => 'checkbox',
		'section'     => 'slide_content',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 70,
	)
);


