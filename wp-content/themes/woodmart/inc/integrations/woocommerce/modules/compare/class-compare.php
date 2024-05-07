<?php
/**
 * Compare class.
 *
 * @package woodmart
 */

namespace XTS\Modules;

use WPBMap;
use XTS\Modules\Compare\Ui;
use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Compare class.
 */
class Compare extends Singleton {
	/**
	 * Use cookies name.
	 *
	 * @var int
	 */
	private $cookie_name = 'woodmart_compare_list';

	/**
	 * Init.
	 */
	public function init() {
		$this->include_files();

		add_action( 'init', array( $this, 'hooks' ), 110 );
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 */
	public function hooks() {
		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'compare' ) ) {
			return;
		}

		if ( is_multisite() ) {
			$this->cookie_name .= '_' . get_current_blog_id();
		}

		add_action( 'wp_ajax_woodmart_add_to_compare', array( $this, 'add_to_compare' ) );
		add_action( 'wp_ajax_nopriv_woodmart_add_to_compare', array( $this, 'add_to_compare' ) );

		add_action( 'wp_ajax_woodmart_remove_from_compare', array( $this, 'remove_from_compare' ) );
		add_action( 'wp_ajax_nopriv_woodmart_remove_from_compare', array( $this, 'remove_from_compare' ) );

		add_action( 'wp_ajax_woodmart_remove_category_from_compare', array( $this, 'remove_category_from_compare' ) );
		add_action( 'wp_ajax_nopriv_woodmart_remove_category_from_compare', array( $this, 'remove_category_from_compare' ) );

		add_action( 'wp_ajax_woodmart_get_fragment_product_category_compare', array( $this, 'get_fragment_product_category_compare' ) );
		add_action( 'wp_ajax_nopriv_woodmart_get_fragment_product_category_compare', array( $this, 'get_fragment_product_category_compare' ) );

		add_filter( 'woodmart_get_update_compare_fragments', array( $this, 'get_dropdown_compare_fragments' ) );

		add_filter( 'woodmart_localized_string_array', array( $this, 'add_localized_settings' ) );

