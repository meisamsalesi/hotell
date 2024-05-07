<?php
/**
 * Table map
 *
 * @package WoodMart
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Table extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_table';
	}

	/**
	 * Get widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Table', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-table';
	}

	/**
	 * Get widget categories.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-elements' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function register_controls() { // phpcs:ignore
		/**
		* Content tab
		* /

		/**
		 * Heading settings
		 */
		$this->start_controls_section(
			'heading_general_section',
			array(
				'label' => esc_html__( 'Heading', 'woodmart' ),
			)
		);

		$heading_repeater = new Repeater();

		$heading_repeater->add_control(
			'heading_content_type',
			array(
				'label'   => esc_html__( 'Action', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cell',
				'options' => array(
					'row'  => esc_html__( 'Start new row', 'woodmart' ),
					'cell' => esc_html__( 'Add new cell', 'woodmart' ),
				),
			)
		);

		$heading_repeater->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'heading_item_border',
				'label'          => esc_html__( 'Border', 'woodmart' ),
				'fields_options' => array(
					'border' => array(
						'options' => array(
							''       => esc_html__( 'Inherit', 'woodmart' ),
							'none'   => esc_html__( 'None', 'elementor' ),
							'solid'  => _x( 'Solid', 'Border Control', 'elementor' ),
							'double' => _x( 'Double', 'Border Control', 'elementor' ),
							'dotted' => _x( 'Dotted', 'Border Control', 'elementor' ),
							'dashed' => _x( 'Dashed', 'Border Control', 'elementor' ),
							'groove' => _x( 'Groove', 'Border Control', 'elementor' ),
						),
						'default' => '',
					),
					'width'  => array(
						'default'   => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
						'condition' => array(
							'border!' => array( '', 'none' ),
						),
					),
					'color'  => array(
						'default'   => '#bbb',
						'condition' => array(
							'border!' => array( '', 'none' ),
						),
					),
				),
				'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}} th',
				'condition'      => array(
					'heading_content_type' => 'row',
				),
			)
		);

		$heading_repeater->start_controls_tabs( 'heading_items_tabs' );

		$heading_repeater->start_controls_tab(
			'tab_heading_cell_content',
			array(
				'label'     => esc_html__( 'Content', 'woodmart' ),
				'condition' => array(
					'heading_content_type' => 'cell',
				),
			)
		);

		$heading_repeater->add_control(
			'heading_cell_text',
			array(
				'label'     => esc_html__( 'Text', 'woodmart' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => 'Content',
				'condition' => array(
					'heading_content_type' => 'cell',
				),
			)
		);

		$heading_repeater->end_controls_tab();

		$heading_repeater->start_controls_tab(
			'tab_heading_cell_settings',
			array(
				'label'     => esc_html__( 'Settings', 'woodmart' ),
				'condition' => array(
					'heading_content_type' => 'cell',
				),
			)
		);

		$heading_repeater->add_control(
			'heading_cell_span',
			array(
				'label'     => esc_html__( 'Column Span', 'woodmart' ),
				'title'     => esc_html__( 'How many columns should this column span across.', 'woodmart' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 20,
				'step'      => 1,
				'condition' => array(
					'heading_content_type' => 'cell',
				),
			)
		);

		$heading_repeater->add_control(
			'heading_cell_row_span',
			array(
				'label'     => esc_html__( 'Row Span', 'woodmart' ),
				'title'     => esc_html__( 'How many rows should this column span across.', 'woodmart' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 20,
				'step'      => 1,
				'separator' => 'below',
				'condition' => array(
					'heading_content_type' => 'cell',
				),
			)
		);

		$heading_repeater->add_control(
			'heading_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'heading_content_type' => 'cell',
				),
			)
		);

		$heading_repeater->add_control(
			'heading_cell_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'heading_content_type' => 'cell',
				),
			)
		);

		$heading_repeater->end_controls_tab();

		$heading_repeater->end_controls_tabs();

		$this->add_control(
			'heading_items',
			array(
				'type'          => Controls_Manager::REPEATER,
				'title_field'   => '{{ heading_content_type }}: {{{ heading_cell_text }}}',
				'fields'        => $heading_repeater->get_controls(),
				'prevent_empty' => false,
				'default'       => array(
					array(
						'heading_content_type' => 'row',
					),
					array(
						'heading_cell_text'    => 'Heading #1',
						'heading_content_type' => 'cell',
					),
					array(
						'heading_cell_text'    => 'Heading #2',
						'heading_content_type' => 'cell',
					),
					array(
						'heading_cell_text'    => 'Heading #3',
						'heading_content_type' => 'cell',
					),
					array(
						'heading_cell_text'    => 'Heading #4',
						'heading_content_type' => 'cell',
					),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Content settings
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'Body', 'woodmart' ),
			)
		);

		$body_repeater = new Repeater();

		$body_repeater->add_control(
			'body_content_type',
			array(
				'label'   => esc_html__( 'Action', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cell',
				'options' => array(
					'row'  => esc_html__( 'Start new row', 'woodmart' ),
					'cell' => esc_html__( 'Add new cell', 'woodmart' ),
				),
			)
		);

		$body_repeater->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'body_item_border',
				'label'          => esc_html__( 'Border', 'woodmart' ),
				'fields_options' => array(
					'border' => array(
						'options' => array(
							''       => esc_html__( 'Inherit', 'woodmart' ),
							'none'   => esc_html__( 'None', 'elementor' ),
							'solid'  => _x( 'Solid', 'Border Control', 'elementor' ),
							'double' => _x( 'Double', 'Border Control', 'elementor' ),
							'dotted' => _x( 'Dotted', 'Border Control', 'elementor' ),
							'dashed' => _x( 'Dashed', 'Border Control', 'elementor' ),
							'groove' => _x( 'Groove', 'Border Control', 'elementor' ),
						),
						'default' => '',
					),
					'width'  => array(
						'default'   => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
						'condition' => array(
							'border!' => array( '', 'none' ),
						),
					),
					'color'  => array(
						'default'   => '#bbb',
						'condition' => array(
							'border!' => array( '', 'none' ),
						),
					),
				),
				'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}} th, {{WRAPPER}} {{CURRENT_ITEM}} td',
				'condition'      => array(
					'body_content_type' => 'row',
				),
			)
		);

		$body_repeater->start_controls_tabs( 'body_item_tabs' );

		$body_repeater->start_controls_tab(
			'tab_body_cell_content',
			array(
				'label'     => esc_html__( 'Content', 'woodmart' ),
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->add_control(
			'body_cell_text',
			array(
				'label'     => esc_html__( 'Text', 'woodmart' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => 'Content',
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->end_controls_tab();

		$body_repeater->start_controls_tab(
			'tab_body_cell_settings',
			array(
				'label'     => esc_html__( 'Settings', 'woodmart' ),
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->add_control(
			'body_cell_type',
			array(
				'label'     => esc_html__( 'Cell Type', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'td',
				'options'   => array(
					'td' => esc_html__( 'Default', 'woodmart' ),
					'th' => esc_html__( 'Header', 'woodmart' ),
				),
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->add_control(
			'body_cell_span',
			array(
				'label'     => esc_html__( 'Column Span', 'woodmart' ),
				'title'     => esc_html__( 'How many columns should this column span across.', 'woodmart' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 20,
				'step'      => 1,
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->add_control(
			'body_cell_row_span',
			array(
				'label'     => esc_html__( 'Row Span', 'woodmart' ),
				'title'     => esc_html__( 'How many rows should this column span across.', 'woodmart' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 20,
				'step'      => 1,
				'separator' => 'below',
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->add_control(
			'body_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->add_control(
			'body_cell_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'body_content_type' => 'cell',
				),
			)
		);

		$body_repeater->end_controls_tab();

		$body_repeater->end_controls_tabs();

		$this->add_control(
			'body_items',
			array(
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{ body_content_type }}: {{{ body_cell_text }}}',
				'fields'      => $body_repeater->get_controls(),
				'default'     => array(
					array(
						'body_content_type' => 'row',
					),
					array(
						'body_cell_text'    => 'Row #1 Content #1',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #1 Content #2',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #1 Content #3',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #1 Content #4',
						'body_content_type' => 'cell',
					),
					array(
						'body_content_type' => 'row',
					),
					array(
						'body_cell_text'    => 'Row #2 Content #1',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #2 Content #2',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #2 Content #3',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #2 Content #4',
						'body_content_type' => 'cell',
					),
					array(
						'body_content_type' => 'row',
					),
					array(
						'body_cell_text'    => 'Row #3 Content #1',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #3 Content #2',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #3 Content #3',
						'body_content_type' => 'cell',
					),
					array(
						'body_cell_text'    => 'Row #3 Content #4',
						'body_content_type' => 'cell',
					),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style tab
		 */

		/**
		 * Heading settings
		 */
		$this->start_controls_section(
			'heading_style_section',
			array(
				'label' => esc_html__( 'Heading', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_text_align',
			array(
				'label'   => esc_html__( 'Text alignment', 'woodmart' ),
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
			'heading_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} th' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_text_color',
			array(
				'label'     => esc_html__( 'Text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} th' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_typography_heading',
			array(
				'label'     => esc_html__( 'Typography', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_custom_typography',
				'label'    => esc_html__( 'Custom typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} th',
			)
		);

		$this->add_control(
			'heading_border_heading',
			array(
				'label'     => esc_html__( 'Border', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'heading_border',
				'label'          => esc_html__( 'Border', 'woodmart' ),
				'fields_options' => array(
					'border' => array(
						'options' => array(
							''       => esc_html__( 'Default', 'woodmart' ),
							'none'   => esc_html__( 'None', 'elementor' ),
							'solid'  => _x( 'Solid', 'Border Control', 'elementor' ),
							'double' => _x( 'Double', 'Border Control', 'elementor' ),
							'dotted' => _x( 'Dotted', 'Border Control', 'elementor' ),
							'dashed' => _x( 'Dashed', 'Border Control', 'elementor' ),
							'groove' => _x( 'Groove', 'Border Control', 'elementor' ),
						),
						'default' => '',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(
						'default' => '#bbb',
					),
				),
				'selector'       => '{{WRAPPER}} th',
			)
		);

		$this->add_control(
			'heading_padding_heading',
			array(
				'label'     => esc_html__( 'Padding', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'heading_cell_padding',
			array(
				'label'      => esc_html__( 'Table cell padding', 'woodmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'      => '',
					'bottom'   => '',
					'left'     => '',
					'right'    => '',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Body settings
		 */
		$this->start_controls_section(
			'body_style_section',
			array(
				'label' => esc_html__( 'Body', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'body_text_align',
			array(
				'label'   => esc_html__( 'Text alignment', 'woodmart' ),
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
			'body_background_heading',
			array(
				'label'     => esc_html__( 'Background', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'body_background_type',
			array(
				'label'   => esc_html__( 'Background type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'body',
				'options' => array(
					'body'       => esc_html__( 'Body', 'woodmart' ),
					'h_even_odd' => esc_html__( 'Horizontal even & odd', 'woodmart' ),
					'v_even_odd' => esc_html__( 'Vertical even & odd', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'body_background_color',
			array(
				'label'     => esc_html__( 'Body background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody td' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'body',
				),
			)
		);

		$this->add_control(
			'body_text_color',
			array(
				'label'     => esc_html__( 'Body text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody td' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'body',
				),
			)
		);

		$this->add_control(
			'h_even_background_color',
			array(
				'label'     => esc_html__( 'Horizontal even background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody tr:nth-child(even)' => 'background-color: {{VALUE}};',
				),
				'default'   => '#F8F8F8',
				'condition' => array(
					'body_background_type' => 'h_even_odd',
				),
			)
		);

		$this->add_control(
			'h_odd_background_color',
			array(
				'label'     => esc_html__( 'Horizontal odd background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody tr:nth-child(odd)' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'h_even_odd',
				),
			)
		);

		$this->add_control(
			'h_even_text_color',
			array(
				'label'     => esc_html__( 'Horizontal even text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody tr:nth-child(even)' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'h_even_odd',
				),
			)
		);

		$this->add_control(
			'h_odd_text_color',
			array(
				'label'     => esc_html__( 'Horizontal odd text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody tr:nth-child(odd)' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'h_even_odd',
				),
			)
		);

		$this->add_control(
			'v_even_background_color',
			array(
				'label'     => esc_html__( 'Vertical even background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody td:nth-child(even), {{WRAPPER}} tbody th:nth-child(even)' => 'background-color: {{VALUE}};',
				),
				'default'   => '#F8F8F8',
				'condition' => array(
					'body_background_type' => 'v_even_odd',
				),
			)
		);

		$this->add_control(
			'v_odd_background_color',
			array(
				'label'     => esc_html__( 'Vertical odd background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody td:nth-child(odd), {{WRAPPER}} tbody th:nth-child(odd)' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'v_even_odd',
				),
			)
		);

		$this->add_control(
			'v_even_text_color',
			array(
				'label'     => esc_html__( 'Vertical even text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody td:nth-child(even), {{WRAPPER}} tbody th:nth-child(even)' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'v_even_odd',
				),
			)
		);

		$this->add_control(
			'v_odd_text_color',
			array(
				'label'     => esc_html__( 'Vertical odd text color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} tbody td:nth-child(odd), {{WRAPPER}} tbody th:nth-child(odd)' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'body_background_type' => 'v_even_odd',
				),
			)
		);

		$this->add_control(
			'body_typography_heading',
			array(
				'label'     => esc_html__( 'Typography', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'body',
				'label'    => esc_html__( 'Custom typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} td',
			)
		);

		$this->add_control(
			'body_border_heading',
			array(
				'label'     => esc_html__( 'Border', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'body_border',
				'label'          => esc_html__( 'Border', 'woodmart' ),
				'fields_options' => array(
					'border' => array(
						'options' => array(
							''       => esc_html__( 'Default', 'woodmart' ),
							'none'   => esc_html__( 'None', 'elementor' ),
							'solid'  => _x( 'Solid', 'Border Control', 'elementor' ),
							'double' => _x( 'Double', 'Border Control', 'elementor' ),
							'dotted' => _x( 'Dotted', 'Border Control', 'elementor' ),
							'dashed' => _x( 'Dashed', 'Border Control', 'elementor' ),
							'groove' => _x( 'Groove', 'Border Control', 'elementor' ),
						),
						'default' => '',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(
						'default' => '#bbb',
					),
				),
				'selector'       => '{{WRAPPER}} td',
			)
		);

		$this->add_control(
			'body_cell_padding_heading',
			array(
				'label'     => esc_html__( 'Padding', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'body_cell_padding',
			array(
				'label'      => esc_html__( 'Table cell padding', 'woodmart' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'      => '',
					'bottom'   => '',
					'left'     => '',
					'right'    => '',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	 * @since  1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$default_args = array(
			// Heading.
			'heading_items'         => array(),
			'heading_text_align'    => 'left',
			'heading_color_presets' => 'default',
			'heading_text_size'     => 'default',

			// Body.
			'body_items'            => array(),
			'body_text_align'       => 'left',
			'body_color_presets'    => 'default',
			'body_text_size'        => 'default',
		);

		$element_args = wp_parse_args( $this->get_settings_for_display(), $default_args ); // phpcs:ignore

		$wrapper_classes = '';

		// Heading classes.
		$heading_classes = 'text-' . $element_args['heading_text_align'];
		if ( 'default' !== $element_args['heading_color_presets'] ) {
			$heading_classes .= ' wd-textcolor-' . $element_args['heading_color_presets'];
		}
		if ( 'default' !== $element_args['heading_text_size'] ) {
			$heading_classes .= ' wd-fontsize-' . $element_args['heading_text_size'];
		}

		// Body classes.
		$body_classes = 'text-' . $element_args['body_text_align'];
		if ( 'default' !== $element_args['body_color_presets'] ) {
			$body_classes .= ' wd-textcolor-' . $element_args['body_color_presets'];
		}
		if ( 'default' !== $element_args['body_text_size'] ) {
			$body_classes .= ' wd-fontsize-' . $element_args['body_text_size'];
		}

		woodmart_enqueue_inline_style( 'el-table' );
		?>
		<div class="wd-el-table-wrap wd-reset-all-last<?php echo esc_attr( $wrapper_classes ); ?>">
			<table class="wd-el-table">
				<?php if ( $element_args['heading_items'] ) : ?>
					<thead class="<?php echo esc_attr( $heading_classes ); ?>">
						<?php foreach ( $element_args['heading_items'] as $key => $heading ) : ?>
							<?php if ( 'cell' === $heading['heading_content_type'] ) : ?>
								<th class="wd-table-cell elementor-repeater-item-<?php echo esc_attr( $heading['_id'] ); ?>" colspan="<?php echo esc_attr( $heading['heading_cell_span'] ); ?>" rowspan="<?php echo esc_attr( $heading['heading_cell_row_span'] ); ?>">
									<?php echo wp_kses( $heading['heading_cell_text'], true ); ?>
								</th>
							<?php else : ?>
								<?php if ( 0 === $key ) : ?>
									<tr class="wd-table-row elementor-repeater-item-<?php echo esc_attr( $heading['_id'] ); ?>">
								<?php else : ?>
									</tr>
									<tr class="wd-table-row elementor-repeater-item-<?php echo esc_attr( $heading['_id'] ); ?>">
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
						</tr>
					</thead>
				<?php endif; ?>

				<tbody class="<?php echo esc_attr( $body_classes ); ?>">
					<?php foreach ( $element_args['body_items'] as $key => $item ) : ?>
						<?php if ( 'cell' === $item['body_content_type'] ) : ?>
							<<?php echo esc_attr( $item['body_cell_type'] ); ?> class="wd-table-cell elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>" colspan="<?php echo esc_attr( $item['body_cell_span'] ); ?>" rowspan="<?php echo esc_attr( $item['body_cell_row_span'] ); ?>">
							<?php echo wp_kses( $item['body_cell_text'], true ); ?>
							</<?php echo esc_attr( $item['body_cell_type'] ); ?>>
						<?php else : ?>
							<?php if ( 0 === $key ) : ?>
								<tr class="wd-table-row elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<?php else : ?>
								</tr>
								<tr class="wd-table-row elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Table() );
