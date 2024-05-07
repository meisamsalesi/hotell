/* global woodmart_settings */
(function($) {
	woodmartThemeModule.checkoutRemove = function() {
		woodmartThemeModule.$document.on('click', '.wd-checkout-remove-btn', function() {
			$(this)
				.closest('.woocommerce-checkout-review-order-table')
				.append('<div class="wd-loader-overlay wd-fill wd-loading"></div>');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.checkoutRemove();
	});
})(jQuery);
