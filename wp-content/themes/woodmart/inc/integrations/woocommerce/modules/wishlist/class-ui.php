<?php
/**
 * Wishlist UI.
 */

namespace XTS\WC_Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Singleton;

/**
 * Wishlist UI.
 *
 * @since 1.0.0
 */
class Ui extends Singleton {

	/**
	 * Wishlist object.
	 *
	 * @var null
	 */
	private $wishlist = null;

	/**
	 * Can user edit this wishlist or just view it.
	 *
	 * @var boolean
	 */
	private $editable = true;

	/**
	 * Wishlist group object.
	 *
	 * @var boolean
	 */
	private $wishlist_group = null;

	/**
	 * Ajax actions.
	 *
	 * @var array
	 */
	private $wishlist_action = array(
		'woodmart_remove_from_wishlist',
		'woodmart_move_products_from_wishlist',
		'woodmart_remove_group_from_wishlist',
		'woodmart_save_wishlist_group',
	);

	/**
	 * Initialize action.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		if ( ! woodmart_woocommerce_installed() ) {
			return false;
		}

		add_action( 'init', array( $this, 'hooks' ), 100 );
		add_action( 'init', array( $this, 'button_hooks' ), 200 );
		add_action( 'wp', array( $this, 'hooks' ), 100 );
	}

	/**
	 * Register hooks and actions.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function hooks() {
		if ( ! woodmart_get_opt( 'wishlist', 1 ) ) {
			return false;
		}

		$wishlist_id = get_query_var( 'wishlist_id' );

		// Display public wishlist or personal.
		if ( $wishlist_id && (int) $wishlist_id > 0 ) {
			$this->editable = false;
			$this->wishlist = new Wishlist( $wishlist_id, false, true );
		} else {
			$this->wishlist = new Wishlist();
		}

		if ( woodmart_get_opt( 'wishlist_expanded' ) && is_user_logged_in() && $this->is_editable() && empty( $_GET['opauth'] ) ) { //phpcs:ignore
			$this->wishlist_group = Wishlists_Group::get_instance();
		}
	}

	/**
	 * Wishlist page shortcode output.
	 *
	 * @since 1.0.0
	 */
	public function get_wishlist() {
		return $this->wishlist;
	}

