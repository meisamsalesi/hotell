<?php
/**
 * Stock status map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Stock_Status extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_stock_status';
	}

	/**
	 * Get widget content.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product stock status', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-stock-status';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-single-product-elements' );
	}

	/**
	 * Show in panel.
	 *
	 * @return bool Whether to show the widget in the panel or not.
	 */
	public function show_in_panel() {
		return Main::is_layout_type( 'single_product' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'stock_status_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-single-stock-status',
				'prefix_class' => '',
			)
		);

		$this->add_responsive_control(
			'inner_margin',
			array(
				'label'              => esc_html__( 'Inner margin', 'elementor' ),
				'description'        => esc_html__( 'Useful for variable products where the "Stock status" label appears after selecting a variation.', 'woodmart' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => array( 'px', 'em', '%', 'rem', 'custom' ),
				'selectors'          => array(
					'{{WRAPPER}} p.stock' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				)
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		Main::setup_preview();
			global $product;

			woodmart_enqueue_js_script( 'stock-status' );

			echo ' '; // So that the wrapper of the element is always displayed, regardless of the type of this project.

			if ( ! $product->is_type( 'variable' ) ) {
				echo wc_get_stock_html( $product );
			}
		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register( new Stock_Status() );
