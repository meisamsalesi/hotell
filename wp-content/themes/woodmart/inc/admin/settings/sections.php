<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Options;

/**
 * General.
 */
Options::add_section(
	array(
		'id'       => 'general_parent_section',
		'name'     => esc_html__( 'General', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-home',
	)
);

Options::add_section(
	array(
		'id'       => 'general_layout_section',
		'parent'   => 'general_parent_section',
		'name'     => esc_html__( 'Layout', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-home',
	)
);

Options::add_section(
	array(
		'id'       => 'header_banner_section',
		'parent'   => 'general_parent_section',
		'name'     => esc_html__( 'Header banner', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-home',
	)
);

Options::add_section(
	array(
		'id'       => 'promo_popup_section',
		'parent'   => 'general_parent_section',
		'name'     => esc_html__( 'Promo popup', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-home',
	)
);

Options::add_section(
	array(
		'id'       => 'age_verify_section',
		'parent'   => 'general_parent_section',
		'name'     => esc_html__( 'Age verify popup', 'woodmart' ),
		'priority' => 40,
		'icon'     => 'xts-i-home',
	)
);

Options::add_section(
	array(
		'id'       => 'cookie_section',
		'parent'   => 'general_parent_section',
		'name'     => esc_html__( 'Cookie law info', 'woodmart' ),
		'priority' => 50,
		'icon'     => 'xts-i-home',
	)
);

Options::add_section(
	array(
		'id'       => 'general_navbar_section',
		'parent'   => 'general_parent_section',
		'name'     => esc_html__( 'Mobile bottom navbar', 'woodmart' ),
		'priority' => 60,
		'icon'     => 'xts-i-home',
	)
);

Options::add_section(
	array(
		'id'       => 'general_search',
		'parent'   => 'general_parent_section',
		'name'     => esc_html__( 'Search', 'woodmart' ),
		'priority' => 70,
		'icon'     => 'xts-i-home',
	)
);

/**
 * Page title.
 */
Options::add_section(
	array(
		'id'       => 'page_title_section',
		'name'     => esc_html__( 'Page title', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-page-title',
	)
);

/**
 * Footer.
 */
Options::add_section(
	array(
		'id'       => 'general_footer_section',
		'name'     => esc_html__( 'Footer', 'woodmart' ),
		'priority' => 40,
		'icon'     => 'xts-i-footer',
	)
);

Options::add_section(
	array(
		'id'       => 'footer_section',
		'parent'   => 'general_footer_section',
		'name'     => esc_html__( 'Footer', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-footer',
	)
);

Options::add_section(
	array(
		'id'       => 'copyrights_section',
		'parent'   => 'general_footer_section',
		'name'     => esc_html__( 'Copyrights', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-footer',
	)
);

Options::add_section(
	array(
		'id'       => 'prefooter_section',
		'parent'   => 'general_footer_section',
		'name'     => esc_html__( 'Prefooter', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-footer',
	)
);

/**
 * Typography.
 */
Options::add_section(
	array(
		'id'       => 'general_typography_section',
		'name'     => esc_html__( 'Typography', 'woodmart' ),
		'priority' => 50,
		'icon'     => 'xts-i-typography',
	)
);

Options::add_section(
	array(
		'id'       => 'typography_section',
		'parent'   => 'general_typography_section',
		'name'     => esc_html__( 'Basic', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-typography',
	)
);

Options::add_section(
	array(
		'id'       => 'advanced_typography_section',
		'parent'   => 'general_typography_section',
		'name'     => esc_html__( 'Advanced', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-typography',
	)
);

Options::add_section(
	array(
		'id'       => 'custom_fonts_section',
		'parent'   => 'general_typography_section',
		'name'     => esc_html__( 'Custom fonts', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-typography',
	)
);

Options::add_section(
	array(
		'id'       => 'icons_fonts_section',
		'parent'   => 'general_typography_section',
		'name'     => esc_html__( 'Icons fonts', 'woodmart' ),
		'priority' => 40,
		'icon'     => 'xts-i-typography',
	)
);

Options::add_section(
	array(
		'id'       => 'typekit_section',
		'parent'   => 'general_typography_section',
		'name'     => esc_html__( 'Adobe fonts', 'woodmart' ),
		'priority' => 50,
		'icon'     => 'xts-i-typography',
	)
);



/**
 * Styles and colors.
 */
Options::add_section(
	array(
		'id'       => 'general_styles_section',
		'name'     => esc_html__( 'Styles and colors', 'woodmart' ),
		'priority' => 60,
		'icon'     => 'xts-i-brush',
	)
);

Options::add_section(
	array(
		'id'       => 'styles_section',
		'parent'   => 'general_styles_section',
		'name'     => esc_html__( 'Styles', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-brush',
	)
);

Options::add_section(
	array(
		'id'       => 'colors_section',
		'parent'   => 'general_styles_section',
		'name'     => esc_html__( 'Colors', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-brush',
	)
);

Options::add_section(
	array(
		'id'       => 'pages_bg_section',
		'parent'   => 'general_styles_section',
		'name'     => esc_html__( 'Pages background', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-brush',
	)
);

Options::add_section(
	array(
		'id'       => 'buttons_section',
		'parent'   => 'general_styles_section',
		'name'     => esc_html__( 'Buttons', 'woodmart' ),
		'priority' => 40,
		'icon'     => 'xts-i-brush',
	)
);

Options::add_section(
	array(
		'id'       => 'forms_section',
		'parent'   => 'general_styles_section',
		'name'     => esc_html__( 'Forms', 'woodmart' ),
		'priority' => 50,
		'icon'     => 'xts-i-brush',
	)
);

Options::add_section(
	array(
		'id'       => 'notices_section',
		'parent'   => 'general_styles_section',
		'name'     => esc_html__( 'Notices', 'woodmart' ),
		'priority' => 60,
		'icon'     => 'xts-i-brush',
	)
);

/**
 * Blog.
 */
Options::add_section(
	array(
		'id'       => 'general_blog_section',
		'name'     => esc_html__( 'Blog', 'woodmart' ),
		'priority' => 70,
		'icon'     => 'xts-i-book-edit',
	)
);

Options::add_section(
	array(
		'id'       => 'blog_section',
		'name'     => esc_html__( 'Blog', 'woodmart' ),
		'parent'   => 'general_blog_section',
		'priority' => 10,
		'icon'     => 'xts-i-book-edit',
	)
);

Options::add_section(
	array(
		'id'       => 'blog_archive_section',
		'name'     => esc_html__( 'Blog archive', 'woodmart' ),
		'parent'   => 'general_blog_section',
		'priority' => 20,
		'icon'     => 'xts-i-book-edit',
	)
);

Options::add_section(
	array(
		'id'       => 'blog_singe_post_section',
		'name'     => esc_html__( 'Single post', 'woodmart' ),
		'parent'   => 'general_blog_section',
		'priority' => 30,
		'icon'     => 'xts-i-book-edit',
	)
);

/**
 * Portfolio.
 */
Options::add_section(
	array(
		'id'       => 'general_portfolio_section',
		'name'     => esc_html__( 'Portfolio', 'woodmart' ),
		'priority' => 80,
		'icon'     => 'xts-i-portfolio',
	)
);

Options::add_section(
	array(
		'id'       => 'portfolio_section',
		'name'     => esc_html__( 'Portfolio', 'woodmart' ),
		'parent'   => 'general_portfolio_section',
		'priority' => 10,
		'icon'     => 'xts-i-portfolio',
	)
);

Options::add_section(
	array(
		'id'       => 'portfolio_archive_section',
		'name'     => esc_html__( 'Portfolio archive', 'woodmart' ),
		'parent'   => 'general_portfolio_section',
		'priority' => 20,
		'icon'     => 'xts-i-portfolio',
	)
);

Options::add_section(
	array(
		'id'       => 'portfolio_singe_project_section',
		'name'     => esc_html__( 'Single project', 'woodmart' ),
		'parent'   => 'general_portfolio_section',
		'priority' => 30,
		'icon'     => 'xts-i-portfolio',
	)
);

/**
 * Shop.
 */
Options::add_section(
	array(
		'id'       => 'general_shop_section',
		'name'     => esc_html__( 'Shop', 'woodmart' ),
		'priority' => 90,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'shop_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Shop', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'variable_products_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Variable products', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'product_labels_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Product labels', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'brands_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Brands', 'woodmart' ),
		'priority' => 40,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'quick_view_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Quick view', 'woodmart' ),
		'priority' => 50,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'compare_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Compare', 'woodmart' ),
		'priority' => 60,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'wishlist_section',
		'name'     => esc_html__( 'Wishlist', 'woodmart' ),
		'parent'   => 'general_shop_section',
		'priority' => 70,
		'icon'     => 'xts-i-cart',
	)
);

Options::add_section(
	array(
		'id'       => 'cart_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Cart', 'woodmart' ),
		'priority' => 75,
	)
);

Options::add_section(
	array(
		'id'       => 'checkout_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Checkout', 'woodmart' ),
		'priority' => 80,
	)
);

Options::add_section(
	array(
		'id'       => 'thank_you_page_section',
		'parent'   => 'general_shop_section',
		'name'     => esc_html__( 'Thank you page', 'woodmart' ),
		'priority' => 85,
		'icon'     => 'xts-i-cart',
	)
);

/**
 * Product archive.
 */
Options::add_section(
	array(
		'id'       => 'general_product_archive_section',
		'name'     => esc_html__( 'Product archive', 'woodmart' ),
		'priority' => 100,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'product_archive_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Product archive', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'products_grid_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Products grid', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'products_styles_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Products styles', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'categories_styles_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Categories styles', 'woodmart' ),
		'priority' => 40,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'shop_filters_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Shop filters', 'woodmart' ),
		'priority' => 50,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'widgets_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Widgets', 'woodmart' ),
		'priority' => 60,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'shop_page_title_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Page title', 'woodmart' ),
		'priority' => 70,
		'icon'     => 'xts-i-archive',
	)
);

Options::add_section(
	array(
		'id'       => 'shop_sidebar_section',
		'parent'   => 'general_product_archive_section',
		'name'     => esc_html__( 'Sidebar', 'woodmart' ),
		'priority' => 80,
		'icon'     => 'xts-i-archive',
	)
);

/**
 * Single product.
 */
Options::add_section(
	array(
		'id'       => 'general_single_product_section',
		'name'     => esc_html__( 'Single product', 'woodmart' ),
		'priority' => 110,
		'icon'     => 'xts-i-bag',
	)
);

Options::add_section(
	array(
		'id'       => 'single_product_section',
		'parent'   => 'general_single_product_section',
		'name'     => esc_html__( 'Single product', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-bag',
	)
);

Options::add_section(
	array(
		'id'       => 'product_images',
		'parent'   => 'general_single_product_section',
		'name'     => esc_html__( 'Images', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-bag',
	)
);

Options::add_section(
	array(
		'id'       => 'single_product_add_to_cart_section',
		'parent'   => 'general_single_product_section',
		'name'     => esc_html__( 'Add to cart', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-bag',
	)
);

Options::add_section(
	array(
		'id'       => 'product_elements',
		'parent'   => 'general_single_product_section',
		'name'     => esc_html__( 'Elements', 'woodmart' ),
		'priority' => 40,
		'icon'     => 'xts-i-bag',
	)
);

Options::add_section(
	array(
		'id'       => 'product_tabs',
		'parent'   => 'general_single_product_section',
		'name'     => esc_html__( 'Tabs', 'woodmart' ),
		'priority' => 60,
		'icon'     => 'xts-i-bag',
	)
);

Options::add_section(
	array(
		'id'       => 'single_product_related_section',
		'parent'   => 'general_single_product_section',
		'name'     => esc_html__( 'Related & Upsells', 'woodmart' ),
		'priority' => 70,
		'icon'     => 'xts-i-bag',
	)
);

/**
 * Login/register section.
 */
Options::add_section(
	array(
		'id'       => 'my_account',
		'name'     => esc_html__( 'My account', 'woodmart' ),
		'priority' => 115,
		'icon'     => 'xts-i-login',
	)
);

Options::add_section(
	array(
		'id'       => 'login_section',
		'parent'   => 'my_account',
		'name'     => esc_html__( 'Login / Register', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-login',
	)
);

Options::add_section(
	array(
		'id'       => 'dashboard_section',
		'parent'   => 'my_account',
		'name'     => esc_html__( 'Dashboard', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-login',
	)
);

/**
 * Share buttons configuration.
 */
Options::add_section(
	array(
		'id'       => 'general_social_profiles',
		'name'     => esc_html__( 'Social profiles', 'woodmart' ),
		'priority' => 130,
		'icon'     => 'xts-i-social',
	)
);

Options::add_section(
	array(
		'id'       => 'social_profiles',
		'parent'   => 'general_social_profiles',
		'name'     => esc_html__( 'Social profiles', 'woodmart' ),
		'priority' => 10,
		'icon'     => 'xts-i-social',
	)
);

Options::add_section(
	array(
		'id'       => 'social_links',
		'parent'   => 'general_social_profiles',
		'name'     => esc_html__( 'Links to social profiles', 'woodmart' ),
		'priority' => 20,
		'icon'     => 'xts-i-social',
	)
);

Options::add_section(
	array(
		'id'       => 'social_share',
		'parent'   => 'general_social_profiles',
		'name'     => esc_html__( 'Share buttons', 'woodmart' ),
		'priority' => 30,
		'icon'     => 'xts-i-social',
	)
);

/**
 * API integrations.
 */
Options::add_section(
	array(
		'id'       => 'api_integrations_section',
		'name'     => esc_html__( 'API integrations', 'woodmart' ),
		'priority' => 140,
		'icon'     => 'xts-i-cog',
	)
);

Options::add_section(
	array(
		'id'       => 'instagram_api_section',
		'name'     => esc_html__( 'Instagram API', 'woodmart' ),
		'parent'   => 'api_integrations_section',
		'priority' => 10,
		'icon'     => 'xts-i-cog',
	)
);

Options::add_section(
	array(
		'id'       => 'google_api_section',
		'name'     => esc_html__( 'Google map API', 'woodmart' ),
		'parent'   => 'api_integrations_section',
		'priority' => 20,
		'icon'     => 'xts-i-cog',
	)
);

Options::add_section(
	array(
		'id'       => 'social_login_api_section',
		'name'     => esc_html__( 'Social authentication', 'woodmart' ),
		'parent'   => 'api_integrations_section',
		'priority' => 30,
		'icon'     => 'xts-i-cog',
	)
);

/**
 * Performance.
 */
Options::add_section(
	array(
		'id'       => 'general_performance',
		'name'     => esc_html__( 'Performance', 'woodmart' ),
		'priority' => 150,
		'icon'     => 'xts-i-performance',
	)
);

Options::add_section(
	array(
		'id'       => 'performance_css',
		'name'     => esc_html__( 'CSS', 'woodmart' ),
		'parent'   => 'general_performance',
		'priority' => 10,
		'icon'     => 'xts-i-performance',
	)
);

Options::add_section(
	array(
		'id'       => 'performance_js',
		'name'     => esc_html__( 'JS', 'woodmart' ),
		'parent'   => 'general_performance',
		'priority' => 20,
		'icon'     => 'xts-i-performance',
	)
);

Options::add_section(
	array(
		'id'       => 'fonts_section',
		'name'     => esc_html__( 'Fonts & Icons', 'woodmart' ),
		'parent'   => 'general_performance',
		'priority' => 30,
		'icon'     => 'xts-i-performance',
	)
);

Options::add_section(
	array(
		'id'       => 'performance_lazy_loading',
		'name'     => esc_html__( 'Lazy loading', 'woodmart' ),
		'parent'   => 'general_performance',
		'priority' => 40,
		'icon'     => 'xts-i-performance',
	)
);

Options::add_section(
	array(
		'id'       => 'plugins_section',
		'name'     => esc_html__( 'Plugins', 'woodmart' ),
		'parent'   => 'general_performance',
		'priority' => 50,
		'icon'     => 'xts-i-performance',
	)
);

Options::add_section(
	array(
		'id'       => 'preloader_section',
		'name'     => esc_html__( 'Preloader', 'woodmart' ),
		'parent'   => 'general_performance',
		'priority' => 60,
		'icon'     => 'xts-i-performance',
	)
);

Options::add_section(
	array(
		'id'       => 'performance_other',
		'name'     => esc_html__( 'Other', 'woodmart' ),
		'parent'   => 'general_performance',
		'priority' => 70,
		'icon'     => 'xts-i-performance',
	)
);

/**
 * Maintenance.
 */
Options::add_section(
	array(
		'id'       => 'maintenance',
		'name'     => esc_html__( 'Maintenance', 'woodmart' ),
		'priority' => 160,
		'icon'     => 'xts-i-tools',
	)
);

/**
 * White label.
 */
Options::add_section(
	array(
		'id'       => 'white_label_section',
		'name'     => esc_html__( 'White label', 'woodmart' ),
		'priority' => 170,
		'icon'     => 'xts-i-tag',
	)
);

/**
 * Custom CSS section.
 */
Options::add_section(
	array(
		'id'       => 'custom_css',
		'name'     => esc_html__( 'Custom CSS', 'woodmart' ),
		'priority' => 180,
		'icon'     => 'xts-i-file-code-css',
	)
);

/**
 * Custom JS section.
 */
Options::add_section(
	array(
		'id'       => 'custom_js',
		'name'     => esc_html__( 'Custom JS', 'woodmart' ),
		'priority' => 190,
		'icon'     => 'xts-i-file-code-js',
	)
);

/**
 * Other.
 */
Options::add_section(
	array(
		'id'       => 'other_section',
		'name'     => esc_html__( 'Other', 'woodmart' ),
		'priority' => 200,
		'icon'     => 'xts-i-setting-slider-in-square',
	)
);

/**
 * Import / Export / Reset.
 */
Options::add_section(
	array(
		'id'       => 'import_export',
		'name'     => esc_html__( 'Import / Export / Reset', 'woodmart' ),
		'priority' => 220,
		'icon'     => 'xts-i-round-right',
	)
);
