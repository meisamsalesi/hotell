<?php
/**
 * Cart table shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_cart_table' ) ) {
	/**
	 * Cart table shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_cart_table( $settings ) {
		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return '';
		}

		$default_settings = array(
			'css' => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();

		Main::setup_preview();

		wc()->cart->calculate_totals();

		$update_cart_btn_classes = '';

		if ( function_exists( 'wc_wp_theme_get_element_class_name' ) ) {
			$update_cart_btn_classes .= ' ' . wc_wp_theme_get_element_class_name( 'button' );
		}

		if ( woodmart_get_opt( 'update_cart_quantity_change' ) ) {
			$update_cart_btn_classes .= ' wd-hide';
		}

		?>
		<div class="wd-cart-table wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<form class="woocommerce-cart-form cart-data-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<div class="cart-table-section">

					<?php do_action( 'woocommerce_before_cart_table' ); ?>

					<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
						<thead>
							<tr>
								<th class="product-remove">&nbsp;</th>
								<th class="product-thumbnail">&nbsp;</th>
								<th class="product-name">
									<?php esc_html_e( 'Product', 'woocommerce' ); ?>
								</th>
								<?php if ( woodmart_get_opt( 'show_sku_in_cart' ) ) : ?>
									<th class="product-sku"><?php esc_html_e( 'SKU', 'woocommerce' ); ?></th>
								<?php endif; ?>
								<th class="product-price">
									<?php esc_html_e( 'Price', 'woocommerce' ); ?>
								</th>
								<th class="product-quantity">
									<?php esc_html_e( 'Quantity', 'woocommerce' ); ?>
								</th>
								<th class="product-subtotal">
									<?php esc_html_e( 'Subtotal', 'woocommerce' ); ?>
								</th>
							</tr>
						</thead>
						<tbody>
						<?php do_action( 'woocommerce_before_cart_contents' ); ?>

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
								?>

								<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

									<td class="product-remove">
										<?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
												esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
												/* translators: %s is the product name */
												esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
												esc_attr( $product_id ),
												esc_attr( $_product->get_sku() )
											),
											$cart_item_key
										);
										?>
									</td>

									<td class="product-thumbnail">
										<?php
										if ( ! $product_permalink ) {
											echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); //phpcs:ignore
										} else {
											printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ) ); //phpcs:ignore
										}
										?>
									</td>

									<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
										<?php
										if ( ! $product_permalink ) {
											echo wp_kses_post( $product_name . '&nbsp;' );
										} else {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
										}

										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

										// Meta data.
										echo wc_get_formatted_cart_item_data( $cart_item ); //phpcs:ignore

										// Backorder notification.
										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
										}
										?>
									</td>

									<?php if ( woodmart_get_opt( 'show_sku_in_cart' ) ) : ?>
										<td class="product-sku" data-title="<?php esc_attr_e( 'SKU', 'woocommerce' ); ?>">
											<?php if ( $_product->get_sku() ) : ?>
												<?php echo esc_html( $_product->get_sku() ); ?>
											<?php else : ?>
												<?php esc_html_e( 'N/A', 'woocommerce' ); ?>
											<?php endif; ?>
										</td>
									<?php endif; ?>

									<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
										<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); //phpcs:ignore ?>
									</td>

									<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
										<?php
										if ( $_product->is_sold_individually() ) {
											$min_quantity = 1;
											$max_quantity = 1;
										} else {
											$min_quantity = 0;
											$max_quantity = $_product->get_max_purchase_quantity();
										}

										$product_quantity = woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $max_quantity,
												'min_value'    => $min_quantity,
												'product_name' => $product_name,
											),
											$_product,
											false
										);

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); //phpcs:ignore
										?>
									</td>

									<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
										<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); //phpcs:ignore ?>
									</td>
								</tr>
								<?php
							}
						}
						?>

						<?php do_action( 'woocommerce_cart_contents' ); ?>

						<?php do_action( 'woocommerce_after_cart_contents' ); ?>
						</tbody>
					</table>

					<div class="row cart-actions">
						<div class="col-12 order-last order-md-first col-md">
							<?php if ( wc_coupons_enabled() ) : ?>
								<div class="coupon">
									<label for="coupon_code">
										<?php esc_html_e( 'Coupon:', 'woocommerce' ); ?>
									</label>
									<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
									<button type="submit" class="button<?php echo esc_attr( function_exists( 'wc_wp_theme_get_element_class_name') && wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">
										<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>
									</button>
									<?php do_action( 'woocommerce_cart_coupon' ); ?>
								</div>
							<?php endif; ?>
						</div>

						<div class="col-12 order-first order-md-last col-md-auto">
							<button type="submit" class="button<?php echo esc_attr( $update_cart_btn_classes ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>">
								<?php esc_html_e( 'Update cart', 'woocommerce' ); ?>
							</button>

							<?php do_action( 'woocommerce_cart_actions' ); ?>

							<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
