<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Options;

Options::add_field(
	array(
		'id'          => 'rounding_size',
		'name'        => esc_html__( 'Rounding', 'woodmart' ),
		'description' => esc_html__( 'Change global site elements rounding. It also can be overwritten in each individual element by the same option.', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'custom-border-radius.mp4" autoplay loop muted></video>',
		'type'        => 'buttons',
		'section'     => 'styles_section',
		'options'     => array(
			'none'   => array(
				'name'  => esc_html__( '0', 'woodmart' ),
				'value' => 'none',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/rounding-1.jpg',
			),
			'5'      => array(
				'name'  => esc_html__( '5', 'woodmart' ),
				'value' => '5',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/rounding-2.jpg',
			),
			'8'      => array(
				'name'  => esc_html__( '8', 'woodmart' ),
				'value' => '8',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/rounding-3.jpg',
			),
			'12'     => array(
				'name'  => esc_html__( '12', 'woodmart' ),
				'value' => '12',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/rounding-4.jpg',
			),
			'custom' => array(
				'name'  => esc_html__( 'Custom', 'woodmart' ),
				'value' => 'custom',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/rounding-5.jpg',
			),
		),
		'default'     => 'none',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'        => 'custom_rounding_size',
		'name'      => esc_html__( 'Custom rounding', 'woodmart' ),
		'type'      => 'responsive_range',
		'section'   => 'styles_section',
		'selectors' => array(
			':root' => array(
				'--wd-brd-radius: {{VALUE}}{{UNIT}};',
			),
		),
		'devices'   => array(
			'desktop' => array(
				'value' => '',
				'unit'  => 'px',
			),
		),
		'range'     => array(
			'px' => array(
				'min'  => 0,
				'max'  => 300,
				'step' => 1,
			),
		),
		'requires'  => array(
			array(
				'key'     => 'rounding_size',
				'compare' => 'equals',
				'value'   => 'custom',
			),
		),
		'priority'  => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'dark_version',
		'name'        => esc_html__( 'Dark theme', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'styles-and-colors-dark-theme.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Turn your global website colors to a dark scheme.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'styles_section',
		'default'     => false,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'           => 'primary-color',
		'name'         => esc_html__( 'Primary color', 'woodmart' ),
		'description'  => esc_html__( 'Pick a background color for the theme buttons and other colored elements.', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'colors_section',
		'selector_var' => '--wd-primary-color',
		'default'      => array( 'idle' => '#83b735' ),
		'priority'     => 10,
	)
);

Options::add_field(
	array(
		'id'           => 'secondary-color',
		'name'         => esc_html__( 'Secondary color', 'woodmart' ),
		'description'  => esc_html__( 'Color for page builder elements options where "Secondary color" was chosen.', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'colors_section',
		'selector_var' => '--wd-alternative-color',
		'default'      => array( 'idle' => '#fbbc34' ),
		'priority'     => 20,
	)
);

Options::add_field(
	array(
		'id'                 => 'link-color',
		'name'               => esc_html__( 'Links color', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'links-color.mp4" autoplay loop muted></video>',
		'description'        => esc_html__( 'Set the color for links on your pages, posts and products content.', 'woodmart' ),
		'type'               => 'color',
		'section'            => 'colors_section',
		'selector_var'       => '--wd-link-color',
		'selector_hover_var' => '--wd-link-color-hover',
		'default'            => array(
			'idle'  => '#333333',
			'hover' => '#242424',
		),
		'priority'           => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'android_browser_bar_color',
		'name'        => esc_html__( 'Android browser bar color', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'android-browser-bar-color.jpg" alt="">', 'woodmart' ), true ),
		'description' => wp_kses( __( 'Define color for the browser top bar on Android devices. <a href="https://developers.google.com/web/fundamentals/design-and-ux/browser-customization/#color_browser_elements" target="_blank">[Read more]</a>', 'woodmart' ), true ),
		'type'        => 'color',
		'section'     => 'colors_section',
		'default'     => array(),
		'priority'    => 40,
	)
);

/**
 * Pages background.
 */
Options::add_field(
	array(
		'id'          => 'body-background',
		'name'        => esc_html__( 'Body background', 'woodmart' ),
		'description' => esc_html__( 'Set background for site body. Only for "Boxed" layouts.', 'woodmart' ),
		'group'       => esc_html__( 'General', 'woodmart' ),
		'type'        => 'background',
		'default'     => array(),
		'section'     => 'pages_bg_section',
		'selector'    => 'body',
		'priority'    => 12,
		'requires'    => array(
			array(
				'key'     => 'site_width',
				'compare' => 'equals',
				'value'   => array( 'boxed', 'boxed-2' ),
			),
		),
		'class'       => 'xts-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'pages-background',
		'name'     => esc_html__( 'All pages background', 'woodmart' ),
		'group'    => esc_html__( 'General', 'woodmart' ),
		'type'     => 'background',
		'default'  => array(),
		'section'  => 'pages_bg_section',
		'selector' => '.page .main-page-wrapper',
		'priority' => 20,
		'class'    => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'shop-background',
		'name'     => esc_html__( 'Product archive background', 'woodmart' ),
		'group'    => esc_html__( 'Shop', 'woodmart' ),
		'type'     => 'background',
		'default'  => array(),
		'section'  => 'pages_bg_section',
		'selector' => '.woodmart-archive-shop .main-page-wrapper',
		'priority' => 30,
		'class'    => 'xts-tab-field',
	)
);

Options::add_field(
	array(
		'id'          => 'product-background',
		'name'        => esc_html__( 'Single product background', 'woodmart' ),
		'description' => esc_html__( 'Set background for all product pages. You can also specify different background for the particular product while editing it.', 'woodmart' ),
		'group'       => esc_html__( 'Shop', 'woodmart' ),
		'type'        => 'background',
		'default'     => array(),
		'section'     => 'pages_bg_section',
		'selector'    => '.single-product .main-page-wrapper',
		'priority'    => 40,
		'class'       => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'blog-background',
		'name'     => esc_html__( 'Blog archive background', 'woodmart' ),
		'group'    => esc_html__( 'Blog', 'woodmart' ),
		'type'     => 'background',
		'default'  => array(),
		'section'  => 'pages_bg_section',
		'selector' => '.woodmart-archive-blog .main-page-wrapper',
		'priority' => 50,
		'class'    => 'xts-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'blog-post-background',
		'name'     => esc_html__( 'Single post background', 'woodmart' ),
		'group'    => esc_html__( 'Blog', 'woodmart' ),
		'type'     => 'background',
		'default'  => array(),
		'section'  => 'pages_bg_section',
		'selector' => '.single-post .main-page-wrapper',
		'priority' => 60,
		'class'    => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'portfolio-background',
		'name'     => esc_html__( 'Portfolio archive background', 'woodmart' ),
		'group'    => esc_html__( 'Portfolio', 'woodmart' ),
		'type'     => 'background',
		'default'  => array(),
		'section'  => 'pages_bg_section',
		'selector' => '.woodmart-archive-portfolio .main-page-wrapper',
		'priority' => 70,
		'class'    => 'xts-tab-field',
	)
);

Options::add_field(
	array(
		'id'       => 'portfolio-project-background',
		'name'     => esc_html__( 'Single project background', 'woodmart' ),
		'group'    => esc_html__( 'Portfolio', 'woodmart' ),
		'type'     => 'background',
		'default'  => array(),
		'section'  => 'pages_bg_section',
		'selector' => '.single-portfolio .main-page-wrapper',
		'priority' => 80,
		'class'    => 'xts-tab-field xts-last-tab-field',
	)
);

/**
 * Buttons.
 */
Options::add_field(
	array(
		'id'          => 'btns_default_style',
		'name'        => esc_html__( 'Default buttons styles', 'woodmart' ),
		'description' => esc_html__( 'Almost all standard buttons through the site', 'woodmart' ),
		'group'       => esc_html__( 'Default buttons', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'buttons_section',
		'options'     => array(
			'flat'         => array(
				'name'  => esc_html__( 'Flat', 'woodmart' ),
				'value' => 'flat',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/flat.jpg',
			),
			'3d'           => array(
				'name'  => esc_html__( '3D', 'woodmart' ),
				'value' => '3d',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/3d.jpg',
			),
			'rounded'      => array(
				'name'  => esc_html__( 'Round', 'woodmart' ),
				'value' => 'rounded',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/round.jpg',
			),
			'semi-rounded' => array(
				'name'  => esc_html__( 'Rounded', 'woodmart' ),
				'value' => 'semi-rounded',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/semi-rounded.jpg',
			),
		),
		'default'     => 'flat',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'             => 'btns_default_typography',
		'type'           => 'typography',
		'section'        => 'buttons_section',
		'group'          => esc_html__( 'Default buttons', 'woodmart' ),
		'name'           => 'Default buttons typography',
		'selector_var'   => array(
			'font-family'    => '--btn-default-font-family',
			'font-weight'    => '--btn-default-font-weight',
			'font-style'     => '--btn-default-font-style',
			'text-transform' => '--btn-default-transform',
		),
		'default'        => array(
			array(
				'font-family'    => '',
				'font-weight'    => '',
				'font-style'     => '',
				'text-transform' => '',
			),
		),
		'line-height'    => false,
		'font-size'      => false,
		'text-transform' => true,
		'color'          => false,
		'tags'           => 'typography',
		'class'          => 'xts-btn-typography',
		'priority'       => 20,
	)
);

Options::add_field(
	array(
		'id'           => 'btns_default_bg',
		'name'         => esc_html__( 'Default buttons background', 'woodmart' ),
		'group'        => esc_html__( 'Default buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-default-bgcolor',
		'default'      => array(
			'idle' => '#f7f7f7',
		),
		'priority'     => 30,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'           => 'btns_default_bg_hover',
		'name'         => esc_html__( 'Default buttons hover background', 'woodmart' ),
		'group'        => esc_html__( 'Default buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-default-bgcolor-hover',
		'default'      => array(
			'idle' => '#efefef',
		),
		'tags'         => 'buttons background button color buttons color',
		'priority'     => 40,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'btns_default_color_scheme',
		'name'     => esc_html__( 'Default buttons text color scheme', 'woodmart' ),
		'group'    => esc_html__( 'Default buttons', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'buttons_section',
		'options'  => array(
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
			'light' => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
			'custom' => array(
				'name'  => esc_html__( 'Custom', 'woodmart' ),
				'value' => 'custom',
			),
		),
		'default'  => 'dark',
		'priority' => 50,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'btns_default_color_scheme_hover',
		'name'     => esc_html__( 'Default buttons hover text color scheme', 'woodmart' ),
		'group'    => esc_html__( 'Default buttons', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'buttons_section',
		'options'  => array(
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
			'light' => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
			'custom' => array(
				'name'  => esc_html__( 'Custom', 'woodmart' ),
				'value' => 'custom',
			),
		),
		'default'  => 'dark',
		'priority' => 60,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'           => 'btns_default_color_scheme_custom',
		'name'         => esc_html__( 'Custom default buttons text color scheme', 'woodmart' ),
		'group'        => esc_html__( 'Default buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-default-color',
		'requires'     => array(
			array(
				'key'     => 'btns_default_color_scheme',
				'compare' => 'equals',
				'value'   => 'custom',
			),
		),
		'priority'     => 70,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'           => 'btns_default_color_scheme_hover_custom',
		'name'         => esc_html__( 'Custom default buttons hover text color scheme', 'woodmart' ),
		'group'        => esc_html__( 'Default buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-default-color-hover',
		'requires'     => array(
			array(
				'key'     => 'btns_default_color_scheme_hover',
				'compare' => 'equals',
				'value'   => 'custom',
			),
		),
		'priority'     => 80,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'btns_shop_style',
		'name'        => esc_html__( 'Accent buttons styles', 'woodmart' ),
		'description' => esc_html__( '"Call to action" buttons', 'woodmart' ),
		'group'       => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'buttons_section',
		'options'     => array(
			'flat'         => array(
				'name'  => esc_html__( 'Flat', 'woodmart' ),
				'value' => 'flat',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/flat.jpg',
			),
			'3d'           => array(
				'name'  => esc_html__( '3D', 'woodmart' ),
				'value' => '3d',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/3d.jpg',
			),
			'rounded'      => array(
				'name'  => esc_html__( 'Round', 'woodmart' ),
				'value' => 'rounded',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/round.jpg',
			),
			'semi-rounded' => array(
				'name'  => esc_html__( 'Rounded', 'woodmart' ),
				'value' => 'semi-rounded',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/buttons/semi-rounded.jpg',
			),
		),
		'default'     => '3d',
		'priority'    => 170,
	)
);

Options::add_field(
	array(
		'id'             => 'btns_shop_typography',
		'group'          => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'           => 'typography',
		'section'        => 'buttons_section',
		'name'           => 'Accent buttons typography',
		'selector_var'   => array(
			'font-family'    => '--btn-accented-font-family',
			'font-weight'    => '--btn-accented-font-weight',
			'font-style'     => '--btn-accented-font-style',
			'text-transform' => '--btn-accented-transform',
		),
		'default'        => array(
			array(
				'font-family'    => '',
				'font-weight'    => '',
				'font-style'     => '',
				'text-transform' => '',
			),
		),
		'line-height'    => false,
		'font-size'      => false,
		'text-transform' => true,
		'color'          => false,
		'tags'           => 'typography',
		'class'          => 'xts-btn-typography',
		'priority'       => 180,
	)
);

Options::add_field(
	array(
		'id'           => 'btns_shop_bg',
		'name'         => esc_html__( 'Accent buttons background', 'woodmart' ),
		'group'        => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-accented-bgcolor',
		'default'      => array(
			'idle' => '#83b735',
		),
		'priority'     => 190,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'           => 'btns_shop_bg_hover',
		'name'         => esc_html__( 'Accent buttons hover background', 'woodmart' ),
		'group'        => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-accented-bgcolor-hover',
		'default'      => array(
			'idle' => '#74a32f',
		),
		'priority'     => 200,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'btns_shop_color_scheme',
		'name'     => esc_html__( 'Accent buttons text color scheme', 'woodmart' ),
		'group'    => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'buttons_section',
		'options'  => array(
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
			'light' => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
			'custom' => array(
				'name'  => esc_html__( 'Custom', 'woodmart' ),
				'value' => 'custom',
			),
		),
		'default'  => 'light',
		'priority' => 210,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'btns_shop_color_scheme_hover',
		'name'     => esc_html__( 'Accent hover buttons text color scheme', 'woodmart' ),
		'group'    => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'buttons_section',
		'options'  => array(
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
			'light' => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
			'custom' => array(
				'name'  => esc_html__( 'Custom', 'woodmart' ),
				'value' => 'custom',
			),
		),
		'default'  => 'light',
		'priority' => 220,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'           => 'btns_shop_color_scheme_custom',
		'name'         => esc_html__( 'Custom shop buttons text color scheme', 'woodmart' ),
		'group'        => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-accented-color',
		'requires'     => array(
			array(
				'key'     => 'btns_shop_color_scheme',
				'compare' => 'equals',
				'value'   => 'custom',
			),
		),
		'priority'     => 230,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'           => 'btns_shop_color_scheme_hover_custom',
		'name'         => esc_html__( 'Custom shop buttons hover text color scheme', 'woodmart' ),
		'group'        => esc_html__( 'Accent buttons', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'buttons_section',
		'selector_var' => '--btn-accented-color-hover',
		'requires'     => array(
			array(
				'key'     => 'btns_shop_color_scheme_hover',
				'compare' => 'equals',
				'value'   => 'custom',
			),
		),
		'priority'     => 240,
		'class'        => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'               => 'advanced_typography_button',
		'type'             => 'typography',
		'section'          => 'buttons_section',
		'name'             => esc_html__( 'Advanced button styles', 'woodmart' ),
		'selectors'        => '',
		'callback'         => 'woodmart_get_theme_settings_buttons_selectors_array',
		'default'          => array(
			array(
				'font-family'    => '',
				'font-weight'    => '',
				'font-style'     => '',
				'font-size'      => '',
				'line-height'    => '',
				'color'          => '',
				'background'     => '',
				'hover'          => array(
					'color'      => '',
					'background' => '',
				),
				'text-transform' => '',
			)
		),
		'color-hover'      => true,
		'line-height'      => false,
		'text-transform'   => true,
		'background'       => true,
		'background-hover' => true,
		'priority'         => 250,
	)
);


/**
 * Forms.
 */
Options::add_field(
	array(
		'id'          => 'form_fields_style',
		'name'        => esc_html__( 'Form fields style', 'woodmart' ),
		'description' => esc_html__( 'Choose your form style', 'woodmart' ),
		'group'       => esc_html__( 'Style', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'forms_section',
		'options'     => array(
			'rounded'      => array(
				'name'  => esc_html__( 'Round', 'woodmart' ),
				'value' => 'rounded',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/form-style/circle.jpg',
			),
			'semi-rounded' => array(
				'name'  => esc_html__( 'Rounded', 'woodmart' ),
				'value' => 'semi-rounded',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/form-style/semi-rounded.jpg',
			),
			'square'       => array(
				'name'  => esc_html__( 'Square', 'woodmart' ),
				'value' => 'square',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/form-style/square.jpg',
			),
			'underlined'   => array(
				'name'  => esc_html__( 'Underlined', 'woodmart' ),
				'value' => 'underlined',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/form-style/underlined.jpg',
			),
		),
		'default'     => 'square',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'form_border_width',
		'name'        => esc_html__( 'Form border width', 'woodmart' ),
		'description' => esc_html__( 'Choose your form border width', 'woodmart' ),
		'group'       => esc_html__( 'Style', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'forms_section',
		'options'     => array(
			0 => array(
				'name'  => 0,
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'form-border-width-0.jpg" alt="">', 'woodmart' ), true ),
				'value' => 0,
			),
			1 => array(
				'name'  => 1,
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'form-border-width-1.jpg" alt="">', 'woodmart' ), true ),
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'form-border-width-2.jpg" alt="">', 'woodmart' ), true ),
				'value' => 2,
			),
		),
		'default'     => 2,
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'form_color',
		'name'     => esc_html__( 'Form text color', 'woodmart' ),
		'group'    => esc_html__( 'Color', 'woodmart' ),
		'type'     => 'color',
		'section'  => 'forms_section',
		'class'    => 'xts-col-6',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'form_placeholder_color',
		'name'     => esc_html__( 'Form placeholder color', 'woodmart' ),
		'group'    => esc_html__( 'Color', 'woodmart' ),
		'type'     => 'color',
		'section'  => 'forms_section',
		'class'    => 'xts-col-6',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'form_brd_color',
		'name'     => esc_html__( 'Form border color', 'woodmart' ),
		'group'    => esc_html__( 'Color', 'woodmart' ),
		'type'     => 'color',
		'section'  => 'forms_section',
		'class'    => 'xts-col-6',
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'form_brd_color_focus',
		'name'     => esc_html__( 'Form border color focus', 'woodmart' ),
		'group'    => esc_html__( 'Color', 'woodmart' ),
		'type'     => 'color',
		'section'  => 'forms_section',
		'class'    => 'xts-col-6',
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'form_bg',
		'name'     => esc_html__( 'Form background color', 'woodmart' ),
		'group'    => esc_html__( 'Color', 'woodmart' ),
		'type'     => 'color',
		'section'  => 'forms_section',
		'class'    => 'xts-col-6',
		'priority' => 70,
	)
);

/**
 * Notices.
 */
Options::add_field(
	array(
		'id'           => 'success_notice_bg_color',
		'name'         => esc_html__( 'Success notice background color', 'woodmart' ),
		'hint'         => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'notices-success.jpg" alt="">', 'woodmart' ), true ),
		'group'        => esc_html__( 'Success', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'notices_section',
		'selector_var' => '--notices-success-bg',
		'default'      => array( 'idle' => '#459647' ),
		'priority'     => 10,
	)
);

Options::add_field(
	array(
		'id'           => 'success_notice_test_color',
		'name'         => esc_html__( 'Success notice text color', 'woodmart' ),
		'group'        => esc_html__( 'Success', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'notices_section',
		'selector_var' => '--notices-success-color',
		'default'      => array( 'idle' => '#fff' ),
		'priority'     => 20,
	)
);

Options::add_field(
	array(
		'id'           => 'warning_notice_bg_color',
		'name'         => esc_html__( 'Warning notice background color', 'woodmart' ),
		'hint'         => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'notices-warning.jpg" alt="">', 'woodmart' ), true ),
		'group'        => esc_html__( 'Warning', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'notices_section',
		'selector_var' => '--notices-warning-bg',
		'default'      => array( 'idle' => '#E0B252' ),
		'priority'     => 30,
	)
);

Options::add_field(
	array(
		'id'           => 'warning_notice_test_color',
		'name'         => esc_html__( 'Warning notice text color', 'woodmart' ),
		'group'        => esc_html__( 'Warning', 'woodmart' ),
		'type'         => 'color',
		'section'      => 'notices_section',
		'selector_var' => '--notices-warning-color',
		'default'      => array( 'idle' => '#fff' ),
		'priority'     => 40,
	)
);