	/**
	 * Add buttons.
	 *
	 * @since 1.0.0
	 */
	public function button_hooks() {
		if ( ! woodmart_get_opt( 'wishlist', 1 ) ) {
			return false;
		}

		add_filter( 'woocommerce_account_menu_items', array( $this, 'account_navigation' ), 15 );
		add_filter( 'woocommerce_get_endpoint_url', array( $this, 'account_navigation_url' ), 15, 4 );
		add_filter( 'woocommerce_account_menu_item_classes', array( $this, 'account_navigation_classes' ), 15, 2 );

		if ( ( woodmart_get_opt( 'wishlist_logged' ) && is_user_logged_in() ) || ! woodmart_get_opt( 'wishlist_logged' ) ) {
			add_action( 'woocommerce_single_product_summary', array( $this, 'add_to_wishlist_single_btn' ), 33 );
			add_action( 'woodmart_sticky_atc_actions', array( $this, 'add_to_wishlist_sticky_atc_btn' ), 20 );
		}

		if ( woodmart_get_opt( 'product_loop_wishlist' ) && ( ( woodmart_get_opt( 'wishlist_logged' ) && is_user_logged_in() ) || ! woodmart_get_opt( 'wishlist_logged' ) ) ) {
			add_action( 'woodmart_product_action_buttons', array( $this, 'add_to_wishlist_loop_btn' ), 30 );
		}

		if ( woodmart_is_woo_ajax() && $this->is_editable() && ( ( isset( $_POST['atts'] ) && ! empty( $_POST['atts']['is_wishlist'] ) ) || ( isset( $_GET['action'] ) && in_array( $_GET['action'], $this->wishlist_action ) ) ) ) { //phpcs:ignore
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'output_settings_btn' ) );
		}
	}

	/**
	 * Wishlist page shortcode output.
	 *
	 * @since 1.0.0
	 */
	public function wishlist_page() {
		if ( $this->is_editable() ) {
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'output_settings_btn' ) );
		}

		ob_start();
		?>
		<?php if ( woodmart_get_opt( 'wishlist_logged' ) && ! is_user_logged_in() ) : ?>
			<div class="woocommerce-notices-wrapper">
				<div class="woocommerce-info" role="alert">
					<?php esc_html_e( 'Wishlist is available only for logged in visitors.', 'woodmart' ); ?> 
					<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>">
						<?php esc_html_e( 'Sign in', 'woodmart' ); ?>
					</a>
				</div>
			</div>
			<?php return; ?>
		<?php endif; ?>

		<?php if ( woodmart_woocommerce_installed() && is_user_logged_in() && $this->is_editable() && apply_filters( 'woodmart_my_account_wishlist', true ) ) : ?>
			<?php do_action( 'woocommerce_account_navigation' ); ?>
		<?php endif; ?>

		<div class="<?php echo ( is_user_logged_in() && $this->is_editable() && apply_filters( 'woodmart_my_account_wishlist', true ) ) ? 'woocommerce-MyAccount-content' : ''; ?>">
			<?php echo $this->wishlist_page_content(); //phpcs:ignore ?>
		</div>
		<?php

		if ( $this->is_editable() ) {
			remove_action( 'woocommerce_before_shop_loop_item', array( $this, 'output_settings_btn' ) );
		}

		return ob_get_clean();
	}

	/**
	 * Content of the wishlist page with products.
	 *
	 * @since 1.0.0
	 *
	 * @param object $wishlist Wishlist object.
	 */
	public function wishlist_page_content( $wishlist = false ) {
		if ( ! $wishlist ) {
			$wishlist = $this->wishlist;
		}

		$products        = $wishlist->get_product_ids_by_wishlist_id( $wishlist->get_id() );
		$wrapper_classes = '';
		$wishlist_groups = woodmart_get_opt( 'wishlist_expanded' ) && is_user_logged_in() ? $wishlist->get_all_wishlists_by_current_user() : '';

		if ( woodmart_get_opt( 'wishlist_expanded' ) && ! $this->is_editable() ) {
			$default_title = $wishlist->get_wishlist_title_by_wishlist_id( $wishlist->get_id() );
		} else {
			$default_title = esc_html__( 'Your products wishlist', 'woodmart' );
		}

		$products = array_map(
			function( $item ) {
				return $item['product_id'];
			},
			$products
		);

		$columns = woodmart_get_opt( 'products_columns' );

		if ( $columns > 3 && is_user_logged_in() ) {
			--$columns;
		}

		$args = array(
			'include'                      => implode( ',', $products ),
			'post_type'                    => 'ids',
			'items_per_page'               => $wishlist_groups && is_user_logged_in() && $this->is_editable() ? -1 : woodmart_get_opt( 'shop_per_page' ),
			'columns'                      => $columns,
			'pagination'                   => 'links',
			'force_not_ajax'               => 'yes',
			'products_masonry'             => woodmart_get_opt( 'products_masonry' ) ? 'enable' : 'disable',
			'products_different_sizes'     => woodmart_get_opt( 'products_different_sizes' ) ? 'enable' : 'disable',
			'query_post_type'              => array( 'product', 'product_variation' ),
			'products_bordered_grid'       => woodmart_get_opt( 'products_bordered_grid', 0 ),
			'products_bordered_grid_style' => woodmart_get_opt( 'products_bordered_grid_style' ),
			'products_with_background'     => woodmart_get_opt( 'products_with_background', 0 ),
			'products_shadow'              => woodmart_get_opt( 'products_shadow', 0 ),
			'products_color_scheme'        => woodmart_get_opt( 'products_color_scheme', 'default' ),
			'is_wishlist'                  => 'yes',
		);

		if ( ! $this->is_editable() ) {
			$wrapper_classes .= ' wd-wishlist-preview';
		}

		if ( $this->wishlist_group && $this->is_editable() ) {
			$wrapper_classes .= ' wd-group-enable';
		}

		ob_start();

		?>
			<div class="wd-wishlist-content<?php echo esc_attr( $wrapper_classes ); ?>">
				<?php if ( $this->wishlist_group && $this->is_editable() ) : ?>
					<?php $this->wishlist_group->output_header_for_wishlist_groups(); ?>
					<?php $this->wishlist_group->get_wishlist_groups( $wishlist, $wishlist_groups, $args ); ?>
				<?php elseif ( count( $products ) > 0 ) : ?>
					<?php
					$this->wishlist_content_header(
						array(
							'title'           => $default_title,
							'group_id'        => $wishlist->get_id(),
							'wishlist_groups' => false,
						)
					);
					?>
					<?php echo woodmart_shortcode_products( $args ); //phpcs:ignore ?>
				<?php else : ?>
					<?php $this->wishlist_empty_content(); ?>
				<?php endif; ?>
			</div>
		<?php

		return ob_get_clean();
	}

	/**
	 * Wishlist content title.
	 *
	 * @param array $args Arguments.
	 *
	 * @return void
	 */
	public function wishlist_content_header( $args ) {
		if ( $args['wishlist_groups'] ) {
			$title_classes = 'wd-wishlist-group-head';
		} else {
			$title_classes = 'wd-wishlist-head';

			if ( woodmart_get_opt( 'products_bordered_grid' ) && 'outside' === woodmart_get_opt( 'products_bordered_grid_style', 'outside' ) ) {
				$title_classes .= ' wd-border-off';
			}
		}

		if ( woodmart_get_opt( 'wishlist_bulk_action' ) ) {
			woodmart_enqueue_inline_style( 'page-wishlist-bulk' );
		}

		?>
		<div class="<?php echo esc_attr( $title_classes ); ?>">
			<?php if ( $args['wishlist_groups'] ) : ?>
				<div class="wd-wishlist-group-title">
					<div class="wd-wishlist-group-action wd-event-hover">
						<ul class="wd-dropdown wd-dropdown-menu wd-dropdown-wishlist-group wd-design-default wd-sub-menu">
							<li>
								<a href="#" class="wd-wishlist-edit-title">
									<?php esc_html_e( 'Edit name', 'woodmart' ); ?>
								</a>
							</li>
							<?php if ( empty( $args['hide_remove_group_btn'] ) ) : ?>
								<li>
									<a href="#" class="wd-wishlist-remove-group">
										<?php esc_html_e( 'Remove wishlist', 'woodmart' ); ?>
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</div>
					<h4 class="title">
						<?php echo esc_html( $args['title'] ); ?>
					</h4>
					<div class="wd-wishlist-title-edit">
						<input type="text" class="wd-wishlist-input-rename" value="<?php echo esc_html( $args['title'] ); ?>" data-title="<?php echo esc_html( $args['title'] ); ?>">
						<a href="#" class="btn wd-wishlist-rename-save">
							<?php esc_html_e( 'Save', 'woodmart' ); ?>
						</a>
						<div class="wd-wishlist-rename-cancel wd-action-btn wd-style-text wd-cross-icon">
							<a href="#">
								<?php esc_html_e( 'Cancel', 'woodmart' ); ?>
							</a>
						</div>
					</div>
				</div>

				<?php else : ?>
					<h4 class="title">
						<?php echo esc_html( $args['title'] ); ?>
					</h4>
				<?php endif; ?>

			<?php if ( is_user_logged_in() && $this->is_editable() && woodmart_is_social_link_enable( 'share' ) ) : ?>
				<?php echo woodmart_shortcode_social( //phpcs:ignore
					array(
						'size'          => 'small',
						'page_link'     => woodmart_get_wishlist_page_url() . $args['group_id'] . '/',
						'show_label'    => 'yes',
						'el_class'      => 'wd-layout-inline',
						'title_classes' => 'share-title',
					)
				);
				?>
			<?php endif; ?>
		</div>
		<?php if ( woodmart_get_opt( 'wishlist_bulk_action' ) ) : ?>
			<div class="wd-wishlist-bulk-action">
				<?php if ( $args['wishlist_groups'] ) : ?>
					<div class="wd-wishlist-move-action wd-action-btn wd-style-text">
						<a href="#">
							<?php esc_html_e( 'Move', 'woodmart' ); ?>
						</a>
					</div>
				<?php endif; ?>
				<div class="wd-wishlist-remove-action wd-action-btn wd-style-text wd-cross-icon">
					<a href="#">
						<?php esc_html_e( 'Remove', 'woodmart' ); ?>
					</a>
				</div>
				<div class="wd-wishlist-select-all wd-action-btn wd-style-text">
					<a href="#">
						<span class="wd-wishlist-text-select"><?php esc_html_e( 'Select all', 'woodmart' ); ?></span>
						<span class="wd-wishlist-text-deselect"><?php esc_html_e( 'Deselect all', 'woodmart' ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
		<?php
	}

	/**
	 * Wishlist empty content.
	 *
	 * @param bool $show_wishlist_empty_text Show text is wishlist empty.
	 * @return void
	 */
	public function wishlist_empty_content( $show_wishlist_empty_text = true ) {
		woodmart_enqueue_inline_style( 'woo-page-empty-page' );

		$wishlist_empty_text = woodmart_get_opt( 'wishlist_empty_text' );
		?>
		<?php if ( ! $show_wishlist_empty_text ) : ?>
			<div class="wd-wishlist-group-empty">
		<?php endif; ?>

		<p class="wd-empty-wishlist wd-empty-page">
			<?php esc_html_e( 'This wishlist is empty.', 'woodmart' ); ?>
		</p>

		<?php if ( $wishlist_empty_text ) : ?>
			<div class="wd-empty-page-text">
				<?php echo wp_kses( $wishlist_empty_text, woodmart_get_allowed_html() ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! $show_wishlist_empty_text ) : ?>
			</div>
		<?php endif; ?>

		<?php if ( $show_wishlist_empty_text && $this->is_editable() ) : ?>
			<p class="return-to-shop">
				<a class="button" href="<?php echo esc_url( apply_filters( 'woodmart_wishlist_return_to_shop_url', wc_get_page_permalink( 'shop' ) ) ); ?>">
					<?php esc_html_e( 'Return to shop', 'woodmart' ); ?>
				</a>
			</p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Remove button HTML.
	 *
	 * @since 1.0.0
	 */
	public function output_settings_btn() {
		woodmart_enqueue_js_script( 'wishlist' );
		?>
			<div class="wd-wishlist-product-actions">
				<div class="wd-wishlist-product-remove wd-action-btn wd-style-text wd-cross-icon">
					<a href="#" class="wd-wishlist-remove" data-product-id="<?php echo esc_attr( get_the_ID() ); ?>">
						<?php esc_html_e( 'Remove', 'woodmart' ); ?>
					</a>
				</div>
				<?php if ( woodmart_get_opt( 'wishlist_bulk_action' ) ) : ?>
					<div class="wd-wishlist-product-checkbox">
						<input type="checkbox" class="wd-wishlist-checkbox" data-product-id="<?php echo esc_attr( get_the_ID() ); ?>">
					</div>
				<?php endif; ?>
			</div>
		<?php
	}

	/**
	 * Add to wishlist button on loop product.
	 *
	 * @since 1.0.0
	 */
	public function add_to_wishlist_loop_btn() {
		$this->add_to_wishlist_btn( 'wd-action-btn wd-style-icon wd-wishlist-icon' );
	}

	/**
	 * Add to wishlist button on single product.
	 *
	 * @since 1.0.0
	 */
	public function add_to_wishlist_single_btn() {
		$this->add_to_wishlist_btn( 'wd-action-btn wd-style-text wd-wishlist-icon' );
	}

	/**
	 * Add to wishlist button on sticky add to cart.
	 *
	 * @since 1.0.0
	 */
	public function add_to_wishlist_sticky_atc_btn() {
		woodmart_enqueue_js_library( 'tooltips' );
		woodmart_enqueue_js_script( 'btns-tooltips' );

		$this->add_to_wishlist_btn( 'wd-action-btn wd-style-icon wd-wishlist-icon wd-tooltip' );
	}

	/**
	 * Add to wishlist button.
	 *
	 * @since 1.0.0
	 *
	 * @param string $classes Extra classes.
	 */
	public function add_to_wishlist_btn( $classes = '' ) {
		woodmart_enqueue_js_script( 'wishlist' );

		if ( woodmart_get_opt( 'wishlist_expanded' ) && 'disable' !== woodmart_get_opt( 'wishlist_show_popup', 'disable' ) && is_user_logged_in() ) {
			woodmart_enqueue_js_script( 'wishlist-group' );
		}

		$added        = false;
		$link_classes = '';
		$text         = esc_html__( 'Add to wishlist', 'woodmart' );
		$product_id   = apply_filters( 'wpml_object_id', get_the_ID(), 'product', true, apply_filters( 'wpml_default_language', null ) );

		if ( $this->wishlist && $this->wishlist->get_all() && woodmart_get_opt( 'wishlist_save_button_state', '0' ) ) {
			$products = $this->wishlist->get_all();
			foreach ( $products as $product ) {
				if ( (int) get_the_ID() === (int) $product['product_id'] ) {
					$added = true;
				}
			}
		}

		if ( $added ) {
			$link_classes .= ' added';
			$text          = esc_html__( 'Browse Wishlist', 'woodmart' );
		}

		$classes .= woodmart_get_old_classes( ' woodmart-wishlist-btn' );

		?>
			<div class="wd-wishlist-btn <?php echo esc_attr( $classes ); ?>">
				<a class="<?php echo esc_attr( $link_classes ); ?>" href="<?php echo esc_url( woodmart_get_wishlist_page_url() ); ?>" data-key="<?php echo esc_attr( wp_create_nonce( 'woodmart-wishlist-add' ) ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" rel="nofollow" data-added-text="<?php esc_html_e( 'Browse Wishlist', 'woodmart' ); ?>">
					<span><?php echo esc_html( $text ); ?></span>
				</a>
			</div>
		<?php
	}

	/**
	 * Add wishlist title to account menu.
	 *
	 * @since 1.0.0
	 *
	 * @param array $items Menu items.
	 *
	 * @return array
	 */
	public function account_navigation( $items ) {
		unset( $items['customer-logout'] );

		if ( woodmart_get_opt( 'wishlist', 1 ) && woodmart_get_opt( 'wishlist_page' ) && apply_filters( 'woodmart_my_account_wishlist', true ) ) {
			$items['wishlist'] = esc_html__( 'Wishlist', 'woodmart' );
		}

		$items['customer-logout'] = esc_html__( 'Logout', 'woodmart' );

		return $items;
	}

	/**
	 * Add URL to wishlist item in the menu.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url Item url.
	 * @param string $endpoint Endpoint name.
	 * @param string $value Value.
	 * @param string $permalink Item permalink.
	 *
	 * @return string
	 */
	public function account_navigation_url( $url, $endpoint, $value, $permalink ) {
		if ( 'wishlist' === $endpoint ) {
			$url = woodmart_get_wishlist_page_url();
		}

		return $url;
	}

	/**
	 * Add active class to wishlist item in the menu.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $classes Item classes.
	 * @param string $endpoint Endpoint name.
	 *
	 * @return array
	 */
	public function account_navigation_classes( $classes, $endpoint ) {
		global $wp;

		$wishlist_page = function_exists( 'wpml_object_id_filter' ) ? wpml_object_id_filter( woodmart_get_opt( 'wishlist_page' ), 'page', true ) : woodmart_get_opt( 'wishlist_page' );

		if ( 'wishlist' === $endpoint && get_the_ID() == $wishlist_page ) {
			$classes[] = 'is-active';
		} elseif ( get_the_ID() == $wishlist_page ) {
			$key = array_search( 'is-active', $classes );
			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}
		}

		return $classes;
	}

	/**
	 * Can user edit this wishlist or just view it.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	public function is_editable() {
		return $this->editable;
	}
}
