<?php
/**
 * FOX — Currency Switcher Professional for WooCommerce.
 *
 * @package woodmart
 */

if ( ! defined( 'WOOCS_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_woocs_convert_product_bundle_in_cart' ) ) {
	/**
	 * Back convector bundle product price.
	 *
	 * @param float  $price Product price.
	 * @param object $cart_item Product cart data.
	 * @return mixed|string
	 */
	function woodmart_woocs_convert_product_bundle_in_cart( $price, $cart_item ) {
		global $WOOCS;

		return $WOOCS->woocs_back_convert_price( $price );
	}

	add_filter( 'woodmart_fbt_set_product_cart_price', 'woodmart_woocs_convert_product_bundle_in_cart', 10, 2 );
}

if ( ! function_exists( 'woodmart_woocs_shipping_progress_bar_amount' ) ) {
	/**
	 * Converse shipping progress bar limit
	 *
	 * @param float $limit
	 * @return float
	 */
	function woodmart_woocs_shipping_progress_bar_amount( $limit ) {
		global $WOOCS;

		$limit *= $WOOCS->get_sign_rate( array( 'sign' => $WOOCS->current_currency ) );

		return $limit;
	}

	add_filter( 'woodmart_fbt_set_product_price_cart', 'woodmart_woocs_shipping_progress_bar_amount' );
	add_filter( 'woodmart_shipping_progress_bar_amount', 'woodmart_woocs_shipping_progress_bar_amount' );
}
