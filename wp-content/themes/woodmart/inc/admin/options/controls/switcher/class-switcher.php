<?php
/**
 * Switcher form control "on/off".
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Switcher field control.
 */
class Switcher extends Field {

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

		$val = $this->get_field_value();

		if ( empty( $val ) ) {
			$val = 0;
		}

		?>
		<div class="xts-switcher-btn<?php echo esc_attr( ( $this->is_activated() ) ? ' xts-active' : '' ); ?>" data-on="1" data-off="0">
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

		<?php if ( ! empty( $this->args['notices'] ) ) : ?>
			<div class="xts-field-notice xts-hidden">
				<?php foreach ( $this->args['notices'] as $type => $content ) : ?>
					<div class="xts-notice xts-<?php echo esc_attr( $type ); ?>">
						<?php echo wp_kses( $content, true ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<input type="hidden" name="<?php echo esc_attr( $this->get_input_name() ); ?>" value="<?php echo esc_attr( $val ); ?>"/>
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
		return '1' == $this->get_field_value() || 'yes' == $this->get_field_value();
	}
}
