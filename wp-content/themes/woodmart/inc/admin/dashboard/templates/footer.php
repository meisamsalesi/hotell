<?php if ( ! woodmart_get_opt( 'white_label' ) ) : ?>
	<div class="xts-footer xts-theme-style">
		<div class="xts-row">
			<div class="xts-col">
				<a class="xts-logo" href="https://xtemos.com/" target="_blank">
					<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/xtemos-logo-dark.svg' ); ?>" alt="<?php	esc_html_e( 'Logo', 'woodmart' ); ?>">
				</a>
			</div>

			<div class="xts-col-auto">
				<?php
				new XTS\Inc\Admin\Dashboard\Menu(
					[
						'items' => [
							[
								'link' => [
									'url'        => 'https://xtemos.com/documentation/woodmart/',
									'new_window' => true,
								],
								'icon' => 'documentation',
								'text' => esc_html__( 'Documentation', 'woodmart' ),
							],
							[
								'link' => [
									'url'        => 'https://www.youtube.com/playlist?list=PLMw6W4rAaOgKKv0oexGHzpWBg1imvrval',
									'new_window' => true,
								],
								'icon' => 'video-tutorials',
								'text' => esc_html__( 'Video tutorials', 'woodmart' ),
							],
							[
								'link' => [
									'url'        => 'https://themeforest.net/downloads',
									'new_window' => true,
								],
								'icon' => 'rate-theme',
								'text' => esc_html__( 'Rate our theme', 'woodmart' ),
							],
							[
								'link' => [
									'url'        => 'https://xtemos.com/forums/forum/woodmart-premium-template/',
									'new_window' => true,
								],
								'icon' => 'support-forum',
								'text' => esc_html__( 'Support forum', 'woodmart' ),
							],
						],
					]
				);
				?>
			</div>
		</div>
	</div>
<?php endif; ?>