<?php
/**
 * Send promotional wishlists.
 *
 * @package XTS
 */

namespace XTS\WC_Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Singleton;

/**
 * Send promotional wishlists.
 *
 * @since 1.0.0
 */
class Sends_Promotional extends Singleton {
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

		add_action( 'woodmart_wishlist_send_promotional_email', array( $this, 'send_promotional_email' ) );

		if ( ! wp_next_scheduled( 'woodmart_wishlist_send_promotional_email' ) ) {
			wp_schedule_event( time(), apply_filters( 'woodmart_schedule_send_promotional_email', 'hourly' ), 'woodmart_wishlist_send_promotional_email' );
		}
	}

	/**
	 * Load woocommerce mailer.
	 */
	public function load_wc_mailer() {
		add_action( 'woodmart_send_promotional_mail', array( 'WC_Emails', 'send_transactional_email' ), 10, 4 );
	}

	/**
	 * Send promotional product.
	 */
	public function send_promotional_email() {
		$promotion_data = get_option( 'woodmart_promotion_data', array() );

		if ( ! $promotion_data ) {
			return;
		}

		$emails_limited = apply_filters( 'woodmart_wishlist_send_emails_limited', 20 );
		$counter        = 0;
		$unsubscribed_users = get_option( $this->unsubscribed_users, array() );

		foreach ( $promotion_data as $id => $data ) {
			foreach ( $data['users_products'] as $user_id => $product_list ) {
				$is_unsubscribed_users = in_array( get_userdata( $user_id )->user_email, $unsubscribed_users, true );

				if ( ! $user_id || ! $product_list || $is_unsubscribed_users ) {
					if ( $is_unsubscribed_users ) {
						unset( $promotion_data[$id]['users_products'][ $user_id ] );
					}

					continue;
				}

				if ( ++$counter > $emails_limited ) {
					break;
				}

				do_action( 'woodmart_send_promotional_mail', $user_id, $product_list,  $data['content_html'], $data['content_text'] );

				unset( $promotion_data[$id]['users_products'][ $user_id ] );
			}

			if ( empty( $promotion_data[$id]['users_products'] ) ) {
				unset( $promotion_data[$id] );
			}
		}

		update_option( 'woodmart_promotion_data', $promotion_data );
	}

	/**
	 * Update promotion data.
	 */
	public static function update_promotion_data( $users_products ) {
		$promotion_data = get_option( 'woodmart_promotion_data', array() );

		if ( ! is_array( $users_products ) || empty( $users_products ) || ! is_array( $promotion_data ) ) {
			return;
		}

		$mailer         = WC()->mailer();
		$email          = $mailer->emails['woodmart_promotional_email'];
		$is_create      = false;

		if ( ! empty( $promotion_data ) ) {
			foreach ( $promotion_data as $id => $data ) {
				if ( $data['content_html'] === $email->get_option( 'content_html' ) ) {
					foreach ( array_keys( $users_products ) as $user_id ) {
						if ( in_array( $user_id , array_keys( $data['users_products'] ) ) ) {
							if ( ! is_array( $promotion_data[$id]['users_products'][$user_id] ) && $promotion_data[$id]['users_products'][$user_id] !== $users_products[ $user_id ] ) {
								$promotion_data[$id]['users_products'][$user_id] = array( $promotion_data[$id]['users_products'][$user_id], $users_products[ $user_id ] );

								$is_create = true;
							} else if ( is_array( $promotion_data[$id]['users_products'][$user_id] ) && ! in_array( $users_products[ $user_id ], $promotion_data[$id]['users_products'][$user_id] ) ) {
								$promotion_data[$id]['users_products'][$user_id][] = $users_products[ $user_id ];

								$is_create = true;
							}

							continue;
						}

						$promotion_data[$id]['users_products'][$user_id] = $users_products[ $user_id ];
						$is_create = true;
					}

					break;
				}
			}
		}

		if ( empty( $promotion_data ) || ! $is_create ) {
			$promotion_data[] = array(
				'users_products' => $users_products,
				'content_html'   => $email->get_option( 'content_html' ),
				'content_text'   => $email->get_option( 'content_text' ),
			);
		}

		update_option( 'woodmart_promotion_data', $promotion_data );
	}
}

Sends_Promotional::get_instance();
