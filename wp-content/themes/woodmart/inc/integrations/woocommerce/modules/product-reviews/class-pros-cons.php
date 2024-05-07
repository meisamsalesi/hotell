<?php
/**
 * Single product reviews class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Product_Reviews;

use WP_Comment;
use XTS\Metaboxes;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Pros_Cons class.
 */
class Pros_Cons {
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
		add_action( 'init', array( $this, 'add_metaboxes' ), 20 );

		add_action( 'edit_comment', array( $this, 'edit_comment_pros_cons' ), 10, 2 );
		add_action( 'comment_post', array( $this, 'save_comment_pros_cons' ) );
		add_filter( 'comment_text', array( $this, 'render' ), 30, 2 );

		add_filter( 'woocommerce_product_review_comment_form_args', array( $this, 'add_pros_cons_fields' ) );
	}

	/**
	 * This method saves pros/cons fields after editing them on the admin page.
	 *
	 * @param int   $comment_id Current comment id.
	 * @param array $data Comment data.
	 *
	 * @return void
	 */
	public function edit_comment_pros_cons( $comment_id, $data ) {
		if ( 'review' !== $data['comment_type'] || ! isset( $_POST['pros'] ) || ! isset( $_POST['cons'] ) ) {
			return;
		}

		update_comment_meta( $comment_id, 'wd_pros', trim( $_POST['pros'] ) );
		update_comment_meta( $comment_id, 'wd_cons', trim( $_POST['cons'] ) );
	}

	/**
	 * This method save new meta-data for comment.
	 *
	 * @param int $comment_id Current comment id.
	 *
	 * @return void
	 */
	public function save_comment_pros_cons( $comment_id ) {
		if ( isset( $_POST['pros'], $_POST['cons'], $_POST['comment_post_ID'] ) && 'product' === get_post_type( absint( $_POST['comment_post_ID'] ) ) ) {
			add_comment_meta( $comment_id, 'wd_pros', trim( $_POST['pros'] ), true );
			add_comment_meta( $comment_id, 'wd_cons', trim( $_POST['cons'] ), true );
		}
	}

	/**
	 * This method add new fields to comment form.
	 *
	 * @param array $comment_form List of data for render comment form.
	 *
	 * @return array
	 */
	public function add_pros_cons_fields( $comment_form ) {
		if ( ! woodmart_get_opt( 'reviews_enable_pros_cons' ) ) {
			return $comment_form;
		}

		$comment_form['comment_field'] .= '<p class="comment-form-pros"><label for="pros">' . esc_html__( 'Pros', 'woodmart' ) . '</label><input id="pros" name="pros" type="text" value="" size="30"/></p>';

		$comment_form['comment_field'] .= '<p class="comment-form-cons"><label for="cons">' . esc_html__( 'Cons', 'woodmart' ) . '</label><input id="cons" name="cons" type="text" value="" size="30"/></p>';

		return $comment_form;
	}

	/**
	 * Render additional field after `.comment-text`.
	 *
	 * @param string $comment_content Comment content html.
	 * @param WP_Comment $comment Single comment.
	 *
	 * @return string
	 */
	public function render( $comment_content, $comment ) {
		if ( ! woodmart_get_opt( 'reviews_enable_pros_cons' ) || ( ! wp_doing_ajax() && ( is_admin() || ! is_singular( 'product' ) ) ) ) {
			return $comment_content;
		}

		$pros_list = array_filter( get_comment_meta( $comment->comment_ID, 'wd_pros' ) );
		$cons_list = array_filter( get_comment_meta( $comment->comment_ID, 'wd_cons' ) );

		if ( empty( $pros_list ) && empty( $cons_list ) ) {
			return $comment_content;
		}

		ob_start();
		?>
		<div class="wd-review-arguments">
			<?php foreach ( $pros_list as $pros ) : ?>
				<?php
				if ( empty( $pros ) ) {
					continue;
				}
				?>

				<div class="wd-pros">
					<div class="wd-argument-label">
						<?php echo esc_html__( 'Pros:', 'woodmart' ); ?>
					</div>
					<p>
						<?php echo esc_html( $pros ); ?>
					</p>
				</div>
			<?php endforeach; ?>

			<?php foreach ( $cons_list as $cons ) : ?>
				<?php
				if ( empty( $cons ) ) {
					continue;
				}
				?>

				<div class="wd-cons">
					<div class="wd-argument-label">
						<?php echo esc_html__( 'Cons:', 'woodmart' ); ?>
					</div>
					<p>
						<?php echo esc_html( $cons ); ?>
					</p>
				</div>
			<?php endforeach; ?>
		</div>
		<?php

		return $comment_content . ob_get_clean();
	}

	/**
	 * Add metaboxes for product reviews.
	 *
	 * @since 1.0.0
	 */
	public function add_metaboxes() {
		if ( ! woodmart_get_opt( 'reviews_enable_pros_cons' ) || ! isset( $_REQUEST['action'] ) || 'editcomment' !== $_REQUEST['action'] ) {
			return;
		}

		$comment_id = $_REQUEST['c'];
		$comment    = get_comment( $comment_id );

		if ( ! $comment instanceof WP_Comment || 'product' !== $comment->__get( 'post_type' ) || 'review' !== $comment->comment_type ) {
			return;
		}

		$pros_list = $comment_id ? array_filter( get_comment_meta( $comment_id, 'wd_pros' ) ) : array();
		$cons_list = $comment_id ? array_filter( get_comment_meta( $comment_id, 'wd_cons' ) ) : array();

		$pros_text = isset( $pros_list[0] ) ? $pros_list[0] : '';
		$cons_text = isset( $cons_list[0] ) ? $cons_list[0] : '';

		$metaboxes = Metaboxes::add_metabox(
			array(
				'id'     => 'woodmart_review_pros_cons_metabox',
				'title'  => esc_html__( 'Review pros/cons metabox', 'woodmart' ),
				'object' => array( 'comment' ),
			)
		);

		$metaboxes->add_section(
			array(
				'id'       => 'general',
				'name'     => esc_html__( 'General', 'woodmart' ),
				'icon'     => 'xts-i-footer',
				'priority' => 10,
			)
		);

		$metaboxes->add_field(
			array(
				'id'       => 'pros',
				'name'     => esc_html__( 'Pros', 'woodmart' ),
				'type'     => 'text_input',
				'section'  => 'general',
				'default'  => $pros_text,
				'priority' => 10,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);

		$metaboxes->add_field(
			array(
				'id'       => 'cons',
				'name'     => esc_html__( 'Cons', 'woodmart' ),
				'type'     => 'text_input',
				'section'  => 'general',
				'default'  => $cons_text,
				'priority' => 10,
				'class'    => 'xts-tab-field xts-last-tab-field xts-col-6',
			)
		);
	}
}

new Pros_Cons();
