/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdBackHistory wdProductsTabsLoaded wdSearchFullScreenContentLoaded wdActionAfterAddToCart wdShopPageInit wdArrowsLoadProducts wdLoadMoreLoadProducts wdUpdateWishlist wdQuickViewOpen wdQuickShopSuccess wdProductBaseHoverIconsResize wdRecentlyViewedProductLoaded updated_checkout updated_cart_totals', function () {
		woodmartThemeModule.btnsToolTips();
	});

	woodmartThemeModule.$document.on('wdUpdateTooltip', function (e, $this) {
		woodmartThemeModule.updateTooltip($this);
	});

	$.each([
		'frontend/element_ready/wd_products.default',
		'frontend/element_ready/wd_products_tabs.default',
		'frontend/element_ready/wd_single_product_nav.default',
		'frontend/element_ready/wd_single_product_size_guide_button.default',
		'frontend/element_ready/wd_single_product_compare_button.default',
		'frontend/element_ready/wd_single_product_wishlist_button.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.btnsToolTips();
		});
	});

	woodmartThemeModule.btnsToolTips = function() {
		$('.woodmart-css-tooltip, .wd-buttons[class*="wd-pos-r"] div > a').on('mouseenter touchstart', function () {
			var $this = $(this);

			if ($this.hasClass('wd-tooltip-inited')) {
				return;
			}

			$this.find('.wd-tooltip-label').remove();
			$this.addClass('wd-tltp').prepend('<span class="wd-tooltip-label">' + $this.text() + '</span>');

			$this.addClass('wd-tooltip-inited');
		});

		// Bootstrap tooltips
		$('.wd-tooltip, .wd-hover-icons .wd-buttons .wd-action-btn:not(.wd-add-btn) > a, .wd-hover-icons .wd-buttons .wd-add-btn, body:not(.catalog-mode-on):not(.login-see-prices) .wd-hover-base .wd-bottom-actions .wd-action-btn.wd-style-icon:not(.wd-add-btn) > a, body:not(.catalog-mode-on):not(.login-see-prices) .wd-hover-base .wd-bottom-actions .wd-action-btn.wd-style-icon.wd-add-btn, .wd-hover-base .wd-compare-btn > a, .wd-products-nav .wd-btn-back, .wd-single-action-btn .wd-action-btn.wd-style-icon a').on('mouseenter touchstart', function() {
			var $this = $(this);

			if (!$this.hasClass('wd-hint') && woodmartThemeModule.windowWidth <= 1024 || $this.hasClass('wd-tooltip-inited')) {
				return;
			}

			$this.tooltip({
				animation: false,
				container: 'body',
				trigger  : 'hover',
				boundary: 'window',
				title    : function() {
					var $this = $(this);

					if ($this.find('.added_to_cart').length > 0) {
						return $this.find('.add_to_cart_button').text();
					}

					if ($this.find('.add_to_cart_button').length > 0) {
						return $this.find('.add_to_cart_button').text();
					}

					if ($this.find('.wd-swatch-text').length > 0) {
						return $this.find('.wd-swatch-text').text();
					}

					return $this.text();
				}
			});

			$this.tooltip('show');

			$this.addClass('wd-tooltip-inited');
		});
	};

	woodmartThemeModule.updateTooltip = function($this) {
		var $tooltip = $($this);

		if ( !$tooltip.hasClass('wd-tooltip-inited') ) {
			$tooltip = $tooltip.parent('.wd-tooltip-inited');
		}

		if (woodmartThemeModule.windowWidth <= 1024 || !$tooltip.hasClass('wd-tooltip-inited') || 'undefined' === typeof ($.fn.tooltip) || !$tooltip.is(':hover')) {
			return;
		}

		$tooltip.tooltip('update').tooltip('show');
	};

	$(document).ready(function() {
		woodmartThemeModule.btnsToolTips();
	});
})(jQuery);

