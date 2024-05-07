<?php
/**
 * Wishlist group.
 *
 * @package XTS
 */

namespace XTS\WC_Wishlist;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Singleton;

/**
 * Wishlist group.
 *
 * @since 1.0.0
 */
class Wishlists_Group extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		if ( ! woodmart_woocommerce_installed() ) {
			return;
		}

		add_action( 'admin_init', array( $this, 'upgrade_database_wishlist' ), 110 );

		add_action( 'wp', array( $this, 'set_cookies' ), 99 );

		add_action( 'wp_ajax_woodmart_remove_group_from_wishlist', array( $this, 'remove_group_from_wishlist_action' ) );

		add_action( 'wp_ajax_woodmart_rename_wishlist_group', array( $this, 'rename_wishlist_group' ) );

		add_action( 'wp_ajax_woodmart_save_wishlist_group', array( $this, 'create_wishlist_group' ) );

		add_action( 'wp_ajax_woodmart_move_products_from_wishlist', array( $this, 'move_products_from_wishlist' ) );

		add_action( 'wp_ajax_woodmart_get_wishlist_fragments', array( $this, 'get_wishlist_fragments' ) );

		add_filter( 'woodmart_get_update_wishlist_fragments', array( $this, 'get_wishlist_groups_fragments' ) );
		add_filter( 'woodmart_get_update_wishlist_fragments', array( $this, 'get_wishlist_count' ) );

		add_filter( 'woodmart_get_wishlist_hash', array( $this, 'get_wishlist_hash' ) );

		add_action( 'woodmart_before_wp_footer', array( $this, 'wishlist_create_group_popup' ), 250 );
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
	 * Remove wishlist group.
	 *
	 * @return false|void
	 */
	public function remove_group_from_wishlist_action() {
		check_ajax_referer( 'wd-wishlist-page', 'key' );

		if ( ! isset( $_GET['group_id'] ) ) {
			return false;
		}

		$group_id = sanitize_text_field( wp_unslash( $_GET['group_id'] ) );

		$wishlist = $this->get_wishlist( $group_id );

		$result = $wishlist->remove_group( $group_id );
		$wishlist->update_count_cookie();

		$response = array(
			'status'    => $result ? 'success' : 'error',
			'count'     => $wishlist->get_count(),
			'fragments' => apply_filters( 'woodmart_get_update_wishlist_fragments', array() ),
			'hash'      => apply_filters( 'woodmart_get_wishlist_hash', '' ),
		);

		add_filter( 'woodmart_is_ajax', '__return_false' );

		$response['wishlist_content'] = Ui::get_instance()->wishlist_page_content( $wishlist );

		wp_send_json( $response );

		exit;
	}

	/**
	 * Rename wishlist group.
	 *
	 * @return false|void
	 */
	public function rename_wishlist_group() {
		check_ajax_referer( 'wd-wishlist-page', 'key' );

		if ( empty( $_GET['group_id'] ) || empty( $_GET['title'] ) ) {
			return false;
		}

		$group_id = woodmart_clean( $_GET['group_id'] ); //phpcs:ignore
		$title    = woodmart_clean( $_GET['title'] ); //phpcs:ignore

		echo wp_json_encode(
			array(
				'status'    => $this->get_wishlist( $group_id )->rename_group( $group_id, $title ) ? 'success' : 'error',
				'fragments' => apply_filters( 'woodmart_get_update_wishlist_fragments', array() ),
				'hash'      => apply_filters( 'woodmart_get_wishlist_hash', '' ),
			)
		);

		exit;
	}

	/**
	 * Create wishlist group.
	 *
	 * @return false|void
	 */
	public function create_wishlist_group() {
		check_ajax_referer( 'wd-wishlist-page', 'key' );

		if ( empty( $_GET['group'] ) ) { //phpcs:ignore
			return false;
		}

		$wishlist    = $this->get_wishlist();
		$wishlist_id = $wishlist->create_group( woodmart_clean( $_GET['group'] ) ); //phpcs:ignore

		$response = array(
			'status'    => $wishlist_id ? 'success' : 'error',
			'count'     => $wishlist->get_count(),
			'fragments' => apply_filters( 'woodmart_get_update_wishlist_fragments', array() ),
			'hash'      => apply_filters( 'woodmart_get_wishlist_hash', '' ),
		);

		add_filter( 'woodmart_is_ajax', '__return_false' );

		$response['wishlist_content'] = Ui::get_instance()->wishlist_page_content( $wishlist );

		wp_send_json( $response );

		exit;
	}

	/**
	 * Move products from wishlist group.
	 *
	 * @return void
	 */
	public function move_products_from_wishlist() {
		check_ajax_referer( 'wd-wishlist-page', 'key' );

		if ( empty( $_GET['products_id'] ) || empty( $_GET['group_id'] ) || empty( $_GET['group_id_old'] ) ) {
			return;
		}

		$wishlist     = $this->get_wishlist();
		$products_id  = sanitize_text_field( $_GET['products_id'] ); //phpcs:ignore
		$new_group_id = sanitize_text_field( $_GET['group_id'] ); //phpcs:ignore
		$old_group_id = sanitize_text_field( $_GET['group_id_old'] ); //phpcs:ignore

		$products_id = explode( ',', $products_id );
		$groups_ids  = woodmart_get_wishlist_groups();

		if ( ! isset( $groups_ids[ $new_group_id ] ) ) {
			$new_group_id = $wishlist->create_group( $new_group_id );
		}

		if ( $products_id && is_array( $products_id ) ) {
			foreach ( $products_id as $product_id ) {
				$wishlist->remove( $product_id, $old_group_id );
				$wishlist->add( $product_id, $new_group_id );
			}
		}

		$response = array(
			'status'    => 'success',
			'count'     => $wishlist->get_count(),
			'fragments' => apply_filters( 'woodmart_get_update_wishlist_fragments', array() ),
			'hash'      => apply_filters( 'woodmart_get_wishlist_hash', '' ),
		);

		add_filter( 'woodmart_is_ajax', '__return_false' );

		$response['wishlist_content'] = Ui::get_instance()->wishlist_page_content( $wishlist );

		wp_send_json( $response );

		exit;
	}

	/**
	 * Get wishlist fragments.
	 *
	 * @return void
	 */
	public function get_wishlist_fragments() {
		check_ajax_referer( 'wd-wishlist-fragments', 'key' );

		wp_send_json(
			array(
				'fragments' => apply_filters( 'woodmart_get_update_wishlist_fragments', array() ),
				'hash'      => apply_filters( 'woodmart_get_wishlist_hash', '' ),
			)
		);
	}

	/**
	 * Get wishlist group content.
	 *
	 * @param array $fragments Fragments.
	 * @return array
	 */
	public function get_wishlist_groups_fragments( $fragments ) {
		$content = '';

		if ( woodmart_get_wishlist_groups() ) {
			ob_start();

			$this->wishlist_create_group_popup();

			$content = ob_get_clean();
		}

		$fragments['div.wd-popup-wishlist'] = $content;

		return $fragments;
	}

	/**
	 * Get wishlist count content.
	 *
	 * @param array $fragments Fragments.
	 * @return array
	 */
	public function get_wishlist_count( $fragments ) {
		$wishlist_id = isset( $_GET['group_id'] ) ? sanitize_text_field( $_GET['group_id'] ) : ''; //phpcs:ignore
		$wishlist    = $this->get_wishlist( $wishlist_id );

		ob_start();
		?>
		<span class="wd-tools-count">
			<?php echo esc_html( $wishlist->get_count() ); ?>
		</span>
		<?php

		$fragments['div.wd-header-wishlist.wd-with-count .wd-tools-count'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Get wishlist hash.
	 *
	 * @return string
	 */
	public function get_wishlist_hash() {
		return md5( wp_json_encode( woodmart_get_wishlist_groups() ) . woodmart_get_wishlist_count() );
	}

	/**
	 * Set wishlist cookies
	 *
	 * @return void
	 */
	public function set_cookies() {
		if ( headers_sent() || ! did_action( 'wp_loaded' ) ) {
			return;
		}

		$hash_name = 'woodmart_wishlist_hash';

		if ( is_multisite() ) {
			$hash_name .= '_' . get_current_blog_id();
		}

		$setcookies = apply_filters(
			'woodmart_set_cookies_wishlist',
			array(
				$hash_name => $this->get_wishlist_hash(),
			)
		);

		foreach ( $setcookies as $name => $value ) {
			if ( woodmart_get_cookie( $name ) !== $value ) {
				woodmart_set_cookie( $name, $value );
			}
		}
	}

	/**
	 * Upgrade wishlist database.
	 *
	 * @return void
	 */
	public function upgrade_database_wishlist() {
		if ( get_option( 'woodmart_upgrade_database_wishlist' ) ) {
			return;
		}

		global $wpdb;

		$default_wishlist_name = esc_html__( 'My wishlist', 'woodmart' );

		$wpdb->query(
			"ALTER TABLE {$wpdb->woodmart_wishlists_table} 
				ADD COLUMN wishlist_group varchar( 255 ) DEFAULT '{$default_wishlist_name}' NOT NULL AFTER user_id"
		);

		update_option( 'woodmart_upgrade_database_wishlist', true );
	}

	/**
	 * Create group popup.
	 *
	 * @return void
	 */
	public function wishlist_create_group_popup() {
		$page_id = woodmart_get_opt( 'wishlist_page' );

		if ( defined( 'ICL_SITEPRESS_VERSION' ) && function_exists( 'wpml_object_id_filter' ) ) {
			$page_id = wpml_object_id_filter( $page_id, 'page', true );
		}

		if ( 'disable' === woodmart_get_opt( 'wishlist_show_popup', 'disable' ) && get_the_ID() !== (int) $page_id && ! wp_doing_ajax() ) {
			return;
		}

		woodmart_enqueue_inline_style( 'mfp-popup' );
		woodmart_enqueue_inline_style( 'page-wishlist-popup' );
		woodmart_enqueue_js_library( 'magnific' );

		$wishlist_groups = woodmart_get_wishlist_groups();

		?>
		<div class="mfp-with-anim wd-popup wd-close-btn-inset wd-popup-wishlist">
			<div class="wd-wishlist-back-btn wd-action-btn wd-style-text">
				<a href="#">
					<?php esc_html_e( 'Back to list', 'woodmart' ); ?>
				</a>
			</div>
			<?php if ( $wishlist_groups ) : ?>
			<ul class="wd-wishlist-group-list" data-product-id="" data-nonce="" data-group-count="<?php echo count( $wishlist_groups ); ?>">
				<?php foreach ( $wishlist_groups as $id => $name ) : ?>
					<li data-group-id="<?php echo esc_html( $id ); ?>">
						<input type="radio" id="wd-wishlist-group-<?php echo esc_attr( $id ); ?>">
						<label for="wd-wishlist-group-<?php echo esc_attr( $id ); ?>">
							<?php echo esc_html( $name ); ?>
						</label>
					</li>
				<?php endforeach; ?>
				<li data-group-id="add_new">
					<span class="wd-wishlist-add-group wd-action-btn wd-style-text">
						<a href="#">
							<?php esc_html_e( 'Add new wishlist', 'woodmart' ); ?>
						</a>
					</span>
				</li>
			</ul>
			<?php endif; ?>
			<div class="wd-wishlist-create-group">
				<label for="wd-wishlist-group-name">
					<?php esc_html_e( 'Create wishlist', 'woodmart' ); ?>
				</label>
				<input type="text" class="wd-wishlist-group-name" id="wd-wishlist-group-name">
			</div>
			<div class="wd-wishlist-add-success set-mb-m reset-last-child">
				<span class="title">
					<?php esc_html_e( 'Product was successfully added to your wishlist.', 'woodmart' ); ?>
				</span>
				<a href="<?php echo esc_url( woodmart_get_wishlist_page_url() ); ?>" class="wd-wishlist-back-to-lists btn btn-full-width">
					<?php esc_html_e( 'Browse wishlist', 'woodmart' ); ?>
				</a>
				<a href="#" class="wd-wishlist-back-to-shop btn btn-style-link btn-color-default">
					<?php esc_html_e( 'Back to shop', 'woodmart' ); ?>
				</a>
			</div>
			<a href="#" data-group-id="save" class="btn btn-color-primary btn-full-width wd-wishlist-save-btn" data-added-text="<?php esc_html_e( 'Add to wishlist', 'woodmart' ); ?>" data-create-text="<?php esc_html_e( 'Create wishlist', 'woodmart' ); ?>" data-move-text="<?php esc_html_e( 'Move to wishlist', 'woodmart' ); ?>">
				<?php esc_html_e( 'Add to wishlist', 'woodmart' ); ?>
			</a>
		</div>
		<?php
	}


	/**
	 * Output header for wishlist groups.
	 */
	public function output_header_for_wishlist_groups() {
		woodmart_enqueue_inline_style( 'page-wishlist-group' );
		woodmart_enqueue_js_script( 'wishlist-group' );

		?>
		<div class="wd-wishlist-head wd-border-off">
			<h4 class="title">
				<?php esc_html_e( 'Your wishlists', 'woodmart' ); ?>
			</h4>
			<a href="#" class="btn wd-wishlist-create-group-btn">
				<?php esc_html_e( 'Create wishlist', 'woodmart' ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Render wishlist groups.
	 *
	 * @param object $wishlist Object wishlist class.
	 * @param array  $wishlist_groups Wishlist groups.
	 * @param array  $args Default arguments.
	 *
	 * @return void
	 */
	public function get_wishlist_groups( $wishlist, $wishlist_groups, $args ) {
		foreach ( $wishlist_groups as $key => $wishlist_group ) {
			$wishlist_group_product_ids = array_map(
				function( $item ) {
					return $item['product_id'];
				},
				$wishlist->get_product_ids_by_wishlist_id( $wishlist_group['ID'] )
			);

			?>
			<div class="wd-wishlist-group" data-group-id="<?php echo esc_attr( $wishlist_group['ID'] ); ?>">
				<?php
				Ui::get_instance()->wishlist_content_header(
					array(
						'title'                 => $wishlist_group['wishlist_group'],
						'group_id'              => $wishlist_group['ID'],
						'wishlist_groups'       => true,
						'hide_remove_group_btn' => 0 === $key,
					)
				);

				if ( $wishlist_group_product_ids ) {
					$args['include'] = implode( ',', $wishlist_group_product_ids );

					echo woodmart_shortcode_products( apply_filters( 'woodmart_wishlist_products_settings', $args ) ); //phpcs:ignore
				} else {
					Ui::get_instance()->wishlist_empty_content( false );
				}
				?>
				<div class="wd-loader-overlay wd-fill"></div>
			</div>
			<?php
		}
	}
}

Wishlists_Group::get_instance();
