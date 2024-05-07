<?php
/**
 * Database storage.
 */

namespace XTS\WC_Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\WC_Wishlist\Storage;
use XTS\Modules\WC_Wishlist;

/**
 * Database storage.
 *
 * @since 1.0.0
 */
class DB_Storage implements Storage {

	/**
	 * Wishlist id.
	 *
	 * @var int
	 */
	private $wishlist_id = 0;

	/**
	 * User id.
	 *
	 * @var int
	 */
	private $user_id = 0;

	/**
	 * Transient name.
	 *
	 * @var string
	 */
	private $cache_name = '';

	/**
	 * Transient name.
	 *
	 * @var string
	 */
	private $cache_name_prefix = 'woodmart_wishlist_';

	/**
	 * Is tables installed.
	 *
	 * @var string
	 */
	private $is_table_exists;

	/**
	 * Set cookie name in the constructor.
	 *
	 * @since 1.0
	 *
	 * @param integer $wishlist_id Wishlist id.
	 * @param integer $user_id User id.
	 *
	 * @return void
	 */
	public function __construct( $wishlist_id, $user_id ) {
		$this->wishlist_id     = $wishlist_id;
		$this->user_id         = $user_id;
		$this->cache_name      = $this->cache_name_prefix . $this->wishlist_id;
		$this->is_table_exists = get_option( 'wd_wishlist_installed' );
	}

	/**
	 * Add product to the wishlist.
	 *
	 * @since 1.0
	 *
	 * @param integer $product_id Product id.
	 * @param integer $wishlist_id Wishlist group ID.
	 *
	 * @return boolean
	 */
	public function add( $product_id, $wishlist_id = 0 ) {
		global $wpdb;

		if ( $this->is_product_exists( $product_id, $wishlist_id ) ) {
			return false;
		}

		if ( ! $wishlist_id ) {
			$wishlist_id = $this->wishlist_id;
		}

		if ( ! $wishlist_id ) {
			return false;
		}

		if ( ! $this->is_table_exists ) {
			return false;
		}

		delete_user_meta( $this->user_id, $this->cache_name );
		delete_user_meta( $this->user_id, $this->cache_name_prefix . $wishlist_id );
		delete_user_meta( $this->user_id, $this->cache_name_prefix . 'group_' . $wishlist_id );

		return $wpdb->insert(
			$wpdb->woodmart_products_table,
			array(
				'product_id'  => $product_id,
				'wishlist_id' => $wishlist_id,
				'date_added'  => current_time( 'mysql', 1 ),
			),
			array(
				'%d',
				'%d',
				'%s',
			)
		);
	}

	/**
	 * Remove product from the wishlist.
	 *
	 * @since 1.0
	 *
	 * @param integer $product_id Product id.
	 * @param integer $wishlist_id Wishlist group ID.
	 *
	 * @return boolean
	 */
	public function remove( $product_id, $wishlist_id = 0 ) {
		global $wpdb;

		if ( ! $this->is_product_exists( $product_id, $wishlist_id ) ) {
			return false;
		}

		if ( ! $this->is_table_exists ) {
			return false;
		}

		if ( ! $wishlist_id ) {
			$wishlist_id = $this->wishlist_id;
		}

		delete_user_meta( $this->user_id, $this->cache_name );
		delete_user_meta( $this->user_id, $this->cache_name_prefix . $wishlist_id );
		delete_user_meta( $this->user_id, $this->cache_name_prefix . 'group_' . $wishlist_id );

		return $wpdb->delete(
			$wpdb->woodmart_products_table,
			array(
				'product_id'  => $product_id,
				'wishlist_id' => $wishlist_id,
			),
			array( '%d', '%d' )
		);
	}

	/**
	 * Remove product from the wishlist.
	 *
	 * @param integer $wishlist_id Product id.
	 *
	 * @return boolean
	 */
	public function remove_group( $wishlist_id ) {
		global $wpdb;

		if ( ! $this->is_table_exists ) {
			return false;
		}

		delete_user_meta( $this->user_id, $this->cache_name );
		delete_user_meta( $this->user_id, $this->cache_name_prefix . $wishlist_id );
		delete_user_meta( $this->user_id, $this->cache_name_prefix . 'group_' . $wishlist_id );
		delete_user_meta( $this->user_id, 'woodmart_wishlist_groups' );

		$wpdb->delete(
			$wpdb->woodmart_products_table,
			array(
				'wishlist_id' => $wishlist_id,
			),
			array( '%d' )
		);

		return $wpdb->delete(
			$wpdb->woodmart_wishlists_table,
			array(
				'ID'      => $wishlist_id,
				'user_id' => $this->user_id,
			),
			array( '%d', '%d' )
		);
	}

