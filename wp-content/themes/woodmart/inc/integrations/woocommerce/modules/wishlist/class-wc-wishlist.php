<?php
/**
 * Wishlist.
 */

namespace XTS\Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Options;
use XTS\WC_Wishlist\Wishlist;
use XTS\WC_Wishlist\Ui;

/**
 * Wishlist.
 *
 * @since 1.0.0
 */
class WC_Wishlist {
	/**
	 * Name of the products in wishlist table.
	 *
	 * @var string
	 */
	private $products_table = '';

	/**
	 * Name of the wishlists table.
	 *
	 * @var string
	 */
	private $wishlists_table = '';

	/**
	 * Is table installed.
	 *
	 * @var string
	 */
	private $is_installed;

	/**
	 * Class basic constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Base initialization class required for Module class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		global $wpdb;

		if ( ! woodmart_get_opt( 'wishlist', 1 ) ) {
			return;
		}

		$this->products_table  = $wpdb->prefix . 'woodmart_wishlist_products';
		$this->wishlists_table = $wpdb->prefix . 'woodmart_wishlists';
		$this->is_installed    = get_option( 'wd_wishlist_installed' );

		$this->check_table_exist();
		$this->define_constants();
		$this->include_files();

		$wpdb->woodmart_products_table  = $this->products_table;
		$wpdb->woodmart_wishlists_table = $this->wishlists_table;

		add_action( 'after_switch_theme', array( $this, 'install' ) );
		add_action( 'admin_init', array( $this, 'theme_settings_install' ), 100 );

		add_action( 'wp_ajax_woodmart_add_to_wishlist', array( $this, 'add_to_wishlist_action' ) );
		add_action( 'wp_ajax_nopriv_woodmart_add_to_wishlist', array( $this, 'add_to_wishlist_action' ) );

		add_action( 'wp_ajax_woodmart_remove_from_wishlist', array( $this, 'remove_from_wishlist_action' ) );
		add_action( 'wp_ajax_nopriv_woodmart_remove_from_wishlist', array( $this, 'remove_from_wishlist_action' ) );

		add_filter( 'woodmart_localized_string_array', array( $this, 'update_localized_settings' ) );

		if ( ! $this->is_installed ) {
			return;
		}

		Ui::get_instance();

		add_action( 'init', array( $this, 'custom_rewrite_rule' ), 10 );

		add_filter( 'query_vars', array( $this, 'add_query_vars' ) );
	}

	/**
	 * This method checks to see if the desired tables for the wishlist exist.
	 */
	private function check_table_exist() {
		global $wpdb;

		if ( $this->is_installed ) {
			return;
		}

		$wishlists_table_count = $wpdb->query( "SHOW TABLES WHERE `Tables_in_{$wpdb->dbname}` LIKE '{$this->products_table}%' OR `Tables_in_{$wpdb->dbname}` LIKE '{$this->wishlists_table}%'" );//phpcs:ignore

		if ( 2 === $wishlists_table_count ) {
			update_option( 'wd_wishlist_installed', true );
			$this->is_installed = true;
		}
	}

	/**
	 * Add rewrite rules for wishlist.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function custom_rewrite_rule() {
		$id   = (int) woodmart_get_opt( 'wishlist_page' );
		$slug = (string) get_post_field( 'post_name', $id );

		add_rewrite_rule( '^' . $slug . '/([^/]*)/page/([^/]*)?', 'index.php?page_id=' . $id . '&wishlist_id=$matches[1]&paged=$matches[2]', 'top' );
		add_rewrite_rule( '^' . $slug . '/page/([^/]*)?', 'index.php?page_id=' . $id . '&paged=$matches[1]', 'top' );
		add_rewrite_rule( '^' . $slug . '/([^/]*)/?', 'index.php?page_id=' . $id . '&wishlist_id=$matches[1]', 'top' );
	}

	/**
	 * Add query vars for wishlist rewrite rules.
	 *
	 * @since 1.0
	 *
	 * @param array $vars Vars.
	 *
	 * @return array
	 */
	public function add_query_vars( $vars ) {
		$vars[] = 'wishlist_id';
		return $vars;
	}

