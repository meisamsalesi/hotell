<?php
/**
 * Class save.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Show_Single_Variations;

use WC_Product_Variation;
use XTS\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Class save.
 */
class Save extends Singleton {
	/**
	 * Register hooks.
	 */
	public function init() {
		add_action( 'save_post_product', array( $this, 'save_product' ), 100, 3 );
		add_action( 'woocommerce_save_product_variation', array( $this, 'save_variation' ), 10, 2 );
		add_action( 'woocommerce_new_product_variation', array( $this, 'save_variation' ), 10 );
	}

	/**
	 * Save product.
	 *
	 * @param integer $post_id Post ID.
	 * @param object  $post Post object.
	 * @param integer $update is updates.
	 * @return void
	 */
	public function save_product( $post_id, $post, $update ) {
		if ( 'publish' !== $post->post_status ) {
			return;
		}

		$product = wc_get_product( $post_id );

		if ( $product->get_type() !== 'variable' ) {
			return;
		}

		$variation_ids = $product->get_children();
		$attributes    = array();

		if ( ! $variation_ids ) {
			return;
		}

		if ( $product->get_attributes() ) {
			foreach ( $product->get_attributes() as $key => $attribute ) {
				if ( $attribute->get_variation() ) {
					continue;
				}

				$attributes[ $key ] = $attribute->get_slugs();
			}
		}

		$taxonomies = apply_filters( 'woodmart_single_variations_taxonomies', array( 'product_cat', 'product_tag' ), $post_id );
		$post_metas = apply_filters( 'woodmart_single_variations_post_meta', array( '_woodmart_new_label_date', '_woodmart_new_label' ), $post_id );

		foreach ( $variation_ids as $variation_id ) {
			if ( $taxonomies ) {
				foreach ( $taxonomies as $taxonomy ) {
					$terms = (array) wp_get_post_terms( $post_id, $taxonomy, array( 'fields' => 'ids' ) );
					wp_set_post_terms( $variation_id, $terms, $taxonomy );
				}
			}

			if ( $post_metas ) {
				foreach ( $post_metas as $post_meta ) {
					if ( isset( $this->request_data()['bulk_edit'] ) ) {
						$data = get_post_meta( $post_id, $post_meta, true );
					} elseif ( isset( $this->request_data()[ $post_meta ] ) ) {
						$data = $this->request_data()[ $post_meta ];
					} else {
						continue;
					}

					update_post_meta( $variation_id, $post_meta, $data );
				}
			}

			if ( $attributes ) {
				foreach ( $attributes as $key => $options ) {
					wp_set_post_terms( $variation_id, $options, $key );
				}
			}

			if ( isset( $this->request_data()['bulk_edit'] ) ) {
				$this->update_variation_option( $variation_id );
			}

			if ( isset( $this->request_data()['_woodmart_exclude_show_single_variation'] ) && ( $this->request_data()['_woodmart_exclude_show_single_variation'] || get_post_meta( $post_id, '_woodmart_exclude_show_single_variation', true ) ) ) {
				update_post_meta( $variation_id, '_wd_show_variation', 'on' === $this->request_data()['_woodmart_exclude_show_single_variation'] ? 'no' : '' );
			}

			$variation = new WC_Product_Variation( $variation_id );
			$variation->set_menu_order( $post->menu_order );
			$variation->save();
		}
	}

	/**
	 * Ajax save variation product.
	 *
	 * @param integer $variation_id Variation ID.
	 * @param bool    $i Index.
	 * @return void
	 */
	public function save_variation( $variation_id, $i = false ) {
		$request_data = $this->request_data();

		if ( ! isset( $request_data['action'] ) || 'woocommerce_save_variations' !== $request_data['action'] ) {
			return;
		}

		if ( isset( $request_data['wd_additional_variation_images'][ $variation_id ] ) ) {
			update_post_meta( $variation_id, '_product_image_gallery', $request_data['wd_additional_variation_images'][ $variation_id ] );
		}

		if ( isset( $request_data['variation_title'][ $i ] ) ) {
			update_post_meta( $variation_id, 'variation_title', $request_data['variation_title'][ $i ] );
		}

		$show_variation = 'no';

		if ( isset( $request_data['wd_show_variation'][ $i ] ) ) {
			$show_variation = $request_data['wd_show_variation'][ $i ];
		}

		update_post_meta( $variation_id, '_wd_show_variation', $show_variation );

		foreach ( $request_data as $key => $data ) {
			if ( 'attribute_' !== substr( $key, 0, 10 ) ) {
				continue;
			}

			$attr_tax = str_replace( 'attribute_', '', $key );
			wp_set_post_terms( $variation_id, $data[ $i ], $attr_tax );
		}
	}

	/**
	 * Update variation option for save bulk edit.
	 *
	 * @param integer $variation_id Variation ID.
	 * @return void
	 */
	public function update_variation_option( $variation_id ) {
		$updated_gallery_ids = get_post_meta( $variation_id, 'wd_additional_variation_images_data', true );

		if ( $updated_gallery_ids ) {
			update_post_meta( $variation_id, '_product_image_gallery', $updated_gallery_ids );
		}

		$variation  = new WC_Product_Variation( $variation_id );
		$attributes = $variation->get_variation_attributes();

		if ( $attributes ) {
			foreach ( $attributes as $key => $term ) {
				$attr_tax = str_replace( 'attribute_', '', $key );
				wp_set_post_terms( $variation_id, $term, $attr_tax );
			}
		}
	}

	/**
	 * Get the current request data ($_REQUEST super global).
	 * This method is added to ease unit testing.
	 *
	 * @return array The $_REQUEST super global.
	 */
	protected function request_data() {
		return $_REQUEST;
	}
}

Save::get_instance();
