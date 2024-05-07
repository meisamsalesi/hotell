<?php

$extra_class = '';
$icon_type = $params['icon_type'];

$extra_class .= ' wd-style-' . $params['style'];

if ( $icon_type == 'custom' ) {
	$extra_class .= ' wd-tools-custom-icon';
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

if ( isset( $id ) ) {
	$extra_class .= ' whb-' . $id;
}

$extra_class .= woodmart_get_old_classes( ' woodmart-burger-icon' );

?>
<div class="wd-tools-element wd-header-mobile-nav<?php echo esc_attr( $extra_class ); ?>">
	<a href="#" rel="nofollow" aria-label="<?php esc_html_e( 'Open mobile menu', 'woodmart' ); ?>">
		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			<span class="wd-tools-inner">
		<?php endif; ?>

		<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' woodmart-burger' ); ?>">
			<?php if ( $icon_type == 'custom' ): ?>
				<?php echo whb_get_custom_icon( $params['custom_icon'] ); ?>
			<?php endif; ?>
		</span>

		<span class="wd-tools-text"><?php esc_html_e( 'Menu', 'woodmart' ); ?></span>

		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			</span>
		<?php endif; ?>
	</a>
</div><!--END wd-header-mobile-nav-->