<?php
/**
 * Send on sales products wishlists.
 *
 * @package XTS
 */

namespace XTS\WC_Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Singleton;

/**
 * Send on sales products wishlists.
 *
 * @since 1.0.0
 */
class Send_On_Sales_Products extends Singleton {
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
		$this->register_crons();

		add_action( 'init', array( $this, 'upgrade_database_wishlist' ) );

		add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );
		add_action( 'woodmart_remove_product_from_wishlist', array( $this, 'remove_product_from_lists' ) );
	}

	/**
	 * Register crons.
	 */
	public function register_crons() {
		$crons = array();

		$crons['woodmart_wishlist_register_on_sales_products'] = array(
			'schedule' => apply_filters( 'woodmart_schedule_register_on_sales_products', 'daily' ),
			'callback' => array( $this, 'register_on_sales_products' ),
		);
		$crons['woodmart_wishlist_on_sales_products_email']    = array(
			'schedule' => apply_filters( 'woodmart_schedule_on_sales_products_email', 'hourly' ),
			'callback' => array( $this, 'send_on_sales_products_email' ),
		);

		if ( $crons ) {
			foreach ( $crons as $hook => $data ) {
				add_action( $hook, $data['callback'] );

				if ( ! wp_next_scheduled( $hook ) ) {
					wp_schedule_event( time(), $data['schedule'], $hook );
				}
			}
		}
	}

	/**
	 * Load woocommerce mailer.
	 */
	public function load_wc_mailer() {
		add_action( 'woodmart_send_on_sale_products_mail', array( 'WC_Emails', 'send_transactional_email' ), 10, 2 );
	}

	/**
	 * Register on sale products.
	 *
	 * @return void
	 */
	public function register_on_sales_products() {
		$products_id_on_sale       = wc_get_product_ids_on_sale();
		$products_id_on_sale_in_db = $this->get_product_id_which_on_sale();
		$products_on_sales         = get_option( 'woodmart_wishlist_products_on_sale', array() );
		$unsubscribed_users        = get_option( $this->unsubscribed_users, array() );

		if ( $products_id_on_sale_in_db ) {
			foreach ( $products_id_on_sale_in_db as $product_id ) {
				if ( ! in_array( $product_id, $products_id_on_sale ) ) { //phpcs:ignore
					$this->update_on_sale_for_product( $product_id, false );
				}
			}
		}

		if ( $products_id_on_sale ) {
			foreach ( $products_id_on_sale as $product_id_sale ) {
				if ( ! in_array( $product_id_sale, $products_id_on_sale_in_db ) ) { //phpcs:ignore
					$this->update_on_sale_for_product( $product_id_sale, true );
					$users_id = $this->get_users_id_by_product_id( $product_id_sale );

					if ( $users_id ) {
						foreach ( $users_id as $user_id ) {
							if ( in_array( get_userdata( $user_id )->user_email, $unsubscribed_users, true ) || ! empty( $products_on_sales[ $user_id ] ) && in_array( $products_on_sales, $products_on_sales[ $user_id ], true ) ) {
								continue;
							}

							$products_on_sales[ $user_id ][] = $product_id_sale;
						}
					}
				}
			}

			update_option( 'woodmart_wishlist_products_on_sale', $products_on_sales );
		}
	}

	/**
	 * Send sales product in email.
	 *
	 * @return void
	 */
	public function send_on_sales_products_email() {
		$products_on_sales  = get_option( 'woodmart_wishlist_products_on_sale' );
		$unsubscribed_users = get_option( $this->unsubscribed_users, array() );
		$emails_limited     = apply_filters( 'woodmart_wishlist_send_emails_limited', 20 );
		$counter            = 1;

		if ( ! $products_on_sales ) {
			return;
		}

		foreach ( $products_on_sales as $user_id => $products ) {
			if ( ! $user_id || ! $products ) {
				continue;
			}

			if ( in_array( get_userdata( $user_id )->user_email, $unsubscribed_users, true ) ) {
				unset( $products_on_sales[ $user_id ] );
				continue;
			}

			do_action( 'woodmart_send_on_sale_products_mail', $user_id, $products );

			unset( $products_on_sales[ $user_id ] );

			if ( ++$counter > $emails_limited ) {
				break;
			}
		}

		update_option( 'woodmart_wishlist_products_on_sale', $products_on_sales );
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
	 * Get product ID which on sale.
	 *
	 * @return array
	 */
	public function get_product_id_which_on_sale() {
		global $wpdb;

		return $wpdb->get_col(
			$wpdb->prepare(
				"SELECT product_id FROM $wpdb->woodmart_products_table WHERE on_sale = %d",
				1
			)
		);
	}

	/**
	 * Update on sale product.
	 *
	 * @param integer $product_id Product ID.
	 * @param boolean $on_sale Is sale product.
	 *
	 * @return bool|int
	 */
	public function update_on_sale_for_product( $product_id, $on_sale ) {
		global $wpdb;

		return $wpdb->update(
			$wpdb->woodmart_products_table,
			array(
				'on_sale' => $on_sale,
			),
			array(
				'product_id' => $product_id,
			),
		);
	}

	/**
	 * Upgrade wishlist database.
	 *
	 * @return void
	 */
	public function upgrade_database_wishlist() {
		if ( get_option( 'woodmart_added_column_on_sale_in_product_db' ) ) {
			return;
		}

		global $wpdb;

		$wpdb->query( "ALTER TABLE {$wpdb->woodmart_wishlists_table} ADD COLUMN on_sale boolean DEFAULT 0 NOT NULL AFTER date_added" );

		update_option( 'woodmart_added_column_on_sale_in_product_db', true );
	}

	/**
	 * Remove product on sale.
	 *
	 * @param integer $product_id Product ID.
	 * @return void
	 */
	public function remove_product_from_lists( $product_id ) {
		if ( ! is_user_logged_in() ) {
			return;
		}

		$products_ids_on_sale = get_option( 'woodmart_wishlist_products_on_sale' );
		$user_id              = get_current_user_id();

		if ( isset( $products_ids_on_sale[ $user_id ] ) ) {
			$key = array_search( $product_id, $products_ids_on_sale[ $user_id ], true );

			if ( $key || 0 === $key ) {
				unset( $products_ids_on_sale[ $user_id ][ $key ] );

				if ( ! $products_ids_on_sale[ $user_id ] ) {
					unset( $products_ids_on_sale[ $user_id ] );
				}

				update_option( 'woodmart_wishlist_products_on_sale', $products_ids_on_sale );
			}
		}
	}
}

Send_On_Sales_Products::get_instance();
