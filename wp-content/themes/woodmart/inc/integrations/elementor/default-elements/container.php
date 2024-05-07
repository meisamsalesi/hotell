<?php
/**
 * Elementor container custom controls
 *
 * @package xts
 */

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_add_container_full_width_control' ) ) {
	/**
	 * Container full width option.
	 *
	 * @since 1.0.0
	 *
	 * @param object $element The control.
	 */
	function woodmart_add_container_full_width_control( $element ) {
		$element->start_controls_section(
			'wd_extra_layout',
			array(
				'label' => esc_html__( '[XTemos] Layout', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);

		$element->add_control(
			'wd_section_stretch',
			array(
				'label'        => esc_html__( 'Container stretch', 'woodmart' ),
				'description'  => esc_html__( 'Enable this option to stretch container with CSS.', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'disabled',
				'options'      => array(
					'disabled'        => esc_html__( 'Disabled', 'woodmart' ),
					'stretch'         => esc_html__( 'Stretch container', 'woodmart' ),
					'stretch-content' => esc_html__( 'Stretch container and content', 'woodmart' ),
				),
				'render_type'  => 'template',
				'prefix_class' => 'wd-section-',
			)
		);

		$element->end_controls_section();
	}

	add_action( 'elementor/element/container/section_layout_container/after_section_end', 'woodmart_add_container_full_width_control' );
}

if ( ! function_exists( 'woodmart_add_container_color_scheme_control' ) ) {
	/**
	 * Container custom controls.
	 *
	 * @since 1.0.0
	 *
	 * @param object $element The control.
	 */
	function woodmart_add_container_color_scheme_control( $element ) {
		$element->start_controls_section(
			'wd_extra_style',
			array(
				'label' => esc_html__( '[XTemos] Extra', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		/**
		 * Color scheme.
		 */
		$element->add_control(
			'wd_color_scheme',
			array(
				'label'        => esc_html__( 'Color Scheme', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				),
				'default'      => '',
				'render_type'  => 'template',
				'prefix_class' => 'color-scheme-',
			)
		);

		$element->end_controls_section();
	}

	add_action( 'elementor/element/container/section_background_overlay/after_section_end', 'woodmart_add_container_color_scheme_control' );
}

if ( ! function_exists( 'woodmart_add_container_custom_controls' ) ) {
	/**
	 * Container section controls.
	 *
	 * @since 1.0.0
	 *
	 * @param Controls_Stack $element The control.
	 */
	function woodmart_add_container_custom_controls( $element ) {
		$element->start_controls_section(
			'wd_extra_advanced',
			array(
				'label' => esc_html__( '[XTemos] Extra', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			)
		);

		$element->add_control(
			'wd_column_role',
			array(
				'label'       => __('Column role for "off-canvas layout"', 'woodmart'),
				'description' => esc_html__('You can create your page layout with an off-canvas sidebar. In this case, you need to have two columns: one will be set as the off-canvas sidebar and another as the content. NOTE: you need to also display the Off-canvas button element somewhere in your content column to open the sidebar. Also, you need to enable them on specific devices synchronously.', 'woodmart'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''          => esc_html__('None', 'woodmart'),
					'offcanvas' => esc_html__('Off canvas column', 'woodmart'),
					'content'   => esc_html__('Content column', 'woodmart'),
				),
				'render_type' => 'template',
				'default'     => '',
			)
		);

		$element->add_control(
			'wd_column_role_offcanvas_desktop',
			array(
				'label'        => esc_html__('Desktop', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'lg',
				'prefix_class' => 'wd-col-offcanvas-',
				'condition'    => array(
					'wd_column_role' => 'offcanvas',
				),
				'render_type'  => 'template',
			)
		);

		$element->add_control(
			'wd_column_role_offcanvas_tablet',
			array(
				'label'        => esc_html__('Tablet', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'md-sm',
				'prefix_class' => 'wd-col-offcanvas-',
				'condition'    => array(
					'wd_column_role' => 'offcanvas',
				),
				'render_type'  => 'template',
			)
		);

		$element->add_control(
			'wd_column_role_offcanvas_mobile',
			array(
				'label'        => esc_html__('Mobile', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'sm',
				'prefix_class' => 'wd-col-offcanvas-',
				'condition'    => array(
					'wd_column_role' => 'offcanvas',
				),
				'render_type'  => 'template',
			)
		);

		$element->add_control(
			'wd_column_role_content_desktop',
			array(
				'label'        => esc_html__('Desktop', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'lg',
				'prefix_class' => 'wd-col-content-',
				'condition'    => array(
					'wd_column_role' => 'content',
				),
				'render_type'  => 'template',
			)
		);

		$element->add_control(
			'wd_column_role_content_tablet',
			array(
				'label'        => esc_html__('Tablet', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'md-sm',
				'prefix_class' => 'wd-col-content-',
				'condition'    => array(
					'wd_column_role' => 'content',
				),
				'render_type'  => 'template',
			)
		);

		$element->add_control(
			'wd_column_role_content_mobile',
			array(
				'label'        => esc_html__('Mobile', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'sm',
				'prefix_class' => 'wd-col-content-',
				'condition'    => array(
					'wd_column_role' => 'content',
				),
				'render_type'  => 'template',
			)
		);

		$element->add_control(
			'wd_off_canvas_alignment',
			array(
				'label'        => esc_html__('Off canvas alignment', 'woodmart'),
				'type'         => 'wd_buttons',
				'options'      => array(
					'left' => array(
						'title' => esc_html__('Left', 'woodmart'),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					),
					'right' => array(
						'title' => esc_html__('Right', 'woodmart'),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'condition'    => array(
					'wd_column_role' => 'offcanvas',
				),
				'render_type'  => 'template',
				'default'      => 'left',
				'prefix_class' => 'wd-alignment-',
			)
		);

		$element->add_control(
			'wd_column_role_hr',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		/**
		 * Column parallax on scroll
		 */
		$element->add_control(
			'column_parallax',
			array(
				'label'        => esc_html__('Parallax on scroll', 'woodmart'),
				'description'  => esc_html__('Smooth element movement when you scroll the page to create beautiful parallax effect.', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'parallax-on-scroll',
				'prefix_class' => 'wd-',
				'render_type'  => 'template',
				'condition'    => array(
					'wd_column_role' => array(''),
				),
			)
		);

		$element->add_control(
			'scroll_x',
			array(
				'label'        => esc_html__('X axis translation', 'woodmart'),
				'description'  => esc_html__('Recommended -200 to 200', 'woodmart'),
				'type'         => Controls_Manager::TEXT,
				'default'      => 0,
				'render_type'  => 'template',
				'prefix_class' => 'wd_scroll_x_',
				'condition'    => array(
					'column_parallax' => array('parallax-on-scroll'),
					'wd_column_role' => array(''),
				),
			)
		);

		$element->add_control(
			'scroll_y',
			array(
				'label'        => esc_html__('Y axis translation', 'woodmart'),
				'description'  => esc_html__('Recommended -200 to 200', 'woodmart'),
				'type'         => Controls_Manager::TEXT,
				'default'      => -80,
				'render_type'  => 'template',
				'prefix_class' => 'wd_scroll_y_',
				'condition'    => array(
					'column_parallax' => array('parallax-on-scroll'),
					'wd_column_role' => array(''),
				),
			)
		);

		$element->add_control(
			'scroll_z',
			array(
				'label'        => esc_html__('Z axis translation', 'woodmart'),
				'description'  => esc_html__('Recommended -200 to 200', 'woodmart'),
				'type'         => Controls_Manager::TEXT,
				'default'      => 0,
				'render_type'  => 'template',
				'prefix_class' => 'wd_scroll_z_',
				'condition'    => array(
					'column_parallax' => array('parallax-on-scroll'),
					'wd_column_role' => array(''),
				),
			)
		);

		$element->add_control(
			'scroll_smoothness',
			array(
				'label'       => esc_html__('Parallax smoothness', 'woodmart'),
				'description' => esc_html__('Define the parallax smoothness on mouse scroll. By default - 30', 'woodmart'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'10'  => '10',
					'20'  => '20',
					'30'  => '30',
					'40'  => '40',
					'50'  => '50',
					'60'  => '60',
					'70'  => '70',
					'80'  => '80',
					'90'  => '90',
					'100' => '100',
				),
				'default'      => '30',
				'render_type'  => 'template',
				'prefix_class' => 'wd_scroll_smoothness_',
				'condition'    => array(
					'column_parallax' => array('parallax-on-scroll'),
					'wd_column_role' => array(''),
				),
			)
		);

		$element->add_control(
			'column_parallax_hr',
			array(
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => array(
					'wd_column_role' => array(''),
				),
			)
		);

		/**
		 * Hidden column content switcher.
		 */
		$element->add_control(
			'wd_collapsible_content_switcher',
			array(
				'label'        => esc_html__('Collapsible content', 'woodmart'),
				'description'  => esc_html__('Limit the column height and add the "Read more" button. IMPORTANT: you need to add our "Button" element to the end of this container and enable an appropriate option there as well.', 'woodmart'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => esc_html__('Yes', 'woodmart'),
				'label_off'    => esc_html__('No', 'woodmart'),
				'return_value' => 'collapsible-content',
				'prefix_class' => 'wd-',
				'condition'    => array(
					'wd_column_role' => array(''),
				),
			)
		);

		$element->add_responsive_control(
			'wd_collapsible_content_height',
			array(
				'label'     => esc_html__('Column content height', 'woodmart'),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.wd-collapsible-content.e-con' => 'max-height: {{SIZE}}px',
				),
				'default'   => array(
					'size' => 300,
				),
				'condition' => array(
					'wd_collapsible_content_switcher' => array('collapsible-content'),
					'wd_column_role' => array(''),
				),
			)
		);

		$element->add_control(
			'wd_collapsible_content_fade_out_color',
			array(
				'label'     => esc_html__('Fade out color', 'woodmart'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}.wd-collapsible-content.e-con:not(.wd-opened):after' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'wd_collapsible_content_switcher' => array('collapsible-content'),
					'wd_column_role' => array(''),
				),
			)
		);

		/**
		 * Animations
		 */
		woodmart_get_animation_map(
			$element,
			array(
				'wd_column_role' => '',
			)
		);

		$element->end_controls_section();
	}

	add_action( 'elementor/element/container/section_layout/after_section_end', 'woodmart_add_container_custom_controls' );
}

if ( ! function_exists( 'woodmart_container_before_render' ) ) {
	/**
	 * Section before render.
	 *
	 * @since 1.0.0
	 *
	 * @param object $widget Element.
	 */
	function woodmart_container_before_render( $widget ) {
		$settings = $widget->get_settings_for_display();

		if ( 'enabled' === woodmart_get_opt( 'negative_gap', 'enabled' ) && isset( $settings['content_width'] ) && 'boxed' === $settings['content_width'] && isset( $settings['boxed_width']['size'] ) && ! $settings['boxed_width']['size'] ) {
			$widget->add_render_attribute( '_wrapper', 'class', 'wd-negative-gap' );
		}

		if ( isset( $settings['wd_animation'] ) && $settings['wd_animation'] ) {
			woodmart_enqueue_inline_style( 'animations' );
			woodmart_enqueue_js_script( 'animations' );
			woodmart_enqueue_js_library( 'waypoints' );
		}

		if ( isset( $settings['column_parallax'] ) && $settings['column_parallax'] ) {
			woodmart_enqueue_js_library( 'parallax-scroll-bundle' );
		}

		if ( isset( $settings['wd_animation'] ) && $settings['wd_animation'] ) {
			woodmart_enqueue_inline_style( 'animations' );
			woodmart_enqueue_js_script( 'animations' );
			woodmart_enqueue_js_library( 'waypoints' );
		}

		if ( isset( $settings['wd_collapsible_content_switcher'] ) && $settings['wd_collapsible_content_switcher'] ) {
			woodmart_enqueue_inline_style( 'collapsible-content' );
		}

		if ( isset( $settings['wd_column_role'] ) && $settings['wd_column_role'] ) {
			woodmart_enqueue_inline_style( 'int-elem-opt-off-canvas-column' );
		}
	}

	add_action( 'elementor/frontend/container/before_render', 'woodmart_container_before_render', 10 );
}

if ( ! function_exists( 'woodmart_add_container_class_if_content_width' ) ) {
	/**
	 * Add class to container is content with is set.
	 *
	 * @since 1.0.0
	 *
	 * @param object $widget Element.
	 */
	function woodmart_add_container_class_if_content_width( $widget ) {
		$settings = $widget->get_settings_for_display();

		if ( isset( $settings['content_width'] ) && 'boxed' === $settings['content_width'] && isset( $settings['boxed_width']['size'] ) && ! $settings['boxed_width']['size'] ) {
			$widget->add_render_attribute( '_wrapper', 'class', 'wd-negative-gap' );
		}
	}
}
