<?php
/**
 * Frequently bought together class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Frequently_Bought_Together;

use WC_Product;
use XTS\Singleton;

/**
 * Render class.
 */
class Render extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		add_action( 'woocommerce_before_mini_cart_contents', array( $this, 'enqueue_style' ) );

		add_action( 'wp_ajax_woodmart_purchasable_fbt_products', array( $this, 'purchasable_fbt_products' ) );
		add_action( 'wp_ajax_nopriv_woodmart_purchasable_fbt_products', array( $this, 'purchasable_fbt_products' ) );

		add_action( 'woocommerce_before_calculate_totals', array( $this, 'before_calculate_totals' ), 100 );

		add_filter( 'woocommerce_cart_item_remove_link', array( $this, 'cart_item_remove_link' ), 10, 2 );
		add_filter( 'woocommerce_cart_item_price', array( $this, 'cart_item_price' ), 10, 2 );
		add_filter( 'woocommerce_cart_item_quantity', array( $this, 'cart_item_quantity' ), 10, 2 );
		add_filter( 'woocommerce_cart_item_subtotal', array( $this, 'cart_item_subtotal' ), 10, 2 );

		add_filter( 'woodmart_show_widget_cart_item_quantity', array( $this, 'widget_cart_item_quantity' ), 10, 2 );

		add_action( 'woocommerce_after_cart_item_quantity_update', array( $this, 'update_cart_item_quantity' ), 10, 4 );

		add_filter( 'woocommerce_order_item_name', array( $this, 'cart_item_name' ), 10, 2 );
		add_filter( 'woocommerce_cart_item_name', array( $this, 'cart_item_name' ), 10, 2 );

		add_filter( 'woocommerce_cart_item_class', array( $this, 'cart_item_class' ), 10, 3 );
		add_filter( 'woocommerce_mini_cart_item_class', array( $this, 'cart_item_class' ), 10, 3 );

		add_action( 'woocommerce_cart_item_removed', array( $this, 'cart_item_removed' ), 10, 2 );
		add_action( 'woocommerce_cart_item_restored', array( $this, 'restore_cart_items' ), 10, 2 );

		add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'get_cart_item_from_session' ), 10, 2 );
	}

	/**
	 * Enqueue cart style.
	 *
	 * @return void
	 */
	public function enqueue_style() {
		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return;
		}

		foreach ( WC()->cart->cart_contents as $product_cart ) {
			if ( ! empty( $product_cart['wd_fbt_bundle_id'] ) ) {
				woodmart_enqueue_inline_style( 'woo-opt-fbt-cart' );

				return;
			}
		}
	}

	/**
	 * Add to cart frequently bought together products.
	 *
	 * @return void
	 */
	public function purchasable_fbt_products() {
		check_ajax_referer( 'wd-frequently-bought-together', 'key' );

		if ( empty( $_POST['main_product'] ) || empty( $_POST['products_id'] ) || empty( $_POST['bundle_id'] ) ) {
			wp_send_json_error();
		}

		$bundle_id                 = sanitize_text_field( wp_unslash( $_POST['bundle_id'] ) );
		$main_product_id           = sanitize_text_field( wp_unslash( $_POST['main_product'] ) );
		$main_product              = wc_get_product( $main_product_id );
		$products_id               = woodmart_clean( $_POST['products_id'] ); //phpcs:ignore
		$fbt_products              = get_post_meta( $bundle_id, '_woodmart_fbt_products', true );
		$main_product_qty          = 1;
		$main_product_variation_id = 0;
		$main_product_variation    = array();
		$main_product_discount     = get_post_meta( $bundle_id, '_woodmart_main_products_discount', true );
		$item_keys                 = array();

		if ( ! $products_id || count( $products_id ) < 2 || ! $fbt_products ) {
			wp_send_json_error();
		}

		if ( $main_product->is_type( 'variable' ) ) {
			if ( empty( $products_id[ $main_product_id ] ) ) {
				wp_send_json_error();
			}

			$main_variation_product    = wc_get_product( $products_id[ $main_product_id ] );
			$main_product_variation_id = $main_variation_product->get_id();
			$main_product_variation    = $main_variation_product->get_variation_attributes();
		}

		$main_key_item = WC()->cart->add_to_cart(
			$main_product->get_id(),
			$main_product_qty,
			$main_product_variation_id,
			$main_product_variation,
			array(
				'wd_fbt_parent_id'       => $main_product->get_id(),
				'wd_fbt_discount'        => $main_product_discount,
				'wd_fbt_bundle_id'       => $bundle_id,
				'wd_fbt_keys'            => array(),
				'wd_fbt_product_ids'     => $products_id,
				'wd_fbt_bundle_modified' => get_the_modified_date( 'U', $bundle_id ),
			)
		);

		if ( ! $main_key_item ) {
			wp_send_json(
				array(
					'success' => false,
					'notices' => wc_print_notices( true ),
				)
			);
		}

		foreach ( $fbt_products as $fbt_product ) {
			$product_id = apply_filters( 'wpml_object_id', $fbt_product['id'], 'product', true );

			if ( ! isset( $products_id[ $product_id ] ) || $main_product->get_id() === (int) $product_id ) {
				continue;
			}

			$product           = wc_get_product( $product_id );
			$item_qty          = 1;
			$item_variation_id = 0;
			$item_variation    = array();

			if ( $product->is_type( 'variable' ) ) {
				if ( ! $products_id[ $product_id ] ) {
					continue;
				}

				$variation_product = wc_get_product( $products_id[ $product_id ] );
				$item_variation_id = $variation_product->get_id();
				$item_variation    = $variation_product->get_variation_attributes();
			}

			$item_keys[] = WC()->cart->add_to_cart(
				$product->get_id(),
				$item_qty,
				$item_variation_id,
				$item_variation,
				array(
					'wd_fbt_parent_id'   => $main_product->get_id(),
					'wd_fbt_discount'    => $fbt_product['discount'],
					'wd_fbt_bundle_id'   => $bundle_id,
					'wd_fbt_parent_keys' => $main_key_item,
				)
			);
		}

		if ( ! $item_keys || wc_notice_count( 'error' ) ) {
			if ( isset( WC()->cart->cart_contents[ $main_key_item ] ) ) {
				unset( WC()->cart->cart_contents[ $main_key_item ] );
			}

			if ( $item_keys ) {
				foreach ( $item_keys as $item_key ) {
					if ( isset( WC()->cart->cart_contents[ $item_key ] ) ) {
						unset( WC()->cart->cart_contents[ $item_key ] );
					}
				}
			}

			WC()->cart->set_session();

			wp_send_json(
				array(
					'success' => false,
					'notices' => wc_print_notices( true ),
				)
			);
		}

		WC()->cart->cart_contents[ $main_key_item ]['wd_fbt_keys'] = $item_keys;
		WC()->cart->set_session();

		woodmart_ajax_add_to_cart();
	}

	/**
	 * Update total price.
	 *
	 * @param object $cart_object Cart data.
	 * @return object
	 */
	public function before_calculate_totals( $cart_object ) {
		if ( ! defined( 'DOING_AJAX' ) && is_admin() ) {
			return $cart_object;
		}

		foreach ( $cart_object->cart_contents as $cart_item ) {
			if ( ! empty( $cart_item['wd_fbt_parent_keys'] ) && empty( $cart_object->cart_contents[ $cart_item['wd_fbt_parent_keys'] ] ) ) {
				unset( $cart_object->cart_contents[ $cart_item['key'] ] );
				unset( WC()->cart->cart_contents[ $cart_item['key'] ] );

				WC()->cart->set_session();
			}

			if ( isset( $cart_item['wd_fbt_bundle_id'], $cart_item['wd_fbt_bundle_modified'] ) && ( get_the_modified_date( 'U', $cart_item['wd_fbt_bundle_id'] ) !== $cart_item['wd_fbt_bundle_modified'] || 'publish' !== get_post_status( $cart_item['wd_fbt_bundle_id'] ) ) ) {
				$this->update_data_bundle_product( $cart_item );
			}
		}

		foreach ( $cart_object->cart_contents as $cart_item ) {
			if ( isset( $cart_item['data'], $cart_item['wd_fbt_discount'] ) && $cart_item['wd_fbt_discount'] && $cart_item['data'] instanceof WC_Product ) {
				if ( ! empty( $cart_item['variation_id'] ) ) {
					$variation_product = wc_get_product( $cart_item['variation_id'] );
					$price             = (float) $variation_product->get_price();
				} else {
					$current_product = wc_get_product( $cart_item['data']->get_id() );
					$price           = $current_product->get_price();
				}

				$price = apply_filters( 'woodmart_fbt_set_product_cart_price', $price, $cart_item );

				$item_price = $price - ( ( $price / 100 ) * (float) $cart_item['wd_fbt_discount'] );

				$cart_item['data']->set_price( $item_price );
			}
		}

		return $cart_object;
	}

	/**
	 * Update products data bundles after save bundle.
	 *
	 * @param array $cart_item Product cart item.
	 *
	 * @return void
	 */
	private function update_data_bundle_product( $cart_item ) {
		$cart_object        = WC()->cart;
		$cart_key           = $cart_item['key'];
		$fbt_products       = get_post_meta( $cart_item['wd_fbt_bundle_id'], '_woodmart_fbt_products', true );
		$main_discount      = get_post_meta( $cart_item['wd_fbt_bundle_id'], '_woodmart_main_products_discount', true );
		$show_checkbox      = get_post_meta( $cart_item['wd_fbt_bundle_id'], '_woodmart_show_checkbox', true );
		$fbt_products_count = count( $fbt_products );

		if ( $fbt_products ) {
			foreach ( $fbt_products as $key => $fbt_product ) {
				if ( ! empty( $fbt_product['id'] ) ) {
					$fbt_products[ $key ]['id'] = apply_filters( 'wpml_object_id', $fbt_product['id'], 'product', true );
				}
			}
		}

		$bundles_id = get_post_meta( $cart_item['wd_fbt_parent_id'], 'woodmart_fbt_bundles_id', true );

		if ( in_array( $cart_item['wd_fbt_parent_id'], array_column( $fbt_products, 'id' ) ) ) { //phpcs:ignore
			--$fbt_products_count;
		}

		if ( 'publish' !== get_post_status( $cart_item['wd_fbt_bundle_id'] ) || ! $show_checkbox && $fbt_products_count !== count( $cart_item['wd_fbt_keys'] ) || ! in_array( $cart_item['wd_fbt_bundle_id'], $bundles_id ) ) { //phpcs:ignore
			foreach ( $cart_item['wd_fbt_keys'] as $fbt_keys ) {
				unset( WC()->cart->cart_contents[ $fbt_keys ] );
			}

			unset( WC()->cart->cart_contents[ $cart_key ] );

			WC()->cart->set_session();

			return;
		}

		if ( $main_discount && $cart_item['wd_fbt_discount'] !== $main_discount ) {
			WC()->cart->cart_contents[ $cart_key ]['wd_fbt_discount'] = $main_discount;
		}

		$fbt_products = array_combine( array_column( $fbt_products, 'id' ), $fbt_products );

		foreach ( $cart_item['wd_fbt_keys'] as $key ) {
			if ( ! isset( $cart_object->cart_contents[ $key ] ) ) {
				continue;
			}

			$product_id   = $cart_object->cart_contents[ $key ]['product_id'];
			$variation_id = $cart_object->cart_contents[ $key ]['variation_id'];
			$discount     = 0;

			if ( isset( $fbt_products[ $product_id ]['discount'] ) ) {
				$discount = (int) $fbt_products[ $product_id ]['discount'];
			} elseif ( isset( $fbt_products[ $variation_id ]['discount'] ) ) {
				$discount = (int) $fbt_products[ $variation_id ]['discount'];
			}

			if ( empty( $fbt_products[ $product_id ] ) && empty( $fbt_products[ $variation_id ] ) ) {
				foreach ( $cart_item['wd_fbt_keys'] as $fbt_keys ) {
					unset( WC()->cart->cart_contents[ $fbt_keys ] );
				}

				unset( WC()->cart->cart_contents[ $cart_key ] );

				WC()->cart->set_session();

				return;
			}

			if ( (int) $cart_object->cart_contents[ $key ]['wd_fbt_discount'] !== $discount ) {
				WC()->cart->cart_contents[ $key ]['wd_fbt_discount'] = $discount;
			}
		}

		WC()->cart->cart_contents[ $cart_key ]['wd_fbt_bundle_modified'] = get_the_modified_date( 'U', $cart_item['wd_fbt_bundle_id'] );
		WC()->cart->set_session();
	}

	/**
	 * Update price in cart.
	 *
	 * @param string $price Product price.
	 * @param array  $cart_item Product data.
	 * @return string
	 */
	public function cart_item_price( $price, $cart_item ) {
		if ( isset( $cart_item['wd_fbt_parent_id'], $cart_item['wd_fbt_discount'] ) && $cart_item['wd_fbt_discount'] ) {
			if ( ! empty( $cart_item['variation_id'] ) ) {
				$variation_product = wc_get_product( $cart_item['variation_id'] );
				$product_price     = (float) $variation_product->get_price();
			} elseif ( ! empty( $cart_item['product_id'] ) ) {
				$product       = wc_get_product( $cart_item['product_id'] );
				$product_price = (float) $product->get_price();
			} else {
				$product_price = (float) $cart_item['data']->get_price();
			}

			$new_price = $product_price - ( ( $product_price / 100 ) * (float) $cart_item['wd_fbt_discount'] );
			$new_price = apply_filters( 'woodmart_fbt_product_cart_price', $new_price, $cart_item );

			return wc_price( wc_get_price_to_display( $cart_item['data'], array( 'price' => $new_price ) ) );
		}

		return $price;
	}

	/**
	 * Update subtotal price in cart.
	 *
	 * @param string $price Product price.
	 * @param array  $cart_item Product data.
	 * @return string
	 */
	public function cart_item_subtotal( $price, $cart_item ) {
		if ( isset( $cart_item['wd_fbt_parent_id'], $cart_item['wd_fbt_discount'] ) && $cart_item['wd_fbt_discount'] ) {
			if ( ! empty( $cart_item['variation_id'] ) ) {
				$variation_product = wc_get_product( $cart_item['variation_id'] );
				$product_price     = (float) $variation_product->get_price();
			} elseif ( ! empty( $cart_item['product_id'] ) ) {
				$product       = wc_get_product( $cart_item['product_id'] );
				$product_price = (float) $product->get_price();
			} else {
				$product_price = (float) $cart_item['data']->get_price();
			}

			$new_price = ( $product_price - ( ( $product_price / 100 ) * (float) $cart_item['wd_fbt_discount'] ) ) * $cart_item['quantity'];
			$new_price = apply_filters( 'woodmart_fbt_product_cart_subtotal', $new_price, $cart_item );

			return wc_price( wc_get_price_to_display( $cart_item['data'], array( 'price' => $new_price ) ) );
		}

		return $price;
	}

	/**
	 * Cart item remove link.
	 *
	 * @param string $link Quantity content.
	 * @param string $cart_item_key Product key.
	 *
	 * @return string
	 */
	public function cart_item_remove_link( $link, $cart_item_key ) {
		$item = WC()->cart->get_cart_item( $cart_item_key );

		if ( isset( $item['wd_fbt_bundle_id'], $item['wd_fbt_parent_id'] ) && $item['wd_fbt_parent_id'] !== $item['product_id'] ) {
			return '';
		}

		return $link;
	}

	/**
	 * Cart item quantity.
	 *
	 * @param string $quantity Quantity content.
	 * @param string $cart_item_key Product key.
	 *
	 * @return string
	 */
	public function cart_item_quantity( $quantity, $cart_item_key ) {
		$item = WC()->cart->get_cart_item( $cart_item_key );

		if ( isset( $item['wd_fbt_bundle_id'], $item['wd_fbt_parent_id'] ) && $item['wd_fbt_parent_id'] !== $item['product_id'] ) {
			return woocommerce_quantity_input(
				array(
					'input_name'   => "cart[{$cart_item_key}][qty]",
					'input_value'  => $item['quantity'],
					'max_value'    => $item['quantity'],
					'min_value'    => $item['quantity'],
					'product_name' => $item['data']->get_name(),
				),
				$item['data'],
				false
			);
		}

		return $quantity;
	}

	/**
	 * Update bundles products quantity.
	 *
	 * @param string  $cart_item_key Item key.
	 * @param integer $quantity New quantity.
	 * @param integer $old_quantity Old quantity.
	 * @param object  $cart Cart data.
	 *
	 * @return void
	 */
	public function update_cart_item_quantity( $cart_item_key, $quantity, $old_quantity, $cart ) {
		if ( isset( $_REQUEST['action'] ) && 'woodmart_purchasable_fbt_products' === $_REQUEST['action'] ) { //phpcs:ignore
			return;
		}

		$cart_items = $cart->cart_contents;
		$item_key   = array();

		if ( ! empty( $cart_items[ $cart_item_key ]['wd_fbt_keys'] ) ) {
			$item_key = $cart_items[ $cart_item_key ]['wd_fbt_keys'];
		} elseif ( ! empty( $cart_items[ $cart_item_key ]['wd_fbt_parent_keys'] ) && ! empty( $cart_items[ $cart_items[ $cart_item_key ]['wd_fbt_parent_keys'] ]['wd_fbt_keys'] ) ) {
			$item_key   = $cart_items[ $cart_items[ $cart_item_key ]['wd_fbt_parent_keys'] ]['wd_fbt_keys'];
			$item_key[] = $cart_items[ $cart_item_key ]['wd_fbt_parent_keys'];
		}

		if ( $item_key ) {
			foreach ( $item_key as $key ) {
				$cart->cart_contents[ $key ]['quantity'] = $quantity;
			}
		}
	}

	/**
	 * Widget cart item quantity.
	 *
	 * @param boolean $show Show quantity.
	 * @param string  $cart_item_key Product key.
	 *
	 * @return false
	 */
	public function widget_cart_item_quantity( $show, $cart_item_key ) {
		$item = WC()->cart->get_cart_item( $cart_item_key );

		if ( isset( $item['wd_fbt_bundle_id'], $item['wd_fbt_parent_id'] ) && $item['wd_fbt_parent_id'] !== $item['product_id'] ) {
			return false;
		}

		return $show;
	}

	/**
	 * Update item class cart for frequently bought together product.
	 *
	 * @param string $classes Item classes.
	 * @param array  $cart_item Product data.
	 * @param string $cart_item_key Product key.
	 *
	 * @return string
	 */
	public function cart_item_class( $classes, $cart_item, $cart_item_key ) {
		if ( ! empty( $cart_item['wd_fbt_parent_keys'] ) && isset( WC()->cart->cart_contents[ $cart_item['wd_fbt_parent_keys'] ] ) ) {
			$parent_product = WC()->cart->cart_contents[ $cart_item['wd_fbt_parent_keys'] ];

			if ( ! empty( $parent_product['wd_fbt_keys'] ) && count( $parent_product['wd_fbt_keys'] ) === array_search( $cart_item_key, $parent_product['wd_fbt_keys'], true ) + 1 ) {
				$classes .= ' wd-fbt-item-last';
			} else {
				$classes .= ' wd-fbt-item';
			}
		} elseif ( ! empty( $cart_item['wd_fbt_keys'] ) ) {
			$classes .= ' wd-fbt-item-first';
		}

		return $classes;
	}

	/**
	 * Update title in cart for frequently bought together product.
	 *
	 * @param string $item_name Product title.
	 * @param array  $item Product data.
	 * @return string
	 */
	public function cart_item_name( $item_name, $item ) {
		if ( ! empty( $item['wd_fbt_parent_id'] ) ) {
			ob_start();

			woodmart_enqueue_js_library( 'tooltips' );
			woodmart_enqueue_js_script( 'btns-tooltips' );

			?>
			<span class="wd-fbt-label wd-tooltip">
				<?php esc_html_e( 'Bundled product', 'woodmart' ); ?>
			</span>
			<?php

			$item_name .= ob_get_clean();
		}

		return $item_name;
	}

	/**
	 * Remove frequently bought together products.
	 *
	 * @param string $cart_item_key Product key.
	 * @param array  $cart Cart data.
	 * @return void
	 */
	public function cart_item_removed( $cart_item_key, $cart ) {
		$cart_data = $cart->removed_cart_contents;
		$item_key  = array();

		if ( ! empty( $cart_data[ $cart_item_key ]['wd_fbt_keys'] ) ) {
			$item_key = $cart_data[ $cart_item_key ]['wd_fbt_keys'];
		} elseif ( ! empty( $cart_data[ $cart_item_key ]['wd_fbt_parent_keys'] ) ) {
			$item_key   = $cart->cart_contents[ $cart_data[ $cart_item_key ]['wd_fbt_parent_keys'] ]['wd_fbt_keys'];
			$item_key[] = $cart_data[ $cart_item_key ]['wd_fbt_parent_keys'];
		}

		if ( $item_key ) {
			foreach ( $item_key as $key ) {
				$cart->removed_cart_contents[ $key ] = $cart->cart_contents[ $key ];

				unset( $cart->cart_contents[ $key ] );
			}
		}
	}

	/**
	 * Restore cart items.
	 *
	 * @param string $cart_item_key Cart item.
	 * @param object $cart Cart data.
	 *
	 * @return void
	 */
	public function restore_cart_items( $cart_item_key, $cart ) {
		$cart_data = $cart->cart_contents;
		$item_key  = array();

		if ( ! empty( $cart_data[ $cart_item_key ]['wd_fbt_keys'] ) ) {
			$item_key = $cart_data[ $cart_item_key ]['wd_fbt_keys'];
		} elseif ( ! empty( $cart_data[ $cart_item_key ]['wd_fbt_parent_keys'] ) ) {
			$item_key   = $cart->removed_cart_contents[ $cart_data[ $cart_item_key ]['wd_fbt_parent_keys'] ]['wd_fbt_keys'];
			$item_key[] = $cart_data[ $cart_item_key ]['wd_fbt_parent_keys'];
		}

		if ( $item_key ) {
			foreach ( $item_key as $key ) {
				$cart->cart_contents[ $key ] = $cart->removed_cart_contents[ $key ];
				unset( $cart->removed_cart_contents[ $key ] );
			}
		}
	}

	/**
	 * Get item from session.
	 *
	 * @param array $cart_item Cart data.
	 * @param array $item_session_values Session cart data.
	 *
	 * @return array
	 */
	public function get_cart_item_from_session( $cart_item, $item_session_values ) {
		if ( isset( $item_session_values['wd_fbt_parent_id'] ) ) {
			$cart_item['wd_fbt_parent_id'] = $item_session_values['wd_fbt_parent_id'];
			$cart_item['wd_fbt_discount']  = $item_session_values['wd_fbt_discount'];
			$cart_item['wd_fbt_bundle_id'] = $item_session_values['wd_fbt_bundle_id'];
		}

		if ( isset( $item_session_values['wd_fbt_keys'] ) ) {
			$cart_item['wd_fbt_keys'] = $item_session_values['wd_fbt_keys'];
		}

		if ( isset( $item_session_values['wd_fbt_parent_keys'] ) ) {
			$cart_item['wd_fbt_parent_keys'] = $item_session_values['wd_fbt_parent_keys'];
		}

		if ( isset( $item_session_values['wd_fbt_bundle_modified'] ) ) {
			$cart_item['wd_fbt_bundle_modified'] = $item_session_values['wd_fbt_bundle_modified'];
		}

		return $cart_item;
	}
}

Render::get_instance();
