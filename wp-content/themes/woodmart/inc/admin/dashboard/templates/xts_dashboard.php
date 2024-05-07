<div class="xts-welcome-page">

	<?php if ( woodmart_get_opt( 'white_label' ) ) : ?>
		<div class="xts-box xts-white-label-box xts-theme-style">
			<div class="xts-box-content">
				<h3>
					<?php if ( woodmart_get_opt( 'white_label_dashboard_title' ) ) : ?>
						<?php echo esc_html( woodmart_get_opt( 'white_label_dashboard_title' ) ); ?>
					<?php else : ?>
				به قالب وودمارت خوش آمدید
					<?php endif; ?>
				</h3>
				
				<div class="xts-about-text" style="line-height: 2;">

								از شما برای دانلود رایگان قالب فروشگاهی وودمارت متشکریم.<br>
این قالب، ارائه شده توسط گروه طراحی و توسعه ویشاوب می باشد.
					<br>

				توجه داشته باشید که حتما قالب را فقط از
				 <a href="https://vishaweb.net/shop" target="_blank">فروشگاه قالب و افزونه ویشاوب </a>
				 تهیه کرده باشید. در غیر اینصورت در دریافت آپدیت ها و پشتیبانی دچار مشکلی خواهید شد.
	<br>
<div style="text-align: right;">
	<a href="https://t.me/vishaweb" target="_blank" style="color:#940882; font-size:20px;">برای دریافت قالب ها و افزونه های رایگان و تخفیفات در کانال تلگرام ویشاوب عضو شوید.
	</a>
	<br>

	<a href="https://t.me/vishaweb_group" target="_blank" style="color:#d10708;">در استفاده از قالب مشکل دارید؟؟ یا سوالی دارید که میخواهید پاسخ بدهیم؟؟!! در گروه تلگرامی ویشاوب عضو شوید.</a>

				
				
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="xts-box xts-welcome-box xts-theme-style xts-color-scheme-light">
			<div class="xts-box-content">
				<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/banner.png' ); ?>" alt="banner">

				<h3>
					<?php esc_html_e( 'Welcome to WoodMart', 'woodmart' ); ?>
				</h3>

				<p>
					<?php esc_html_e( 'Thank you for purchasing our premium eCommerce theme - Woodmart. Here you are able to start creating your awesome web store by importing our prebuilt websites and theme options.', 'woodmart' ); ?>
				</p>

				<?php if ( woodmart_get_opt( 'white_label_changelog_tab' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_changelog' ) ); ?>" class="xts-btn">
						<?php esc_html_e( 'What\'s new' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="xts-row xts-welcome-row xts-sp-20 xts-theme-style">
			<div class="xts-col-12 xts-col-xl-6">
				<div class="xts-box xts-info-boxes">
					<div class="xts-box-content">
						<h4>
							<?php esc_html_e( 'Need Help?' ); ?>
						</h4>

						<p>
							<?php esc_html_e( 'Use these links for more information!' ); ?>
						</p>

						<div class="xts-row">
							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/docs.jpg' ); ?>" alt="documentation banner">
								</div>
								<a href="https://xtemos.com/documentation/woodmart/" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Documentation' ); ?>
								</a>
							</div>

							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/video.jpg' ); ?>" alt="video banner">
								</div>
								<a href="https://www.youtube.com/channel/UCu3loFwqqOQ9z-YTcnplK8w/" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Video tutorials' ); ?>
								</a>
							</div>

							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/forum.jpg' ); ?>" alt="forum banner">
								</div>
								<a href="https://xtemos.com/forums/forum/woodmart-premium-template/" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Support forum' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="xts-col-12 xts-col-xl-6">
				<div class="xts-box xts-info-boxes xts-align-center">
					<div class="xts-box-content">
						<h4>
							<?php esc_html_e( 'Do you like theme?' ); ?>
						</h4>

						<p>
							<?php esc_html_e( 'Leave a comment on Themeforest!' ); ?>
						</p>

						<div class="xts-row">
							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/vote.jpg' ); ?>" alt="vote banner">
								</div>
								<a href="https://themeforest.net/downloads" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Rate our theme' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>