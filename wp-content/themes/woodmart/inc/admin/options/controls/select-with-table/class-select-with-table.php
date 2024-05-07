<?php
/**
 * HTML dropdown select control.
 *
 * @package woodmart
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Switcher field control.
 */
class Select_With_Table extends Field {
	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$value = $this->get_field_value();

		?>
		<div class="xts-item-template xts-hidden">
			<div class="xts-bundle">
				<div class="xts-bundle-name">
					<?php $this->get_select( '', $this->get_input_name() . '[{{index}}][id]' ); ?>
				</div>
				<div class="xts-bundle-discount">
					<div class="xts-input-append">
						<input type="number" min="0" max="100" name="<?php echo esc_attr( $this->get_input_name() . '[{{index}}][discount]' ); ?>">
						<span class="add-on">%</span>
					</div>
				</div>
				<div class="xts-bundle-close">
					<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
				</div>
			</div>
		</div>
		<div class="xts-controls-wrapper">
			<div class="xts-bundle">
				<div class="xts-bundle-name">
					<label><?php esc_html_e( 'Products', 'woodmart' ); ?></label>
				</div>
				<div class="xts-bundle-discount">
				<label><?php esc_html_e( 'Discount', 'woodmart' ); ?></label>
				</div>
			</div>
			<?php if ( $value ) : ?>
				<?php foreach ( $value as $id => $product ) : ?>
					<div class="xts-bundle">
						<div class="xts-bundle-name">
							<?php $this->get_select( $product['id'], $this->get_input_name() . '[' . $id . '][id]' ); ?>
						</div>
						<div class="xts-bundle-discount">
							<div class="xts-input-append">
								<input type="number" min="0" max="100" step="0.01" name="<?php echo esc_attr( $this->get_input_name() . '[' . $id . '][discount]' ); ?>" value="<?php echo esc_attr( $product['discount'] ); ?>">
								<span class="add-on">%</span>
							</div>
						</div>
						<div class="xts-bundle-close">
							<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<a href="#" class="xts-add-row xts-inline-btn xts-color-primary xts-i-add">
			<?php esc_html_e( 'Add new product', 'woodmart' ); ?>
		</a>

		<?php
	}

	/**
	 * Get select control.
	 *
	 * @param string $value Value.
	 * @param string $name Name.
	 *
	 * @return void
	 */
	protected function get_select( $value, $name ) {
		$classes = ' xts-select2';

		$autocomplete_type   = $this->args['autocomplete']['type'];
		$autocomplete_value  = $this->args['autocomplete']['value'];
		$autocomplete_search = $this->args['autocomplete']['search'];

		$classes    .= ' xts-autocomplete';
		$attributes  = ' data-type="' . $autocomplete_type . '"';
		$attributes .= ' data-value=\'' . $autocomplete_value . '\'';
		$attributes .= ' data-search="' . $autocomplete_search . '"';

		$options = $this->args['autocomplete']['render']( $value );

		?>
		<select class="xts-select<?php echo esc_attr( $classes ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php echo $attributes; // phpcs:ignore ?> aria-label="<?php echo esc_attr( $this->get_input_name() ); ?>">
			<?php foreach ( $options as $option ) : ?>
				<?php
				$selected = false;

				if ( is_array( $value ) && in_array( $option['value'], $value, false ) ) { // phpcs:ignore
					$selected = true;
				} elseif ( ! is_array( $value ) && strval( $value ) === strval( $option['value'] ) ) {
					$selected = true;
				}

				?>
				<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( true, $selected ); ?>><?php echo esc_html( $option['name'] ); ?></option>
			<?php endforeach ?>
		</select>
		<?php
	}

	/**
	 * Enqueue lib.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'select2', WOODMART_ASSETS . '/js/libs/select2.full.min.js', array(), woodmart_get_theme_info( 'Version' ), true );
	}
}
