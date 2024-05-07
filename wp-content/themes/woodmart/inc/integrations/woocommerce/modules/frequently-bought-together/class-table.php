<?php
/**
 * Frequently bought together class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Frequently_Bought_Together;

use WP_Query;

/**
 * Class Table
 *
 * @package Woodmart
 */
class Bundles_Table extends \WP_List_Table {
	/**
	 * Constructor.
	 */
	public function __construct( $product_id = '' ) {
		parent::__construct(
			array(
				'singular' => __( 'types', 'woodmart' ),
				'plural'   => __( 'type', 'woodmart' ),
				'ajax'     => true,
			)
		);

		$this->_column_headers = array(
			$this->get_columns(),
		);
		$this->prepare_items( $product_id );
	}

	/**
	 * Default column.
	 *
	 * @param array  $item Data.
	 * @param string $column_name Column name.
	 *
	 * @return array
	 */
	protected function column_default( $item, $column_name ) {
		return $item;
	}

	/**
	 * Get content in column Name.
	 *
	 * @param array $item Data.
	 *
	 * @return void
	 */
	protected function column_name( $item ) {
		$edit_link = get_edit_post_link( $item['id'] );
		$status    = '';

		if ( 'publish' !== $item['status'] ) {
			$status .= ' — <span class="post-state">' . $item['status'] . '</span>';
		}

		?>
		<strong>
			<a href="<?php echo esc_url( $edit_link ); ?>">
				<?php echo esc_html( $item['title'] ); ?>
			</a>
			<?php echo wp_kses( $status, true ); ?>
		</strong>

		<div class="row-actions">
			<span class="edit">
				<a href="<?php echo esc_url( $edit_link ); ?>">
					<?php esc_html_e( 'Edit', 'woodmart' ); ?>
				</a>
				|
			</span>
			<span class="delete">
				<a href="#" class="xts-delete-bundle" data-id="<?php echo esc_attr( $item['id'] ); ?>" data-link="ajax-delete">
					<?php esc_html_e( 'Delete', 'woodmart' ); ?>
				</a>
			</span>
		</div>
		<?php
	}

	/**
	 * Get content in column Product.
	 *
	 * @param array $item Data.
	 *
	 * @return string
	 */
	protected function column_products( $item ) {
		return '<span>' . implode( ' | ', $item['products'] ) . '</span>';
	}

	/**
	 * Return array with columns titles.
	 *
	 * @return array
	 */
	public function get_columns() {
		$data['name']     = esc_html__( 'Bundles name', 'woodmart' );
		$data['products'] = esc_html__( 'Products', 'woodmart' );

		return $data;
	}

	/**
	 * Set items data in table.
	 *
	 * @param string $product_id Product ID.
	 */
	public function prepare_items( $product_id = '' ) {
		if ( ! $product_id ) {
			$product_id = get_the_ID();
		}

		$bundles_id = get_post_meta( $product_id, 'woodmart_fbt_bundles_id', true );

		if ( $bundles_id ) {
			foreach ( $bundles_id as $bundle_id ) {
				if ( ! $bundle_id || ! get_post_status( $bundle_id ) || 'trash' === get_post_status( $bundle_id ) ) {
					continue;
				}

				$bundle        = get_post( $bundle_id );
				$products      = get_post_meta( $bundle->ID, '_woodmart_fbt_products', true );
				$products_data = array();

				if ( $products ) {
					foreach ( $products as $product ) {
						if ( ! empty( $product['id'] ) ) {
							$products_data[] = '<a href="' . get_permalink( $product['id'] ) . '">' . get_the_title( $product['id'] ) . '</a>';
						}
					}
				}

				$this->items[ $bundle->ID ] = array(
					'id'       => $bundle->ID,
					'title'    => $bundle->post_title,
					'status'   => get_post_status( $bundle->ID ),
					'products' => $products_data,
				);
			}
		}
	}

	/**
	 * Render if no items.
	 */
	public function no_items() {
		esc_html_e( 'No bundles found.', 'woodmart' );
	}
}
