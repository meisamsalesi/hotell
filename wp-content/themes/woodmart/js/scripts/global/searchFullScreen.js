/* global woodmart_settings */
(function($) {
	woodmartThemeModule.searchFullScreen = function() {
		var $searchWrapper = $('[class*=wd-search-full-screen]');

		if ( 'yes' === woodmart_settings.ajax_fullscreen_content ) {
			woodmartThemeModule.$body.on('mouseover click touchstart', '.wd-header-search.wd-display-full-screen > a, .wd-search-form.wd-display-full-screen-2', function() {
				var $this = $(this);

				if ($this.hasClass('wd-inited')) {
					return;
				}

				$this.addClass('wd-inited');

				var $contentArea = $searchWrapper.find('.wd-search-area');

				if ( ! $contentArea.length ) {
					return;
				}

				$.ajax({
					url     : woodmart_settings.ajaxurl,
					data    : {
						action: 'woodmart_load_full_search_html',
					},
					dataType: 'json',
					method  : 'POST',
					success : function(response) {
						if (response.content) {
							$contentArea.html(response.content);
							setTimeout( function () {
								$searchWrapper.addClass('wp-content-loaded');
							}, 10);

							woodmartThemeModule.$document.trigger('wdSearchFullScreenContentLoaded');
							woodmartThemeModule.$document.trigger('wood-images-loaded');
						}
					},
					error   : function() {
						console.log('loading html full search ajax error');
					}
				});
			});
		}

		woodmartThemeModule.$body.on('click', '.wd-header-search.wd-display-full-screen > a, .wd-search-form.wd-display-full-screen-2', function(e) {
			e.preventDefault();

			var $this = $(this);
			var $wrapper = $('.wd-search-full-screen-2');

			if ($this.parent().find('.wd-search-dropdown').length > 0 || woodmartThemeModule.$body.hasClass('global-search-dropdown')) {
				return;
			}

			if (isOpened()) {
				closeWidget();
			} else {
				if ( ! $this.hasClass('wd-display-full-screen-2') ) {
					$wrapper = $('.wd-search-full-screen');
					calculationOffset();
				}

				setTimeout(function() {
					openWidget($wrapper);
				}, 10);
			}
		});

		woodmartThemeModule.$body.on('click', '.wd-close-search a, .website-wrapper, .header-banner', function(event) {

			if (!$(event.target).is('.wd-close-search a') && $(event.target).closest('.wd-search-full-screen').length) {
				return;
			}

			if ( $(event.target).is('.wd-close-search a') ) {
				event.preventDefault();
			}

			if (isOpened()) {
				closeWidget();
			}
		});

		var closeByEsc = function(e) {
			if (e.keyCode === 27) {
				closeWidget();
				woodmartThemeModule.$body.unbind('keyup', closeByEsc);
			}
		};

		var closeWidget = function() {
			$('html').removeClass('wd-search-opened');
			$searchWrapper.removeClass('wd-opened');
			setTimeout( function () {
				$searchWrapper.removeClass('wd-searched');
			}, 500);
		};

		var calculationOffset = function () {
			var $bar = $('#wpadminbar');
			var barHeight = $bar.length > 0 ? $bar.outerHeight() : 0;
			var $sticked = $('.whb-sticked');
			var $mainHeader = $('.whb-main-header');
			var offset;

			if ($sticked.length > 0) {
				if ($('.whb-clone').length > 0) {
					offset = $sticked.outerHeight() + barHeight;
				} else {
					offset = $mainHeader.outerHeight() + barHeight;
				}
			} else {
				offset = $mainHeader.outerHeight() + barHeight;
				if (woodmartThemeModule.$body.hasClass('header-banner-display')) {
					offset += $('.header-banner').outerHeight();
				}
			}

			$('.wd-search-full-screen').css('top', offset);
		}

		var openWidget = function($wrapper) {
			// Close by esc
			woodmartThemeModule.$body.on('keyup', closeByEsc);
			$('html').addClass('wd-search-opened');

			$wrapper.addClass('wd-opened');

			setTimeout(function() {
				$wrapper.find('input[type="text"]').trigger('focus');

				if ( woodmartThemeModule.windowWidth > 1024 ) {
					woodmartThemeModule.$window.one('scroll', function() {
						if (isOpened()) {
							closeWidget();
						}
					});
				}
			}, 500);
		};

		var isOpened = function() {
			return $('html').hasClass('wd-search-opened');
		};
	};

	$(document).ready(function() {
		woodmartThemeModule.searchFullScreen();
	});
})(jQuery);
