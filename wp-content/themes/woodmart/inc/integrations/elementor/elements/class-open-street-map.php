<?php
/**
 * Open street map.
 *
 * @package xts
 */

namespace XTS\Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Open_Street_Map extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_open_street_map';
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
		return esc_html__( 'Open street map', 'woodmart' );
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
		return 'wd-icon-open-street-map';
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
		return array( 'wd-elements' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'map', 'open street map' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
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
			'marker_title',
			array(
				'label'       => esc_html__( 'Title', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Marker Title', 'woodmart' ),
			)
		);

		$repeater->add_control(
			'marker_coords',
			array(
				'label'       => esc_html__( 'Coordinates', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '51.50735, -0.12776',
				'placeholder' => esc_html__( 'lat, long', 'woodmart' ),
			)
		);

		$repeater->add_control(
			'marker_description',
			array(
				'label'       => esc_html__( 'Description', 'woodmart' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => esc_html__( 'Marker Description', 'woodmart' ),
			)
		);

		$repeater->add_control(
			'marker_behavior',
			array(
				'label'   => esc_html__( 'Behavior', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'popup',
				'options' => array(
					'popup'            => 'Popup',
					'tooltip'          => 'Tooltip',
					'static_close_on'  => 'Static with close',
					'static_close_off' => 'Static without close',
					'none'             => 'None',
				),
			)
		);

		$repeater->add_control(
			'show_button',
			array(
				'label'        => esc_html__( 'Show button', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'woodmart' ),
				'label_off'    => esc_html__( 'Hide', 'woodmart' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$repeater->add_control(
			'button_text',
			array(
				'label'       => esc_html__( 'Button text', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Button Text', 'woodmart' ),
				'condition'   => array(
					'show_button' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Button URL', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'input_type'  => 'url',
				'placeholder' => esc_html__( 'https://your-link.com', 'woodmart' ),
				'condition'   => array(
					'show_button' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'button_url_target',
			array(
				'label'     => esc_html__( 'URL target', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'_self'  => esc_html__( 'Same Window', 'woodmart' ),
					'_blank' => esc_html__( 'New Window/Tab', 'woodmart' ),
				),
				'default'   => '_blank',
				'condition' => array(
					'button_url!' => '',
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'marker_tab',
			array(
				'label' => esc_html__( 'Marker', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Image', 'woodmart' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->start_controls_section(
			'section_map',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$this->add_control(
			'marker_list',
			array(
				'label'       => esc_html__( 'Marker list', 'woodmart' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(),
				),
				'title_field' => '{{{ marker_title }}}',
			)
		);

		$this->end_controls_section();

		/**
		 * Marker settings.
		 */
		$this->start_controls_section(
			'marker_content_section',
			array(
				'label' => esc_html__( 'Marker', 'woodmart' ),
			)
		);

		$this->add_control(
			'marker_icon',
			array(
				'label'   => esc_html__( 'Choose image', 'woodmart' ),
				'type'    => Controls_Manager::MEDIA,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'marker_icon',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$this->end_controls_section();

		/**
		 * Content settings.
		 */
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'   => esc_html__( 'Content type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'text'       => esc_html__( 'Text', 'woodmart' ),
					'html_block' => esc_html__( 'HTML Block', 'woodmart' ),
				),
				'default' => 'text',
			)
		);

		$this->add_control(
			'content',
			array(
				'label'       => esc_html__( 'Content', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => woodmart_get_elementor_html_blocks_array(),
				'description' => function_exists( 'woodmart_get_html_block_links' ) ? woodmart_get_html_block_links() : '',
				'default'     => '0',
				'condition'   => array(
					'content_type' => 'html_block',
				),
			)
		);

		$this->add_control(
			'text',
			array(
				'label'     => esc_html__( 'Text', 'woodmart' ),
				'type'      => Controls_Manager::WYSIWYG,
				'condition' => array(
					'content_type' => 'text',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_map_style',
			array(
				'label' => esc_attr__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'mask',
			array(
				'label'       => esc_html__( 'Map mask', 'woodmart' ),
				'description' => esc_html__( 'Add an overlay to your map to make the content look cleaner on the map.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__( 'Without', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
				),
				'default'     => '',
			)
		);

		$this->add_control(
			'zoom',
			array(
				'label'       => esc_html__( 'Zoom', 'woodmart' ),
				'description' => esc_html__( 'Zoom level when focus the marker 1 - 20', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'default'     => array(
					'size' => 15,
					'unit' => 'px',
				),
			)
		);

		$this->add_responsive_control(
			'height',
			array(
				'label'      => esc_html__( 'Map height', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 100,
						'max'  => 2000,
						'step' => 10,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 400,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wd-osm-map-container .wd-osm-map-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'zoom_control',
			array(
				'label'        => esc_html__( 'Zoom control', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'scroll_zoom',
			array(
				'label'        => esc_html__( 'Zoom with mouse wheel', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'pan_control',
			array(
				'label'        => esc_html__( 'Pan control', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'woodmart' ),
				'label_off'    => esc_html__( 'Off', 'woodmart' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'geoapify_tile',
			array(
				'label'   => esc_html__( 'Map style (Tile)', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'osm-carto',
				'options' => array(
					'osm-carto'         => esc_html__( 'OSM carto', 'woodmart' ),
					'stamen-toner'      => esc_html__( 'Stamen toner', 'woodmart' ),
					'stamen-terrain'    => esc_html__( 'Stamen terrain', 'woodmart' ),
					'stamen-watercolor' => esc_html__( 'Stamen watercolor', 'woodmart' ),
					'custom-tile'       => esc_html__( 'Custom map tile', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'geoapify_custom_tile',
			array(
				'label'       => esc_html__( 'Custom map tile URL', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'input_type'  => 'url',
				'description' => sprintf(
					__( 'You can find more Open Street Maps styles on the website: %1$s OpenStreetMap Wiki %2$s Just copy url and paste it here. For example: %4$s', 'woodmart' ),
					'<a target="_blank" href="https://wiki.openstreetmap.org/wiki/Raster_tile_providers">',
					'</a>',
					'<br>',
					'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png'
				),
				'condition'   => array(
					'geoapify_tile' => array( 'custom-tile' ),
				),
			)
		);

		$this->add_control(
			'osm_custom_attribution',
			array(
				'label'       => esc_html__( 'Attribution title', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'input_type'  => 'url',
				'placeholder' => 'Attribution Title',
				'condition'   => array(
					'geoapify_tile' => array( 'custom-tile' ),
				),
			)
		);

		$this->add_control(
			'osm_custom_attribution_url',
			array(
				'label'       => esc_html__( 'Attribution URL', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'input_type'  => 'url',
				'placeholder' => 'http://stamen.com',
				'condition'   => array(
					'geoapify_tile' => array( 'custom-tile' ),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Content settings.
		 */
		$this->start_controls_section(
			'content_style_section',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_horizontal',
			array(
				'label'   => esc_html__( 'Horizontal position', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/left.png',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/center.png',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/right.png',
					),
				),
				'default' => 'left',
			)
		);

		$this->add_control(
			'content_vertical',
			array(
				'label'   => esc_html__( 'Vertical position', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/top.png',
					),
					'middle' => array(
						'title' => esc_html__( 'Middle', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/middle.png',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/bottom.png',
					),
				),
				'default' => 'top',
			)
		);

		$this->add_responsive_control(
			'width',
			array(
				'label'          => esc_html__( 'Width', 'woodmart' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'size' => 300,
					'unit' => 'px',
				),
				'tablet_default' => array(
					'unit' => 'px',
				),
				'mobile_default' => array(
					'unit' => 'px',
				),
				'size_units'     => array( 'px' ),
				'range'          => array(
					'px' => array(
						'min'  => 100,
						'max'  => 2000,
						'step' => 10,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} .wd-osm-map-content' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Lazy loading settings.
		 */
		$this->start_controls_section(
			'lazy_loading_style_section',
			array(
				'label' => esc_html__( 'Lazy loading', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'init_type',
			array(
				'label'       => esc_html__( 'Init event', 'woodmart' ),
				'description' => esc_html__( 'For a better performance you can initialize the Open street map only when you scroll down the page or when you click on it.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'page_load'   => esc_html__( 'On page load', 'woodmart' ),
					'scroll'      => esc_html__( 'On scroll', 'woodmart' ),
					'button'      => esc_html__( 'On button click', 'woodmart' ),
					'interaction' => esc_html__( 'On user interaction', 'woodmart' ),
				),
				'default'     => 'page_load',
			)
		);

		$this->add_control(
			'init_offset',
			array(
				'label'       => esc_html__( 'Scroll offset', 'woodmart' ),
				'description' => esc_html__( 'Zoom level when focus the marker 0 - 19', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'size' => 100,
				),
				'size_units'  => '',
				'range'       => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 10,
					),
				),
				'condition'   => array(
					'init_type' => 'scroll',
				),
			)
		);

		$this->add_control(
			'map_init_placeholder',
			array(
				'label'     => esc_html__( 'Choose image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'init_type' => array( 'scroll', 'button', 'interaction' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'map_init_placeholder',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => array(
					'init_type' => array( 'scroll', 'button', 'interaction' ),
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
		$markers  = $this->get_settings_for_display( 'marker_list' );
		$coords   = $this->get_settings_coords( $markers );
		$settings = $this->get_settings_for_display();

		$map_settings = array_filter(
			array(
				'zoom'                       => isset( $settings['zoom']['size'] ) ? $settings['zoom']['size'] : '',
				'iconUrl'                    => ! empty( $settings['marker_icon']['url'] ) ? $settings['marker_icon']['url'] : WOODMART_IMAGES . '/icons/marker-icon.png',
				'iconSize'                   => ! empty( $settings['marker_icon']['url'] ) ? $this->get_settings_icon_size(
					$this->get_settings_for_display( 'marker_icon' ),
					$this->get_settings_for_display( 'marker_icon_size' ),
					$this->get_settings_for_display( 'marker_icon_custom_dimension' )
				) : '',
				'scrollWheelZoom'            => $settings['scroll_zoom'],
				'zoomControl'                => $settings['zoom_control'],
				'dragging'                   => $settings['pan_control'],
				'geoapify_tile'              => $settings['geoapify_tile'],
				'geoapify_custom_tile'       => $settings['geoapify_custom_tile'],
				'osm_custom_attribution'     => $settings['osm_custom_attribution'],
				'osm_custom_attribution_url' => $settings['osm_custom_attribution_url'],
				'markers'                    => $coords,
				'center'                     => ! empty( $coords ) ? implode( ',', woodmart_get_center_coords( $coords ) ) : '',
				'init_type'                  => $settings['init_type'],
				'init_offset'                => isset( $settings['init_offset']['size'] ) ? $settings['init_offset']['size'] : '',
			)
		);

		$this->add_render_attribute(
			array(
				'map_element_container' => array(
					'class' => array(
						'wd-osm-map-container',
						'wd-map-container',
					),
				),
				'map_element'           => array(
					'id'            => 'wd-osm-map-' . $this->get_id(),
					'class'         => array(
						'wd-osm-map-wrapper',
						'wd-map-wrapper',
					),
					'data-settings' => esc_attr( wp_json_encode( $map_settings ) ),
				),
				'content_wrapper'       => array(
					'class' => array(
						'container',
						'wd-osm-map-content-wrap',
						'wd-map-content-wrap',
						'wd-items-' . $settings['content_vertical'],
						'wd-justify-' . $settings['content_horizontal'],
						'wd-fill',
					),
				),
			)
		);

		if ( $settings['mask'] ) {
			$this->add_render_attribute( 'map_element_container', 'class', 'map-mask-' . $settings['mask'] );
		}

		if ( $settings['content'] || $settings['text'] ) {
			$this->add_render_attribute( 'map_element_container', 'class', 'map-container-with-content' );
		}

		if ( 'page_load' !== $settings['init_type'] ) {
			$this->add_render_attribute( 'map_element_container', 'class', 'map-lazy-loading' );
		}

		// Placeholder settings.
		if ( isset( $settings['map_init_placeholder']['id'] ) && $settings['map_init_placeholder']['id'] ) {
			$placeholder = woodmart_get_image_html( $settings, 'map_init_placeholder' );
		} else {
			$placeholder = '<img src="' . WOODMART_ASSETS_IMAGES . '/google-map-placeholder.jpg">';
		}

		woodmart_enqueue_inline_style( 'map' );
		woodmart_enqueue_inline_style( 'el-open-street-map' );

		woodmart_enqueue_js_library( 'leaflet' );
		woodmart_enqueue_js_script( 'open-street-map-element' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'map_element_container' ); // phpcs:ignore. ?>>
			<div <?php echo $this->get_render_attribute_string( 'map_element' ); // phpcs:ignore. ?>></div>

			<?php if ( 'page_load' !== $settings['init_type'] && $placeholder ) : ?>
				<div class="wd-map-placeholder wd-fill">
					<?php echo $placeholder; // phpcs:ignore.?>
				</div>
			<?php endif ?>

			<?php if ( 'button' === $settings['init_type'] ) : ?>
				<div class="wd-init-map-wrap wd-fill">
					<a href="#" rel="nofollow" class="btn btn-color-white wd-init-map">
						<span><?php esc_attr_e( 'Show map', 'woodmart' ); ?></span>
					</a>
				</div>
			<?php endif ?>

			<?php if ( $settings['content'] || $settings['text'] ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'content_wrapper' ); // phpcs:ignore. ?>>
					<div class="wd-osm-map-content wd-map-content reset-last-child">
						<?php if ( 'html_block' === $settings['content_type'] ) : ?>
							<?php echo woodmart_get_html_block( $settings['content'] ); // phpcs:ignore ?>
						<?php else : ?>
							<?php echo wpautop( do_shortcode( $settings['text'] ) ); // phpcs:ignore. ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif ?>
		</div>
		<?php
	}

	/**
	 * This method accepts a list of markers and returns a prepared array of coordinates.
	 * If the token list is empty, the method will return an empty array.
	 *
	 * @param array $markers List of markers.
	 * @return array|string Return array with coords or empty string.
	 */
	private function get_settings_coords( $markers ) {
		if ( empty( $markers ) && ! is_array( $markers ) ) {
			return '';
		}

		$coords = array();

		foreach ( $markers as $marker ) {
			$marker['image_size'] = $this->get_settings_icon_size( $marker['image'], $marker['image_size'], $marker['image_custom_dimension'] );

			$loc = explode( ',', $marker['marker_coords'] );

			if ( ! empty( $loc ) && 2 === count( $loc ) ) {
				$coords[] = array(
					'marker' => $marker,
					'lat'    => $loc[0],
					'lng'    => $loc[1],
				);
			}
		}

		return $coords;
	}

	/**
	 * This method takes the values of two Group_Control_Image_Size options and casts them into a single view.
	 * Returns a simple array: [ '120px', '60px' ];
	 *
	 * @param array $icon An array with the icon parameters: [ 'url' => ..., 'id' => ..., ].
	 * @param array $default_size An array with the names of the registered sizes: [ 'thumbnail', 'medium' ... ].
	 * @param array $dimension_size An array with a custom size: [ 'width': '120px', 'height': '60px' ].
	 * @return array Simple array [ '120px', '60px' ].
	 */
	private function get_settings_icon_size( $icon, $default_size, $dimension_size ) {
		$icon_size = array();

		if ( 'full' === $default_size || ( 'custom' === $default_size && empty( $dimension_size['width'] ) && empty( $dimension_size['height'] ) ) ) {
			$attachment_image_src = wp_get_attachment_image_src( $icon['id'], 'full' );

			if ( ! $attachment_image_src ) {
				return $icon_size;
			}

			$icon_size = array(
				$attachment_image_src[1],
				$attachment_image_src[2],
			);
		} elseif ( 'custom' !== $default_size && ! empty( Group_Control_Image_Size::get_all_image_sizes()[ $default_size ] ) ) {
			$icon_size = array_values( Group_Control_Image_Size::get_all_image_sizes()[ $default_size ] );
		} elseif ( $dimension_size['width'] || $dimension_size['height'] ) {
			$icon_size = array(
				$dimension_size['width'],
				$dimension_size['height'],
			);
		}

		if ( ! empty( $icon_size[0] ) && empty( $icon_size[1] ) ) {
			$icon_size[1] = $icon_size[0];
		}

		if ( ! empty( $icon_size[1] ) && empty( $icon_size[0] ) ) {
			$icon_size[0] = $icon_size[1];
		}

		return $icon_size;
	}
}

Plugin::instance()->widgets_manager->register( new Open_Street_Map() );
