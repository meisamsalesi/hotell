<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function returns quick shop of the product by ID. Variations form HTML
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodmart_quick_shop' ) ) {
	function woodmart_quick_shop($id = false) {
		if( isset($_GET['id']) ) {
			$id = sanitize_text_field( (int) $_GET['id'] );
		}
		if( ! $id || ! woodmart_woocommerce_installed() ) {
			return;
		}

		global $post;

		$args = array( 'post__in' => array($id), 'post_type' => 'product' );

		$quick_posts = get_posts( $args );

		woodmart_enqueue_inline_style( 'woo-opt-quick-shop' );
		woodmart_enqueue_inline_style( 'woo-mod-stock-status' );

		foreach( $quick_posts as $post ) :
			setup_postdata($post);
			?>
			<div class="quick-shop-wrapper wd-quantity-overlap wd-fill wd-scroll">
				<div class="quick-shop-close wd-action-btn wd-style-text wd-cross-icon">
					<a href="#" rel="nofollow noopener">
						<?php esc_html_e( 'Close', 'woodmart' ); ?>
					</a>
				</div>
				<div class="quick-shop-form text-center wd-scroll-content">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>
			</div>
			<?php
		endforeach;

		wp_reset_postdata(); 

		die();
	}

	add_action( 'wp_ajax_woodmart_quick_shop', 'woodmart_quick_shop' );
	add_action( 'wp_ajax_nopriv_woodmart_quick_shop', 'woodmart_quick_shop' );

}

/**
 * ------------------------------------------------------------------------------------------------
 * Quick shop element
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'woodmart_quick_shop_wrapper' ) ) {
	function woodmart_quick_shop_wrapper() {
		if ( ! woodmart_get_opt( 'quick_shop_variable' ) ) {
			return;
		}
		?>
			<div class="quick-shop-wrapper wd-quantity-overlap wd-fill wd-scroll">
				<div class="quick-shop-close wd-action-btn wd-style-text wd-cross-icon"><a href="#" rel="nofollow noopener"><?php esc_html_e('Close', 'woodmart'); ?></a></div>
				<div class="quick-shop-form text-center wd-scroll-content">
				</div>
			</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_load_available_variations' ) ) {
	function woodmart_load_available_variations() {
		if ( empty( $_GET['id'] ) ) { // phpcs:ignore
			return;
		}

		$product = wc_get_product( absint( $_GET['id'] ) ); // phpcs:ignore

		if ( ! $product ) {
			return;
		}

		$cache          = apply_filters( 'woodmart_swatches_cache', true );
		$transient_name = 'woodmart_swatches_cache_' . $product->get_id();

		if ( $cache ) {
			$available_variations = get_transient( $transient_name );
		} else {
			$available_variations = array();
		}

		if ( ! $available_variations ) {
			$available_variations = $product->get_available_variations();

			if ( $cache ) {
				set_transient( $transient_name, $available_variations, apply_filters( 'woodmart_swatches_cache_time', WEEK_IN_SECONDS ) );
			}
		}

		wp_send_json( $available_variations );
	}

	add_action( 'wp_ajax_woodmart_load_available_variations', 'woodmart_load_available_variations' );
	add_action( 'wp_ajax_nopriv_woodmart_load_available_variations', 'woodmart_load_available_variations' );
}
