<?php

$extra_class = '';
$icon_type   = $params['icon_type'];

$extra_class .= ' wd-style-' . $params['style'];

if ( 'custom' === $icon_type ) {
	$extra_class .= ' wd-tools-custom-icon';
}

if ( ! empty( $params['title'] ) ) {
	$title = $params['title'];
} else {
	$title = esc_html__( 'Menu', 'woodmart' );
}

if ( ! empty( $params['icon_design'] ) ) {
	$extra_class .= ' wd-design-' . $params['icon_design'];
}

if ( '8' === $params['icon_design'] ) {
	woodmart_enqueue_inline_style( 'mod-tools-design-8' );
}

if ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) {
	$extra_class .= ' wd-with-wrap';
}

if ( 'click' === $params['mouse_event'] && ! empty( $params['close_menu_mouseout'] ) ) {
	$extra_class .= ' wd-close-menu-mouseout';
} elseif ( 'hover' === $params['mouse_event'] ) {
	$extra_class .= ' wd-event-hover';
}

if ( isset( $id ) ) {
	$extra_class .= ' whb-' . $id;
}

?>
<div class="wd-tools-element wd-header-sticky-nav<?php echo esc_attr( $extra_class ); ?>">
	<a href="#" rel="nofollow" aria-label="<?php esc_html_e( 'Open sticky navigation', 'woodmart' ); ?>">
		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			<span class="wd-tools-inner">
		<?php endif; ?>

		<span class="wd-tools-icon">
			<?php if ( 'custom' === $icon_type ) : ?>
				<?php echo whb_get_custom_icon( $params['custom_icon'] ); ?>
			<?php endif; ?>
		</span>

		<span class="wd-tools-text"><?php echo esc_html( $title ); ?></span>

		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			</span>
		<?php endif; ?>
	</a>
</div>
