<?php
/**
 * Quick buy.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Quick_Buy;

use WC_Form_Handler;
use XTS\Singleton;

/**
 * Quick buy.
 */
class Redirect extends Singleton {
	/**
	 * Constructor.
	 */
	public function init() {
		add_filter( 'woocommerce_add_to_cart_redirect', array( $this, 'quick_buy_redirect' ), 99 );
		add_action( 'wp_loaded', array( $this, 'add_to_cart_action' ), 100 );
		add_filter( 'wc_add_to_cart_message_html', array( $this, 'update_add_to_cart_message' ), 10, 3 );
	}

	/**
	 * Quick buy action.
	 *
	 * @return void
	 */
	public function add_to_cart_action() {
		if ( ! isset( $_REQUEST['wd-add-to-cart'] ) || ! is_numeric( wp_unslash( $_REQUEST['wd-add-to-cart'] ) ) ) { //phpcs:ignore
			return;
		}

		if ( isset( $_REQUEST['variation_id'] ) && ! $_REQUEST['variation_id'] ) { //phpcs:ignore
			return;
		}

		if ( isset( $_REQUEST['quantity'] ) && is_array( $_REQUEST['quantity'] ) ) {
			foreach ( $_REQUEST['quantity'] as $quantity ) {
				if ( ! $quantity ) {
					return;
				}
			}
		}

		if ( ! isset( $_REQUEST['add-to-cart'] ) || $_REQUEST['add-to-cart'] !== $_REQUEST['wd-add-to-cart'] ) { //phpcs:ignore
			$_REQUEST['add-to-cart'] = $_REQUEST['wd-add-to-cart']; //phpcs:ignore
		}

		WC_Form_Handler::add_to_cart_action();
	}

	/**
	 * Update WooCommerce message when active buy now.
	 *
	 * @param string  $message Message.
	 * @param array   $products Product ID list or single product ID.
	 * @param integer $show_qty Should quantities be shown? Added in 2.6.0.
	 * @return string
	 */
	public function update_add_to_cart_message( $message, $products, $show_qty ) {
		if ( ! isset( $_REQUEST['wd-add-to-cart'] ) || ! is_numeric( wp_unslash( $_REQUEST['wd-add-to-cart'] ) ) ) { //phpcs:ignore
			return $message;
		}

		$titles = array();
		$count  = 0;

		foreach ( $products as $product_id => $qty ) {
			$titles[] = apply_filters( 'woocommerce_add_to_cart_qty_html', ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ), $product_id ) . apply_filters( 'woocommerce_add_to_cart_item_name_in_quotes', sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce' ), wp_strip_all_tags( get_the_title( $product_id ) ) ), $product_id );
			$count   += $qty;
		}

		$titles     = array_filter( $titles );
		$added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', $count, 'woocommerce' ), wc_format_list_of_items( $titles ) );

		$return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wc_get_raw_referer() ? wp_validate_redirect( wc_get_raw_referer(), false ) : wc_get_page_permalink( 'shop' ) );

		return sprintf( '<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', esc_url( $return_to ), esc_html__( 'Continue shopping', 'woocommerce' ), esc_html( $added_text ) );
	}

	/**
	 * Redirect user after quick buy button is submitted.
	 *
	 * @param string $url Url.
	 *
	 * @return string
	 */
	public function quick_buy_redirect( $url ) {
		if ( ! isset( $_REQUEST['wd-add-to-cart'] ) ) { //phpcs:ignore
			return $url;
		}

		$product_id = sanitize_text_field( $_REQUEST['wd-add-to-cart'] ); //phpcs:ignore
		$redirect   = $this->get_redirect_url( $product_id );

		if ( ! $redirect['url'] ) {
			return $url;
		}

		return $redirect['url'];
	}

	/**
	 * Fetches proper redirect url from DB and returns It.
	 *
	 * @param integer $product_id Product ID.
	 *
	 * @return array
	 */
	public function get_redirect_url( $product_id ) {
		$url      = array( 'url' => '' );
		$redirect = woodmart_get_opt( 'buy_now_redirect', 'checkout' );

		if ( 'cart' === $redirect ) {
			$url = array(
				'type' => 'internal',
				'url'  => wc_get_cart_url(),
			);
		} elseif ( 'checkout' === $redirect ) {
			$url = array(
				'type' => 'internal',
				'url'  => wc_get_checkout_url(),
			);
		}

		return $url;
	}
}

Redirect::get_instance();
