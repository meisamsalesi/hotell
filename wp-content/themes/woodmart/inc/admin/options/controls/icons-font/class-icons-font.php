<?php
/**
 * Icon fonts control.
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Icons Font.
 */
class Icons_Font extends Field {
	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$value   = $this->get_field_value();
		$options = $this->get_field_options();

		?>
		<div class="xts-fields-group xts-group">
			<div class="xts-fields">
				<div class="xts-field xts-col-6">
					<?php if ( ! empty( $options['font'] ) ) : ?>
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Icon design', 'woodmart' ); ?>
								</span>
							</label>
						</div>

						<div class="xts-option-control">
							<select class="xts-select xts-icon-font-select" name="<?php echo esc_attr( $this->get_input_name( 'font' ) ); ?>" aria-label="<?php echo esc_attr( $this->get_input_name( 'font' ) ); ?>">
								<?php foreach ( $options['font'] as $option ) : ?>
									<?php
									$selected = false;

									if ( ! empty( $value['font'] ) && strval( $value['font'] ) === strval( $option['value'] ) ) {
										$selected = true;
									}

									?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( true, $selected ); ?>>
										<?php echo esc_html( $option['name'] ); ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					<?php endif; ?>
				</div>
				<div class="xts-field xts-col-6">
					<?php if ( ! empty( $options['weight'] ) ) : ?>
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Icon weight', 'woodmart' ); ?>
								</span>
							</label>
						</div>

						<div class="xts-option-control">
							<select class="xts-select xts-icon-weight-select" name="<?php echo esc_attr( $this->get_input_name( 'weight' ) ); ?>" aria-label="<?php echo esc_attr( $this->get_input_name( 'weight' ) ); ?>">
								<?php foreach ( $options['weight'] as $option ) : ?>
									<?php
									$selected = false;

									if ( ! empty( $value['weight'] ) && strval( $value['weight'] ) === strval( $option['value'] ) ) {
										$selected = true;
									}

