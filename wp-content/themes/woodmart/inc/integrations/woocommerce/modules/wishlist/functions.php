<?php
/**
 * Wishlist helper functions.
 */

use XTS\WC_Wishlist\Ui;
use XTS\WC_Wishlist\Wishlist;

if ( ! function_exists( 'woodmart_get_wishlist_page_url' ) ) {
	/**
	 * Get wishlist page url.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	function woodmart_get_wishlist_page_url() {
		$page_id = woodmart_get_opt( 'wishlist_page' );

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			$page_id = wpml_object_id_filter( $page_id, 'page', true );
		}

		return get_permalink( $page_id );
	}
}


if ( ! function_exists( 'woodmart_get_wishlist_count' ) ) {
	/**
	 * Get wishlist count.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	function woodmart_get_wishlist_count() {
		$count = 0;
		$ui    = Ui::get_instance();

		if ( $ui->get_wishlist() ) {
			$count = $ui->get_wishlist()->get_count();
		}

		return $count;
	}
}

if ( ! function_exists( 'woodmart_set_cookie' ) ) {
	/**
	 * Set cookies.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Name.
	 * @param string $value Value.
	 */
	function woodmart_set_cookie( $name, $value ) {
		$expire = time() + intval( apply_filters( 'woodmart_session_expiration', 60 * 60 * 24 * 7 ) );
		setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );
		$_COOKIE[ $name ] = $value;
	}
}

if ( ! function_exists( 'woodmart_get_cookie' ) ) {
	/**
	 * Get cookie.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Name.
	 *
	 * @return string
	 */
	function woodmart_get_cookie( $name ) {
		return isset( $_COOKIE[ $name ] ) ? sanitize_text_field( wp_unslash( $_COOKIE[ $name ] ) ) : false; // phpcs:ignore
	}
}

if ( ! function_exists( 'woodmart_get_wishlist_groups' ) ) {
	/**
	 * Get wishlist groups user.
	 *
	 * @return array
	 */
	function woodmart_get_wishlist_groups() {
		if ( ! woodmart_get_opt( 'wishlist_expanded' ) || ! is_user_logged_in() ) {
			return array();
		}

		global $wpdb;

		$wishlist = new Wishlist();
		$list     = array();

		$cache = get_user_meta( $wishlist->get_user_id(), 'woodmart_wishlist_groups', true );

		if ( ! $cache ) {
			$wishlist_groups = $wpdb->get_results(
				$wpdb->prepare(
					"	SELECT ID, wishlist_group
					FROM {$wpdb->prefix}woodmart_wishlists
					WHERE user_id = %d
					",
					$wishlist->get_user_id()
				),
				ARRAY_A
			);

			if ( $wishlist_groups ) {
				foreach ( $wishlist_groups as $wishlist_group ) {
					$list[ $wishlist_group['ID'] ] = $wishlist_group['wishlist_group'];
				}
			}

			update_user_meta( $wishlist->get_user_id(), 'woodmart_wishlist_groups', $list );
		} else {
			$list = (array) $cache;
		}

		return $list;
	}
}

if ( ! function_exists( 'woodmart_get_unsubscribe_link' ) ) {
	/**
	 * Get unsubscribe link by user ID.
	 *
	 * @param integer $user_id User ID.
	 *
	 * @return string
	 */
	function woodmart_get_unsubscribe_link( $user_id ) {
		$unsubscribe_token            = get_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token', true );
		$unsubscribe_token_expiration = get_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token_expiration', true );

		if ( ! $unsubscribe_token || ! $unsubscribe_token_expiration || $unsubscribe_token_expiration < time() ) {
			$unsubscribe_token            = wp_generate_password( 24, false );
			$unsubscribe_token_expiration = apply_filters( 'woodmart_send_wishlist_unsubscribe_token_expiration', time() + MONTH_IN_SECONDS, $unsubscribe_token );

			update_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token', $unsubscribe_token );
			update_user_meta( $user_id, 'woodmart_send_wishlist_unsubscribe_token_expiration', $unsubscribe_token_expiration );
		}

		return apply_filters( 'woodmart_send_wishlist_unsubscribe_url', add_query_arg( 'unsubscribe_send_wishlist_product', $unsubscribe_token, get_permalink( wc_get_page_id( 'shop' ) ) ), $user_id, $unsubscribe_token, $unsubscribe_token_expiration );
	}
}

if ( ! function_exists( 'woodmart_check_this_email_notification_is_enabled' ) ) {
	/**
	 * Check this email notification is enabled in woocommerce.
	 *
	 * @param string $option Name option.
	 * @param string $default Default option value. If the $option is not saved in the database, then $default will be taken.
	 *
	 * @return bool
	 */
	function woodmart_check_this_email_notification_is_enabled( $option, $default = 'no' ) {
		$settings   = get_option( $option, array() );
		$option_val = ! isset( $settings['enabled'] ) ? $default : $settings['enabled'];

		return 'yes' === $option_val || isset( $_GET['page'] ) && 'digthis-woocommerce-preview-emails' === $_GET['page'];
	}
}
