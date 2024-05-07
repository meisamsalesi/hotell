<?php
/**
 * Wishlist.
 */

namespace XTS\WC_Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\WC_Wishlist\DB_Storage;
use XTS\WC_Wishlist\Cookies_Storage;

/**
 * Wishlist.
 *
 * @since 1.0.0
 */
class Wishlist {

	/**
	 * Wishlist id.
	 *
	 * @var int
	 */
	private $id = 0;

	/**
	 * User id.
	 *
	 * @var int
	 */
	private $user_id = 0;

	/**
	 * Use cookies or db.
	 *
	 * @var int
	 */
	private $use_cookies = false;

	/**
	 * Storage object.
	 *
	 * @var object
	 */
	private $storage = null;


	/**
	 * Is tables installed.
	 *
	 * @var string
	 */
	private $is_table_exists;

	/**
	 * Can user edit this wishlist or just view it.
	 *
	 * @var boolean
	 */
	private $editable = true;

	/**
	 * Set up wishlist object and storage.
	 *
	 * @since 1.0
	 *
	 * @param integer $id Wishlist id.
	 * @param integer $user_id User id.
	 * @param boolean $read_only Read only wishlist.
	 *
	 * @return void
	 */
	public function __construct( $id = false, $user_id = false, $read_only = false ) {
		$this->id              = $id;
		$this->user_id         = $user_id;
		$this->is_table_exists = get_option( 'wd_wishlist_installed' );
		$wishlist_id           = get_query_var( 'wishlist_id' );

		if ( $read_only ) {
			$this->user_id = $this->get_current_wishlist_user();
		} elseif ( ! $user_id ) {
			$this->user_id = $this->get_current_user_id();
		}

		if ( ! $id ) {
			$this->id = $this->get_current_user_wishlist();
		}

		if ( is_user_logged_in() && ! $this->has_wishlist() && ! $read_only ) {
			$this->create();
		}

		if ( ! is_user_logged_in() && ! $read_only ) {
			$this->use_cookies = true;
			$this->storage     = new Cookies_Storage();
		} else {
			$this->storage = new DB_Storage( $this->get_id(), $this->get_user_id() );
		}

		// Move products from cookies to database if you just logged in and clean cookie.
		if ( is_user_logged_in() && ! $read_only ) {
			$this->move_products_if_needed();
		}

		if ( woodmart_get_opt( 'wishlist_page' ) && get_queried_object_id() === (int) woodmart_get_opt( 'wishlist_page' ) ) {
			$this->remove_unnecessary_products();
		}

		if ( $wishlist_id && (int) $wishlist_id > 0 ) {
			$this->editable = false;
		}

		add_action( 'delete_user', array( $this, 'remove_all_user_wishlists' ) );
	}

	/**
	 * Remove all user wishlists from database.
	 *
	 * @param int $id ID of the user to delete.
	 * @return void
	 */
	public function remove_all_user_wishlists( $id ) {
		global $wpdb;

		$where_query         = '';
		$wishlists_ids_from_db = $wpdb->get_results(
			$wpdb->prepare(
				"
					SELECT ID
					FROM $wpdb->woodmart_wishlists_table
					WHERE user_id = %d 
					",
				$id
			),
			ARRAY_N
		);

		foreach ( $wishlists_ids_from_db as $wishlists_id ) {
			$where_query .= ! empty( $where_query ) ? ','  . $wishlists_id[0] : $wishlists_id[0];
		}

		if ( empty( $where_query ) ) {
			return;
		}

		$wpdb->query(
			"DELETE FROM $wpdb->woodmart_products_table
				WHERE $wpdb->woodmart_products_table.wishlist_id IN ( $where_query )"
		);

		$wpdb->delete(
			$wpdb->woodmart_wishlists_table,
			array(
				'user_id' => $id,
			),
			array( '%d' )
		);
	}

