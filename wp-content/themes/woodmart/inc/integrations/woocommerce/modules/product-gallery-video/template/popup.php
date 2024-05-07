<?php
/**
 * Popup template.
 *
 * @package Woodmart
 */
?>

<div class="xts-popup-holder xts-popup-product-gallery" data-default-settings='<?php echo wp_json_encode( $this->default_settings ); ?>'>
	<div class="xts-popup-overlay"></div>

	<div class="xts-popup xts-theme-style">
		<div class="xts-popup-inner">
			<div class="xts-popup-header">
				<div class="xts-popup-title">
					<?php esc_html_e( 'Product gallery video', 'woodmart' ); ?>
				</div>
				<a href="#" class="xts-popup-close xts-i-close">
					<?php esc_html__( 'Close', 'woodmart' ); ?>
				</a>
			</div>

			<div class="xts-popup-content xts-section xts-active-section">
				<div class="xts-fields">
					<div class="xts-field xts-settings-field xts-buttons-control xts-gallery_video_type-field">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Video source', 'woodmart' ); ?>
								</span>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-btns-set xts-active">
								<div class="xts-set-item xts-set-btn xts-active" data-value="mp4">
									<span>
										<?php esc_html_e( 'MP4', 'woodmart' ); ?>
									</span>
								</div>
								<div class="xts-set-item xts-set-btn" data-value="youtube">
									<span>
										<?php esc_html_e( 'YouTube', 'woodmart' ); ?>
									</span>
								</div>
								<div class="xts-set-item xts-set-btn" data-value="vimeo">
									<span>
										<?php esc_html_e( 'Vimeo', 'woodmart' ); ?>
									</span>
								</div>
							</div>
							<input type="hidden" data-name="video_type" value="mp4">
						</div>
					</div>

					<div class="xts-field xts-settings-field xts-text_input-control xts-gallery_custom_url-field xts-shown" data-dependency="gallery_video_type:equals:youtube;">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'YouTube video URL', 'woodmart' ); ?>
								</span>
							</label>
						</div>
						<div class="xts-option-control">
							<input type="text" data-name="youtube_url" value="">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Example: https://youtu.be/LXb3EKWsInQ', 'woodmart' ); ?>
						</p>
					</div>

					<div class="xts-field xts-settings-field xts-text_input-control xts-gallery_custom_url-field xts-shown" data-dependency="gallery_video_type:equals:vimeo;">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Vimeo video URL', 'woodmart' ); ?>
								</span>
							</label>
						</div>
						<div class="xts-option-control">
							<input type="text" data-name="vimeo_url" value="">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Example: https://vimeo.com/259400046', 'woodmart' ); ?>
						</p>
					</div>

					<div class="xts-field xts-settings-field xts-upload-control xts-gallery_upload_video-field" data-dependency="gallery_video_type:equals:mp4;">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'MP4 video file' ); ?>
								</span>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-upload-preview"></div>
							<div class="xts-upload-btns">
								<a class="xts-btn xts-upload-btn xts-i-import">
									<?php esc_html_e( 'Upload', 'woodmart' ); ?>
								</a>
								<a class="xts-btn xts-color-warning xts-remove-upload-btn xts-i-trash">
									<?php esc_html_e( 'Remove', 'woodmart' ); ?>
								</a>
								<input type="hidden" class="xts-upload-input-url" data-name="upload_video_url" value="">
								<input type="hidden" class="xts-upload-input-id" data-name="upload_video_id" value="">
							</div>
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Upload a new or select (.mp4) video file from the media library.', 'woodmart' ); ?>
						</p>
					</div>
					<div class="xts-field xts-col-6 xts-settings-field xts-buttons-control xts-gallery_video_control-field">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Video display type', 'woodmart' ); ?>
								</span>
								<div class="xts-hint">
									<div class="xts-tooltip xts-top">
										<video data-src="<?php echo esc_url( WOODMART_TOOLTIP_URL . 'video-display-type-native-player.mp4' ); ?>" autoplay loop muted></video>
									</div>
								</div>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-btns-set xts-active">
								<div class="xts-set-item xts-set-btn xts-active" data-value="theme">
									<span>
										<?php esc_html_e( 'Simplified', 'woodmart' ); ?>
									</span>
								</div>
								<div class="xts-set-item xts-set-btn" data-value="native">
									<span>
										<?php esc_html_e( 'Native player', 'woodmart' ); ?>
									</span>
								</div>
							</div>
							<input type="hidden" data-name="video_control" value="theme">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Minimalist theme-friendly design or a design from an embedded video player.', 'woodmart' ); ?>
						</p>
					</div>
					<div class="xts-field xts-col-6 xts-settings-field xts-switcher-control xts-gallery_hide_gallery_img-field" data-dependency="gallery_video_control:equals:native;">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Hide gallery image', 'woodmart' ); ?>
								</span>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-switcher-btn" data-on="1" data-off="0">
								<div class="xts-switcher-dot-wrap">
									<div class="xts-switcher-dot"></div>
								</div>
								<div class="xts-switcher-labels">
									<span class="xts-switcher-label xts-on">
										<?php esc_html_e( 'Yes', 'woodmart' ); ?>
									</span>
									<span class="xts-switcher-label xts-off">
										<?php esc_html_e( 'No', 'woodmart' ); ?>
									</span>
								</div>
							</div>
							<input type="hidden" data-name="hide_gallery_img" value="0">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Show the native player instead of the gallery image, even if the video hasn\'t started yet.', 'woodmart' ); ?>
						</p>
					</div>
					<div class="xts-field xts-col-6 xts-settings-field xts-buttons-control xts-gallery_video_size-field" data-dependency="gallery_video_control:equals:theme;">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Video size', 'woodmart' ); ?>
								</span>
								<div class="xts-hint">
									<div class="xts-tooltip xts-top">
										<video data-src="<?php echo esc_url( WOODMART_TOOLTIP_URL . 'video-size-cover.mp4' ); ?>" autoplay loop muted></video>
									</div>
								</div>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-btns-set xts-active">
								<div class="xts-set-item xts-set-btn xts-active" data-value="contain">
									<span>
										<?php esc_html_e( 'Contain', 'woodmart' ); ?>
									</span>
								</div>
								<div class="xts-set-item xts-set-btn" data-value="cover">
									<span>
										<?php esc_html_e( 'Cover', 'woodmart' ); ?>
									</span>
								</div>
							</div>
							<input type="hidden" data-name="video_size" value="contain">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Choose how the video will fill its container.', 'woodmart' ); ?>
						</p>
					</div>
					<div class="xts-field xts-divider-field"></div>
					<div class="xts-field xts-col-6 xts-settings-field xts-switcher-control xts-gallery_autoplay-field">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Autoplay', 'woodmart' ); ?>
								</span>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-switcher-btn" data-on="1" data-off="0">
								<div class="xts-switcher-dot-wrap">
									<div class="xts-switcher-dot"></div>
								</div>
								<div class="xts-switcher-labels">
									<span class="xts-switcher-label xts-on">
										<?php esc_html_e( 'On', 'woodmart' ); ?>
									</span>
									<span class="xts-switcher-label xts-off">
										<?php esc_html_e( 'Off', 'woodmart' ); ?>
									</span>
								</div>
							</div>
							<input type="hidden" data-name="autoplay" value="0">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Start playback after the gallery is loaded. Work on mobile depends on the video source.', 'woodmart' ); ?>
						</p>
					</div>

					<div class="xts-field xts-col-6 xts-settings-field xts-buttons-control xts-gallery_audio_status-field" data-dependency="gallery_autoplay:equals:0;">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Audio status', 'woodmart' ); ?>
								</span>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-btns-set xts-active">
								<div class="xts-set-item xts-set-btn xts-active" data-value="unmute">
									<span>
										<?php esc_html_e( 'Unmute', 'woodmart' ); ?>
									</span>
								</div>
								<div class="xts-set-item xts-set-btn" data-value="mute">
									<span>
										<?php esc_html_e( 'Mute', 'woodmart' ); ?>
									</span>
								</div>
							</div>
							<input type="hidden" data-name="audio_status" value="unmute">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Audio in autoplay videos is always muted.', 'woodmart' ); ?>
						</p>
					</div>
					<div class="xts-field xts-settings-field xts-switcher-control xts-gallery_hide_information-field">
						<div class="xts-option-title">
							<label>
								<span>
									<?php esc_html_e( 'Hide overlay information', 'woodmart' ); ?>
								</span>
								<div class="xts-hint">
									<div class="xts-tooltip xts-top">
										<video data-src="<?php echo esc_url( WOODMART_TOOLTIP_URL . 'hide-overlay-information.mp4' ); ?>" autoplay loop muted></video>
									</div>
								</div>
							</label>
						</div>
						<div class="xts-option-control">
							<div class="xts-switcher-btn" data-on="1" data-off="0">
								<div class="xts-switcher-dot-wrap">
									<div class="xts-switcher-dot"></div>
								</div>
								<div class="xts-switcher-labels">
									<span class="xts-switcher-label xts-on">
										<?php esc_html_e( 'Yes', 'woodmart' ); ?>
									</span>
									<span class="xts-switcher-label xts-off">
										<?php esc_html_e( 'No', 'woodmart' ); ?>
									</span>
								</div>
							</div>
							<input type="hidden" data-name="hide_information" value="0">
						</div>
						<p class="xts-field-description">
							<?php esc_html_e( 'Hide product labels, buttons, and pagination on the gallery slider during video playback.', 'woodmart' ); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="xts-popup-actions">
				<a href="#" class="xts-save-submit xts-btn xts-color-primary">
					<?php esc_html_e( 'Save', 'woodmart' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
