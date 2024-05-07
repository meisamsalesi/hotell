<?php
/**
 * Quick buy.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Quick_Buy;

use XTS\Options;
use XTS\Singleton;

/**
 * Quick buy.
 */
class Main extends Singleton {
	/**
	 * Constructor.
	 */
	public function init() {
		$this->include_files();
		$this->add_options();

		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'output_quick_buy_button' ), 1 );
	}

	/**
	 * Include files.
	 */
	public function include_files() {
		require_once WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/quick-buy/class-redirect.php';
	}

	/**
	 * Add options in theme settings.
	 */
	public function add_options() {
		Options::add_section(
			array(
				'id'       => 'single_product_buy_now',
				'parent'   => 'general_single_product_section',
				'name'     => esc_html__( 'Buy now', 'woodmart' ),
				'priority' => 35,
				'icon'     => 'xts-i-bag',
			)
		);

		Options::add_field(
			array(
				'id'          => 'buy_now_enabled',
				'name'        => esc_html__( 'Buy now button', 'woodmart' ),
				'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'buy-now-button.jpg" alt="">', 'woodmart' ), true ),
				'description' => wp_kses( __( 'Add an extra button next to the “Add to cart” that will add the product to the cart and redirect it to the cart or checkout. Read more information in our <a href="https://xtemos.com/docs-topic/buy-now-button/">documentation</a>.', 'woodmart' ), 'default' ),
				'type'        => 'switcher',
				'section'     => 'single_product_buy_now',
				'default'     => false,
				'priority'    => 260,
			)
		);

		Options::add_field(
			array(
				'id'       => 'buy_now_redirect',
				'name'     => esc_html__( 'Redirect location', 'woodmart' ),
				'type'     => 'select',
				'section'  => 'single_product_buy_now',
				'default'  => 'checkout',
				'options'  => array(
					'checkout' => array(
						'name'  => esc_html__( 'Checkout page', 'woodmart' ),
						'value' => 'checkout',
					),
					'cart'     => array(
						'name'  => esc_html__( 'Cart page', 'woodmart' ),
						'value' => 'cart',
					),
				),
				'requires' => array(
					array(
						'key'     => 'quick_buy_enabled',
						'compare' => 'equals',
						'value'   => true,
					),
				),
				'priority' => 270,
			)
		);
	}

	/**
	 * Output quick buy button.
	 */
	public function output_quick_buy_button() {
		if ( ! is_singular( 'product' ) && ! woodmart_loop_prop( 'is_quick_view' ) || ! woodmart_get_opt( 'buy_now_enabled' ) ) {
			return;
		}
		?>
			<button id="wd-add-to-cart" type="submit" name="wd-add-to-cart" value="<?php echo get_the_ID(); ?>" class="wd-buy-now-btn button alt">
				<?php esc_html_e( 'Buy now', 'woodmart' ); ?>
			</button>
		<?php
	}
}

Main::get_instance();
