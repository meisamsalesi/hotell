<?php

namespace XTS\Inc\Admin\Dashboard;

use XTS\Singleton;

class Slider extends Singleton {
	/**
	 * Constructor.
	 */
	public function init() {
		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		add_action( 'woodmart_slider_term_edit_form_top', [ $this, 'add_slides_to_slider_page' ], 9 );
		add_action( 'wp_ajax_woodmart_get_slides_data', [ $this, 'get_slides_data' ] );
		add_action( 'post_edit_form_tag', [ $this, 'enqueue_script' ] );
	}

	/**
	 * Enqueue script.
	 *
	 * @param object $post Post.
	 */
	public function enqueue_script( $post ) {
		if ( ! $post || $post->post_type !== 'woodmart_slide' ) {
			return;
		}
		wp_enqueue_script( 'wd-sliders-ui', WOODMART_ASSETS . '/js/sliders-ui.js', array(), WOODMART_VERSION, true );
	}

	/**
	 * Add slides to slider list.
	 */
	public function get_slides_data() {
		check_ajax_referer( 'woodmart-get-slides-nonce', 'security' );
		$output     = array();
		$taxonomies = get_terms( 'woodmart_slider', array( 'hide_empty' => false ) );

		if ( ! $taxonomies ) {
			wp_send_json_error();
		}

		foreach ( $taxonomies as $taxonomy ) {
			$slider_id = $taxonomy->term_id;

			$output[ $slider_id ]['slider_edit_link'] = get_edit_term_link( $slider_id, 'woodmart_slider' );
			$output[ $slider_id ]['slider_edit_text'] = esc_html__( 'Slider settings', 'woodmart' );
		}

		if ( empty( $_GET['slider_id'] ) ) {
			wp_send_json_success( $output );
		}

		$args = array(
			'posts_per_page' => -1,
			'post_type'      => 'woodmart_slide',
			'tax_query'      => array(
				'relation' => 'OR',
			),
		);

		$slider_ids = $_GET['slider_id']; //phpcs:ignore

		foreach ( $slider_ids as $id ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'woodmart_slider',
				'field'    => 'term_id',
				'terms'    => (int) $id,
			);
		}

		$slides = new \WP_Query( $args );

		if ( $slides->posts ) {
			foreach ( $slides->posts as $slide ) {
				$bg_image_desktop      = has_post_thumbnail( $slide->ID ) ? wp_get_attachment_url( get_post_thumbnail_id( $slide->ID ) ) : '';
				$meta_bg_image_desktop = get_post_meta( $slide->ID, 'bg_image_desktop', true );

				if ( is_array( $meta_bg_image_desktop ) ) {
					$meta_bg_image_desktop = $meta_bg_image_desktop['url'];
				}

				if ( $meta_bg_image_desktop ) {
					$bg_image_desktop = $meta_bg_image_desktop;
				}

				$slider_term = wp_get_post_terms( $slide->ID, 'woodmart_slider' );

				if ( ! $slider_term ) {
					continue;
				}

				foreach ( $slider_term as $term ) {
					$slider_id = $term->term_id;

					$output[ $slider_id ]['slides'][ $slide->ID ] = array(
						'id'       => $slide->ID,
						'title'    => $slide->post_title,
						'link'     => get_edit_post_link( $slide->ID, 'url' ),
						'img_url'  => $bg_image_desktop,
						'bg_color' => get_post_meta( $slide->ID, 'bg_color', true ),
					);
				}
			}
		}