	/**
	 * Add product to the wishlist AJAX action.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function add_to_wishlist_action() {
		check_ajax_referer( 'woodmart-wishlist-add', 'key' );

		if ( ! is_user_logged_in() && woodmart_get_opt( 'wishlist_logged' ) ) {
			return false;
		}

		$product_id  = (int) trim( $_GET['product_id'] ); //phpcs:ignore
		$group       = '';
		$wishlist    = $this->get_wishlist();
		$wishlist_id = '';

		if ( isset( $_GET['group'] ) ) { //phpcs:ignore
			$group = woodmart_clean( $_GET['group'] ); //phpcs:ignore
		}

		if ( $group && 'disable' !== woodmart_get_opt( 'wishlist_show_popup', 'disable' ) && is_user_logged_in() ) {
			$result_db = $wishlist->get_wishlist_id_by_current_user( $group );

			if ( $result_db ) {
				$wishlist_id = $result_db;
			} else {
				$wishlist_id = $wishlist->create_group( $group );
			}
		}

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			global $sitepress;
			$product_id = wpml_object_id_filter( $product_id, 'product', true, $sitepress->get_default_language() );
		}

		$response = array(
			'status'    => $wishlist->add( $product_id, $wishlist_id ) ? 'success' : 'errors',
			'count'     => $wishlist->get_count(),
			'fragments' => apply_filters( 'woodmart_get_update_wishlist_fragments', array() ),
			'hash'      => apply_filters( 'woodmart_get_wishlist_hash', '' ),
		);

		$wishlist->update_count_cookie();

		wp_send_json( $response );

		exit;
	}

	/**
	 * Remove product from the wishlist AJAX action.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function remove_from_wishlist_action() {
		check_ajax_referer( 'wd-wishlist-page', 'key' );

		if ( ! is_user_logged_in() && woodmart_get_opt( 'wishlist_logged' ) ) {
			return false;
		}

		$product_id   = woodmart_clean( $_GET['product_id'] ); //phpcs:ignore
		$group_id     = '';
		$product_atts = array();

		if ( isset( $_GET['atts'] ) ) {
			$product_atts = woodmart_clean( $_GET['atts'] ); //phpcs:ignore
		}

		if ( isset( $_GET['group_id'] ) ) {
			$group_id = woodmart_clean( $_GET['group_id'] ); //phpcs:ignore
		}

		$wishlist = $this->get_wishlist( $group_id );

		if ( is_array( $product_id ) ) {
			foreach ( $product_id as $id ) {
				$this->remove_product_from_wishlist( $wishlist, $id, $group_id );
			}
		} else {
			$this->remove_product_from_wishlist( $wishlist, $product_id, $group_id );
		}

		$wishlist->update_count_cookie();

		$products = $wishlist->get_product_ids_by_wishlist_id( $wishlist->get_id() );

		if ( $products ) {
			$products = array_map(
				function( $item ) {
					return $item['product_id'];
				},
				$products
			);

			if ( isset( $product_atts['items_per_page'] ) && count( $products ) <= $product_atts['items_per_page'] && '1' !== $product_atts['ajax_page'] ) {
				--$product_atts['ajax_page'];
			}

			$product_atts['include'] = implode( ',', $products );

			$content = woodmart_shortcode_products( $product_atts );
		} else {
			ob_start();

			Ui::get_instance()->wishlist_empty_content( ! $group_id );

			$content = ob_get_clean();
		}

		$response = array(
			'status'           => 'success',
			'count'            => $wishlist->get_count(),
			'wishlist_content' => $content,
			'fragments'        => apply_filters( 'woodmart_get_update_wishlist_fragments', array() ),
			'hash'             => apply_filters( 'woodmart_get_wishlist_hash', '' ),
		);

		wp_send_json( $response );

		exit;
	}

	/**
	 * Remove product from wishlist.
	 *
	 * @param object  $wishlist Current wishlist.
	 * @param integer $product_id Product ID.
	 * @param integer $group_id Group ID.
	 * @return void
	 */
	public function remove_product_from_wishlist( $wishlist, $product_id, $group_id ) {
		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			global $sitepress;
			$product_id = wpml_object_id_filter( $product_id, 'product', true, $sitepress->get_default_language() );
		}

		$wishlist->remove( intval( $product_id ), $group_id );

