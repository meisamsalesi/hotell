<?php
/**
 * This file describes class for render view all wishlists list in WordPress admin panel.
 *
 * @package Woodmart.
 */

namespace XTS\WC_Wishlist\Backend\List_Table;

use WP_List_Table;
use XTS\WC_Wishlist\Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Create a new table class that will extend the WP_List_Table.
 */
class Wishlists extends WP_List_Table {

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
	 * Prints column for wishlist user
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="wishlist[]" value="%1$s" />',
			$item['ID']
		);
	}

	/**
	 * Prints column for wishlist name
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 * @since 2.0.0
	 */
	public function column_wishlist_group( $item ) {
		$row = '';

		$delete_wishlist_url = add_query_arg(
			array(
				'action'      => 'delete_wishlist',
				'wishlist_id' => $item['ID'],
			),
			wp_nonce_url( admin_url( 'edit.php?post_type=product' ), 'delete_wishlist', 'delete_wishlist' )
		);

		if ( '' != get_option('permalink_structure') ) {
			$view_wishlist_page = home_url( 'wishlist/' . $item['ID'] ); // www.example.com/pagename/test
		} else {
			$view_wishlist_page = add_query_arg(
				array(
					'page_id'     => woodmart_get_opt( 'wishlist_page' ),
					'wishlist_id' => $item['ID'],
				),
				home_url() . '/'
			);
		}

		$actions = apply_filters(
			'woodmart_admin_table_column_name_actions',
			array(
				'view'   => sprintf(
					'<a href="%s">%s</a>',
						esc_url( $view_wishlist_page ),
						esc_html__( 'View', 'woodmart' )
					),
				'delete' => sprintf(
					'<a href="%s">%s</a>',
						esc_url( $delete_wishlist_url ),
						esc_html__( 'Delete', 'woodmart' )
					),
			),
			$item,
			$delete_wishlist_url
		);

		if ( isset( $item['ID'] ) ) {
			$row = sprintf(
				"<a href='%s'>%s</a>%s",
				esc_url( woodmart_get_wishlist_page_url() . $item['ID'] . '/' ),
				( ! empty( $item['wishlist_group'] ) ) ? $item['wishlist_group'] : esc_html__( 'My wishlist', 'woodmart' ),
				$this->row_actions( $actions )
			);
		}

		return $row;
	}

	/**
	 * Return username column for an item
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 * @since 2.0.0
	 */
	public function column_user_name( $item ) {
		$row = '';

		if ( isset( $item['user_id'] ) ) {
			$user = get_user_by( 'id', $item['user_id'] );

			if ( ! empty( $user ) ) {
				$row = sprintf(
					"%s<div class='customer-details'><strong><a href='%s'>%s</a></strong></div>",
					get_avatar( $item['user_id'], 40 ),
					get_edit_user_link( $item['user_id'] ),
					$user->user_login
				);
			} else {
				$row = sprintf( '- %s -', esc_html__( 'guest', 'woodmart' ) );
			}
		}

		return apply_filters( 'woodmart_admin_table_column_username_row', $row, $item );
	}

	/**
	 * Prints column for wishlist number of items
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 * @since 2.0.0
	 */
	public function column_product_count( $item ) {
		return $item['product_count'];
	}

	/**
	 * Prints column for wishlist creation date
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 * @since 2.0.0
	 */
	public function column_date_created( $item ) {
		$row = '';

		if ( isset( $item['date_created'] ) ) {
			$date_created = strtotime( $item['date_created'] );
			$time_diff    = time() - $date_created;

			if ( $time_diff < DAY_IN_SECONDS ) {
				// translators: 1. Date diff since wishlist creation (EG: 1 hour, 2 seconds, etc...).
				$row = sprintf( esc_html__( '%s ago', 'woodmart' ), human_time_diff( $date_created ) );
			} else {
				$row = date_i18n( wc_date_format(), $date_created );
			}
		}

		return $row;
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'             => '<input type="checkbox" />',
			'wishlist_group' => esc_html__( 'Name', 'woodmart' ),
			'user_name'      => esc_html__( 'Customer', 'woodmart' ),
			'product_count'  => esc_html__( 'Items in wishlist', 'woodmart' ),
			'date_created'   => esc_html__( 'Date created', 'woodmart' ),
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
			'wishlist_group' => array( 'wishlist_group', false ),
			'user_name'      => array( 'user_name', false ),
			'product_count'  => array( 'product_count', false ),
			'date_created'   => array( 'date_created', false ),
		);
	}

	/**
	 * Sets bulk actions for table.
	 *
	 * @return array Array of available actions.
	 */
	public function get_bulk_actions() {
		return array(
			'delete' => esc_html__( 'Delete', 'woodmart' ),
		);
	}

	/**
	 * Delete wishlist on bulk action.
	 *
	 * @return void
	 */
	public function process_bulk_action() {
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-' . $this->_args['plural'] ) ) { // phpcs:ignore.
			return;
		}

		// Detect when a bulk action is being triggered...
		$wishlist_ids = isset( $_REQUEST['wishlist'] ) ? array_map( 'intval', (array) $_REQUEST['wishlist'] ) : false;

		if ( 'delete' === $this->current_action() && ! empty( $wishlist_ids ) ) {
			foreach ( $wishlist_ids as $wishlist_id ) {
				try {
					$wishlist = new Wishlist( $wishlist_id );

					$wishlist->remove_group( $wishlist_id );
					$wishlist->update_count_cookie();
				} catch ( Exception $e ) {
					continue;
				}
			}

			wp_safe_redirect( admin_url( '/edit.php?post_type=product&page=xts-wishlist-settings-page&tab=xts-all-wishlists' ) );
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

		$data = $this->table_data();
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

		$search      = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : false; // phpcs:ignore.
		$_product_id = isset( $_REQUEST['_product_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_product_id'] ) ) : false; // phpcs:ignore.
		$_user_id    = isset( $_REQUEST['_user_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_user_id'] ) ) : false; // phpcs:ignore.

		$wishlist_group_exist = ! empty(
			$wpdb->get_results( //phpcs:ignore;
				"SHOW COLUMNS FROM $wpdb->woodmart_wishlists_table LIKE 'wishlist_group'",
				ARRAY_A
			)
		);

		if ( $search && $wishlist_group_exist ) {
			$where_query[] = $wpdb->prepare( "$wpdb->woodmart_wishlists_table.wishlist_group LIKE %s", '%' . $wpdb->esc_like( $search ) . '%' );
		}

		if ( $_product_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->woodmart_products_table.product_id = %d", $_product_id );
		}

		if ( $_user_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->woodmart_wishlists_table.user_id = %d", $_user_id );
		}

		if ( ! wp_cache_get( 'wishlists_list_table' ) ) {
			$where_query_text = ! empty( $where_query ) ? ' WHERE ' . implode( ' AND ', $where_query ) : '';

			wp_cache_set(
				'wishlists_list_table',
				$wpdb->get_results( //phpcs:ignore;
					"SELECT
							$wpdb->woodmart_wishlists_table.*,
							$wpdb->users.user_login as user_name,
							COUNT( $wpdb->woodmart_products_table.product_id ) as product_count
						FROM $wpdb->woodmart_wishlists_table
							INNER JOIN $wpdb->woodmart_products_table
							    ON $wpdb->woodmart_wishlists_table.ID = $wpdb->woodmart_products_table.wishlist_id
						    INNER JOIN $wpdb->users
           						 ON $wpdb->woodmart_wishlists_table.user_id = $wpdb->users.ID"
					. $where_query_text .
					" GROUP BY $wpdb->woodmart_wishlists_table.ID;",
					ARRAY_A
				)
			);
		}

		return wp_cache_get( 'wishlists_list_table' );
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
		$order_by = 'date_created';
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

	/**
	 * Print filters for current table
	 *
	 * @param string $which Top / Bottom.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	protected function extra_tablenav( $which ) {
		if ( 'top' !== $which ) {
			return;
		}

		$need_reset = false;
		$product_id = isset( $_REQUEST['_product_id'] ) ? intval( $_REQUEST['_product_id'] ) : false; // phpcs:ignore.
		$user_id    = isset( $_REQUEST['_user_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_user_id'] ) ) : false; // phpcs:ignore.

		if ( ! empty( $product_id ) ) {
			$product = wc_get_product( $product_id );

			if ( $product ) {
				$selected_product = '#' . $product_id . ' &ndash; ' . $product->get_title();
			}
		}

		if ( ! empty( $user_id ) ) {
			$user = get_user_by( 'id', $user_id );

			if ( $user ) {
				$selected_user = $user->get( 'user_login' );
			}
		}

		if ( $product_id || $user_id ) {
			$need_reset = true;
		}

		wp_enqueue_style(
			'xts-jquery-ui',
			WOODMART_ASSETS . '/css/jquery-ui.css',
			array(),
			WOODMART_VERSION
		);

		wp_enqueue_script(
			'xts-admin-wishlist',
			WOODMART_ASSETS . '/js/wishlist.js',
			array(
				'jquery',
				'jquery-ui-datepicker',
				'select2',
			),
			WOODMART_VERSION,
			true
		);
		?>
		<select
			id="_product_id"
			name="_product_id"
			class="wc-product-search"
			data-security="<?php echo esc_attr( wp_create_nonce( 'search-products' ) ); ?>"
			style="width: 300px;"
		>
			<?php if ( $product_id && isset( $selected_product ) ) : ?>
				<option value="<?php echo esc_attr( $product_id ); ?>" <?php selected( true, true, true ); ?> >
					<?php echo esc_html( $selected_product ); ?>
				</option>
			<?php endif; ?>
		</select>
		<select
			id="_user_id"
			name="_user_id"
			class="xts-users-search"
			data-security="<?php echo esc_attr( wp_create_nonce( 'search-users' ) ); ?>"
			style="width: 300px;"
		>
			<?php if ( $user_id && isset( $selected_user ) ) : ?>
				<option value="<?php echo esc_attr( $user_id ); ?>" <?php selected( true, true, true ); ?> >
					<?php echo esc_html( $selected_user ); ?>
				</option>
			<?php endif; ?>
		</select>
		<?php
		submit_button( esc_html__( 'Filter', 'woodmart' ), 'button', 'filter_action', false, array( 'id' => 'post-query-submit' ) );

		if ( $need_reset ) {
			echo sprintf(
				'<a href="%s" class="button button-secondary reset-button">%s</a>',
				esc_url(
					add_query_arg(
						array(
							'page' => 'xts-wishlist-settings-page',
							'tab'  => 'xts-all-wishlists',
						),
						admin_url( '/edit.php?post_type=product' )
					)
				),
				esc_html__( 'Reset', 'woodmart' )
			);
		}
	}
}
