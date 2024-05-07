<?php
/**
 * Shipping progress bar shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_shipping_progress_bar' ) ) {
	/**
	 * Shipping progress bar shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_shipping_progress_bar( $settings ) {
		$default_settings = array(
			'css'       => '',
			'alignment' => 'left',
			'style'     => 'bordered',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );
		$wrapper_classes .= ' wd-style-' . $settings['style'];

		ob_start();

		Main::setup_preview();

		woodmart_enqueue_inline_style( 'woo-opt-free-progress-bar' );
		woodmart_enqueue_inline_style( 'woo-mod-progress-bar' );

		?>
		<div class="wd-shipping-progress-bar wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>"><?php Shipping_Progress_Bar_Module::get_instance()->render_shipping_progress_bar(); // Must be in one line. ?></div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
