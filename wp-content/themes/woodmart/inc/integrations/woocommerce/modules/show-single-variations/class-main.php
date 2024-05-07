<?php
/**
 * The main show single variations class.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Show_Single_Variations;

use XTS\Options;
use XTS\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * The main show single variations class.
 */
class Main extends Singleton {
	/**
	 * Register hooks.
	 */
	public function init() {
		add_action( 'init', array( $this, 'add_options' ), 10 );

		if ( ! woodmart_get_opt( 'show_single_variation' ) ) {
			return;
		}

		$this->include_files();

		add_action( 'woocommerce_variation_options', array( $this, 'add_exclude_variation_option' ), 1, 3 );
		add_action( 'woocommerce_variation_options', array( $this, 'get_option' ), 15, 3 );
	}

	/**
	 * Include files.
	 */
	public function include_files() {
		require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/show-single-variations/class-save.php' );
		require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/show-single-variations/class-query.php' );
	}

	/**
	 * Add option.
	 *
	 * @return void
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'show_single_variation',
				'name'        => esc_html__( 'Show single variation', 'woodmart' ),
				'hint'        => '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-single-variation.jpg" alt="">',
				'description' => wp_kses( __( 'Enable it to show each variation as a separate product on the shop page. You need to resave variable products to make this option work. You can do this separately or using the bulk edit function. Read more information in our <a href="https://xtemos.com/docs-topic/show-single-variation/" target="_blank">documentation</a>.', 'woodmart' ), true ),
				'group'       => esc_html__( 'Variation as product', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'variable_products_section',
				'notices'     => array(
					'switcher' => esc_html__( 'You need to resave variable products to make this option work. You can do this separately or using the bulk edit function.', 'woodmart' ),
				),
				'default'     => false,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 170,
			)
		);
		Options::add_field(
			array(
				'id'          => 'hide_variation_parent',
				'name'        => esc_html__( 'Hide variations parent', 'woodmart' ),
				'description' => esc_html__( 'You can show only variations on the shop page excluding the main parent product.', 'woodmart' ),
				'group'       => esc_html__( 'Variation as product', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'variable_products_section',
				'default'     => false,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 180,
			)
		);
	}

	/**
	 * Output control in product variation.
	 *
	 * @param integer $loop Numbers variations.
	 * @param array   $variation_data Variation data.
	 * @param object  $variation Variation product object.
	 *
	 * @return void
	 */
	public function get_option( $loop, $variation_data, $variation ) {
		$variation_title = get_post_meta( $variation->ID, 'variation_title', true );

		?>
		<div class="form-field variation form-row variation">
			<?php
				woocommerce_wp_text_input(
					array(
						'id'    => 'variation_title[' . esc_attr( $loop ) . ']',
						'label' => esc_html__( 'Variation Title', 'woocommerce-single-variations' ),
						'type'  => 'text',
						'value' => $variation_title,
					)
				);
			?>
		</div>
		<?php
	}

	/**
	 * Output control in product variation.
	 *
	 * @param integer $loop Numbers variations.
	 * @param array   $variation_data Variation data.
	 * @param object  $variation Variation product object.
	 *
	 * @return void
	 */
	public function add_exclude_variation_option( $loop, $variation_data, $variation ) {
		$enable = get_post_meta( $variation->ID, '_wd_show_variation', true );
		$enable = 'on' === $enable || '' === $enable;

		?>
		<label>
			<input type="checkbox" class="checkbox show_variation_product" name="wd_show_variation[<?php echo esc_attr( $loop ); ?>]" <?php checked( $enable ); ?> />
			<?php esc_html_e( 'Show variation product', 'woodmart' ); ?>
		</label>
		<?php
	}
}

Main::get_instance();
