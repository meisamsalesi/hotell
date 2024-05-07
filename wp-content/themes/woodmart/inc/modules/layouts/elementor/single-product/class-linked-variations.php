<?php

namespace XTS\Modules\Layouts;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use XTS\Modules\Layouts\Global_Data as Builder;
use XTS\Modules\Linked_Variations\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Linked_Variations extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_linked_variations';
	}

	/**
	 * Get widget content.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Linked variations', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-linked-variations';
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

		/**
		 * Content tab
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-single-linked-variations',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'default' => 'left',
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'inline'  => esc_html__( 'Inline', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_responsive_control(
			'label_position',
			array(
				'label'          => esc_html__( 'Label position', 'woodmart' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => array(
					'side' => esc_html__( 'Side', 'woodmart' ),
					'top'  => esc_html__( 'Top', 'woodmart' ),
					'hide' => esc_html__( 'Hide', 'woodmart' ),
				),
				'devices'        => array( 'desktop', 'mobile' ),
				'default'        => 'side',
				'mobile_default' => 'side',
				'render_type'    => 'template',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$default_settings = array(
			'alignment'             => 'left',
			'layout'                => 'default',
			'label_position'        => 'side',
			'label_position_mobile' => 'side',
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		$wrapper_classes  = ' text-' . $settings['alignment'];
		$wrapper_classes .= ' wd-swatch-layout-' . $settings['layout'];
		$wrapper_classes .= ' wd-label-' . $settings['label_position'] . '-lg';
		$wrapper_classes .= ' wd-label-' . $settings['label_position_mobile'] . '-md';

		Main::setup_preview();

		Frontend::get_instance()->output( $wrapper_classes );

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register( new Linked_Variations() );
