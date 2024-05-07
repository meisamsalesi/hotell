<?php
/**
 * Single product reviews class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Product_Reviews;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Rating_Summary class.
 */
class Rating_Summary extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		if ( ! woodmart_get_opt( 'reviews_rating_summary' ) ) {
			return;
		}

		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_filter( 'comment_post_redirect', array( $this, 'redirect_after_comment' ) );
	}

	/**
	 * Get percentage or average from rating.
	 *
	 * @param string $criteria_slug Criteria slug from `reviews_rating_summary_criteria_${n}_slug` option
	 * @param string|array $rating List of ratings by this criteria slug, or simple rating key.
	 * @param string $format Format rating value. You can get 'percentage' or 'average' rating. Default = 'percentage'.
	 * @return float|int
	 */
	public function get_rating_value( $criteria_slug, $rating, $format = 'percentage' ) {
		$product              = wc_get_product( Helper::get_product_id() );
		$criteria_rating_list = Rating_Criteria::get_instance()->get_criteria_rating_list();
		$is_criteria_count    = Rating_Criteria::get_instance()->is_criteria_enabled() && ! empty( $criteria_rating_list[ $criteria_slug ] );

		if ( $is_criteria_count ) {
			$count              = count( array_filter( $criteria_rating_list[ $criteria_slug ] ) );
			$total_rating_count = array_sum( $criteria_rating_list[ $criteria_slug ] );
		} else {
			$count              = $product->get_rating_count( $rating );
			$total_rating_count = $product->get_rating_count();
		}

		if ( 0 === $count || 0 === $total_rating_count ) {
			return  0;
		} else if ( 'average' === $format ) {
			return $total_rating_count / $count;
		} else if ( 'percentage' === $format ) {
			if ( $is_criteria_count ) {
				return $total_rating_count / $count / 5 * 100;
			} else {
				return $count / $total_rating_count * 100;
			}
		}

		return  0;
	}

	/**
	 * Render rating summary.
	 *
	 * @param bool $return Do you need to return the html?.
	 * @return string|void
	 */
	public function render_filter_dashboard( $return = false ) {
		if ( ! function_exists( 'wc_review_ratings_enabled' ) || ! wc_review_ratings_enabled() ) {
			return '';
		}

		$product                = wc_get_product( Helper::get_product_id() );
		$ratings                = array( '5', '4', '3', '2', '1' );
		$average_rating         = round( $product->get_average_rating(), 1 );
		$reviews_count          = $product->get_review_count();
		$rating_summary_classes = 'rating' === woodmart_get_opt( 'reviews_rating_summary_content', 'rating' ) && woodmart_get_opt( 'reviews_rating_summary_filter' ) ? ' wd-with-filter' : '';
		$rating_format          = 'percentage';

		if ( 'criteria' === woodmart_get_opt( 'reviews_rating_summary_content', 'rating' ) && Rating_Criteria::get_instance()->is_criteria_enabled() ) {
			$rating_summary_classes .= ' wd-with-criteria';
			$ratings                 = Rating_Criteria::get_instance()->get_summary_criteria_list();
		}

		$ratings = apply_filters( 'woodmart_product_ratings', $ratings );

		if ( $return ) {
			ob_start();
		}

		woodmart_enqueue_inline_style( 'woo-mod-progress-bar' );
		woodmart_enqueue_inline_style( 'woo-single-prod-opt-rating-summary' );
		?>
		<div class="wd-rating-summary wd-sticky<?php echo esc_attr( apply_filters( 'woodmart_rating_summary_classes', $rating_summary_classes ) );?>">
			<div class="wd-rating-summary-heading">
				<?php if ( $average_rating ): ?>
					<div class="wd-rating-summary-main">
						<?php echo esc_html( $average_rating ); ?>
					</div>
				<?php endif; ?>
				<div class="star-rating" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5', 'woodmart' ), $average_rating ) ); ?>">
					<?php echo wp_kses( woodmart_get_star_rating_html( $average_rating ), true ); ?>
				</div>
				<div class="wd-rating-summary-total">
					<?php
					printf( _nx( '%d review', '%d reviews', $reviews_count, 'noun', 'woodmart' ), $reviews_count ); // phpcs:ignore.
					?>
				</div>
			</div>
			<div class="wd-rating-summary-cont">
				<?php

				foreach ( $ratings as $key => $rating ) {
					$rating_value                 = round( $this->get_rating_value( $key, $rating , 'percentage' ) );
					$wd_active                    = in_array( $rating, Helper::get_ratings_from_request(), true );
					$rating_summary_item_classes  = esc_attr( $wd_active ? ' wd-active' : '' );
					$rating_summary_item_classes .= floatval( 0 ) === $rating_value ? ' wd-empty' : '';
					?>
					<div class="wd-rating-summary-item<?php echo esc_attr( $rating_summary_item_classes ); ?>">
						<div class="wd-rating-label" data-rating="<?php echo esc_attr( $rating ); ?>">
							<?php if ( ! Rating_Criteria::get_instance()->is_criteria_enabled() || 'rating' === woodmart_get_opt( 'reviews_rating_summary_content', 'rating' ) ) : ?>
								<div class="star-rating" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5', 'woodmart' ), $rating ) ); ?>">
									<?php echo wp_kses( woodmart_get_star_rating_html( $rating ), true ); ?>
								</div>
							<?php else: ?>
								<?php echo esc_attr( $rating ); ?>
							<?php endif; ?>
						</div>
						<div class="wd-rating-progress-bar wd-progress-bar">
							<div class="progress-area">
								<div class="progress-bar" style="width: <?php echo esc_attr( $rating_value ); ?>%;"></div>
							</div>
						</div>
						<div class="wd-rating-count">
							<?php
							$rating_count = $product->get_rating_count( $rating );

							if ( Rating_Criteria::get_instance()->is_criteria_enabled() && 'criteria' === woodmart_get_opt( 'reviews_rating_summary_content', 'rating' ) ) {
								$rating_count = round( $this->get_rating_value( $key, $rating , 'average' ), 1 );
							}

							$rating_count = apply_filters( 'woodmart_rating_count', $rating_count, $key, $rating );

							?>
							<?php echo esc_html( $rating_count ); ?>

							<?php if ( Rating_Criteria::get_instance()->is_criteria_enabled() && 'criteria' === woodmart_get_opt( 'reviews_rating_summary_content', 'rating' ) ) : ?>
								<div class="star-rating" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5', 'woodmart' ), $rating_count ) ); ?>">
									<?php echo wp_kses( woodmart_get_star_rating_html( $rating_count ), true ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php
				}
				?>
			</div>

			<?php do_action( 'woodmart_after_rating_summary_content' ); ?>
		</div>
		<?php
		if ( $return ) {
			return ob_get_clean();
		}
	}

	/**
	 * This method returns a value HTTP_REFERER, to return to the same page after adding a new comment to the product.
	 *
	 * @param string $location The 'redirect_to' URI sent via $_POST.
	 * @return array|string
	 */
	public function redirect_after_comment( $location ) { // phpcs:ignore.
		return wp_unslash( $_SERVER['HTTP_REFERER'] ); // phpcs:ignore.
	}
}

Rating_Summary::get_instance();
