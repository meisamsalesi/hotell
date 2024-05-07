<?php
/**
 * Tabs map.
 *
 * @package Woodmart.
 */

namespace XTS\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that adds tabs.
 */
class Tabs extends Widget_Base {
	/***
	 * This method return a widget name that will be used in the code.
	 *
	 * @return string widget name.
	 */
	public function get_name() {
		return 'wd_tabs';
	}

	/***
	 * This method return the widget title that will be displayed as the widget label.
	 *
	 * @return string widget title.
	 */
	public function get_title() {
		return esc_html__( 'Tabs', 'woodmart' );
	}

	/***
	 * This method set the widget icon.
	 *
	 * @return string widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-tabs';
	}

	/***
	 * This method lets you set the category of the widget.
	 *
	 * @return array the category name.
	 */
	public function get_categories() {
		return array( 'wd-elements' );
	}

	/***
	 * This method lets you define which controls (setting fields) your widget will have.
	 */
	protected function register_controls() {
		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Tabs title', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Title text example',
			)
		);

		$this->add_control(
			'description',
			[
				'label'     => esc_html__( 'Tabs description', 'woodmart' ),
				'type'      => Controls_Manager::TEXTAREA,
				'condition' => [
					'design' => array( 'default', 'aside' ),
				],
			]
		);

		$this->end_controls_section();

		/**
		 * Image settings.
		 */
		$this->start_controls_section(
			'image_content_section',
			array(
				'label' => esc_html__( 'Image', 'woodmart' ),
			)
		);

		$this->add_control(
			'image',
			array(
				'label' => esc_html__( 'Choose image', 'woodmart' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Tabs', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'content_tabs' );

		$repeater->start_controls_tab(
			'content_tab',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater->add_control(
			'tab_title',
			array(
				'label'       => esc_html__( 'Title', 'woodmart' ),
				'placeholder' => esc_html__( 'Tab Title', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Tab Title',
			)
		);

		$repeater->add_control(
			'content_type',
			array(
				'label'       => esc_html__( 'Content type', 'woodmart' ),
				'description' => esc_html__( 'You can display content as a simple text or if you need more complex structure you can create an HTML Block with Elementor builder and place it here.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'text'       => esc_html__( 'Text', 'woodmart' ),
					'html_block' => esc_html__( 'HTML Block', 'woodmart' ),
				),
				'default'     => 'text',
			)
		);

		$repeater->add_control(
			'content_text',
			array(
				'label'     => esc_html__( 'Text', 'woodmart' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
				'condition' => array(
					'content_type' => array( 'text' ),
				),
			)
		);

		$repeater->add_control(
			'content_html_block',
			array(
				'label'       => esc_html__( 'Content', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => woodmart_get_elementor_html_blocks_array(),
				'description' => function_exists( 'woodmart_get_html_block_links' ) ? woodmart_get_html_block_links() : '',
				'default'     => '0',
				'condition'   => array(
					'content_type' => array( 'html_block' ),
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'icon_tab',
			array(
				'label' => esc_html__( 'Icon', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater->add_control(
			'icon_type',
			array(
				'label'   => esc_html__( 'Icon type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'icon'  => esc_html__( 'With icon', 'woodmart' ),
					'image' => esc_html__( 'With image', 'woodmart' ),
				),
				'default' => 'icon',
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'     => esc_html__( 'Icon', 'woodmart' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => array(
					'icon_type' => array( 'icon' ),
				),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'icon_type' => array( 'image' ),
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'separator' => 'none',
				'default'   => 'thumbnail',
				'condition' => array(
					'icon_type' => array( 'image' ),
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'tabs',
			array(
				'label'   => esc_html__( 'Tabs items', 'woodmart' ),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array(
						'tab_title' => 'Tab #1',
						'icon_type' => 'icon',
					),
					array(
						'tab_title' => 'Tab #2',
						'icon_type' => 'icon',
					),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Tabs General.
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'Heading', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'design',
			array(
				'label'   => esc_html__( 'Design', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'simple'  => esc_html__( 'Simple', 'woodmart' ),
					'alt'     => esc_html__( 'Alternative', 'woodmart' ),
					'aside'   => esc_html__( 'Aside', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'tabs_side_width',
			array(
				'label'      => esc_html__( 'Side heading width', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 100,
						'max'  => 500,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wd-tabs.tabs-design-aside' => '--wd-side-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'design' => array( 'aside' ),
				),
			)
		);

		$this->add_control(
			'tabs_title_color',
			array(
				'label'     => esc_html__( 'Heading color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .tabs-name' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tabs_heading_typography',
				'label'    => esc_html__( 'Heading typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-tabs .tabs-name',
			)
		);

		$this->add_control(
			'tabs_description_color',
			array(
				'label'     => esc_html__( 'Description color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-tabs-desc' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'design' => array( 'default', 'aside' ),
				),
			)
		);

		$this->add_control(
			'tabs_border_color',
			array(
				'label'     => esc_html__( 'Border color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-tabs.tabs-design-simple .tabs-name' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'design' => array( 'simple' ),
				),
			)
		);

		$this->add_control(
			'tabs_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'woodmart' ),
				'type'      => 'wd_buttons',
				'options'   => array(
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
				'default'   => 'center',
				'condition' => array(
					'design' => array( 'default' ),
				),
			)
		);

		$this->end_controls_section();
		/**
		 * Tabs Style.
		 */
		$this->start_controls_section(
			'title_style_section',
			array(
				'label' => esc_html__( 'Tab title', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tabs_style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'   => esc_html__( 'Default', 'woodmart' ),
					'underline' => esc_html__( 'Underline', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'title_text_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'custom'  => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->start_controls_tabs(
			'tabs_title_text_color_tabs',
			array(
				'condition' => array(
					'title_text_color_scheme' => 'custom',
				),
			)
		);

		$this->start_controls_tab(
			'tabs_title_text_color_tab',
			array(
				'label' => esc_html__( 'Idle', 'woodmart' ),
			)
		);

		$this->add_control(
			'tabs_title_text_idle_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-nav > li > a' => 'color: {{VALUE}}',
				),
				array(
					'condition' => array(
						'title_text_color_scheme' => 'custom',
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_title_text_hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'woodmart' ),
			)
		);

		$this->add_control(
			'tabs_title_text_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-nav > li:hover > a' => 'color: {{VALUE}}',
				),
				array(
					'condition' => array(
						'title_text_color_scheme' => 'custom',
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_title_text_hover_active_tab',
			array(
				'label' => esc_html__( 'Active', 'woodmart' ),
			)
		);

		$this->add_control(
			'tabs_title_text_hover_active',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-nav-tabs > li.wd-active > a, {{WRAPPER}} .wd-tabs:not(.wd-inited) .wd-nav-tabs li:first-child a' => 'color: {{VALUE}}',
				),
				array(
					'condition' => array(
						'title_text_color_scheme' => 'custom',
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tabs_title_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-nav.wd-nav-tabs .wd-nav-link',
			)
		);

		/**
		 * Layout.
		 */

		$this->add_control(
			'icon_alignment',
			array(
				'label'   => esc_html__( 'Icon alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/left.png',
					),
					'top'   => array(
						'title' => esc_html__( 'Top', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/top.png',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/right.png',
					),
				),
				'default' => 'left',
			)
		);

		$this->add_responsive_control(
			'space_between_tabs_title_horizontal',
			array(
				'label'     => esc_html__( 'Horizontal spacing', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 150,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-nav-tabs > li:not(:last-child)' => 'margin-inline-end: {{SIZE}}px;',
				),
				'condition' => array(
					'design!' => array( 'aside' ),
				),
			)
		);

		$this->add_responsive_control(
			'space_between_tabs_title_vertical',
			array(
				'label'     => esc_html__( 'Vertical spacing', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 150,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wd-tabs-header' => 'margin-bottom: {{SIZE}}px;',
				),
				'condition' => array(
					'design!' => array( 'aside' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tabs_content_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-tab-content',
			)
		);

		$this->add_control(
			'content_text_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'custom'  => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_control(
			'custom_content_text_color_scheme',
			array(
				'label'     => esc_html__( 'Custom color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-tab-content' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'content_text_color_scheme' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/***
	 * This method render the code and generate the final HTML on the frontend using PHP.
	 */
	protected function render() {
		$tabs_parent_settings = $this->get_settings_for_display();
		$tabs_child_settings  = $tabs_parent_settings['tabs'];

		$wrapper_classes         = ' tabs-design-' . $tabs_parent_settings['design'];
		$nav_tabs_title_classes  = ' wd-icon-pos-' . $tabs_parent_settings['icon_alignment'];
		$nav_tabs_title_classes .= ' wd-style-' . $tabs_parent_settings['tabs_style'];
		$this->add_inline_editing_attributes( 'content_text' );

		woodmart_enqueue_js_script( 'tabs-element' );
		woodmart_enqueue_inline_style( 'tabs' );

		if ( ! $tabs_parent_settings['tabs_alignment'] ) {
			$tabs_parent_settings['tabs_alignment'] = 'center';
		}

		$nav_tabs_wrapper_classes = ' text-' . $tabs_parent_settings['tabs_alignment'];

		$image_output = '';

		// Image settings.
		$custom_image_size = isset( $tabs_parent_settings['image_custom_dimension']['width'] ) && $tabs_parent_settings['image_custom_dimension']['width'] ? $tabs_parent_settings['image_custom_dimension'] : array(
			'width'  => 128,
			'height' => 128,
		);

		if ( isset( $tabs_parent_settings['image']['id'] ) && $tabs_parent_settings['image']['id'] ) {
			$image_output = '<span class="img-wrapper">' . woodmart_get_image_html( $tabs_parent_settings, 'image' ) . '</span>';

			if ( woodmart_is_svg( woodmart_get_image_url( $tabs_parent_settings['image']['id'], 'image', $tabs_parent_settings ) ) ) {
				$image_output = '<span class="svg-icon img-wrapper" style="width:' . esc_attr( $tabs_parent_settings['width'] ) . 'px; height:' . esc_attr( $custom_image_size['height'] ) . 'px;">' . woodmart_get_any_svg( woodmart_get_image_url( $tabs_parent_settings['image']['id'], 'image', $tabs_parent_settings ), wp_rand( 999, 9999 ) ) . '</span>';
			}
		}

		$tabs_nav_wrapper_classes = '';
		if ( 'inherit' !== $tabs_parent_settings['title_text_color_scheme'] && 'custom' !== $tabs_parent_settings['title_text_color_scheme'] ) {
			$tabs_nav_wrapper_classes .= ' color-scheme-' . $tabs_parent_settings['title_text_color_scheme'];
		}

		$content_classes_wrapper = '';
		if ( 'inherit' !== $tabs_parent_settings['content_text_color_scheme'] && 'custom' !== $tabs_parent_settings['content_text_color_scheme'] ) {
			$content_classes_wrapper = ' color-scheme-' . $tabs_parent_settings['content_text_color_scheme'];
		}
		?>
		<div class="wd-tabs<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-tabs-header<?php echo esc_attr( $nav_tabs_wrapper_classes ); ?>">
				<?php if ( $tabs_parent_settings['title'] ) : ?>
					<div class="tabs-name title">
						<?php if ( $image_output ) : ?>
							<?php echo $image_output; // phpcs:ignore ?>
						<?php endif; ?>

						<span class="tabs-text" data-elementor-setting-key="title">
							<?php echo wp_kses( $tabs_parent_settings['title'], woodmart_get_allowed_html() ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $tabs_parent_settings['description'] ) : ?>
					<div class="wd-tabs-desc">
						<?php echo wp_kses( $tabs_parent_settings['description'], woodmart_get_allowed_html() ); ?>
					</div>
				<?php endif; ?>

				<div class="wd-nav-wrapper wd-nav-tabs-wrapper<?php echo esc_attr( $tabs_nav_wrapper_classes ); ?>">
					<ul class="wd-nav wd-nav-tabs<?php echo esc_attr( $nav_tabs_title_classes ); ?>">
						<?php foreach ( $tabs_child_settings as $tab ) : ?>
							<?php
							// Icon settings.

							$image_size = array(
								'width'  => 128,
								'height' => 128,
							);

							if ( isset( $tab['image_size'] ) && ! empty( $tab['image_size'] ) && 'custom' !== $tab['image_size'] ) {
								$image_size = $tab['image_size'];
							} elseif ( 'custom' === $tab['image_size'] && isset( $tab['image_custom_dimension']['width'] ) && ! empty( $tab['image_custom_dimension']['width'] ) ) {
								$image_size = $tab['image_custom_dimension'];
							}

							$icon_output = '';

							if ( 'image' === $tab['icon_type'] && isset( $tab['image']['id'] ) && $tab['image']['id'] ) {
								$icon_output = woodmart_get_image_html( $tab, 'image' );

								if ( woodmart_is_svg( woodmart_get_image_url( $tab['image']['id'], 'image', $tab ) ) ) {
									$icon_output = woodmart_get_svg_html( $tab['image']['id'], $image_size, array( 'class' => 'svg-icon' ) );
								}
							} elseif ( 'icon' === $tab['icon_type'] && $tab['icon'] ) {
								$icon_output = woodmart_elementor_get_render_icon( $tab['icon'] );
							}
							?>

							<li>
								<a href="#" class="wd-nav-link">
									<?php if ( ! empty( $icon_output ) ) : ?>
										<div class="img-wrapper">
											<?php echo $icon_output; // phpcs:ignore ?>
										</div>
									<?php endif; ?>

									<span class="nav-link-text wd-tabs-title">
										<?php echo esc_html( $tab['tab_title'] ); ?>
									</span>
								</a>
							</li>

						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="wd-tab-content-wrapper<?php echo esc_attr( $content_classes_wrapper ); ?>">
				<?php foreach ( $tabs_child_settings as $index => $tab ) : ?>
					<?php $tab_content_setting_key = $this->get_repeater_setting_key( 'content_text', 'tabs', $index ); ?>
					<?php $this->add_inline_editing_attributes( $tab_content_setting_key ); ?>

					<?php
					$content_classes_active = '';
					if ( 0 === $index ) {
						$content_classes_active = ' wd-active wd-in';
					}
					?>

					<div class="wd-tab-content<?php echo esc_attr( $content_classes_active ); ?>">
						<?php if ( 'html_block' === $tab['content_type'] ) : ?>
							<?php echo woodmart_get_html_block( $tab['content_html_block'] ); // phpcs:ignore ?>
						<?php elseif ( 'text' === $tab['content_type'] ) : ?>
							<div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
								<?php echo do_shortcode( $tab['content_text'] ); ?>
							</div>
						<?php endif; ?>
					</div>

				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Tabs() );
