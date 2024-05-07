<?php
/**
 * Products map.
 *
 * @package xts
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Products extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_products';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Products (grid or carousel)', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-products';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'wd-elements' ];
	}

	/**
	 * Get attribute taxonomies
	 *
	 * @since 1.0.0
	 */
	public function get_product_attributes_array() {
		$attributes = [];

		if ( woodmart_woocommerce_installed() ) {
			foreach ( wc_get_attribute_taxonomies() as $attribute ) {
				$attributes[] = 'pa_' . $attribute->attribute_name;
			}
		}

		return $attributes;
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Content tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_content_section',
			[
				'label' => esc_html__( 'General', 'woodmart' ),
			]
		);

		$this->add_control(
			'element_title',
			[
				'label' => esc_html__( 'Element title', 'woodmart' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'       => esc_html__( 'Data source', 'woodmart' ),
				'description' => esc_html__( 'Select content type for your grid.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'product',
				'options'     => $this->get_options_depend_builder(
					array(
						'product'            => esc_html__( 'All Products', 'woodmart' ),
						'featured'           => esc_html__( 'Featured Products', 'woodmart' ),
						'sale'               => esc_html__( 'Sale Products', 'woodmart' ),
						'new'                => esc_html__( 'Products with NEW label', 'woodmart' ),
						'bestselling'        => esc_html__( 'Bestsellers', 'woodmart' ),
						'ids'                => esc_html__( 'List of IDs', 'woodmart' ),
						'top_rated_products' => esc_html__( 'Top Rated Products', 'woodmart' ),
						'recently_viewed'    => esc_html__( 'Recently Viewed Products', 'woodmart' ),
					),
					array(
						'single_product' => array(
							'related' => esc_html__( 'Related (Single product)', 'woodmart' ),
							'upsells' => esc_html__( 'Upsells (Single product)', 'woodmart' ),
						),
						'cart'           => array(
							'cross-sells' => esc_html__( 'Cross Sells', 'woodmart' ),
						),
					)
				),
			]
		);

		$this->add_control(
			'ajax_recently_viewed',
			[
				'label'        => esc_html__( 'Update with AJAX on page load', 'woodmart' ),
				'description'  => esc_html__( 'Enable this option if you use full-page cache like WP Rocket.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
				'condition'    => [
					'post_type' => 'recently_viewed',
				],
			]
		);

		$this->add_control(
			'include',
			[
				'label'       => esc_html__( 'Include only', 'woodmart' ),
				'description' => esc_html__( 'Add products by title.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_posts_by_query',
				'render'      => 'woodmart_get_posts_title_by_id',
				'post_type'   => 'product',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type' => 'ids',
				],
			]
		);

		$this->add_control(
			'taxonomies',
			[
				'label'       => esc_html__( 'Categories or tags', 'woodmart' ),
				'description' => esc_html__( 'List of product categories.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_taxonomies_by_query',
				'render'      => 'woodmart_get_taxonomies_title_by_id',
				'taxonomy'    => array_merge( [ 'product_cat', 'product_tag' ], $this->get_product_attributes_array() ),
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type!' => 'ids',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__( 'Order by', 'woodmart' ),
				'description' => esc_html__( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''               => '',
					'date'           => esc_html__( 'Date', 'woodmart' ),
					'id'             => esc_html__( 'ID', 'woodmart' ),
					'author'         => esc_html__( 'Author', 'woodmart' ),
					'title'          => esc_html__( 'Title', 'woodmart' ),
					'modified'       => esc_html__( 'Last modified date', 'woodmart' ),
					'comment_count'  => esc_html__( 'Number of comments', 'woodmart' ),
					'menu_order'     => esc_html__( 'Menu order', 'woodmart' ),
					'meta_value'     => esc_html__( 'Meta value', 'woodmart' ),
					'meta_value_num' => esc_html__( 'Meta value number', 'woodmart' ),
					'rand'           => esc_html__( 'Random order', 'woodmart' ),
					'price'          => esc_html__( 'Price', 'woodmart' ),
				),
				'condition'   => array(
					'post_type!' => 'recently_viewed',
				),
			]
		);

		$this->add_control(
			'offset',
			[
				'label'       => esc_html__( 'Offset', 'woodmart' ),
				'description' => esc_html__( 'Number of grid elements to displace or pass over.', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'post_type!' => array( 'ids', 'recently_viewed' ),
				],
			]
		);

		$this->add_control(
			'query_type',
			[
				'label'     => esc_html__( 'Query type', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'OR',
				'options'   => array(
					'OR'  => esc_html__( 'OR', 'woodmart' ),
					'AND' => esc_html__( 'AND', 'woodmart' ),
				),
				'condition' => array(
					'post_type!' => 'recently_viewed',
				),
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__( 'Sort order', 'woodmart' ),
				'description' => 'Designates the ascending or descending order. More at <a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>.',
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''     => esc_html__( 'Inherit', 'woodmart' ),
					'DESC' => esc_html__( 'Descending', 'woodmart' ),
					'ASC'  => esc_html__( 'Ascending', 'woodmart' ),
				),
				'condition'   => [
					'post_type!' => 'ids', 'recently_viewed',
				],
			]
		);

		$this->add_control(
			'hide_out_of_stock',
			[
				'label'        => esc_html__( 'Hide out of stock products', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label'       => esc_html__( 'Meta key', 'woodmart' ),
				'description' => esc_html__( 'Input meta key for grid ordering.', 'woodmart' ),
				'type'        => Controls_Manager::TEXTAREA,
				'condition'   => [
					'orderby' => [ 'meta_value', 'meta_value_num' ],
				],
			]
		);

		$this->add_control(
			'exclude',
			[
				'label'       => esc_html__( 'Exclude', 'woodmart' ),
				'description' => esc_html__( 'Exclude posts, pages, etc. by title.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_posts_by_query',
				'render'      => 'woodmart_get_posts_title_by_id',
				'post_type'   => 'product',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type!' => 'ids',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * Layout settings.
		 */
		$this->start_controls_section(
			'layout_style_section',
			[
				'label' => esc_html__( 'Layout', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Grid or carousel', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__( 'Grid', 'woodmart' ),
					'list'     => esc_html__( 'List', 'woodmart' ),
					'carousel' => esc_html__( 'Carousel', 'woodmart' ),
				),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns', 'woodmart' ),
				'description' => esc_html__( 'Number of columns in the grid.', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 4,
				],
				'size_units'  => '',
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					],
				],
				'condition'   => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'products_masonry',
			[
				'label'       => esc_html__( 'Masonry grid', 'woodmart' ),
				'description' => esc_html__( 'Products may have different sizes.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Inherit', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'condition'   => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'products_different_sizes',
			[
				'label'       => esc_html__( 'Products grid with different sizes', 'woodmart' ),
				'description' => esc_html__( 'In this situation, some of the products will be twice bigger in width than others. Recommended to use with 6 columns grid only.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__( 'Inherit', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'condition'   => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'spacing',
			[
				'label'     => esc_html__( 'Space between', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'' => esc_html__( 'Inherit', 'woodmart' ),
					0  => esc_html__( '0 px', 'woodmart' ),
					2  => esc_html__( '2 px', 'woodmart' ),
					6  => esc_html__( '6 px', 'woodmart' ),
					10 => esc_html__( '10 px', 'woodmart' ),
					20 => esc_html__( '20 px', 'woodmart' ),
					30 => esc_html__( '30 px', 'woodmart' ),
				],
				'default'   => '',
				'condition' => [
					'layout'                => [ 'grid', 'carousel' ],
					'highlighted_products!' => [ '1' ],
				],
			]
		);

		$this->add_control(
			'items_per_page',
			[
				'label'       => esc_html__( 'Items per page', 'woodmart' ),
				'description' => esc_html__( 'Number of items to show per page.', 'woodmart' ),
				'default'     => 12,
				'type'        => Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'     => esc_html__( 'Pagination', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''         => esc_html__( 'Inherit', 'woodmart' ),
					'more-btn' => esc_html__( 'Load more button', 'woodmart' ),
					'infinit'  => esc_html__( 'Infinit scrolling', 'woodmart' ),
					'arrows'   => esc_html__( 'Arrows', 'woodmart' ),
					'links'    => esc_html__( 'Links', 'woodmart' ),
				),
				'condition' => [
					'layout!' => 'carousel',
				],
			]
		);

		$this->add_control(
			'shop_tools',
			[
				'label'        => esc_html__( 'Shop tools', 'woodmart' ),
				'description'  => esc_html__( 'Per page, Sorting, Columns', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => [
					'pagination' => 'links',
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Carousel settings.
		 */
		$this->start_controls_section(
			'carousel_style_section',
			[
				'label'     => esc_html__( 'Carousel', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'carousel',
				],
			]
		);

		$this->add_responsive_control(
			'slides_per_view',
			[
				'label'       => esc_html__( 'Slides per view', 'woodmart' ),
				'description' => esc_html__( 'Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 3,
				],
				'size_units'  => '',
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 8,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'scroll_per_page',
			[
				'label'        => esc_html__( 'Scroll per page', 'woodmart' ),
				'description'  => esc_html__( 'Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_pagination_control',
			[
				'label'        => esc_html__( 'Hide pagination control', 'woodmart' ),
				'description'  => esc_html__( 'If "YES" pagination control will be removed.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_prev_next_buttons',
			[
				'label'        => esc_html__( 'Hide prev/next buttons', 'woodmart' ),
				'description'  => esc_html__( 'If "YES" prev/next control will be removed', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'center_mode',
			[
				'label'        => esc_html__( 'Center mode', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wrap',
			[
				'label'        => esc_html__( 'Slider loop', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Slider autoplay', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => esc_html__( 'Slider speed', 'woodmart' ),
				'description' => esc_html__( 'Duration of animation between slides (in ms)', 'woodmart' ),
				'default'     => '5000',
				'type'        => Controls_Manager::NUMBER,
				'condition'   => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'scroll_carousel_init',
			[
				'label'        => esc_html__( 'Init carousel on scroll', 'woodmart' ),
				'description'  => esc_html__( 'This option allows you to init carousel script only when visitor scroll the page to the slider. Useful for performance optimization.\'', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Products design settings.
		 */
		$this->start_controls_section(
			'products_design_style_section',
			[
				'label' => esc_html__( 'Products design', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_hover',
			[
				'label'     => esc_html__( 'Products hover', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'inherit',
				'options'   => array(
					'inherit'   => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'info-alt'  => esc_html__( 'Full info on hover', 'woodmart' ),
					'info'      => esc_html__( 'Full info on image', 'woodmart' ),
					'alt'       => esc_html__( 'Icons and "add to cart" on hover', 'woodmart' ),
					'icons'     => esc_html__( 'Icons on hover', 'woodmart' ),
					'quick'     => esc_html__( 'Quick', 'woodmart' ),
					'button'    => esc_html__( 'Show button on hover on image', 'woodmart' ),
					'base'      => esc_html__( 'Show summary on hover', 'woodmart' ),
					'standard'  => esc_html__( 'Standard button', 'woodmart' ),
					'tiled'     => esc_html__( 'Tiled', 'woodmart' ),
					'fw-button' => esc_html__( 'Full width button', 'woodmart' ),
					'small'     => esc_html__( 'Small', 'woodmart' ),
				),
				'condition' => [
					'layout!' => 'list',
				],
			]
		);

		$this->add_control(
			'img_size',
			[
				'label'   => esc_html__( 'Image size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => woodmart_get_all_image_sizes_names( 'elementor' ),
			]
		);

		$this->add_control(
			'img_size_custom',
			[
				'label'       => esc_html__( 'Image dimension', 'woodmart' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'woodmart' ),
				'condition'   => [
					'img_size' => 'custom',
				],
			]
		);

		$this->add_control(
			'rounding_size',
			array(
				'label'     => esc_html__( 'Rounding', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'Inherit', 'woodmart' ),
					'0'      => esc_html__( '0', 'woodmart' ),
					'5'      => esc_html__( '5', 'woodmart' ),
					'8'      => esc_html__( '8', 'woodmart' ),
					'12'     => esc_html__( '12', 'woodmart' ),
					'custom' => esc_html__( 'Custom', 'woodmart' ),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => '--wd-brd-radius: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'custom_rounding_size',
			array(
				'label'      => esc_html__( 'Rounding', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--wd-brd-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'rounding_size' => array( 'custom' ),
				),
			)
		);

		$this->add_control(
			'sale_countdown',
			[
				'label'        => esc_html__( 'Sale countdown', 'woodmart' ),
				'description'  => esc_html__( 'Countdown to the end sale date will be shown. Be sure you have set final date of the product sale price.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'product_hover!' => 'small',
				),
			]
		);

		$this->add_responsive_control(
			'stretch_product',
			[
				'label'        => esc_html__( 'Even product grid', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'product_hover' => array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button' ),
				),
			]
		);

		$this->add_control(
			'stock_progress_bar',
			[
				'label'        => esc_html__( 'Stock progress bar', 'woodmart' ),
				'description'  => esc_html__( 'Display a number of sold and in stock products as a progress bar.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'product_hover!' => 'small',
				),
			]
		);

		$this->add_control(
			'highlighted_products',
			[
				'label'        => esc_html__( 'Highlighted products', 'woodmart' ),
				'description'  => esc_html__( 'Create an eye-catching section of special products to promote them on your store.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'product_hover!' => 'small',
				),
			]
		);

		$this->add_control(
			'products_color_scheme',
			array(
				'label'        => esc_html__( 'Products color scheme', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'default',
				'options'      => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'products_bordered_grid',
			[
				'label'        => esc_html__( 'Bordered grid', 'woodmart' ),
				'description'  => esc_html__( 'Add borders between the products in your grid.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => [
					'highlighted_products!' => [ '1' ],
				],
			]
		);

		$this->add_control(
			'products_bordered_grid_style',
			array(
				'label'       => esc_html__( 'Bordered grid style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'outside' => esc_html__( 'Outside', 'woodmart' ),
					'inside'  => esc_html__( 'inside', 'woodmart' ),
				),
				'condition' => array(
					'products_bordered_grid' => array( '1' ),
					'highlighted_products!' => array( '1' ),
				),
				'default' => 'outside',
			)
		);

		$this->add_control(
			'products_with_background',
			array(
				'label'        => esc_html__( 'Products background', 'woodmart' ),
				'description'  => esc_html__( 'Add a background to the products in your grid.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			)
		);

		$this->add_control(
			'products_background',
			array(
				'label'     => esc_html__( 'Custom background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-products-with-bg, {{WRAPPER}} .wd-products-with-bg .product-grid-item' => '--wd-prod-bg:{{VALUE}}; --wd-bordered-bg:{{VALUE}};',
				),
				'condition' => array(
					'products_with_background' => array( '1' ),
				),
			)
		);

		$this->add_control(
			'products_shadow',
			array(
				'label'        => esc_html__( 'Products shadow', 'woodmart' ),
				'description'  => esc_html__( 'Add a shadow to products if the initial product style did not have one.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			)
		);

		$this->add_control(
			'product_quantity',
			[
				'label'     => esc_html__( 'Quantity input on product', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''        => esc_html__( 'Inherit', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
			]
		);

		$this->add_control(
			'grid_gallery',
			array(
				'label'       => esc_html__( 'Product gallery', 'woodmart' ),
				'description' => esc_html__( 'Add the ability to view the product gallery on the products loop.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''    => esc_html__( 'Inherit', 'woodmart' ),
					'yes' => esc_html__( 'Yes', 'woodmart' ),
					'no'  => esc_html__( 'No', 'woodmart' ),
				),
			)
		);

		$this->start_controls_tabs(
			'grid_gallery_tabs',
			array(
				'condition' => array(
					'grid_gallery' => array( 'yes' ),
				),
			)
		);

		$this->start_controls_tab(
			'grid_gallery_desktop_tab',
			array(
				'label' => esc_html__( 'Desktop', 'woodmart' ),
			)
		);

		$this->add_control(
			'grid_gallery_control',
			array(
				'label'   => esc_html__( 'Product gallery controls', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''       => esc_html__( 'Inherit', 'woodmart' ),
					'arrows' => esc_html__( 'Arrows', 'woodmart' ),
					'hover'  => esc_html__( 'Hover', 'woodmart' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'grid_gallery_mobile_tab',
			[
				'label' => esc_html__( 'Mobile devices', 'woodmart' ),
			]
		);

		$this->add_control(
			'grid_gallery_enable_arrows',
			array(
				'label'   => esc_html__( 'Product gallery controls', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''       => esc_html__( 'Inherit', 'woodmart' ),
					'none'   => esc_html__( 'None', 'woodmart' ),
					'arrows' => esc_html__( 'Arrows', 'woodmart' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Title settings.
		 */
		$this->start_controls_section(
			'title_style_section',
			array(
				'label' => esc_html__( 'Title', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .element-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .element-title',
			)
		);

		$this->end_controls_section();

		/**
		 * Extra settings.
		 */
		$this->start_controls_section(
			'extra_style_section',
			[
				'label' => esc_html__( 'Extra', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lazy_loading',
			[
				'label'        => esc_html__( 'Lazy loading for images', 'woodmart' ),
				'description'  => esc_html__( 'Enable lazy loading for images for this element.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		Main::setup_preview();
		woodmart_elementor_products_template( $this->get_settings_for_display() );
		Main::restore_preview();
	}

	/**
	 * This method checks on which layout this element is displayed, and depending on these displays the necessary additional options.
	 *
	 * @param array $default_array An array of options that should be independent of the builder.
	 * @param array $additional_array Options that should appear only on the specific layout.
	 * This array must have a key equal to the name of the builder layout on which you want to see additional options.
	 * Example: array( 'single_product' => array( 'related' => esc_html__( 'Related (Single product)', 'woodmart' ) ) );.
	 * @return array
	 */
	private function get_options_depend_builder( $default_array, $additional_array ) {
		$result_array = $default_array;

		foreach ( $additional_array as $needed_builder => $additional_options ) {
			if ( Main::is_layout_type( $needed_builder ) ) {
				$result_array = array_merge( $result_array, $additional_options );
			}
		}

		return $result_array;
	}
}

Plugin::instance()->widgets_manager->register( new Products() );
