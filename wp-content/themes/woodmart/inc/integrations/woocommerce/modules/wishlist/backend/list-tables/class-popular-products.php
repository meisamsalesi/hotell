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
class Popular_Products extends WP_List_Table {

	/**
	 * Define what data to show on each column of the table.
	 *
	 * @param array  $item Data.
	 * @param string $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		if ( isset( $item[ $column_name ] ) ) {
			return apply_filters( 'woodmart_column_default', esc_html( $item[ $column_name ] ), $item, $column_name );
		} else {
			// Show the whole array for troubleshooting purposes.
			return apply_filters('woodmart_column_default', print_r($item, true), $item, $column_name); // phpcs:ignore.
		}
	}

	/**
	 * Prints checkbox column.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="popular_products[]" value="%1$s" />',
			$item['product_id']
		);
	}

	/**
	 * Print column for product name
	 *
	 * @param array $item Item for the current record.
	 * @return string Column content
	 * @since 2.0.5
	 */
	public function column_name( $item ) {
		$product = wc_get_product( $item['product_id'] );

		if ( ! $product ) {
			return '';
		}

		$product_url      = $product->get_permalink();
		$product_edit_url = get_edit_post_link( $item['product_id'] );
		$product_name     = $product->get_name();

		$actions     = array(
			'product_id'   => sprintf( 'ID: %s', esc_html( $item['product_id'] ) ),
			'edit'         => sprintf( '<a href="%s" title="%s">%s</a>', $product_edit_url, esc_html__( 'Edit this item', 'woodmart' ), esc_html__( 'Edit', 'woodmart' ) ),
			'view_users'   => sprintf(
				'<a href="%s" title="%s">%s</a>',
				esc_url(
					add_query_arg(
						array(
							'page'       => 'xts-wishlist-settings-page',
							'tab'        => 'xts-users-popular-products',
							'action'     => 'show_users',
							'product_id' => $item['product_id'],
						),
						admin_url( 'edit.php?post_type=product' )
					)
				),
				esc_html__( 'View a list with customers that have added this product to their wishlist', 'woodmart' ),
				esc_html__( 'View customers', 'woodmart' )
			),
			'view_product' => sprintf( '<a href="%s" title="%s" rel="permalink">%s</a>', $product_url, esc_html__( 'View Product', 'woodmart' ), esc_html__( 'View Product', 'woodmart' ) ),
		);
		$row_actions = $this->row_actions( $actions );

		return sprintf(
			'%s<div class="product-details"><strong><a class="row-title" href="%s">%s</a></strong>%s</div>',
			$product->get_image( 'thumbnail' ),
			esc_url(
				add_query_arg(
					array(
						'page'       => 'xts-wishlist-settings-page',
						'tab'        => 'xts-users-popular-products',
						'action'     => 'show_users',
						'product_id' => $item['product_id'],
					),
					admin_url( 'edit.php?post_type=product' )
				)
			),
			$product_name,
			$row_actions
		);
	}

	/**
	 * Print column for product category
	 *
	 * @param array $item Item for the current record.
	 * @return string
	 */
	public function column_category( $item ) {
		$product_categories = wp_get_post_terms( $item['product_id'], 'product_cat' );

		if ( ! $product_categories || is_wp_error( $product_categories ) ) {
			return '-';
		}

		$product_categories_names = wp_list_pluck( $product_categories, 'name' );

		return implode( ', ', $product_categories_names );
	}

