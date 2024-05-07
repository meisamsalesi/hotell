var woodmartThemeModule = {};
/* global woodmart_settings */

(function($) {
	woodmartThemeModule.supports_html5_storage = false;

	try {
		woodmartThemeModule.supports_html5_storage = ('sessionStorage' in window && window.sessionStorage !== null);
		window.sessionStorage.setItem('wd', 'test');
		window.sessionStorage.removeItem('wd');
	}
	catch (err) {
		woodmartThemeModule.supports_html5_storage = false;
	}

	woodmartThemeModule.$window = $(window);

	woodmartThemeModule.$document = $(document);

	woodmartThemeModule.$body = $('body');

	woodmartThemeModule.windowWidth = woodmartThemeModule.$window.width();

	woodmartThemeModule.removeURLParameter = function(url, parameter) {
		var urlParts = url.split('?');

		if (urlParts.length >= 2) {
			var prefix = encodeURIComponent(parameter) + '=';
			var pars = urlParts[1].split(/[&;]/g);

			for (var i = pars.length; i-- > 0;) {
				if (pars[i].lastIndexOf(prefix, 0) !== -1) {
					pars.splice(i, 1);
				}
			}

			return urlParts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
		}

		return url;
	};

	woodmartThemeModule.removeDuplicatedStylesFromHTML = function(html, callback) {
		var $data = $('<div class="temp-wrapper"></div>').append(html);
		var $links = $data.find('link');
		var counter = 0;
		var timeout = false;

		if (0 === $links.length) {
			callback(html);
			return;
		}

		setTimeout(function() {
			if (counter <= $links.length && !timeout) {
				callback($($data.html()));
				timeout = true;
			}
		}, 500);

		$links.each(function() {
			if ( 'undefined' !== typeof $(this).attr('id') && $(this).attr('id').indexOf('theme_settings_') !== -1) {
				$('head').find('link[id*="theme_settings_"]:not([id*="theme_settings_default"])').remove();
			}
		});

		$links.each(function() {
			var $link = $(this);
			var id = $link.attr('id');
			var href = $link.attr('href');

			if ( 'undefined' === typeof id ) {
				return;
			}

			var isThemeSettings = id.indexOf('theme_settings_') !== -1;
			var isThemeSettingsDefault = id.indexOf('theme_settings_default') !== -1;

			$link.remove();

			if ('undefined' === typeof woodmart_page_css[id] && ! isThemeSettingsDefault) {
				$('head').append($link.on('load', function() {
					counter++;

					if (!isThemeSettings) {
						woodmart_page_css[id] = href;
					}

					if (counter >= $links.length && !timeout) {
						callback($($data.html()));
						timeout = true;
					}
				}));
			} else {
				counter++;

				if (counter >= $links.length && !timeout) {
					callback($($data.html()));
					timeout = true;
				}
			}
		});
	};

	woodmartThemeModule.debounce = function(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this;
			var args = arguments;
			var later = function() {
				timeout = null;

				if (!immediate) {
					func.apply(context, args);
				}
			};
			var callNow = immediate && !timeout;

			clearTimeout(timeout);
			timeout = setTimeout(later, wait);

			if (callNow) {
				func.apply(context, args);
			}
		};
	};

	woodmartThemeModule.wdElementorAddAction = function(name, callback) {
		woodmartThemeModule.$window.on('elementor/frontend/init', function() {
			if (!elementorFrontend.isEditMode()) {
				return;
			}

			elementorFrontend.hooks.addAction(name, callback);
		});
	};

	woodmartThemeModule.wdElementorAddAction('frontend/element_ready/global', function($wrapper) {
		if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('transform:translate3d') === 0 && !$wrapper.hasClass('wd-parallax-on-scroll')) {
			$wrapper.attr('style', '');
		}
		$wrapper.removeClass('wd-animated');
		$wrapper.data('wd-waypoint', '');
		$wrapper.removeClass('wd-anim-ready');
		woodmartThemeModule.$document.trigger('wdElementorGlobalReady');
	});

	$.each([
		'frontend/element_ready/column',
		'frontend/element_ready/container'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
			if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('transform:translate3d') === 0 && !$wrapper.hasClass('wd-parallax-on-scroll')) {
				$wrapper.attr('style', '');
			}
			$wrapper.removeClass('wd-animated');
			$wrapper.data('wd-waypoint', '');
			$wrapper.removeClass('wd-anim-ready');

			setTimeout(function() {
				woodmartThemeModule.$document.trigger('wdElementorColumnReady');
			}, 100);
		});
	});

	woodmartThemeModule.setupMainCarouselArg = function() {
		woodmartThemeModule.$mainCarouselWrapper = $('.woocommerce-product-gallery');
		var items = 1;

		if ( woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-centered') || woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-carousel_two_columns') ) {
			items = 2;
		}

		woodmartThemeModule.mainCarouselArg = {
			rtl            : woodmartThemeModule.$body.hasClass('rtl'),
			items          : items,
			autoplay       : woodmart_settings.product_slider_autoplay,
			autoplayTimeout: 3000,
			loop           : woodmart_settings.product_slider_autoplay,
			center         : woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-centered'),
			startPosition  : woodmartThemeModule.$mainCarouselWrapper.hasClass('thumbs-position-centered') ? woodmart_settings.centered_gallery_start : 0,
			dots           : 'yes' === woodmart_settings.product_slider_dots || woodmartThemeModule.$mainCarouselWrapper.find('.woocommerce-product-gallery__wrapper').data('hide_pagination_control') && 'yes' !== woodmartThemeModule.$mainCarouselWrapper.find('.woocommerce-product-gallery__wrapper').data('hide_pagination_control'),
			nav            : true,
			autoHeight     : woodmart_settings.product_slider_auto_height === 'yes',
			navText        : false,
			navClass       : [
				'owl-prev wd-btn-arrow',
				'owl-next wd-btn-arrow'
			]
		};
	}

	woodmartThemeModule.shopLoadMoreBtn = '.wd-products-load-more.load-on-scroll';

	woodmartThemeModule.$window.on('elementor/frontend/init', function() {
		if (!elementorFrontend.isEditMode()) {
			return;
		}

		if ('enabled' === woodmart_settings.elementor_no_gap) {
			$.each([
				'frontend/element_ready/section',
				'frontend/element_ready/container'
			], function(index, value) {
				woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
					if ($wrapper.attr('style') && $wrapper.attr('style').indexOf('transform:translate3d') === 0 && !$wrapper.hasClass('wd-parallax-on-scroll')) {
						$wrapper.attr('style', '');
					}

					$wrapper.removeClass('wd-animated');
					$wrapper.data('wd-waypoint', '');
					$wrapper.removeClass('wd-anim-ready');
					woodmartThemeModule.$document.trigger('wdElementorSectionReady');
				});

				elementorFrontend.hooks.addAction(value, function($wrapper) {
					var cid = $wrapper.data('model-cid');

					if (typeof elementorFrontend.config.elements.data[cid] !== 'undefined') {
						var size = '';

						if ('undefined' !== typeof elementorFrontend.config.elements.data[cid].attributes.elType) {
							if ('container' === elementorFrontend.config.elements.data[cid].attributes.elType) {
								size = elementorFrontend.config.elements.data[cid].attributes.boxed_width.size;
							} else if ('section' === elementorFrontend.config.elements.data[cid].attributes.elType) {
								size = elementorFrontend.config.elements.data[cid].attributes.content_width.size;
							}
						}

						if (!size) {
							$wrapper.addClass('wd-negative-gap');
						}
					}
				});
			});

			elementor.channels.editor.on('change:section change:container', function(view) {
				var changed = view.elementSettingsModel.changed;
				if (typeof changed.content_width !== 'undefined' || typeof changed.boxed_width !== 'undefined') {
					var size = [];

					if ( typeof changed.content_width !== 'undefined' ) {
						size = changed.content_width.size;
					} else if ( typeof changed.boxed_width !== 'undefined' ) {
						size = changed.boxed_width.size
					}

					var sectionId = view._parent.model.id;
					var $section = $('.elementor-element-' + sectionId);

					if (size) {
						$section.removeClass('wd-negative-gap');
					} else {
						$section.addClass('wd-negative-gap');
					}
				}
			});
		}
	});

	woodmartThemeModule.$window.on('load', function() {
		$('.wd-preloader').delay(parseInt(woodmart_settings.preloader_delay)).addClass('preloader-hide');
		$('.wd-preloader-style').remove();
		setTimeout(function() {
			$('.wd-preloader').remove();
		}, 200);
	});

	woodmartThemeModule.googleMapsCallback = function () {
		return '';
	};
})(jQuery);

window.onload = function() {
	var events = [
		'keydown',
		'scroll',
		'mouseover',
		'touchmove',
		'touchstart',
		'mousedown',
		'mousemove'
	];

	var triggerListener = function(e) {
		jQuery(window).trigger('wdEventStarted');
		removeListener();
	};

	var removeListener = function() {
		events.forEach(function(eventName) {
			window.removeEventListener(eventName, triggerListener);
		});
	};

	var addListener = function(eventName) {
		window.addEventListener(eventName, triggerListener);
	};

	events.forEach(function(eventName) {
		addListener(eventName);
	});
};