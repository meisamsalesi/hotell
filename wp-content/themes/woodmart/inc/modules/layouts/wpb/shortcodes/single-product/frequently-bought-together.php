<?php
/**
 * Frequently bought together shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Frequently_Bought_Together\Frontend;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_fbt_products' ) ) {
	/**
	 * Single product frequently bought together shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_fbt_products( $settings ) {
		$default_settings = array(
			'css'                    => '',
			'slides_per_view'        => '3',
			'slides_per_view_tablet' => 'auto',
			'slides_per_view_mobile' => 'auto',
			'form_width'             => '',
			'is_builder'             => true,
		);

		if ( ! woodmart_get_opt( 'bought_together_enabled', 1 ) ) {
			return '';
		}

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		Main::setup_preview();
		?>
		<div class="wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>"><?php Frontend::get_instance()->get_bought_together_products( $settings ); // Must be in one line. ?></div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
