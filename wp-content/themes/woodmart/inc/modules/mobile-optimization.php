<?php

use XTS\Metaboxes;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_wp_is_mobile' ) ) {
	/**
	 * Filter page content.
	 *
	 * @param boolean $is_mobile Is mobile.
	 *
	 * @return string|void
	 */
	function woodmart_wp_is_mobile( $is_mobile ) {
		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && strpos( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) ) { // phpcs:ignore
			$is_mobile = false;
		}

		return $is_mobile;
	}

	add_filter( 'wp_is_mobile', 'woodmart_wp_is_mobile' );
}
