<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

use XTS\Modules\Product_Reviews\Helper;
use XTS\Modules\Product_Reviews\Rating_Criteria;
use XTS\Modules\Product_Reviews\Rating_Summary;
use XTS\Modules\Product_Reviews\Reviews;
use XTS\Modules\Product_Reviews\Reviews_Sorting;

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

$review_form_classes = 'wd-form-pos-' . woodmart_get_opt( 'reviews_form_location', 'after' );

if ( woodmart_get_opt( 'reviews_enable_pros_cons' ) || woodmart_get_opt( 'reviews_enable_likes' ) || woodmart_get_opt( 'reviews_rating_summary' ) ||  woodmart_get_opt( 'reviews_sorting' ) || woodmart_get_opt( 'show_reviews_only_image_filter' ) ) {
	woodmart_enqueue_js_script( 'product-reviews' );
}

?>
<div id="reviews" class="woocommerce-Reviews" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
	<?php if ( woodmart_get_opt( 'reviews_rating_summary' ) && function_exists( 'wc_review_ratings_enabled' ) && wc_review_ratings_enabled() ) : ?>
		<div class="wd-rating-summary-wrap">
			<?php Rating_Summary::get_instance()->render_filter_dashboard(); ?>
		</div>
	<?php endif; ?>

	<div id="comments">
		<div class="wd-reviews-heading">
			<div class="wd-reviews-tools">
				<h2 class="woocommerce-Reviews-title">
					<?php
					$count = $product->get_review_count();
					if ( $count && wc_review_ratings_enabled() ) {
						/* translators: 1: reviews count 2: product name */
						$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
						echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
					} else {
						esc_html_e( 'Reviews', 'woocommerce' );
					}
					?>
				</h2>

				<?php if ( woodmart_get_opt( 'reviews_rating_summary' ) || ( woodmart_get_opt( 'show_reviews_only_image_filter' ) && woodmart_get_opt( 'single_product_comment_images' ) ) ) : ?>
					<a class="wd-reviews-sorting-clear <?php echo ! Helper::get_ratings_from_request() && ! Helper::show_only_image() ? esc_attr( 'wd-hide' ) : ''; ?>">
						<?php echo esc_html__( 'Clear filters', 'woodmart' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( woodmart_get_opt( 'reviews_sorting' ) || ( woodmart_get_opt( 'show_reviews_only_image_filter' ) && woodmart_get_opt( 'single_product_comment_images' ) ) ) : ?>
				<form class="wd-reviews-tools wd-reviews-filters">
					<?php if ( woodmart_get_opt( 'show_reviews_only_image_filter' ) && woodmart_get_opt( 'single_product_comment_images' ) ) : ?>
						<div class="wd-with-image">
							<input type="checkbox" name="only-image" id="wd-with-image-checkbox" <?php echo Helper::show_only_image() ? esc_attr( 'checked' ) : ''; ?>>
							<label for="wd-with-image-checkbox">
								<?php echo esc_html__( 'Only with images', 'woodmart' ); ?>
							</label>
						</div>
					<?php endif; ?>

					<?php if ( woodmart_get_opt( 'reviews_sorting' ) ) : ?>
						<?php Reviews_Sorting::get_instance()->render(); ?>
					<?php endif; ?>
				</form>
			<?php endif; ?>
		</div>

		<div class="wd-reviews-content wd-sticky">
			<?php if ( have_comments() ) : ?>
				<?php Reviews::get_instance()->render_comments(); ?>

				<?php if ( woodmart_get_opt( 'reviews_rating_summary' ) || woodmart_get_opt( 'reviews_sorting' ) ) : ?>
					<?php Reviews::get_instance()->render_pagination(); ?>
				<?php elseif ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<nav class="woocommerce-pagination">
						<?php
						paginate_comments_links(
							apply_filters(
								'woocommerce_comment_pagination_args',
								array(
									'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
									'next_text' => is_rtl() ? '&larr;' : '&rarr;',
									'type'      => 'list',
								)
							)
						);
						?>
					</nav>
				<?php endif; ?>
			<?php else : ?>
				<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
			<?php endif; ?>
		</div>

		<div class="wd-loader-overlay wd-fill"></div>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper" class="<?php echo esc_attr( $review_form_classes ); ?>">
			<div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'    => __( 'Name', 'woocommerce' ),
						'type'     => 'text',
						'value'    => $commenter['comment_author'],
						'required' => $name_email_required,
					),
					'email'  => array(
						'label'    => __( 'Email', 'woocommerce' ),
						'type'     => 'email',
						'value'    => $commenter['comment_author_email'],
						'required' => $name_email_required,
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( Rating_Criteria::get_instance()->is_criteria_enabled() ) {
					$comment_form['comment_field'] .= Rating_Criteria::get_instance()->get_criteria_stars_ratings_fields();
				} else if ( wc_review_ratings_enabled() ) {
						$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
					</select></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
	<?php endif; ?>
</div>