	/**
	 * Remove unnecessary products.
	 *
	 * @since 1.0
	 */
	public function remove_unnecessary_products() {
		$unnecessary_products = get_transient( 'wishlist_unnecessary_products' );

		if ( false !== $unnecessary_products ) {
			return;
		}

		foreach ( $this->get_all() as $product_data ) {
			$product_id  = $product_data['product_id'];
			$wishlist_id = ! empty( $product_data['wishlist_id'] ) ? $product_data['wishlist_id'] : $this->get_id();

			if ( 'publish' !== get_post_status( $product_id ) || 'product' !== get_post_type( $product_id ) ) {
				$this->remove( $product_id, $wishlist_id );
			}
		}

		$this->update_count_cookie();

		set_transient( 'wishlist_unnecessary_products', true, DAY_IN_SECONDS );
	}

	/**
	 * Get wishlist ID.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get user id.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function get_user_id() {
		return $this->user_id;
	}

	/**
	 * Has wishlist in the database.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	private function has_wishlist() {
		return $this->get_current_user_wishlist();
	}

	/**
	 * Get current user ID if logged in.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	private function get_current_user_id() {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		$current_user = wp_get_current_user();

		if ( ! $current_user->exists() ) {
			return false;
		}

		return $current_user->ID;
	}

	/**
	 * Get current wishlist ID from the database.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	private function get_current_user_wishlist() {
		global $wpdb;

		if ( ! is_user_logged_in() ) {
			return false;
		}

		if ( ! $this->is_table_exists ) {
			return false;
		}

		$cache = get_transient( 'wishlist_current_user_' . $this->get_user_id() );
		$id    = '';

		if ( $cache ) {
			return $cache;
		}

		if ( woodmart_get_opt( 'wishlist_expanded' ) && is_user_logged_in() ) {
			$id = $wpdb->get_var(
				$wpdb->prepare(
					"
					SELECT ID
					FROM $wpdb->woodmart_wishlists_table
					WHERE user_id = %d 
					",
					$this->get_user_id()
				)
			);
		}

		if ( ! $id ) {
			$id = $wpdb->get_var(
				$wpdb->prepare(
					"
					SELECT ID
					FROM $wpdb->woodmart_wishlists_table
					WHERE user_id = %d
					",
					$this->get_user_id()
				)
			);
		}

		set_transient( 'wishlist_current_user_' . $this->get_user_id(), $id, HOUR_IN_SECONDS * 2 );

		return $id;
	}

	/**
	 * Get user for this wishlist.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	private function get_current_wishlist_user() {
		global $wpdb;

		if ( ! $this->is_table_exists ) {
			return false;
		}

		$id = $wpdb->get_var(
			$wpdb->prepare(
				"
				SELECT user_id
				FROM $wpdb->woodmart_wishlists_table
				WHERE ID = %d
			",
				$this->get_id()
			)
		);

		return $id;
	}

	/**
	 * Create wishlist in the database.
	 *
	 * @param string $group Title wishlist group.
	 *
	 * @return bool|int
	 * @since 1.0
	 */
	private function create( $group = '' ) {
		global $wpdb;

		if ( ! $this->is_table_exists ) {
			return false;
		}

		if ( get_option( 'woodmart_upgrade_database_wishlist' ) && woodmart_get_opt( 'wishlist_expanded' ) ) {
			delete_user_meta( $this->get_user_id(), 'woodmart_wishlist_groups' );

			if ( ! $group ) {
				$group = esc_html__( 'My wishlist', 'woodmart' );
			}

			$wpdb->insert(
				$wpdb->woodmart_wishlists_table,
				array(
					'user_id'        => $this->get_user_id(),
					'wishlist_group' => ucfirst( $group ),
					'date_created'   => current_time( 'mysql', 1 ),
				),
				array(
					'%d',
					'%s',
					'%s',
				)
			);
		} else {
			$wpdb->insert(
				$wpdb->woodmart_wishlists_table,
				array(
					'user_id'      => $this->get_user_id(),
					'date_created' => current_time( 'mysql', 1 ),
				),
				array(
					'%d',
					'%s',
				)
			);
		}

		$insert_id = $wpdb->insert_id;

		delete_transient( 'wishlist_current_user_' . $this->get_user_id() );

		$this->id = $this->get_current_user_wishlist();

		return $insert_id;
	}

