/* global woodmart_settings */
(function($) {
	woodmartThemeModule.singleProductTabsAccordion = function() {
		var $wcTabs = $('.woocommerce-tabs');
		var $wcTabItems = $wcTabs.find('.wd-accordion-item .entry-content');

		if ($wcTabs.length <= 0 || $wcTabs.data('layout') === 'accordion' || $('.site-content').hasClass('wd-builder-on')) {
			return;
		}

		if (woodmartThemeModule.$window.width() <= 1024) {
			if ( ! $wcTabs.hasClass('tabs-layout-accordion') ) {
				$wcTabs.removeClass('tabs-layout-tabs wc-tabs-wrapper').addClass('tabs-layout-accordion wd-accordion wd-style-default');
				$wcTabItems.addClass('wd-accordion-content wd-scroll').find('.wc-tab-inner').addClass('wd-scroll-content');
				$('.single-product-page').removeClass('tabs-type-tabs').addClass('tabs-type-accordion');
				if ($wcTabs.data('state') !== 'first' ) {
					$wcTabItems.first().hide().siblings('.wd-active').removeClass('wd-active');
				}
			}
		} else if ( ! $wcTabs.hasClass('tabs-layout-tabs') ) {
			$wcTabs.addClass('tabs-layout-tabs wc-tabs-wrapper').removeClass('tabs-layout-accordion wd-accordion wd-style-default');
			$wcTabItems.removeClass('wd-accordion-content wd-scroll').find('.wc-tab-inner').removeClass('wd-scroll-content');
			$('.single-product-page').addClass('tabs-type-tabs').removeClass('tabs-type-accordion');
			$wcTabs.find('.wd-nav a').first().trigger('click');
		}
	};

	woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
		woodmartThemeModule.singleProductTabsAccordion();
		woodmartThemeModule.accordion();
		woodmartThemeModule.$document.trigger('resize.vcRowBehaviour');
	}, 300));

	$(document).ready(function() {
		woodmartThemeModule.singleProductTabsAccordion();
	});
})(jQuery);
