<?php
/**
 * Contact form 7 timer map
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
class Contact_Form_7 extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_contact_form_7';
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
		return esc_html__( 'Contact form 7', 'woodmart' );
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
		return 'wd-icon-contact-form-7';
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
	 * Get contact forms.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Contact forms.
	 */
	public function get_contact_forms() {
		$forms = get_posts(
			[
				'post_type'   => 'wpcf7_contact_form',
				'numberposts' => -1,
			]
		);

		$contact_forms = [];

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$contact_forms[ $form->ID ] = $form->post_title;
			}
		}

		return $contact_forms;
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Content tab
		 */
		$this->start_controls_section(
			'general_content_section',
			[
				'label' => esc_html__( 'General', 'woodmart' ),
			]
		);

		$this->add_control(
			'form_id',
			[
				'label'       => esc_html__( 'Select contact form', 'woodmart' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => $this->get_contact_forms(),
				'default'     => '0',
			]
		);

		$this->end_controls_section();

		/**
		 * Style tab
		 */

		$this->start_controls_section(
			'color_style_section',
			[
				'label' => esc_html__( 'Form', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Color presets', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''                 => esc_html__( 'Default', 'woodmart' ),
					'wd-style-with-bg' => esc_html__( 'With background', 'woodmart' ),
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
					'{{WRAPPER}} .wpcf7-form' => '--wd-form-color: {{VALUE}};',
				),
				'condition' => array(
					'style!' => 'wd-style-with-bg',
				),
			)
		);

		$this->add_control(
			'form_placeholder_color',
			array(
				'label'     => esc_html__( 'Placeholder color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wpcf7-form' => '--wd-form-placeholder-color: {{VALUE}};',
				),
				'condition' => array(
					'style!' => 'wd-style-with-bg',
				),
			)
		);

		$this->add_control(
			'form_brd_color',
			array(
				'label'     => esc_html__( 'Border color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wpcf7-form' => '--wd-form-brd-color: {{VALUE}};',
				),
				'condition' => array(
					'style!' => 'wd-style-with-bg',
				),
			)
		);

		$this->add_control(
			'form_brd_color_focus',
			array(
				'label'     => esc_html__( 'Border color focus', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wpcf7-form' => '--wd-form-brd-color-focus: {{VALUE}};',
				),
				'condition' => array(
					'style!' => 'wd-style-with-bg',
				),
			)
		);

		$this->add_control(
			'form_bg',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wpcf7-form' => '--wd-form-bg: {{VALUE}};',
				),
				'condition' => array(
					'style!' => 'wd-style-with-bg',
				),
			)
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
			'form_id' => '0',
			'style'   => '',
		];

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		if ( ! $settings['form_id'] || ! defined( 'WPCF7_PLUGIN' ) ) {
			echo '<div class="wd-notice wd-info">' . esc_html__( 'You need to create a form using Contact form 7 plugin to be able to display it using this element.', 'woodmart' ) . '</div>';
			return;
		}

		echo do_shortcode( '[contact-form-7 html_class="' . esc_attr( $settings['style'] ) . '" id="' . esc_attr( $settings['form_id'] ) . '"]' );
	}
}

Plugin::instance()->widgets_manager->register( new Contact_Form_7() );
