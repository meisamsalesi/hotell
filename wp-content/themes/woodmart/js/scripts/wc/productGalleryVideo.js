/* global woodmartConfig, woodmartThemeModule, woodmart_settings */
(function($) {
	'use strict';
	woodmartThemeModule.$document.on('wdReplaceMainGallery', function() {
		woodmartThemeModule.productVideoGallery();
	});

	$.each([
		'frontend/element_ready/wd_single_product_gallery.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.productVideoGallery();
		});
	});

	woodmartThemeModule.productVideoGallery = function() {
		var $mainGallery = $('.woocommerce-product-gallery__wrapper:not(.quick-view-gallery)');
		var $mainGalleryWrapper = $mainGallery.parents('.woocommerce-product-gallery');
		var $variation_form = $('.variations_form');

		woodmartThemeModule.$document.on('click', '.product-image-wrap.wd-with-video .wd-play-video', function (e) {
			e.preventDefault();

			var $button  = $(this);
			var $wrapper = $button.parents('.product-image-wrap');
			var $video   = $wrapper.find('iframe');

			if ( ! $video.length ) {
				$video = $wrapper.find('video');
			}

			if ( $wrapper.hasClass('wd-inited') || ! $video.length ) {
				return;
			}

			var videoScr = $video.attr('src');

			if ( ! videoScr ) {
				videoScr = $video.data('lazy-load');
				$video.attr('src', videoScr);
			}

			if ( ! videoScr ) {
				return;
			}

			if ( ! $wrapper.hasClass('wd-video-playing') ) {
				$wrapper.addClass('wd-loading');
			}

			videoInited( videoScr, $wrapper );
		});

		woodmartThemeModule.$document.on('wdPhotoSwipeBeforeInited', function( event, gallery ) {
			gallery.listen('initialLayout', function() {
				if ( 'undefined' === typeof gallery.items || ! gallery.items ) {
					return;
				}

				$.each( gallery.items, function ( key, item ) {
					if ( 'undefined' !== typeof item.mainElement && item.mainElement.hasClass('wd-video-playing') && item.mainElement.hasClass('wd-inited') ) {
						item.mainElement.find('.wd-play-video').trigger('click');
					}
				});
			});

			gallery.listen('close', function() {
				if ( 'undefined' === typeof gallery.currItem.container ) {
					return;
				}

				var $container = $(gallery.currItem.container).parents('.pswp__container');

				$container.find('.pswp__item').each(function () {
					var $video = $(this).find('.wd-with-video.wd-video-playing');

					if ($video.length) {
						$video.find('.wd-play-video').trigger('click');
					}
				});
			});
		});

		if ( $mainGallery.find('.product-image-wrap.wd-with-video').length ) {
			$mainGallery.on('changed.owl.carousel', function(e) {
				var $currentSlide = $mainGallery.find('.owl-item').eq(e.item.index);
				var $imageWrapper = $currentSlide.find('.product-image-wrap');

				if ( $imageWrapper.hasClass('wd-overlay-hidden') && ( $imageWrapper.hasClass('wd-video-playing') || $imageWrapper.hasClass('wd-video-design-native') && $imageWrapper.hasClass('wd-video-hide-thumb') ) ) {
					visibleOverlayProductInfo( 'hide' );
				} else if ( $mainGalleryWrapper.hasClass('wd-hide-overlay-info') && ( ! $imageWrapper.hasClass('wd-overlay-hidden') || ! $imageWrapper.hasClass('wd-video-playing' ) ) ) {
					visibleOverlayProductInfo( 'show' );
				}
			});
		}

		if ( $variation_form.length ) {
			$variation_form.on('show_variation', function(e, variation) {
				$mainGallery.find('.product-image-wrap.wd-video-playing').each( function () {
					var $imageWrapper = $(this);

					if ( $imageWrapper.find('.wp-post-image').length || $imageWrapper.hasClass('wd-inited') ) {
						$imageWrapper.find('.wd-play-video').trigger('click');
					}
				});
			});
		}

		function videoInited( videoScr, $wrapper ) {
			$wrapper.addClass('wd-inited');

			if (videoScr.indexOf('vimeo.com') + 1) {
				if ('undefined' === typeof Vimeo || 'undefined' === typeof Vimeo.Player) {
					var interval;
					$.getScript(woodmart_settings.vimeo_library_url, function() {
						interval = setInterval(function() {
							if ('undefined' !== typeof Vimeo) {
								clearInterval( interval );
								vimeoVideoControls( $wrapper );
							}
						}, 100);
					});
				} else {
					vimeoVideoControls($wrapper);
				}
			} else if (videoScr.indexOf('youtube.com') + 1) {
				if ('undefined' === typeof YT || 'undefined' === typeof YT.Player) {
					var interval;

					if ( $wrapper.hasClass('wd-video-playing') ) {
						$wrapper.find('.wd-video-actions').addClass('wd-loading');
					}

					$.getScript('https://www.youtube.com/iframe_api', function() {
						interval = setInterval(function() {
							if ('undefined' !== typeof YT.Player) {
								clearInterval( interval );
								youtubeVideoControls($wrapper);

								$wrapper.find('.wd-video-actions').removeClass('wd-loading');
							}
						}, 100);
					});
				} else {
					youtubeVideoControls( $wrapper );
				}
			} else {
				hostedVideoControls( $wrapper );
			}
		}

		function youtubeVideoControls( $wrapper ) {
			var $video    = $wrapper.find('iframe');
			var $playBtn  = $wrapper.find('.wd-play-video');
			var prevState;

			var player = new YT.Player($video[0], {
				events: {
					'onReady': onPlayerReady,
					'onStateChange': onPlayerStateChange
				}
			});

			function onPlayerStateChange( event ) {
				if ( $wrapper.hasClass('wd-overlay-hidden') ) {
					if ( event.data === YT.PlayerState.PLAYING ) {
						visibleOverlayProductInfo( 'hide' );
					} else if ( event.data === YT.PlayerState.PAUSED && ! $wrapper.hasClass('wd-video-design-native') ) {
						visibleOverlayProductInfo( 'show' );
					}
				}

				prevState = event.data;
			}

			function onPlayerReady() {
				if ( $wrapper.hasClass('wd-video-muted') ) {
					player.mute();
				} else {
					player.unMute();
				}

				player.setLoop(true);
				$wrapper.removeClass('wd-loading');

				if ( ! $wrapper.hasClass('wd-video-playing') || woodmartThemeModule.$window.width() <= 768 && $video.attr('src').indexOf('autoplay=1') && $video.attr('src').indexOf('mute=1') ) {
					$wrapper.addClass('wd-video-playing');
					player.playVideo();
				} else {
					$wrapper.removeClass('wd-video-playing');
					player.pauseVideo();
				}
			}

			$playBtn.on('click', function() {
				if ( prevState === YT.PlayerState.UNSTARTED ) {
					if ( 'function' === typeof player.playVideo ) {
						player.playVideo();
					}

					return;
				}

				if ( $wrapper.hasClass('wd-video-playing') ) {
					$wrapper.removeClass('wd-video-playing');

					if ( 'function' === typeof player.pauseVideo ) {
						player.pauseVideo();
					}
				} else {
					$wrapper.addClass('wd-video-playing');

					if ( 'function' === typeof player.playVideo ) {
						player.playVideo();
					}
				}
			});
		}

		function vimeoVideoControls( $wrapper ) {
			var $video    = $wrapper.find('iframe');
			var $playBtn  = $wrapper.find('.wd-play-video');
			var player    = new Vimeo.Player( $video );

			player.setLoop(true);

			if ( $wrapper.hasClass('wd-video-muted') ) {
				player.setVolume(0);
			} else {
				player.setVolume(1);
			}

			player.on('timeupdate', function() {
				if ( $wrapper.hasClass('wd-loading') ) {
					$wrapper.addClass('wd-video-playing');
					$wrapper.removeClass('wd-loading');

					if ( $wrapper.hasClass('wd-overlay-hidden') ) {
						visibleOverlayProductInfo( 'hide' );
					}
				}
			});

			if ( ! $wrapper.hasClass('wd-video-design-native') && $wrapper.hasClass('wd-overlay-hidden') ) {
				player.on('pause', function() {
					visibleOverlayProductInfo( 'show' );
				});
			}

			if ( $wrapper.hasClass('wd-video-playing') ) {
				player.pause();
				$wrapper.removeClass('wd-video-playing');
			} else {
				player.play();
			}

			if ( $wrapper.hasClass('wd-loaded') ) {
				$wrapper.addClass('wd-video-playing');
				$wrapper.removeClass('wd-loading');

				if ( $wrapper.hasClass('wd-overlay-hidden') ) {
					visibleOverlayProductInfo( 'hide' );
				}

				$wrapper.removeClass('wd-loaded');
			}

			$playBtn.on('click', function() {
				if ( $wrapper.hasClass('wd-video-playing') ) {
					$wrapper.removeClass('wd-video-playing');
					player.pause();
				} else {
					$wrapper.addClass('wd-video-playing');
					player.play();
				}
			});
		}

		function hostedVideoControls( $wrapper ) {
			var $video    = $wrapper.find('video');
			var $playBtn  = $wrapper.find('.wd-play-video');

			$video.on('loadedmetadata', function () {
				$wrapper.removeClass('wd-loading');
				$video[0].play();
				$wrapper.addClass('wd-video-playing');
			});

			if ( $wrapper.hasClass('wd-overlay-hidden') ) {
				$video.on('play', function () {
					visibleOverlayProductInfo( 'hide' );
				});

				if ( ! $wrapper.hasClass('wd-video-design-native') ) {
					$video.on('pause', function () {
						visibleOverlayProductInfo( 'show' );
					});
				}
			}

			if ( $wrapper.hasClass('wd-video-muted') ) {
				$video.prop('muted', true);
			} else {
				$video.prop('muted', false);
			}

			if ( $wrapper.hasClass('wd-video-playing') ) {
				$video[0].pause();
				$wrapper.removeClass('wd-video-playing');
			} else if ( $wrapper.hasClass('wd-loaded') ) {
				$wrapper.removeClass('wd-loading');
				$video[0].play();
				$wrapper.addClass('wd-video-playing');
			}

			$playBtn.on('click', function() {
				if ( $wrapper.hasClass('wd-video-playing') ) {
					$video[0].pause();
					$wrapper.removeClass('wd-video-playing');
				} else {
					$wrapper.addClass('wd-video-playing');
					$video[0].play();
				}
			});
		}

		function visibleOverlayProductInfo( event ) {
			if ( ! $mainGallery.hasClass('owl-carousel') ) {
				return;
			}

			if ( 'hide' === event ) {
				$mainGalleryWrapper.addClass('wd-hide-overlay-info');
			} else if ( 'show' === event ) {
				$mainGalleryWrapper.removeClass('wd-hide-overlay-info');
			}
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.productVideoGallery();
	});
})(jQuery);