<?php

class PW_Tools_General {

	public function __construct() {
		add_filter( 'pre_get_posts', [ $this, 'fix_arabic_characters' ] );

		if ( PW()->get_options( 'fix_load_states', 'no' ) != 'no' ) {
			add_action( 'wp_footer', [ $this, 'checkout_state_dropdown_fix' ], 50 );
		}

		if ( PW()->get_options( 'fix_postcode_persian_number', 'no' ) != 'no' ) {
			add_filter( 'woocommerce_checkout_process', [ $this, 'checkout_process_postcode' ], 20, 1 );
		}

		if ( PW()->get_options( 'postcode_validation', 'no' ) != 'no' ) {
			add_filter( 'woocommerce_validate_postcode', [ $this, 'validate_postcode' ], 10, 3 );
		}

		if ( PW()->get_options( 'fix_phone_persian_number', 'no' ) != 'no' ) {
			add_filter( 'woocommerce_checkout_process', [ $this, 'checkout_process_phone' ], 20, 1 );
		}
	}

	function fix_arabic_characters( $query ) {

		if ( $query->is_search ) {
			$query->set( 's', str_replace( [ 'ك', 'ي', ], [ 'ک', 'ی' ], $query->get( 's' ) ) );
		}

		return $query;
	}

	function checkout_state_dropdown_fix() {

		if ( function_exists( 'is_checkout' ) && ! is_checkout() ) {
			return;
		}

		?>
		<script>
            jQuery(function () {
                // Snippets.ir
                jQuery('#billing_country').trigger('change');
                jQuery('#billing_state_field').removeClass('woocommerce-invalid');
            });
		</script>
		<?php
	}

	function checkout_process_postcode() {

		if ( isset( $_POST['billing_postcode'] ) ) {
			$_POST['billing_postcode'] = self::en( sanitize_text_field( $_POST['billing_postcode'] ) );
		}

		if ( isset( $_POST['shipping_postcode'] ) ) {
			$_POST['shipping_postcode'] = self::en( sanitize_text_field( $_POST['shipping_postcode'] ) );
		}

		if ( PW()->get_options( 'phone_validation', 'no' ) != 'no' ) {
			add_action( 'woocommerce_after_checkout_validation', [ $this, 'validate_phone' ], 10, 3 );
		}
	}

	function validate_postcode( $valid, $postcode, $country ): bool {

		if ( $country != 'IR' ) {
			return $valid;
		}

		return (bool) preg_match( '/^([0-9]{10})$/', $postcode );
	}

	function checkout_process_phone() {

		if ( isset( $_POST['billing_phone'] ) ) {
			$_POST['billing_phone'] = self::en( sanitize_text_field( $_POST['billing_phone'] ) );
		}

		if ( isset( $_POST['shipping_phone'] ) ) {
			$_POST['shipping_phone'] = self::en( sanitize_text_field( $_POST['shipping_phone'] ) );
		}

	}

	function validate_phone( $data, $errors ) {

		if ( (bool) preg_match( '/^(09[0-9]{9})$/', $data['billing_phone'] ) ) {
			return false;
		}

		$errors->add( 'validation', '<b>تلفن همراه</b> وارد شده، معتبر نمی باشد.' );
	}

	private static function en( $number ) {
		return str_replace( [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ], range( 0, 9 ), $number );
	}
}

new PW_Tools_General();
