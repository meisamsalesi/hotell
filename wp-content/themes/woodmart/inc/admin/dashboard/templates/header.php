<?php

$logo_url = WOODMART_ASSETS_IMAGES . '/wood-logo-dark.svg';

if ( woodmart_get_opt( 'white_label' ) ) {
	$image_data = woodmart_get_opt( 'white_label_dashboard_logo' );

	if ( ! empty( $image_data['url'] ) ) {
		$logo_url = wp_get_attachment_image_url( $image_data['id'], 'full' );
	}
}

?>
<div class="xts-header xts-theme-style">
	<div class="xts-row">
		<div class="xts-col-auto">
			<a class="xts-logo" href="<?php echo esc_url( admin_url( 'admin.php?page=xts_dashboard' ) ); ?>">
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_html_e( 'Logo', 'woodmart' ); ?>">
			</a>
			<div class="xts-version">
				<?php echo esc_html( 'v.' . woodmart_get_theme_info( 'Version' ) ); ?>
			</div>
		</div>
		<div class="xts-col">
			<?php
			new XTS\Inc\Admin\Dashboard\Menu(
				[
					'items' => [
						[
							'link'       => [
								'url' => ( 'https://www.vishaweb.net/' ),
							],
							'type'       => 'page',
							'slug'       => 'xts_theme_settings',
							'icon'       => '',
							'text'       => esc_html__( '❤  ویشاوب', '' ),
							'child_menu' => [
								'items' => [
									[
										'link' => [
											'url' => ( 'https://www.vishaweb.net/shop' ),
										],
										
										'type' => 'page',
										'slug' => 'xts_theme_settings_presets',
										'icon' => 'dummy-content',
										'text' => esc_html__( 'فروشگاه ویشاوب', '' ),
									],
									[
										'link' => [
											'url' => ( 'https://www.vishaweb.net/host' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_backup',
										'icon' => 'dummy-content',
										'text' => esc_html__( 'هاست حرفه‌ای ویشاوب', 'woodmart' ),
									],
										[
										'link' => [
											'url' => ( 'https://www.vishaweb.net/web-design/' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_backup',
										'icon' => 'dummy-content',
										'text' => esc_html__( 'طراحی سایت', 'woodmart' ),
									],
									
									[
										'link' => [
											'url' => ( 'https://www.vishaweb.net/seo/' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_backup',
										'icon' => 'dummy-content',
										'text' => esc_html__( 'سئو', 'woodmart' ),
									],
									
									
									[
										'link' => [
											'url' => ( 'https://t.me/vishaweb_group' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_backup',
										'icon' => 'dummy-content',
										'text' => esc_html__( 'گروه پرسش و پاسخ', 'woodmart' ),
									],
									
													[
										'link' => [
											'url' => ( 'https://t.me/vishaweb' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_backup',
										'icon' => 'dummy-content',
										'text' => esc_html__( 'کانال ویشاوب', 'woodmart' ),
									],
									
															[
										'link' => [
											'url' => ( 'https://t.me/Mahboobvpn/11' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_backup',
										'icon' => 'dummy-content',
										'text' => esc_html__( 'خرید VPN پرسرعت با پشتیبانی', 'woodmart' ),
									],
									
									
									
								],
							],
						],
						
						
						
						
						
						
						
						
						
						
						
						[
							'link'       => [
								'url' => admin_url( 'admin.php?page=xts_theme_settings' ),
							],
							'type'       => 'page',
							'slug'       => 'xts_theme_settings',
							'icon'       => 'theme-settings',
							'text'       => esc_html__( 'Theme settings', 'woodmart' ),
							'child_menu' => [
								'items' => [
									[
										'link' => [
											'url' => admin_url( 'admin.php?page=xts_theme_settings_presets' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_presets',
										'icon' => 'cog',
										'text' => esc_html__( 'Presets', 'woodmart' ),
									],
									[
										'link' => [
											'url' => admin_url( 'admin.php?page=xts_theme_settings_backup' ),
										],
										'type' => 'page',
										'slug' => 'xts_theme_settings_backup',
										'icon' => 'round-right',
										'text' => esc_html__( 'Backup', 'woodmart' ),
									],
								],
							],
						],
						
						
						
						[
							'link'      => [
								'url' => admin_url( 'admin.php?page=xts_prebuilt_websites' ),
							],
							'type'      => 'page',
							'slug'      => 'xts_prebuilt_websites',
							'icon'      => 'dummy-content',
							'condition' => woodmart_get_opt( 'dummy_import', '1' ),
							'text'      => esc_html__( 'Prebuilt websites', 'woodmart' ),
						],
						[
							'link'      => [
								'url' => admin_url( 'admin.php?page=xts_license' ),
							],
							'type'      => 'page',
							'slug'      => 'xts_license',
							'icon'      => 'key',
							'condition' => woodmart_get_opt( 'white_label_theme_license_tab', '1' ),
							'text'      => esc_html__( 'Theme license', 'woodmart' ),
							'class'     => woodmart_is_license_activated() ? '' : 'xts-license-not-activated',
						],
						[
							'link'       => [
								'url' => admin_url( 'admin.php?page=xts_plugins' ),
							],
							'type'       => 'page',
							'slug'       => 'xts_plugins',
							'icon'       => 'tools',
							'text'       => esc_html__( 'Tools', 'woodmart' ),
							'child_menu' => [
								'items' => [
									[
										'link' => [
											'url' => admin_url( 'admin.php?page=xts_plugins' ),
										],
										'type' => 'page',
										'slug' => 'xts_plugins',
										'icon' => 'puzzle',
										'text' => esc_html__( 'Plugins', 'woodmart' ),
									],
									[
										'link' => [
											'url' => admin_url( 'admin.php?page=xts_patcher' ),
										],
										'type' => 'page',
										'slug' => 'xts_patcher',
										'icon' => 'cog',
										'text' => esc_html__( 'Patcher', 'woodmart' ),
									],
									[
										'link' => [
											'url' => admin_url( 'admin.php?page=xts_status' ),
										],
										'type' => 'page',
										'slug' => 'xts_status',
										'icon' => 'status',
										'text' => esc_html__( 'Status', 'woodmart' ),
									],
									[
										'link'      => [
											'url' => admin_url( 'admin.php?page=xts_changelog' ),
										],
										'type'      => 'page',
										'slug'      => 'xts_changelog',
										'icon'      => 'file-text',
										'condition' => woodmart_get_opt( 'white_label_changelog_tab', '1' ),
										'text'      => esc_html__( 'Changelog', 'woodmart' ),
									],
									[
										'link'      => [
											'url' => admin_url( 'admin.php?page=xts_wpb_css_generator' ),
										],
										'type'      => 'page',
										'slug'      => 'xts_wpb_css_generator',
										'icon'      => 'code',
										'condition' => 'wpb' === woodmart_get_current_page_builder(),
										'text'      => esc_html__( 'WPB CSS generator', 'woodmart' ),
									],
								],
							],
						],
					],
				]
			);
			?>
			<?php
			new XTS\Inc\Admin\Dashboard\Menu(
				[
					'items' => [
						[
							'link' => [
								'url' => admin_url( 'admin.php?page=xts_header_builder' ),
							],
							'type' => 'page',
							'slug' => 'xts_header_builder',
							'icon' => 'header-builder',
							'text' => esc_html__( 'Header builder', 'woodmart' ),
						],
						[
							'link' => [
								'url' => admin_url( 'edit.php?post_type=woodmart_layout' ),
							],
							'type' => 'post_type',
							'slug' => 'woodmart_layout',
							'icon' => 'layouts',
							'text' => esc_html__( 'Layouts', 'woodmart' ),
						],
						[
							'link'       => [
								'url' => admin_url( 'edit-tags.php?taxonomy=woodmart_slider&post_type=woodmart_slide' ),
							],
							'type'       => 'post_type_taxonomy',
							'slug'       => 'woodmart_slide',
							'icon'       => 'slides',
							'text'       => esc_html__( 'Sliders', 'woodmart' ),
							'condition'  => woodmart_get_opt( 'woodmart_slider', '1' ),
							'child_menu' => [
								'items' => [
									[
										'link' => [
											'url' => admin_url( 'edit.php?post_type=woodmart_slide' ),
										],
										'type' => 'post_type',
										'slug' => 'woodmart_slide',
										'text' => esc_html__( 'All slides', 'woodmart' ),
									],
									[
										'link' => [
											'url' => admin_url( 'post-new.php?post_type=woodmart_slide' ),
										],
										'type' => 'post_type_new',
										'slug' => 'woodmart_slide',
										'text' => esc_html__( 'Add new slide', 'woodmart' ),
									],
								],
							],
						],
						[
							'link'       => [
								'url' => admin_url( 'edit.php?post_type=cms_block' ),
							],
							'type'       => 'post_type',
							'slug'       => 'cms_block',
							'icon'       => 'html-block',
							'text'       => esc_html__( 'HTML Blocks', 'woodmart' ),
							'child_menu' => [
								'items' => [
									[
										'link' => [
											'url' => admin_url( 'edit-tags.php?taxonomy=cms_block_cat&post_type=cms_block' ),
										],
										'type' => 'post_type_taxonomy',
										'slug' => 'cms_block',
										'text' => esc_html__( 'Categories', 'woodmart' ),
									],
									[
										'link' => [
											'url' => admin_url( 'post-new.php?post_type=cms_block' ),
										],
										'type' => 'post_type_new',
										'slug' => 'cms_block',
										'text' => esc_html__( 'Add new', 'woodmart' ),
									],
								],
							],
						],
						[
							'link'       => [
								'url' => admin_url( 'edit.php?post_type=woodmart_sidebar' ),
							],
							'type'       => 'post_type',
							'slug'       => 'woodmart_sidebar',
							'icon'       => 'sidebars',
							'text'       => esc_html__( 'Sidebars', 'woodmart' ),
							'child_menu' => [
								'items' => [
									[
										'link' => [
											'url' => admin_url( 'post-new.php?post_type=woodmart_sidebar' ),
										],
										'type' => 'post_type_new',
										'slug' => 'woodmart_sidebar',
										'text' => esc_html__( 'Add new', 'woodmart' ),
									],
								],
							],
						],
					],
				]
			);
			?>
		</div>
	</div>
</div>