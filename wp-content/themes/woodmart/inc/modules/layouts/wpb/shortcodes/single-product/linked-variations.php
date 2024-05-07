<?php
use XTS\Modules\Layouts\Main;
use XTS\Modules\Linked_Variations\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_linked_variations' ) ) {
	/**
	 * Single product linked variations shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_linked_variations( $settings ) {
		$default_settings = array(
			'css'            => '',
			'alignment'      => 'left',
			'layout'         => 'default',
			'label_position' => 'side',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes  = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );
		$wrapper_classes .= ' wd-wpb';

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );
		$wrapper_classes .= ' wd-swatch-layout-' . $settings['layout'];
		$wrapper_classes .= ' wd-label-' . woodmart_vc_get_control_data( $settings['label_position'], 'desktop' ) . '-lg';
		$wrapper_classes .= ' wd-label-' . woodmart_vc_get_control_data( $settings['label_position'], 'mobile' ) . '-md';

		ob_start();

		Main::setup_preview();

		Frontend::get_instance()->output( $wrapper_classes );

		Main::restore_preview();

		return ob_get_clean();
	}
}
