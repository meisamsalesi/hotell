<?php

defined( 'ABSPATH' ) || exit;

function PW_Load_Zibal_Gateway() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) || class_exists( 'WC_Zibal' ) || function_exists( 'Woocommerce_Add_Zibal_Gateway' ) ) {


		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		$plugin = "zibal-payment-gateway-for-woocommerce/index.php";

		if ( is_plugin_active( $plugin ) ) {
			deactivate_plugins( $plugin );
		}

		return;
	}

	add_filter( 'woocommerce_payment_gateways', 'Woocommerce_Add_Zibal_Gateway' );

	function Woocommerce_Add_Zibal_Gateway( $methods ) {
		$methods[] = 'WC_Zibal';

		return $methods;
	}

	class WC_Zibal extends WC_Payment_Gateway {

		public function __construct() {

			$this->id                 = 'WC_Zibal';
			$this->method_title       = __( 'پرداخت زیبال', 'woocommerce' );
			$this->method_description = __( 'تنظیمات درگاه پرداخت زیبال برای افزونه فروشگاه ساز ووکامرس', 'woocommerce' );
			$this->icon               = apply_filters( 'woocommerce_ir_gateway_zibal_icon', PW()->plugin_url( 'assets/images/zibal.png' ) );
			$this->has_fields         = false;

			$this->init_form_fields();
			$this->init_settings();

			$this->title       = $this->settings['title'];
			$this->description = $this->settings['description'];

			$this->merchantcode = $this->settings['merchantcode'];

			$this->success_massage = $this->settings['success_massage'];
			$this->failed_massage  = $this->settings['failed_massage'];

			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, [
				$this,
				'process_admin_options',
			] );

			add_action( 'woocommerce_receipt_' . $this->id, [ $this, 'Send_to_Zibal_Gateway' ] );
			add_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), [
				$this,
				'webhook',
			] );
		}

		public function init_form_fields() {
			$this->form_fields = apply_filters(
				'WC_Zibal_Config',
				[
					'base_confing'    => [
						'title'       => __( 'تنظیمات پایه ای', 'woocommerce' ),
						'type'        => 'title',
						'description' => '',
					],
					'enabled'         => [
						'title'       => __( 'فعالسازی/غیرفعالسازی', 'woocommerce' ),
						'type'        => 'checkbox',
						'label'       => __( 'فعالسازی درگاه زیبال', 'woocommerce' ),
						'description' => __( 'برای فعالسازی درگاه پرداخت زیبال باید چک باکس را تیک بزنید', 'woocommerce' ),
						'default'     => 'no',
						'desc_tip'    => true,
					],
					'title'           => [
						'title'       => __( 'عنوان درگاه', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'عنوان درگاه که در طی خرید به مشتری نمایش داده میشود', 'woocommerce' ),
						'default'     => __( 'پرداخت امن زیبال', 'woocommerce' ),
						'desc_tip'    => true,
					],
					'description'     => [
						'title'       => __( 'توضیحات درگاه', 'woocommerce' ),
						'type'        => 'text',
						'desc_tip'    => true,
						'description' => __( 'توضیحاتی که در طی عملیات پرداخت برای درگاه نمایش داده خواهد شد', 'woocommerce' ),
						'default'     => __( 'پرداخت امن به وسیله کلیه کارت های عضو شتاب از طریق درگاه زیبال', 'woocommerce' ),
					],
					'account_confing' => [
						'title'       => __( 'تنظیمات حساب زیبال', 'woocommerce' ),
						'type'        => 'title',
						'description' => '',
					],
					'merchantcode'    => [
						'title'       => __( 'مرچنت کد', 'woocommerce' ),
						'type'        => 'text',
						'description' => __( 'مرچنت کد درگاه زیبال - برای تست می‌توانید از مرچنت zibal استفاده کنید', 'woocommerce' ),
						'default'     => '',
						'desc_tip'    => true,
					],
					'payment_confing' => [
						'title'       => __( 'تنظیمات عملیات پرداخت', 'woocommerce' ),
						'type'        => 'title',
						'description' => '',
					],
					'success_massage' => [
						'title'       => __( 'پیام پرداخت موفق', 'woocommerce' ),
						'type'        => 'textarea',
						'description' => __( 'متن پیامی که میخواهید بعد از پرداخت موفق به کاربر نمایش دهید را وارد نمایید . همچنین می توانید از شورت کد {transaction_id} برای نمایش کد رهگیری (توکن) زیبال استفاده نمایید .', 'woocommerce' ),
						'default'     => __( 'با تشکر از شما . سفارش شما با موفقیت پرداخت شد .', 'woocommerce' ),
					],
					'failed_massage'  => [
						'title'       => __( 'پیام پرداخت ناموفق', 'woocommerce' ),
						'type'        => 'textarea',
						'description' => __( 'متن پیامی که میخواهید بعد از پرداخت ناموفق به کاربر نمایش دهید را وارد نمایید . همچنین می توانید از شورت کد {fault} برای نمایش دلیل خطای رخ داده استفاده نمایید . این دلیل خطا از سایت زیبال ارسال میگردد .', 'woocommerce' ),
						'default'     => __( 'پرداخت شما ناموفق بوده است . لطفا مجددا تلاش نمایید یا در صورت بروز اشکال با مدیر سایت تماس بگیرید .', 'woocommerce' ),
					],
				]
			);
		}

		/**
		 * @param $order_id
		 *
		 * @return array
		 */
		public function process_payment( $order_id ) {
			WC()->session->set( 'order_id_Zibal', $order_id );

			$order = wc_get_order( $order_id );

			$currency = $order->get_currency();

			$Amount = $order->get_total();

			if ( strtolower( $currency ) == strtolower( 'IRT' ) ) {
				$Amount = $Amount * 10;
			} else if ( strtolower( $currency ) == strtolower( 'IRHT' ) ) {
				$Amount = $Amount * 10000;
			} else if ( strtolower( $currency ) == strtolower( 'IRHR' ) ) {
				$Amount = $Amount * 1000;
			}

			$CallbackUrl = add_query_arg( 'wc_order', $order_id, WC()->api_request_url( 'WC_Zibal' ) );

			// Zibal Hash Secure Code
			$hash        = md5( $order_id . $Amount . $this->merchantcode );
			$CallbackUrl = add_query_arg( 'secure', $hash, $CallbackUrl );

			$Description = 'خریدار: ' . $order->get_formatted_billing_full_name();

			$Mobile = $order->get_meta( '_billing_phone' ) ? $order->get_meta( '_billing_phone' ) : '-';

			$Mobile = preg_match( '/^09[0-9]{9}/i', $Mobile ) ? $Mobile : '';

			$data = [
				'merchant'    => $this->merchantcode,
				'amount'      => $Amount,
				'orderId'     => $order->get_order_number(),
				'callbackUrl' => $CallbackUrl,
				'description' => $Description,
				'mobile'      => $Mobile,
				'reseller'    => 'woocommerce',
			];

			$result = $this->SendRequestToZibal( 'request', $data );

			if ( $result === false ) {
				$Message = 'خطا در اتصال به سرورهای زیبال';
			} else {
				if ( $result["result"] == 100 ) {

					return [
						'result'   => 'success',
						'redirect' => sprintf( 'https://gateway.zibal.ir/start/%s', $result['trackId'] ),
					];

				} else {
					$Message = ' تراکنش ناموفق بود- کد خطا : ' . $result["result"];
				}
			}

			if ( ! empty( $Message ) ) {

				$Note = sprintf( __( 'خطا در هنگام ارسال به بانک: %s', 'woocommerce' ), $Message );

				$order->add_order_note( $Note );

				$Notice = sprintf( __( 'در هنگام اتصال به بانک خطای زیر رخ داده است: <br/>%s', 'woocommerce' ), $Message );

				if ( $Notice ) {
					wc_add_notice( $Notice, 'error' );
				}

			}
		}

		public function webhook() {
			$InvoiceNumber = isset( $_GET['orderId'] ) ? sanitize_text_field( $_GET['orderId'] ) : '';
			$success       = sanitize_text_field( $_GET['success'] );
			$trackId       = sanitize_text_field( $_GET['trackId'] );

			if ( isset( $_GET['wc_order'] ) ) {
				$order_id = sanitize_text_field( $_GET['wc_order'] );
			} else if ( $InvoiceNumber ) {
				$order_id = $InvoiceNumber;
			} else {
				$order_id = WC()->session->get( 'order_id_Zibal' );
				unset( WC()->session->order_id_Zibal );
			}

			if ( ! $order_id ) {
				$Fault  = __( 'شماره سفارش وجود ندارد .', 'woocommerce' );
				$Notice = wpautop( wptexturize( $this->failed_massage ) );
				$Notice = str_replace( "{fault}", $Fault, $Notice );

				if ( $Notice ) {
					wc_add_notice( $Notice, 'error' );
				}

				wp_redirect( wc_get_checkout_url() );
				exit;
			}

			$order    = wc_get_order( $order_id );
			$currency = $order->get_currency();

			$Amount = intval( $order->get_total() );

			if ( strtolower( $currency ) == strtolower( 'IRT' ) ) {
				$Amount = $Amount * 10;
			} else if ( strtolower( $currency ) == strtolower( 'IRHT' ) ) {
				$Amount = $Amount * 10000;
			} else if ( strtolower( $currency ) == strtolower( 'IRHR' ) ) {
				$Amount = $Amount * 1000;
			}

			$hash = md5( $order_id . $Amount . $this->merchantcode );

			if ( $_GET['secure'] != $hash ) {
				echo 'شما اجازه دسترسی به این قسمت را ندارید.';
				die();
			}

			if ( ! $order->has_status( 'completed' ) ) {

				if ( $success == '1' ) {
					$MerchantID = $this->merchantcode;
					$data       = [ 'merchant' => $MerchantID, 'trackId' => $trackId ];
					$result     = $this->SendRequestToZibal( 'verify', $data );

					if ( $result['result'] == 100 && $result['amount'] == $Amount ) {
						$Status         = 'completed';
						$Transaction_ID = $trackId;
						$verify_card_no = $result['cardNumber'];
						$verify_ref_num = $result['refNumber'];
						$Fault          = '';
						$Message        = '';
					} elseif ( $result['result'] == 201 ) {

						$Message = 'این تراکنش قبلا تایید شده است';
						$Notice  = wpautop( wptexturize( $Message ) );
						wp_redirect( add_query_arg( 'wc_status', 'success', $this->get_return_url( $order ) ) );
						exit;
					} else {
						$Status  = 'failed';
						$Fault   = $result['result'];
						$Message = 'تراکنش ناموفق بود';
					}
				} else {
					$Status  = 'failed';
					$Fault   = '';
					$Message = 'تراکنش انجام نشد .';
				}

				if ( $Status == 'completed' && isset( $Transaction_ID ) && $Transaction_ID != 0 ) {

					$order->update_meta_data( '_transaction_id', $Transaction_ID );
					$order->update_meta_data( 'zibal_payment_card_number', $verify_card_no );
					$order->update_meta_data( 'zibal_payment_ref_number', $verify_ref_num );
					$order->save_meta_data();

					$order->payment_complete( $Transaction_ID );
					WC()->cart->empty_cart();

					$Note = sprintf( __( 'پرداخت موفقیت آمیز بود .<br/> کد رهگیری : %s', 'woocommerce' ), $Transaction_ID );
					$Note .= sprintf( __( '<br/> شماره کارت پرداخت کننده : %s', 'woocommerce' ), $verify_card_no );
					$Note .= sprintf( __( '<br/> شماره مرجع : %s', 'woocommerce' ), $verify_ref_num );

					if ( $Note ) {
						$order->add_order_note( $Note, 1 );
					}

					$Notice = wpautop( wptexturize( $this->success_massage ) );

					$Notice = str_replace( "{transaction_id}", $Transaction_ID, $Notice );

					if ( $Notice ) {
						wc_add_notice( $Notice, 'success' );
					}

					do_action( 'WC_Zibal_Return_from_Gateway_Success', $order_id, $Transaction_ID );

					wp_redirect( add_query_arg( 'wc_status', 'success', $this->get_return_url( $order ) ) );
					exit;
				} else {


					$tr_id = ( $Transaction_ID && $Transaction_ID != 0 ) ? ( '<br/>توکن : ' . $Transaction_ID ) : '';

					$Note = sprintf( __( 'خطا در هنگام بازگشت از بانک : %s %s', 'woocommerce' ), $Message, $tr_id );

					if ( $Note ) {
						$order->add_order_note( $Note, 1 );
					}

					$Notice = wpautop( wptexturize( $this->failed_massage ) );

					$Notice = str_replace( "{transaction_id}", $Transaction_ID, $Notice );

					$Notice = str_replace( "{fault}", $Message, $Notice );

					if ( $Notice ) {
						wc_add_notice( $Notice, 'error' );
					}

					do_action( 'WC_Zibal_Return_from_Gateway_Failed', $order_id, $Transaction_ID, $Fault );

					wp_redirect( wc_get_checkout_url() );
					exit;
				}
			} else {

				$Transaction_ID = $order->get_meta( '_transaction_id' );

				$Notice = wpautop( wptexturize( $this->success_massage ) );

				$Notice = str_replace( "{transaction_id}", $Transaction_ID, $Notice );

				if ( $Notice ) {
					wc_add_notice( $Notice, 'success' );
				}

				wp_redirect( add_query_arg( 'wc_status', 'success', $this->get_return_url( $order ) ) );
				exit;
			}
		}

		/**
		 * @param string $action (PaymentRequest, )
		 * @param array  $params
		 *
		 * @return mixed
		 */
		public function SendRequestToZibal( string $action, array $params ) {
			try {

				$response = wp_safe_remote_post( 'https://gateway.zibal.ir/v1/' . $action, [
					'body'    => json_encode( $params ),
					'headers' => [
						'Content-Type' => 'application/json',
					],
				] );

				if ( is_wp_error( $response ) ) {
					return false;
				}

				$body = wp_remote_retrieve_body( $response );

				return json_decode( $body, true );

			} catch ( Exception $ex ) {
				return false;
			}
		}
	}

}

add_action( 'init', 'PW_Load_Zibal_Gateway', 0 );

add_action( 'after_plugin_row_zibal-payment-gateway-for-woocommerce/index.php', function ( $plugin_file, $plugin_data, $status ) {
	echo '<tr class="inactive"><td>&nbsp;</td><td colspan="2">
        	<div class="notice inline notice-warning notice-alt"><p>افزونه «<strong>درگاه پرداخت زیبال برای فروشگاه ساز ووکامرس</strong>» درون بسته ووکامرس فارسی وجود دارد و نیاز به فعال سازی نیست. به صفحه <a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout' ) . '">ووکامرس > پیکربندی > تسویه حساب</a> مراجعه کنید.</p></div>
        	</td>
        </tr>';
}, 10, 3 );