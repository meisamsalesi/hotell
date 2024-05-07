<?php
/**
 * Meta shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_meta' ) ) {
	/**
	 * Single product meta.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_meta( $settings ) {
		$default_settings = array(
			'alignment'       => 'left',
			'css'             => '',
			'layout'          => 'default',
			'show_sku'        => 'yes',
			'show_categories' => 'yes',
			'show_tags'       => 'yes',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( 'justify' !== $settings['layout'] ) {
			$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );
		}

		$product_meta_classes = ' wd-layout-' . $settings['layout'];

		ob_start();

		Main::setup_preview();

		?>
		<div class="wd-single-meta wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php
			wc_get_template(
				'single-product/meta.php',
				array(
					'builder_meta_classes' => $product_meta_classes,
					'show_sku'             => $settings['show_sku'],
					'show_categories'      => $settings['show_categories'],
					'show_tags'            => $settings['show_tags'],
				)
			);
			?>
			</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