	/**
	 * Print column for wishlist count
	 *
	 * @param array $item Item for the current record.
	 * @return string
	 */
	public function column_count( $item ) {
		$column_content = $item['count'];

		return sprintf(
			'<a href="%s">%d</a>',
			esc_url(
				add_query_arg(
					array(
						'page'       => 'xts-wishlist-settings-page',
						'tab'        => 'xts-users-popular-products',
						'action'     => 'show_users',
						'product_id' => $item['product_id'],
					),
					admin_url( 'edit.php?post_type=product' )
				)
			),
			$column_content
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
			'<a href="%s" class="xts-btn xts-color-primary wd-create-promotion">%s</a>',
			esc_url(
				wp_nonce_url(
					add_query_arg(
						array(
							'page'       => 'xts-wishlist-settings-page',
							'tab'        => 'xts-popular-products-in-wishlist',
							'product_id' => $item['product_id'],
						),
						admin_url( 'edit.php?post_type=product' )
					),
					'woodmart_send_promotion_email'
				)
			),
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
			'name'             => esc_html__( 'Name', 'woodmart' ),
			'category'         => esc_html__( 'Category', 'woodmart' ),
			'count'            => esc_html__( 'Wishlist count', 'woodmart' ),
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
			'name'  => array( 'name', false ),
			'count' => array( 'count', false ),
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
		$popular_products_ids = isset( $_REQUEST['popular_products'] ) ? array_map( 'intval', (array) $_REQUEST['popular_products'] ) : false;

		if ( 'create-promotion' === $this->current_action() && ! empty( $popular_products_ids ) ) {
			if ( ! woodmart_check_this_email_notification_is_enabled( 'woocommerce_woodmart_promotional_email_settings', 'yes' ) ) {
				return;
			}

			$users_products = array();

			foreach ( $popular_products_ids as $product_id ) {
				foreach ( array_unique( self::get_user_ids_by_product_id( $product_id ) ) as $user_id ) {
					$users_products[$user_id][] = $product_id;
				}
			}

			try {
				Sends_Promotional::update_promotion_data( $users_products );
			} catch ( Exception $e ) {
				throw( $e );
			}

			wp_safe_redirect( admin_url( '/edit.php?post_type=product&page=xts-wishlist-settings-page&tab=xts-popular-products-in-wishlist' ) );
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

		$_product_id = isset( $_REQUEST['_product_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_product_id'] ) ) : false; // phpcs:ignore.
		$_from       = isset( $_REQUEST['_from'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_from'] ) ) : false; // phpcs:ignore.
		$_to         = isset( $_REQUEST['_to'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_to'] ) ) : false; // phpcs:ignore.

		if ( $_product_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->woodmart_products_table.product_id = %d", $_product_id );
		}

		if ( $_from ) {
			$start_date    = gmdate( 'Y-m-d 00:00:00', strtotime( $_from ) );
			$where_query[] = $wpdb->prepare( 'date_added >= %s', $start_date );
		}

		if ( $_to ) {
			$start_date    = gmdate( 'Y-m-d 23:59:59', strtotime( $_to ) );
			$where_query[] = $wpdb->prepare( 'date_added <= %s', $start_date );
		}

		if ( ! wp_cache_get( 'popular_products_list_table' ) ) {
			$where_query_text = ! empty( $where_query ) ? ' WHERE ' . implode( ' AND ', $where_query ) : '';

			wp_cache_set(
				'popular_products_list_table',
				$wpdb->get_results( //phpcs:ignore;
					"SELECT
						$wpdb->woodmart_products_table.product_id,
						$wpdb->posts.post_title as name,
						count( $wpdb->woodmart_products_table.wishlist_id ) as count
						FROM $wpdb->woodmart_products_table 
							INNER JOIN $wpdb->posts
							    ON $wpdb->woodmart_products_table.product_id = $wpdb->posts.ID"
					. $where_query_text .
					" GROUP BY $wpdb->woodmart_products_table.product_id;",
					ARRAY_A
				)
			);
		}

		return wp_cache_get( 'popular_products_list_table' );
	}

	/**
	 * Get user id`s list by product id.
	 *
	 * @param int|string $product_id Product id.
	 * @return array
	 */
	public static function get_user_ids_by_product_id( $product_id ) {
		global $wpdb;

		if ( $product_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->woodmart_products_table.product_id = %d", $product_id );
		}

		$where_query_text = ! empty( $where_query ) ? ' WHERE ' . implode( ' AND ', $where_query ) : '';

		$user_ids_from_db = $wpdb->get_results( //phpcs:ignore;
			"SELECT $wpdb->woodmart_wishlists_table.user_id
				FROM $wpdb->woodmart_wishlists_table
			        INNER JOIN $wpdb->woodmart_products_table
						ON $wpdb->woodmart_wishlists_table.ID = $wpdb->woodmart_products_table.wishlist_id"
			. $where_query_text .
			";",
			ARRAY_A
		);

		$user_ids = array();

		foreach ( $user_ids_from_db as $user_ids_list ) {
			$user_ids[] = $user_ids_list['user_id'];
		}

		return $user_ids;
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
		$order_by = 'count';
		$order    = 'desc';

		// If orderby is set, use this as the sort column.
		if (!empty($_GET['orderby'])) { // phpcs:ignore.
			$order_by = $_GET['orderby']; // phpcs:ignore.
		}

		// If order is set use this as the order.
		if (!empty($_GET['order'])) { // phpcs:ignore.
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
		$from       = isset( $_REQUEST['_from'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_from'] ) ) : false; // phpcs:ignore.
		$to         = isset( $_REQUEST['_to'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_to'] ) ) : false; // phpcs:ignore.

		if ( ! empty( $product_id ) ) {
			$product = wc_get_product( $product_id );

			if ( $product ) {
				$selected_product = '#' . $product_id . ' &ndash; ' . $product->get_title();
			}
		}

		if ( $product_id || $from || $to ) {
			$need_reset = true;
		}

		wp_enqueue_style(
			'xts-jquery-ui',
			WOODMART_ASSETS . '/css/jquery-ui.css',
			array(),
			WOODMART_VERSION
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
		<input
			type="text"
			name="_from"
			class="date-picker"
			value="<?php echo esc_attr( $from ); ?>"
			placeholder="<?php esc_html_e( 'From:', 'woodmart' ); ?>"
			style="min-width: 200px; vertical-align:middle;"
		/>
		<input
			type="text"
			name="_to"
			class="date-picker"
			value="<?php echo esc_attr( $to ); ?>"
			placeholder="<?php esc_html_e( 'To:', 'woodmart' ); ?>"
			style="min-width: 200px; vertical-align:middle;"
		/>
		<?php
		submit_button( esc_html__( 'Filter', 'woodmart' ), 'button', 'filter_action', false, array( 'id' => 'post-query-submit' ) );

		if ( $need_reset ) {
			echo sprintf(
				'<a href="%s" class="button button-secondary reset-button">%s</a>',
				esc_url(
					add_query_arg(
						array(
							'page' => 'xts-wishlist-settings-page',
							'tab'  => 'xts-popular-products-in-wishlist',
						),
						admin_url( '/edit.php?post_type=product' )
					)
				),
				esc_html__( 'Reset', 'woodmart' )
			);
		}
	}
}
