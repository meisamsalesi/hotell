/* global woodmart_settings */

(function($) {
	woodmartThemeModule.siteScroll = function() {
		if ( window.innerWidth > woodmartThemeModule.windowWidth ) {
			$('html').addClass('wd-scrollbar');
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.siteScroll();
	});
})(jQuery);