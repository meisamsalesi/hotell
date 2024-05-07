/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function () {
		woodmartThemeModule.ajaxSearch();
	});

	$.each([
		'frontend/element_ready/wd_search.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.ajaxSearch();
		});
	});

	woodmartThemeModule.ajaxSearch = function() {
		if (typeof ($.fn.devbridgeAutocomplete) == 'undefined') {
			return;
		}

		var escapeRegExChars = function(value) {
			return value.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&');
		};

		$('form.woodmart-ajax-search').each(function() {
			var $this         = $(this),
			    number        = parseInt($this.data('count')),
			    thumbnail     = parseInt($this.data('thumbnail')),
			    symbols_count = parseInt($this.data('symbols_count')),
			    productCat    = $this.find('[name="product_cat"]'),
				$parent       = $this.parent(),
				$results      = $parent.find('.wd-dropdown-results > .wd-scroll-content'),
			    postType      = $this.data('post_type'),
			    url           = woodmart_settings.ajaxurl + '?action=woodmart_ajax_search',
			    price         = parseInt($this.data('price')),
			    sku           = $this.data('sku'),
				isFullScreen2 = $this.parents('.wd-search-full-screen-2').length,
				$parentResult = $parent.find('.wd-dropdown-results');

			if (number > 0) {
				url += '&number=' + number;
			}
			url += '&post_type=' + postType;

			$results.on('click', '.view-all-results', function() {
				$this.submit();
			});

			if (productCat.length && productCat.val() !== '') {
				url += '&product_cat=' + productCat.val();
			}

			$this.find('[type="text"]').on('focus keyup cat_selected', function(e) {
				let $input         = $(this);
				let serviceUrlData = {
					'action': 'woodmart_ajax_search',
					'number': number > 0 ? number : undefined,
					'post_type': postType,
				};

				if ( isFullScreen2 ) {
					$parentResult.removeClass('wd-no-results');
				}

				if ( ! $input.hasClass('wd-search-inited') ) {
					$input.devbridgeAutocomplete({
						serviceUrl      : url,
						appendTo        : $results,
						minChars        : symbols_count,
						deferRequestBy  : woodmart_settings.ajax_search_delay,
						onSelect        : function(suggestion) {
							if (suggestion.permalink.length > 0) {
								window.location.href = suggestion.permalink;
							}
						},
						onHide          : function() {
							$parentResult.removeClass('wd-opened');
						},
						onSearchStart   : function() {
							$this.addClass('search-loading');
						},
						beforeRender    : function(container) {
							$(container).find('.suggestion-divider-title').parent().addClass('suggestion-divider');
							$(container).find('.no-found-msg').parent().addClass('suggestion-no-found');
							if (container[0].childElementCount > 2) {
								$(container).append('<div class="view-all-results"><span>' + woodmart_settings.all_results + '</span></div>');
							}

							$(container).removeAttr('style');
						},
						onSearchComplete: function() {
							$this.removeClass('search-loading');

							woodmartThemeModule.$document.trigger('wood-images-loaded');

						},
						formatResult    : function(suggestion, currentValue) {
							if (currentValue === '&') {
								currentValue = '&#038;';
							}
							var pattern     = '(' + escapeRegExChars(currentValue) + ')',
								returnValue = '';

							if (suggestion.divider) {
								returnValue += ' <h5 class="suggestion-divider-title">' + suggestion.divider + '</h5>';
							}

							if (thumbnail && suggestion.thumbnail) {
								returnValue += ' <div class="suggestion-thumb">' + suggestion.thumbnail + '</div>';
							}

							if (suggestion.value) {
								returnValue += ' <div class="suggestion-content set-cont-mb-s reset-last-child">';
								returnValue += '<h4 class="wd-entities-title">' + suggestion.value
									.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>')
									.replace(/&lt;(\/?strong)&gt;/g, '<$1>') + '</h4>';
							}

							if (sku && suggestion.sku) {
								returnValue += ' <p class="suggestion-sku">' + suggestion.sku + '</p>';
							}

							if (price && suggestion.price) {
								returnValue += ' <p class="price">' + suggestion.price + '</p>';
							}

							if (suggestion.value) {
								returnValue += ' </div>';
							}

							if (suggestion.products_not_found) {
								returnValue = '<span class="no-found-msg">' + suggestion.value + '</span>';
							}

							if (isFullScreen2 && suggestion.no_results) {
								$parentResult.addClass('wd-no-results');
							}

							$parentResult.addClass('wd-opened');
							$this.parents('div[class*=\'wd-search-full-\']').addClass('wd-searched');

							return returnValue;
						}
					});

					$input.addClass('wd-search-inited');
				}

				if ( productCat.length  && 'cat_selected' === e.type ) {
					if (  '' !== productCat.val() ) {
						serviceUrlData['product_cat'] = productCat.val();
					}

					let searchForm = $this.find('[type="text"]').devbridgeAutocomplete()
					let serviceUrl = woodmart_settings.ajaxurl + '?' + new URLSearchParams(serviceUrlData).toString();

					searchForm.setOptions({
						serviceUrl: serviceUrl
					});

					searchForm.hide();
					searchForm.onValueChange();
				}
			});

			woodmartThemeModule.$document.on('click', function(e) {
				var target = e.target;

				if (!$(target).is('.wd-search-form') && !$(target).parents().is('.wd-search-form') && !$(target).is('.wd-search-full-screen') && !$(target).parents().is('.wd-search-full-screen')) {
					$this.find('[type="text"]').devbridgeAutocomplete('hide');
				}
			});

			$('.wd-dropdown-results > .wd-scroll-content').on('click', function(e) {
				e.stopPropagation();
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.ajaxSearch();
	});
})(jQuery);