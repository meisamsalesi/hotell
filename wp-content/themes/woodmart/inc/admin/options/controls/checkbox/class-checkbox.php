<?php
/**
 * Checkbox control.
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Checkbox field control.
 */
class Checkbox extends Field {

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$on_text  = isset( $this->args['on-text'] ) ? $this->args['on-text'] : esc_html__( 'On', 'woodmart' );
		$off_text = isset( $this->args['off-text'] ) ? $this->args['off-text'] : esc_html__( 'Off', 'woodmart' );

		?>
		<div class="xts-switcher-btn<?php echo esc_attr( ( $this->is_activated() ) ? ' xts-active' : '' ); ?>" data-on="on" data-off="">
			<div class="xts-switcher-dot-wrap">
				<div class="xts-switcher-dot"></div>
			</div>
			<div class="xts-switcher-labels">
				<span class="xts-switcher-label xts-on">
					<?php echo esc_html( $on_text ); ?>
				</span>

				<span class="xts-switcher-label xts-off">
					<?php echo esc_html( $off_text ); ?>
				</span>
			</div>
		</div>
		<input type="hidden" name="<?php echo esc_attr( $this->get_input_name() ); ?>" value="<?php echo esc_attr( $this->get_field_value() ); ?>"/>
		<?php
	}


	/**
	 * Check if the value corresponds to "on" state.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	private function is_activated() { // phpcs:ignore
		return 'on' === $this->get_field_value();
	}
}


