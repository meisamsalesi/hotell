/* global woodmart_settings */
(function($) {
	woodmartThemeModule.productRecentlyViewed = function() {
		$('.wd-products-element .products, .wd-carousel-container.products').each( function () {
			var $this = $(this);
			var attr = $this.data('atts');

			if ( 'undefined' === typeof attr || 'undefined' === typeof attr.post_type || 'recently_viewed' !== attr.post_type || 'undefined' === typeof attr.ajax_recently_viewed || 'yes' !== attr.ajax_recently_viewed ) {
				return;
			}

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					attr  : attr,
					action: 'woodmart_get_recently_viewed_products'
				},
				dataType: 'json',
				method  : 'POST',
				success : function(data) {
					if (data.items) {
						if ( $this.hasClass('wd-carousel-container') && $this.parents('.elementor-widget-container').length ) {
							$this.replaceWith(data.items);
						} else {
							$this.parent().replaceWith(data.items);
						}

						woodmartThemeModule.$document.trigger('wdRecentlyViewedProductLoaded');
						woodmartThemeModule.$document.trigger('wood-images-loaded');
					}
				},
				error   : function() {
					console.log('ajax error');
				},
			});
		})
	};

	$(document).ready(function() {
		woodmartThemeModule.productRecentlyViewed();
	});
})(jQuery);