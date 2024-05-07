<?php
/**
 * Stock status shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_stock_status' ) ) {
	/**
	 * Single product stock status shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_stock_status( $settings ) {
		$default_settings = array(
			'css' => '',
		);
		$settings         = wp_parse_args( $settings, $default_settings );
		$wrapper_classes  = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		Main::setup_preview();
			global $product;

			woodmart_enqueue_js_script( 'stock-status' );
			?>
				<div class="wd-single-stock-status wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
					<?php if ( ! $product->is_type( 'variable' ) ) : ?>
						<?php echo wc_get_stock_html( $product ); ?>
					<?php endif; ?>
				</div>
			<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
