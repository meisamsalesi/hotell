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
class Sends_About_Products_Wishlists extends Singleton {
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
		if ( ! woodmart_woocommerce_installed() ) {
			return;
		}

		$this->include_files();

		add_action( 'init', array( $this, 'unsubscribe_user' ) );

		add_filter( 'woocommerce_email_classes', array( $this, 'add_woocommerce_emails' ) );
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		if ( woodmart_check_this_email_notification_is_enabled( 'woocommerce_woodmart_back_in_stock_email_settings' ) ) {
			require_once XTS_WISHLIST_DIR . 'sends-about-products-wishlist/class-send-back-in-stock.php';
		}

		if ( woodmart_check_this_email_notification_is_enabled( 'woocommerce_woodmart_on_sale_products_email_settings' ) ) {
			require_once XTS_WISHLIST_DIR . 'sends-about-products-wishlist/class-send-on-sales-products.php';
		}

		if ( woodmart_check_this_email_notification_is_enabled( 'woocommerce_woodmart_promotional_email_settings', 'yes' ) ) {
			require_once XTS_WISHLIST_DIR . 'sends-about-products-wishlist/class-send-promotional.php';
		}

	}

	/**
	 * Add woocommerce emails.
	 *
	 * @param array $emails Woocommerce emails.
	 *
	 * @return array
	 */
	public function add_woocommerce_emails( $emails ) {
		$emails['woodmart_wishlist_back_in_stock']    = include XTS_WISHLIST_DIR . '/emails/class-back-in-stock-email.php';
		$emails['woodmart_wishlist_on_sale_products'] = include XTS_WISHLIST_DIR . '/emails/class-on-sale-products-email.php';
		$emails['woodmart_promotional_email']         = include XTS_WISHLIST_DIR . '/emails/class-promotional-email.php';

		return $emails;
	}

	/**
	 * Unsubscribe from mailing lists for wishlist plugin
	 *
	 * @return void
	 */
	public function unsubscribe_user() {
		if ( ! isset( $_GET['unsubscribe_send_wishlist_product'] ) ) { //phpcs:ignore
			return;
		}

		$unsubscribe_token = woodmart_clean( $_GET['unsubscribe_send_wishlist_product'] ); //phpcs:ignore

		if ( ! is_user_logged_in() ) {
			wc_add_notice( esc_html__( 'Please, log in to continue with the unsubscribe process', 'woodmart' ), 'notice' );
			wp_safe_redirect( add_query_arg( 'redirect_to', esc_url( add_query_arg( $_GET, get_home_url() ) ), wc_get_page_permalink( 'myaccount' ) ) );
			exit();
		}

		$redirect = apply_filters( 'woodmart_wishlist_after_unsubscribe_redirect', get_permalink( wc_get_page_id( 'shop' ) ) );

		$user_id                      = get_current_user_id();
		$user                         = wp_get_current_user();
		$user_unsubscribe_token       = get_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token', true );
		$unsubscribe_token_expiration = get_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token_expiration', true );

		if ( $unsubscribe_token !== $user_unsubscribe_token ) {
			wc_add_notice( esc_html__( 'The token provided does not match the current user; make sure to log in with the right account', 'woodmart' ), 'notice' );
			wp_safe_redirect( $redirect );
			exit();
		}

		if ( $unsubscribe_token_expiration < time() ) {
			wc_add_notice( esc_html__( 'The token provided is expired; contact us to so we can manually unsubscribe your from the list', 'woodmart' ), 'notice' );
			wp_safe_redirect( $redirect );
			exit();
		}

		$unsubscribed_users = get_option( $this->unsubscribed_users, array() );

		if ( ! in_array( $user->user_email, $unsubscribed_users, true ) ) {
			$unsubscribed_users[] = $user->user_email;

			update_option( $this->unsubscribed_users, $unsubscribed_users );

			delete_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token' );
			delete_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token_expiration' );
		}

		wc_add_notice( esc_html__( 'You have unsubscribed from our wishlist-related mailing lists', 'woodmart' ), 'success' );
		wp_safe_redirect( $redirect );
		exit();
	}
}

Sends_About_Products_Wishlists::get_instance();
