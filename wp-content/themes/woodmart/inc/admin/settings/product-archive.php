<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Options;

Options::add_field(
	array(
		'id'          => 'ajax_shop',
		'name'        => esc_html__( 'AJAX shop', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'ajax-shop.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Enable AJAX functionality for filter widgets, categories navigation, and pagination on the shop page.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_archive_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'ajax_scroll',
		'name'        => esc_html__( 'Scroll to top after AJAX', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'scroll-to-top-after-ajax.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Disable - Enable scroll to top after AJAX.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_archive_section',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'shop_page_breadcrumbs',
		'name'     => esc_html__( 'Breadcrumbs on shop page', 'woodmart' ),
		'hint'     => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'breadcrumbs-on-shop-page.jpg" alt="">', 'woodmart' ), true ),
		'type'     => 'switcher',
		'section'  => 'product_archive_section',
		'default'  => '1',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'cat_desc_position',
		'name'        => esc_html__( 'Category description position', 'woodmart' ),
		'description' => esc_html__( 'You can change default products category description position and move it below the products.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'product_archive_section',
		'options'     => array(
			'before' => array(
				'name'  => esc_html__( 'Before product grid', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'category-description-position-before.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'before',
			),
			'after'  => array(
				'name'  => esc_html__( 'After product grid', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'category-description-position-affter.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'after',
			),
		),
		'default'     => 'before',
		'priority'    => 40,
	)
);

/**
 * Product styles.
 */
Options::add_field(
	array(
		'id'          => 'products_hover',
		'name'        => esc_html__( 'Hover on product', 'woodmart' ),
		'description' => esc_html__( 'Choose one of those hover effects for products', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_styles_section',
		'default'     => 'base',
		'options'     => array(
			'info-alt'  => array(
				'name'  => esc_html__( 'Full info on hover', 'woodmart' ),
				'value' => 'info-alt',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/info-alt.jpg',
			),
			'info'      => array(
				'name'  => esc_html__( 'Full info on image', 'woodmart' ),
				'value' => 'info',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/info.jpg',
			),
			'alt'       => array(
				'name'  => esc_html__( 'Icons and "add to cart" on hover', 'woodmart' ),
				'value' => 'alt',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/alt.jpg',
			),
			'icons'     => array(
				'name'  => esc_html__( 'Icons on hover', 'woodmart' ),
				'value' => 'icons',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/icons.jpg',
			),
			'quick'     => array(
				'name'  => esc_html__( 'Quick', 'woodmart' ),
				'value' => 'quick',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/quick.jpg',
			),
			'button'    => array(
				'name'  => esc_html__( 'Show button on hover on image', 'woodmart' ),
				'value' => 'button',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/button.jpg',
			),
			'base'      => array(
				'name'  => esc_html__( 'Show summary on hover', 'woodmart' ),
				'value' => 'base',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/base.jpg',
			),
			'standard'  => array(
				'name'  => esc_html__( 'Standard button', 'woodmart' ),
				'value' => 'standard',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/standard.jpg',
			),
			'tiled'     => array(
				'name'  => esc_html__( 'Tiled', 'woodmart' ),
				'value' => 'tiled',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/tiled.jpg',
			),
			'fw-button' => array(
				'name'  => esc_html__( 'Full width button', 'woodmart' ),
				'value' => 'fw-button',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/hover/fw-button.jpg',
			),
		),
		'priority'    => 10,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'base_hover_mobile_click',
		'name'        => esc_html__( 'Open product on click on mobile', 'woodmart' ),
		'description' => esc_html__( 'If you disable this option, when user click on the product on mobile devices, it will see its description text and add to cart button. The product page will be opened on second click.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => false,
		'priority'    => 20,
		'requires'    => array(
			array(
				'key'     => 'products_hover',
				'compare' => 'equals',
				'value'   => array( 'base' ),
			),
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'products_color_scheme',
		'name'     => esc_html__( 'Products color scheme', 'woodmart' ),
		'group'    => esc_html__( 'Style', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'products_styles_section',
		'default'  => 'default',
		'options'  => array(
			'default' => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
			),
			'dark'    => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
			'light'   => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
		),
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'products_bordered_grid',
		'name'        => esc_html__( 'Bordered grid', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'bordered-grid-outside.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Add borders between all product loop items, except for product elements, which have their own options.', 'woodmart' ),
		'group'       => esc_html__( 'Style', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'products_bordered_grid_style',
		'name'     => esc_html__( 'Bordered grid style', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'products_styles_section',
		'group'    => esc_html__( 'Style', 'woodmart' ),
		'options'  => array(
			'outside' => array(
				'name'  => esc_html__( 'Outside', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'bordered-grid-outside.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'outside',
			),
			'inside'  => array(
				'name'  => esc_html__( 'Inside', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'bordered-grid-inside.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'inside',
			),
		),
		'default'  => 'outside',
		'requires' => array(
			array(
				'key'     => 'products_bordered_grid',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'priority' => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'products_with_background',
		'name'        => esc_html__( 'Products background', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'products-with-background.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Add background to all product loop items, except product elements, which have their own options.', 'woodmart' ),
		'group'       => esc_html__( 'Style', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'products_background',
		'name'     => esc_html__( 'Custom products background color', 'woodmart' ),
		'description' => esc_html__( 'Set custom background color for products.', 'woodmart' ),
		'group'    => esc_html__( 'Style', 'woodmart' ),
		'type'     => 'color',
		'default'  => array( 'idle' => '' ),
		'section'  => 'products_styles_section',
		'selectors' => array(
			':is(.shop-content-area.wd-builder-off,.wd-wishlist-content,.related-and-upsells,.cart-collaterals,.wd-shop-product) .wd-products-with-bg, :is(.shop-content-area.wd-builder-off,.wd-wishlist-content,.related-and-upsells,.cart-collaterals,.wd-shop-product) .wd-products-with-bg .product-grid-item' => array(
				'--wd-prod-bg:{{VALUE}}; --wd-bordered-bg:{{VALUE}};',
			),
		),
		'priority' => 70,
		'class'    => 'xts-tab-field',
		'requires' => array(
			array(
				'key'     => 'products_with_background',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_shadow',
		'name'        => esc_html__( 'Products shadow', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'products_shadow.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Add a shadow to product loop items if the initial product style did not have one. Product elements have their own shadow control.', 'woodmart' ),
		'group'       => esc_html__( 'Style', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'stretch_product_desktop',
		'name'        => esc_html__( 'Even product grid for desktop', 'woodmart' ),
		'description' => esc_html__( 'Align the product hover content to the bottom of the products row.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'even-product-grid.mp4" autoplay loop muted></video>',
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => false,
		'priority'    => 90,
		'requires'    => array(
			array(
				'key'     => 'products_hover',
				'compare' => 'equals',
				'value'   => array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button' ),
			),
		),
		't_tab'    => [
			'id'    => 'stretch_product_tabs',
			'tab'   => esc_html__( 'Desktop', 'woodmart' ),
			'icon'  => 'xts-i-desktop',
			'style' => 'devices',
		],
	)
);

Options::add_field(
	array(
		'id'       => 'stretch_product_tablet',
		'name'     => esc_html__( 'Even product grid for tablet', 'woodmart' ),
		'description' => esc_html__( 'Align the product hover content to the bottom of the products row.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'products_styles_section',
		'default'  => false,
		'priority' => 100,
		'requires' => array(
			array(
				'key'     => 'products_hover',
				'compare' => 'equals',
				'value'   => array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button' ),
			),
		),
		't_tab'    => [
			'id'   => 'stretch_product_tabs',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
			'icon' => 'xts-i-tablet',
		],
	)
);

Options::add_field(
	array(
		'id'       => 'stretch_product_mobile',
		'name'     => esc_html__( 'Even product grid for mobile', 'woodmart' ),
		'description' => esc_html__( 'Align the product hover content to the bottom of the products row.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'products_styles_section',
		'default'  => false,
		'priority' => 110,
		'requires' => array(
			array(
				'key'     => 'products_hover',
				'compare' => 'equals',
				'value'   => array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button' ),
			),
		),
		't_tab'    => [
			'id'   => 'stretch_product_tabs',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
			'icon' => 'xts-i-phone',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'product_title_lines_limit',
		'name'        => esc_html__( 'Product title lines limit', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'product-title-lines-limit.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Specify the maximum number of product title lines if it does not fit on one line.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_styles_section',
		'options'     => array(
			'one'  => array(
				'name'  => esc_html__( 'One line', 'woodmart' ),
				'value' => 'one',
			),
			'two'  => array(
				'name'  => esc_html__( 'Two line', 'woodmart' ),
				'value' => 'one',
			),
			'none' => array(
				'name'  => esc_html__( 'None', 'woodmart' ),
				'value' => 'none',
			),
		),
		'default'  => 'none',
		'priority' => 120,
	)
);

Options::add_field(
	array(
		'id'          => 'show_empty_star_rating',
		'name'        => esc_html__( 'Show empty star rating', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-empty-star-rating.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Show empty star rating even if the product has no ratings.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 130,
	)
);

Options::add_field(
	array(
		'id'          => 'hover_image',
		'name'        => esc_html__( 'Hover image', 'woodmart' ),
		'description' => esc_html__( 'Disable - Enable hover image for products on the shop page.', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'hover-image.mp4" autoplay loop muted></video>',
		'group'       => esc_html__( 'Elements', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => '1',
		'priority'    => 140,
	)
);

Options::add_field(
	array(
		'id'          => 'grid_gallery',
		'name'        => esc_html__( 'Product gallery', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'grid-gallery-control-hover.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Add the ability to view the product gallery on the products loop.', 'woodmart' ),
		'group'       => esc_html__( 'Elements', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => false,
		'priority'    => 150,
	)
);

Options::add_field(
	array(
		'id'       => 'grid_gallery_control',
		'name'     => esc_html__( 'Product gallery controls on desktop', 'woodmart' ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'products_styles_section',
		'options'  => array(
			'hover'  => array(
				'name'  => esc_html__( 'Hover', 'woodmart' ),
				'hint'  => '<video data-src="' . WOODMART_TOOLTIP_URL . 'grid-gallery-control-hover.mp4" autoplay loop muted></video>',
				'value' => 'hover',
			),
			'arrows' => array(
				'name'  => esc_html__( 'Arrows', 'woodmart' ),
				'hint'  => '<video data-src="' . WOODMART_TOOLTIP_URL . 'grid-gallery-control-arrows.mp4" autoplay loop muted></video>',
				'value' => 'arrows',
			),
		),
		'default'  => 'hover',
		'requires' => array(
			array(
				'key'     => 'grid_gallery',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		't_tab'    => array(
			'id'       => 'grid_gallery_tabs',
			'tab'      => esc_html__( 'Desktop', 'woodmart' ),
			'icon'     => 'xts-i-desktop',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'grid_gallery',
					'compare' => 'equals',
					'value'   => true,
				),
			),
		),
		'priority' => 160,
	)
);

Options::add_field(
	array(
		'id'       => 'grid_gallery_enable_arrows',
		'name'     => esc_html__( 'Product gallery controls on mobile device', 'woodmart' ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'products_styles_section',
		'options'  => array(
			'none'   => array(
				'name'  => esc_html__( 'None', 'woodmart' ),
				'value' => 'none',
			),
			'arrows' => array(
				'name'  => esc_html__( 'Arrows', 'woodmart' ),
				'value' => 'arrows',
			),
		),
		'default'  => 'none',
		'requires' => array(
			array(
				'key'     => 'grid_gallery',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		't_tab'    => array(
			'id'   => 'grid_gallery_tabs',
			'tab'  => esc_html__( 'Mobile device', 'woodmart' ),
			'icon' => 'xts-i-phone',
		),
		'priority' => 170,
	)
);

Options::add_field(
	array(
		'id'          => 'product_quantity',
		'name'        => esc_html__( 'Quantity input on product', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'quantity-input-on-product.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Show quantity input on product hover and quick shop where the layout is allowing it. It can be shown on the following product hovers: "Standard button", "Quick", "Full width button", "List".', 'woodmart' ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => false,
		'priority'    => 180,
	)
);

Options::add_field(
	array(
		'id'       => 'base_hover_content',
		'name'     => esc_html__( 'Hover content', 'woodmart' ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'products_styles_section',
		'options'  => array(
			'excerpt'         => array(
				'name'  => esc_html__( 'Excerpt', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'hover-content-excerpt.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'excerpt',
			),
			'additional_info' => array(
				'name'  => esc_html__( 'Additional information', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'hover-content-additional-information.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'additional_info',
			),
			'none'            => array(
				'name'  => esc_html__( 'None', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'hover-content-none.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'none',
			),
		),
		'default'  => 'excerpt',
		'requires' => array(
			array(
				'key'     => 'products_hover',
				'compare' => 'equals',
				'value'   => array( 'base', 'fw-button' ),
			),
		),
		'priority' => 190,
	)
);

Options::add_field(
	array(
		'id'       => 'stock_status_position',
		'name'     => esc_html__( 'Stock status position', 'woodmart' ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'products_styles_section',
		'options'  => array(
			'thumbnail'   => array(
				'name'  => esc_html__( 'In thumbnail', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'stock-status-position-thumbnail.mp4" autoplay loop muted></video>',
				'value' => 'thumbnail',
			),
			'after_title' => array(
				'name'  => esc_html__( 'After title', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'stock-status-position-after-title.mp4" autoplay loop muted></video>',
				'value' => 'after_title',
			),
		),
		'default'  => 'thumbnail',
		'priority' => 200,
	)
);

Options::add_field(
	array(
		'id'          => 'grid_stock_progress_bar',
		'name'        => esc_html__( 'Stock progress bar', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'products-archive-stock-progress-bar.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Display a number of sold and in stock products as a progress bar.', 'woodmart' ),
		'group'       => esc_html__( 'Elements', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => false,
		'priority'    => 210,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_countdown',
		'name'        => esc_html__( 'Countdown timer', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'product-archive-countdown-timer.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Show timer for products that have scheduled date for the sale price', 'woodmart' ),
		'group'       => esc_html__( 'Elements', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_styles_section',
		'default'     => false,
		'priority'    => 220,
	)
);

Options::add_field(
	array(
		'id'       => 'categories_under_title',
		'name'     => esc_html__( 'Show product category', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-product-category.jpg" alt="">', 'woodmart' ), true ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'products_styles_section',
		'default'  => true,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority' => 230,
	)
);

Options::add_field(
	array(
		'id'       => 'brands_under_title',
		'name'     => esc_html__( 'Show product brands', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-product-brands.jpg" alt="">', 'woodmart' ), true ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'products_styles_section',
		'default'  => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority' => 240,
	)
);

Options::add_field(
	array(
		'id'       => 'sku_under_title',
		'name'     => esc_html__( 'Show SKU', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-sku.jpg" alt="">', 'woodmart' ), true ),
		'group'    => esc_html__( 'Elements', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'products_styles_section',
		'default'  => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority' => 250,
	)
);

/**
 * Categories styles.
 */
Options::add_field(
	array(
		'id'          => 'categories_design',
		'name'        => esc_html__( 'Categories design', 'woodmart' ),
		'description' => esc_html__( 'Choose one of those designs for categories', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'categories_styles_section',
		'default'     => 'default',
		'options'     => array(
			'default'       => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/categories/default.jpg',
			),
			'alt'           => array(
				'name'  => esc_html__( 'Alternative', 'woodmart' ),
				'value' => 'alt',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/categories/alt.jpg',
			),
			'center'        => array(
				'name'  => esc_html__( 'Center title', 'woodmart' ),
				'value' => 'center',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/categories/center.jpg',
			),
			'replace-title' => array(
				'name'  => esc_html__( 'Replace title', 'woodmart' ),
				'value' => 'replace-title',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/categories/replace-title.jpg',
			),
			'mask-subcat'   => array(
				'name'  => esc_html__( 'Mask with subcategories', 'woodmart' ),
				'value' => 'mask-subcat',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/categories/subcat.jpg',
			),
		),
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'categories_color_scheme',
		'name'     => esc_html__( 'Categories color scheme', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'categories_styles_section',
		'default'  => 'default',
		'options'  => array(
			'default' => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
			),
			'dark'    => array(
				'name'  => esc_html__( 'Dark', 'woodmart' ),
				'value' => 'dark',
			),
			'light'   => array(
				'name'  => esc_html__( 'Light', 'woodmart' ),
				'value' => 'light',
			),
		),
		'priority' => 15,
		'requires' => array(
			array(
				'key'     => 'categories_design',
				'compare' => 'equals',
				'value'   => array( 'default', 'mask-subcat' ),
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'categories_with_shadow',
		'name'     => esc_html__( 'Categories with shadow', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'categories_styles_section',
		'options'  => array(
			'enable'  => array(
				'name'  => esc_html__( 'Enable', 'woodmart' ),
				'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'categories-with-shadow-enable.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'enable',
			),
			'disable' => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'categories-with-shadow-disable.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'disable',
			),
		),
		'default'  => 'enable',
		'priority' => 20,
		'requires' => array(
			array(
				'key'     => 'categories_design',
				'compare' => 'equals',
				'value'   => array( 'alt', 'default' ),
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'hide_categories_product_count',
		'name'     => esc_html__( 'Hide product count on category', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'hide-product-count-on-category.mp4" autoplay loop muted></video>',
		'type'     => 'switcher',
		'section'  => 'categories_styles_section',
		'on-text'  => esc_html__( 'Yes', 'woodmart' ),
		'off-text' => esc_html__( 'No', 'woodmart' ),
		'default'  => false,
		'priority' => 30,
	)
);

/**
 * Sidebar.
 */
Options::add_field(
	array(
		'id'          => 'shop_layout',
		'name'        => esc_html__( 'Shop layout', 'woodmart' ),
		'description' => esc_html__( 'Select main content and sidebar alignment for shop pages.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'shop_sidebar_section',
		'options'     => array(
			'full-width'    => array(
				'name'  => esc_html__( '1 Column', 'woodmart' ),
				'value' => 'full-width',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/sidebar-layout/none.png',
			),
			'sidebar-left'  => array(
				'name'  => esc_html__( '2 Column Left', 'woodmart' ),
				'value' => 'sidebar-left',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/sidebar-layout/left.png',
			),
			'sidebar-right' => array(
				'name'  => esc_html__( '2 Column Right', 'woodmart' ),
				'value' => 'sidebar-right',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/sidebar-layout/right.png',
			),
		),
		'priority'    => 10,
		'default'     => 'sidebar-left',
	)
);

Options::add_field(
	array(
		'id'          => 'shop_sidebar_width',
		'name'        => esc_html__( 'Sidebar size', 'woodmart' ),
		'description' => esc_html__( 'You can set different sizes for your shop pages sidebar', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'shop_sidebar_section',
		'options'     => array(
			2 => array(
				'name'  => esc_html__( 'Small', 'woodmart' ),
				'value' => 2,
			),
			3 => array(
				'name'  => esc_html__( 'Medium', 'woodmart' ),
				'value' => 3,
			),
			4 => array(
				'name'  => esc_html__( 'Large', 'woodmart' ),
				'value' => 4,
			),
		),
		'priority'    => 20,
		'default'     => 3,
		'class'       => 'xts-tooltip-bordered',
	)
);

Options::add_field(
	array(
		'id'          => 'shop_hide_sidebar_desktop',
		'name'        => esc_html__( 'Off canvas sidebar for desktop', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'off-canvas-sidebar-for-desktop.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'You can hide the sidebar from the page and show it nicely with a button click.', 'woodmart' ),
		'group'       => esc_html__( 'Off canvas sidebar', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_sidebar_section',
		'default'     => false,
		'priority'    => 30,
		't_tab'       => [
			'id'    => 'off_canvas_sidebar_tabs',
			'tab'   => esc_html__( 'Desktop', 'woodmart' ),
			'icon'  => 'xts-i-desktop',
			'style' => 'devices',
		],
	)
);


Options::add_field(
	array(
		'id'          => 'shop_hide_sidebar_tablet',
		'name'        => esc_html__( 'Off canvas sidebar for tablet', 'woodmart' ),
		'description' => esc_html__( 'You can hide the sidebar on tablet devices and show it nicely with a button click.', 'woodmart' ),
		'group'       => esc_html__( 'Off canvas sidebar', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_sidebar_section',
		'default'     => '1',
		'priority'    => 40,
		'requires'    => array(
			array(
				'key'     => 'shop_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
		't_tab'       => [
			'id'   => 'off_canvas_sidebar_tabs',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
			'icon' => 'xts-i-tablet',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'shop_hide_sidebar',
		'name'        => esc_html__( 'Off canvas sidebar for mobile', 'woodmart' ),
		'description' => esc_html__( 'You can hide the sidebar on mobile devices and show it nicely with a button click.', 'woodmart' ),
		'group'       => esc_html__( 'Off canvas sidebar', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_sidebar_section',
		'default'     => '1',
		'priority'    => 50,
		'requires'    => array(
			array(
				'key'     => 'shop_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
		't_tab'       => [
			'id'   => 'off_canvas_sidebar_tabs',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
			'icon' => 'xts-i-phone',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'sticky_filter_button',
		'name'        => esc_html__( 'Sticky off canvas sidebar button', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'sticky-off-canvas-sidebar-button.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Display the filters button fixed on the screen for mobile and tablet devices.', 'woodmart' ),
		'group'       => esc_html__( 'Off canvas sidebar', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_sidebar_section',
		'default'     => false,
		'priority'    => 51,
	)
);

/**
 * Page title.
 */
Options::add_field(
	array(
		'id'          => 'shop_title',
		'name'        => esc_html__( 'Shop title', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'product-archive-shop-title.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Show title for shop page, product categories or tags.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_page_title_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_categories',
		'name'        => esc_html__( 'Categories in page title', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'categories-in-page-title.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'This categories menu is generated automatically based on all categories in the shop. You are not able to manage this menu as other WordPress menus.', 'woodmart' ),
		'group'       => esc_html__( 'Categories', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_page_title_section',
		'default'     => '1',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_categories_ancestors',
		'name'        => esc_html__( 'Show current category ancestors', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'show-current-category-ancestors.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'If you visit category Man, for example, only man\'s subcategories will be shown in the page title like T-shirts, Coats, Shoes etc.', 'woodmart' ),
		'group'       => esc_html__( 'Categories', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_page_title_section',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 30,
		'requires'    => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'show_categories_neighbors',
		'name'        => esc_html__( 'Show category neighbors if there is no children', 'woodmart' ),
		'description' => esc_html__( 'If the category you visit doesn\'t contain any subcategories, the page title menu will display this category\'s neighbors categories.', 'woodmart' ),
		'group'       => esc_html__( 'Categories', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_page_title_section',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 40,
		'requires'    => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
			array(
				'key'     => 'shop_categories_ancestors',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'shop_products_count',
		'name'     => esc_html__( 'Show products count for each category', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'show-products-count-for-each-category.mp4" autoplay loop muted></video>',
		'group'       => esc_html__( 'Categories', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'shop_page_title_section',
		'default'  => '1',
		'priority' => 50,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'requires' => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'shop_page_title_hide_empty_categories',
		'name'     => esc_html__( 'Hide empty categories', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'hide-empty-categories.mp4" autoplay loop muted></video>',
		'group'       => esc_html__( 'Categories', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'shop_page_title_section',
		'default'  => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'requires' => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'priority' => 60,
	)
);

Options::add_field(
	array(
		'id'           => 'shop_page_title_categories_exclude',
		'type'         => 'select',
		'section'      => 'shop_page_title_section',
		'name'         => esc_html__( 'Exclude categories', 'woodmart' ),
		'group'        => esc_html__( 'Categories', 'woodmart' ),
		'select2'      => true,
		'empty_option' => true,
		'multiple'     => true,
		'requires'     => array(
			array(
				'key'     => 'shop_categories',
				'compare' => 'equals',
				'value'   => true,
			),
			array(
				'key'     => 'shop_categories_ancestors',
				'compare' => 'not_equals',
				'value'   => true,
			),
		),
		'autocomplete' => array(
			'type'   => 'term',
			'value'  => 'product_cat',
			'search' => 'woodmart_get_taxonomies_by_query_autocomplete',
			'render' => 'woodmart_get_taxonomies_by_ids_autocomplete',
		),
		'priority'     => 70,
	)
);

/**
 * Products grid.
 */
Options::add_field(
	array(
		'id'          => 'shop_view',
		'name'        => __( 'Shop products view', 'woodmart' ),
		'description' => __( 'You can set different view mode for the shop page', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_grid_section',
		'options'     => array(
			'grid'      => array(
				'name'  => esc_html__( 'Grid', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-products-view-grid.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'grid',
			),
			'list'      => array(
				'name'  => esc_html__( 'List', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-products-view-list.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'list',
			),
			'grid_list' => array(
				'name'  => esc_html__( 'Grid / List', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-products-view-grid-list.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'grid_list',
			),
			'list_grid' => array(
				'name'  => esc_html__( 'List / Grid', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-products-view-list-grid.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'list_grid',
			),
		),
		'default'     => 'grid',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'products_columns',
		'name'        => esc_html__( 'Products columns on desktop', 'woodmart' ),
		'description' => esc_html__( 'How many products you want to show per row', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_grid_section',
		'options'     => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'     => 3,
		'priority'    => 20,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
		't_tab'       => [
			'id'    => 'products_columns_tabs',
			'tab'   => esc_html__( 'Desktop', 'woodmart' ),
			'icon'  => 'xts-i-desktop',
			'style' => 'devices',
			'requires' => array(
				array(
					'key'     => 'shop_view',
					'compare' => 'not_equals',
					'value'   => 'list',
				),
			),
		],
	)
);

Options::add_field(
	array(
		'id'          => 'products_columns_tablet',
		'name'        => esc_html__( 'Products columns on tablet', 'woodmart' ),
		'description' => esc_html__( 'How many products you want to show per row', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_grid_section',
		'options'     => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			1      => array(
				'name'  => 1,
				'value' => 1,
			),
			2      => array(
				'name'  => 2,
				'value' => 2,
			),
			3      => array(
				'name'  => 3,
				'value' => 3,
			),
			4      => array(
				'name'  => 4,
				'value' => 4,
			),
			5      => array(
				'name'  => 5,
				'value' => 5,
			),
			6      => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'     => 'auto',
		'priority'    => 21,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
		't_tab'       => [
			'id'   => 'products_columns_tabs',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
			'icon' => 'xts-i-tablet',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'products_columns_mobile',
		'name'        => esc_html__( 'Products columns on mobile', 'woodmart' ),
		'description' => esc_html__( 'How many products you want to show per row on mobile devices', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_grid_section',
		'options'     => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
		),
		'default'     => 2,
		'priority'    => 30,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
		't_tab'       => [
			'id'   => 'products_columns_tabs',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
			'icon' => 'xts-i-phone',
		],
	)
);

Options::add_field(
	array(
		'id'          => 'products_spacing',
		'name'        => esc_html__( 'Space between products', 'woodmart' ),
		'description' => esc_html__( 'You can set different spacing between blocks on shop page', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_grid_section',
		'options'     => array(
			0  => array(
				'name'  => 0,
				'value' => 0,
			),
			2  => array(
				'name'  => 2,
				'value' => 2,
			),
			6  => array(
				'name'  => 5,
				'value' => 6,
			),
			10 => array(
				'name'  => 10,
				'value' => 10,
			),
			20 => array(
				'name'  => 20,
				'value' => 20,
			),
			30 => array(
				'name'  => 30,
				'value' => 30,
			),
		),
		'default'     => 20,
		'priority'    => 40,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'per_row_columns_selector',
		'name'        => esc_html__( 'Number of columns selector', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'number-of-columns-selector.jpg" alt="">', 'woodmart' ), true ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'description' => esc_html__( 'Allow customers to change number of columns per row', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_grid_section',
		'default'     => '1',
		'priority'    => 50,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_columns_variations',
		'name'        => esc_html__( 'Available products columns variations', 'woodmart' ),
		'description' => esc_html__( 'What columns users may select to be displayed on the product page', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'select',
		'multiple'    => true,
		'select2'     => true,
		'section'     => 'products_grid_section',
		'options'     => array(
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'     => array( 2, 3, 4 ),
		'priority'    => 60,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
			array(
				'key'     => 'per_row_columns_selector',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_masonry',
		'name'        => esc_html__( 'Masonry grid', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'product-archive-masonry-grid.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Useful if your products have different height.', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_grid_section',
		'default'     => false,
		'priority'    => 62,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'products_different_sizes',
		'name'        => esc_html__( 'Products grid with different sizes', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'products-grid-with-different-sizes.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'In this situation, some of the products will be twice bigger in width than others. Recommended to use with 6 columns grid only.', 'woodmart' ),
		'group'       => esc_html__( 'Grid', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_grid_section',
		'default'     => false,
		'priority'    => 63,
		'requires'    => array(
			array(
				'key'     => 'shop_view',
				'compare' => 'not_equals',
				'value'   => 'list',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_per_page',
		'name'        => esc_html__( 'Products per page', 'woodmart' ),
		'description' => esc_html__( 'Number of products per page', 'woodmart' ),
		'group'       => esc_html__( 'Pages', 'woodmart' ),
		'type'        => 'text_input',
		'attributes'  => array(
			'type' => 'number',
		),
		'section'     => 'products_grid_section',
		'default'     => 12,
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'per_page_links',
		'name'        => esc_html__( 'Products per page links', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'products-per-page-links.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Allow customers to change number of products per page', 'woodmart' ),
		'group'       => esc_html__( 'Pages', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_grid_section',
		'default'     => '1',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'per_page_options',
		'name'        => esc_html__( 'Products per page variations', 'woodmart' ),
		'description' => esc_html__( 'For ex.: 12,24,36,-1. Use -1 to show all products on the page', 'woodmart' ),
		'group'       => esc_html__( 'Pages', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'products_grid_section',
		'default'     => '9,12,18,24',
		'priority'    => 90,
		'requires'    => array(
			array(
				'key'     => 'per_page_links',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_pagination',
		'name'        => esc_html__( 'Products pagination', 'woodmart' ),
		'description' => esc_html__( 'Choose a type for the pagination on your shop page.', 'woodmart' ),
		'group'       => esc_html__( 'Pages', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'products_grid_section',
		'options'     => array(
			'pagination' => array(
				'name'  => esc_html__( 'Pagination', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'products-pagination-pagination.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'pagination',
			),
			'more-btn'   => array(
				'name'  => esc_html__( '"Load more" button', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'products-pagination-load-more-button.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'more-btn',
			),
			'infinit'    => array(
				'name'  => esc_html__( 'Infinite scrolling', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'infinit-products.mp4" autoplay loop muted></video>',
				'value' => 'infinit',
			),
		),
		'default'     => 'pagination',
		'priority'    => 100,
	)
);

Options::add_field(
	array(
		'id'          => 'load_more_button_page_url',
		'name'        => esc_html__( 'Keep the page number in the URL', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'keep-the-page-number-in-the-url.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Enable this option if you want to change the page number in the URL when you click on the “Load more” button.', 'woodmart' ),
		'group'       => esc_html__( 'Pages', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'products_grid_section',
		'default'     => true,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 110,
	)
);

/**
 * Widgets.
 */
Options::add_field(
	array(
		'id'          => 'categories_toggle',
		'name'        => esc_html__( 'Toggle function for categories widget', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'toggle-function-for-categories-widget.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Turn it on to enable accordion JS for the WooCommerce Product Categories widget. Useful if you have a lot of categories and subcategories.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'widgets_section',
		'default'     => '1',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'widgets_scroll',
		'name'        => esc_html__( 'Scroll for filters widgets', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'scroll-for-filters-widgets.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'You can limit your Layered Navigation widgets by height and enable nice scroll for them. Useful if you have a lot of product colors/sizes or other attributes for filters.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'widgets_section',
		'default'     => '1',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'widget_heights',
		'name'        => esc_html__( 'Height for filters widgets', 'woodmart' ),
		'description' => esc_html__( 'Set widgets height in pixels.', 'woodmart' ),
		'type'        => 'range',
		'section'     => 'widgets_section',
		'default'     => 223,
		'min'         => 100,
		'step'        => 1,
		'max'         => 800,
		'priority'    => 30,
		'requires'    => array(
			array(
				'key'     => 'widgets_scroll',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'unit'        => 'px',
	)
);

Options::add_field(
	array(
		'id'          => 'shop_widgets_collapse',
		'name'        => esc_html__( 'Shop sidebar widgets collapse', 'woodmart' ),
		'description' => esc_html__( '“Filters only” variant works with WoodMart Layered Navigation widgets.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'widgets_section',
		'options'     => array(
			'disable'     => array(
				'name'  => esc_html__( 'Disable', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-sidebar-widgets-disable.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'disable',
			),
			'all'         => array(
				'name'  => esc_html__( 'All widgets', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-sidebar-widgets-collapse-all-widgets.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'all',
			),
			'layered-nav' => array(
				'name'  => esc_html__( 'Filters only', 'woodmart' ),
				'hint'  => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-sidebar-widgets-collapse-filters-only.jpg" alt="">', 'woodmart' ), true ),
				'value' => 'layered-nav',
			),
		),
		'default'     => 'disable',
		'priority'    => 40,
	)
);

/**
 * Shop filers.
 */
Options::add_field(
	array(
		'id'          => 'shop_filters',
		'name'        => esc_html__( 'Shop filters', 'woodmart' ),
		'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'shop-filters.jpg" alt="">', 'woodmart' ), true ),
		'description' => esc_html__( 'Enable shop filters widget\'s area above the products.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_filters_section',
		'default'     => false,
		'priority'    => 10,
	)
);


Options::add_field(
	array(
		'id'          => 'shop_filters_type',
		'name'        => esc_html__( 'Shop filters content type', 'woodmart' ),
		'description' => esc_html__( 'You can use widgets or custom HTML block with our Product filters page builder element.', 'woodmart' ),
		'group'       => esc_html__( 'Content', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'shop_filters_section',
		'default'     => 'widgets',
		'options'     => array(
			'widgets' => array(
				'name'  => esc_html__( 'Widgets', 'woodmart' ),
				'value' => 'widgets',
			),
			'content' => array(
				'name'  => esc_html__( 'HTML Block', 'woodmart' ),
				'value' => 'content',
			),
		),
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'           => 'shop_filters_content',
		'name'         => esc_html__( 'Shop filters HTML Block', 'woodmart' ),
		'description'  => esc_html__( 'You can create an HTML Block in Dashboard -> HTML Blocks and add Product filters page builder element there.', 'woodmart' ),
		'group'        => esc_html__( 'Content', 'woodmart' ),
		'type'         => 'select',
		'section'      => 'shop_filters_section',
		'select2'      => true,
		'empty_option' => true,
		'autocomplete' => array(
			'type'   => 'post',
			'value'  => 'cms_block',
			'search' => 'woodmart_get_post_by_query_autocomplete',
			'render' => 'woodmart_get_post_by_ids_autocomplete',
		),
		'priority'     => 30,
		'requires'     => array(
			array(
				'key'     => 'shop_filters_type',
				'compare' => 'equals',
				'value'   => 'content',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'shop_filters_always_open',
		'name'        => esc_html__( 'Shop filters area always opened', 'woodmart' ),
		'description' => esc_html__( 'If you enable this option the shop filters will be always opened on the shop page.', 'woodmart' ),
		'group'       => esc_html__( 'State', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_filters_section',
		'default'     => false,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'shop_filters_close',
		'name'        => esc_html__( 'Stop close filters after click', 'woodmart' ),
		'description' => esc_html__( 'This option will prevent filters area from closing when you click on certain filter links.', 'woodmart' ),
		'group'       => esc_html__( 'State', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'shop_filters_section',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 50,
		'requires'    => array(
			array(
				'key'     => 'shop_filters_always_open',
				'compare' => 'equals',
				'value'   => '0',
			),
		),
	)
);