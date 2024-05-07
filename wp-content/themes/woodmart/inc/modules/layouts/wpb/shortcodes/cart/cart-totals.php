<?php
/**
 * Cart totals shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_cart_totals' ) ) {
	/**
	 * Cart totals shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_cart_totals( $settings ) {
		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return '';
		}

		$default_settings = array(
			'button_alignment' => 'left',
			'css'              => '',
			'show_title'       => 'yes',
			'title_alignment'  => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' wd-btn-align-' . woodmart_vc_get_control_data( $settings['button_alignment'], 'desktop' );

		if ( 'yes' === $settings['show_title'] ) {
			$wrapper_classes .= ' wd-title-show';
		}

		if ( $settings['title_alignment'] ) {
			$wrapper_classes .= ' text-' . $settings['title_alignment'];
		}

		ob_start();

		Main::setup_preview();

		$nonce_value = wc_get_var( $_REQUEST['woocommerce-shipping-calculator-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

		// Update Shipping. Nonce check uses new value and old value (woocommerce-cart). @todo remove in 4.0.
		if ( ! empty( $_POST['calc_shipping'] ) && ( wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' ) ) ) { // WPCS: input var ok.
			$shortcode_cart = new WC_Shortcode_Cart();
			$shortcode_cart->calculate_shipping();
		}

		?>
		<div class="wd-cart-totals wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php wc()->cart->calculate_fees(); ?>
			<?php wc()->cart->calculate_shipping(); ?>
			<?php wc()->cart->calculate_totals(); ?>

			<?php woocommerce_cart_totals(); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
