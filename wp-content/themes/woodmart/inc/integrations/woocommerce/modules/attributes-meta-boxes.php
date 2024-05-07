<?php
/**
 * Add meta boxes to attributes interface for woocommerce.
 *
 * @package Woodmart.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_wc_attribute_update' ) ) {
	/**
	 * This function save woocommerce attribute data after push 'update' button.
	 *
	 * @param mixed $attribute_id .
	 * @param mixed $attribute .
	 * @param mixed $old_attribute_name .
	 */
	function woodmart_wc_attribute_update( $attribute_id, $attribute, $old_attribute_name ) {
		$attribute_swatch_size = isset( $_POST['attribute_swatch_size'] ) ? $_POST['attribute_swatch_size'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_size', sanitize_text_field( $attribute_swatch_size ) );

		$attribute_swatch_bg_style = isset( $_POST['attribute_swatch_style'] ) ? $_POST['attribute_swatch_style'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_style', sanitize_text_field( $attribute_swatch_bg_style ) );

		$attribute_swatch_dis_style = isset( $_POST['attribute_swatch_dis_style'] ) ? $_POST['attribute_swatch_dis_style'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_dis_style', sanitize_text_field( $attribute_swatch_dis_style ) );

		$attribute_swatch_shape = isset( $_POST['attribute_swatch_shape'] ) ? $_POST['attribute_swatch_shape'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_shape', sanitize_text_field( $attribute_swatch_shape ) );

		$attribute_show_on_product = isset( $_POST['attribute_show_on_product'] ) ? $_POST['attribute_show_on_product'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_show_on_product', sanitize_text_field( $attribute_show_on_product ) );

		$attribute_thumbnail = isset( $_POST['product_attr_thumbnail_id'] ) ? $_POST['product_attr_thumbnail_id'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_thumbnail', sanitize_text_field( $attribute_thumbnail ) );

		$attribute_hint = isset( $_POST['attribute_hint'] ) ? $_POST['attribute_hint'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_hint', sanitize_text_field( $attribute_hint ) );

		$attribute_change_image = isset( $_POST['attribute_change_image'] ) ? $_POST['attribute_change_image'] : ''; // phpcs:ignore.
		update_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_change_image', sanitize_text_field( $attribute_change_image ) );
	}

	add_action( 'woocommerce_attribute_updated', 'woodmart_wc_attribute_update', 20, 3 );
}

if ( ! function_exists( 'woodmart_wc_attribute_add' ) ) {
	/**
	 * This function save woocommerce attribute data after push 'Add attribute' button.
	 *
	 * @param mixed $attribute_id .
	 * @param mixed $attribute .
	 */
	function woodmart_wc_attribute_add( $attribute_id, $attribute ) {
		$attribute_swatch_size = isset( $_POST['attribute_swatch_size'] ) ? $_POST['attribute_swatch_size'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_size', sanitize_text_field( $attribute_swatch_size ) );

		$attribute_swatch_bg_style = isset( $_POST['attribute_swatch_style'] ) ? $_POST['attribute_swatch_style'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_style', sanitize_text_field( $attribute_swatch_bg_style ) );

		$attribute_swatch_dis_style = isset( $_POST['attribute_swatch_dis_style'] ) ? $_POST['attribute_swatch_dis_style'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_dis_style', sanitize_text_field( $attribute_swatch_dis_style ) );

		$attribute_swatch_shape = isset( $_POST['attribute_swatch_shape'] ) ? $_POST['attribute_swatch_shape'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_swatch_shape', sanitize_text_field( $attribute_swatch_shape ) );

		$attribute_show_on_product = isset( $_POST['attribute_show_on_product'] ) ? $_POST['attribute_show_on_product'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_show_on_product', sanitize_text_field( $attribute_show_on_product ) );

		$attribute_thumbnail = isset( $_POST['product_attr_thumbnail_id'] ) ? $_POST['product_attr_thumbnail_id'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_thumbnail', sanitize_text_field( $attribute_thumbnail ) );

		$attribute_hint = isset( $_POST['attribute_hint'] ) ? $_POST['attribute_hint'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_hint', sanitize_text_field( $attribute_hint ) );

		$attribute_change_image = isset( $_POST['attribute_change_image'] ) ? $_POST['attribute_change_image'] : ''; // phpcs:ignore.
		add_option( 'woodmart_pa_' . $attribute['attribute_name'] . '_change_image', sanitize_text_field( $attribute_change_image ) );
	}

	add_action( 'woocommerce_attribute_added', 'woodmart_wc_attribute_add', 20, 2 );
}

if ( ! function_exists( 'woodmart_wc_get_attribute_term' ) ) {

	/**
	 * Get attribute term.
	 *
	 * @param mixed $attribute_name .
	 * @param mixed $term .
	 * @return false|mixed|void
	 */
	function woodmart_wc_get_attribute_term( $attribute_name, $term, $default = false ) {
		return get_option( 'woodmart_' . $attribute_name . '_' . $term, $default );
	}
}

if ( ! function_exists( 'woodmart_render_product_attrs_admin_options' ) ) {
	/**
	 * Add product attribute labels options
	 *
	 * @since 1.0.0
	 */
	function woodmart_render_product_attrs_admin_options() {
		wp_enqueue_media();
		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );

		$swatch_shape_list     = array(
			'round'   => esc_html__( 'Round', 'woodmart' ),
			'rounded' => esc_html__( 'Rounded', 'woodmart' ),
			'square'  => esc_html__( 'Square', 'woodmart' ),
		);
		$swatch_size_list      = array(
			'xs'      => esc_html__( 'XS', 'woodmart' ),
			'default' => esc_html__( 'S', 'woodmart' ),
			'm'       => esc_html__( 'M', 'woodmart' ),
			'large'   => esc_html__( 'L', 'woodmart' ),
			'xlarge'  => esc_html__( 'XL', 'woodmart' ),
			'xxl'     => esc_html__( 'XXL', 'woodmart' ),
		);
		$swatch_style_list     = array(
			'1' => esc_html__( 'Style 1', 'woodmart' ),
			'2' => esc_html__( 'Style 2', 'woodmart' ),
			'3' => esc_html__( 'Style 3', 'woodmart' ),
			'4' => esc_html__( 'Style 4', 'woodmart' ),
		);
		$swatch_dis_style_list = array(
			'1' => esc_html__( 'Style 1', 'woodmart' ),
			'2' => esc_html__( 'Style 2', 'woodmart' ),
			'3' => esc_html__( 'Style 3', 'woodmart' ),
		);

		$show_on_product      = '';
		$thumb_id             = '';
		$attribute_hint       = '';
		$change_image_product = '';

		if ( ! empty( $_GET['edit'] ) ) { // phpcs:ignore
			$attribute_id   = sanitize_text_field( wp_unslash( $_GET['edit'] ) ); // phpcs:ignore
			$taxonomy_ids   = wc_get_attribute_taxonomy_ids();
			$attribute_name = 'pa_' . array_search( $attribute_id, $taxonomy_ids, false ); // phpcs:ignore

			$swatch_shape         = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_shape' );
			$swatch_size          = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );
			$swatch_style         = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_style' );
			$swatch_dis_style     = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_dis_style' );
			$show_on_product      = woodmart_wc_get_attribute_term( $attribute_name, 'show_on_product' );
			$thumb_id             = woodmart_wc_get_attribute_term( $attribute_name, 'thumbnail' );
			$attribute_hint       = woodmart_wc_get_attribute_term( $attribute_name, 'hint' );
			$change_image_product = woodmart_wc_get_attribute_term( $attribute_name, 'change_image' );
		}

		$swatch_shape     = ! empty( $swatch_shape ) ? $swatch_shape : 'round';
		$swatch_size      = ! empty( $swatch_size ) ? $swatch_size : 'default';
		$swatch_style     = ! empty( $swatch_style ) ? $swatch_style : '1';
		$swatch_dis_style = ! empty( $swatch_dis_style ) ? $swatch_dis_style : '1';

		?>
		<div class="xts-box xts-options xts-metaboxes xts-theme-style">
			<div class="xts-box-content">
				<div class="xts-fields-tabs">
					<div class="xts-sections">
						<div class="xts-section xts-active-section" data-id="general">
							<div class="xts-fields">
								<div class="xts-group-title">
									<span><?php esc_html_e( 'Swatch', 'woodmart' ); ?></span>
								</div>
								<div class="xts-fields-group xts-group">
									<div class="xts-field xts-settings-field xts-buttons-control xts-images-set">
										<div class="xts-option-title">
											<label>
												<span>
													<?php esc_html_e( 'Swatch style', 'woodmart' ); ?>
												</span>
											</label>
										</div>
										<div class="xts-option-control">
											<div class="xts-btns-set">
												<?php foreach ( $swatch_style_list as $value => $label ) : ?>
													<div class="xts-set-item xts-set-btn-img<?php echo (string) $value === $swatch_style ? ' xts-active' : ''; ?>" data-value="<?php echo esc_attr( $value ); ?>">
														<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/settings/swatches/swatches-style-' . $value . '.jpg' ); ?>" title="<?php echo esc_attr( $label ); ?>" alt="<?php echo esc_attr( $label ); ?>">
														<span class="xts-images-set-lable"><?php echo esc_html( $label ); ?></span>
													</div>
												<?php endforeach; ?>
											</div>
											<input type="hidden" name="attribute_swatch_style" value="<?php echo esc_attr( $swatch_style ); ?>">
										</div>
									</div>
									<div class="xts-field xts-settings-field xts-buttons-control xts-images-set">
										<div class="xts-option-title">
											<label>
												<span>
													<?php esc_html_e( 'Disabled swatch style', 'woodmart' ); ?>
												</span>
											</label>
										</div>
										<div class="xts-option-control">
											<div class="xts-btns-set">
												<?php foreach ( $swatch_dis_style_list as $value => $label ) : ?>
													<div class="xts-set-item xts-set-btn-img<?php echo (string) $value === $swatch_dis_style ? ' xts-active' : ''; ?>" data-value="<?php echo esc_attr( $value ); ?>">
														<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/settings/swatches/disable-swatches-style-' . $value . '.jpg' ); ?>" title="<?php echo esc_attr( $label ); ?>" alt="<?php echo esc_attr( $label ); ?>">
														<span class="xts-images-set-lable"><?php echo esc_html( $label ); ?></span>
													</div>
												<?php endforeach; ?>
											</div>
											<input type="hidden" name="attribute_swatch_dis_style" value="<?php echo esc_attr( $swatch_dis_style ); ?>">
										</div>
									</div>
									<div class="xts-field xts-settings-field xts-buttons-control xts-images-set">
										<div class="xts-option-title">
											<label>
												<span>
													<?php esc_html_e( 'Swatch shape', 'woodmart' ); ?>
												</span>
											</label>
										</div>
										<div class="xts-option-control">
											<div class="xts-btns-set">
												<?php foreach ( $swatch_shape_list as $value => $label ) : ?>
													<div class="xts-set-item xts-set-btn-img<?php echo $value === $swatch_shape ? ' xts-active' : ''; ?>" data-value="<?php echo esc_attr( $value ); ?>">
														<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/settings/swatches/swatch-form-' . $value . '.jpg' ); ?>" title="<?php echo esc_attr( $label ); ?>" alt="<?php echo esc_attr( $label ); ?>">
														<span class="xts-images-set-lable"><?php echo esc_html( $label ); ?></span>
													</div>
												<?php endforeach; ?>
											</div>
											<input type="hidden" name="attribute_swatch_shape" value="<?php echo esc_attr( $swatch_shape ); ?>">
										</div>
									</div>
									<div class="xts-field xts-settings-field xts-buttons-control">
										<div class="xts-option-title">
											<label>
												<span>
													<?php esc_html_e( 'Swatch size', 'woodmart' ); ?>
												</span>
											</label>
										</div>
										<div class="xts-option-control">
											<div class="xts-btns-set">
												<?php foreach ( $swatch_size_list as $value => $label ) : ?>
													<div class="xts-set-item xts-set-btn<?php echo $value === $swatch_size ? ' xts-active' : ''; ?>" data-value="<?php echo esc_attr( $value ); ?>">
														<span class="xts-images-set-lable"><?php echo esc_html( $label ); ?></span>
													</div>
												<?php endforeach; ?>
											</div>
											<input type="hidden" name="attribute_swatch_size" value="<?php echo esc_attr( $swatch_size ); ?>">
										</div>
									</div>
								</div>
								<div class="xts-group-title">
									<span><?php esc_html_e( 'Extra', 'woodmart' ); ?></span>
								</div>
								<div class="xts-fields-group xts-group">
									<div class="xts-field xts-settings-field xts-switcher-control">
										<div class="xts-option-title">
											<label>
												<span>
													<?php esc_html_e( 'Show attribute label on products', 'woodmart' ); ?>
												</span>
											</label>
											<div class="xts-hint">
												<div class="xts-tooltip xts-top"><img data-src="<?php echo esc_url( WOODMART_TOOLTIP_URL . 'show-attribute-label-on-products.jpg' ); ?>" alt=""></div>
											</div>
										</div>
										<div class="xts-option-control">
											<div class="xts-switcher-btn<?php echo esc_attr( 'on' === $show_on_product ? ' xts-active' : '' ); ?>" data-on="on" data-off="off">
												<div class="xts-switcher-dot-wrap">
													<div class="xts-switcher-dot"></div>
												</div>
												<div class="xts-switcher-labels">
													<span class="xts-switcher-label xts-on">
														<?php esc_html_e( 'Yes', 'woodmart' ); ?>
													</span>
													<span class="xts-switcher-label xts-off">
														<?php esc_html_e( 'No', 'woodmart' ); ?>
													</span>
												</div>
											</div>
											<input type="hidden" name="attribute_show_on_product" value="<?php echo esc_attr( $show_on_product ); ?>" >
										</div>
										<p class="xts-field-description">
											<?php esc_html_e( 'Enable this option to show an attribute label on the product image.', 'woodmart' ); ?>
										</p>
									</div>
									<div class="xts-field xts-settings-field xts-switcher-control">
										<div class="xts-option-title">
											<label>
												<span>
													<?php esc_html_e( 'Change product image on attribute click', 'woodmart' ); ?>
												</span>
											</label>
											<div class="xts-hint xts-loaded">
												<div class="xts-tooltip xts-top">
													<div class="xts-tooltip-inner"><video data-src="https://woodmart.xtemos.com/theme-settings-tooltips/change-product-image-attribute-click.mp4" autoplay="" loop="" muted="" src="https://woodmart.xtemos.com/theme-settings-tooltips/change-product-image-attribute-click.mp4"></video></div>
												</div>
											</div>
										</div>
										<div class="xts-option-control">
											<div class="xts-switcher-btn<?php echo esc_attr( 'on' === $change_image_product ? ' xts-active' : '' ); ?>" data-on="on" data-off="off">
												<div class="xts-switcher-dot-wrap">
													<div class="xts-switcher-dot"></div>
												</div>
												<div class="xts-switcher-labels">
													<span class="xts-switcher-label xts-on">
														<?php esc_html_e( 'Yes', 'woodmart' ); ?>
													</span>
													<span class="xts-switcher-label xts-off">
														<?php esc_html_e( 'No', 'woodmart' ); ?>
													</span>
												</div>
											</div>
											<input type="hidden" name="attribute_change_image" value="<?php echo esc_attr( $change_image_product ); ?>" >
										</div>
									</div>
									<div class="xts-field xts-settings-field xts-upload-control">
										<div class="xts-option-title">
											<label>
												<span>
													<?php esc_html_e( 'Attribute icon', 'woocommerce' ); ?>
												</span>
											</label>
											<div class="xts-hint">
												<div class="xts-tooltip xts-top"><img data-src="<?php echo esc_url( WOODMART_TOOLTIP_URL . 'attribute-icon.jpg' ); ?>" alt=""></div>
											</div>
										</div>
										<div class="xts-option-control">
											<div class="xts-upload-preview">
												<?php if ( ! empty( $thumb_id ) ) : ?>
													<img src="<?php echo esc_attr( wp_get_attachment_image_url( $thumb_id ) ); ?>" alt="">
												<?php endif; ?>
											</div>
											<div class="xts-upload-btns">
												<a class="xts-btn xts-upload-btn xts-i-import">
													<?php esc_html_e( 'Upload', 'woodmart' ); ?>
												</a>
												<a class="xts-btn xts-color-warning xts-remove-upload-btn xts-i-trash<?php echo ( isset( $thumb_id ) && ! empty( $thumb_id ) ) ? ' xts-active' : ''; ?>">
													<?php esc_html_e( 'Remove', 'woodmart' ); ?>
												</a>

												<input id="product_attr_thumbnail_id" type="hidden" class="xts-upload-input-id" name="product_attr_thumbnail_id" value="<?php echo esc_attr( $thumb_id ); ?>" />
											</div>
										</div>
										<p class="xts-field-description">
											<?php esc_html_e( 'Upload an icon that will be displayed on the additional information table.', 'woodmart' ); ?>
										</p>
									</div>
									<div class="xts-field xts-settings-field">
										<div class="xts-option-title">
											<label for="attribute_hint">
												<span>
													<?php esc_html_e( 'Attribute hint content', 'woodmart' ); ?>
												</span>
											</label>
											<div class="xts-hint">
												<div class="xts-tooltip xts-top"><img data-src="<?php echo esc_url( WOODMART_TOOLTIP_URL . 'attribute-hint.gif' ); ?>" alt=""></div>
											</div>
										</div>
										<div class="xts-option-control">
											<textarea id="attribute_hint" class="xts-textarea-plain" rows="5" name="attribute_hint"><?php echo esc_textarea( $attribute_hint ); ?></textarea>
										</div>
										<p class="xts-field-description">
											<?php esc_html_e( 'Enter the text that will be displayed as a hint on the additional information table.', 'woodmart' ); ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	add_action( 'woocommerce_after_edit_attribute_fields', 'woodmart_render_product_attrs_admin_options' );
	add_action( 'woocommerce_after_add_attribute_fields', 'woodmart_render_product_attrs_admin_options' );
}
