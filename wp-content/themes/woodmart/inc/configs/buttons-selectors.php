<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Elements selectors for advanced button styles
 * ------------------------------------------------------------------------------------------------
 */

return apply_filters(
	'woodmart_buttons_selectors',
	array(
		'all_buttons'                   => array(
			'title'        => 'All buttons',
			'selector_var' => array(
				'font-family'      => '--btn-font-family',
				'font-weight'      => '--btn-font-weight',
				'font-style'       => '--btn-font-style',
				'font-size'        => '--btn-font-size',
				'text-transform'   => '--btn-transform',
				'color'            => '--btn-color',
				'color-hover'      => '--btn-color-hover',
				'background'       => '--btn-bgcolor',
				'background-hover' => '--btn-bgcolor-hover',
			),
		),
		'product_loop'                => array(
			'title' => 'Product loop',
		),
		'quick_add_to_cart'             => array(
			'title'          => 'Hover "Quick" add to cart',
			'selector'       => 'html .wd-hover-quick .wd-add-btn>a, html .wd-hover-quick.wd-quantity-overlap div.quantity input[type]',
			'selector-hover' => 'html .wd-hover-quick .wd-add-btn>a:hover, html .wd-hover-quick.wd-quantity-overlap div:hover > div.quantity input[type], 
			html .wd-hover-quick.wd-quantity-overlap div:hover > div.quantity+.button',
		),
		'summary_add_to_cart'           => array(
			'title'          => 'Hover "Show summary on hover" add to cart',
			'selector'       => 'html .wd-hover-base .wd-bottom-actions:not(.wd-add-small-btn) .wd-add-btn>a',
			'selector-hover' => 'html .wd-hover-base .wd-bottom-actions:not(.wd-add-small-btn) .wd-add-btn>a:hover',
		),
		'standard_add_to_cart'          => array(
			'title'          => 'Hover "Standard button" add to cart',
			'selector'       => 'html .wd-hover-standard .wd-add-btn>a',
			'selector-hover' => 'html .wd-hover-standard .wd-add-btn>a:hover',
		),
		'fw-button_add_to_cart'         => array(
			'title'          => 'Hover "Full width button" add to cart',
			'selector'       => 'html .wd-hover-fw-button .wd-add-btn>a, html .wd-hover-fw-button.wd-quantity-overlap div.quantity input[type]',
			'selector-hover' => 'html .wd-hover-fw-button .wd-add-btn>a:hover, html .wd-hover-fw-button.wd-quantity-overlap div:hover > div.quantity input[type], 
			html .wd-hover-fw-button.wd-quantity-overlap div:hover > div.quantity+.button',
		),
		'list_add_to_cart'              => array(
			'title'          => 'Hover "List" add to cart',
			'selector'       => 'html .product-list-item .wd-add-btn>a',
			'selector-hover' => 'html .product-list-item .wd-add-btn>a:hover',
		),
		'quick_shop_add_to_cart'        => array(
			'title'          => 'Quick shop add to cart',
			'selector'       => 'html .quick-shop-form .single_add_to_cart_button, html .quick-shop-form div.quantity input[type]',
			'selector-hover' => 'html .quick-shop-form .single_add_to_cart_button:hover, html .quick-shop-form div:hover > div.quantity input[type], 
			html .quick-shop-form div:hover > div.quantity+.button',
		),
		'single_product'                => array(
			'title' => 'Single product',
		),
		'single_add_to_cart'            => array(
			'title'          => 'Single add to cart',
			'selector'       => 'html .entry-summary .single_add_to_cart_button, .wd-single-add-cart .single_add_to_cart_button',
			'selector-hover' => 'html .entry-summary .single_add_to_cart_button:hover, .wd-single-add-cart .single_add_to_cart_button:hover',
		),
		'single_buy_now'                => array(
			'title'          => 'Single buy now',
			'selector'       => 'html .wd-buy-now-btn',
			'selector-hover' => 'html .wd-buy-now-btn:hover',
		),
		'sticky_add_to_cart'            => array(
			'title'          => 'Sticky add to cart',
			'selector'       => 'html .wd-sticky-btn-cart .single_add_to_cart_button, html .wd-sticky-add-to-cart, html .wd-sticky-btn.wd-quantity-overlap div.quantity input[type]',
			'selector-hover' => 'html .wd-sticky-btn-cart .single_add_to_cart_button:hover, html .wd-sticky-add-to-cart:hover, html .wd-sticky-btn.wd-quantity-overlap .cart:hover > div.quantity input[type], html .wd-sticky-btn.wd-quantity-overlap .cart:hover > div.quantity+.button',
		),
		'review_submit'                 => array(
			'title'          => 'Review submit',
			'selector'       => 'html .comment-form .submit',
			'selector-hover' => 'html .comment-form .submit:hover',
		),
		'quick_view'                    => array(
			'title' => 'Quick view',
		),
		'quick_view_add_to_cart'        => array(
			'title'          => 'Quick view add to cart',
			'selector'       => 'html .product-quick-view .entry-summary .single_add_to_cart_button',
			'selector-hover' => 'html .product-quick-view .entry-summary .single_add_to_cart_button:hover',
		),
		'quick_view_view_details'       => array(
			'title'          => 'View details',
			'selector'       => 'html .product-quick-view .view-details-btn',
			'selector-hover' => 'html .product-quick-view .view-details-btn:hover',
		),
		'cart'                          => array(
			'title' => 'Cart',
		),
		'cart_coupon'                   => array(
			'title'          => 'Cart apply coupon',
			'selector'       => 'html .cart-actions .button[name="apply_coupon"]',
			'selector-hover' => 'html .cart-actions .button[name="apply_coupon"]:hover',
		),
		'update_cart'                   => array(
			'title'          => 'Update cart',
			'selector'       => 'html .cart-actions .button[name="update_cart"]',
			'selector-hover' => 'html .cart-actions .button[name="update_cart"]:hover',
		),
		'proceed_to_checkout'           => array(
			'title'          => 'Proceed to checkout',
			'selector'       => 'html .cart-totals-inner .checkout-button',
			'selector-hover' => 'html .cart-totals-inner .checkout-button:hover',
		),
		'mini_cart'                     => array(
			'title' => 'Mini cart',
		),
		'mini_cart_view_cart'           => array(
			'title'          => 'Mini cart view cart',
			'selector'       => 'html .woocommerce-mini-cart__buttons .btn-cart',
			'selector-hover' => 'html .woocommerce-mini-cart__buttons .btn-cart:hover',
		),
		'mini_cart_checkout'            => array(
			'title'          => 'Mini cart checkout',
			'selector'       => 'html .woocommerce-mini-cart__buttons .checkout',
			'selector-hover' => 'html .woocommerce-mini-cart__buttons .checkout:hover',
		),
		'mini_cart_return_to_shop'      => array(
			'title'          => 'Mini cart empty',
			'selector'       => 'html .wd-empty-mini-cart .btn',
			'selector-hover' => 'html .wd-empty-mini-cart .btn:hover',
		),
		'checout page'                  => array(
			'title' => 'Checkout',
		),
		'checkout_login'                => array(
			'title'          => 'Checkout log in',
			'selector'       => 'html .woocommerce-checkout .login .button',
			'selector-hover' => 'html .woocommerce-checkout .login .button:hover',
		),
		'checkout_coupon'               => array(
			'title'          => 'Checkout apply coupon',
			'selector'       => 'html .checkout_coupon .button',
			'selector-hover' => 'html .checkout_coupon .button:hover',
		),
		'place_order'                   => array(
			'title'          => 'Place order',
			'selector'       => 'html #place_order',
			'selector-hover' => 'html #place_order:hover',
		),
		'my_account'                    => array(
			'title' => 'My account',
		),
		'my_account_save_address'       => array(
			'title'          => 'Save account data',
			'selector'       => 'html button[name="save_account_details"], html button[name="save_address"]',
			'selector-hover' => 'html button[name="save_account_details"]:hover, html button[name="save_address"]:hover',
		),
		'my_account_orders_actions'     => array(
			'title'          => 'Orders table actions',
			'selector'       => 'html td.woocommerce-orders-table__cell-order-actions a',
			'selector-hover' => 'html td.woocommerce-orders-table__cell-order-actions a:hover',
		),
		'my_account_download_file'      => array(
			'title'          => 'Download file',
			'selector'       => 'html .woocommerce-MyAccount-downloads-file',
			'selector-hover' => 'html .woocommerce-MyAccount-downloads-file:hover',
		),
		'my_account_order_again'        => array(
			'title'          => 'Order again',
			'selector'       => 'html .order-again .button',
			'selector-hover' => 'html .order-again .button:hover',
		),
		'login_register'                => array(
			'title' => 'Login/Register',
		),
		'login'                         => array(
			'title'          => 'Log in',
			'selector'       => 'html .login .button',
			'selector-hover' => 'html .login .button:hover',
		),
		'register'                      => array(
			'title'          => 'Register',
			'selector'       => 'html .register .button',
			'selector-hover' => 'html .register .button:hover',
		),
		'login_register_tabs'           => array(
			'title'          => 'Log in/Register tabs switch',
			'selector'       => 'html .wd-switch-to-register',
			'selector-hover' => 'html .wd-switch-to-register:hover',
		),
		'reset_password'                => array(
			'title'          => 'Reset password',
			'selector'       => 'html .lost_reset_password .button',
			'selector-hover' => 'html .lost_reset_password .button:hover',
		),
		'wishlist'                      => array(
			'title' => 'Wishlist',
		),
		'wishlist_popup_add'            => array(
			'title'          => '"Add to wishlist" button in wishlist popup',
			'selector'       => 'html .wd-popup-wishlist .wd-wishlist-save-btn',
			'selector-hover' => 'html .wd-popup-wishlist .wd-wishlist-save-btn:hover',
		),
		'wishlist_popup_browse'         => array(
			'title'          => '"Browse wishlist" button in wishlist popup',
			'selector'       => 'html .wd-popup-wishlist .wd-wishlist-back-to-lists',
			'selector-hover' => 'html .wd-popup-wishlist .wd-wishlist-back-to-lists:hover',
		),
		'wishlist_create_group'         => array(
			'title'          => 'Create new wishlist',
			'selector'       => 'html .wd-wishlist-create-group-btn',
			'selector-hover' => 'html .wd-wishlist-create-group-btn:hover',
		),
		'wishlist_rename_group'         => array(
			'title'          => 'Rename wishlist',
			'selector'       => 'html .wd-wishlist-rename-save',
			'selector-hover' => 'html .wd-wishlist-rename-save:hover',
		),
		'compare'                       => array(
			'title' => 'Compare',
		),
		'compare_page_add_more_product' => array(
			'title'          => 'Compare page add more products',
			'selector'       => 'html .btn.wd-compare-cat-link',
			'selector-hover' => 'html .btn.wd-compare-cat-link:hover',
		),
		'compare_page_remove_category'  => array(
			'title'          => 'Compare page remove category',
			'selector'       => 'html .btn.wd-compare-remove-cat',
			'selector-hover' => 'html .btn.wd-compare-remove-cat:hover',
		),
		'compare_page_add_to_cart'      => array(
			'title'          => 'Compare page add to cart',
			'selector'       => 'html .wd-compare-table .button, html .wd-compare-table .added_to_cart',
			'selector-hover' => 'html .wd-compare-table .button:hover, html .wd-compare-table .added_to_cart:hover',
		),
		'blog'                          => array(
			'title' => 'Blog',
		),
		'blog_post_comment'             => array(
			'title'          => 'Post comment',
			'selector'       => 'html .comment-form .submit',
			'selector-hover' => 'html .comment-form .submit:hover',
		),
		'plugins'                       => array(
			'title' => 'Plugins',
		),
		'mailchimp_signup'              => array(
			'title'          => 'MailChimp sign up',
			'selector'       => 'html .mc4wp-form input[type="submit"]',
			'selector-hover' => 'html .mc4wp-form input[type="submit"]:hover',
		),
		'contact_form'                  => array(
			'title'          => 'Contact form submit',
			'selector'       => 'html .wpcf7 input[type="submit"]',
			'selector-hover' => 'html .wpcf7 input[type="submit"]:hover',
		),
		'widgets'                       => array(
			'title' => 'Widgets',
		),
		'widget_price_filer'            => array(
			'title'          => 'Price filter',
			'selector'       => 'html .widget_price_filter [class*="price_slider_amount"] .button',
			'selector-hover' => 'html .widget_price_filter [class*="price_slider_amount"] .button:hover',
		),
		'elements'                      => array(
			'title' => 'Elements',
		),
		'price_plan_button'             => array(
			'title'          => 'Price plan button',
			'selector'       => 'html .wd-price-table .wd-plan-footer > a',
			'selector-hover' => 'html .wd-price-table .wd-plan-footer > a:hover',
		),
		'hotspot_add_to_cart'           => array(
			'title'          => 'Hotspot add to cart',
			'selector'       => 'html .hotspot-content .add_to_cart_button, html .hotspot-content .product_type_variable',
			'selector-hover' => 'html .hotspot-content .add_to_cart_button:hover, html .hotspot-content .product_type_variable:hover',
		),
		'hotspot_read_more'             => array(
			'title'          => 'Hotspot read more',
			'selector'       => 'html .hotspot-content .btn.btn-color-primary',
			'selector-hover' => 'html .hotspot-content .btn.btn-color-primary:hover',
		),
		'product_filters_btn'           => array(
			'title'          => 'Product filters',
			'selector'       => 'html .wd-pf-btn button',
			'selector-hover' => 'html .wd-pf-btn button:hover',
		),
		'track_order_btn'               => array(
			'title'          => 'Track order',
			'selector'       => 'html button[name="track"]',
			'selector-hover' => 'html button[name="track"]:hover',
		),
		'other'                         => array(
			'title' => 'Other',
		),
		'add_to_cart_popup_view_cart'   => array(
			'title'          => 'Add to cart popup view cart',
			'selector'       => 'html .popup-added_to_cart .view-cart',
			'selector-hover' => 'html .popup-added_to_cart .view-cart:hover',
		),
		'empty_page_btn'                => array(
			'title'          => 'Empty page button',
			'selector'       => 'html .website-wrapper .return-to-shop .button',
			'selector-hover' => 'html .website-wrapper .return-to-shop .button:hover',
		),
		'age_verify_allowed'            => array(
			'title'          => 'Age verify allowed',
			'selector'       => 'html .wd-age-verify .wd-age-verify-allowed',
			'selector-hover' => 'html .wd-age-verify .wd-age-verify-allowed:hover',
		),
		'age_verify_forbidden'          => array(
			'title'          => 'Age verify forbidden',
			'selector'       => 'html .wd-age-verify .wd-age-verify-forbidden',
			'selector-hover' => 'html .wd-age-verify .wd-age-verify-forbidden:hover',
		),
		'cookies_popup_btn'             => array(
			'title'          => 'Cookies popup accept',
			'selector'       => 'html .cookies-buttons .cookies-accept-btn',
			'selector-hover' => 'html .cookies-buttons .cookies-accept-btn:hover',
		),
	)
);
