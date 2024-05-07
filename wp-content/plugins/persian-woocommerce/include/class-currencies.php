<?php

defined( 'ABSPATH' ) || exit;

class Persian_Woocommerce_Currencies extends Persian_Woocommerce_Core {

	/** @var array */
	public $currencies;

	public static $currency = null;

	public function __construct() {

		self::$currency = get_woocommerce_currency();

		$this->currencies = [
			'IRR'  => __( 'ریال', 'woocommerce' ),
			'IRHR' => __( 'هزار ریال', 'woocommerce' ),
			'IRT'  => __( 'تومان', 'woocommerce' ),
			'IRHT' => __( 'هزار تومان', 'woocommerce' ),
		];

		add_filter( 'woocommerce_currencies', [ $this, 'currencies' ] );
		add_filter( 'woocommerce_currency_symbol', [ $this, 'currency_symbol' ], 10, 2 );
		add_filter( 'woocommerce_structured_data_product_offer', [ $this, 'fix_prices_in_structured_data' ], 100 );

		add_filter( 'rank_math/snippet/rich_snippet_product_entity', [ $this, 'fix_prices_in_structured_data' ], 100 );
		add_filter( 'rank_math/opengraph/facebook/product_price_amount', [ $this, 'convert_to_IRR' ], 100 );
		add_filter( 'rank_math/opengraph/facebook/product_price_currency', function () {
			return 'IRR';
		}, 100 );
	}

	public function currencies( array $currencies ): array {
		return $this->currencies + $currencies;
	}

	public function currency_symbol( $currency_symbol, $currency ) {
		return $this->currencies[ $currency ] ?? $currency_symbol;
	}

	public function fix_prices_in_structured_data( array $markup_offer ): array {

		foreach ( $markup_offer as $key => &$value ) {

			if ( $key === 'priceCurrency' ) {
				$value = 'IRR';
			}

			if ( in_array( $key, [ 'price', 'lowPrice', 'highPrice' ], true ) ) {
				$value = $this->convert_to_IRR( $value );
			}

			if ( is_array( $value ) ) {
				$value = $this->fix_prices_in_structured_data( $value );
			}

		}

		return $markup_offer;
	}

	public function convert_to_IRR( $price ): int {

		$price = intval( $price );

		if ( self::$currency == 'IRT' ) {
			return $price * 10;
		}

		if ( self::$currency == 'IRHR' ) {
			return $price * 1000;
		}

		if ( self::$currency == 'IRHT' ) {
			return $price * 10000;
		}

		return $price;
	}
}

new Persian_Woocommerce_Currencies();