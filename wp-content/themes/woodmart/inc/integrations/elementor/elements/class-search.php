<?php
/**
 * Search map.
 */

namespace XTS\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Search extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'wd_search';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return esc_html__( 'AJAX Search', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_icon() {
		return 'wd-icon-search';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 * @access public
	 */
	public function get_categories() {
		return [ 'wd-elements' ];
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
			'number',
			[
				'label'   => esc_html__( 'Number results to show', 'woodmart' ),
				'default' => 12,
				'type'    => Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'search_post_type',
			[
				'label'   => esc_html__( 'Search post type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'product'   => esc_html__( 'Product', 'woodmart' ),
					'post'      => esc_html__( 'Post', 'woodmart' ),
					'portfolio' => esc_html__( 'Portfolio', 'woodmart' ),
				],
				'default' => 'product',
			]
		);

		$this->add_control(
			'price',
			[
				'label'        => esc_html__( 'Show price', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			]
		);

		$this->add_control(
			'thumbnail',
			[
				'label'        => esc_html__( 'Show thumbnail', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			]
		);

		$this->add_control(
			'category',
			[
				'label'        => esc_html__( 'Show category', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
			]
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		$this->start_controls_section(
			'color_style_section',
			[
				'label' => esc_html__( 'Form', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'form_style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'default'   => array(
						'title' => esc_html__( 'Default', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/header-builder/search/default.jpg',
						'style' => 'col-2',
					),
					'with-bg'   => array(
						'title' => esc_html__( 'With background', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/header-builder/search/with-bg.jpg',
						'style' => 'col-2',
					),
					'with-bg-2' => array(
						'title' => esc_html__( 'With background 2', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/header-builder/search/with-bg-2.jpg',
						'style' => 'col-2',
					),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'woodmart_color_scheme',
			[
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'form_color',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .searchform' => '--wd-form-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_placeholder_color',
			array(
				'label'     => esc_html__( 'Placeholder color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .searchform' => '--wd-form-placeholder-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_brd_color',
			array(
				'label'     => esc_html__( 'Border color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .searchform' => '--wd-form-brd-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_brd_color_focus',
			array(
				'label'     => esc_html__( 'Border color focus', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .searchform' => '--wd-form-brd-color-focus: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_bg',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .searchform' => '--wd-form-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_shape',
			array(
				'label'     => esc_html__( 'Form shape', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'' => array(
						'title'  => esc_html__( 'Inherit', 'woodmart' ),
					),
					'0'  => array(
						'title' => esc_html__( 'Square', 'woodmart' ),
					),
					'5'  => array(
						'title'  => esc_html__( 'Rounded', 'woodmart' ),
					),
					'35'  => array(
						'title'  => esc_html__( 'Round', 'woodmart' ),
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--wd-form-brd-radius: {{VALUE}}px;',
				),
				'default' => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'category_style_section',
			[
				'label'     => esc_html__( 'Category', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'category' => '1',
				],
			]
		);

		$this->add_control(
			'cat_selector_style',
			[
				'label'   => esc_html__( 'Categories selector style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default'   => esc_html__( 'Default', 'woodmart' ),
					'bordered'  => esc_html__( 'Bordered', 'woodmart' ),
					'separated' => esc_html__( 'Separated', 'woodmart' ),
				],
				'default' => 'bordered',
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
		$default_settings = [
			'number'                => 3,
			'price'                 => 1,
			'thumbnail'             => 1,
			'category'              => 1,
			'search_post_type'      => 'product',
			'woodmart_color_scheme' => 'dark',
			'form_style'            => 'default',
			'cat_selector_style'    => 'bordered',
		];

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class' => [
						'wd-el-search',
						'woodmart-ajax-search',
						woodmart_get_old_classes( 'woodmart-vc-ajax-search' ),
						'wd-color-' . $settings['woodmart_color_scheme'],
					],
				],
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
			woodmart_search_form(
				array(
					'ajax'               => true,
					'post_type'          => $settings['search_post_type'],
					'count'              => $settings['number'],
					'thumbnail'          => $settings['thumbnail'],
					'price'              => $settings['price'],
					'show_categories'    => $settings['category'],
					'search_style'       => $settings['form_style'],
					'cat_selector_style' => $settings['cat_selector_style'],
				)
			);
			?>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Search() );
