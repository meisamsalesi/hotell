<?php
/**
 * Single product reviews class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Product_Reviews;

use WP_Comment;
use XTS\Options;
use XTS\Presets;
use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Rating_Summary class.
 */
class Rating_Criteria extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_filter( 'woodmart_localized_string_array', array( $this, 'add_localized_settings' ) );

		remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating' );
		remove_action( 'woocommerce_review_before_comment_text', 'woocommerce_review_display_rating' );

		add_action( 'trash_comment', array( $this, 'clear_transient' ) );
		add_action( 'delete_comment', array( $this, 'clear_transient' ) );
		add_action( 'wp_ajax_delete_comment', array( $this, 'clear_transient' ) );
		add_action( 'comment_post', array( $this, 'save_comment_summary_criteria' ) );
		add_action( 'woocommerce_review_before_comment_text', array( $this, 'render_star_rating' ) );
	}

	/**
	 * Check show criteria star rating html structure.
	 * 
	 * @param string $comment_id A numeric string, for compatibility reasons.
	 * @return bool
	 */
	public function is_show_criteria_star_rating( $comment_id ) {
		$summary_criteria_list = $this->get_summary_criteria_list();

		if ( empty( $summary_criteria_list ) ) {
			return false;
		}

		foreach ( array_keys( $summary_criteria_list ) as $criteria_id ) {
			$criteria_rating = intval( get_comment_meta( $comment_id, $criteria_id,true ) );

			if ( 0 !== $criteria_rating ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * This method add wrapper for star rating html.
	 *
	 * @param  WP_Comment $comment
	 * @return void
	 */
	public function render_star_rating( $comment ) {
		$comment_id            = $comment->comment_ID;
		$rating                = intval( get_comment_meta( $comment_id, 'rating', true ) );
		$summary_criteria_list = $this->get_summary_criteria_list();

		if ( ! $this->is_show_criteria_star_rating( $comment_id ) ) {
			woocommerce_review_display_rating();

			return;
		}

		?>
		<?php if ( $rating && wc_review_ratings_enabled() ) : ?>
			<div class="wd-star-ratings wd-event-hover">
				<div class="wd-star-rating-wrap">
					<?php echo wc_get_rating_html( $rating ); // WPCS: XSS ok. ?>
				</div>

				<div class="wd-criteria-wrap wd-dropdown">
					<?php foreach ( $summary_criteria_list as $criteria_id => $criteria_title ) : ?>
						<?php
							$criteria_rating = intval( get_comment_meta( $comment_id, $criteria_id,true ) );

							if ( 0 === $criteria_rating ) {
								continue;
							}
						?>
						<div class="wd-star-rating-wrap">
							<div class="star-rating" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5', 'woodmart' ), $criteria_rating ) ); ?>">
								<?php echo wp_kses( woodmart_get_star_rating_html( $criteria_rating ), true ); ?>
							</div>
							<div class="wd-rating-label">
								<?php echo esc_attr( $criteria_title ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php
	}

	/**
	 * This method return criteria stars ratings fields to comment form.
	 *
	 * @return string
	 */
	public function get_criteria_stars_ratings_fields() {
		$summary_criteria_list = $this->get_summary_criteria_list();

		ob_start();

		woodmart_enqueue_js_script( 'product-reviews-criteria' );
		?>
		<div class="wd-review-criteria-wrap">
			<div class="comment-form-rating">
				<label for="rating">
					<?php echo esc_html__( 'Your rating', 'woocommerce' ); ?>
					<?php if ( wc_review_ratings_required() ): ?>
						&nbsp;<span class="required">*</span>
					<?php endif; ?>
				</label>
				<select name="rating" id="rating" required>
					<option value="">
						<?php echo esc_html__( 'Rate&hellip;', 'woocommerce' ); ?>
					</option>
					<option value="5">
						<?php echo esc_html__( 'Perfect', 'woocommerce' ); ?>
					</option>
					<option value="4">
						<?php echo esc_html__( 'Good', 'woocommerce' ); ?>
					</option>
					<option value="3">
						<?php echo esc_html__( 'Average', 'woocommerce' ); ?>
					</option>
					<option value="2">
						<?php echo esc_html__( 'Not that bad', 'woocommerce' ); ?>
					</option>
					<option value="1">
						<?php echo esc_html__( 'Very poor', 'woocommerce' ); ?>
					</option>
				</select>
			</div>

			<?php foreach ( $summary_criteria_list as $criteria_id => $criteria_title ) : ?>
				<div class="wd-review-criteria comment-form-rating" data-criteria-id=<?php echo esc_attr( $criteria_id ); ?>>
					<label for="<?php echo esc_attr( $criteria_id ); ?>">
						<?php echo esc_html( $criteria_title ); ?>
						<?php if ( woodmart_get_opt( 'reviews_criteria_rating_required' ) ) : ?>
							<span class="required">*</span>
						<?php endif; ?>
					</label>
					<div class="stars">
						<span>
							<a class="star-1" href="#">1</a>
							<a class="star-2" href="#">2</a>
							<a class="star-3" href="#">3</a>
							<a class="star-4" href="#">4</a>
							<a class="star-5" href="#">5</a>
						</span>
					</div>
					<select name="<?php echo esc_attr( $criteria_id ); ?>" id="<?php echo esc_attr( $criteria_id ); ?>" required>
						<option value="">
							<?php echo esc_html__( 'Rate&hellip;', 'woodmart' ); ?>
						</option>
						<option value="5">
							<?php echo esc_html__( 'Perfect', 'woodmart' ); ?>
						</option>
						<option value="4">
							<?php echo esc_html__( 'Good', 'woodmart' ); ?>
						</option>
						<option value="3">
							<?php echo esc_html__( 'Average', 'woodmart' ); ?>
						</option>
						<option value="2">
							<?php echo esc_html__( 'Not that bad', 'woodmart' ); ?>
						</option>
						<option value="1">
							<?php echo esc_html__( 'Very poor', 'woodmart' ); ?>
						</option>
					</select>
				</div>
			<?php endforeach; ?>
			<input type="hidden" name="summary_criteria_ids" value="<?php echo implode( ',', array_keys( $summary_criteria_list ) ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * This method save comment summary criteria ratings.
	 *
	 * @param int $comment_id Current comment id.
	 *
	 * @return void
	 */
	public function save_comment_summary_criteria( $comment_id ) {
		$summary_criteria_list = $this->get_summary_criteria_list();

		if ( 0 === count( $summary_criteria_list ) ) {
			return;
		}

		$this->clear_transient( $comment_id );

		foreach ( array_keys( $summary_criteria_list ) as $criteria_key ) {
			if ( isset( $_POST[ $criteria_key ], $_POST['comment_post_ID'] ) && in_array( $_POST[ $criteria_key ], array( '1', '2', '3', '4', '5' ), true ) && 'product' === get_post_type( absint( $_POST['comment_post_ID'] ) ) ) {
				add_comment_meta( $comment_id, $criteria_key, $_POST[ $criteria_key ], true );
			}
		}
	}

	/**
	 * Get summary criteria list. When key is criteria id and value is criteria title.
	 *
	 * @return array Example: array( 'criteria_id' => 'criteria_title', ).
	 */
	public function get_summary_criteria_list() {
		$criteria_ids_list = array();

		if ( isset( $_REQUEST['summary_criteria_ids'] ) && ! empty( $_REQUEST['summary_criteria_ids'] ) ) {
			$criteria_ids_list = explode( ',', $_REQUEST['summary_criteria_ids'] );
		}

		if ( ! empty( $criteria_ids_list ) ) {
			return $this->validate_summary_criteria_list( $criteria_ids_list );
		} else {
			return $this->get_summary_criteria_list_from_theme_settings();
		}
	}

	/**
	 * Check criteria rating is enabled.
	 *
	 * @return bool
	 */
	public function is_criteria_enabled() {
		return function_exists( 'wc_review_ratings_enabled' ) && wc_review_ratings_enabled() && ! empty( $this->get_summary_criteria_list() );
	}

	/**
	 * Clear woodmart_criteria_hash transients.
	 *
	 * @param int $comment_ID Current comment id.
	 * @return void
	 */
	public function clear_transient( $comment_ID ) {
		if ( ! $this->is_criteria_enabled() ) {
			return;
		}

		$product_id = get_comment( $comment_ID )->comment_post_ID;

		foreach ( $this->get_summary_criteria_list() as $criteria_id => $criteria_title ) {
			delete_transient( 'woodmart_criteria_hash_' . $product_id . '_' . $criteria_id );
		}
	}

	/**
	 * Get criteria rating list, when key is `reviews_rating_summary_criteria_${n}_slug` and value is list of ratings by this key.
	 * Example: array(
	 *      'criteria_slug_1' => array( 1, 2, 3, 4, 5, ),
	 *      'criteria_slug_2' => array( 1, 5, 2, ),
	 * );
	 *
	 * @return array
	 */
	public function get_criteria_rating_list() {
		$criteria_rating_list = array();

		if ( ! $this->is_criteria_enabled() ) {
			return $criteria_rating_list;
		}

		$product_id = Helper::get_product_id();

		foreach ( $this->get_summary_criteria_list() as $criteria_id => $criteria_title ) {
			$comments = get_transient( 'woodmart_criteria_hash_' . $product_id . '_' . $criteria_id );

			if ( ! $comments ) {
				$comments = get_comments(
					array(
						'post_id'            => $product_id,
						'order'              => 'ASC',
						'orderby'            => 'comment_date',
						'post_type'          => 'product',
						'status'             => 'approve',
						'include_unapproved' => array( is_user_logged_in() ? get_current_user_id() : wp_get_unapproved_comment_author_email() ),
						'meta_key'           => $criteria_id,
					)
				);

				set_transient( 'woodmart_criteria_hash_' . $product_id . '_' . $criteria_id ,  $comments );
			}

			foreach ( $comments as $comment ) {
				$criteria_rating_list[ $criteria_id ][] = get_comment_meta( $comment->comment_ID, $criteria_id, true );
			}
		}

		return $criteria_rating_list;
	}

	/**
	 * Add localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function add_localized_settings( $settings ) {
		$settings['is_criteria_enabled']  = $this->is_criteria_enabled();
		$settings['summary_criteria_ids'] = implode( ',', array_keys( $this->get_summary_criteria_list() ) );

		return $settings;
	}

	/**
	 * Get registered summary criteria list from all options.
	 *
	 * @return array Example: array( 'criteria_id' => 'criteria_title', ).
	 */
	private function get_all_registered_summary_criteria() {
		$all_registered_summary_criteria = array();
		$options                         = Options::get_options();

		for ( $i = 1; $i <= 6; $i++ ) {
			$criteria_slug_id = 'reviews_rating_summary_criteria_' . $i . '_slug';
			$criteria_title_id = 'reviews_rating_summary_criteria_' . $i;

			if ( ! isset( $options[ $criteria_slug_id ] ) || ! isset( $options[ $criteria_title_id ] ) ) {
				continue;
			}

			$all_registered_summary_criteria[ $options[ $criteria_slug_id ] ] = $options[ $criteria_title_id ];
		}

		foreach ( array_keys( Presets::get_all() ) as $preset_id ) {
			for ( $i = 1; $i <= 6; $i++ ) {
				$criteria_slug_id  = 'reviews_rating_summary_criteria_' . $i . '_slug';
				$criteria_title_id = 'reviews_rating_summary_criteria_' . $i;

				if ( ! isset( $options[ $preset_id ][ $criteria_slug_id ] ) || ! isset( $options[ $preset_id ][ $criteria_title_id ] ) ) {
					continue;
				}

				$all_registered_summary_criteria[ $options[ $preset_id ][ $criteria_slug_id ] ] = $options[ $preset_id ][ $criteria_title_id ];
			}
		}

		return array_unique( $all_registered_summary_criteria );
	}

	/**
	 * Get summary criteria list from theme settings.
	 *
	 * @return array Example: array( 'criteria_id' => 'criteria_title', ).
	 */
	private function get_summary_criteria_list_from_theme_settings() {
		$summary_criteria_list = array();

		if ( ! woodmart_get_opt( 'reviews_rating_by_criteria' ) ) {
			return $summary_criteria_list;
		}

		for ( $i = 1; $i <= 6; $i++ ) {
			$criteria_slug_id  = 'reviews_rating_summary_criteria_' . $i . '_slug';
			$criteria_title_id = 'reviews_rating_summary_criteria_' . $i;

			if ( ! woodmart_get_opt( $criteria_slug_id ) || ! woodmart_get_opt( $criteria_title_id ) ) {
				continue;
			}

			$summary_criteria_list[ woodmart_get_opt( $criteria_slug_id ) ] = woodmart_get_opt( $criteria_title_id );
		}

		return $summary_criteria_list;
	}

	/**
	 * Check whether the criterion is registered in Theme Settings Options.
	 *
	 * @param array $summary_criteria_ids Criteria ids to check with those in Theme Settings.
	 * @return array Checked array.
	 */
	private function validate_summary_criteria_list( $summary_criteria_ids ) {
		$all_registered_summary_criteria = $this->get_all_registered_summary_criteria();
		$summary_criteria_list           = array();

		foreach ( $summary_criteria_ids as $criteria_id ) {
			if ( in_array( $criteria_id, array_keys( $all_registered_summary_criteria ), true ) ) {
				$summary_criteria_list[ $criteria_id ] = $all_registered_summary_criteria[ $criteria_id ];
			}
		}

		return $summary_criteria_list;
	}
}

Rating_Criteria::get_instance();
