/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function() {
		woodmartThemeModule.widgetCollapse();
	});

	woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
		woodmartThemeModule.widgetCollapse();
	}, 300));

	woodmartThemeModule.widgetCollapse = function() {
		var $footer = $('.main-footer .footer-widget');

		if ('yes' === woodmart_settings.collapse_footer_widgets && 0 < $footer.length) {
			if (woodmartThemeModule.$window.innerWidth() <= 575) {
				$footer.addClass('wd-widget-collapse');
			} else {
				$footer.removeClass('wd-widget-collapse');
				$footer.find('> *:not(.widget-title)').show();
			}
		}

		$('.wd-widget-collapse .widget-title').off('click').on('click', function() {
			var $title = $(this);
			var $widget = $title.parent();
			var $content = $widget.find('> *:not(.widget-title)');

			if ($widget.hasClass('wd-opened')) {
				$widget.removeClass('wd-opened');
				$content.stop().slideUp(200);
			} else {
				$widget.addClass('wd-opened');
				$content.stop().slideDown(200);
				woodmartThemeModule.$document.trigger('wood-images-loaded');
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.widgetCollapse();
	});

	window.addEventListener('popstate', function() {
		woodmartThemeModule.widgetCollapse();
	});
})(jQuery);
