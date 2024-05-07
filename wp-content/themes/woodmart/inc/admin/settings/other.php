<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

Options::add_field(
	array(
		'id'          => 'negative_gap',
		'name'        => esc_html__( 'Elementor sections negative margin', 'woodmart' ),
		'description' => esc_html__( 'Add a negative margin to each Elementor section to align the content with your website container.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'other_section',
		'options'     => array(
			'enabled'  => array(
				'name'  => esc_html__( 'Enabled', 'woodmart' ),
				'value' => 'enabled',
			),
			'disabled' => array(
				'name'  => esc_html__( 'Disabled', 'woodmart' ),
				'value' => 'disabled',
			),
		),
		'default'     => 'enabled',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'                 => 'sticky_notifications',
		'name'               => esc_html__( 'Sticky notifications', 'woodmart' ),
		'type'               => 'switcher',
		'section'            => 'other_section',
		'default'            => '0',
		'priority'           => 20,
		'status'             => 'deprecated',
	)
);

Options::add_field(
	array(
		'id'       => 'page_comments',
		'name'     => esc_html__( 'Show comments on pages', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'other_section',
		'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'general-show-comments-on-pages.jpg" alt="">', 'woodmart' ), true ),
		'default'  => '1',
		'on-text'  => esc_html__( 'Yes', 'woodmart' ),
		'off-text' => esc_html__( 'No', 'woodmart' ),
		'priority' => 25,
	)
);

Options::add_field(
	array(
		'id'           => 'custom_404_page',
		'name'         => esc_html__( 'Custom 404 page', 'woodmart' ),
		'type'         => 'select',
		'description'  => esc_html__( 'Select a page that will be shown as your default 404 error page.', 'woodmart' ),
		'section'      => 'other_section',
		'options'      => '',
		'callback'     => 'woodmart_get_pages_array',
		'empty_option' => true,
		'select2'      => true,
		'priority'     => 28,
	)
);

Options::add_field(
	array(
		'id'          => 'widget_title_tag',
		'name'        => esc_html__( 'Widget title tag', 'woodmart' ),
		'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'widget-title-tag.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Choose which HTML tag to use in widget title.', 'woodmart' ),
		'type'        => 'select',
		'section'     => 'other_section',
		'default'     => 'h5',
		'options'     => array(
			'h1'   => array(
				'name'  => 'h1',
				'value' => 'h1',
			),
			'h2'   => array(
				'name'  => 'h2',
				'value' => 'h2',
			),
			'h3'   => array(
				'name'  => 'h3',
				'value' => 'h3',
			),
			'h4'   => array(
				'name'  => 'h4',
				'value' => 'h4',
			),
			'h5'   => array(
				'name'  => 'h5',
				'value' => 'h5',
			),
			'h6'   => array(
				'name'  => 'h6',
				'value' => 'h6',
			),
			'p'    => array(
				'name'  => 'p',
				'value' => 'p',
			),
			'div'  => array(
				'name'  => 'div',
				'value' => 'div',
			),
			'span' => array(
				'name'  => 'span',
				'value' => 'span',
			),
		),
		'priority'    => 29,
	)
);

Options::add_field(
	array(
		'id'          => 'woodmart_slider',
		'name'        => esc_html__( 'Enable custom slider', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'enable-custom-slider.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'If you enable this option, a new post type for sliders will be added to your Dashboard menu. You will be able to create sliders with page builder and place them on any page on your website.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'other_section',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'allow_upload_svg',
		'name'        => esc_html__( 'Allow SVG upload', 'woodmart' ),
		'description' => wp_kses(
			__( 'Allow SVG uploads as well as SVG format for custom fonts. We suggest you to use <a href="https://wordpress.org/plugins/safe-svg/">this plugin</a> to be sure that all uploaded content is safe. If you will install this plugin, you can disable this option.', 'woodmart' ),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
			)
		),
		'type'        => 'switcher',
		'section'     => 'other_section',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'rev_slider_inherit_theme_font',
		'name'     => esc_html__( 'Slider Revolution inherit theme font', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'other_section',
		'default'  => '0',
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'site_viewport',
		'name'        => esc_html__( 'Viewport tag', 'woodmart' ),
		'description' => esc_html__( 'Default viewport tag:', 'woodmart' ) .  ' <code>' . htmlspecialchars( '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">' ) . '</code>',
		'type'        => 'select',
		'section'     => 'other_section',
		'default'     => 'not_scalable',
		'options'     => array(
			'not_scalable' => array(
				'name'  => esc_html__( 'Not scalable', 'woodmart' ),
				'value' => 'not_scalable',
			),
			'scalable'   => array(
				'name'  => esc_html__( 'Scalable', 'woodmart' ),
				'value' => 'scalable',
			),
		),
		'priority'    => 70,
	)
);