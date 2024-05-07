<?php
/**
 * Responsive Range slider.
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Responsive Range slider control.
 */
class Responsive_Range extends Field {


	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$value = $this->get_field_value();
		$data  = array();

		if ( ! empty( $value ) ) {
			if ( function_exists( 'woodmart_decompress' ) && woodmart_is_compressed_data( $value ) ) {
				$data = json_decode( woodmart_decompress( $value ), true );
			} else {
				$data['devices'] = array_replace_recursive(
					$this->args['devices'],
					array(
						'desktop' => array(
							'value' => $value,
						),
					)
				);
			}
		} else {
			$data['devices'] = $this->args['devices'];
		}
		$data['devices'] = array_merge( $this->args['devices'], $data['devices'] );

		?>
			<div class="xts-responsive-range-wrapper">
				<?php if ( $data['devices'] ) : ?>
					<div class="xts-responsive-range-devices">
						<?php if ( 1 < count( $data['devices'] ) ) : ?>
							<?php foreach ( $data['devices'] as $device => $device_settings ) : ?>
								<span class="xts-device<?php echo esc_attr( ' wd-' . $device ); ?><?php echo array_key_first( $data['devices'] ) === $device ? esc_attr( ' xts-active' ) : ''; ?>" data-value="<?php echo esc_attr( $device ); ?>">
									<span><?php echo esc_attr( $device ); ?></span>
								</span>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<?php foreach ( $data['devices'] as $device => $device_settings ) : ?>
						<?php
						$device_value = isset( $device_settings['value'] ) ? $device_settings['value'] : '';
						$device_unit  = isset( $device_settings['unit'] ) ? $device_settings['unit'] : '-';
						?>
						<div class="xts-responsive-range xts-range-slider-wrap <?php echo array_key_first( $data['devices'] ) === $device ? esc_attr( ' xts-active' ) : ''; ?>"  data-device="<?php echo esc_attr( $device ); ?>" data-value="<?php echo esc_attr( $device_value ); ?>" data-unit="<?php echo esc_attr( $device_unit ); ?>">
							<div class="xts-responsive-range-slider xts-range-slider"></div>
							<span class="xts-range-field-value-input">
								<input type="number" class="xts-range-field-value" value="<?php echo esc_attr( $device_value ); ?>">
							</span>

							<?php if ( ! empty( $this->args['range'] ) ) : ?>
								<span class="xts-slider-units">
									<?php foreach ( $this->args['range'] as $unit => $value ) : ?>
										<?php if ( '-' === $unit ) : ?>
											<?php continue; ?>
										<?php endif; ?>

										<span class="wd-slider-unit-control<?php echo esc_attr( $unit === $device_unit ? ' xts-active' : '' ); ?>" data-unit="<?php echo esc_attr( $unit ); ?>">
											<?php echo esc_html( $unit ); ?>
										</span>
									<?php endforeach; ?>
								</span>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<input type="hidden" class="xts-responsive-range-value" name="<?php echo esc_attr( $this->get_input_name() ); ?>" value="<?php echo function_exists( 'woodmart_compress' ) ? woodmart_compress( wp_json_encode( $data ) ) : ''; ?>" data-settings="<?php echo esc_attr( wp_json_encode( $this->args ) ); ?>">

		<?php
	}

	/**
	 * Output field's css code based on the settings.
	 *
	 * @since 1.0.0
	 *
	 * @return string $output Generated CSS code.
	 */
	public function css_output() {
		if ( empty( $this->args['selectors'] ) || empty( $this->get_field_value() ) || ! function_exists( 'woodmart_decompress' ) ) {
			return;
		}

		$value  = json_decode( woodmart_decompress( $this->get_field_value() ), true );
		$output = '';

		if ( empty( $value['devices'] ) ) {
			return;
		}

		foreach ( $value['devices'] as $device => $device_value ) {
			if ( ! $device_value || empty( $device_value['value'] ) ) {
				continue;
			}

			$output_css_selects = '';

			foreach ( $this->args['selectors'] as $selector => $css_data ) {
				$output_css_selects .= $selector . '{' . "\n";

				foreach ( $css_data as $css ) {
					$result = str_replace( '{{VALUE}}', $device_value['value'], $css );

					if ( isset( $device_value['unit'] ) ) {
						$result = str_replace( '{{UNIT}}', $device_value['unit'], $result );
					}

					$output_css_selects .= $result;
				}
				$output_css_selects .= "\n}";
			}

			$output .= $this->get_heading_css_attribute( $device, $output_css_selects );
		}

		return $output;
	}

	/**
	 * Print css heading.
	 *
	 * @param string $device Device.
	 * @param string $css CSS.
	 * @return string
	 */
	public function get_heading_css_attribute( $device, $css ) {
		if ( 'desktop' === $device ) {
			return $css;
		}

		if ( 'tablet' === $device ) {
			return "\n@media (max-width: 1199px) { \n $css \n}\n";
		}

		if ( 'mobile' === $device ) {
			return "\n@media (max-width: 767px) { \n $css \n}\n";
		}
	}

	/**
	 * Enqueue slider jquery ui.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_style( 'xts-jquery-ui', WOODMART_ASSETS . '/css/jquery-ui.css', array(), woodmart_get_theme_info( 'Version' ) );
	}
}


