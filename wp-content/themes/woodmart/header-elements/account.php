<?php

if ( ! woodmart_woocommerce_installed() ) {
	return '';
}

$links = woodmart_get_header_links( $params );
$my_account_style = $params['display'];
$login_side = $params['form_display'] == 'side';
$icon_type = $params['icon_type'];
$extra_class = '';

$classes = '';
$classes .= ( ! empty( $link['dropdown'] ) ) ? ' menu-item-has-children' : '';
$classes .= ( $params['with_username'] ) ? ' wd-with-username' : '';

if ( ! empty( $params['icon_design'] ) ) {
	$classes .= ' wd-design-' . $params['icon_design'];
}

if ( $my_account_style ) {
	$classes .= ' wd-account-style-' . $my_account_style;
	$classes .= woodmart_get_old_classes( ' my-account-with-' . $my_account_style );
}

if ( ! is_user_logged_in() && $params['login_dropdown'] && $login_side ) {
	woodmart_enqueue_js_script( 'login-sidebar' );
	$classes .= ' login-side-opener';
}

if ( ! is_user_logged_in() ) {
	woodmart_enqueue_inline_style( 'woo-mod-login-form' );
}

if ( '8' === $params['icon_design'] ) {
	woodmart_enqueue_inline_style( 'mod-tools-design-8' );
}

if ( $icon_type == 'custom' && $my_account_style == 'icon' ) {
	$classes .= ' wd-tools-custom-icon';
}


if ( ! empty( $params['bg_overlay'] && ( $params['login_dropdown'] && 'dropdown' === $params['form_display'] && ! is_account_page() || is_user_logged_in() ) ) ) {
	woodmart_enqueue_js_script( 'menu-overlay' );

	$classes .= ' wd-with-overlay';
}

if (  isset( $params['wrap_type'], $params['with_username'], $params['icon_design'], $params['display'] ) && 'icon_and_text' === $params['wrap_type'] && $params['with_username'] && in_array( $params['icon_design'], array( '6', '7' ), true ) && 'icon' === $params['display'] ) {
	$classes .= ' wd-with-wrap';
}

if ( isset( $id ) ) {
	$classes .= ' whb-' . $id;
}

if( empty( $links ) ) return '';

$classes .= woodmart_get_old_classes( ' woodmart-header-links woodmart-navigation item-event-hover menu-simple-dropdown' );
woodmart_enqueue_inline_style( 'header-my-account' );
?>
<div class="wd-header-my-account wd-tools-element wd-event-hover<?php echo esc_attr( $classes ); ?>">
	<?php foreach ($links as $key => $link): ?>
		<a href="<?php echo esc_url( $link['url'] ); ?>" title="<?php echo esc_attr__( 'My account', 'woodmart' ); ?>">
			<?php if ( '8' === $params['icon_design'] || (  isset( $params['wrap_type'], $params['with_username'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && $params['with_username'] && in_array( $params['icon_design'], array( '6', '7' ), true ) && 'icon' === $params['display'] ) ) : ?>
				<span class="wd-tools-inner">
			<?php endif; ?>

				<span class="wd-tools-icon">
					<?php
						if ( $icon_type == 'custom' && $my_account_style == 'icon' ) {
							echo whb_get_custom_icon( $params['custom_icon'] );
						}
					?>
				</span>
				<span class="wd-tools-text">
				<?php echo wp_kses( $link['label'], 'default' ); ?>
			</span>

			<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['with_username'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && $params['with_username'] && in_array( $params['icon_design'], array( '6', '7' ), true ) && 'icon' === $params['display'] ) ) : ?>
				</span>
			<?php endif; ?>
		</a>

		<?php if( ! empty( $link['dropdown'] ) ) echo apply_filters( 'woodmart_account_element_dropdown', $link['dropdown'] ); ?>
	<?php endforeach; ?>
</div>
