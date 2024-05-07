<?php
if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'wishlist', 1 ) || ( woodmart_get_opt( 'wishlist_logged' ) && ! is_user_logged_in() ) ) {
	return;
}

woodmart_enqueue_inline_style( 'header-elements-base' );

$extra_class = '';
$icon_type   = $params['icon_type'];

$extra_class .= ' wd-style-' . $params['design'];

if ( ! $params['hide_product_count'] ) {
	$extra_class .= ' wd-with-count';
	$extra_class .= woodmart_get_old_classes( ' with-product-count' );
}

if ( $icon_type == 'custom' ) {
	$extra_class .= ' wd-tools-custom-icon';
}

if ( ! empty( $params['icon_design'] ) ) {
	$extra_class .= ' wd-design-' . $params['icon_design'];
}

if ( '8' === $params['icon_design'] ) {
	woodmart_enqueue_inline_style( 'mod-tools-design-8' );
}

if ( isset( $params['wrap_type'], $params['design'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['design'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) {
	$extra_class .= ' wd-with-wrap';
}

if ( isset( $id ) ) {
	$extra_class .= ' whb-' . $id;
}

$extra_class .= woodmart_get_old_classes( ' woodmart-wishlist-info-widget' );

woodmart_enqueue_js_script( 'wishlist' );
?>

<div class="wd-header-wishlist wd-tools-element<?php echo esc_attr( $extra_class ); ?>" title="<?php echo esc_attr__( 'My Wishlist', 'woodmart' ); ?>">
	<a href="<?php echo esc_url( woodmart_get_wishlist_page_url() ); ?>">
		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['design'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['design'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			<span class="wd-tools-inner">
		<?php endif; ?>

			<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' wishlist-icon' ); ?>">
				<?php
				if ( $icon_type == 'custom' ) {
					echo whb_get_custom_icon( $params['custom_icon'] );
				}
				?>

				<?php if ( ! $params['hide_product_count'] ) : ?>
					<span class="wd-tools-count">
						<?php echo esc_html( woodmart_get_wishlist_count() ); ?>
					</span>
				<?php endif; ?>
			</span>

			<span class="wd-tools-text<?php echo woodmart_get_old_classes( ' wishlist-label' ); ?>">
				<?php esc_html_e( 'Wishlist', 'woodmart' ); ?>
			</span>

		<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['design'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['design'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
			</span>
		<?php endif; ?>
	</a>
</div>
