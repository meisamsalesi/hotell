<?php
	$extra_class = '';
	$count       = ( $params['display'] == 'dropdown' ) ? 20 : 40;
	$icon_type   = $params['icon_type'];
	woodmart_enqueue_inline_style( 'header-search' );

if ( 'form' === $params['display'] || 'full-screen-2' === $params['display'] ) {
	woodmart_enqueue_inline_style( 'header-search-form' );
	$search_style     = isset( $params['search_style'] ) ? $params['search_style'] : 'default';
	$wrapper_classes  = 'wd-header-search-form';
	$wrapper_classes .= ' wd-display-' . $params['display'];

	if ( isset( $id ) ) {
		$wrapper_classes .= ' whb-' . $id;
	}

	woodmart_search_form(
		array(
			'ajax'                   => 'full-screen-2' !== $params['display'] && $params['ajax'],
			'count'                  => $params['ajax_result_count'],
			'post_type'              => $params['post_type'],
			'show_categories'        => 'form' === $params['display'] && $params['categories_dropdown'],
			'icon_type'              => $icon_type,
			'search_style'           => $search_style,
			'custom_icon'            => $params['custom_icon'],
			'wrapper_custom_classes' => $wrapper_classes,
			'cat_selector_style'     => 'full-screen-2' !== $params['display'] ? $params['cat_selector_style'] : '',
		)
	);
	return;
}

if ( $icon_type == 'custom' ) {
	$extra_class .= ' wd-tools-custom-icon';
}

if ( 'dropdown' === $params['display'] ) {
	$extra_class .= ' wd-event-hover';
}

if ( ! empty( $params['icon_design'] ) ) {
	$extra_class .= ' wd-design-' . $params['icon_design'];
}

if ( '8' === $params['icon_design'] ) {
	woodmart_enqueue_inline_style( 'mod-tools-design-8' );
}

if ( ! empty( $params['style'] ) ) {
	$extra_class .= ' wd-style-' . $params['style'];
}

if ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) {
	$extra_class .= ' wd-with-wrap';
}

$extra_class .= ' wd-display-' . $params['display'];

if ( isset( $id ) ) {
	$extra_class .= ' whb-' . $id;
}

if ( 'dropdown' === $params['display'] && ! empty( $params['bg_overlay'] ) ) {
	woodmart_enqueue_js_script( 'menu-overlay' );

	$extra_class .= ' wd-with-overlay';
}

$extra_class .= woodmart_get_old_classes( ' search-button' );

?>
<div class="wd-header-search wd-tools-element<?php echo esc_attr( $extra_class ); ?>" title="<?php echo esc_attr__( 'Search', 'woodmart' ); ?>">
	<a href="javascript:void(0);" aria-label="<?php esc_html_e( 'Search', 'woodmart' ); ?>">
		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			<span class="wd-tools-inner">
		<?php endif; ?>

			<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' search-button-icon' ); ?>">
				<?php
					if ( $icon_type == 'custom' ) {
						echo whb_get_custom_icon( $params['custom_icon'] );
					}
				?>
			</span>

			<span class="wd-tools-text">
				<?php echo esc_html__( 'Search', 'woodmart' ); ?>
			</span>

		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			</span>
		<?php endif; ?>
	</a>
	<?php if ( $params['display'] == 'dropdown' ) : ?>
		<?php
			woodmart_search_form(
				array(
					'ajax'        => $params['ajax'],
					'count'       => $params['ajax_result_count'],
					'post_type'   => $params['post_type'],
					'type'        => 'dropdown',
					'icon_type'   => $icon_type,
					'custom_icon' => $params['custom_icon'],
				)
			);
		?>
	<?php endif ?>
</div>
