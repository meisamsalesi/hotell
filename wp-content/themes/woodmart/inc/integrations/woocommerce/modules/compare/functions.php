<?php
/**
 * Compare helpers functions.
 *
 * @package woodmart
 */

use XTS\Modules\Compare;
use XTS\Modules\Compare\Ui;

if ( ! function_exists( 'woodmart_get_compare_page_url' ) ) {
	/**
	 * Get compare page ID.
	 *
	 * @since 3.3
	 */
	function woodmart_get_compare_page_url() {
		$page_id = woodmart_get_opt( 'compare_page' );

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			$page_id = wpml_object_id_filter( $page_id, 'page', true );
		}

		return get_permalink( $page_id );
	}
}

if ( ! function_exists( 'woodmart_get_compare_count' ) ) {
	/**
	 * Get compare number.
	 */
	function woodmart_get_compare_count() {
		return Compare::get_instance()->get_compare_count();
	}
}

if ( ! function_exists( 'woodmart_add_to_compare_loop_btn' ) ) {
	/**
	 * Add to compare button on loop product.
	 */
	function woodmart_add_to_compare_loop_btn() {
		if ( woodmart_get_opt( 'compare' ) && woodmart_get_opt( 'compare_on_grid' ) ) {
			Ui::get_instance()->add_to_compare_btn( 'wd-action-btn wd-style-icon wd-compare-icon' );
		}

		if ( ! class_exists( 'YITH_Woocompare' ) || 'yes' !== get_option( 'yith_woocompare_compare_button_in_products_list' ) ) {
			return;
		}

		global $product;
		$product_id = $product->get_id();

		if ( ! isset( $button_text ) || 'default' === $button_text ) {
			$button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'woodmart' ) );
		}

		?>
		<div class="product-compare-button wd-action-btn wd-style-icon wd-compare-icon">
			<?php if ( $product_id || ! apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) ) : ?>
				<a href="<?php echo esc_url( woodmart_compare_add_product_url( $product_id ) ); ?>" class="compare" data-product_id="<?php echo esc_attr( $product_id ); ?>" rel="nofollow noopener">
					<?php echo esc_html( $button_text ); ?>
				</a>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_compare_add_product_url' ) ) {
	/**
	 * The URL to add the product into the comparison table YITH.
	 *
	 * @param integer $product_id ID of the product to add.
	 * @return string
	 */
	function woodmart_compare_add_product_url( $product_id ) {
		$url_args = array(
			'action' => 'yith-woocompare-add-product',
			'id'     => $product_id,
		);

		$lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;
		if ( $lang ) {
			$url_args['lang'] = isset( $_GET['lang'] ) ? $_GET['lang'] : $lang; //phpcs:ignore
		}

		return apply_filters( 'yith_woocompare_add_product_url', esc_url_raw( add_query_arg( $url_args, site_url() ) ), 'yith-woocompare-add-product', $url_args );
	}
}

if ( ! function_exists( 'woodmart_compare_available_fields' ) ) {
	/**
	 * All available fields for Theme Settings sorter option.
	 *
	 * @param bool $new New options.
	 *
	 * @return mixed
	 */
	function woodmart_compare_available_fields() {
		return Compare::get_instance()->compare_available_fields( true );
	}
}
