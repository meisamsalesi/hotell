<?php
/**
 * The Template for displaying the review order product table within checkout.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

woodmart_enqueue_inline_style( 'woo-mod-quantity' );

foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		if ( $_product->is_sold_individually() || ! woodmart_get_opt( 'checkout_product_quantity' ) || ( ! empty( $cart_item['wd_fbt_parent_keys'] ) && isset( WC()->cart->cart_contents[ $cart_item['wd_fbt_parent_keys'] ] ) ) ) {
			ob_start();
			?>
			<strong class="product-quantity">
				&times;&nbsp;<?php echo esc_html( $cart_item['quantity'] ); ?>
			</strong>
			<input type="hidden" name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]" value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" />
			<?php
			$product_quantity = ob_get_clean();
		} else {
			woodmart_enqueue_js_script( 'checkout-quantity' );

			$product_quantity = woocommerce_quantity_input(
				array(
					'input_name'   => "cart[{$cart_item_key}][qty]",
					'input_value'  => $cart_item['quantity'],
					'max_value'    => $_product->get_max_purchase_quantity(),
					'min_value'    => '0',
					'product_name' => $_product->get_name(),
				),
				$_product,
				false
			);
		}

		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
		$product_image     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
		$product_title     = wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) );
		$product_title     = sprintf( '<span class="cart-product-label">%s</span>', $product_title );

		if ( $product_permalink && woodmart_get_opt( 'checkout_link_to_product' ) ) {
			$product_image = sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $product_image );
			$product_title = sprintf( '<a class="cart-product-label-link" href="%s">%s</a>', esc_url( $product_permalink ), $product_title );
		}

		?>
		<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
			<td class="wd-checkout-prod">
				<?php if ( woodmart_get_opt( 'checkout_remove_button' ) ) : ?>
					<div class="wd-checkout-remove-btn-wrapp"><?php
						woodmart_enqueue_js_script( 'checkout-remove-btn' );

						echo apply_filters( // phpcs:ignore.
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove wd-checkout-remove-btn" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
					?></div>
				<?php endif; ?>

				<?php if ( woodmart_get_opt( 'checkout_show_product_image' ) ) : ?>
					<div class="wd-checkout-prod-img">
						<?php echo $product_image; // phpcs:ignore. ?>
					</div>
				<?php endif; ?>

				<div class="wd-checkout-prod-cont">
					<div class="wd-checkout-prod-title">
						<?php echo $product_title; // phpcs:ignore. ?>

						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', $product_quantity, $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>

					<div class="wd-checkout-prod-total product-total">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</td>
		</tr>
		<?php
	}
}
wp_nonce_field( 'woodmart_remove_product_from_checkout' );