	/**
	 * Get all products.
	 *
	 * @return array
	 */
	public function get_all() {
		global $wpdb;

		if ( ! $this->wishlist_id ) {
			return array();
		}

		if ( ! $this->is_table_exists ) {
			return array();
		}

		$cache = get_user_meta( $this->user_id, $this->cache_name, true );

		if ( empty( $cache ) || $cache['expires'] < time() ) {

			if ( woodmart_get_opt( 'wishlist_expanded' ) && $this->is_editable() ) {
				$products = $wpdb->get_results(
					$wpdb->prepare(
						"
							SELECT *
							FROM $wpdb->woodmart_products_table
							WHERE wishlist_id IN 
							( SELECT ID 
							  FROM $wpdb->woodmart_wishlists_table
							  WHERE user_id = %d
							)
						",
						$this->user_id
					),
					ARRAY_A
				);
			} else {
				$products = $wpdb->get_results(
					$wpdb->prepare(
						"
						SELECT *
						FROM $wpdb->woodmart_products_table
						WHERE wishlist_id = %d
					",
						$this->wishlist_id
					),
					ARRAY_A
				);
			}

			$cache = array(
				'expires'  => time() + WEEK_IN_SECONDS,
				'products' => $products,
			);

			update_user_meta( $this->user_id, $this->cache_name, $cache );
		}

		return $cache['products'];
	}

	/**
	 * Is product in compare.
	 *
	 * @since 1.0
	 *
	 * @param integer $product_id Product id.
	 * @param string  $wishlist_id Wishlist group ID.
	 *
	 * @return boolean
	 */
	public function is_product_exists( $product_id, $wishlist_id = 0 ) {
		global $wpdb;

		if ( ! $this->is_table_exists ) {
			return false;
		}

		if ( ! $wishlist_id ) {
			$wishlist_id = $this->wishlist_id;
		}

		$id = $wpdb->get_var(
			$wpdb->prepare(
				"
				SELECT ID
				FROM $wpdb->woodmart_products_table
				WHERE wishlist_id = %d
				AND product_id = %d
			",
				$wishlist_id,
				$product_id
			)
		);

		return ! is_null( $id );
	}

	/**
	 * Get products by wishlist group.
	 *
	 * @param integer $group_id Group id.
	 *
	 * @return array
	 */
	public function get_product_ids_by_wishlist_id( $group_id ) {
		global $wpdb;

		$cache = get_user_meta( $this->user_id, $this->cache_name_prefix . 'group_' . $group_id, true );

		if ( empty( $cache ) || $cache['expires'] < time() ) {
			$cache = array(
				'expires'  => time() + WEEK_IN_SECONDS,
				'products' => $wpdb->get_results(
					$wpdb->prepare(
						"SELECT *
						FROM $wpdb->woodmart_products_table
						WHERE wishlist_id = %d",
						$group_id
					),
					ARRAY_A
				),
			);

			update_user_meta( $this->user_id, $this->cache_name_prefix . 'group_' . $group_id, $cache );
		}

		return $cache['products'];
	}

	/**
	 * Get ID wishlist group and check isset wishlist group with title.
	 *
	 * @param integer $id ID wishlist group or name wishlist group.
	 *
	 * @return string|null
	 */
	public function get_wishlist_id_by_current_user( $id ) {
		global $wpdb;

		return $wpdb->get_var(
			$wpdb->prepare(
				"SELECT ID
				FROM $wpdb->woodmart_wishlists_table
				WHERE user_id = %d
				AND (ID = %d OR wishlist_group = %s)",
				$this->user_id,
				$id,
				$id
			)
		);
	}

	/**
	 * Get wishlist groups by user id.
	 *
	 * @return array|object|null
	 */
	public function get_all_wishlists_by_current_user() {
		global $wpdb;

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM $wpdb->woodmart_wishlists_table
				WHERE user_id = %d",
				$this->user_id
			),
			ARRAY_A
		);
	}

	/**
	 * Get wishlist title.
	 *
	 * @param integer $id Wishlist ID.
	 * @return string|null
	 */
	public function get_wishlist_title_by_wishlist_id( $id ) {
		global $wpdb;

		return $wpdb->get_var(
			$wpdb->prepare(
				"SELECT wishlist_group
				FROM $wpdb->woodmart_wishlists_table
				WHERE ID = %d",
				$id
			)
		);
	}

	/**
	 * Rename wishlist group.
	 *
	 * @param integer $group_id Wishlist group ID.
	 * @param string  $title New title wishlist group.
	 *
	 * @return bool|int
	 */
	public function rename_group( $group_id, $title ) {
		global $wpdb;

		delete_user_meta( $this->user_id, 'woodmart_wishlist_groups' );

		return $wpdb->update(
			$wpdb->woodmart_wishlists_table,
			array(
				'wishlist_group' => $title,
			),
			array(
				'ID'      => $group_id,
				'user_id' => $this->user_id,
			)
		);
	}

	/**
	 * Can user edit this wishlist or just view it.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function is_editable() {
		return Ui::get_instance()->is_editable();
	}
}
