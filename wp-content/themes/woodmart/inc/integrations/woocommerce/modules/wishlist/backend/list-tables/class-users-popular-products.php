<?php
/**
 * This file describes class for render view popular products in wishlist list in WordPress admin panel.
 *
 * @package Woodmart.
 */

namespace XTS\WC_Wishlist\Backend\List_Table;

use WP_List_Table;
use XTS\WC_Wishlist\Sends_About_Products_Wishlists;
use XTS\WC_Wishlist\Sends_Promotional;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Create a new table class that will extend the WP_List_Table.
 */
class Users_Popular_Products extends WP_List_Table {

	/**
	 * Define what data to show on each column of the table.
	 *
	 * @param array  $item        Data.
	 * @param string $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		if ( isset( $item[ $column_name ] ) ) {
			return apply_filters( 'woodmart_column_default', esc_html( $item[ $column_name ] ), $item, $column_name );
		} else {
			// Show the whole array for troubleshooting purposes.
			return apply_filters( 'woodmart_column_default', print_r( $item, true ), $item, $column_name ); // phpcs:ignore.
		}
	}

	/**
	 * Print column for user thumbnail.
	 *
	 * @param array $item Item for the current record.
	 * @return string Column content
	 */
	public function column_thumb( $item ) {
		$avatar   = get_avatar( $item['user_id'], 40 );
		$edit_url = get_edit_user_link( $item['user_id'] );

		return sprintf( '<a href="%s">%s</a>', $edit_url, $avatar );
	}

	/**
	 * Prints checkbox column.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="user_ids[]" value="%1$s" />',
			$item['user_id']
		);
	}

	/**
	 * Print column for username
	 *
	 * @param array $item Item for the current record.
	 * @return string Column content
	 * @since 2.0.5
	 */
	public function column_name( $item ) {
		if ( ! $item['user_id'] ) {
			return sprintf( '- %s -', esc_html__( 'guest', 'woodmart' ) );
		}

		$user = get_user_by( 'id', $item['user_id'] );

		$user_edit_url = get_edit_user_link( $item['user_id'] );
		$user_name     = $user->user_login;

		$actions     = array(
			'ID'      => sprintf( 'ID: %s', esc_html( $item['user_id'] ) ),
			'edit'    => sprintf( '<a href="%s" title="%s">%s</a>', $user_edit_url, esc_html__( 'Edit this customer', 'woodmart' ), esc_html__( 'Edit', 'woodmart' ) ),
		);
		$row_actions = $this->row_actions( $actions );

		return sprintf( '<strong><a class="row-title" href="%s">%s</a></strong>%s', $user_edit_url, $user_name, $row_actions );
	}

	/**
	 * Print column for date added.
	 *
	 * @param array $item Item for the current record.
	 * @return string Column content
	 * @since 2.0.5
	 */
	public function column_date_added( $item ) {
		$date_added = $item['date_added'];

		return date_i18n( 'd F Y', strtotime( $date_added ) );
	}

	/**
	 * Print column for wishlist.
	 *
	 * @param array $item Item for the current record.
	 * @return string Column content
	 * @since 2.0.5
	 */
	public function column_wishlist( $item ) {
		$delete_wishlist_url = add_query_arg(
			array(
				'action'      => 'delete_wishlist',
				'wishlist_id' => $item['wishlist_id'],
			),
			wp_nonce_url( admin_url( 'edit.php?post_type=product' ), 'delete_wishlist', 'delete_wishlist' )
		);

		$actions = apply_filters(
			'woodmart_admin_table_wishlist_id_actions',
			array(
				'view'   => sprintf( '<a href="%s">%s</a>', esc_url( woodmart_get_wishlist_page_url() . $item['wishlist_id'] . '/' ), esc_html__( 'View', 'woodmart' ) ),
				'delete' => sprintf( '<a href="%s">%s</a>', esc_url( $delete_wishlist_url ), esc_html__( 'Delete', 'woodmart' ) ),
			),
			$item,
			$delete_wishlist_url
		);

		return sprintf(
			"<a href='%s'>%s</a>%s",
			esc_url( woodmart_get_wishlist_page_url() . $item['wishlist_id'] . '/' ),
			( ! empty( $item['wishlist_group'] ) ) ? $item['wishlist_group'] : esc_html__( 'My wishlist', 'woodmart' ),
			$this->row_actions( $actions )
		);
	}

