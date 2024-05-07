/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit wdArrowsLoadProducts wdLoadMoreLoadProducts wdProductsTabsLoaded wdSearchFullScreenContentLoaded wdRecentlyViewedProductLoaded wdQuickViewOpen', function () {
		woodmartThemeModule.swatchesLimit();
	});

	woodmartThemeModule.swatchesLimit = function() {
		$('.wd-swatch-divider, .product-grid-item .wd-swatches-product:not(.wd-all-shown) .wd-swatch').on('click', function() {
			var $this = $(this).parent();

			if ( $this.parents('.wd-swatches-single').length || $this.hasClass('wd-swatches-single') ) {
				var $form = $this.parents('.variations_form');

				$form.find('.wd-swatches-single').removeClass('wd-swatches-limited').addClass('wd-all-shown');
				$form.find('.wd-swatch').removeClass('wd-hidden');
			} else {
				$this.addClass('wd-all-shown');
				$this.find('.wd-swatch').removeClass('wd-hidden');
			}

			woodmartThemeModule.$document.trigger('wood-images-loaded');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.swatchesLimit();
	});
})(jQuery);
