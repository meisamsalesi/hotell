/* global woodmart_settings */
(function($) {
	woodmartThemeModule.wishlist = function() {
		var countCookiesName = 'woodmart_wishlist_count';
		var productCookiesName = 'woodmart_wishlist_products';

		if (woodmartThemeModule.$body.hasClass('logged-in')) {
			countCookiesName += '_logged';
		}

		if (woodmart_settings.is_multisite) {
			countCookiesName += '_' + woodmart_settings.current_blog_id;
			productCookiesName += '_' + woodmart_settings.current_blog_id;
		}

		if ( typeof Cookies === 'undefined' ) {
			return;
		}

		var cookie = Cookies.get(countCookiesName);
		var count = 0;

		if ('undefined' !== typeof cookie) {
			try {
				count = JSON.parse(cookie);
			}
			catch (e) {
				console.log('cant parse cookies json');
			}
		}

		if ( 'undefined' === typeof woodmart_settings.wishlist_expanded || 'yes' !== woodmart_settings.wishlist_expanded) {
			updateCountWidget(count);
		}

		// Add to wishlist action
		woodmartThemeModule.$body.on('click', '.wd-wishlist-btn a', function(e) {
			var $this = $(this);

			if (!$this.hasClass('added')) {
				e.preventDefault();
			} else {
				return true;
			}

			var productId = $this.data('product-id');
			var key = $this.data('key');

			if ( woodmartThemeModule.$body.hasClass('logged-in') || typeof Cookies === 'undefined' ) {
				$this.addClass('loading');

				if ( 'undefined' !== typeof woodmart_settings.wishlist_expanded && 'yes' === woodmart_settings.wishlist_expanded && 'disable' !== woodmart_settings.wishlist_show_popup && woodmartThemeModule.$body.hasClass('logged-in') ) {
					woodmartThemeModule.$document.trigger('wdShowWishlistGroupPopup', [ productId, key ] );
					return;
				}

				addProductWishlistAJAX( productId, '', key );
			} else {
				var products = {};
				var wishlistCookies = Cookies.get(productCookiesName);

				if ( 'undefined' !== typeof wishlistCookies && wishlistCookies ) {
					var cookiesProducts = JSON.parse(wishlistCookies);

					if ( Object.keys(cookiesProducts).length ) {
						products = cookiesProducts;
					}
				}

				products[ productId ] = {
					'product_id' : productId
				}

				var count = Object.keys(products).length

				updateCountWidget(count);

				Cookies.set(productCookiesName, JSON.stringify(products), {
					expires: 7,
					path   : '/',
					secure : woodmart_settings.cookie_secure_param
				});
				Cookies.set(countCookiesName, count, {
					expires: 7,
					path   : '/',
					secure : woodmart_settings.cookie_secure_param
				});

				updateButton( $this );
			}
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-remove', function(e) {
			e.preventDefault();

			var $this = $(this);
			var groupId = '';

			if ( $this.parents('.wd-wishlist-group').length ) {
				groupId = $this.parents('.wd-wishlist-group').data('group-id');
			}

			$this.addClass('loading');

			if ( woodmartThemeModule.$body.hasClass('logged-in') || 'undefined' === typeof Cookies || 1 === $this.parents('.products.elements-grid').find('.product-grid-item').length ) {
				removeProductWishlistAJAX(
					$this.data('product-id'),
					groupId,
					$this.parents('.wd-products-holder'),
					function () {
						$this.removeClass('loading');
					}
				);
			} else {
				$this.parents('.product-grid-item').remove();

				var wishlistCookies = Cookies.get(productCookiesName);
				var products = {};

				if ( 'undefined' !== typeof wishlistCookies && wishlistCookies ) {
					products = JSON.parse(wishlistCookies);

					if ( Object.keys(products).length ) {
						delete products[$this.data('product-id')];
					}
				}

				var count = Object.keys(products).length;

				updateCountWidget( count );

				Cookies.set(productCookiesName, JSON.stringify(products), {
					expires: 7,
					path   : '/',
					secure : woodmart_settings.cookie_secure_param
				});
				Cookies.set(countCookiesName, count, {
					expires: 7,
					path   : '/',
					secure : woodmart_settings.cookie_secure_param
				});
			}
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-checkbox', function(e) {
			var $this = $(this);
			var $parent = $this.parents('.product-grid-item');
			var $bulkAction = $this.parents('.wd-products-element').siblings('.wd-wishlist-bulk-action');
			var $selectAllBtn = $bulkAction.find('.wd-wishlist-select-all');

			$parent.toggleClass('wd-current-product');

			if ( $selectAllBtn.hasClass('wd-selected') && $bulkAction.hasClass('wd-visible') && ! $parent.hasClass('wd-current-product') ) {
				$selectAllBtn.removeClass('wd-selected');
			}

			if ( $parent.siblings('.product').length === $parent.siblings('.wd-current-product').length && $parent.hasClass('wd-current-product') ) {
				$selectAllBtn.addClass('wd-selected');
			}

			if ( ! $parent.siblings('.wd-current-product').length && $bulkAction.hasClass('wd-visible') && ! $parent.hasClass('wd-current-product') ) {
				$bulkAction.removeClass('wd-visible');
			} else {
				$bulkAction.addClass('wd-visible');
			}
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-remove-action > a', function(e) {
			e.preventDefault();

			var $this = $(this);
			var $productWrapper = $this.parents('.wd-wishlist-bulk-action').siblings('.wd-products-element').find('.products');
			var $products = $productWrapper.find('.wd-current-product');
			var productsId = [];
			var groupId = '';

			if ( !$products.length || ! confirm(woodmart_settings.wishlist_remove_notice) ) {
				return;
			}

			$this.addClass('loading');

			if ( $this.parents('.wd-wishlist-group').length ) {
				groupId = $this.parents('.wd-wishlist-group').data('group-id');
			}

			$products.each(function () {
				productsId.push($(this).data('id'));
			});

			removeProductWishlistAJAX( productsId, groupId, $productWrapper, function () {
				$this.parents('.wd-wishlist-bulk-action').removeClass('wd-visible');
				$this.removeClass('loading');
			} );
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-select-all > a', function(e) {
			e.preventDefault();

			var $this = $(this).parent();
			var $productWrapper = $this.parents('.wd-wishlist-bulk-action').siblings('.wd-products-element').find('.products');

			if ( $this.hasClass('wd-selected') ) {
				$productWrapper.find('.product').removeClass('wd-current-product').find('.wd-wishlist-checkbox').prop('checked', false);
				$this.removeClass('wd-selected');
				$this.parents('.wd-wishlist-bulk-action').removeClass('wd-visible');
			} else {
				$productWrapper.find('.product').addClass('wd-current-product').find('.wd-wishlist-checkbox').prop('checked', true);
				$this.addClass('wd-selected');
			}
		});


		woodmartThemeModule.$document.on('wdAddProductToWishlist', function (event, productId, groupId, key, callback) {
			addProductWishlistAJAX( productId, groupId, key, callback );
		});

		woodmartThemeModule.$document.on('wdRemoveProductToWishlist', function (event, productId, groupId, $productWrapper, callback) {
			removeProductWishlistAJAX( productId, groupId, $productWrapper, callback );
		});

		woodmartThemeModule.$document.on('wdUpdateWishlistContent', function (event, response) {
			updateWishlist(response);
		});

		// Elements update after ajax
		function updateWishlist(data) {
			var $wishlistContent = $('.wd-wishlist-content');

			updateCountWidget(data.count);

			if ($wishlistContent.length > 0 && !$wishlistContent.hasClass('wd-wishlist-preview')) {
				woodmartThemeModule.removeDuplicatedStylesFromHTML(data.wishlist_content, function(html) {
					$wishlistContent.replaceWith(html);

					woodmartThemeModule.$document.trigger('wdUpdateWishlist');
				});
			}
		}

		// Update product wishlist after ajax.
		function updateWishlistProducts(data, $wrapper) {
			if ( $wrapper.length && ! $('.wd-wishlist-content').hasClass('wd-wishlist-preview')) {
				woodmartThemeModule.removeDuplicatedStylesFromHTML(data.wishlist_content, function(html) {
					$wrapper.replaceWith(html);

					woodmartThemeModule.$document.trigger('wdUpdateWishlist');
				});
			}

			setTimeout( function () {
				var $pagination = $('.wd-wishlist-content .wd-pagination').find('a.page-numbers');

				if ( $pagination.length ) {
					$pagination.each( function () {
						var $this = $(this);

						var href = $this.attr('href').split('product-page=')[1];
						var page = parseInt( href );

						$this.attr( 'href', window.location.origin + window.location.pathname + '?product-page=' + page );
					});
				}
			}, 500 );
		}

		function updateCountWidget(count) {
			var $widget = $('.wd-header-wishlist');

			if ($widget.length > 0) {
				$widget.find('.wd-tools-count').text(count);
			}
		}

		// Add product in wishlist.
		function addProductWishlistAJAX( productId, group, key, callback = '' ) {
			var $this = $('a[data-product-id=' + productId + ']');

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action    : 'woodmart_add_to_wishlist',
					product_id: productId,
					group     : group,
					key       : key
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response) {
						if ( response.count ) {
							updateCountWidget(response.count);
						}

						if (response.fragments) {
							woodmartThemeModule.$document.trigger('wdWishlistSaveFragments', [response.fragments, response.hash]);

							$.each( response.fragments, function( key, html ) {
								woodmartThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
									$( key ).replaceWith(html);
								});
							});
						}

						updateButton( $this );
					} else {
						console.log('something wrong loading wishlist data ', response);
					}

					if ( callback ) {
						callback()
					}
				},
				error   : function() {
					console.log('We cant add to wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$this.removeClass('loading');
				}
			});
		}

		function removeProductWishlistAJAX( productId, groupId, $productsWrapper, callback = '' ) {
			var productsAtts = '';

			if ( 'undefined' !== typeof $productsWrapper.data('atts') ) {
				productsAtts = $productsWrapper.data('atts');

				productsAtts.ajax_page = $productsWrapper.attr('data-paged');
			}

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action    : 'woodmart_remove_from_wishlist',
					product_id: productId,
					group_id  : groupId,
					key       : woodmart_settings.wishlist_page_nonce,
					atts      : productsAtts,
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response.wishlist_content) {
						updateCountWidget(response.count);
						updateWishlistProducts(response, $productsWrapper.parents('.wd-products-element'));
					} else {
						console.log('something wrong loading wishlist data ', response);
					}

					if (response.fragments) {
						woodmartThemeModule.$document.trigger('wdUpdateWishlistFragments', [response.fragments, response.hash]);
					}

					if ( callback ) {
						callback()
					}
				},
				error   : function() {
					console.log('We cant remove from wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
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

			woodmartThemeModule.$document.trigger('added_to_wishlist');
			woodmartThemeModule.$document.trigger('wdUpdateTooltip', $button);
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.wishlist();
	});
})(jQuery);
