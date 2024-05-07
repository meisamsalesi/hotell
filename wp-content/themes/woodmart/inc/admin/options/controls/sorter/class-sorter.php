<?php
/**
 * Reset control.
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Textarea field control.
 */
class Sorter extends Field {
	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$value           = $this->get_field_value();
		$default_options = $this->args['options'];
		$classes_list    = uniqid( 'wd-sorter-' );

		if ( $value ) {
			$sortable_options = array();

			foreach ( json_decode( $value, true ) as $key => $save_options ) {
				foreach ( $save_options as $option_id ) {
					$current_option = array();

					foreach ( $default_options as $opt ) {
						if ( isset( $opt[ $option_id ] ) ) {
							$current_option = $opt[ $option_id ];
						}
					}
					if ( ! $current_option ) {
						continue;
					}

					$sortable_options[ $key ][ $option_id ] = $current_option;
				}
			}

			// Add new key when save old keys.
			$sortable_opts = call_user_func_array( 'array_merge', $sortable_options );
			foreach ( $default_options as $key => $def_options ) {
				foreach ( $sortable_opts as $sort_key => $sort_options ) {
					if ( isset( $def_options[ $sort_key ] ) ) {
						unset( $default_options[ $key ][ $sort_key ] );
					}
				}
			}

			if ( $default_options ) {
				foreach ( $default_options as $key => $default_opt ) {
					$array = array();
					if ( isset( $sortable_options[ $key ] ) ) {
						$array = $sortable_options[ $key ];
					}
					$sortable_options[ $key ] = array_merge( $array, $default_opt );
				}
			}

			$options = $sortable_options;
		} else {
			$options = $default_options;
		}
		?>

		<?php foreach ( $options as $key => $option ) : ?>
			<div class="xts-sorter-wrapper" data-key="<?php echo esc_attr( $key ); ?>">
				<?php if ( isset( $this->args['title_tabs'][ $key ] ) ) : ?>
					<span>
						<?php echo esc_html( $this->args['title_tabs'][ $key ] ); ?>
					</span>
				<?php endif; ?>
				<ul class="<?php echo esc_attr( $classes_list ); ?>">
					<?php foreach ( $option as $id => $name ) : ?>
						<li data-id="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $name ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endforeach; ?>

		<input type="hidden" name="<?php echo esc_attr( $this->get_input_name() ); ?>" value="<?php echo esc_attr( $value ); ?>"/>
		<?php
	}

	/**
	 * Enqueue media lib.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
}


