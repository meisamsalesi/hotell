<?php
/**
 * Meta map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}
/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Meta extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_single_product_meta';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Product meta', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sp-meta';
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
		 * Content tab.
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
				'default'      => 'wd-single-meta',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'show_sku',
			array(
				'label'        => esc_html__( 'Show SKU', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_categories',
			array(
				'label'        => esc_html__( 'Show categories', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_tags',
			array(
				'label'        => esc_html__( 'Show tags', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'       => esc_html__( 'Layout', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'inline'  => esc_html__( 'Inline', 'woodmart' ),
					'justify' => esc_html__( 'Justify', 'woodmart' ),
				),
				'render_type' => 'template',
				'default'     => 'default',
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'woodmart' ),
				'type'         => 'wd_buttons',
				'options'      => array(
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
				'prefix_class' => 'text-',
				'default'      => 'left',
				'condition'    => array(
					'layout!' => array( 'justify' ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Label settings.
		 */
		$this->start_controls_section(
			'label_style_section',
			array(
				'label' => esc_html__( 'Label', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .meta-label',
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Label color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .meta-label' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings             = wp_parse_args(
			$this->get_settings_for_display(),
			array(
				'layout'          => 'default',
				'show_sku'        => 'yes',
				'show_categories' => 'yes',
				'show_tags'       => 'yes',
			)
		);
		$product_meta_classes = ' wd-layout-' . $settings['layout'];

		Main::setup_preview();

		wc_get_template(
			'single-product/meta.php',
			array(
				'builder_meta_classes' => $product_meta_classes,
				'show_sku'             => $settings['show_sku'],
				'show_categories'      => $settings['show_categories'],
				'show_tags'            => $settings['show_tags'],
			)
		);

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register( new Meta() );
