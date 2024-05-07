<?php

namespace XTS\Modules\Layouts;

use WC_Product_Factory;
use WP_Query;

class Single_Product extends Layout_Type {
	/**
	 * Check.
	 *
	 * @param array  $condition Condition.
	 * @param string $type      Layout type.
	 */
	public function check( $condition, $type = '' ) {
		$is_active = false;

		switch ( $condition['condition_type'] ) {
			case 'all':
				$is_active = is_singular( 'product' );
				break;
			case 'product':
				$is_active = (int) woodmart_get_the_ID() === (int) $condition['condition_query'];
				break;
			case 'product_type':
				$is_active = WC_Product_Factory::get_product_type( woodmart_get_the_ID() ) === $condition['condition_query'];
				break;
			case 'product_cat':
			case 'product_tag':
			case 'product_attr_term':
				$terms = wp_get_post_terms( woodmart_get_the_ID(), get_taxonomies(), array( 'fields' => 'ids' ) );

				if ( $terms ) {
					$is_active = in_array( (int) $condition['condition_query'], $terms, true );
				}
				break;
			case 'product_cat_children':
				$terms         = wp_get_post_terms( woodmart_get_the_ID(), get_taxonomies(), array( 'fields' => 'ids' ) );
				$term_children = get_term_children( $condition['condition_query'], 'product_cat' );

				if ( $terms ) {
					$is_active = count( array_diff( $terms, $term_children ) ) !== count( $terms );
				}
				break;
		}

		return $is_active;
	}

	/**
	 * Override template.
	 *
	 * @param string $template Template.
	 *
	 * @return bool|string
	 */
	public function override_template( $template ) {
		if ( woodmart_woocommerce_installed() && is_singular( 'product' ) && Main::get_instance()->has_custom_layout( 'single_product' ) ) {
			$this->display_template();

			return false;
		}

		return $template;
	}

	/**
	 * Display custom template.
	 */
	private function display_template() {
		$this->before_template_content();

		woodmart_enqueue_inline_style( 'woo-single-prod-builder' );
		?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-page' ); ?>>
				<?php $this->template_content( 'single_product' ); // phpcs:ignore ?>
				<?php if ( function_exists( 'WC' ) && is_object( WC()->structured_data ) ) : ?>
					<?php WC()->structured_data->generate_product_data(); ?>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
		<?php
		$this->after_template_content();
	}

	/**
	 * Get preview product id.
	 *
	 * @return int
	 */
	public static function get_preview_product_id() {
		$product_id = woodmart_get_opt( 'single_product_builder_post_data' );

		if ( ! $product_id ) {
			$random_product = new WP_Query(
				array(
					'posts_per_page' => '1',
					'post_type'      => 'product',
				)
			);

			while ( $random_product->have_posts() ) {
				$random_product->the_post();
				$product_id = get_the_ID();
			}

			wp_reset_postdata();
		}

		return $product_id;
	}

	/**
	 * Setup post data.
	 */
	public static function setup_postdata( $force_product_id = false ) {
		global $post, $product;

		if ( ( Main::is_layout_type( 'single_product') && empty( $product ) ) || is_singular( 'woodmart_layout' ) || wp_doing_ajax() || ( isset( $_POST['action'] ) && 'editpost' === $_POST['action'] ) || $force_product_id ) { // phpcs:ignore
			$product_id = $force_product_id ? $force_product_id : self::get_preview_product_id();
			$post = get_post( $product_id ); // phpcs:ignore

			setup_postdata( $post );
		}
	}

	/**
	 * Reset post data.
	 */
	public static function reset_postdata( $force_product_id = false ) {
		if ( is_singular( 'woodmart_layout' ) || wp_doing_ajax() || $force_product_id ) {
			wp_reset_postdata();
		}
	}

	/**
	 * Template content.
	 *
	 * @param string $type Template type.
	 */
	public function template_content( $type ) {
		remove_filter( 'the_content', 'convert_smilies', 20 );

		parent::template_content( $type );

		add_filter( 'the_content', 'convert_smilies', 20 );
	}
}

Single_Product::get_instance();
