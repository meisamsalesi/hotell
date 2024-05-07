<?php
/**
 * This file creates html for the woodmart_switch field in WPBakery.
 *
 * @package Woodmart.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
* Woodmart switch param
*/
if ( ! function_exists( 'woodmart_get_switch_param' ) ) {
	/**
	 * This function creates html for the woodmart_switch field in WPBakery.
	 *
	 * @param array $settings .
	 * @param array $value .
	 * @return string
	 */
	function woodmart_get_switch_param( $settings, $value ) {
		if ( '0' === $value ) {
			$value = 0;
		} elseif ( empty( $value ) && isset( $settings['default'] ) ) {
			$value = $settings['default'];
		}

		$settings['true_text']  = isset( $settings['true_text'] ) ? $settings['true_text'] : esc_html__( 'Yes', 'woodmart' );
		$settings['false_text'] = isset( $settings['false_text'] ) ? $settings['false_text'] : esc_html__( 'No', 'woodmart' );

		ob_start();
		?>
		<div class="xts-switcher-btn<?php echo esc_attr( (string) $value === (string) $settings['true_state'] ? ' xts-active' : '' ); ?>" data-on="<?php echo esc_attr( $settings['true_state'] ); ?>" data-off="<?php echo esc_attr( $settings['false_state'] ); ?>">
			<input type="hidden" class="switch-field-value wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>">
			<div class="xts-switcher-dot-wrap">
				<div class="xts-switcher-dot"></div>
			</div>
			<div class="xts-switcher-labels">
				<span class="xts-switcher-label xts-on">
					<?php echo esc_html( $settings['true_text'] ); ?>
				</span>

				<span class="xts-switcher-label xts-off">
					<?php echo esc_html( $settings['false_text'] ); ?>
				</span>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}
