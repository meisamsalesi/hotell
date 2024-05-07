<?php
/**
 * Gallery shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_gallery' ) ) {
	/**
	 * Gallery shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_gallery( $settings ) {
		$default_settings = array(
			'css'                               => '',
			'thumbnails_position'               => 'inherit',
			'thumbnails_left_vertical_columns'  => 'inherit',
			'thumbnails_bottom_columns_desktop' => 'inherit',
			'thumbnails_bottom_columns_tablet'  => 'inherit',
			'thumbnails_bottom_columns_mobile'  => 'inherit',
			'product_id'                        => false,
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		wp_enqueue_script( 'zoom' );
		wp_enqueue_script( 'wc-single-product' );

		Main::setup_preview( array(), $settings['product_id'] );

		?>
		<div class="wd-single-gallery wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php
			wc_get_template(
				'single-product/product-image.php',
				array(
					'builder_thumbnails_position'         => $settings['thumbnails_position'],
					'builder_thumbnails_vertical_columns' => $settings['thumbnails_left_vertical_columns'],
					'builder_thumbnails_columns_desktop'  => $settings['thumbnails_bottom_columns_desktop'],
					'builder_thumbnails_columns_tablet'   => $settings['thumbnails_bottom_columns_tablet'],
					'builder_thumbnails_columns_mobile'   => $settings['thumbnails_bottom_columns_mobile'],
				)
			);
			?>
		</div>
		<?php

		Main::restore_preview( $settings['product_id'] );

		return ob_get_clean();
	}
}
