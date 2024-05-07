<?php
/**
 * Single product reviews class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Product_Reviews;

use WP_Comment;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Likes class.
 */
class Likes {
	/**
	 * Class basic constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'comment_post', array( $this, 'save_comment' ) );

		add_action( 'wp_ajax_woodmart_comments_likes', array( $this, 'ajax_comments_likes' ) );
		add_action( 'woocommerce_review_after_comment_text', array( $this, 'render' ) );

		add_filter( 'woodmart_localized_string_array', array( $this, 'add_localized_settings' ) );
	}

	/**
	 * This method add comment meta data likes/dislikes before save reviews.
	 *
	 * @param int $comment_id Current comment id.
	 *
	 * @return void
	 */
	public function save_comment( $comment_id ) {
		if ( 'product' !== get_post_type( absint( $_POST['comment_post_ID'] ) ) ) {
			return;
		}

		update_comment_meta( $comment_id, 'wd_likes', 0 );
		update_comment_meta( $comment_id, 'wd_dislikes', 0 );
		update_comment_meta( $comment_id, 'wd_total_vote', 0 );
	}

	/**
	 * This method update comments votes meta-data ( 'likes', 'dislikes', 'vote' ).
	 * If $_POST there is no needed params will be return 0.
	 *
	 * @return int|void
	 */
	public function ajax_comments_likes() {
		if ( ! isset( $_POST['comment_id'], $_POST['vote'] ) ) {
			return 0;
		}

		$comment_id       = $_POST['comment_id'];
		$vote             = $_POST['vote'];
		$current_user_id  = get_current_user_id();

		if ( metadata_exists( 'comment', $comment_id, 'wd_vote' ) ) {
			$meta_votes = get_comment_meta( $comment_id, 'wd_vote', true );
		} else {
			$meta_votes[$current_user_id] = $vote;
		}

		foreach ( $meta_votes as $user_id => $meta_vote ) {
			if ( $user_id !== $current_user_id ) {
				$meta_votes[$current_user_id] = $vote;
			} else {
				$meta_votes[$user_id] = $vote;
			}
		}

		$votes_counted = array_count_values( $meta_votes );

		if ( ! isset( $votes_counted['like'] ) ) {
			$votes_counted['like'] = 0;
		}

		if ( ! isset( $votes_counted['dislike'] ) ) {
			$votes_counted['dislike'] = 0;
		}

		$likes   = $votes_counted['like'];
		$dislike = $votes_counted['dislike'];
		$total   = $votes_counted['like'] + $votes_counted['dislike'];

		update_comment_meta( $comment_id, 'wd_vote', $meta_votes );
		update_comment_meta( $comment_id, 'wd_likes', $likes );
		update_comment_meta( $comment_id, 'wd_dislikes', $dislike );
		update_comment_meta( $comment_id, 'wd_total_vote', $total );

		$data = array(
			'likes'    => $likes,
			'dislikes' => $dislike,
		);

		wp_send_json( $data );
	}

	/**
	 * Add localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function add_localized_settings( $settings ) {
		$settings['myaccount_page'] = esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) );

		return $settings;
	}

	/**
	 * Render comments html with pros and cons field.
	 *
	 * @param WP_Comment $data_object Comment data object.
	 *
	 * @return void
	 */
	public function render( $data_object ) {
		if ( ! woodmart_get_opt( 'reviews_enable_likes' ) || '0' !== $data_object->comment_parent || ( ! wp_doing_ajax() && ( is_admin() || ! is_singular( 'product' ) ) ) ) {
			return;
		}

		$likes    = metadata_exists( 'comment', $data_object->comment_ID, 'wd_likes' ) ? get_comment_meta( $data_object->comment_ID, 'wd_likes', true ) : 0;
		$dislikes = metadata_exists( 'comment', $data_object->comment_ID, 'wd_dislikes' ) ? get_comment_meta( $data_object->comment_ID, 'wd_dislikes', true ) : 0;

		woodmart_enqueue_js_script( 'product-reviews-likes' );
		woodmart_enqueue_inline_style( 'woo-single-prod-opt-review-likes' );
		?>
		<div class="wd-review-likes">
			<div class="wd-action-btn wd-style-text wd-like wd-like-icon">
				<a><span><?php echo esc_html( $likes ); ?></span></a>
			</div>
			<div class="wd-action-btn wd-style-text wd-dislike wd-dislike-icon">
				<a><span><?php echo esc_html( $dislikes ); ?></span></a>
			</div>
		</div>
		<?php
	}
}

new Likes();
