<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options;

Options::add_field(
	array(
		'id'          => 'mobile_optimization',
		'name'        => esc_html__( 'Mobile DOM optimization (experimental)', 'woodmart' ),
		'description' => esc_html__( 'You can reduce the number of DOM elements on mobile devices. This option currently removes all HTML tags from the desktop header version on mobile devices.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_other',
		'default'     => false,
		'priority'    => 10,
	)
);

/**
 * CSS.
 */
Options::add_field(
	array(
		'id'          => 'disable_gutenberg_css',
		'name'        => esc_html__( 'Disable Gutenberg styles', 'woodmart' ),
		'description' => esc_html__( 'If you are not using Gutenberg elements you will not need these files to be loaded.', 'woodmart' ),
		'group'       => esc_html__( 'Gutenberg', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_css',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 40,
		'class'       => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'disable_gutenberg_backend_css',
		'name'        => esc_html__( 'Disable Gutenberg styles in editor', 'woodmart' ),
		'description' => esc_html__( 'Use this option if you are not want to see frontend styles in the Gutenberg editor', 'woodmart' ),
		'group'       => esc_html__( 'Gutenberg', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_css',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 50,
		'class'       => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'styles_always_use',
		'name'        => esc_html__( 'Styles always load', 'woodmart' ),
		'description' => esc_html__( 'You can manually load some styles on all pages.', 'woodmart' ),
		'group'       => esc_html__( 'Advanced', 'woodmart' ),
		'section'     => 'performance_css',
		'type'        => 'select',
		'multiple'    => true,
		'select2'     => true,
		'buttons'     => 'disable',
		'options'     => '',
		'callback'    => 'woodmart_get_theme_settings_css_files_array',
		'default'     => array(),
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'styles_not_use',
		'name'        => esc_html__( 'Styles never load', 'woodmart' ),
		'description' => esc_html__( 'You can manually unload some styles on all pages.', 'woodmart' ),
		'group'       => esc_html__( 'Advanced', 'woodmart' ),
		'section'     => 'performance_css',
		'type'        => 'select',
		'multiple'    => true,
		'select2'     => true,
		'buttons'     => 'disable',
		'options'     => '',
		'callback'    => 'woodmart_get_theme_settings_css_files_name_array',
		'default'     => array(),
		'priority'    => 70,
	)
);

/**
 * JS
 */
Options::add_field(
	array(
		'id'          => 'disable_owl_mobile_devices',
		'name'        => esc_html__( 'Disable OWL Carousel script on mobile devices', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'disable-owl-carousel.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Using native browser\'s scrolling feature on mobile devices may improve your page loading and performance on some devices. Desktop will be handled with OWL Carousel JS library.', 'woodmart' ),
		'group'       => esc_html__( 'General', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_js',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 40,
		'class'       => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'remove_jquery_migrate',
		'name'        => esc_html__( 'Remove jQuery Migrate', 'woodmart' ),
		'description' => esc_html__( 'Remove jQuery Migrate eliminates a JS file and can improve load time.', 'woodmart' ),
		'group'       => esc_html__( 'General', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_js',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 45,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'advanced_js_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'group'    => esc_html__( 'Advanced', 'woodmart' ),
		'content'  => wp_kses(
			__( 'Our theme is designed in the way to load only scripts and libraries that are required on a particular page. But if you need to load some particular script for some reason globally, you can use the following set of options.', 'woodmart' ),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
				'u'      => array(),
			)
		),
		'section'  => 'performance_js',
		'priority' => 49,
	)
);

Options::add_field(
	array(
		'id'          => 'advanced_js',
		'name'        => esc_html__( 'Advanced scripts controls', 'woodmart' ),
		'group'       => esc_html__( 'Advanced', 'woodmart' ),
		'description' => esc_html__( 'This option doesn\'t affect anything. It just shows/hides all scripts configuration. Note that we don\'t recommend you enable/disable any scripts if you are not sure how they work.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_js',
		'default'     => false,
		'priority'    => 50,
	)
);

$config_libraries = woodmart_get_config( 'js-libraries' );
foreach ( $config_libraries as $key => $libraries ) {
	foreach ( $libraries as $library ) {
		Options::add_field(
			array(
				'id'       => $library['name'] . '_library',
				'section'  => 'performance_js',
				'name'     => ucfirst( $library['title'] ) . ' library',
				'group'    => esc_html__( 'Advanced', 'woodmart' ),
				'type'     => 'buttons',
				'options'  => array(
					'always'   => array(
						'name'  => esc_html__( 'Always load', 'woodmart' ),
						'value' => 'always',
					),
					'required' => array(
						'name'  => esc_html__( 'On demand', 'woodmart' ),
						'value' => 'required',
					),
					'not_use'  => array(
						'name'  => esc_html__( 'Never load', 'woodmart' ),
						'value' => 'not_use',
					),
				),
				'requires' => array(
					array(
						'key'     => 'advanced_js',
						'compare' => 'equals',
						'value'   => true,
					),
				),
				'default'  => 'required',
				'priority' => 60,
				'class'    => 'xts-col-6',
			)
		);
	}
}

Options::add_field(
	array(
		'id'          => 'scripts_always_use',
		'name'        => esc_html__( 'Scripts always load', 'woodmart' ),
		'description' => esc_html__( 'You can manually load some initialization scripts on all pages.', 'woodmart' ),
		'group'       => esc_html__( 'Advanced', 'woodmart' ),
		'section'     => 'performance_js',
		'type'        => 'select',
		'multiple'    => true,
		'select2'     => true,
		'buttons'     => 'disable',
		'options'     => '',
		'callback'    => 'woodmart_get_theme_settings_js_scripts_files_array',
		'default'     => array(),
		'requires'    => array(
			array(
				'key'     => 'advanced_js',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'scripts_not_use',
		'name'        => esc_html__( 'Scripts never load', 'woodmart' ),
		'description' => esc_html__( 'You can manually unload some initialization scripts on all pages.', 'woodmart' ),
		'group'       => esc_html__( 'Advanced', 'woodmart' ),
		'section'     => 'performance_js',
		'type'        => 'select',
		'multiple'    => true,
		'select2'     => true,
		'buttons'     => 'disable',
		'options'     => '',
		'callback'    => 'woodmart_get_theme_settings_js_scripts_files_array',
		'default'     => array(),
		'requires'    => array(
			array(
				'key'     => 'advanced_js',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'dequeue_scripts',
		'type'        => 'text_input',
		'section'     => 'performance_js',
		'name'        => esc_html__( 'Dequeue scripts', 'woodmart' ),
		'description' => esc_html__( 'You can manually disable JS files from being loaded using their keys. Write their case separated with a comma. For example: woodmart-theme,elementor-frontend', 'woodmart' ),
		'group'       => esc_html__( 'Advanced', 'woodmart' ),
		'requires'    => array(
			array(
				'key'     => 'advanced_js',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'status'      => 'deprecated',
		'priority'    => 90,
	)
);

/**
 * Lazy loading
 */
Options::add_field(
	array(
		'id'          => 'lazy_loading',
		'name'        => esc_html__( 'Lazy loading for images', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'lazy-loading-for-images.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Enable this option to optimize your images loading on the website. They will be loaded only when user will scroll the page.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_lazy_loading',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'lazy_loading_offset',
		'name'        => esc_html__( 'Offset', 'woodmart' ),
		'description' => esc_html__( 'Start load images X pixels before the page is scrolled to the item', 'woodmart' ),
		'type'        => 'range',
		'section'     => 'performance_lazy_loading',
		'default'     => 0,
		'min'         => 0,
		'step'        => 10,
		'max'         => 1000,
		'priority'    => 20,
		'unit'        => 'px',
	)
);

Options::add_field(
	array(
		'id'          => 'lazy_effect',
		'name'        => esc_html__( 'Appearance effect', 'woodmart' ),
		'description' => esc_html__( 'When enabled, your images will be replaced with their blurred small previews. And when the visitor will scroll the page to that image, it will be replaced with an original image.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'performance_lazy_loading',
		'default'     => 'fade',
		'options'     => array(
			'fade' => array(
				'name'  => esc_html__( 'Fade', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'lazy-loading-appearance-effect-fade.mp4" autoplay loop muted></video>',
				'value' => 'fade',
			),
			'blur' => array(
				'name'  => esc_html__( 'Blur', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'lazy-loading-appearance-effect-blur.mp4" autoplay loop muted></video>',
				'value' => 'blur',
			),
			'none' => array(
				'name'  => esc_html__( 'None', 'woodmart' ),
				'value' => 'none',
			),
		),
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'lazy_generate_previews',
		'name'        => esc_html__( 'Generate previews', 'woodmart' ),
		'description' => esc_html__( 'Create placeholders previews as miniatures from the original images.', 'woodmart' ),
		'group'       => esc_html__( 'Placeholders', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_lazy_loading',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'lazy_base_64',
		'name'        => esc_html__( 'Base 64 encode for placeholders', 'woodmart' ),
		'description' => esc_html__( 'This option allows you to decrease a number of HTTP requests replacing images with base 64 encoded sources.', 'woodmart' ),
		'group'       => esc_html__( 'Placeholders', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_lazy_loading',
		'default'     => '1',
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'lazy_proprtion_size',
		'name'        => esc_html__( 'Proportional placeholders size', 'woodmart' ),
		'description' => esc_html__( 'Will generate proportional image size for the placeholder based on original image size.', 'woodmart' ),
		'group'       => esc_html__( 'Placeholders', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_lazy_loading',
		'default'     => '1',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'lazy_custom_placeholder',
		'name'        => esc_html__( 'Upload custom placeholder image', 'woodmart' ),
		'description' => esc_html__( 'Add your custom image placeholder that will be used before the original image will be loaded.', 'woodmart' ),
		'group'       => esc_html__( 'Placeholders', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'performance_lazy_loading',
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'disable_wordpress_lazy_loading',
		'name'        => esc_html__( 'Disable native WordPress lazy loading', 'woodmart' ),
		'description' => esc_html__( 'This option will remove attribute loading=“lazy” from all images on your website.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'performance_lazy_loading',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 80,
	)
);

/**
 * Plugins
 */
Options::add_field(
	array(
		'id'          => 'rocket_delay_js_exclusions',
		'name'        => esc_html__( 'WP Rocket delay JS exclusions', 'woodmart' ),
		'description' => esc_html__( 'Add a list of JS files that don’t need to be delayed to the exclusion list for WP Rocket. It contains JS files for elements like header, mobile menu, and other elements that usually need to be active right after opening the page.', 'woodmart' ),
		'group'       => esc_html__( 'WP Rocket', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'plugins_section',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'cf7_js',
		'name'        => esc_html__( 'Load "Contact form 7" JS files', 'woodmart' ),
		'description' => esc_html__( 'You can enable/disable this option globally. If you want to load them on the particular page only, you can create a special Theme Settings preset for this and add a condition for that page.', 'woodmart' ),
		'group'       => esc_html__( 'Contact form 7', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'plugins_section',
		'default'     => true,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 11,
	)
);

Options::add_field(
	array(
		'id'                 => 'load_elementor_optimized_css',
		'type'               => 'switcher',
		'section'            => 'plugins_section',
		'name'               => esc_html__( 'Load Elementor optimized CSS', 'woodmart' ),
		'description'        => esc_html__( 'Load only theme-required styles for Elementor. Don\'t use it if you are using most of the standard Elementor\'s widgets.', 'woodmart' ),
		'group'              => esc_html__( 'Elementor', 'woodmart' ),
		'default'            => '0',
		'priority'           => 20,
		'status'             => 'deprecated',
		'status_description' => esc_html__( 'Should be always DISABLED. You can now use Elementor’s plugin optimization settings instead.', 'woodmart' ),
	)
);

Options::add_field(
	array(
		'id'       => 'elementor_animations',
		'type'     => 'switcher',
		'section'  => 'plugins_section',
		'name'     => esc_html__( 'Load Elementor animations CSS file', 'woodmart' ),
		'group'    => esc_html__( 'Elementor', 'woodmart' ),
		'default'  => '1',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'       => 'elementor_icons',
		'type'     => 'switcher',
		'section'  => 'plugins_section',
		'name'     => esc_html__( 'Load Elementor icons CSS file', 'woodmart' ),
		'group'    => esc_html__( 'Elementor', 'woodmart' ),
		'woodmart',
		'default'  => '1',
		'priority' => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'elementor_dialog_library',
		'type'        => 'switcher',
		'section'     => 'plugins_section',
		'name'        => esc_html__( 'Elementor dialog.js library', 'woodmart' ),
		'description' => esc_html__( 'Turn it off if you never use it to improve the performance.', 'woodmart' ),
		'group'       => esc_html__( 'Elementor', 'woodmart' ),
		'default'     => true,
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'elementor_frontend',
		'type'        => 'switcher',
		'section'     => 'plugins_section',
		'name'        => esc_html__( 'Elementor frontend', 'woodmart' ),
		'description' => esc_html__( 'Disable Elementor\'s JS files if you are not using most of their widgets.', 'woodmart' ),
		'group'       => esc_html__( 'Elementor', 'woodmart' ),
		'default'     => '1',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'swiper_library',
		'section'  => 'plugins_section',
		'name'     => esc_html__( 'Swiper library', 'woodmart' ),
		'group'    => esc_html__( 'Elementor', 'woodmart' ),
		'type'     => 'buttons',
		'options'  => array(
			'always'   => array(
				'name'  => esc_html__( 'Always load', 'woodmart' ),
				'value' => 'always',
			),
			'required' => array(
				'name'  => esc_html__( 'On demand', 'woodmart' ),
				'value' => 'required',
			),
			'not_use'  => array(
				'name'  => esc_html__( 'Never load', 'woodmart' ),
				'value' => 'not_use',
			),
		),
		'requires' => array(
			array(
				'key'     => 'elementor_frontend',
				'compare' => 'equals',
				'value'   => '0',
			),
		),
		'default'  => 'always',
		'priority' => 70,
	)
);

Options::add_field(
	array(
		'id'       => 'el_waypoints_library',
		'section'  => 'plugins_section',
		'name'     => esc_html__( 'Waypoints library', 'woodmart' ),
		'group'    => esc_html__( 'Elementor', 'woodmart' ),
		'type'     => 'buttons',
		'options'  => array(
			'always'   => array(
				'name'  => esc_html__( 'Always load', 'woodmart' ),
				'value' => 'always',
			),
			'required' => array(
				'name'  => esc_html__( 'On demand', 'woodmart' ),
				'value' => 'required',
			),
			'not_use'  => array(
				'name'  => esc_html__( 'Never load', 'woodmart' ),
				'value' => 'not_use',
			),
		),
		'requires' => array(
			array(
				'key'     => 'elementor_frontend',
				'compare' => 'equals',
				'value'   => '0',
			),
		),
		'default'  => 'always',
		'priority' => 80,
	)
);

/**
 * Fonts
 */
Options::add_field(
	array(
		'id'          => 'google_font_display',
		'name'        => esc_html__( '"font-display" for text fonts', 'woodmart' ),
		'description' => wp_kses(
			__( 'You can specify "font-display" property for text fonts. Read more information <a href="https://developers.google.com/web/updates/2016/02/font-display">here</a>', 'woodmart' ),
			true
		),
		'type'        => 'select',
		'section'     => 'fonts_section',
		'default'     => 'disable',
		'options'     => array(
			'disable'  => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'value' => 'disable',
			),
			'block'    => array(
				'name'  => esc_html__( 'Block', 'woodmart' ),
				'value' => 'block',
			),
			'swap'     => array(
				'name'  => esc_html__( 'Swap', 'woodmart' ),
				'value' => 'swap',
			),
			'fallback' => array(
				'name'  => esc_html__( 'Fallback', 'woodmart' ),
				'value' => 'fallback',
			),
			'optional' => array(
				'name'  => esc_html__( 'Optional', 'woodmart' ),
				'value' => 'optional',
			),
		),
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'icons_font_display',
		'name'        => esc_html__( '"font-display" for icon fonts', 'woodmart' ),
		'description' => wp_kses(
			__( 'You can specify "font-display" property for fonts used for icons in our theme including Font Awesome. Read more information <a href="https://developers.google.com/web/updates/2016/02/font-display">here</a>', 'woodmart' ),
			true
		),
		'type'        => 'select',
		'section'     => 'fonts_section',
		'default'     => 'disable',
		'options'     => array(
			'disable'  => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'value' => 'disable',
			),
			'block'    => array(
				'name'  => esc_html__( 'Block', 'woodmart' ),
				'value' => 'block',
			),
			'swap'     => array(
				'name'  => esc_html__( 'Swap', 'woodmart' ),
				'value' => 'swap',
			),
			'fallback' => array(
				'name'  => esc_html__( 'Fallback', 'woodmart' ),
				'value' => 'fallback',
			),
		),
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'font_awesome_css',
		'name'        => esc_html__( 'Font Awesome library', 'woodmart' ),
		'description' => esc_html__( 'You can force Font Awesome 5 library to be loaded on all pages.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'fonts_section',
		'options'     => array(
			'always'  => array(
				'name'  => esc_html__( 'Always use', 'woodmart' ),
				'value' => 'always',
			),
			'not_use' => array(
				'name'  => esc_html__( 'Don\'t use', 'woodmart' ),
				'value' => 'not_use',
			),
		),
		'default'     => 'not_use',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'font_icon_woff2_preload',
		'name'        => esc_html__( 'Preload key request for "woodmart-font.woff2"', 'woodmart' ),
		'description' => esc_html__( 'Enable this option if you see this warning in Google Pagespeed report.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'fonts_section',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 50,
	)
);

/**
 * Preloader
 */
Options::add_field(
	array(
		'id'          => 'preloader',
		'name'        => esc_html__( 'Preloader', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'preloader.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Enable preloader animation while loading your website content. Useful when you move all the CSS to the footer.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'preloader_section',
		'default'     => false,
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'preloader_image',
		'name'        => esc_html__( 'Custom animated loader', 'woodmart' ),
		'description' => esc_html__( 'Upload a custom animated image that will replace the default theme preloader.', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'preloader_section',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'preloader_background_color',
		'name'     => esc_html__( 'Background for loader screen', 'woodmart' ),
		'group'    => esc_html__( 'Style', 'woodmart' ),
		'type'     => 'color',
		'default'  => array(
			'idle' => '#ffffff',
		),
		'section'  => 'preloader_section',
		'priority' => 30,
	)
);


Options::add_field(
	array(
		'id'       => 'preloader_color_scheme',
		'name'     => esc_html__( 'Preloader color scheme', 'woodmart' ),
		'group'    => esc_html__( 'Style', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'preloader_section',
		'default'  => 'dark',
		'options'  => array(
			'dark'  => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
			'light' => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
		),
		'priority' => 40,
	)
);