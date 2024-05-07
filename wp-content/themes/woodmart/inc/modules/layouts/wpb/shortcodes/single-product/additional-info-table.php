<?php
/**
 * Additional info table shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Global_Data as Builder;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_additional_info_table' ) ) {
	/**
	 * Additional info table shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_additional_info_table( $settings ) {
		$default_settings = array(
			'layout'           => 'list',
			'style'            => 'bordered',
			'css'              => '',
			'include'          => array(),
			'exclude'          => array(),

			'icon_type'        => 'without',
			'image'            => '',
			'img_size'         => '',
			'title'            => '',

			'icon_library'     => 'fontawesome',
			'icon_fontawesome' => 'far fa-bell',
			'icon_openiconic'  => 'vc-oi vc-oi-dial',
			'icon_typicons'    => 'typcn typcn-adjust-brightness',
			'icon_entypo'      => 'entypo-icon entypo-icon-note',
			'icon_linecons'    => 'vc_li vc_li-heart',
			'icon_monosocial'  => 'vc-mono vc-mono-fivehundredpx',
			'icon_material'    => 'vc-material vc-material-cake',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );
		$icon_class      = 'title-icon';
		$heading_output  = '';

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( $settings['title'] ) {
			if ( 'icon' === $settings['icon_type'] ) {
				$icon_class    .= ' ' . $settings[ 'icon_' . $settings['icon_library'] ];
				$heading_output = '<span class="' . esc_attr( $icon_class ) . '"></span>';

				if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && $settings[ 'icon_' . $settings['icon_library'] ] ) {
					vc_icon_element_fonts_enqueue( $settings['icon_library'] );
				}
			} else if ( 'image' === $settings['icon_type'] && ! empty( $settings['image'] ) && function_exists( 'wpb_getImageBySize' ) ) {
				if ( woodmart_is_svg( wp_get_attachment_image_url( $settings['image'] ) ) ) {
					$icon_output = woodmart_get_svg_html(
						$settings['image'],
						$settings['img_size']
					);
				} else {
					$icon_output = wpb_getImageBySize(
						array(
							'attach_id'  => $settings['image'],
							'thumb_size' => $settings['img_size'],
						)
					)['thumbnail'];
				}

				$heading_output = '<span class="' . esc_attr( $icon_class ) . '">' . $icon_output . '</span>';
			}

		$heading_output = '<h4 class="title element-title">' . $heading_output . '<span class="title-text">' . $settings['title'] . '</span></h4>';
		}

		$wrapper_classes .= ' wd-layout-' . $settings['layout'];
		$wrapper_classes .= ' wd-style-' . $settings['style'];

		if ( $settings['include'] ) {
			$settings['include'] = explode( ', ', $settings['include'] );
		}

		if ( $settings['exclude'] ) {
			$settings['exclude'] = explode( ', ', $settings['exclude'] );
		}

		ob_start();

		Main::setup_preview();

		global $product;

		$display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() );
		$attributes         = array_keys( array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' ) );

		if ( $display_dimensions && $product->has_weight() ) {
			$attributes[] = 'weight';
		}

		if ( $display_dimensions && $product->has_dimensions() ) {
			$attributes[] = 'dimensions';
		}

		if ( $settings['include'] ) {
			if ( $settings['include'] === $settings['exclude'] || ! array_intersect( $attributes, $settings['include'] ) ) {
				Main::restore_preview();
				ob_clean();
				return '';
			}

			Builder::get_instance()->set_data( 'wd_product_attributes_include', $settings['include'] );
		}

		if ( $settings['exclude'] ) {
			if ( ! array_diff( $attributes, $settings['exclude'] ) ) {
				Builder::get_instance()->set_data( 'wd_product_attributes_include', array() );
				Main::restore_preview();
				ob_clean();
				return '';
			}

			Builder::get_instance()->set_data( 'wd_product_attributes_exclude', $settings['exclude'] );
		}

		?>
		<div class="wd-single-attrs wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>"><?php echo $heading_output ? $heading_output : ''; //phpcs:ignore ?><?php do_action( 'woocommerce_product_additional_information', $product ); // Must be in one line. ?></div>
		<?php

		Main::restore_preview();

		Builder::get_instance()->set_data( 'wd_product_attributes_include', array() );
		Builder::get_instance()->set_data( 'wd_product_attributes_exclude', array() );

		return ob_get_clean();
	}
}
