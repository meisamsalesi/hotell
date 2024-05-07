<?php
woodmart_enqueue_inline_style( 'header-elements-base' );
$params['source'] = 'header';

if ( isset( $id ) ) {
	$params['wrapper_classes'] = ' whb-' . $id;
}

if ( isset( $params['image']['id'] ) ) {
	$params['image'] = $params['image']['id'];
}

if ( ! empty( $params['link']['url'] ) ) {
	$link_attrs = 'url:' . rawurlencode( $params['link']['url'] );

	if ( ! empty( $params['link']['blank'] ) ) {
		$link_attrs .= '|target:_blank';
	}

	$params['link'] = $link_attrs;
}

// Remove value for control with css generators.
$params['bg_hover_color']           = '';
$params['icon_text_color']          = '';
$params['icon_bg_color']            = '';
$params['icon_bg_hover_color']      = '';
$params['icon_border_color']        = '';
$params['icon_border_hover_color']  = '';
$params['icon_text_color']          = '';
$params['subtitle_font_weight']     = '';
$params['subtitle_custom_bg_color'] = '';
$params['subtitle_custom_color']    = '';
$params['title_color']              = '';
$params['title_font_weight']        = '';
$params['custom_text_color']        = '';


echo woodmart_shortcode_info_box( $params, $params['content'] );
