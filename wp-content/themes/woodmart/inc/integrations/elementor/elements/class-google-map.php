<?php
/**
 * Google map map.
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
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
class Google_Map extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_google_map';
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
		return esc_html__( 'Google map', 'woodmart' );
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
		return 'wd-icon-google-map';
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
			'marker_lat',
			array(
				'label'       => esc_html__( 'Latitude (required)', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'description' => 'You can use <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">this service</a> to get coordinates of your location.',
				'default'     => '51.50735',
			)
		);

		$repeater->add_control(
			'marker_lon',
			array(
				'label'   => esc_html__( 'Longitude (required)', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '-0.12776',
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

		/**
		 * Content tab.
		 */

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
			'google_key',
			array(
				'label'       => esc_html__( 'Google API key', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'description' => 'Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google map VC element.',
			)
		);

		$this->add_control(
			'multiple_markers',
			array(
				'label'        => esc_html__( 'Multiple markers', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'lat',
			array(
				'label'       => esc_html__( 'Latitude (required)', 'woodmart' ),
				'type'        => Controls_Manager::TEXT,
				'description' => 'You can use <a href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm" target="_blank">this service</a> to get coordinates of your location.',
				'default'     => '51.50735',
				'condition'   => array(
					'multiple_markers!' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'lon',
			array(
				'label'     => esc_html__( 'Longitude (required)', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '-0.12776',
				'condition' => array(
					'multiple_markers!' => array( 'yes' ),
				),
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
				'condition'   => array(
					'multiple_markers' => array( 'yes' ),
				),
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
				'label' => esc_html__( 'Choose image', 'woodmart' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'marker_icon',
				'default'   => 'thumbnail',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'title',
			array(
				'label'     => esc_html__( 'Title', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'multiple_markers!' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'marker_text',
			array(
				'label'     => esc_html__( 'Text', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'multiple_markers!' => array( 'yes' ),
				),
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

		/**
		 * Style tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
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
				'description' => esc_html__( 'Zoom level when focus the marker 0 - 19', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'size' => 15,
				),
				'size_units'  => '',
				'range'       => array(
					'px' => array(
						'min'  => 0,
						'max'  => 19,
						'step' => 1,
					),
				),
			)
		);

		$this->add_responsive_control(
			'height',
			array(
				'label'          => esc_html__( 'Map height', 'woodmart' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'size' => '400',
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
					'{{WRAPPER}} .google-map-container' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'scroll',
			array(
				'label'        => esc_html__( 'Zoom with mouse wheel', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'style_json',
			array(
				'label'       => esc_html__( 'Styles (JSON)', 'woodmart' ),
				'type'        => 'wd_google_json',
				'description' => sprintf(
					__( 'Styled maps allow you to customize the presentation of the standard Google base maps, changing the visual display of such elements as roads, parks, and built-up areas.%3$s You can find more Google maps styles on the website: %1$s Snazzy Maps %2$s 3$s Just copy JSON code and paste it here.', 'woodmart' ),
					'<a target="_blank" href="https://snazzymaps.com/">',
					'</a>',
					'<br>'
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
					'{{WRAPPER}} .wd-google-map-content' => 'max-width: {{SIZE}}{{UNIT}};',
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
				'description' => esc_html__( 'For a better performance you can initialize the Google map only when you scroll down the page or when you click on it.', 'woodmart' ),
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
		$markers = $this->get_settings_for_display( 'marker_list' );
		$coords  = $this->get_settings_coords( $markers );

		$default_settings = array(
			'title'                     => '',
			'lat'                       => 45.9,
			'lon'                       => 10.9,
			'style_json'                => '',
			'zoom'                      => 15,
			'height'                    => 400,
			'scroll'                    => 'no',
			'mask'                      => '',
			'marker_text'               => '',
			'marker_content'            => '',
			'content_vertical'          => 'top',
			'content_horizontal'        => 'left',
			'content_width'             => 300,
			'google_key'                => woodmart_get_opt( 'google_map_api_key' ),
			'marker_icon'               => '',
			'multiple_markers'          => 'no',

			'init_type'                 => 'page_load',
			'init_offset'               => '100',
			'map_init_placeholder'      => '',
			'map_init_placeholder_size' => '',
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );
		$uniqid   = uniqid();
		$minified = woodmart_is_minified_needed() ? '.min' : '';
		$version  = woodmart_get_theme_info( 'Version' );

		wp_enqueue_script( 'wd-google-map-api', 'https://maps.google.com/maps/api/js?libraries=geometry&callback=woodmartThemeModule.googleMapsCallback&v=weekly&key=' . $settings['google_key'], array( 'woodmart-theme' ), $version, true );
		wp_enqueue_script( 'wd-maplace', WOODMART_THEME_DIR . '/js/libs/maplace' . $minified . '.js', array( 'wd-google-map-api' ), $version, true );

		woodmart_enqueue_js_script( 'google-map-element' );

		$this->add_render_attribute(
			array(
				'content_wrapper' => array(
					'class' => array(
						'container',
						'wd-google-map-content-wrap',
						'wd-map-content-wrap',
						'wd-items-' . $settings['content_vertical'],
						'wd-justify-' . $settings['content_horizontal'],
					),
				),
			)
		);

		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class' => array(
						'google-map-container',
						'wd-map-container',
					),
				),
			)
		);

		if ( $settings['mask'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'map-mask-' . $settings['mask'] );
		}
		if ( 'page_load' !== $settings['init_type'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'map-lazy-loading' );
		}
		if ( $settings['content'] || $settings['text'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'map-container-with-content' );
		}

		// Image settings.
		if ( is_array( $markers ) && ! empty( $markers ) ) {
			foreach ( $markers as $marker_key => $marker ) {
				if ( isset( $marker['image']['id'] ) && $marker['image']['id'] ) {
					$markers[ $marker_key ]['marker_icon']      = woodmart_get_image_url( $marker['image']['id'], 'image', $marker );
					$markers[ $marker_key ]['marker_icon_size'] = $this->get_settings_icon_size( $marker['image'], $marker['image_size'], $marker['image_custom_dimension'] );
				}

				unset(
					$markers[ $marker_key ]['image'],
					$markers[ $marker_key ]['image_size'],
					$markers[ $marker_key ]['image_custom_dimension']
				);
			}
		}

		if ( isset( $settings['marker_icon']['id'] ) && $settings['marker_icon']['id'] ) {
			$marker_icon = woodmart_get_image_url( $settings['marker_icon']['id'], 'marker_icon', $settings );
		} else {
			$marker_icon = WOODMART_ASSETS_IMAGES . '/google-icon.png';
		}

		$map_args = array(
			'multiple_markers'   => $settings['multiple_markers'],
			'latitude'           => $settings['lat'],
			'longitude'          => $settings['lon'],
			'zoom'               => $settings['zoom']['size'],
			'mouse_zoom'         => $settings['scroll'],
			'init_type'          => $settings['init_type'],
			'init_offset'        => isset( $settings['init_offset']['size'] ) ? $settings['init_offset']['size'] : '',
			'json_style'         => $settings['style_json'],
			'marker_icon'        => $marker_icon,
			'marker_icon_size'   => '',
			'elementor'          => true,
			'marker_text_needed' => $settings['marker_text'] || $settings['title'] ? 'yes' : 'no',
			'marker_text'        => '<h3 style="min-width:300px; text-align:center; margin:15px;">' . $settings['title'] . '</h3>' . esc_html( $settings['marker_text'] ),
			'selector'           => 'wd-map-id-' . $uniqid,
			'markers'            => $markers,
			'center'             => ! empty( $coords ) ? implode( ',', woodmart_get_center_coords( $coords ) ) : '',
		);

		if ( ! empty( $settings['marker_icon']['id'] ) ) {
			$map_args[ 'marker_icon_size' ] = $this->get_settings_icon_size( $settings['marker_icon'], $settings['marker_icon_size'], $settings['marker_icon_custom_dimension'] );
		}

		// Placeholder settings.
		if ( isset( $settings['map_init_placeholder']['id'] ) && $settings['map_init_placeholder']['id'] ) {
			$placeholder = $image_output = woodmart_get_image_html( $settings, 'map_init_placeholder' );
		} else {
			$placeholder = '<img src="' . WOODMART_ASSETS_IMAGES . '/google-map-placeholder.jpg">';
		}

		woodmart_enqueue_inline_style( 'map' );
		woodmart_enqueue_inline_style( 'el-google-map' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> data-map-args='<?php echo wp_json_encode( $map_args ); ?>'>

			<?php if ( 'page_load' !== $settings['init_type'] && $placeholder ) : ?>
				<div class="wd-map-placeholder wd-fill">
					<?php echo $placeholder; //phpcs:ignore. ?>
				</div>
			<?php endif ?>

			<?php if ( 'button' === $settings['init_type'] ) : ?>
				<div class="wd-init-map-wrap wd-fill">
					<a href="#" rel="nofollow" class="btn btn-color-white wd-init-map">
						<span><?php esc_attr_e( 'Show map', 'woodmart' ); ?></span>
					</a>
				</div>
			<?php endif ?>

			<div class="wd-google-map-wrapper wd-map-wrapper wd-fill">
				<div id="wd-map-id-<?php echo esc_attr( $uniqid ); ?>" class="wd-google-map without-content wd-fill"></div>
			</div>

			<?php if ( $settings['content'] || $settings['text'] ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'content_wrapper' ); ?>>
					<div class="wd-google-map-content wd-map-content reset-last-child">
						<?php if ( 'html_block' === $settings['content_type'] ) : ?>
							<?php echo woodmart_get_html_block( $settings['content'] ); // phpcs:ignore ?>
						<?php else : ?>
							<?php echo wpautop( do_shortcode( $settings['text'] ) ); ?>
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
			if ( empty( $marker['marker_lat'] ) || empty( $marker['marker_lon'] ) ) {
				continue;
			}

			$coords[] = array(
				'lat' => $marker['marker_lat'],
				'lng' => $marker['marker_lon'],
			);
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

Plugin::instance()->widgets_manager->register( new Google_Map() );
