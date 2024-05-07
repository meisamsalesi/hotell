<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* Woodmart responsive size param
*/
if ( ! function_exists( 'woodmart_get_responsive_size_param' ) ) {
	function woodmart_get_responsive_size_param( $settings, $value ) {
        $output = '<div class="woodmart-rs-wrapper ' . esc_attr( $settings['param_name'] ) . '">';
            $output .= '<div class="woodmart-rs-item xts-input-append-wrap desktop">';
                $output .= '<label class="xts-i-desktop">Desktop</label>';
                $output .= '<div class="xts-input-append">';
                    $output .= '<input type="number" min="1" class="woodmart-rs-input" data-id="desktop">';
                    $output .= '<span class="add-on">px</span>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="woodmart-rs-trigger xts-i-button-right" title="Responsive controls"></div>';

            $output .= '<div class="woodmart-rs-item xts-input-append-wrap tablet hide">';
                $output .= '<label class="xts-i-tablet">Tablet</label>';
                $output .= '<div class="xts-input-append">';
                    $output .= '<input type="number" min="1" class="woodmart-rs-input" data-id="tablet">';
                    $output .= '<span class="add-on">px</span>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="woodmart-rs-item xts-input-append-wrap mobile hide">';
                $output .= '<label class="xts-i-phone">Mobile</label>';
                $output .= '<div class="xts-input-append">';
                    $output .= '<input type="number" min="1" class="woodmart-rs-input" data-id="mobile">';
                    $output .= '<span class="add-on">px</span>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<input type="hidden" data-css_args="' . esc_attr( json_encode( $settings['css_args'] ) ) . '" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value woodmart-rs-value" value="' . esc_attr( $value ) . '">';
        $output .= '</div>';

	    return $output;
    }
    
}
