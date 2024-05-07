<?php
/**
 * Single product reviews class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Product_Reviews;

use WP_Comment;
use WP_Post;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Purchased_Indicator class.
 */
class Purchased_Indicator {
	/**
	 * Class basic constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'comment_author', array( $this, 'add_author_icon' ), 10, 2 );
	}

	/**
	 * Add icon and tooltip to author name. This method will add 'Verified owner' icon if is purchased product or 'Store manager' icon if this is review replay.
	 *
	 * @param string $author     The comment author's username.
	 * @param string $comment_ID The comment ID as a numeric string.
	 * @return string
	 */
	public function add_author_icon( $author, $comment_ID ) {
		if ( ! woodmart_get_opt( 'show_reviews_purchased_indicator' ) || ( $this->is_parent_comment( $comment_ID ) && ! $this->is_user_purchased_product( $comment_ID ) ) || ( ! wp_doing_ajax() && is_admin() ) ) {
			return $author;
		}

		$tooltip_text = $this->is_parent_comment( $comment_ID ) ? esc_html__( 'Verified owner', 'woodmart' ) : esc_html__( 'Store manager', 'woodmart' );

		ob_start();

		woodmart_enqueue_js_script( 'btns-tooltips' );

		?>
		<span class="wd-review-icon">
			<span class="wd-tooltip">
				<?php echo esc_html( $tooltip_text ); ?>
			</span>
		</span>
		<?php echo $author; ?>
		<?php

		return ob_get_clean();
	}

	/**
	 * Verify is user purchased product.
	 *
	 * @param string $comment_id The comment ID as a numeric string.
	 * @return bool
	 */
	protected function is_user_purchased_product( $comment_id ) {
		$comment = get_comment( $comment_id );

		if ( ! woodmart_woocommerce_installed() || ! is_singular( 'product' ) && ! woodmart_is_woo_ajax() || empty( $comment ) || ! function_exists( 'wc_customer_bought_product' ) || ! function_exists( 'wc_review_is_from_verified_owner' ) ) {
			return false;
		}

		$product_id = Helper::get_product_id();

		if ( $product_id && wc_customer_bought_product( $comment->comment_author_email, $comment->user_id, $product_id ) && wc_review_is_from_verified_owner( $comment_id ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if this comment is parent.
	 *
	 * @param string $comment_id The comment ID as a numeric string.
	 * @return bool
	 */
	protected function is_parent_comment( $comment_id ) {
		global $wpdb;

		$comment_info = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT $wpdb->comments.comment_parent
					FROM $wpdb->comments
					WHERE $wpdb->comments.comment_ID = %d;",
				$comment_id
			),
			ARRAY_A
		);

		return '0' === $comment_info[0]['comment_parent'];
	}
}

new Purchased_Indicator();
