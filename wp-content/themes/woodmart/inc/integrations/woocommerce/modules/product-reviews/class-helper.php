<?php
/**
 * Single product reviews helper class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Product_Reviews;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Likes class.
 */
class Helper {
	/**
	 * Get current product_id from $_GET or from global const $product.
	 *
	 * @return int|string
	 */
	public static function get_product_id() {
		global $product;

		if ( ! empty( $_GET['product_id'] ) ) { //phpcs:ignore.
			return wp_unslash( $_GET['product_id'] ); //phpcs:ignore.
		} elseif ( isset( $product ) ) {
			return $product->get_id();
		}

		return 0;
	}

	/**
	 * Get current ratings from $_GET. Default: empty string.
	 *
	 * @return array
	 */
	public static function get_ratings_from_request() {
		return ! empty( $_GET['rating'] ) ? explode( ',', wp_unslash( $_GET['rating'] ) ) : array(); //phpcs:ignore.
	}

	/**
	 * Get current order_by from $_GET. Default: 'newest'.
	 *
	 * @return string
	 */
	public static function get_order_by_from_request() {
		return ! empty( $_GET['order_by'] ) ? wp_unslash( $_GET['order_by'] ) : 'default'; //phpcs:ignore.
	}

	/**
	 * Get current only_images from $_GET. Default: 'false' string.
	 *
	 * @return bool
	 */
	public static function show_only_image() {
		return isset( $_GET['only_images'] ) && 'true' === $_GET['only_images']; //phpcs:ignore.
	}
}
