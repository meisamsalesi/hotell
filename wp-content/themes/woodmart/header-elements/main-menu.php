<?php
$extra_class = '';
$menu_style  = ( $params['menu_style'] ) ? $params['menu_style'] : 'default';
$location    = 'main-menu';
$classes     = 'text-' . $params['menu_align'];
$icon_type   = $params['icon_type'];

if ( $icon_type == 'custom' ) {
	$extra_class .= ' wd-tools-custom-icon';
}

if ( 'bordered' === $params['menu_style'] ) {
	$classes .= ' wd-full-height';
}

$menu_classes = ' wd-style-' . $menu_style;
if ( isset( $params['items_gap'] ) ) {
	$menu_classes .= ' wd-gap-' . $params['items_gap'];
}

if ( isset( $params['inline'] ) && $params['inline'] ) {
	$classes     .= ' wd-inline';
	$extra_class .= ' wd-inline';
}

if ( ! empty( $params['icon_design'] ) ) {
	$classes     .= ' wd-design-' . $params['icon_design'];
	$extra_class .= ' wd-design-' . $params['icon_design'];
}

if ( '8' === $params['icon_design'] ) {
	woodmart_enqueue_inline_style( 'mod-tools-design-8' );
}

if ( ! empty( $params['bg_overlay'] ) ) {
	woodmart_enqueue_js_script( 'menu-overlay' );

	$classes .= ' wd-with-overlay';
}

if ( ! empty( $params['style'] ) ) {
	$extra_class .= ' wd-style-' . $params['style'];
}

if ( isset( $params['wrap_type'], $params['style'], $params['icon_design'], $params['full_screen'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) && $params['full_screen'] ) {
	$extra_class .= ' wd-with-wrap';
}

if ( isset( $id ) ) {
	$extra_class .= ' whb-' . $id;
}

$classes     .= woodmart_get_old_classes( ' navigation-style-' . $menu_style );
$extra_class .= woodmart_get_old_classes( ' full-screen-burger-icon woodmart-burger-icon' );

if ( $params['full_screen'] ) {
	woodmart_enqueue_inline_style( 'header-fullscreen-menu' );
	?>
		<div class="wd-tools-element wd-header-fs-nav<?php echo esc_attr( $extra_class ); ?>">
			<a href="#" rel="nofollow noopener">
				<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
					<span class="wd-tools-inner">
				<?php endif; ?>

					<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' woodmart-burger' ); ?>">
						<?php if ( $icon_type == 'custom' ) : ?>
							<?php echo whb_get_custom_icon( $params['custom_icon'] ); ?>
						<?php endif; ?>
					</span>

					<span class="wd-tools-text"><?php esc_html_e( 'Menu', 'woodmart' ); ?></span>

				<?php if ( '8' === $params['icon_design'] || ( isset( $params['wrap_type'], $params['style'], $params['icon_design'] ) && 'icon_and_text' === $params['wrap_type'] && 'text' === $params['style'] && in_array( $params['icon_design'], array( '6', '7' ), true ) ) ) : ?>
					</span>
				<?php endif; ?>
			</a>
		</div>
	<?php
	return;
}
?>
<div class="wd-header-nav wd-header-main-nav <?php echo esc_attr( $classes ); ?>" role="navigation" aria-label="<?php esc_html_e( 'Main navigation', 'woodmart' ); ?>">
	<?php
	$args = array(
		'container'  => '',
		'menu_class' => 'menu wd-nav wd-nav-main' . $menu_classes,
		'walker'     => new WOODMART_Mega_Menu_Walker(),
	);

	if ( empty( $params['menu_id'] ) ) {
		$args['theme_location'] = $location;
	}

	if ( ! empty( $params['menu_id'] ) ) {
		$args['menu'] = $params['menu_id'];
	}

	if ( has_nav_menu( $location ) ) {
		wp_nav_menu( $args );
	} else {
		$menu_link = get_admin_url( null, 'nav-menus.php' );
		?>
				<div class="create-nav-msg">
			<?php
				printf(
					wp_kses(
						__( 'Create your first <a href="%s"><strong>navigation menu here</strong></a> and add it to the "Main menu" location.', 'woodmart' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					$menu_link
				);
			?>
				</div>
			<?php
	}
	?>
</div><!--END MAIN-NAV-->
