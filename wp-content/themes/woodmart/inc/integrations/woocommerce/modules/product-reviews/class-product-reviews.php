<?php
/**
 * Single product reviews class.
 *
 * @package woodmart
 */

namespace XTS\Modules;

use XTS\Options;
use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Product_Reviews class.
 */
class Product_Reviews extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		$this->define_constants();

		add_action( 'init', array( $this, 'add_options' ) );
		add_action( 'init', array( $this, 'include_files' ), 15 ); // The priority must be higher than the priority of adding meta-boxes.

		add_action( 'wp', array( $this, 'do_after_setup_globals_options' ), 500 );
	}

	public function do_after_setup_globals_options() {
		add_filter( 'woodmart_localized_string_array', array( $this, 'add_localized_settings' ) );
	}

	/**
	 * Define constants.
	 *
	 * @since 1.0.0
	 */
	private function define_constants() {
		define( 'XTS_PRODUCT_REVIEWS_DIR', WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/product-reviews/' );
	}

	/**
	 * Add options
	 */
	public function add_options() {
		Options::add_section(
			array(
				'id'       => 'single_product_comments_section',
				'name'     => esc_html__( 'Reviews', 'woodmart' ),
				'parent'   => 'general_single_product_section',
				'priority' => 50,
				'icon'     => 'xts-i-bag',
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_location',
				'name'        => esc_html__( 'Reviews section location', 'woodmart' ),
				'description' => esc_html__( 'Option for the location of the reviews form and reviews list section.', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Layout', 'woodmart' ),
				'options'     => array(
					'tabs'     => array(
						'name'  => esc_html__( 'Tabs', 'woodmart' ),
						'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'reviews-location-tabs.jpg" alt="">', 'woodmart' ), true ),
						'value' => 'tabs',
					),
					'separate' => array(
						'name'  => esc_html__( 'Separate section', 'woodmart' ),
						'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'reviews-location-separate-section.jpg" alt="">', 'woodmart' ), true ),
						'value' => 'separate',
					),
				),
				'default'     => 'tabs',
				'priority'    => 10,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_section_columns',
				'name'        => esc_html__( 'Reviews section columns', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'reviews-section-columns.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Select the number of columns for the reviews section.', 'woodmart' ),
				'group'       => esc_html__( 'Layout', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'single_product_comments_section',
				'options'     => array(
					'one-column' => array(
						'name'  => '1',
					),
					'two-column' => array(
						'name'  => '2',
					),
				),
				'default'     => 'two-column',
				'priority'    => 20,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_columns',
				'name'        => esc_html__( 'Reviews columns on desktop', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'reviews-columns-on-desktop.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Select the number of columns for the product reviews inside reviews section.', 'woodmart' ),
				'group'       => esc_html__( 'Layout', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'single_product_comments_section',
				'options'     => array(
					1 => array(
						'name'  => '1',
					),
					2 => array(
						'name'  => '2',
					),
				),
				'default'     => 1,
				'priority'    => 30,
				't_tab'       => [
					'id'    => 'reviews_columns_tabs',
					'tab'   => esc_html__( 'Desktop', 'woodmart' ),
					'icon'  => 'xts-i-desktop',
					'style' => 'devices',
				],
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_columns_tablet',
				'name'        => esc_html__( 'Reviews columns on tablet', 'woodmart' ),
				'description' => esc_html__( 'Select the number of columns for the product reviews inside reviews section.', 'woodmart' ),
				'group'       => esc_html__( 'Layout', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'single_product_comments_section',
				'options'     => array(
					1 => array(
						'name'  => '1',
						'value' => 1,
					),
					2 => array(
						'name'  => '2',
						'value' => 2,
					),
				),
				'default'     => 1,
				'priority'    => 40,
				't_tab'       => array(
					'id'   => 'reviews_columns_tabs',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
					'icon' => 'xts-i-tablet',
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_columns_mobile',
				'name'        => esc_html__( 'Reviews columns on mobile', 'woodmart' ),
				'description' => esc_html__( 'Select the number of columns for the product reviews inside reviews section.', 'woodmart' ),
				'group'       => esc_html__( 'Layout', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'single_product_comments_section',
				'options'     => array(
					1 => array(
						'name'  => '1',
						'value' => 1,
					),
					2 => array(
						'name'  => '2',
						'value' => 2,
					),
				),
				'default'     => 1,
				'priority'    => 50,
				't_tab'       => array(
					'id'   => 'reviews_columns_tabs',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
					'icon' => 'xts-i-phone',
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_form_location',
				'name'        => esc_html__( 'Form location', 'woodmart' ),
				'description' => esc_html__( 'Option for the location of the reviews form inside reviews section.', 'woodmart' ),
				'group'       => esc_html__( 'Layout', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'single_product_comments_section',
				'options'     => array(
					'before' => array(
						'name'  => 'Before reviews',
						'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'reviews-form-location-before.jpg" alt="">', 'woodmart' ), true ),
						'value' => 'before',
					),
					'after' => array(
						'name'  => 'After reviews',
						'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'reviews-form-location-after.jpg" alt="">', 'woodmart' ), true ),
						'value' => 'after',
					),
				),
				'default'     => 'after',
				'priority'    => 60,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_style',
				'name'        => esc_html__( 'Style', 'woodmart' ),
				'hint'        => wp_kses( __( '<img data-src="' . WOODMART_TOOLTIP_URL . 'reviews_style.jpg" alt="">', 'woodmart' ), true ),
				'description' => esc_html__( 'Choose style of the product\'s review.', 'woodmart' ),
				'type'        => 'select',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Review', 'woodmart' ),
				'options'     => array(
					'style-1'   => array(
						'name'  => esc_html__( 'Style 1', 'woodmart' ),
						'value' => 'style-1',
					),
					'style-2' => array(
						'name'  => esc_html__( 'Style 2', 'woodmart' ),
						'value' => 'style-2',
					),
				),
				'default'     => 'style-1',
				'priority'    => 70,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_enable_pros_cons',
				'name'        => esc_html__( 'Pros and cons', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'reviews-enable-pros-cons.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Allow customers to add pros and cons of your products in the separate inputs.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Review', 'woodmart' ),
				'default'     => false,
				'priority'    => 80,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_enable_likes',
				'name'        => esc_html__( 'Likes', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'reviews-enable-likes.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Allow customers to vote for most helpful review.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Review', 'woodmart' ),
				'default'     => false,
				'priority'    => 90,
			)
		);

		Options::add_field(
			array(
				'id'          => 'show_reviews_purchased_indicator',
				'name'        => esc_html__( '“Verified owner” badge', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'show-reviews-purchased-indicator.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Mark reviews, made by customers who bought the current product, with a special icon.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Review', 'woodmart' ),
				'default'     => false,
				'priority'    => 100,
			)
		);

		Options::add_field(
			array(
				'id'           => 'reviews_sorting',
				'name'         => esc_html__( 'Sorting', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'reviews-sorting.mp4" autoplay loop muted></video>',
				'description'  => esc_html__( 'Allows users to sort reviews by rating, date, etc.', 'woodmart' ),
				'type'         => 'switcher',
				'section'      => 'single_product_comments_section',
				'group'        => esc_html__( 'Review', 'woodmart' ),
				'default'      => false,
				'priority'     => 110,
			)
		);

		Options::add_field(
			array(
				'id'          => 'single_product_comment_images',
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'tags'        => 'some tags for search',
				'name'        => esc_html__( 'Review images', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'review-images.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Allow customers to upload images to their reviews for products', 'woodmart' ),
				'group'       => esc_html__( 'Images', 'woodmart' ),
				'default'     => false,
				'priority'    => 120,
			)
		);

		Options::add_field(
			array(
				'id'          => 'single_product_comment_images_count',
				'type'        => 'range',
				'section'     => 'single_product_comments_section',
				'tags'        => 'some tags for search',
				'name'        => esc_html__( 'Images count in one review', 'woodmart' ),
				'description' => esc_html__( 'How many images customers can add to each review', 'woodmart' ),
				'group'       => esc_html__( 'Images', 'woodmart' ),
				'min'         => 1,
				'max'         => 20,
				'step'        => 1,
				'default'     => 3,
				'priority'    => 130,
				'unit'        => 'img',
			)
		);

		Options::add_field(
			array(
				'id'          => 'single_product_comment_images_upload_size',
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'number',
				),
				'section'     => 'single_product_comments_section',
				'tags'        => 'some tags for search',
				'name'        => esc_html__( 'Maximum upload file size', 'woodmart' ),
				'description' => esc_html__( 'Set the value in megabytes. Currently your server allows you to upload files up to 64 MB.', 'woodmart' ),
				'group'       => esc_html__( 'Images', 'woodmart' ),
				'default'     => '1',
				'priority'    => 140,
			)
		);

		Options::add_field(
			array(
				'id'          => 'single_product_comment_images_required',
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'tags'        => 'some tags for search',
				'name'        => esc_html__( 'Are images required?', 'woodmart' ),
				'description' => esc_html__( 'If checked, the user will not be able to post a comment without attaching an image.', 'woodmart' ),
				'group'       => esc_html__( 'Images', 'woodmart' ),
				'default'     => '0',
				'priority'    => 150,
			)
		);

		Options::add_field(
			array(
				'id'          => 'show_reviews_only_image_filter',
				'name'        => esc_html__( 'Filter reviews by images', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'show-reviews-only-image-filter.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Enable a filter that allows showing reviews only with images.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Images', 'woodmart' ),
				'default'     => false,
				'priority'    => 160,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary',
				'name'        => esc_html__( 'Rating summary', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'reviews-rating-summary.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Show section with review statistics before product reviews.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Rating summary', 'woodmart' ),
				'default'     => false,
				'priority'    => 170,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_content',
				'name'        => esc_html__( 'Rating summary content', 'woodmart' ),
				'description' => esc_html__( 'Select the information source that will be displayed inside the rating summary chart. If you use "Criteria", make sure that the corresponding option is enabled.', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Rating summary', 'woodmart' ),
				'options'     => array(
					'rating'     => array(
						'name'  => esc_html__( 'Rating', 'woodmart' ),
						'value' => 'rating',
					),
					'criteria' => array(
						'name'  => esc_html__( 'Criteria', 'woodmart' ),
						'value' => 'criteria',
					),
				),
				'default'     => 'rating',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_summary',
						'compare' => 'equals',
						'value'   => true,
					),
				),
				'priority'    => 180,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_filter',
				'name'        => esc_html__( 'Rating summary filter', 'woodmart' ),
				'description' => esc_html__( 'Allows users to filter reviews by clicking on the corresponding rating bar.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Rating summary', 'woodmart' ),
				'default'     => false,
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_summary_content',
						'compare' => 'equals',
						'value'   => 'rating',
					),
					array(
						'key'     => 'reviews_rating_summary',
						'compare' => 'equals',
						'value'   => true,
					),
				),
				'priority'    => 190,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_by_criteria',
				'name'        => esc_html__( 'Rating by criteria', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'reviews-rating-by-criteria.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Enable the ability for customers to review the product according to several criteria. For example: "Value for money", "Durability", "Delivery speed", etc.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				'default'     => false,
				'priority'    => 200,
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_criteria_rating_required',
				'name'        => esc_html__( 'Is criteria required?', 'woodmart' ),
				'description' => esc_html__( 'If checked, the user will not be able to post a review without selecting a criterion.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				'default'     => false,
				'priority'    => 205,
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_1_slug',
				'name'        => esc_html__( 'Criteria slug', 'woodmart' ),
				'type'        => 'text_input',
				'sanitize'    => 'slug',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [1]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 210,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_1',
				'name'        => esc_html__( 'Criteria title', 'woodmart' ),
				'type'        => 'text_input',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [1]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 220,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_2_slug',
				'name'        => esc_html__( 'Criteria slug', 'woodmart' ),
				'type'        => 'text_input',
				'sanitize'    => 'slug',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [2]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 230,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_2',
				'name'        => esc_html__( 'Criteria title', 'woodmart' ),
				'type'        => 'text_input',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [2]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 240,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_3_slug',
				'name'        => esc_html__( 'Criteria slug', 'woodmart' ),
				'type'        => 'text_input',
				'sanitize'    => 'slug',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [3]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 250,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_3',
				'name'        => esc_html__( 'Criteria title', 'woodmart' ),
				'type'        => 'text_input',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [3]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 260,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_4_slug',
				'name'        => esc_html__( 'Criteria slug', 'woodmart' ),
				'type'        => 'text_input',
				'sanitize'    => 'slug',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [4]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 270,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_4',
				'name'        => esc_html__( 'Criteria title', 'woodmart' ),
				'type'        => 'text_input',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [4]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 270,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_5_slug',
				'name'        => esc_html__( 'Criteria slug', 'woodmart' ),
				'type'        => 'text_input',
				'sanitize'    => 'slug',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [5]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 280,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_5',
				'name'        => esc_html__( 'Criteria title', 'woodmart' ),
				'type'        => 'text_input',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [5]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'style' => 'default',
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
				],
				'priority'    => 290,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_6_slug',
				'name'        => esc_html__( 'Criteria slug', 'woodmart' ),
				'type'        => 'text_input',
				'sanitize'    => 'slug',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [6]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
					'style' => 'default',
				],
				'priority'    => 300,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'reviews_rating_summary_criteria_6',
				'name'        => esc_html__( 'Criteria title', 'woodmart' ),
				'type'        => 'text_input',
				'default'     => '',
				'section'     => 'single_product_comments_section',
				'group'       => esc_html__( 'Criteria', 'woodmart' ),
				't_tab'       => [
					'id'    => 'reviews_rating_summary_criteria_tabs',
					'tab'   => esc_html__( 'Criteria [6]', 'woodmart' ),
					'title' => esc_html__( 'Criteria fields', 'woodmart' ),
					'requires'    => array(
						array(
							'key'     => 'reviews_rating_by_criteria',
							'compare' => 'equals',
							'value'   => true,
						),
					),
					'style' => 'default',
				],
				'priority'    => 310,
				'class'       => 'xts-tab-field xts-col-6',
				'requires'    => array(
					array(
						'key'     => 'reviews_rating_by_criteria',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);
	}

	/**
	 * Include main files.
	 */
	public function include_files() {
		$files = array(
			'class-helper',
			'class-reviews',
			'class-rating-criteria',
			'class-likes',
			'class-wc-comment-images',
			'class-purchased-indicator',
			'class-rating-summary',
			'class-reviews-sorting',
			'class-pros-cons',
		);

		foreach ( $files as $file ) {
			$file_path = XTS_PRODUCT_REVIEWS_DIR . $file . '.php';

			if ( file_exists( $file_path ) ) {
				require_once $file_path;
			}
		}
	}

	/**
	 * Add localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function add_localized_settings( $settings ) {
		$settings['reviews_criteria_rating_required'] = woodmart_get_opt( 'reviews_criteria_rating_required' ) ? 'yes' : 'no';
		$settings['is_rating_summary_filter_enabled'] = ( woodmart_get_opt( 'reviews_rating_by_criteria' ) && 'rating' === woodmart_get_opt( 'reviews_rating_summary_content', 'rating' ) && woodmart_get_opt( 'reviews_rating_summary_filter' ) ) || ( ! woodmart_get_opt( 'reviews_rating_by_criteria' ) && woodmart_get_opt( 'reviews_rating_summary_filter' ) );

		return $settings;
	}
}

Product_Reviews::get_instance();
