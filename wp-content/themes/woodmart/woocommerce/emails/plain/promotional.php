<?php
/**
 * Customer "promotional" email.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo esc_html( wp_strip_all_tags( $email_heading ) );
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html( wp_strip_all_tags( $email_content ) );

echo "\n----------------------------------------\n\n";

echo esc_html__( sprintf( 'If you don\'t want to receive any further notification, please follow this link %s', woodmart_get_unsubscribe_link( $email->user->ID ) ), 'woodmart' );

echo "\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
