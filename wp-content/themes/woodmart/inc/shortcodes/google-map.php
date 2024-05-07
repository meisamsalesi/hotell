<?php
/***
 * Google map shortcodes file.
 *
 * @package Shortcode.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_settings_coords_for_google_map' ) ) {
	/**
	 * This method accepts a list of markers and returns a prepared array of coordinates.
	 * If the token list is empty, the method will return an empty array.
	 *
	 * @param array $markers List of markers.
	 * @return array|string Return array with coords or empty string.
	 */
	function woodmart_get_settings_coords_for_google_map( $markers ) {
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
}

/**
* ------------------------------------------------------------------------------------------------
* Google Map shortcode
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_google_map' ) ) {
	/***
	 * Render tabs shortcode.
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content Inner shortcode.
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_google_map( $atts, $content ) {
		$el_class = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );
		$output   = '';

		if ( isset( $atts['multiple_markers'] ) && 'yes' === $atts['multiple_markers'] ) {
			$markers = array_map(
				function ( $marker ) {
					$marker = shortcode_atts(
						array(
							'marker_title'       => '',
							'marker_lat'         => 51.50735,
							'marker_lon'         => -0.12776,
							'marker_description' => '',
							'image'              => '',
							'image_size'         => 'thumbnail',
						),
						$marker
					);

					if ( is_numeric( $marker['image'] ) ) {
						$thumb_size = woodmart_get_image_size( $marker['image_size'] );
						$thumbnail  = wpb_resize( $marker['image'], null, $thumb_size[0], $thumb_size[1], true );

						$marker[ 'marker_icon' ]      = isset( $thumbnail['url'] ) ? $thumbnail['url'] : '';
						$marker[ 'marker_icon_size' ] = array( $thumbnail['width'], $thumbnail['height'] );
					}

					return $marker;
				},
				vc_param_group_parse_atts( $atts['marker_list'] )
			);

			$coords = woodmart_get_settings_coords_for_google_map( $markers );
		}

		$parsed_atts = shortcode_atts(
			array(
				'multiple_markers'          => 'no',
				'title'                     => '',
				'lat'                       => 51.50735,
				'lon'                       => -0.12776,
				'style_json'                => '',
				'zoom'                      => 15,
				'height'                    => 400,
				'new_height'                => '',
				'scroll'                    => 'no',
				'mask'                      => '',
				'marker_text'               => '',
				'marker_content'            => '',
				'content_vertical'          => 'top',
				'content_horizontal'        => 'left',
				'content_width'             => 300,
				'google_key'                => woodmart_get_opt( 'google_map_api_key' ),
				'marker_icon'               => '',
				'marker_icon_size'          => 'thumbnail',
				'css_animation'             => 'none',
				'el_class'                  => '',

				'init_type'                 => 'page_load',
				'init_offset'               => '100',
				'map_init_placeholder'      => '',
				'map_init_placeholder_size' => '',

				'woodmart_css_id'           => '',
				'css'                       => '',
			),
			$atts
		);

		extract( $parsed_atts );

		if ( ! $woodmart_css_id ) {
			$woodmart_css_id = uniqid();
		}

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$el_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$minified = woodmart_is_minified_needed() ? '.min' : '';
		$version  = woodmart_get_theme_info( 'Version' );

		wp_enqueue_script( 'wd-google-map-api', 'https://maps.google.com/maps/api/js?libraries=geometry&callback=woodmartThemeModule.googleMapsCallback&v=weekly&key=' . $google_key, array(), $version, true );
		wp_enqueue_script( 'wd-maplace', WOODMART_THEME_DIR . '/js/libs/maplace' . $minified . '.js', array( 'wd-google-map-api' ), $version, true );

		woodmart_enqueue_js_script( 'google-map-element' );

		$content_wrapper_classes = '';

		$content_wrapper_classes .= ' wd-items-' . $content_vertical;
		$content_wrapper_classes .= ' wd-justify-' . $content_horizontal;
		$el_class                .= woodmart_get_css_animation( $css_animation );

		if ( $mask ) {
			$el_class .= ' map-mask-' . $mask;
		}

		if ( $content ) {
			$el_class .= ' map-container-with-content';
		}

		if ( 'page_load' !== $init_type ) {
			$el_class .= ' map-lazy-loading';
		}

		$uniqid = uniqid();

		$map_args = array(
			'multiple_markers'   => $multiple_markers,
			'latitude'           => $lat,
			'longitude'          => $lon,
			'zoom'               => $zoom,
			'mouse_zoom'         => $scroll,
			'init_type'          => $init_type,
			'init_offset'        => $init_offset,
			'elementor'          => false,
			'json_style'         => rawurldecode( woodmart_decompress( $style_json ) ),
			'marker_icon'        => WOODMART_ASSETS_IMAGES . '/google-icon.png',
			'marker_icon_size'   => '',
			'marker_text_needed' => $marker_text || $title ? 'yes' : 'no',
			'marker_text'        => '<h3 style="min-width:300px; text-align:center; margin:15px;">' . $title . '</h3>' . esc_html( $marker_text ),
			'selector'           => 'wd-map-id-' . $uniqid,
			'markers'            => ! empty( $markers ) ? $markers : '',
			'center'             => ! empty( $coords ) ? implode( ',', woodmart_get_center_coords( $coords ) ) : '',
		);

		if ( $marker_icon ) {
			$thumb_size = woodmart_get_image_size( $marker_icon_size );
			$thumbnail  = wpb_resize( $marker_icon, null, $thumb_size[0], $thumb_size[1], true );

			$map_args[ 'marker_icon' ]      = isset( $thumbnail['url'] ) ? $thumbnail['url'] : '';
			$map_args[ 'marker_icon_size' ] = array( $thumbnail['width'], $thumbnail['height'] );
		}

		$image_id   = $map_init_placeholder;
		$image_size = 'full';

		if ( $map_init_placeholder_size ) {
			$image_size = $map_init_placeholder_size;
		}

		$placeholder = '<img src="' . WOODMART_ASSETS_IMAGES . '/google-map-placeholder.jpg">';

		if ( $image_id ) {
			$placeholder = wpb_getImageBySize(
				array(
					'attach_id'  => $image_id,
					'thumb_size' => $image_size,
				)
			)['thumbnail'];
		}

		$style_attr = ! $new_height && 0 < $height ? 'style="height: ' . esc_attr( $height ) . 'px"' : '';
		$el_class  .= ' wd-rs-' . $woodmart_css_id;
		ob_start();

		woodmart_enqueue_inline_style( 'map' );
		woodmart_enqueue_inline_style( 'el-google-map' );

		?>
			<div class="google-map-container wd-map-container <?php echo esc_attr( $el_class ); ?>" <?php echo $style_attr; ?> data-map-args='<?php echo wp_json_encode( $map_args ); ?>'>

				<?php if ( 'page_load' !== $init_type && $placeholder ) : ?>
					<div class="wd-map-placeholder wd-fill">
						<?php echo $placeholder; // phpcs:ignore. ?>
					</div>
				<?php endif ?>

				<?php if ( 'button' === $init_type ) : ?>
					<div class="wd-init-map-wrap wd-fill">
						<a href="#" rel="nofollow noopener" class="btn btn-color-white wd-init-map">
							<span><?php esc_attr_e( 'Show map', 'woodmart' ); ?></span>
						</a>
					</div>
				<?php endif ?>

				<div class="wd-google-map-wrapper wd-map-wrapper wd-fill">
					<div id="wd-map-id-<?php echo esc_attr( $uniqid ); ?>" class="wd-google-map without-content wd-fill"></div>
				</div>

				<?php if ( $content ) : ?>
					<div class="wd-google-map-content-wrap wd-map-content-wrap container<?php echo esc_attr( $content_wrapper_classes ); ?>">
						<div class="wd-google-map-content wd-map-content reset-last-child" style="max-width: <?php echo esc_attr( $content_width ); ?>px;">
							<?php echo do_shortcode( $content ); ?>
						</div>
					</div>
				<?php endif ?>
			</div>
		<?php

		return ob_get_clean();
	}
}
