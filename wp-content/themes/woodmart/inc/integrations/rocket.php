<?php

if ( ! defined( 'WP_ROCKET_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_remove_elementor_css_from_exclude' ) ) {
	/**
	 * Remove from CSS exclude Elementor post file..
	 *
	 * @param array $excluded_files Excluded files.
	 *
	 * @return array
	 */
	function woodmart_remove_elementor_css_from_exclude( $excluded_files ) {
		$upload   = wp_get_upload_dir();
		$basepath = wp_parse_url( $upload['baseurl'], PHP_URL_PATH );

		if ( empty( $basepath ) ) {
			return $excluded_files;
		}

		$key = array_search( $basepath . '/elementor/css/(.*).css', $excluded_files, true );

		if ( false !== $key ) {
			unset( $excluded_files[ $key ] );
		}

		return $excluded_files;
	}

	add_action( 'rocket_exclude_css', 'woodmart_remove_elementor_css_from_exclude' );
}

if ( ! function_exists( 'woodmart_delay_js_exclusions' ) ) {
	/**
	 * Exclusions JS files.
	 *
	 * @param array $exclude_delay_js Exclude files.
	 * @return array
	 */
	function woodmart_delay_js_exclusions( $exclude_delay_js ) {
		if ( ! woodmart_get_opt( 'rocket_delay_js_exclusions', false ) ) {
			return $exclude_delay_js;
		}

		return wp_parse_args(
			$exclude_delay_js,
			array(
				'/jquery-?[0-9.](.*)(.min|.slim|.slim.min)?.js',
				'helpers',
				'scrollBar',
				'clickOnScrollButton',
				'searchFullScreen',
				'menuOffsets',
				'menuDropdowns',
				'cartWidget',
				'mobileNavigation',
				'loginSidebar',
				'menuSetUp',
				'cart-fragments',
				'slick',
				'productImages',
				'cookie.min',
				'owl.carousel',
				'owlCarousel',
				'imagesLoaded',
				'ageVerify',
				'magnific-popup',
				'headerBuilder',
			)
		);
	}

	add_filter( 'rocket_delay_js_exclusions', 'woodmart_delay_js_exclusions' );
}

if ( ! function_exists( 'woodmart_rejected_uri_exclusions' ) ) {
	/**
	 * Add woodmart uris to the wp_rocket rejected uri
	 *
	 * @param array $uris List of rejected uri.
	 */
	function woodmart_rejected_uri_exclusions( $uris ) {
		$urls = array();

		if ( woodmart_get_opt( 'wishlist' ) && woodmart_get_opt( 'wishlist_page' ) ) {
			$urls[] = woodmart_get_wishlist_page_url();
		}
		if ( woodmart_get_opt( 'compare' ) && woodmart_get_opt( 'compare_page' ) ) {
			$urls[] = woodmart_get_compare_page_url();
		}

		if ( $urls ) {
			foreach ( $urls as $url ) {
				$uri = str_replace( home_url(), '', $url ) . '(.*)';

				if ( ! empty( $uri ) ) {
					$uris[] = $uri;
				}
			}
		}

		return $uris;
	}

	add_filter( 'rocket_cache_reject_uri', 'woodmart_rejected_uri_exclusions' );
}
