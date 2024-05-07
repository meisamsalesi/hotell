<?php
/**
 * Yoast.
 *
 * @package woodmart
 */

if ( ! function_exists( 'YoastSEO' ) ) {
	return;
}

add_action( 'category_description', 'woodmart_page_css_files_disable', 9 );
add_action( 'term_description', 'woodmart_page_css_files_disable', 9 );

add_action( 'category_description', 'woodmart_page_css_files_enable', 11 );
add_action( 'term_description', 'woodmart_page_css_files_enable', 11 );

if ( ! function_exists( 'woodmart_layout_post_type_filter' ) ) {
	/**
	 * Exclude woodmart layout from Optimize SEO.
	 *
	 * @param array $post_types Post type.
	 * @return mixed
	 */
	function woodmart_layout_post_type_filter( $post_types ) {
		if ( isset( $post_types['woodmart_layout'] ) ) {
			unset( $post_types['woodmart_layout'] );
		}

		return $post_types;
	}

	add_filter( 'wpseo_accessible_post_types', 'woodmart_layout_post_type_filter' );
}

if ( ! function_exists( 'woodmart_indexable_excluded_post_types' ) ) {
	/**
	 * Exclude woodmart layout from Optimize SEO.
	 *
	 * @param array $post_types Post type.
	 * @return mixed
	 */
	function woodmart_indexable_excluded_post_types( $post_types ) {
		$post_types[] = 'woodmart_layout';

		return $post_types;
	}

	add_filter( 'wpseo_indexable_excluded_post_types', 'woodmart_indexable_excluded_post_types' );
}
