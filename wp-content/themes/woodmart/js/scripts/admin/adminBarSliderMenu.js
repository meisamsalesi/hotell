/* global woodmart_settings */
(function($) {
	woodmartThemeModule.adminBarSliderMenu = function() {
		var $sliderWrapper = $('.wd-slider-wrapper');
		var $adminBar = $('#wpadminbar');

		if ($sliderWrapper.length > 0 && $adminBar.length > 0) {
			$sliderWrapper.each(function() {
				var $slider = $(this);
				var sliderId = $slider.data('id');
				var sliderData = $slider.data('slider');
				var $sliderSubMenu = $('#wp-admin-bar-xts_sliders > .ab-sub-wrapper > .ab-submenu');

				if (!sliderData) {
					return;
				}

				$sliderSubMenu.append('<li id="' + sliderId + '" class="menupop"><a href="' + sliderData.url + '" class="ab-item" target="_blank">' + sliderData.title + '<span class="wp-admin-bar-arrow" aria-hidden="true"></span></a><div class="ab-sub-wrapper"><ul class="ab-submenu"></ul></div></li>');

				$slider.find('.wd-slide').each(function() {
					var $slide = $(this);
					var slideData = $slide.data('slide');

					$sliderSubMenu.find('#' + sliderId + ' > .ab-sub-wrapper > .ab-submenu').append('<li><a href="' + slideData.url + '" class="ab-item" target="_blank">' + slideData.title + '</a></li>');
				});
			});
		}
	};

	woodmartThemeModule.adminBarSliderMenu();
})(jQuery);
