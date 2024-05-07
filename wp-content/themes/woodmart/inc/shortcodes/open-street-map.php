<?php
/***
 * Open street map shortcodes file.
 *
 * @package Shortcode.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_settings_coords_for_open_street_map' ) ) {
	/**
	 * This method accepts a list of markers and returns a prepared array of coordinates.
	 * If the token list is empty, the method will return an empty array.
	 *
	 * @param array $markers List of markers.
	 * @return array|string Return array with coords or empty string.
	 */
	function woodmart_get_settings_coords_for_open_street_map( $markers ) {
		if ( empty( $markers ) && ! is_array( $markers ) ) {
			return '';
		}

		$coords = array();

		foreach ( $markers as $marker ) {
			$marker['image']      = isset( $marker['image'] ) && is_numeric( $marker['image'] ) ? wp_get_attachment_image_url( $marker['image'] ) : '';
			$marker['image_size'] = 'full' === $marker['image_size'] ? array() : woodmart_get_image_size( $marker['image_size'] );

			$loc = ! empty( $marker['marker_coords'] ) ? explode( ',', $marker['marker_coords'] ) : '';

			if ( ! empty( $loc ) && 2 === count( $loc ) ) {
				$coords[] = array(
					'marker' => $marker,
					'lat'    => $loc[0],
					'lng'    => $loc[1],
				);
			} else {
				$coords[] = array(
					'marker' => $marker,
					'lat'    => '51.50735',
					'lng'    => '-0.12776',
				);
			}
		}

		return $coords;
	}
}

if ( ! function_exists( 'woodmart_shortcode_open_street_map' ) ) {
	/***
	 * Render tabs shortcode.
	 *
	 * @param array  $attr Shortcode attributes.
	 * @param string $content Inner content (shortcode).
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_open_street_map( $attr, $content ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $attr );

		$attr = shortcode_atts(
			array(
				'woodmart_css_id'            => '',
				'zoom'                       => '',
				'zoom_control'               => 'yes',
				'scroll_zoom'                => 'yes',
				'pan_control'                => 'yes',
				'marker_list'                => '',
				'show_button'                => 'no',
				'button_text'                => '',
				'button_url'                 => '',
				'button_url_target'          => '_blank',
				'marker_icon'                => WOODMART_IMAGES . '/icons/marker-icon.png',
				'marker_icon_size'           => 'full',
				'geoapify_tile'              => 'osm-carto',
				'geoapify_custom_tile'       => '',
				'osm_custom_attribution'     => '',
				'osm_custom_attribution_url' => '',
				'mask'                       => '',
				'el_class'                   => '',
				'css_animation'              => 'none',
				'content_vertical'           => 'top',
				'content_horizontal'         => 'left',
				'content_width'              => 300,

				'init_type'                  => 'page_load',
				'init_offset'                => '100',
				'map_init_placeholder'       => '',
				'map_init_placeholder_size'  => '',

				'css'                        => '',
			),
			$attr
		);

		$map_id  = 'wd-rs-' . $attr['woodmart_css_id'];
		$markers = vc_param_group_parse_atts( $attr['marker_list'] );
		$coords  = woodmart_get_settings_coords_for_open_street_map( $markers );
		$zoom    = json_decode( woodmart_decompress( $attr['zoom'] ), true );

		$wrapper_classes .= ! empty( $attr['el_class'] ) ? ' ' . $attr['el_class'] : '';
		$wrapper_classes .= woodmart_get_css_animation( $attr['css_animation'] );
		$wrapper_classes .= $content ? ' map-container-with-content' : '';
		$wrapper_classes .= 'page_load' !== $attr['init_type'] ? ' map-lazy-loading' : '';
		$wrapper_classes .= ! empty( $attr['mask'] ) ? ' map-mask-' . $attr['mask'] : '';

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $attr['css'] );
		}

		$content_wrapper_classes  = ' wd-items-' . $attr['content_vertical'];
		$content_wrapper_classes .= ' wd-justify-' . $attr['content_horizontal'];

		$placeholder = '<img src="' . WOODMART_ASSETS_IMAGES . '/google-map-placeholder.jpg">';

		if ( ! empty( $attr['map_init_placeholder'] ) ) {
			$placeholder = wpb_getImageBySize(
				array(
					'attach_id'  => $attr['map_init_placeholder'],
					'thumb_size' => ! empty( $attr['map_init_placeholder_size'] ) ? $attr['map_init_placeholder_size'] : 'full',
				)
			)['thumbnail'];
		}

		$map_settings = array_filter(
			array(
				'zoom'                       => isset( $zoom['devices']['desktop']['value'] ) ? $zoom['devices']['desktop']['value'] : '',
				'iconUrl'                    => is_numeric( $attr['marker_icon'] ) ? wp_get_attachment_image_url( $attr['marker_icon'] ) : $attr['marker_icon'],
				'iconSize'                   => 'full' === $attr['marker_icon_size'] ? array() : woodmart_get_image_size( $attr['marker_icon_size'] ),
				'scrollWheelZoom'            => $attr['scroll_zoom'],
				'zoomControl'                => $attr['zoom_control'],
				'dragging'                   => $attr['pan_control'],
				'geoapify_tile'              => $attr['geoapify_tile'],
				'geoapify_custom_tile'       => $attr['geoapify_custom_tile'],
				'osm_custom_attribution'     => $attr['osm_custom_attribution'],
				'osm_custom_attribution_url' => $attr['osm_custom_attribution_url'],
				'markers'                    => $coords,
				'center'                     => ! empty( $coords ) ? implode( ',', woodmart_get_center_coords( $coords ) ) : '',
				'init_type'                  => $attr['init_type'],
				'init_offset'                => $attr['init_offset'],
			)
		);

		ob_start();

		woodmart_enqueue_inline_style( 'map' );
		woodmart_enqueue_inline_style( 'el-open-street-map' );

		woodmart_enqueue_js_library( 'leaflet' );
		woodmart_enqueue_js_script( 'open-street-map-element' );
		?>
		<div class="wd-osm-map-container wd-map-container<?php echo esc_attr( $wrapper_classes ); ?>">
			<div id="<?php echo esc_attr( $map_id ); ?>" class="wd-osm-map-wrapper wd-map-wrapper" data-settings="<?php echo esc_attr( wp_json_encode( $map_settings ) ); ?>"></div>

			<?php if ( 'page_load' !== $attr['init_type'] ) : ?>
				<div class="wd-map-placeholder wd-fill">
					<?php echo $placeholder; // phpcs:ignore. ?>
				</div>
			<?php endif ?>

			<?php if ( 'button' === $attr['init_type'] ) : ?>
				<div class="wd-init-map-wrap wd-fill">
					<a href="#" rel="nofollow noopener" class="btn btn-color-white wd-init-map">
						<span><?php esc_attr_e( 'Show map', 'woodmart' ); ?></span>
					</a>
				</div>
			<?php endif ?>

			<?php if ( $content ) : ?>
				<div class="wd-osm-map-content-wrap wd-map-content-wrap container<?php echo esc_attr( $content_wrapper_classes ); ?> wd-fill">
					<div class="wd-osm-map-content wd-map-content reset-last-child" style="max-width: <?php echo esc_attr( $attr['content_width'] ); ?>px;">
						<?php echo do_shortcode( $content ); ?>
					</div>
				</div>
			<?php endif ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
