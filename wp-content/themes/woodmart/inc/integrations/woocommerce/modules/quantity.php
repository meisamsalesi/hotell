<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_product_quantity' ) ) {
	function woodmart_product_quantity( $product ) {
		if ( ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() && $product->is_in_stock() && ! woodmart_get_opt( 'catalog_mode' )  ) {
			woodmart_enqueue_js_script( 'grid-quantity' );
			woocommerce_quantity_input(
				array(
					'min_value' => 1,
					'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity(),
				)
			);
		}
	}
}

if ( ! function_exists( 'woodmart_update_cart_item' ) ) {
	function woodmart_update_cart_item() {
		if ( ( isset( $_GET['item_id'] ) && $_GET['item_id'] ) && ( isset( $_GET['qty'] ) ) ) {
			wc_clear_notices();

			$cart          = WC()->cart->get_cart();
			$cart_item_key = $_GET['item_id'];
			$quantity      = $_GET['qty'];
			$values        = array();
			$_product      = array();
			$cart_updated  = false;

			if ( ! empty( $cart[ $cart_item_key ] ) ) {
				$values   = $cart[ $cart_item_key ];
				$_product = $values['data'];
			}

			$passed_validation = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $values, $quantity );

			// is_sold_individually.
			if ( $_product && $_product->is_sold_individually() && $quantity > 1 ) {
				/* Translators: %s Product title. */
				wc_add_notice( sprintf( __( 'You can only have 1 %s in your cart.', 'woocommerce' ), $_product->get_name() ), 'error' );
				$passed_validation = false;
			}

			if ( $passed_validation && $quantity ) {
				WC()->cart->set_quantity( $cart_item_key, $quantity, false );
				$cart_updated = true;
			} elseif ( ! $quantity ) {
				WC()->cart->remove_cart_item( $cart_item_key );
			}

			// Trigger action - let 3rd parties update the cart if they need to and update the $cart_updated variable.
			$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', $cart_updated );

			if ( $cart_updated ) {
				WC()->cart->calculate_totals();
			}
		}

		WC_AJAX::get_refreshed_fragments();
	}

	add_action( 'wp_ajax_woodmart_update_cart_item', 'woodmart_update_cart_item' );
	add_action( 'wp_ajax_nopriv_woodmart_update_cart_item', 'woodmart_update_cart_item' );
}