		add_action( 'wp', array( $this, 'remove_unnecessary_products' ), 100 );
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		$files = array(
			'class-ui',
			'functions',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/compare/' . $file . '.php' );
		}
	}

	/**
	 * Add localized settings.
	 *
	 * @param array $localized Settings.
	 * @return array
	 */
	public function add_localized_settings( $localized ) {
		$localized['compare_by_category'] = woodmart_get_opt( 'compare_by_category' ) ? 'yes' : 'no';
		$localized['compare_page_nonce']  = wp_create_nonce( 'wd-compare-page' );

		return $localized;
	}

	/**
	 * Get compared products IDs array
	 *
	 * @since 3.3
	 */
	public function get_compared_products() {
		return isset( $_COOKIE[ $this->cookie_name ] ) ? json_decode( sanitize_text_field( wp_unslash( $_COOKIE[ $this->cookie_name ] ) ), true ) : array();
	}

	/**
	 * Add product to compare.
	 */
	public function add_to_compare() {
		$id = sanitize_text_field( $_GET['id'] ); // phpcs:ignore

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			global $sitepress;
			$id = wpml_object_id_filter( $id, 'product', true, $sitepress->get_default_language() );
		}

		$products = $this->get_compared_products();

		if ( ! in_array( $id, $products ) ) { //phpcs:ignore
			$products[] = $id;

			setcookie( $this->cookie_name, wp_json_encode( $products ), 0, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );

			$_COOKIE[ $this->cookie_name ] = wp_json_encode( $products );
		}

		wp_send_json(
			array(
				'count'     => $this->get_compare_count(),
				'fragments' => apply_filters( 'woodmart_get_update_compare_fragments', array() ),
			)
		);
	}

	/**
	 * Remove product to compare.
	 *
	 * @since 3.3
	 */
	public function remove_from_compare() {
		check_ajax_referer( 'wd-compare-page', 'key' );

		$id          = sanitize_text_field( $_GET['id'] ); //phpcs:ignore
		$category_id = '';

		if ( isset( $_GET['category_id'] ) && woodmart_get_opt( 'compare_by_category' ) ) { //phpcs:ignore
			$category_id = sanitize_text_field( $_GET['category_id'] ); //phpcs:ignore
		}

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			global $sitepress;
			$id = wpml_object_id_filter( $id, 'product', true, $sitepress->get_default_language() );
		}

		$products = $this->get_compared_products();

		if ( in_array( $id, $products ) ) { //phpcs:ignore
			foreach ( $products as $key => $product_id ) {
				if ( (int) $id === (int) $product_id ) {
					unset( $products[ $key ] );
				}
			}
		}

		if ( ! $products ) {
			setcookie( $this->cookie_name, false, 0, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );
			$_COOKIE[ $this->cookie_name ] = false;
		} else {
			setcookie( $this->cookie_name, wp_json_encode( $products ), 0, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );
			$_COOKIE[ $this->cookie_name ] = wp_json_encode( $products );
		}

		if ( 'wpb' === woodmart_get_current_page_builder() && class_exists( 'WPBMap' ) ) {
			WPBMap::addAllMappedShortcodes();
		}

		wp_send_json(
			array(
				'count'     => $this->get_compare_count(),
				'table'     => Ui::get_instance()->compare_page( $category_id ),
				'fragments' => apply_filters( 'woodmart_get_update_compare_fragments', array() ),
			)
		);
	}

	/**
	 * Remove category with product in compare.
	 *
	 * @return void
	 */
	public function remove_category_from_compare() {
		check_ajax_referer( 'wd-compare-page', 'key' );

		if ( empty( $_GET['category_id'] ) ) {
			return;
		}

		$category_id = sanitize_text_field( $_GET['category_id'] ); //phpcs:ignore
		$product_ids = $this->get_compared_products();

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			global $sitepress;
			$category_id = wpml_object_id_filter( $category_id, 'product_cat', true, $sitepress->get_default_language() );
		}

		if ( $product_ids ) {
			foreach ( $product_ids as $key => $product_id ) {
				$single_cats = get_the_terms( $product_id, 'product_cat' );

				if ( $single_cats ) {
					foreach ( $single_cats as $single_cat ) {
						if ( intval( $category_id ) === $single_cat->term_id ) {
							unset( $product_ids[ $key ] );
						}
					}
				}
			}
		}

		if ( ! $product_ids ) {
			setcookie( $this->cookie_name, false, 0, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );
			$_COOKIE[ $this->cookie_name ] = false;
		} else {
			setcookie( $this->cookie_name, wp_json_encode( $product_ids ), 0, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );
			$_COOKIE[ $this->cookie_name ] = wp_json_encode( $product_ids );
		}

		wp_send_json(
			array(
				'count'     => $this->get_compare_count(),
				'table'     => Ui::get_instance()->compare_page(),
				'fragments' => apply_filters( 'woodmart_get_update_compare_fragments', array() ),
			)
		);
	}

	/**
	 * Get count product in compare.
	 *
	 * @return int
	 */
	public function get_compare_count() {
		$count    = 0;
		$products = $this->get_compared_products();

		if ( is_array( $products ) ) {
			$count = count( $products );
		}

		return $count;
	}

	/**
	 * Get fragments for compare.
	 *
	 * @return void
	 */
	public function get_fragment_product_category_compare() {
		wp_send_json(
			array(
				'fragments' => apply_filters( 'woodmart_get_update_compare_fragments', array() ),
			)
		);
	}

	/**
	 * Get dropdown compare products category.
	 *
	 * @param array $fragments Fragments.
	 * @return array
	 */
	public function get_dropdown_compare_fragments( $fragments ) {
		if ( ! woodmart_get_opt( 'compare_by_category' ) ) {
			return $fragments;
		}

		ob_start();

		Ui::get_instance()->get_dropdown_with_products_categories();

		$content = ob_get_clean();

		if ( $content ) {
			$fragments['div.wd-header-compare .wd-dropdown'] = $content;
		}

		return $fragments;
	}

	/**
	 * Get product category.
	 *
	 * @return array
	 */
	public function get_product_categories() {
		if ( ! woodmart_get_opt( 'compare_by_category' ) ) {
			return array();
		}

		$product_ids = $this->get_compared_products();
		$categories  = array();

		if ( ! $product_ids ) {
			return array();
		}

		foreach ( $product_ids as $id ) {
			$single_cats = get_the_terms( $id, 'product_cat' );

			if ( ! $single_cats ) {
				continue;
			}

			foreach ( $single_cats as $single_cat ) {
				if ( 1 < count( $single_cats ) && $single_cat->parent && isset( $categories[ $single_cat->parent ] ) ) {
					continue;
				}

				$hide_current_category = false;

				foreach ( $single_cats as $cat ) {
					if ( $single_cat->parent === $cat->term_id ) {
						$hide_current_category = true;
					}
				}

				if ( $hide_current_category ) {
					continue;
				}

				if ( ! isset( $categories[ $single_cat->term_id ] ) ) {
					$categories[ $single_cat->term_id ] = array(
						'name'  => $single_cat->name,
						'slug'  => $single_cat->slug,
						'count' => 1,
					);
				} else {
					++$categories[ $single_cat->term_id ]['count'];
				}
			}
		}

		return $categories;
	}

	/**
	 * All available fields for Theme Settings sorter option.
	 *
	 * @param bool $new New option.
	 *
	 * @return array
	 */
	public function compare_available_fields( $new = false ) {
		$product_attributes = array();

		if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
			$product_attributes = wc_get_attribute_taxonomies();
		}

		if ( $new ) {
			$options = array(
				'description'  => array(
					'name'  => esc_html__( 'Description', 'woodmart' ),
					'value' => 'description',
				),
				'dimensions'   => array(
					'name'  => esc_html__( 'Dimensions', 'woodmart' ),
					'value' => 'dimensions',
				),
				'weight'       => array(
					'name'  => esc_html__( 'Weight', 'woodmart' ),
					'value' => 'weight',
				),
				'availability' => array(
					'name'  => esc_html__( 'Availability', 'woodmart' ),
					'value' => 'availability',
				),
				'sku'          => array(
					'name'  => esc_html__( 'Sku', 'woodmart' ),
					'value' => 'sku',
				),
			);

			if ( count( $product_attributes ) > 0 ) {
				foreach ( $product_attributes as $attribute ) {
					$options[ 'pa_' . $attribute->attribute_name ] = array(
						'name'  => wc_attribute_label( $attribute->attribute_label ),
						'value' => 'pa_' . $attribute->attribute_name,
					);
				}
			}
			return $options;
		}

		$fields = array(
			'enabled'  => array(
				'description'  => esc_html__( 'Description', 'woodmart' ),
				'sku'          => esc_html__( 'Sku', 'woodmart' ),
				'availability' => esc_html__( 'Availability', 'woodmart' ),
			),
			'disabled' => array(
				'weight'     => esc_html__( 'Weight', 'woodmart' ),
				'dimensions' => esc_html__( 'Dimensions', 'woodmart' ),
			),
		);

		if ( count( $product_attributes ) > 0 ) {
			foreach ( $product_attributes as $attribute ) {
				$fields['disabled'][ 'pa_' . $attribute->attribute_name ] = $attribute->attribute_label;
			}
		}

		return $fields;
	}

	/**
	 * Remove unnecessary products.
	 *
	 * @since 1.0
	 */
	public function remove_unnecessary_products() {
		global $post;

		if ( ! isset( $post->ID ) || intval( woodmart_get_opt( 'compare_page' ) ) !== $post->ID || get_transient( 'wd_compare_unnecessary_products' ) ) {
			return;
		}

		$products = $this->get_compared_products();

		if ( $products ) {
			foreach ( $products as $key => $product_id ) {
				if ( 'publish' !== get_post_status( $product_id ) || 'product' !== get_post_type( $product_id ) ) {
					unset( $products[ $key ] );
				}
			}
		}

		if ( ! $products ) {
			setcookie( $this->cookie_name, false, 0, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );
			$_COOKIE[ $this->cookie_name ] = false;
		} else {
			setcookie( $this->cookie_name, wp_json_encode( $products ), 0, COOKIEPATH, COOKIE_DOMAIN, woodmart_cookie_secure_param(), false );
			$_COOKIE[ $this->cookie_name ] = wp_json_encode( $products );
		}

		set_transient( 'wd_compare_unnecessary_products', true, DAY_IN_SECONDS );
	}
}

Compare::get_instance();
