<?php
/**
 * Register vc elements maps.
 *
 * @package Woodmart
 */

if ( ! function_exists( 'woodmart_vc_register_maps' ) ) {
	function woodmart_vc_register_maps() {
		if ( ! woodmart_is_core_installed() ) {
			return;
		}

		$maps = array(
			'woodmart_3d_view'                   => 'woodmart_get_vc_map_3d_view',
			'woodmart_accordion'                 => 'woodmart_get_vc_map_accordion',
			'woodmart_accordion_item'            => 'woodmart_get_vc_map_accordion_item',
			'products_tabs'                      => 'woodmart_get_vc_map_products_tabs',
			'products_tab'                       => 'woodmart_get_vc_map_products_tab',
			'woodmart_ajax_search'               => 'woodmart_get_vc_map_ajax_search',
			'woodmart_counter'                   => 'woodmart_get_vc_map_animated_counter',
			'author_area'                        => 'woodmart_get_vc_map_author_area',
			'banners_carousel'                   => 'woodmart_get_vc_map_banners_carousel',
			'woodmart_blog'                      => 'woodmart_get_vc_map_blog',
			'woodmart_brands'                    => 'woodmart_get_vc_map_brands',
			'woodmart_button'                    => 'woodmart_get_woodmart_button_shortcode_args',
			'woodmart_compare'                   => 'woodmart_get_vc_shortcode_compare',
			'woodmart_countdown_timer'           => 'woodmart_get_vc_map_countdown_timer',
			'extra_menu'                         => 'woodmart_get_vc_map_extra_menu',
			'extra_menu_list'                    => 'woodmart_get_vc_map_extra_menu_list',
			'woodmart_google_map'                => 'woodmart_get_vc_map_google_map',
			'html_block'                         => 'woodmart_get_vc_map_html_block',
			'woodmart_image'                     => 'woodmart_get_vc_map_image',
			'woodmart_image_hotspot'             => 'woodmart_get_vc_map_image_hotspot',
			'woodmart_hotspot'                   => 'woodmart_get_vc_map_hotspot',
			'woodmart_gallery'                   => 'woodmart_get_vc_map_gallery',
			'woodmart_info_box'                  => 'woodmart_get_woodmart_info_box_shortcode_args',
			'woodmart_info_box_carousel'         => 'woodmart_get_vc_map_info_box_carousel',
			'woodmart_instagram'                 => 'woodmart_get_vc_map_instagram',
			'woodmart_list'                      => 'woodmart_get_vc_map_list',
			'woodmart_mailchimp'                 => 'woodmart_get_vc_map_mailchimp',
			'woodmart_mega_menu'                 => 'woodmart_get_vc_map_mega_menu',
			'woodmart_menu_price'                => 'woodmart_get_vc_map_menu_price',
			'woodmart_off_canvas_btn'            => 'woodmart_get_vc_map_off_canvas_btn',
			'woodmart_open_street_map'           => 'woodmart_get_vc_map_open_street_map',
			'woodmart_popup'                     => 'woodmart_get_vc_map_popup',
			'woodmart_portfolio'                 => 'woodmart_get_vc_map_portfolio',
			'pricing_tables'                     => 'woodmart_get_vc_map_pricing_tables',
			'pricing_plan'                       => 'woodmart_get_vc_map_pricing_plan',
			'woodmart_categories'                => 'woodmart_get_vc_shortcode_categories',
			'woodmart_product_filters'           => 'woodmart_get_vc_map_product_filters',
			'woodmart_products'                  => 'woodmart_get_products_shortcode_map_params',
			'woodmart_filter_categories'         => 'woodmart_get_vc_map_filter_categories',
			'woodmart_filters_attribute'         => 'woodmart_get_vc_map_filters_attribute',
			'woodmart_stock_status'              => 'woodmart_get_vc_map_stock_status',
			'woodmart_filters_price_slider'      => 'woodmart_get_vc_map_filters_price_slider',
			'woodmart_filters_orderby'           => 'woodmart_get_vc_map_filters_orderby',
			'promo_banner'                       => 'woodmart_get_vc_map_promo_banner',
			'woodmart_responsive_text_block'     => 'woodmart_get_vc_map_responsive_text_block',
			'woodmart_row_divider'               => 'woodmart_get_vc_map_row_divider',
			'woodmart_sidebar'                   => 'woodmart_get_vc_map_sidebar',
			'woodmart_size_guide'                => 'woodmart_get_vc_map_size_guide',
			'woodmart_slider'                    => 'woodmart_get_vc_map_slider',
			'social_buttons'                     => 'woodmart_get_social_buttons_shortcode_args',
			'woodmart_table'                     => 'woodmart_get_vc_map_table',
			'woodmart_table_row'                 => 'woodmart_get_vc_map_table_row',
			'woodmart_tabs'                      => 'woodmart_get_vc_map_tabs',
			'woodmart_tab'                       => 'woodmart_get_vc_map_tab',
			'team_member'                        => 'woodmart_get_vc_map_team_member',
			'testimonials'                       => 'woodmart_get_vc_map_testimonials',
			'testimonial'                        => 'woodmart_get_vc_map_testimonial',
			'woodmart_text_block'                => 'woodmart_get_vc_map_text_block',
			'woodmart_timeline'                  => 'woodmart_get_vc_map_timeline',
			'woodmart_timeline_item'             => 'woodmart_get_vc_map_timeline_item',
			'woodmart_timeline_breakpoint'       => 'woodmart_get_vc_map_timeline_breakpoint',
			'woodmart_title'                     => 'woodmart_get_vc_map_title',
			'woodmart_twitter'                   => 'woodmart_get_vc_map_twitter',
			'woodmart_shortcode_products_widget' => 'woodmart_get_vc_map_shortcode_products_widget',
			'woodmart_wishlist'                  => 'woodmart_get_vc_map_wishlist',
		);

		if ( ! woodmart_woocommerce_installed() ) {
			$woo_maps = array(
				'products_tabs'                      => 'woodmart_get_vc_map_products_tabs',
				'products_tab'                       => 'woodmart_get_vc_map_products_tab',
				'woodmart_brands'                    => 'woodmart_get_vc_map_brands',
				'woodmart_categories'                => 'woodmart_get_vc_shortcode_categories',
				'woodmart_product_filters'           => 'woodmart_get_vc_map_product_filters',
				'woodmart_products'                  => 'woodmart_get_products_shortcode_map_params',
				'woodmart_filter_categories'         => 'woodmart_get_vc_map_filter_categories',
				'woodmart_filters_attribute'         => 'woodmart_get_vc_map_filters_attribute',
				'woodmart_stock_status'              => 'woodmart_get_vc_map_stock_status',
				'woodmart_filters_price_slider'      => 'woodmart_get_vc_map_filters_price_slider',
				'woodmart_filters_orderby'           => 'woodmart_get_vc_map_filters_orderby',
				'woodmart_shortcode_products_widget' => 'woodmart_get_vc_map_shortcode_products_widget',
			);

			$maps = array_diff( $maps, $woo_maps );
		}

		if ( ! woodmart_get_opt( 'portfolio', '1' ) ) {
			$maps = array_diff( $maps, array( 'woodmart_portfolio' => 'woodmart_get_vc_map_portfolio' ) );
		}

		foreach ( $maps as $key => $callback ) {
			woodmart_vc_map( $key, $callback );
		}
	}

	add_action( 'vc_mapper_init_after', 'woodmart_vc_register_maps' );
}
