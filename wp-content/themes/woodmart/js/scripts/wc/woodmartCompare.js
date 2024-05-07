/* global woodmart_settings */
(function($) {
	woodmartThemeModule.woodmartCompare = function() {
		var cookiesName = 'woodmart_compare_list';

		if (woodmart_settings.is_multisite) {
			cookiesName += '_' + woodmart_settings.current_blog_id;
		}

		if ( typeof Cookies === 'undefined' ) {
			return;
		}

		var $body         = woodmartThemeModule.$body,
		    $widget       = $('.wd-header-compare'),
		    compareCookie = Cookies.get(cookiesName);

		if ($widget.length > 0) {
			if ('undefined' !== typeof compareCookie) {
				try {
					var ids = JSON.parse(compareCookie);
					$widget.find('.wd-tools-count').text(ids.length);
				}
				catch (e) {
					console.log('cant parse cookies json');
				}
			} else {
				$widget.find('.wd-tools-count').text(0);
			}

			if ( 'undefined' !== typeof woodmart_settings.compare_by_category && 'yes' === woodmart_settings.compare_by_category ) {
				try {
					getProductsCategory();
				}
				catch (e) {
					getAjaxProductCategory();
				}
			}
		}

		$body.on('click', '.wd-compare-btn a', function(e) {
			var $this     = $(this),
			    id        = $this.data('id'),
			    $widget = $('.wd-header-compare');

			if ($this.hasClass('added')) {
				return true;
			}

			e.preventDefault();

			if ( ! $widget.find('.wd-dropdown-compare').length ) {
				var products = [];
				var productsCookies = Cookies.get(cookiesName);

				if ( 'undefined' !== typeof productsCookies && productsCookies ) {
					products = Object.values( JSON.parse(productsCookies) );
				}

				if ( ! products.length || -1 === products.indexOf(id.toString()) ) {
					products.push( id.toString() );
				}

				var count = products.length;

				updateCountWidget(count);

				Cookies.set(cookiesName, JSON.stringify(products), {
					expires: 7,
					path   : '/',
					secure : woodmart_settings.cookie_secure_param
				});

				updateButton( $this );

				return;
			}

			$this.addClass('loading');

			jQuery.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action: 'woodmart_add_to_compare',
					id    : id
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if ( response.count ) {
						var $widget = $('.wd-header-compare');

						if ($widget.length > 0) {
							$widget.find('.wd-tools-count').text(response.count);
						}

						updateButton( $this );
					} else {
						console.log('something wrong loading compare data ', response);
					}

					if (response.fragments) {
						$.each( response.fragments, function( key, value ) {
							$( key ).replaceWith(value);
						});

						sessionStorage.setItem( cookiesName + '_fragments', JSON.stringify( response.fragments ) );
					}
				},
				error   : function() {
					console.log('We cant add to compare. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$this.removeClass('loading');
				}
			});
		});

		$body.on('click', '.wd-compare-remove', function(e) {
			e.preventDefault();
			var $this      = $(this),
			    id         = $this.data('id'),
				categoryId = '';

			if ('undefined' !== typeof woodmart_settings.compare_by_category && 'yes' === woodmart_settings.compare_by_category) {
				categoryId = $this.parents('.wd-compare-table').data('category-id');

				if ( categoryId && 1 >= $this.parents('.compare-value').siblings().length ) {
					removeProductCategory( categoryId, $this.parents('.wd-compare-page') );
					return;
				}
			}

			$this.addClass('loading');

			jQuery.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action     : 'woodmart_remove_from_compare',
					id         : id,
					category_id: categoryId,
					key        : woodmart_settings.compare_page_nonce,
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response.table) {
						updateCompare(response);

						if (response.fragments) {
							$.each( response.fragments, function( key, value ) {
								$( key ).replaceWith(value);
							});

							sessionStorage.setItem( cookiesName + '_fragments', JSON.stringify( response.fragments ) );
						}
					} else {
						console.log('something wrong loading compare data ', response);
					}
				},
				error   : function() {
					console.log('We cant remove product compare. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$this.remove('loading');
				}
			});
		});

		$body.on('change', '.wd-compare-select', function (e) {
			e.preventDefault();

			var $this = $(this);
			var $wrapper = $this.parents('.wd-compare-page');
			var $activeCompareTable = $wrapper.find('.wd-compare-table[data-category-id=' + $this.val() + ']');
			var $oldActiveCompareTable = $wrapper.find('.wd-compare-table.wd-active');
			var animationTime = 100;

			$wrapper.find('.wd-compare-cat-link').attr( 'href', $activeCompareTable.data('category-url') );

			$oldActiveCompareTable.removeClass('wd-in');

			setTimeout(function() {
				$oldActiveCompareTable.removeClass('wd-active');
			}, animationTime);

			setTimeout(function() {
				$activeCompareTable.addClass('wd-active');
			}, animationTime);

			setTimeout(function() {
				$activeCompareTable.addClass('wd-in');
				woodmartThemeModule.$document.trigger('wood-images-loaded');
			}, animationTime * 2);
		});

		$body.on('click', '.wd-compare-remove-cat', function (e) {
			e.preventDefault();

			var $this = $(this);
			var activeCategory = $this.parents('.wd-compare-header').find('.wd-compare-select').val();
			var $wrapper = $this.parents('.wd-compare-page');

			removeProductCategory( activeCategory, $wrapper );
		});

		function removeProductCategory( activeCategory, $wrapper ) {
			var $loader = $wrapper.find('.wd-loader-overlay');

			$loader.addClass('wd-loading');

			jQuery.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action     : 'woodmart_remove_category_from_compare',
					category_id: activeCategory,
					key        : woodmart_settings.compare_page_nonce,
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response.table) {
						updateCompare(response);

						if (response.fragments) {
							$.each( response.fragments, function( key, value ) {
								$( key ).replaceWith(value);
							});

							sessionStorage.setItem( cookiesName + '_fragments', JSON.stringify( response.fragments ) );
						}
					} else {
						console.log('something wrong loading compare data ', response);
					}
				},
				error   : function() {
					console.log('We cant remove product compare. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$loader.removeClass('wd-loading');

					var $compareTable = $('.wd-compare-table').first();

					setTimeout(function() {
						$compareTable.addClass('wd-active');
					}, 100);

					setTimeout(function() {
						$compareTable.addClass('wd-in');
						woodmartThemeModule.$document.trigger('wood-images-loaded');
					}, 200);
				}
			});
		}

		function updateCompare(data) {
			var $widget = $('.wd-header-compare');

			if ($widget.length > 0) {
				$widget.find('.wd-tools-count').text(data.count);
			}

			woodmartThemeModule.removeDuplicatedStylesFromHTML(data.table, function(html) {
				var $wcCompareWrapper = $('.wd-compare-page');
				var $wcCompareTable = $('.wd-compare-table');

				if ($wcCompareWrapper.length > 0) {
					$wcCompareWrapper.replaceWith(html);
				} else if ($wcCompareTable.length > 0) {
					$wcCompareTable.replaceWith(html);
				}
			});

			if ('undefined' !== typeof woodmart_settings.compare_by_category && 'yes' === woodmart_settings.compare_by_category) {
				woodmartThemeModule.$document.trigger('wdTabsInit');
			}
		}

		function getProductsCategory() {
			if ( woodmartThemeModule.supports_html5_storage ) {
				var fragmentProductCategory = JSON.parse( sessionStorage.getItem( cookiesName + '_fragments' ) );

				if ( 'undefined' !== typeof actions && ( actions.is_lang_switched === '1' || actions.force_reset === '1' ) ) {
					fragmentProductCategory = '';
				}

				if ( fragmentProductCategory ) {
					$.each( fragmentProductCategory, function( key, value ) {
						$( key ).replaceWith(value);
					});
				} else {
					getAjaxProductCategory();
				}
			} else {
				getAjaxProductCategory();
			}
		}

		function getAjaxProductCategory() {
			jQuery.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action : 'woodmart_get_fragment_product_category_compare',
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response.fragments) {
						$.each( response.fragments, function( key, value ) {
							$( key ).replaceWith(value);
						});

						sessionStorage.setItem( cookiesName + '_fragments', JSON.stringify( response.fragments ) );
					} else {
						console.log('something wrong loading compare data ', response);
					}
				},
				error   : function() {
					console.log('We cant remove product compare. Something wrong with AJAX response. Probably some PHP conflict.');
				},
			});
		}

		function updateButton( $button ) {
			var addedText = $button.data('added-text');

			if ($button.find('span').length > 0) {
				$button.find('span').text(addedText);
			} else {
				$button.text(addedText);
			}

			$button.addClass('added');

			woodmartThemeModule.$document.trigger('added_to_compare');
			woodmartThemeModule.$document.trigger('wdUpdateTooltip', $button);
		}

		function updateCountWidget(count) {
			var $widget = $('.wd-header-compare');

			if ($widget.length > 0) {
				$widget.find('.wd-tools-count').text(count);
			}
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.woodmartCompare();
	});
})(jQuery);