									?>
									<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( true, $selected ); ?>>
										<?php echo esc_html( $option['name'] ); ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					<?php endif; ?>
				</div>
				<?php $this->preview_icons(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Preview icons.
	 *
	 * @return void
	 */
	public function preview_icons() {
		wp_enqueue_style( 'wd-icon-preview', WOODMART_ASSETS . '/css/icon-preview.css', array(), WOODMART_VERSION );

		?>
		<div class="xts-field xts-icons-preview">
			<span class="wd-icon-chevron-left"></span>
			<span class="wd-icon-chevron-right"></span>
			<span class="wd-icon-chevron-up"></span>
			<span class="wd-icon-chevron-down"></span>
			<span class="wd-icon-long-arrow-left"></span>
			<span class="wd-icon-long-arrow-right"></span>
			<span class="wd-icon-warning-sign"></span>
			<span class="wd-icon-play-button"></span>
			<span class="wd-icon-pause-button"></span>
			<span class="wd-icon-360-deg"></span>
			<span class="wd-icon-door-logout"></span>
			<span class="wd-icon-check"></span>
			<span class="wd-icon-plus"></span>
			<span class="wd-icon-cross-close"></span>
			<span class="wd-icon-more-dots"></span>
			<span class="wd-icon-vertical-menu"></span>
			<span class="wd-icon-filter"></span>
			<span class="wd-icon-sort-by"></span>
			<span class="wd-icon-grid"></span>
			<span class="wd-icon-header-cart"></span>
			<span class="wd-icon-cart"></span>
			<span class="wd-icon-bag"></span>
			<span class="wd-icon-heart"></span>
			<span class="wd-icon-user"></span>
			<span class="wd-icon-newlatter"></span>
			<span class="wd-icon-scale-arrows"></span>
			<span class="wd-icon-compare"></span>
			<span class="wd-icon-search"></span>
			<span class="wd-icon-ruler"></span>
			<span class="wd-icon-home"></span>
			<span class="wd-icon-shop"></span>
			<span class="wd-icon-cart-empty"></span>
			<span class="wd-icon-cart-verified"></span>
			<span class="wd-icon-star"></span>
			<span class="wd-icon-star-empty"></span>
			<span class="wd-icon-menu"></span>
			<span class="wd-icon-menu-filters"></span>
			<span class="wd-icon-bundle"></span>
			<span class="wd-icon-map-pointer"></span>
			<span class="wd-icon-like"></span>
			<span class="wd-icon-dislike"></span>
			<span class="wd-icon-eye"></span>
			<span class="wd-icon-eye-disable"></span>
			<span class="wd-icon-edit"></span>
			<span class="wd-icon-social"></span>
			<span class="wd-icon-comment"></span>
			<span class="wd-icon-paperclip"></span>
			<span class="wd-icon-blog"></span>
			<span class="wd-icon-external-link"></span>
			<span class="wd-icon-quote"></span>
			<span class="wd-icon-list-view"></span>
			<span class="wd-icon-grid-view-2"></span>
			<span class="wd-icon-grid-view-3"></span>
			<span class="wd-icon-grid-view-4"></span>
			<span class="wd-icon-grid-view-5"></span>
			<span class="wd-icon-grid-view-6"></span>
			<span class="wd-icon-account-wishlist"></span>
			<span class="wd-icon-account-details"></span>
			<span class="wd-icon-account-download"></span>
			<span class="wd-icon-account-exit"></span>
			<span class="wd-icon-account-orders"></span>
			<span class="wd-icon-account-address"></span>
			<span class="wd-icon-account-other"></span>
			<span class="wd-icon-account-payment"></span>
			<span class="wd-icon-envelope-solid"></span>
			<span class="wd-icon-tik-tok-brands"></span>
			<span class="wd-icon-twitter-brands"></span>
			<span class="wd-icon-github-brands"></span>
			<span class="wd-icon-pinterest-brands"></span>
			<span class="wd-icon-linkedin-brands"></span>
			<span class="wd-icon-youtube-brands"></span>
			<span class="wd-icon-instagram-brands"></span>
			<span class="wd-icon-flickr-brands"></span>
			<span class="wd-icon-tumblr-brands"></span>
			<span class="wd-icon-dribbble-brands"></span>
			<span class="wd-icon-skype-brands"></span>
			<span class="wd-icon-vk-brands"></span>
			<span class="wd-icon-google-brands"></span>
			<span class="wd-icon-behance-brands"></span>
			<span class="wd-icon-spotify-brands"></span>
			<span class="wd-icon-soundcloud-brands"></span>
			<span class="wd-icon-facebook-square-brands"></span>
			<span class="wd-icon-odnoklassniki-brands"></span>
			<span class="wd-icon-vimeo-v-brands"></span>
			<span class="wd-icon-snapchat-ghost-brands"></span>
			<span class="wd-icon-telegram-brands"></span>
			<span class="wd-icon-facebook-f-brands"></span>
			<span class="wd-icon-viber-brands"></span>
			<span class="wd-icon-whatsapp-brands"></span>
		</div>
		<?php
	}

	/**
	 * Enqueue.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		$icon_font_name = 'woodmart-font-';
		$value          = $this->get_field_value();

		if ( ! empty( $value['font'] ) ) {
			$icon_font_name .= $value['font'];
		}

		if ( ! empty( $value['weight'] ) ) {
			$icon_font_name .= '-' . $value['weight'];
		}

		?>
		<style id="wd-icon-font">
			@font-face {
				font-weight: normal;
				font-style: normal;
				font-family: "woodmart-font";
				src: url("<?php echo esc_url( woodmart_remove_https( WOODMART_THEME_DIR . '/fonts/' . $icon_font_name . '.woff2' ) . '?v=' . woodmart_get_theme_info( 'Version' ) ); ?>") format("woff2");
			}
		</style>
		<?php
	}
}