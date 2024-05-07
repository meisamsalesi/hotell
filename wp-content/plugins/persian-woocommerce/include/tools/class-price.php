<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'PW_Tools_Price' ) ) :

	class PW_Tools_Price {

		public function __construct() {

			if ( PW()->get_options( 'enable_call_for_price', 'no' ) == 'yes' ) {
				add_filter( 'woocommerce_empty_price_html', [ $this, 'on_empty_price' ], PHP_INT_MAX - 1 );
				add_filter( 'woocommerce_sale_flash', [ $this, 'hide_sales_flash' ], PHP_INT_MAX, 3 );
			}

			if ( PW()->get_options( 'persian_price', 'no' ) == 'yes' ) {
				add_filter( 'wc_price', [ $this, 'persian_number' ] );
				add_filter( 'woocommerce_get_price_html', [ $this, 'persian_number' ] );

				add_filter( 'woocommerce_cart_item_price', [ $this, 'persian_number' ] );
				add_filter( 'woocommerce_cart_item_subtotal', [ $this, 'persian_number' ] );
				add_filter( 'woocommerce_cart_subtotal', [ $this, 'persian_number' ] );
				add_filter( 'woocommerce_cart_shipping_method_full_label', [ $this, 'persian_number' ] );
				add_filter( 'woocommerce_cart_total', [ $this, 'persian_number' ] );
			}

			if ( PW()->get_options( 'minimum_order_amount', 0 ) != 0 ) {
				add_action( 'woocommerce_checkout_process', [ $this, 'wc_minimum_order_amount' ] );
				add_action( 'woocommerce_before_cart', [ $this, 'wc_minimum_order_amount' ] );
			}

			if ( PW()->get_options( 'variable_price', 'range' ) != 'range' ) {
				add_action( 'woocommerce_variable_sale_price_html', [ $this, 'get_variation_price_format' ], 10, 2 );
				add_action( 'woocommerce_variable_price_html', [ $this, 'get_variation_price_format' ], 10, 2 );
				add_action( 'woocommerce_dropdown_variation_attribute_options_args', [
					$this,
					'remove_dropdown_variation_options',
				] );
			}
		}

		public function hide_sales_flash( $onsale_html, $post, $product ) {
			return ( 'yes' == PW()->get_options( 'call_for_price_hide_sale_sign', 'no' ) && '' == $product->get_price() ) ? "" : $onsale_html;
		}

		public function is_related() {
			global $post;

			$ID = isset( $post->ID ) ? $post->ID : '';

			return is_singular() !== is_single( $ID );
		}

		public function on_empty_price( $price ) {
			if ( is_archive() ) {
				return PW()->get_options( 'call_for_price_text_on_archive' );
			} elseif ( $this->is_related() ) {
				return PW()->get_options( 'call_for_price_text_on_related' );
			} elseif ( is_single() ) {
				return PW()->get_options( 'call_for_price_text' );
			} elseif ( is_home() ) {
				return PW()->get_options( 'call_for_price_text_on_home' );
			}

			return $price;
		}

		public function persian_number( $price ) {
			return str_replace( range( 0, 9 ), [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ], $price );
		}

		public function wc_minimum_order_amount() {

			$minimum = PW()->get_options( 'minimum_order_amount', 0 );

			if ( WC()->cart->get_total( null ) < $minimum ) {

				$message = sprintf( __( 'مبلغ سفارش شما %s می باشد، حداقل مبلغ جهت ثبت سفارش %s است.' ), wc_price( WC()->cart->get_total( null ) ), wc_price( $minimum ) );

				if ( is_cart() ) {

					wc_print_notice( $message, 'error' );

				} else {

					wc_add_notice( $message, 'error' );

				}
			}
		}

		public function get_variation_price_format( string $price, WC_Product $product ): string {

			[ $min_or_max, $type ] = explode( '_', PW()->get_options( 'variable_price' ) );

			// Validation
			$min_or_max = $min_or_max == 'min' ? 'min' : 'max';
			$type       = $type == 'regular' ? 'regular' : 'sale';

			return wc_price( $product->{"get_variation_{$type}_price"}( $min_or_max ) );
		}

		public function remove_dropdown_variation_options( array $args ): array {
			$args['show_option_none'] = false;

			return $args;
		}
	}

endif;

PW()->tools->price = new PW_Tools_Price();
