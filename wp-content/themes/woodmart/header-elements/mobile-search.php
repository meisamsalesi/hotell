<?php

$extra_class = '';
$icon_type   = $params['icon_type'];

if ( $icon_type == 'custom' ) {
	$extra_class .= ' wd-tools-custom-icon';
}

woodmart_enqueue_inline_style( 'header-search' );

$extra_class .= woodmart_get_old_classes( ' search-button' );

$extra_class .= ' wd-display-' . $params['display'];

if ( isset( $id ) ) {
	$extra_class .= ' whb-' . $id;
}


$settings = whb_get_settings();

if ( 'form' === $params['display'] || 'full-screen-2' === $params['display'] ) {
	woodmart_enqueue_inline_style( 'header-search-form' );
	$search_style     = isset( $params['search_style'] ) ? $params['search_style'] : 'default';
	$post_type        = $settings['search']['post_type'];
	$wrapper_classes  = 'wd-header-search-form-mobile';
	$wrapper_classes .= ' wd-display-' . $params['display'];
	$wrapper_classes .= woodmart_get_old_classes( ' woodmart-mobile-search-form' );

	if ( isset( $settings['mobilesearch'] ) && isset( $settings['mobilesearch']['post_type'] ) ) {
		$post_type = $settings['mobilesearch']['post_type'];
	}

	if ( isset( $id ) ) {
		$wrapper_classes .= ' whb-' . $id;
	}

	woodmart_search_form(
		array(
			'ajax'                   => $settings['search']['ajax'],
			'post_type'              => $post_type,
			'icon_type'              => $icon_type,
			'search_style'           => $search_style,
			'custom_icon'            => $params['custom_icon'],
			'wrapper_custom_classes' => $wrapper_classes,
		)
	);
	return;
}

if ( ! empty( $params['style'] ) ) {
	$extra_class .= ' wd-style-' . $params['style'];
}

if ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) {
	$extra_class .= ' wd-with-wrap';
}

if ( ! empty( $params['icon_design'] ) ) {
	$extra_class .= ' wd-design-' . $params['icon_design'];
}

if ( '8' === $params['icon_design'] ) {
	woodmart_enqueue_inline_style( 'mod-tools-design-8' );
}

woodmart_enqueue_js_script( 'mobile-search' );

?>

<div class="wd-header-search wd-tools-element wd-header-search-mobile<?php echo esc_attr( $extra_class ); ?>">
	<a href="#" rel="nofollow noopener" aria-label="<?php esc_html_e( 'Search', 'woodmart' ); ?>">
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
</div>
