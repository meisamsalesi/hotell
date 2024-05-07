<?php
/**
 * Class query.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Show_Single_Variations;

use WP_Query;
use XTS\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Class query.
 */
class Query extends Singleton {
	/**
	 * Register hooks.
	 */
	public function init() {
		if ( ! woodmart_get_opt( 'show_single_variation' ) ) {
			return;
		}

		add_filter( 'posts_clauses', array( $this, 'posts_clauses' ), 100, 2 );
		add_action( 'pre_get_posts', array( $this, 'add_variations_to_product_query' ) );

		add_action( 'woocommerce_product_query', array( $this, 'add_variations_to_query' ), 50, 1 );
		add_action( 'woodmart_quick_view_posts_args', array( $this, 'add_variations_to_quickview' ), 10, 1 );

		add_filter( 'woocommerce_product_title', array( $this, 'variation_title' ), 10, 2 );
		add_filter( 'woocommerce_product_variation_title', array( $this, 'variation_title' ), 10, 4 );
		add_filter( 'woocommerce_product_variation_get_average_rating', array( $this, 'get_average_rating' ), 10, 2 );

		add_filter( 'get_the_excerpt', array( $this, 'get_the_excerpt' ), 10, 2 );
		add_action( 'woocommerce_display_product_attributes', array( $this, 'variation_product_attributes' ), 10, 2 );
	}

