<?php
/**
 * Coupon form shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_checkout_coupon_form' ) ) {
	/**
	 * Coupon form shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_checkout_coupon_form( $settings ) {
		if ( ( ! is_user_logged_in() || ! WC()->checkout()->is_registration_enabled() || WC()->checkout()->is_registration_required() ) && ! wc_coupons_enabled() ) {
			return '';
		}

		$default_settings = array(
			'alignment' => '',
			'css'       => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( $settings['alignment'] ) {
			$wrapper_classes .= ' text-' . $settings['alignment'];
		}

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-checkout-coupon wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-checkout-coupon-inner">
				<?php if ( function_exists( 'wc_print_notice' ) ) : ?>
					<?php woocommerce_checkout_coupon_form(); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