		wp_send_json_success( $output );
	}

	/**
	 * Add slides list to slider.
	 *
	 * @param object $tag Term object.
	 */
	public function add_slides_to_slider_page( $tag ) {
		$args = array(
			'posts_per_page' => -1,
			'post_type'      => 'woodmart_slide',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'      => array( // phpcs:ignore
				array(
					'taxonomy' => 'woodmart_slider',
					'field'    => 'id',
					'terms'    => $tag->term_id,
				),
			),
		);

		$slides = new \WP_Query( $args );

		?>
		<div class="xts-edit-slider-slides-wrap">
			<div class="xts-edit-slider-slides">
				<div class="xts-wp-add-heading">
					<h1 class="wp-heading-inline">
						<?php esc_html_e( 'Slides', 'woodmart' ); ?>
					</h1>

					<a class="page-title-action" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=woodmart_slide&slider_id=' . $tag->term_id ) ); ?>">
						<?php esc_html_e( 'Add new', 'woodmart' ); ?>
					</a>
				</div>

				<?php if ( $slides->posts ) : ?>
					<div class="xts-wp-table">
						<div class="xts-wp-row xts-wp-row-heading">
							<div class="xts-wp-table-img"></div>
							<div class="xts-wp-table-title"><?php esc_html_e( 'Title', 'woodmart' ); ?></div>
							<div class="xts-wp-table-date"><?php esc_html_e( 'Date', 'woodmart' ); ?></div>
						</div>
						<?php foreach ( $slides->posts as $slide ) : ?>
							<?php
							$bg_image_desktop      = has_post_thumbnail( $slide->ID ) ? wp_get_attachment_url( get_post_thumbnail_id( $slide->ID ) ) : '';
							$meta_bg_image_desktop = get_post_meta( $slide->ID, 'bg_image_desktop', true );
							$bg_slide_color        = get_post_meta( $slide->ID, 'bg_color', true );

							if ( is_array( $meta_bg_image_desktop ) ) {
								$meta_bg_image_desktop = $meta_bg_image_desktop['url'];
							}

							if ( $meta_bg_image_desktop ) {
								$bg_image_desktop = $meta_bg_image_desktop;
							}

							?>
							<div class="xts-wp-row">
								<div class="xts-wp-table-img">
									<?php if ( $bg_image_desktop ) : ?>
										<img src="<?php echo esc_url( $bg_image_desktop ); ?>" alt="slide image">
									<?php elseif ( $bg_slide_color ) : ?>
										<div class="xts-slider-bg-color" style="background-color: <?php echo esc_attr( $bg_slide_color ); ?>"></div>
									<?php endif; ?>
								</div>

								<div class="xts-wp-table-title">
									<a href="<?php echo esc_url( get_edit_post_link( $slide->ID, 'url' ) ); ?>">
										<?php echo esc_html( $slide->post_title ); ?>
									</a>
									<div class="xts-actions">
										<a href="<?php echo esc_url( get_edit_post_link( $slide->ID, 'url' ) ); ?>">
											<?php esc_html_e( 'Edit', 'woodmart' ); ?>
										</a>

										<a class="xts-bin" href="<?php echo esc_url( get_delete_post_link( $slide->ID ) ); ?>">
											<?php esc_html_e( 'Trash', 'woodmart' ); ?>
										</a>

										<a href="<?php echo esc_url( get_preview_post_link( $slide->ID ) ); ?>">
											<?php esc_html_e( 'View', 'woodmart' ); ?>
										</a>
									</div>
								</div>

								<div class="xts-wp-table-date">
									<span><?php esc_html_e( 'Published', 'woodmart' ); ?></span>
									<br>
									<span>
										<?php echo esc_html( $slide->post_modified ); ?>
									</span>
								</div>
							</div>
						<?php endforeach; ?>
						<div class="xts-wp-row xts-wp-row-heading">
							<div class="xts-wp-table-img"></div>
							<div class="xts-wp-table-title"><?php esc_html_e( 'Title', 'woodmart' ); ?></div>
							<div class="xts-wp-table-date"><?php esc_html_e( 'Date', 'woodmart' ); ?></div>
						</div>
					</div>
				<?php else : ?>
					<div class="xts-notice xts-info">
						<?php esc_html_e( 'There are no slides yet.', 'woodmart' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}

Slider::get_instance();
