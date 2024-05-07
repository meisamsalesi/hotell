<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'PW_Tools_Checkout' ) ) :

	class PW_Tools_Checkout {

		public function __construct() {

			if ( PW()->get_options( 'remove_extra_field_physical', 'no' ) == 'yes' ) {
				add_filter( 'woocommerce_checkout_fields', [ $this, 'remove_extra_field_physical' ] );
			}

		}

		public function remove_extra_field_physical( $fields ) {

			if ( ! WC()->cart->needs_shipping() ) {
				unset( $fields['billing']['billing_address_1'] );
				unset( $fields['billing']['billing_address_2'] );
				unset( $fields['billing']['billing_company'] );
				unset( $fields['billing']['billing_city'] );
				unset( $fields['billing']['billing_postcode'] );
				unset( $fields['billing']['billing_country'] );
				unset( $fields['billing']['billing_state'] );

				add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
			}

			return $fields;
		}

	}

endif;

PW()->tools->checkout = new PW_Tools_Checkout();
