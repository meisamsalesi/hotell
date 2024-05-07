/* global woodmartConfig */
(function($) {
	'use strict';

	$(document).on('click', '.xts-popup-product-gallery .xts-save-submit, .xts-popup-product-gallery .xts-popup-close, .xts-popup-product-gallery .xts-popup-overlay', function(e) {
		e.preventDefault();

		var $popup   = $(this).parents('.xts-popup-product-gallery');
		var $btn     = $('.xts-product-gallery-video.xts-active');
		var settings = {};

		$popup.find('input').each(function () {
			var $input = $(this);
			var value  = $input.val();
			var key    = $input.data('name');

			settings[ $input.data('name') ] = $input.val();

			if ( value && ( 'custom_url' === key || 'upload_video_id' === key ) ) {
				$btn.removeClass('xts-add-video').addClass('xts-edit-video');
			}
		});

		if ( 'undefined' !== typeof settings.video_type ) {
			if ( 'youtube' === settings.video_type && settings.youtube_url || 'vimeo' === settings.video_type && settings.vimeo_url || 'mp4' === settings.video_type && settings.upload_video_id ) {
				$btn.removeClass('xts-add-video').addClass('xts-edit-video');
			} else {
				$btn.removeClass('xts-edit-video').addClass('xts-add-video');
			}

			$btn.siblings('input').val( JSON.stringify( settings ) );
		} else {
			$btn.removeClass('xts-edit-video').addClass('xts-add-video');
		}

		$btn.removeClass('xts-active');
		$popup.removeClass('xts-opened');
		$('html').removeClass('xts-popup-opened');
	});

	$(document).on('click', '.xts-product-gallery-video', function(e) {
		e.preventDefault();

		var $btn     = $(this);
		var settings = $btn.siblings('input').val();
		var $popup   = $('.xts-popup-holder.xts-popup-product-gallery');

		if ( ! settings ) {
			settings = $popup.data('default-settings');
		} else {
			settings = JSON.parse( settings );
		}

		$btn.addClass('xts-active');
		$popup.addClass( 'xts-loading' );

		if ( settings ) {
			$.each( settings, function ( key, setting ) {
				var $input = $popup.find('input[data-name=' + key + ']');

				if ( $input.siblings('.xts-btns-set').length ) {
					$popup.find('.xts-gallery_' + key + '-field .xts-set-item[data-value=' + setting + ']').trigger('click');
				} else if ( $input.siblings('.xts-switcher-btn').length ) {
					if ( $input.val() !== setting ) {
						$popup.find('.xts-gallery_' + key + '-field .xts-switcher-btn').trigger('click');
					}
				} else {
					$input.val( setting ).trigger('change');
				}

				if ( 'upload_video_id' === key ) {
					var $removeBtn = $popup.find('.xts-gallery_upload_video-field .xts-remove-upload-btn');

					if ( setting ) {
						$removeBtn.addClass('xts-active');
					} else {
						$removeBtn.removeClass('xts-active');
					}
				}
			});
		}

		$(document).trigger('xts_section_changed');

		$popup.addClass( 'xts-opened' );
		$('html').addClass('xts-popup-opened');

		setTimeout( function () {
			$popup.removeClass( 'xts-loading' );
		}, 250 );
	});

	var inputImage = document.querySelector('input#product_image_gallery');

	if ( inputImage ) {
		var observer = new MutationObserver((changes) => {
			changes.forEach( change => {
				if (change.attributeName.includes('value')){
					addVideoGalleryButton();
				}
			});
		});
		observer.observe(inputImage, {attributes : true});
	}

	function addVideoGalleryButton() {
		$('#product_images_container ul.product_images > li').each(function () {
			var $image = $(this);

			if ( $image.find('.xts-product-gallery-video').length ) {
				return;
			}

			$image.append(`
				<div class="xts-product-video-wrapp">
					<a href="#" class="xts-btn xts-color-primary xts-product-gallery-video xts-i-add xts-add-video">
						${woodmartConfig.product_gallery_video_text}
					</a>
					<input type="hidden" name="xts-product-gallery-video[${$image.data('attachment_id')}]">
				</div>
			`);
		});
	}
})(jQuery);