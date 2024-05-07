<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 *  Wishlist element map
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_get_vc_map_wishlist' ) ) {
	function woodmart_get_vc_map_wishlist() {
		return array(
			'name'        => esc_html__( 'Wishlist', 'woodmart' ),
			'base'        => 'woodmart_wishlist',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Required for the wishlist page.', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/wishlist.svg',
		);
	}
}
