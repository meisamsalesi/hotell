<?php
/**
 * Visitor counter shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

use XTS\Modules\Visitor_Counter\Main as Counter_Visitors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_visitor_counter' ) ) {
	/**
	 * Single product visitor counter shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_visitor_counter( $settings ) {
		$default_settings = array(
			'css'   => '',
			'style' => 'default',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$extra_classes = ' wd-style-' . $settings['style'];

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php Counter_Visitors::get_instance()->output_count_visitors( $extra_classes ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