	/**
	 * Update request for product variation.
	 *
	 * @param array  $clauses Request.
	 * @param object $query Query.
	 * @return array
	 */
	public function posts_clauses( $clauses, $query ) {
		global $wpdb;

		if ( ! empty( $query->query_vars['woodmart_single_variations_filter'] ) ) {
			if ( woodmart_get_opt( 'hide_variation_parent' ) && ( ! woodmart_get_opt( 'wishlist_page' ) || get_queried_object_id() !== (int) woodmart_get_opt( 'wishlist_page' ) && empty( $_POST['atts']['is_wishlist'] ) ) ) { //phpcs:ignore
				$clauses['where'] .= " AND 0 = (select count(*) as totalpart from {$wpdb->posts} as posts where posts.post_parent = {$wpdb->posts}.ID and posts.post_type = 'product_variation' ) ";
			}

			if ( strripos( $clauses['where'], 'wp_wc_product_attributes_lookup' ) ) {
				if ( woodmart_get_opt( 'hide_variation_parent' ) ) {
					$clauses['where'] = str_replace( 'product_or_parent_id', 'product_id', $clauses['where'] );
				} else {
					$data_requests = explode( ') temp )', $clauses['where'] );

					foreach ( $data_requests as $key => $request ) {
						if ( ')' === $request ) {
							continue;
						}

						$data_requests[ $key ] .= ' UNION SELECT product_id FROM wp_wc_product_attributes_lookup lt ' . strrchr( $request, 'WHERE' );
					}
					$clauses['where'] = implode( ') temp )', $data_requests );
				}
			}

			$clauses['where'] .= " AND {$wpdb->posts}.ID NOT IN (
			    SELECT {$wpdb->posts}.ID
			    FROM {$wpdb->posts}
			    left JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)
			    WHERE $wpdb->postmeta.meta_key = '_wd_show_variation' AND $wpdb->postmeta.meta_value = 'no'
			)";
		}

		return $clauses;
	}

	/**
	 * Adds Variations to the given WP_Query object.
	 *
	 * @param WP_Query $query The query to be modified.
	 *
	 * @return void
	 */
	public function add_variations_to_query( $query ) {
		$query->set( 'post_type', array( 'product', 'product_variation' ) );
		$query->set( 'woodmart_single_variations_filter', 'yes' );
	}

	/**
	 * Add Variations to all Product queries. If any query has * 'product' as post_type, add 'product_variation' to it.
	 *
	 * @param WP_Query $query The query to be modified.
	 *
	 * @return void
	 */
	public function add_variations_to_product_query( $query ) {
		if ( ( is_admin() && ( ! isset( $_REQUEST['action'] ) ) ) || isset( $query->query['product'] ) || ! empty( $query->query['wd_show_variable_products'] ) ) { //phpcs:ignore
			return;
		}

		global $pagenow;

		$post_type = array_filter( (array) $query->get( 'post_type' ) );

		if ( in_array( 'product', $post_type, true ) && 'edit.php' !== $pagenow ) {
			$query->set( 'post_type', array( 'product', 'product_variation' ) );
			$query->set( 'woodmart_single_variations_filter', 'yes' );
		}
	}

	/**
	 * Add variations to QuickView.
	 *
	 * @param array $args Arguments.
	 *
	 * @return array
	 */
	public function add_variations_to_quickview( $args ) {
		if ( empty( $args ) || ! isset( $args['post__in'] ) ) {
			return $args;
		}

		$product = wc_get_product( current( $args['post__in'] ) );

		if ( $product->get_parent_id() ) {
			$args['post__in'] = (array) $product->get_parent_id();
		}

		return $args;
	}

	/**
	 * Title for variation product.
	 *
	 * @param string $title Product title.
	 * @param object $product Product data.
	 * @return string
	 */
	public function variation_title( $title, $product ) {
		if ( ! $product->is_type( 'variation' ) ) {
			return $title;
		}

		$saved_title = get_post_meta( $product->get_id(), 'variation_title', true );

		if ( ! empty( $saved_title ) ) {
			return $saved_title;
		}

		return $title;
	}

	/**
	 * Inherit parent rating.
	 *
	 * @param float  $value Value rating.
	 * @param Object $product Product object.
	 *
	 * @return float
	 */
	public function get_average_rating( $value, $product ) {
		$parent_product = wc_get_product( $product->get_parent_id() );

		if ( ! $parent_product || ! $parent_product->get_average_rating() ) {
			return $value;
		}

		return $parent_product->get_average_rating();
	}

	/**
	 * Get excerpt for product variation.
	 *
	 * @param string $except Except.
	 * @param object $post Post.
	 * @return string
	 */
	public function get_the_excerpt( $except, $post ) {
		if ( 'product_variation' !== $post->post_type ) {
			return $except;
		}

		$content = get_post_meta( $post->ID, '_variation_description', true );

		if ( ! $content && ! empty( $post->post_parent ) ) {
			$parent  = wc_get_product( $post->post_parent );
			$content = get_the_excerpt( $parent->get_id() );
		}

		if ( $content ) {
			return $content;
		}

		return $except;
	}

	/**
	 * Get variation product attributes.
	 *
	 * @param array  $product_attributes Products attributes.
	 * @param object $product Product.
	 * @return array
	 */
	public function variation_product_attributes( $product_attributes, $product ) {
		if ( 'variation' !== $product->get_type() ) {
			return $product_attributes;
		}

		$product_parent = wc_get_product( $product->get_parent_id() );
		$attributes     = array_filter( $product_parent->get_attributes(), 'wc_attributes_array_filter_visible' );

		foreach ( $attributes as $attribute ) {
			$values = array();

			if ( $attribute->is_taxonomy() ) {
				$attribute_taxonomy = $attribute->get_taxonomy_object();
				$attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

				if ( ! $attribute->get_variation() ) {
					foreach ( $attribute_values as $attribute_value ) {
						$value_name = esc_html( $attribute_value->name );

						if ( $attribute_taxonomy->attribute_public ) {
							$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
						} else {
							$values[] = $value_name;
						}
					}
				} else {
					$term_slug  = $product->get_attributes()[ $attribute->get_name() ];
					$value_name = get_term_by( 'slug', $term_slug, $attribute->get_name() )->name;

					if ( $attribute_taxonomy->attribute_public ) {
						$values[] = '<a href="' . esc_url( get_term_link( get_term_by( 'slug', $term_slug, $attribute->get_name() )->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
					} else {
						$values[] = $value_name;
					}
				}
			} else {
				$values = $attribute->get_options();

				foreach ( $values as &$value ) {
					$value = make_clickable( esc_html( $value ) );
				}
			}

			$product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
				'label' => wc_attribute_label( $attribute->get_name() ),
				'value' => apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ),
			);
		}

		return $product_attributes;
	}
}

Query::get_instance();