	/**
	 * Print column for Create promotion button.
	 *
	 * @param array $item Item for the current record.
	 * @return string
	 */
	public function column_create_promotion( $item ) {
		return sprintf(
			'<a href="%s" class="xts-btn xts-color-primary wd-create-promotion %s">%s</a>',
			esc_url(
				wp_nonce_url(
					add_query_arg(
						array_merge(
							array(
								'page'    => 'xts-wishlist-settings-page',
								'tab'     => 'xts-users-popular-products',
								'user_id' => $item['user_id'],
							),
							! isset( $_REQUEST['product_id'] ) ? array() : array(
								'product_id' => sanitize_text_field( wp_unslash( $_REQUEST['product_id'] ) ),
							)
						),
						admin_url( 'edit.php?post_type=product' )
					),
					'woodmart_send_promotion_email'
				)
			),
			esc_html( in_array( get_userdata( $item['user_id'] )->user_email, get_option( 'woodmart_wishlist_unsubscribed_users', array() ) ) ? 'xts-disabled' : '' ),
			esc_html__( 'Create promotion', 'woodmart' )
		);
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'               => '<input type="checkbox" />',
			'thumb'            => sprintf( '<span class="wc-image tips" data-tip="%s">%s</span>', esc_html__( 'Image', 'woodmart' ), esc_html__( 'Image', 'woodmart' ) ),
			'name'             => esc_html__( 'Name', 'woodmart' ),
			'wishlist'         => esc_html__( 'Wishlist', 'woodmart' ),
			'date_added'       => esc_html__( 'Added on', 'woodmart' ),
			'create_promotion' => sprintf(
				'%s<div class="xts-hint">
						<div class="xts-tooltip xts-top xts-top-left"><div class="xts-tooltip-inner">
							%s
						</div>
					</div>',
				esc_html__( 'Create promotion', 'woodmart' ),
				sprintf(
					'%s <a href="%s">%s</a>.',
					esc_html__( 'When you create a promotion, all customers that have a corresponding product in their wishlist will get an email. You can customize this email content in', 'woodmart' ),
					esc_url( admin_url( 'admin.php?page=wc-settings&tab=email&section=woodmart_promotional_email' ) ),
					esc_html__( 'WooCommerce -> Settings -> Emails -> Wishlist “Promotional” email', 'woodmart' )
				)
			),
		);
	}

	/**
	 * Define which columns are hidden.
	 *
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Define the sortable columns.
	 *
	 * @return array[]
	 */
	public function get_sortable_columns() {
		return array(
			'date_added' => array( 'date_added', false ),
		);
	}

	/**
	 * Sets bulk actions for table.
	 *
	 * @return array Array of available actions.
	 */
	public function get_bulk_actions() {
		return array(
			'create-promotion' => esc_html__( 'Create promotion', 'woodmart' ),
		);
	}

	/**
	 * Delete wishlist on bulk action.
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function process_bulk_action() {
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-' . $this->_args['plural'] ) ) { // phpcs:ignore.
			return;
		}

		// Detect when a bulk action is being triggered...
		$user_ids = isset( $_REQUEST['user_ids'] ) ? array_map( 'intval', (array) $_REQUEST['user_ids'] ) : false;

		if ( 'create-promotion' === $this->current_action() && ! empty( $user_ids ) ) {
			if ( ! woodmart_check_this_email_notification_is_enabled( 'woocommerce_woodmart_promotional_email_settings', 'yes' ) ) {
				return;
			}

			$users_products = array_combine( $user_ids, array_fill( 0, count( $user_ids ), $_REQUEST['product_id'] )  );

			try {
				Sends_Promotional::update_promotion_data( $users_products );
			} catch ( Exception $e ) {
				throw( $e );
			}

			wp_safe_redirect( admin_url( '/edit.php?post_type=product&page=xts-wishlist-settings-page&tab=xts-users-popular-products' ) );
			die();
		}
	}

	/**
	 * Prepare the items for the table to process.
	 *
	 * @return void
	 */
	public function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$user_id  = get_current_user_id();

		$items = $this->table_data();
		$data  = array();

		foreach( $items as $item ) {
			if ( ! get_user_by( 'id', $item['user_id'] ) ) {
				continue;
			}

			$data[] = $item;
		}

		usort( $data, array( $this, 'sort_data' ) );

		$per_page     = ! empty( get_user_meta( $user_id, 'wishlists_per_page', true) ) ? get_user_meta( $user_id, 'wishlists_per_page', true) : 20;
		$current_page = $this->get_pagenum();
		$total_items  = count( $data );

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);

		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $data;

		$this->process_bulk_action();
	}

	/**
	 * Get the table data.
	 *
	 * @return array
	 */
	private function table_data() {
		global $wpdb;
		$where_query = array();
		$product_id  = isset( $_REQUEST['product_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['product_id'] ) ) : false; // phpcs:ignore.

		$wishlist_group_exist = ! empty(
			$wpdb->get_results( //phpcs:ignore;
				"SHOW COLUMNS FROM $wpdb->woodmart_wishlists_table LIKE 'wishlist_group'",
				ARRAY_A
			)
		);

		if ( $product_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->woodmart_products_table.product_id = %d", $product_id );
		}

		if ( ! wp_cache_get( 'users_popular_products_list_table' ) ) {
			$where_query_text    = ! empty( $where_query ) ? ' WHERE ' . implode( ' AND ', $where_query ) : '';
			$wishlist_group_text = $wishlist_group_exist ? " $wpdb->woodmart_wishlists_table.wishlist_group," : '';

			wp_cache_set(
				'users_popular_products_list_table',
				$wpdb->get_results( //phpcs:ignore;
					"SELECT
						$wpdb->woodmart_wishlists_table.user_id,
						$wpdb->woodmart_products_table.wishlist_id,"
						. $wishlist_group_text .
						"MAX($wpdb->woodmart_products_table.date_added) as date_added
					FROM $wpdb->woodmart_products_table
					INNER JOIN $wpdb->woodmart_wishlists_table
						ON $wpdb->woodmart_wishlists_table.ID = $wpdb->woodmart_products_table.wishlist_id"
					. $where_query_text .
					" GROUP BY $wpdb->woodmart_products_table.wishlist_id;",
					ARRAY_A
				)
			);
		}

		return wp_cache_get( 'users_popular_products_list_table' );
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET.
	 *
	 * @param array $a First array.
	 * @param array $b Next array.
	 * @return int
	 */
	private function sort_data( $a, $b ) {
		// Set defaults.
		$order_by = 'date_added';
		$order    = 'asc';

		// If orderby is set, use this as the sort column.
		if ( ! empty( $_GET['orderby'] ) ) { // phpcs:ignore.
			$order_by = $_GET['orderby']; // phpcs:ignore.
		}

		// If order is set use this as the order.
		if ( ! empty( $_GET['order'] ) ) { // phpcs:ignore.
			$order = $_GET['order']; // phpcs:ignore.
		}

		$result = strcmp( $a[ $order_by ], $b[ $order_by ] );

		if ( is_numeric( $a[ $order_by ] ) && is_numeric( $a[ $order_by ] ) ) {
			$result = $a[ $order_by ] - $b[ $order_by ];
		}

		if ( 'asc' === $order ) {
			return $result;
		}

		return -$result;
	}
}