	/**
	 * Create wishlist in the database.
	 *
	 * @param string $group Title wishlist group.
	 *
	 * @return bool|int
	 */
	public function create_group( $group ) {
		return $this->create( $group, false );
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
	public function add( $product_id, $wishlist_id ) {
		return $this->storage->add( $product_id, $wishlist_id );
	}

	/**
	 * Remove product from the wishlist.
	 *
	 * @since 1.0
	 *
	 * @param integer $product_id Product id.
	 * @param integer $group_id Wishlist group ID.
	 *
	 * @return boolean
	 */
	public function remove( $product_id, $group_id ) {
		return $this->storage->remove( $product_id, $group_id );
	}

	/**
	 * Remove group products from the wishlist.
	 *
	 * @param integer $group_id Group id.
	 *
	 * @return boolean
	 */
	public function remove_group( $group_id ) {
		delete_transient( 'wishlist_current_user_' . $this->get_user_id() );

		return $this->storage->remove_group( $group_id );
	}

	/**
	 * Get all products.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function get_all() {
		return $this->storage->get_all();
	}

	/**
	 * Get all products.
	 *
	 * @param integer $group_id Wishlist group ID.
	 *
	 * @return array
	 */
	public function get_product_ids_by_wishlist_id( $group_id ) {
		return $this->storage->get_product_ids_by_wishlist_id( $group_id );
	}

	/**
	 * Get ID wishlist group and check isset wishlist group with title.
	 *
	 * @param integer|string $id ID wishlist group or name wishlist group.
	 *
	 * @return string|null
	 */
	public function get_wishlist_id_by_current_user( $id ) {
		return $this->storage->get_wishlist_id_by_current_user( $id );
	}

	/**
	 * Get wishlist groups by user id.
	 *
	 * @return array|object|null
	 */
	public function get_all_wishlists_by_current_user() {
		return $this->storage->get_all_wishlists_by_current_user();
	}

	/**
	 * Get wishlist title by id.
	 *
	 * @param integer $id Wishlist ID.
	 * @return string
	 */
	public function get_wishlist_title_by_wishlist_id( $id ) {
		return $this->storage->get_wishlist_title_by_wishlist_id( $id );
	}

	/**
	 * Rename wishlist group.
	 *
	 * @param integer $group_id Group ID.
	 * @param string  $title Title group.
	 *
	 * @return mixed
	 */
	public function rename_group( $group_id, $title ) {
		return $this->storage->rename_group( $group_id, $title );
	}

	/**
	 * Is product in compare.
	 *
	 * @since 1.0
	 *
	 * @param integer $product_id Product id.
	 *
	 * @return boolean
	 */
	public function is_product_exists( $product_id ) {
		return $this->storage->is_product_exists( $product_id );
	}

	/**
	 * Update count products cookie.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function update_count_cookie() {
		$cookie_name = 'woodmart_wishlist_count';

		if ( is_user_logged_in() ) {
			$cookie_name .= '_logged';
		}

		if ( is_multisite() ) {
			$cookie_name .= '_' . get_current_blog_id();
		}

		woodmart_set_cookie( $cookie_name, $this->get_count() );
	}

	/**
	 * Get number of products in the wishlist.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function get_count() {
		$all = $this->get_all();

		if ( ! $this->editable ) {
			return 0;
		}

		return count( $all );
	}

	/**
	 * Move products from cookie to database if needed.
	 *
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function move_products_if_needed() {

		$cookie_storage = new Cookies_Storage();

		$cookie_products = $cookie_storage->get_all();

		if ( empty( $cookie_products ) ) {
			return false;
		}

		foreach ( $cookie_products as $item ) {
			$this->storage->add( $item['product_id'] );
			$cookie_storage->remove( $item['product_id'] );
		}

		$cookie_name = 'woodmart_wishlist_count';

		if ( is_multisite() ) {
			$cookie_name .= '_' . get_current_blog_id();
		}

		woodmart_set_cookie( $cookie_name, false );

		$this->update_count_cookie();
	}
}
