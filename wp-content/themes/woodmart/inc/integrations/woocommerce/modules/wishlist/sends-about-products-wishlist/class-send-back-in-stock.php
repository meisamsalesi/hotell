<?php
/**
 * Send about products wishlists.
 *
 * @package XTS
 */

namespace XTS\WC_Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Singleton;

/**
 * Send about products wishlists.
 *
 * @since 1.0.0
 */
class Sends_Back_In_Stock extends Singleton {
	/**
	 * Name unsubscribed users option.
	 *
	 * @var string
	 */
	private $unsubscribed_users = 'woodmart_wishlist_unsubscribed_users';

	/**
	 * Init.
	 */
	public function init() {
		add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );

		add_action( 'woocommerce_product_set_stock_status', array( $this, 'schedule_back_in_stock_emails' ), 10, 3 );
		add_action( 'woocommerce_variation_set_stock_status', array( $this, 'schedule_back_in_stock_emails' ), 10, 3 );

		add_action( 'woodmart_remove_product_from_wishlist', array( $this, 'remove_product_from_lists' ) );

		add_action( 'woodmart_wishlist_send_back_in_stock_email', array( $this, 'send_back_in_stock_email' ) );

		if ( ! wp_next_scheduled( 'woodmart_wishlist_send_back_in_stock_email' ) ) {
			wp_schedule_event( time(), apply_filters( 'woodmart_schedule_send_back_in_stock_email', 'hourly' ), 'woodmart_wishlist_send_back_in_stock_email' );
		}
	}

	/**
	 * Load woocommerce mailer.
	 */
	public function load_wc_mailer() {
		add_action( 'woodmart_send_back_in_stock_mail', array( 'WC_Emails', 'send_transactional_email' ), 10, 2 );
	}

	/**
	 * Send back in stock product.
	 */
	public function send_back_in_stock_email() {
		$products_back_in_stock = get_option( 'woodmart_wishlist_products_back_in_stock' );

		if ( ! $products_back_in_stock ) {
			return;
		}

		$unsubscribed_users = get_option( $this->unsubscribed_users, array() );
		$emails_limited     = apply_filters( 'woodmart_wishlist_send_emails_limited', 20 );
		$counter            = 1;

		foreach ( $products_back_in_stock as $user_id => $product_list ) {
			if ( ! $user_id || ! $product_list || in_array( get_userdata( $user_id )->user_email, $unsubscribed_users, true ) ) {
				continue;
			}

			do_action( 'woodmart_send_back_in_stock_mail', $user_id, $product_list );

			unset( $products_back_in_stock[ $user_id ] );

			if ( ++$counter > $emails_limited ) {
				break;
			}
		}

		update_option( 'woodmart_wishlist_products_back_in_stock', $products_back_in_stock );
	}

	/**
	 * Save back in stock status product.
	 *
	 * @param integer $product_id Product ID.
	 * @param string  $stock_status Stock status product.
	 * @param object  $product Data product.
	 *
	 * @return void
	 */
	public function schedule_back_in_stock_emails( $product_id, $stock_status, $product ) {
		if ( 'instock' !== $stock_status ) {
			return;
		}

		$users_id               = $this->get_users_id_by_product_id( $product_id );
		$products_back_in_stock = get_option( 'woodmart_wishlist_products_back_in_stock', array() );
		$unsubscribed_users     = get_option( $this->unsubscribed_users, array() );

		if ( ! $users_id ) {
			return;
		}

		foreach ( $users_id as $user_id ) {
			if ( ( isset( $products_back_in_stock[ $user_id ] ) && in_array( $product_id, $products_back_in_stock[ $user_id ], true ) ) || ( in_array( get_userdata( $user_id )->user_email, $unsubscribed_users, true ) ) ) {
				continue;
			}

			$products_back_in_stock[ $user_id ][] = $product_id;
		}

		update_option( 'woodmart_wishlist_products_back_in_stock', $products_back_in_stock );
	}

	/**
	 * Get users ID what added this product.
	 *
	 * @param integer $product_id Product ID.
	 *
	 * @return array
	 */
	public function get_users_id_by_product_id( $product_id ) {
		global $wpdb;

		return $wpdb->get_col(
			$wpdb->prepare(
				"SELECT user_id FROM $wpdb->woodmart_wishlists_table INNER JOIN $wpdb->woodmart_products_table ON wishlist_id = $wpdb->woodmart_wishlists_table.ID WHERE product_id = %d",
				$product_id
			)
		);
	}

	/**
	 * Remove product from send back in stock lists.
	 *
	 * @param integer $product_id Product ID.
	 * @return void
	 */
	public function remove_product_from_lists( $product_id ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		$product_ids_back_in_stock = get_option( 'woodmart_wishlist_products_back_in_stock' );
		$user_id                   = get_current_user_id();

		if ( isset( $product_ids_back_in_stock[ $user_id ] ) ) {
			$key = array_search( $product_id, $product_ids_back_in_stock[ $user_id ], true );

			if ( $key || 0 === $key ) {
				unset( $product_ids_back_in_stock[ $user_id ][ $key ] );

				if ( ! $product_ids_back_in_stock[ $user_id ] ) {
					unset( $product_ids_back_in_stock[ $user_id ] );
				}

				update_option( 'woodmart_wishlist_products_back_in_stock', $product_ids_back_in_stock );
			}
		}
	}
}

Sends_Back_In_Stock::get_instance();
