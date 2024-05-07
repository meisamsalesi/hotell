<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Section table shortcode
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_shortcode_table' ) ) {
	function woodmart_shortcode_table( $settings, $content ) {
		$default_settings = array(
			'alignment' => '',
			'css'       => '',
		);

		if ( ! $content ) {
			return '';
		}

		$settings        = wp_parse_args( $settings, $default_settings );
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$table_classes = 'text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );

		ob_start();

		woodmart_enqueue_inline_style( 'el-table' );

		?>
		<div class="wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-el-table-wrap wd-reset-all-last">
				<table class="wd-el-table">
					<tbody class="<?php echo esc_attr( $table_classes ); ?>">
					<?php echo do_shortcode( $content ); ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_shortcode_table_row' ) ) {
	function woodmart_shortcode_table_row( $settings, $content ) {
		$default_settings = array(
			'css'          => '',
			'table_column' => '',
		);

		$settings  = wp_parse_args( $settings, $default_settings );
		$row_items = '';

		if ( function_exists( 'vc_param_group_parse_atts' ) ) {
			$row_items = vc_param_group_parse_atts( $settings['table_column'] );
		}

		if ( empty( $row_items ) ) {
			return '';
		}

		$wrapper_classes  = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		ob_start();
		?>
			<tr class="<?php echo esc_attr( $wrapper_classes ); ?>">
				<?php foreach ( $row_items as $item ) : ?>
					<?php $tag = ! empty( $item['column_cell_type'] ) && 'heading' === $item['column_cell_type'] ? 'th' : 'td'; ?>
					<<?php echo esc_attr( $tag ) . woodmart_get_table_attribute( $item ); ?>>
						<?php if ( ! empty( $item['column_content'] ) ) : ?>
							<?php echo wp_kses_post( $item['column_content'] ); ?>
						<?php endif; ?>
					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>
			</tr>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_get_table_attribute' ) ) {
	/**
	 * Get row item css.
	 *
	 * @param string $attr Data value.
	 *
	 * @return string
	 */
	function woodmart_get_table_attribute( $attr ) {
		$attributes = '';
		$style      = '';
		$classes    = '';

		if ( ! empty( $attr['row_item_color'] ) ) {
			$style .= 'color: ' . woodmart_vc_get_control_data( $attr['row_item_color'], 'desktop' ) . ';';
		}
		if ( ! empty( $attr['row_item_bg_color'] ) ) {
			$style .= 'background-color: ' . woodmart_vc_get_control_data( $attr['row_item_bg_color'], 'desktop' ) . ';';
		}
		if ( ! empty( $attr['row_item_alignment'] ) ) {
			$classes .= 'text-' . $attr['row_item_alignment'];
		}
		if ( ! empty( $attr['column_cell_span'] ) ) {
			$attributes .= ' colspan="' . $attr['column_cell_span'] . '"';
		}
		if ( ! empty( $attr['column_cell_row'] ) ) {
			$attributes .= ' rowspan="' . $attr['column_cell_row'] . '"';
		}

		if ( $classes ) {
			$attributes .= ' class="' . $classes . '"';
		}
		if ( $style ) {
			$attributes .= ' style="' . $style . '"';
		}

		return $attributes;
	}
}
