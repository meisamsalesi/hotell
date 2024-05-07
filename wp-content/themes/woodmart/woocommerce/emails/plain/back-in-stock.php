<?php
/**
 * Customer "back in stock" email
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo esc_html( wp_strip_all_tags( $email_heading ) );
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html__( sprintf( 'Hi, %s!', $email->user->user_login ), 'woodmart' ) . "\n";

echo esc_html__( 'The product on your wishlist is back in stock!', 'woodmart' ) . "\n\n";

if ( $product_lists ) {
	echo "------------------------------------------\n\n";

	foreach ( $product_lists as $product ) {
		echo esc_html( wp_strip_all_tags( sprintf( '%1$s (%2$s) [%3$s]', $product->get_title(), wc_price( $product->get_price() ), $product->get_permalink() ) ) ) . "\n";
	}

	echo "\n------------------------------------------\n\n";
}

echo esc_html__( 'We only have limited stock, so don\'t wait any longer, and take this chance to make it yours!', 'woodmart' );

echo "\n\n****************************************************\n\n";

echo esc_html__( sprintf( 'If you don\'t want to receive any further notification, please follow this link %s', woodmart_get_unsubscribe_link( $email->user->ID ) ), 'woodmart' );

echo "\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
