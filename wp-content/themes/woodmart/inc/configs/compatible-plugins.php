<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Compatible plugins
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters(
	'woodmart_compatible_plugins',
	array(
		'leadin'        => array(
			'name'        => 'HubSpot',
			'slug'        => 'leadin',
			'description' => esc_html__( 'HubSpot is a platform with all the tools and integrations you need for marketing, sales, and customer service. Each product in the platform is powerful alone, but the real magic happens when you use them together. See the magic for yourself in the free HubSpot WordPress plugin.', 'woodmart' ),
			'buttons'     => array( woodmart_get_compatible_plugin_btn( 'leadin' ) ),
		),
		'wpml'          => array(
			'name'        => 'WPML',
			'description' => esc_html__( 'WPML is a plugin for WordPress. Simply put, plugins extend the functionality of the basic WordPress CMS. In our case, WPML makes WordPress run multilingual.', 'woodmart' ),
			'buttons'     => array(
				array(
					'name' => esc_html__( 'Documentation', 'woodmart' ),
					'url'  => 'https://wpml.org/documentation/',
				),
			),
		),
		'wp-rocket'     => array(
			'name'        => 'WP Rocket',
			'description' => esc_html__( 'WordPress experts recommend WP Rocket as the best WordPress caching plugin to achieve incredible speed result and optimize your website for the Core Web Vitals.', 'woodmart' ),
			'buttons'     => array(
				array(
					'name' => esc_html__( 'How to use', 'woodmart' ),
					'url'  => 'https://wp-rocket.me/features/',
				),
			),
		),
		'toolset'       => array(
			'name'        => 'Toolset',
			'description' => esc_html__( 'Toolset offers a fresh approach to building WordPress sites. It builds on of WordPress and provides a complete design and development package, that requires no programming.', 'woodmart' ),
			'buttons'     => array(
				array(
					'name'        => esc_html__( 'Read more', 'woodmart' ),
					'url'         => 'https://toolset.com/home/how-youll-build-sites-with-toolset/',
					'extra-class' => 'xts-update',
				),
				array(
					'name' => esc_html__( 'How to use', 'woodmart' ),
					'url'  => 'https://toolset.com/documentation/',
				),
			),
		),
		'dokan-lite'    => array(
			'name'        => 'Dokan',
			'slug'        => 'dokan-lite',
			'description' => esc_html__( 'The pioneer multi-vendor plugin for WordPress. Start your own marketplace in minutes!', 'woodmart' ),
			'buttons'     => array(
				array(
					'name' => esc_html__( 'Documentation', 'woodmart' ),
					'url'  => 'https://wedevs.com/docs/dokan',
				),
			),
		),
		'wordpress-seo' => array(
			'name'        => 'Yoast SEO',
			'slug'        => 'wordpress-seo',
			'description' => esc_html__( 'Improve your WordPress SEO: Write better content and have a fully optimized WordPress site using the Yoast SEO plugin.', 'woodmart' ),
			'buttons'     => array( woodmart_get_compatible_plugin_btn( 'wordpress-seo' ) ),
		),
		'woo-extra-product-options' => array(
			'name'        => 'Extra product options For WooCommerce',
			'slug'        => 'woo-extra-product-options',
			'description' => esc_html__( 'The WooCommerce Extra Product Options (WooCommerce Product Addons) plugin lets you add custom product fields(19 field types) and sections to your product page, making your WooCommerce product page more functional.', 'woodmart' ),
			'image'       => 'woo-extra-product-options.jpg',
			'buttons'     => array( woodmart_get_compatible_plugin_btn( 'woo-extra-product-options' ) ),
		),
	)
);
