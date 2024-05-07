<?php

$languages    = function_exists( 'icl_get_languages' ) ? icl_get_languages() : array();
$flag_url     = '';
$current_lang = esc_html__( 'Languages', 'woodmart' );
$current_url  = '';

if ( $languages ) {
	foreach ( $languages as $key => $language ) {
		if ( $language['active'] ) {
			$flag_url     = $language['country_flag_url'];
			$current_lang = $language['native_name'];
			$current_url  = $language['url'];

			unset( $languages[ $key ] );
		}
	}
}

$extra_class = ' wd-event-' . $params['mouse_event'];
?>

<div class="wd-header-nav wd-header-secondary-nav">
	<ul class="menu wd-nav wd-nav-secondary wd-style-default">
		<li class="menu-item<?php echo esc_attr( $languages || ! $flag_url ? ' menu-item-has-children' . $extra_class : '' ); ?>">
			<a href="<?php echo esc_url( $current_url ); ?>" class="woodmart-nav-link">
				<?php if ( $flag_url && $params['show_language_flag'] ) : ?>
					<img src="<?php echo esc_url( $flag_url ); ?>" alt="<?php echo esc_attr( $current_lang ); ?>" class="wd-nav-img">
				<?php endif; ?>
				<span class="nav-link-text">
					<?php echo esc_html( $current_lang ); ?>
				</span>
			</a>
			<div class="wd-dropdown-menu wd-dropdown wd-design-default sub-menu-dropdown color-scheme-<?php echo esc_attr( $params['color_scheme'] ); ?>">
				<div class="container">
					<ul class="wd-sub-menu sub-menu">
						<?php if ( $languages ) : ?>
							<?php foreach ( $languages as $language ) : ?>
								<li class="menu-item">
									<a href="<?php echo esc_url( $language['url'] ); ?>" hreflang="<?php echo esc_attr( $language['language_code'] ); ?>" class="woodmart-nav-link">
										<?php if ( $language['country_flag_url'] && $params['show_language_flag'] ) : ?>
											<img src="<?php echo esc_url( $language['country_flag_url'] ); ?>" alt="<?php echo esc_attr( $language['native_name'] ); ?>" class="wd-nav-img">
										<?php endif; ?>
										<span class="nav-link-text">
											<?php echo esc_html( $language['native_name'] ); ?>
										</span>
									</a>
								</li>
							<?php endforeach; ?>
						<?php elseif ( ! $flag_url ) : ?>
							<li class="menu-item">
								<?php esc_html_e( 'You need WPML plugin for this to work. You can remove it from Header builder.', 'woodmart' ); ?>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</li>
	</ul>
</div>
