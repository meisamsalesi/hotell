<?php
/**
 * Single product reviews class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Product_Reviews;

use WP_Comment;
use WP_Post;
use XTS\Modules\Layouts\Global_Data;
use XTS\Singleton;
use XTS\Modules\Layouts\Main as Builder;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Reviews class.
 */
class Reviews extends Singleton {
	private $comment_count = 0;

	/**
	 * Init.
	 */
	public function init() {
		add_action( 'wp_ajax_woodmart_filter_review', array( $this, 'ajax_filter_reviews' ) );
		add_action( 'wp_ajax_nopriv_woodmart_filter_review', array( $this, 'ajax_filter_reviews' ) );

		add_filter( 'comment_class', array( $this, 'add_comment_class' ), 10, 5 );

		remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating' );
		add_action( 'woocommerce_review_before_comment_text', 'woocommerce_review_display_rating' );

		if ( 'style-2' === woodmart_get_opt( 'reviews_style' ) ) {
			remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar' );
		}

		add_action( 'wp', array( $this, 'do_after_setup_globals_options' ), 500 );
	}

	public function do_after_setup_globals_options() {
		if ( 'rating' === woodmart_get_opt( 'reviews_rating_summary_content' ) && woodmart_get_opt( 'reviews_rating_summary_filter' ) ) {
			add_action( 'woodmart_after_rating_summary_content', array( $this, 'get_ajax_loader' ) );
		}
	}

	/**
	 * Add ajax loader html.
	 *
	 * @return void
	 */
	public function get_ajax_loader() {
		?>
		<div class="wd-loader-overlay wd-fill"></div>
		<?php
	}

	/**
	 * Added custom css classes for product reviews li.
	 *
	 * @param string[]    $classes An array of comment classes.
	 * @param string[]    $css_class  An array of additional classes added to the list.
	 * @param string      $comment_id The comment ID as a numeric string.
	 * @param WP_Comment  $comment    The comment object.
	 * @param int|WP_Post $post_id    The post ID or WP_Post object.
	 *
	 * @return string[]
	 */
	public function add_comment_class( $classes, $css_class, $comment_id, $comment, $post_id ) {
		if ( ! woodmart_woocommerce_installed() || ( ! is_singular( 'product' ) && ! Builder::get_instance()->has_custom_layout( 'single_product' ) ) && ! woodmart_is_woo_ajax() || empty( $comment ) || ! function_exists( 'wc_customer_bought_product' ) ) {
			return $classes;
		}

		$classes[] = 'wd-col';

		return $classes;
	}

