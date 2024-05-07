<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Woocommerce_Ir_Gateway_PayIr' ) ) :

	$settings = get_option( 'woocommerce_payir_settings', [] );

	if ( isset( $settings['enabled'] ) && $settings['enabled'] == 'yes' ) {
		Persian_Woocommerce_Gateways::register( 'PayIr' );
	}

	class Woocommerce_Ir_Gateway_PayIr extends Persian_Woocommerce_Gateways {

		public function __construct() {

			$this->method_title = 'Pay.ir';
			$this->icon         = apply_filters( 'woocommerce_ir_gateway_payir_icon', PW()->plugin_url( 'assets/images/payir.png' ) );

			parent::init( $this );
		}

		public function fields() {

			return [
				'api'               => [
					'title'       => 'API',
					'type'        => 'text',
					'description' => 'API درگاه Pay.ir',
					'default'     => '',
					'desc_tip'    => true,
				],
				'sandbox'           => [
					'title'       => 'فعالسازی حالت آزمایشی',
					'type'        => 'checkbox',
					'label'       => 'فعالسازی حالت آزمایشی Pay.ir',
					'description' => 'برای فعال سازی حالت آزمایشی Pay.ir چک باکس را تیک بزنید.',
					'default'     => 'no',
					'desc_tip'    => true,
				],
				'cancelled_massage' => [],
				'shortcodes'        => [
					'transaction_id' => 'شماره تراکنش',
				],
			];
		}

		public function request( $order ) {

			$amount       = $this->get_total( 'IRR' );
			$callback     = $this->get_verify_url();
			$mobile       = $this->get_order_mobile();
			$order_number = $this->get_order_props( 'order_number' );
			$description  = 'شماره سفارش #' . $order_number;
			$apiID        = $this->option( 'sandbox' ) == '1' ? 'test' : $this->option( 'api' );

			$pay = wp_remote_post( 'https://pay.ir/pg/send', [
				'body' => [
					'api'          => $apiID,
					'amount'       => $amount,
					'redirect'     => urlencode( $callback ),
					'mobile'       => $mobile,
					'factorNumber' => $order_number,
					'description'  => $description,
					'resellerId'   => '1000000800',
				],
			] );

			$pay = wp_remote_retrieve_body( $pay );

			if ( empty( $pay ) ) {
				return 'خطایی در اتصال به درگاه رخ داده است!';
			}

			$pay = json_decode( $pay );

			if ( $pay->status ) {
				$this->redirect( 'https://pay.ir/pg/' . $pay->token );
			} else {
				return ! empty( $pay->errorMessage ) ? $pay->errorMessage : ( ! empty( $pay->errorCode ) ? $this->errors( $pay->errorCode ) : '' );
			}
		}

		public function verify( $order ) {

			$apiID = $this->option( 'sandbox' ) == '1' ? 'test' : $this->option( 'api' );
			$token = $this->get( 'token' );

			$this->check_verification( $token );

			$error  = '';
			$status = 'failed';

			if ( $this->get( 'status' ) ) {

				$pay = wp_remote_post( 'https://pay.ir/pg/verify', [
					'body' => [
						'api'   => $apiID,
						'token' => $token,
					],
				] );

				$pay = wp_remote_retrieve_body( $pay );

				if ( ! empty( $pay ) ) {

					$pay = json_decode( $pay );

					if ( $pay->status ) {
						$status = 'completed';
					} else {
						$error = ! empty( $pay->errorMessage ) ? $pay->errorMessage : ( ! empty( $pay->errorCode ) ? $this->errors( ( $pay->errorCode . '1' ) ) : '' );
					}

				}

			} else {
				$error = $this->post( 'message' );
			}

			$this->set_shortcodes( [ 'token' => $token ] );

			return compact( 'status', 'token', 'error' );
		}

		private function errors( $error ) {

			switch ( $error ) {

				case '-1' :
					$message = 'ارسال Api الزامی می باشد.';
					break;

				case '-2' :
					$message = 'ارسال Amount (مبلغ تراکنش) الزامی می باشد.';
					break;

				case '-3' :
					$message = 'مقدار Amount (مبلغ تراکنش)باید به صورت عددی باشد.';
					break;

				case '-4' :
					$message = 'Amount نباید کمتر از 1000 باشد.';
					break;

				case '-5' :
					$message = 'ارسال Redirect الزامی می باشد.';
					break;

				case '-6' :
					$message = 'درگاه پرداختی با Api ارسالی یافت نشد و یا غیر فعال می باشد.';
					break;

				case '-7' :
					$message = 'فروشنده غیر فعال می باشد.';
					break;

				case '-8' :
					$message = 'آدرس بازگشتی با آدرس درگاه پرداخت ثبت شده همخوانی ندارد.';
					break;

				case 'failed' :
					$message = 'تراکنش با خطا مواجه شد.';
					break;

				case '-11' :
					$message = 'ارسال Api الزامی می باشد.';
					break;

				case '-21' :
					$message = 'ارسال token الزامی می باشد.';
					break;

				case '-31' :
					$message = 'درگاه پرداختی با Api ارسالی یافت نشد و یا غیر فعال می باشد.';
					break;

				case '-41' :
					$message = 'فروشنده غیر فعال می باشد.';
					break;

				case '-51' :
					$message = 'تراکنش با خطا مواجه شده است.';
					break;

				default:
					$message = 'خطای ناشناخته رخ داده است.';
					break;
			}

			return $message;
		}
	}
endif;