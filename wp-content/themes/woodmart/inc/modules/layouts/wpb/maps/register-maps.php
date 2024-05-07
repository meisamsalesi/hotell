<?php
/**
 * Register vc elements maps for Woodmart layout.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'woodmart_vc_register_layouts_maps' ) ) {
	function woodmart_vc_register_layouts_maps() {
		if ( ! woodmart_is_core_installed() || ! woodmart_woocommerce_installed() ) {
			return;
		}

		$maps = array();

		$cart_maps = array(
			'woodmart_cart_table'  => 'woodmart_get_vc_map_cart_table',
			'woodmart_cart_totals' => 'woodmart_get_vc_map_cart_totals',
		);

		$checkout_form_maps = array(
			'woodmart_checkout_billing_details_form'  => 'woodmart_get_vc_map_checkout_billing_details_form',
			'woodmart_checkout_order_review'          => 'woodmart_get_vc_map_checkout_order_review',
			'woodmart_checkout_payment_methods'       => 'woodmart_get_vc_map_checkout_payment_methods',
			'woodmart_checkout_shipping_details_form' => 'woodmart_get_vc_map_checkout_shipping_details_form',
		);

		$checkout_content_maps = array(
			'woodmart_checkout_coupon_form' => 'woodmart_get_vc_map_checkout_coupon_form',
			'woodmart_checkout_login_form'  => 'woodmart_get_vc_map_checkout_login_form',
		);

		$archive_maps = array(
			'woodmart_shop_archive_active_filters'    => 'woodmart_get_vc_map_archive_active_filters',
			'woodmart_shop_archive_description'       => 'woodmart_get_vc_map_shop_archive_description',
			'woodmart_shop_archive_products'          => 'woodmart_get_vc_map_shop_archive_products',
			'woodmart_shop_archive_extra_description' => 'woodmart_get_vc_map_archive_extra_description',
			'woodmart_shop_archive_filters_area'      => 'woodmart_get_vc_map_shop_archive_filters_area',
			'woodmart_shop_archive_filters_area_btn'  => 'woodmart_get_vc_map_shop_archive_filters_area_btn',
			'woodmart_shop_archive_orderby'           => 'woodmart_get_vc_map_shop_archive_orderby',
			'woodmart_shop_archive_per_page'          => 'woodmart_get_vc_map_shop_archive_per_page',
			'woodmart_shop_archive_result_count'      => 'woodmart_get_vc_map_shop_archive_result_count',
			'woodmart_shop_archive_view'              => 'woodmart_get_vc_map_shop_archive_view',
			'woodmart_shop_archive_woocommerce_title' => 'woodmart_get_vc_map_shop_archive_woocommerce_title',
		);

		$single_product_maps = array(
			'woodmart_single_product_add_to_cart'        => 'woodmart_get_vc_map_single_product_add_to_cart',
			'woodmart_single_product_additional_info_table' => 'woodmart_get_vc_map_single_product_additional_info_table',
			'woodmart_single_product_brand_information'  => 'woodmart_get_vc_map_single_product_brand_information',
			'woodmart_single_product_brands'             => 'woodmart_get_vc_map_single_product_brands',
			'woodmart_single_product_compare_button'     => 'woodmart_get_vc_map_single_product_compare_button',
			'woodmart_single_product_content'            => 'woodmart_get_vc_map_single_product_content',
			'woodmart_single_product_countdown'          => 'woodmart_get_vc_map_single_product_countdown',
			'woodmart_single_product_extra_content'      => 'woodmart_get_vc_map_single_product_extra_content',
			'woodmart_single_product_fbt_products'       => 'woodmart_get_vc_map_single_product_fbt_products',
			'woodmart_single_product_gallery'            => 'woodmart_get_vc_map_single_product_gallery',
			'woodmart_single_product_linked_variations'  => 'woodmart_get_vc_map_single_product_linked_variations',
			'woodmart_single_product_meta'               => 'woodmart_get_vc_map_single_product_product_meta',
			'woodmart_single_product_meta_value'         => 'woodmart_get_vc_map_single_product_meta_value',
			'woodmart_single_product_nav'                => 'woodmart_get_vc_map_single_product_nav',
			'woodmart_single_product_price'              => 'woodmart_get_vc_map_single_product_price',
			'woodmart_single_product_rating'             => 'woodmart_get_vc_map_single_product_rating',
			'woodmart_single_product_reviews'            => 'woodmart_get_vc_map_single_product_reviews',
			'woodmart_single_product_short_description'  => 'woodmart_get_vc_map_single_product_short_description',
			'woodmart_single_product_size_guide_button'  => 'woodmart_get_vc_map_single_product_size_guide_button',
			'woodmart_single_product_stock_progress_bar' => 'woodmart_get_vc_map_single_product_stock_progress_bar',
			'woodmart_single_product_stock_status'       => 'woodmart_get_vc_map_single_product_stock_status',
			'woodmart_single_product_tabs'               => 'woodmart_get_vc_map_single_product_tabs',
			'woodmart_single_product_title'              => 'woodmart_get_vc_map_single_product_title',
			'woodmart_single_product_visitor_counter'    => 'woodmart_get_vc_map_single_product_visitor_counter',
			'woodmart_single_product_wishlist_button'    => 'woodmart_get_vc_map_single_product_wishlist_button',
		);

		$woocommerce_maps = array(
			'woodmart_woocommerce_breadcrumb' => 'woodmart_get_vc_map_woocommerce_breadcrumb',
			'woodmart_woocommerce_hook'       => 'woodmart_get_vc_map_woocommerce_hook',
			'woodmart_woocommerce_notices'    => 'woodmart_get_vc_map_woocommerce_notices',
			'woodmart_page_title'             => 'woodmart_get_vc_map_page_title',
			'woodmart_shipping_progress_bar'  => 'woodmart_get_vc_map_shipping_progress_bar',
		);

		if ( Main::is_layout_type( 'shop_archive' ) ) {
			$maps = array_merge( $maps, $archive_maps );
		}

		if ( Main::is_layout_type( 'single_product' ) ) {
			$maps = array_merge( $maps, $single_product_maps );
		}

		if ( Main::is_layout_type( 'cart' ) ) {
			$maps = array_merge( $maps, $cart_maps );
		}

		if ( Main::is_layout_type( 'checkout_form' ) ) {
			$maps = array_merge( $maps, $checkout_form_maps );
		}

		if ( Main::is_layout_type( 'checkout_content' ) ) {
			$maps = array_merge( $maps, $checkout_content_maps );
		}

		if ( Main::is_layout_type( 'checkout_form' ) || Main::is_layout_type( 'cart' ) || Main::is_layout_type( 'checkout_content' ) ) {
			$maps = array_merge( $maps, array( 'woodmart_woocommerce_checkout_steps' => 'woodmart_get_vc_map_checkout_steps' ) );
		}

		$maps = array_merge( $maps, $woocommerce_maps );

		foreach ( $maps as $key => $callback ) {
			woodmart_vc_map( $key, $callback );
		}
	}

	add_action( 'vc_mapper_init_after', 'woodmart_vc_register_layouts_maps', 11 );
}