	/**
	 * Get list of comments.
	 *
	 * @return array List of comments.
	 */
	public function filter_comments() {
		global $overridden_cpage;

		$product_id = Helper::get_product_id();
		$ratings    = Helper::get_ratings_from_request();
		$order_by   = Helper::get_order_by_from_request();

		$page          = (get_query_var('cpage')) ? get_query_var('cpage') : 1;
		$limit         = get_option( 'comments_per_page' );
		$offset        = ($page * $limit) - $limit;
		$comment_order = get_option( 'comment_order' );

		$args = apply_filters(
			'woodmart_product_reviews_args',
			array(
				'post_id'            => $product_id,
				'post_type'          => 'product',
				'status'             => 'approve',
				'orderby'            => 'comment_date_gmt',
				'order'              => $comment_order,
				'paged'              => $page,
				'offset'             => $offset,
				'include_unapproved' => array( is_user_logged_in() ? get_current_user_id() : wp_get_unapproved_comment_author_email() ),
			)
		);

		$stars = apply_filters( 'woodmart_product_reviews_ratings', $ratings );

		if ( 'default' !== $order_by ) {
			switch ( $order_by ) {
				case 'newest':
					$args['order'] = 'DESC';
					break;
				case 'oldest':
					$args['order'] = 'ASC';
					break;
				case 'highest_rated':
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';

					$args['meta_query'] = array( // phpcs:ignore.
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'     => 'rating',
								'compare' => 'NOT EXISTS',
							),
							array(
								'key'     => 'rating',
								'compare' => 'EXISTS',
							)
						),
					);
					break;
				case 'lowest_rated':
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'ASC';

					$args['meta_query'] = array( // phpcs:ignore.
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'     => 'rating',
								'compare' => 'NOT EXISTS',
							),
							array(
								'key'     => 'rating',
								'compare' => 'EXISTS',
							)
						),
					);
					break;
				case 'most_helpful':
					$args['orderby']  = 'meta_value_num comment_date_gmt';
					$args['order']    = 'DESC';

					$args['meta_query'] = array( // phpcs:ignore.
						'relation' => 'AND',
						array(
							'relation' => 'OR',
							array(
								'key'     => 'wd_total_vote',
								'compare' => 'NOT EXISTS',
							),
							array(
								'key'     => 'wd_total_vote',
								'compare' => 'EXISTS',
							)
						),
					);
					break;
			}
		}

		if ( ! empty( $stars ) ) {
			$args['meta_query'][] = array( // phpcs:ignore.
				array(
					'key'   => 'rating',
					'value' => $stars,
				),
			);
		}

		if ( Helper::show_only_image() ) {
			$args['meta_query'][] = array( // phpcs:ignore.
				'relation' => 'AND',
				array(
					'key'     => '_woodmart_image_id',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => '_woodmart_image_id',
					'compare' => '!=',
					'value'   => ''
				),
				array(
					'key'     => 'rating',
					'compare' => '=',
					'value'   => $stars
				),
			);
		}

		$comments = get_comments( $args );

		$comment_count = 0;

		foreach ( $comments as $comment ) {
			if ( '0' !== $comment->comment_parent ) {
				continue;
			}

			$comment_count++;
		}

		$this->comment_count = $comment_count;

		if ( wp_doing_ajax() && ( ! empty( $stars ) || Helper::show_only_image() ) ) {
			$comments_children = array();

			foreach ( $comments as $comment ) {
				$comments_children += $comment->get_children(
					array(
						'status' => 'approve',
					)
				);
			}

			$comments = array_merge( $comments, $comments_children );
		}

		if ( 'default' === $order_by && 'desc' === $comment_order ) {
			$comments = array_reverse( $comments );
		}

		$max_depth = get_option( 'thread_comments' ) ? get_option( 'thread_comments_depth' ): -1;
		$threaded  = ( -1 !== $max_depth );

		if ( wp_doing_ajax() && get_comment_pages_count( $comments, $limit, $threaded ) > 1 ) {
			$overridden_cpage = true;
		}

		return $comments;
	}

	/**
	 * Render title.
	 *
	 * @param bool $return Do you need to return the html?.
	 * @return string|void
	 */
	public function render_title( $return = false ) {
		global $product;

		$product_id = Helper::get_product_id();

		if ( $return ) {
			ob_start();
		}

		$count = $this->comment_count;

		if ( function_exists( 'wc_review_ratings_enabled' ) && wc_review_ratings_enabled() ) {
			/* translators: 1: reviews count 2: stars rating 3: product name*/
			$reviews_title = sprintf(
				esc_html(
					_n(
						'%1$s %2$s review for %3$s',
						'%1$s %2$s reviews for %3$s',
						$count,
						'woodmart'
					)
				),
				esc_html( $count ),
				esc_html(
					implode(
						', ',
						array_map(
							function( $rating ) {
								return '"' . $rating . ' stars' . '"' ;
							},
							Helper::get_ratings_from_request()
						)
					)
				),
				'<span>' . get_the_title( $product_id ) . '</span>'
			);

			echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // phpcs:ignore.
		} else {
			esc_html_e( 'Reviews', 'woocommerce' );
		}

		if ( $return ) {
			return ob_get_clean();
		}
	}

	/**
	 * Render comments.
	 *
	 * @param bool $return Do you need to return the html?.
	 * @return string|void
	 */
	public function render_comments( $return = false ) {
		$comments             = $this->filter_comments();
		$comment_list_classes = 'wd-grid';
		$comment_list_styles  = '';
		$reviews_attr         = array();

		$comment_list_classes .= ' wd-review-' . woodmart_get_opt( 'reviews_style', 'style-1' );

		if ( ! wp_doing_ajax() ) {
			$comment_list_classes .= ' wd-active wd-in';
		}

		foreach ( array( 'desktop', 'tablet', 'mobile' ) as $device ) {
			$key             = 'reviews_columns' . ( 'desktop' === $device ? '' : '_' . $device );
			$prefix          = '';
			$reviews_columns = Global_Data::get_instance()->get_data( $key ) ? Global_Data::get_instance()->get_data( $key ) : woodmart_get_opt( $key, 1 );

			if ( 'tablet' === $device ) {
				$prefix = '-md';
			} else if ( 'mobile' === $device ) {
				$prefix = '-sm';
			}

			if ( wp_doing_ajax() && isset( $_GET[ $key ] ) ) {
				$reviews_columns = $_GET[ $key ];
			}

			$comment_list_classes .= $reviews_columns ? sprintf( ' wd-grid-col%s-%s', $prefix, $reviews_columns ) : '';
			$comment_list_styles  .= $reviews_columns ? sprintf( '--wd-col%s: %s;', $prefix, $reviews_columns ) : '';

			$reviews_attr[ $key ] = $reviews_columns;
		}

		if ( $return ) {
			ob_start();
		}
		?>
		<ol class="commentlist <?php echo apply_filters( 'woodmart_single_product_comment_list_classes', $comment_list_classes ); ?>" style="<?php echo esc_attr( $comment_list_styles ); ?>" data-reviews-columns="<?php echo esc_attr( wp_json_encode( $reviews_attr ) ); ?>">
			<?php
			if ( 0 !== count( $comments ) ) {
				wp_list_comments(
					apply_filters(
						'woocommerce_product_review_list_args',
						array(
							'callback'          => 'woocommerce_comments',
							'per_page'          => get_option( 'comments_per_page' ),
							'reverse_top_level' => 'default' !== Helper::get_order_by_from_request() ? 0 : null,
						)
					),
					$comments
				);
			} else {
				?>
				<li class="woocommerce-noreviews wd-col"><?php esc_html_e( 'There are no reviews matching the given conditions.', 'woodmart' ); ?></li>
				<?php
			}
			?>
		</ol>
		<?php

		if ( wp_doing_ajax() ) {
			$this->render_pagination();
		}

		if ( $return ) {
			return ob_get_clean();
		}
	}

	/**
	 * Render pagination.
	 *
	 * @param bool $return Do you need to return the html?.
	 * @return string|void
	 */
	public function render_pagination( $return = false ) {
		$max_page = get_comment_pages_count( $this->filter_comments() );

		if ( $max_page <= 1 || ! get_option( 'page_comments' ) ) {
			return;
		}

		global $wp_rewrite;

		if ( $return ) {
			ob_start();
		}

		$product_id = Helper::get_product_id();
		$ratings    = Helper::get_ratings_from_request();
		$order_by   = Helper::get_order_by_from_request();

		$page = get_query_var( 'cpage' );

		if ( ! $page ) {
			$page = 1;
		}

		$args = array(
			'base'         => add_query_arg( 'cpage', '%#%' ),
			'format'       => '',
			'total'        => $max_page,
			'current'      => $page,
			'echo'         => true,
			'type'         => 'list',
			'add_fragment' => '#comments',
			'prev_text'    => is_rtl() ? '&rarr;' : '&larr;',
			'next_text'    => is_rtl() ? '&larr;' : '&rarr;',
		);

		if ( woodmart_get_opt( 'reviews_rating_summary' ) ) {
			$args['add_args'] = array(
				'rating'     => ! empty( $ratings ) ? implode( ',', $ratings ) : '',
				'product_id' => $product_id,
				'order_by'   => $order_by,
				'action'     => 'woodmart_filter_comments',
			);
		}

		if ( $wp_rewrite->using_permalinks() ) {
			$args['base'] = user_trailingslashit( trailingslashit( get_permalink( $product_id ) ) . $wp_rewrite->comments_pagination_base . '-%#%', 'commentpaged' );
		}
		?>
		<nav class="woocommerce-pagination">
			<?php
			echo paginate_links( apply_filters( 'woodmart_comment_pagination_args', $args ) ); // phpcs:ignore;
			?>
		</nav>

		<?php
		if ( $return ) {
			return ob_get_clean();
		}
	}

	/**
	 * Filter reviews with ajax.
	 */
	public function ajax_filter_reviews() {
		$data = array(
			'content' => $this->render_comments( true ),
			'title'   => $this->render_title( true ),
		);

		wp_send_json( $data );
	}
}

Reviews::get_instance();