		do_action( 'woodmart_remove_product_from_wishlist', $product_id );
	}

	/**
	 * Get wishlist object.
	 *
	 * @param integer $wishlist_id Wishlist id.
	 *
	 * @return object
	 */
	public function get_wishlist( $wishlist_id = false ) {
		return new Wishlist( $wishlist_id );
	}

	/**
	 * Define constants.
	 *
	 * @since 1.0.0
	 */
	private function define_constants() {
		define( 'XTS_WISHLIST_DIR', WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/wishlist/' );
	}

	/**
	 * Include main files.
	 *
	 * @since 1.0.0
	 */
	private function include_files() {
		$files = array(
			'functions',
			'class-storage-interface',
			'class-db-storage',
			'class-cookies-storage',
			'class-ui',
			'class-wishlist',
			'class-sends-about-products-wishlists',
			'backend/class-backend',
		);

		if ( woodmart_get_opt( 'wishlist_expanded' ) && is_user_logged_in() ) {
			$files[] = 'class-wishlist-group';
		}

		foreach ( $files as $file ) {
			$path = XTS_WISHLIST_DIR . $file . '.php';
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}
	}

	/**
	 * Install module and create tables on theme settings save.
	 *
	 * @since 1.0
	 */
	public function theme_settings_install() {
		if ( ! isset( $_GET['settings-updated'] ) ) {
			return;
		}

		$this->install();
	}

	/**
	 * Install module and create tables.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function install() {
		if ( $this->is_installed || ! woodmart_get_opt( 'wishlist', 1 ) ) {
			return;
		}

		$default_wishlist_name = esc_html__( 'My wishlist', 'woodmart' );

		$sql = "CREATE TABLE {$this->wishlists_table} (
					ID INT( 11 ) NOT NULL AUTO_INCREMENT,
					user_id INT( 11 ) NOT NULL,
					wishlist_group varchar( 255 ) DEFAULT '{$default_wishlist_name}' NOT NULL,
					date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY  ( ID )
				) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		$sql .= "CREATE TABLE {$this->products_table} (
					ID int( 11 ) NOT NULL AUTO_INCREMENT,
					product_id varchar( 255 ) NOT NULL,
					wishlist_id int( 11 ) NULL,
					date_added timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					on_sale boolean NOT NULL,
					PRIMARY KEY  ( ID ),
					KEY ( product_id )
				) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		update_option( 'wd_wishlist_installed', true );
		update_option( 'woodmart_upgrade_database_wishlist', true );
		update_option( 'woodmart_added_column_on_sale_in_product_db', true );

		return true;
	}

	/**
	 * Uninstall tables.
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function uninstall() {
		global $wpdb;

		if ( ! $this->is_installed ) {
			return;
		}

		$sql = "DROP TABLE IF EXISTS {$this->wishlists_table};";//phpcs:ignore
		$wpdb->query( $sql );//phpcs:ignore

		$sql = "DROP TABLE IF EXISTS {$this->products_table};";//phpcs:ignore
		$wpdb->query( $sql );//phpcs:ignore

		return true;
	}

	/**
	 * Update localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function update_localized_settings( $settings ) {
		$settings['wishlist_expanded']        = ( woodmart_get_opt( 'wishlist_expanded' ) && is_user_logged_in() ) ? 'yes' : 'no';
		$settings['wishlist_show_popup']      = woodmart_get_opt( 'wishlist_show_popup' );
		$settings['wishlist_page_nonce']      = wp_create_nonce( 'wd-wishlist-page' );
		$settings['wishlist_fragments_nonce'] = wp_create_nonce( 'wd-wishlist-fragments' );
		$settings['wishlist_remove_notice']   = esc_html__( 'Do you really want to remove these products?', 'woodmart' );
		$settings['wishlist_hash_name']       = apply_filters( 'woodmart_wishlist_hash_name', 'woodmart_wishlist_hash_' . md5( get_current_blog_id() . '_' . get_site_url( get_current_blog_id(), '/' ) ) );
		$settings['wishlist_fragment_name']   = apply_filters( 'woodmart_wishlist_fragment_name', 'woodmart_wishlist_fragments_' . md5( get_current_blog_id() . '_' . get_site_url( get_current_blog_id(), '/' ) ) );

		if ( woodmart_get_opt( 'wishlist_expanded' ) ) {
			$settings['wishlist_current_default_group_text'] = esc_html__( 'Current default group', 'woodmart' );
			$settings['wishlist_default_group_text']         = esc_html__( 'Default group', 'woodmart' );
			$settings['wishlist_rename_group_notice']        = esc_html__( 'Title is empty!', 'woodmart' );
		}

		return $settings;
	}
}

new WC_Wishlist();
