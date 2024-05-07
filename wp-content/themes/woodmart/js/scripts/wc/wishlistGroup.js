/* global woodmart_settings */
(function($) {
	woodmartThemeModule.wishlistGroup = function() {
		if ( 'undefined' === typeof woodmart_settings.wishlist_expanded || 'yes' !== woodmart_settings.wishlist_expanded ) {
			return;
		}

		var fragmentsName   = woodmart_settings.wishlist_fragment_name;
		var cookiesHashName = 'woodmart_wishlist_hash';

		if (woodmart_settings.is_multisite) {
			cookiesHashName += '_' + woodmart_settings.current_blog_id;
		}

		try {
			updateWishlistGroup();
		}
		catch (e) {
			updateAjaxWishlistGroup();
		}

		woodmartThemeModule.$body.on('keyup', '.wd-wishlist-group-name', function(e) {
			if ('Enter' === e.key) {
				$('.btn.wd-wishlist-save-btn').trigger('click');
			}
		});

		woodmartThemeModule.$body.on('keyup', '.wd-wishlist-input-rename', function(e) {
			if ('Enter' === e.key) {
				$('.btn.wd-wishlist-rename-save').trigger('click');
			}
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-remove-group', function(e) {
			e.preventDefault();
			var $this = $(this);
			var groupId = $this.parents('.wd-wishlist-group').data('group-id');
			var $loading = $this.parents('.wd-wishlist-group').find('.wd-loader-overlay');

			if ( ! confirm(woodmart_settings.wishlist_remove_notice) ) {
				return;
			}

			$loading.addClass('wd-loading');

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action  : 'woodmart_remove_group_from_wishlist',
					group_id: groupId,
					key     : woodmart_settings.wishlist_page_nonce
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response.wishlist_content) {
						woodmartThemeModule.$document.trigger('wdUpdateWishlistContent', response, 'something' );
					} else {
						console.log('something wrong loading wishlist data ', response);
					}
					if ( response.fragments ) {
						updateFragments( response.fragments, response.hash );
					}
				},
				error   : function() {
					console.log('We cant remove from wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$loading.removeClass('wd-loading');
				}
			});
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-edit-title', function(e) {
			e.preventDefault();

			var $wrapper = $(this).parents('.wd-wishlist-group-head').find('.wd-wishlist-group-title');
			var $input = $wrapper.find('.wd-wishlist-input-rename');
			var title = $input.val();

			$wrapper.addClass('wd-edit');
			$input.val('').val(title).focus();

			woodmartThemeModule.$body.on('mouseup', function(e) {
				var $this = $(this);
				var $inputWrapper = $('.wd-wishlist-group-title.wd-edit');

				if ( $inputWrapper.length ) {
					var $headerGroup = $inputWrapper.parents('.wd-wishlist-group-head');
					if (!$headerGroup.is(e.target) && $headerGroup.has(e.target).length === 0) {
						$inputWrapper.removeClass('wd-edit');
						$this.off(e);
					}
				} else {
					$this.off(e);
				}
			});
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-rename-cancel', function(e) {
			e.preventDefault();

			$(this).parents('.wd-wishlist-group-title').removeClass('wd-edit');
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-rename-save', function(e) {
			e.preventDefault();

			var $this = $(this);
			var $wrapper = $this.parents('.wd-wishlist-group-title');
			var $groupWrapper = $this.parents('.wd-wishlist-group');
			var $input = $this.siblings('.wd-wishlist-input-rename');
			var title = $input.val();
			var group_id = $groupWrapper.data('group-id');

			if ( ! title ) {
				alert(woodmart_settings.wishlist_rename_group_notice);

				return;
			}

			if ( $input.data('title') === title ) {
				$wrapper.removeClass('wd-edit');
				return;
			}

			$this.addClass('loading');

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action  : 'woodmart_rename_wishlist_group',
					title   : title,
					group_id: group_id,
					key     : woodmart_settings.wishlist_page_nonce,
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response) {
						$wrapper.find('>.title').text(title);
						$input.data('title', title);
					} else {
						console.log('something wrong loading wishlist data ', response);
					}

					if ( response.fragments ) {
						updateFragments( response.fragments, response.hash );
					}
				},
				error   : function() {
					console.log('We cant add to wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$wrapper.removeClass('wd-edit');
					$this.removeClass('loading');
				},
			});
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-create-group-btn', function(e) {
			e.preventDefault();

			initPopup( '', '', ' wd-create-group-on-page' );
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-move-action > a', function(e) {
			e.preventDefault();

			var $this = $(this);
			var $products = $this.parents('.wd-wishlist-group').find('.product.wd-current-product');
			var productsId = [];

			if ( !$products.length ) {
				return;
			}

			$this.addClass('wd-loading');

			$products.each(function () {
				productsId.push($(this).data('id'));
			});

			initPopup( productsId, '', ' wd-move-action' );
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-group-list li', function(e) {
			var $this = $(this);
			var groupId = $this.data('group-id');

			if ( 'add_new' === groupId ) {
				e.preventDefault();

				var $wrapper = $this.parents('.wd-popup-wishlist');

				$wrapper.addClass('wd-create-group');
				$wrapper.find('.wd-wishlist-group-name').focus();

				return;
			}

			$this.siblings().removeClass('wd-current').find('input').prop('checked', false);

			$this.addClass('wd-current');
			$this.find('input').prop('checked', true);
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-save-btn', function(e) {
			e.preventDefault();

			var $this = $(this);
			var $popupWrapper = $this.parents('.wd-popup-wishlist');
			var $wrapperList = $this.siblings('.wd-wishlist-group-list');
			var $moveBtn = $('.wd-wishlist-move-action > a.wd-loading');
			var productsId = $wrapperList.data('product-id');
			var groupId = '';

			if ($popupWrapper.hasClass('wd-create-group')) {
				groupId = $popupWrapper.find('.wd-wishlist-group-name').val();
			} else if ($popupWrapper.parents('.wd-create-group-on-page').length) {
				groupId = $popupWrapper.find('.wd-wishlist-group-name').val();

				createNewGroup(groupId, $this, $moveBtn.length);
				return;
			} else {
				groupId = $wrapperList.find('li.wd-current').data('group-id');
			}

			if ( ! groupId ) {
				return;
			}

			$this.addClass('loading');

			if ( ! $moveBtn.length ) {
				woodmartThemeModule.$document.trigger('wdAddProductToWishlist', [ productsId, groupId, $wrapperList.data('nonce'), function () {
					$popupWrapper.addClass('wd-added');
					$popupWrapper.removeClass('wd-create-group');
					$this.removeClass('loading');
				} ] );

				return;
			}

			var groupIdOld = $moveBtn.parents('.wd-wishlist-group').data('group-id');

			$.ajax({
				url: woodmart_settings.ajaxurl,
				data: {
					action      : 'woodmart_move_products_from_wishlist',
					products_id : productsId,
					group_id    : groupId,
					group_id_old: groupIdOld,
					key         : woodmart_settings.wishlist_page_nonce,
				},
				dataType: 'json',
				method: 'GET',
				success: function (response) {
					if (response.wishlist_content) {
						woodmartThemeModule.$document.trigger('wdUpdateWishlistContent', response );
					} else {
						console.log('something wrong loading wishlist data ', response);
					}

					if ( response.fragments ) {
						updateFragments( response.fragments, response.hash );
					}
				},
				error: function () {
					console.log('We cant remove from wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$this.removeClass('wd-loading');
					$.magnificPopup.close();
					$moveBtn.removeClass('wd-loading');
				},
			});
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-back-btn', function(e) {
			e.preventDefault();

			$(this).parents('.wd-popup-wishlist').removeClass('wd-create-group');
		});

		woodmartThemeModule.$body.on('click', '.wd-wishlist-back-to-shop', function(e) {
			e.preventDefault();

			if ('undefined' !== typeof $.fn.magnificPopup) {
				$.magnificPopup.close();
			}
		});

		woodmartThemeModule.$document.on('wdShowWishlistGroupPopup', function (event, productId, key) {
			initPopup( productId, key);
		});

		woodmartThemeModule.$document.on('wdUpdateWishlistFragments', function (event, fragments, hash) {
			updateFragments(fragments, hash);
		});

		woodmartThemeModule.$document.on('wdWishlistSaveFragments', function (event, fragments, hash) {
			saveFragments( fragments, hash )
		});

		function updateFragments( fragments, hash = '' ) {
			setTimeout( function () {
				$.each( fragments, function( key, html ) {
					woodmartThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
						$( key ).replaceWith(html);
					});
				});
			}, 600);

			saveFragments( fragments, hash );
		}

		function saveFragments( fragments, hash ) {
			localStorage.setItem( fragmentsName, JSON.stringify( fragments ) );
			sessionStorage.setItem( fragmentsName, JSON.stringify( fragments ) );

			localStorage.setItem( woodmart_settings.wishlist_hash_name, hash );
			sessionStorage.setItem( woodmart_settings.wishlist_hash_name, hash );

			Cookies.set(cookiesHashName, hash, {
				expires: 7,
				path   : '/',
				secure : woodmart_settings.cookie_secure_param
			});
		}

		// Output popup for save product in wishlist groups.
		function initPopup( productId, key, classes = '' ) {
			if ('undefined' === typeof $.fn.magnificPopup) {
				return;
			}

			var $groupLists = $('.wd-popup-wishlist').find('ul');
			var $moveBtn    = $('.wd-wishlist-move-action > a.wd-loading');

			if ( 'undefined' !== typeof woodmart_settings.wishlist_show_popup && 'more_one' === woodmart_settings.wishlist_show_popup && 2 > $groupLists.data('group-count') && ! $moveBtn.length && ! classes ) {
				woodmartThemeModule.$document.trigger('wdAddProductToWishlist', [ productId, '', key, '' ] );
				return;
			}

			$.magnificPopup.open({
				removalDelay: 500, //delay removal by X to allow out-animation
				tClose      : woodmart_settings.close,
				tLoading    : woodmart_settings.loading,
				callbacks   : {
					beforeOpen: function() {
						this.st.mainClass = 'mfp-move-horizontal' + classes ;
					},
					open      : function() {
						var $popupWrapper = $(this.content[0]);
						var $btn = $popupWrapper.find('.wd-wishlist-save-btn');

						$popupWrapper.find('ul').attr('data-product-id', productId ).attr('data-nonce', key );
						$popupWrapper.find('ul').find('li').first().trigger('click');

						if ( ' wd-create-group-on-page' === classes ) {
							$btn.html( $btn.data('create-text'));

							setTimeout( function () {
								$popupWrapper.find('.wd-wishlist-group-name').focus();
							}, 500);
						}
						if ( ' wd-move-action' === classes ) {
							$btn.html( $btn.data('move-text'));
						}
					},
					close     : function() {
						if ( key ) {
							$('a[data-product-id=' + productId + ']').removeClass('loading');
						}

						var $popupWrapper = $(this.content[0]);

						if ( ' wd-create-group-on-page' === classes && $popupWrapper.find('.wd-wishlist-save-btn').hasClass('loading') ) {
							var $newGroup = $('.wd-wishlist-content').find('.wd-wishlist-group').last();

							setTimeout( function () {
								$('html, body').animate({
									scrollTop: $newGroup.offset().top - 100
								}, 500);
							}, 50);
						}

						$popupWrapper.removeClass('wd-create-group');
						$popupWrapper.removeClass('wd-added');
						$popupWrapper.find('.wd-wishlist-save-btn').removeClass('loading');
						$popupWrapper.find('.wd-wishlist-group-name').val('');
						$popupWrapper.find('.wd-wishlist-group-list li.wd-current').removeClass('wd-current').find('input').prop('checked', false);
						$moveBtn.removeClass('loading');

						setTimeout(function () {
							updateWishlistGroup();
						}, 600);
					}
				},
				items       : {
					src : '.wd-popup-wishlist',
				}
			});
		}

		function updateWishlistGroup() {
			if ( woodmartThemeModule.supports_html5_storage ) {
				var fragmentWishlistGroups = JSON.parse( sessionStorage.getItem( fragmentsName ) );

				if ( sessionStorage.getItem( woodmart_settings.wishlist_hash_name ) !== Cookies.get( cookiesHashName ) ) {
					fragmentWishlistGroups = '';
				}

				if ( sessionStorage.getItem( fragmentsName ) !== localStorage.getItem( fragmentsName ) ) {
					fragmentWishlistGroups = '';
				}

				if ( 'undefined' !== typeof actions && ( actions.is_lang_switched === '1' || actions.force_reset === '1' ) ) {
					fragmentWishlistGroups = '';
				}

				if ( fragmentWishlistGroups ) {
					$.each( fragmentWishlistGroups, function( key, html ) {
						woodmartThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
							$( key ).replaceWith(html);
						});
					});
				} else {
					updateAjaxWishlistGroup();
				}
			} else {
				updateAjaxWishlistGroup();
			}
		}

		function updateAjaxWishlistGroup() {
			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action : 'woodmart_get_wishlist_fragments',
					key    : woodmart_settings.wishlist_fragments_nonce
				},
				dataType: 'json',
				method  : 'GET',
				success : function(response) {
					if (response.fragments) {
						updateFragments( response.fragments, response.hash );
					} else {
						console.log('something wrong loading compare data ', response);
					}
				},
				error   : function() {
					console.log('We cant remove product compare. Something wrong with AJAX response. Probably some PHP conflict.');
				},
			});
		}

		function createNewGroup( nameGroup, $this, is_move = false ) {
			if ( ! nameGroup ) {
				return;
			}

			$this.addClass('loading');

			$.ajax({
				url: woodmart_settings.ajaxurl,
				data: {
					action     : 'woodmart_save_wishlist_group',
					group      : nameGroup,
					key        : woodmart_settings.wishlist_page_nonce,
				},
				dataType: 'json',
				method: 'GET',
				success: function (response) {
					if (response) {
						if (response.wishlist_content) {
							woodmartThemeModule.$document.trigger('wdUpdateWishlistContent', response );
						}

						if ( response.fragments ) {
							updateFragments( response.fragments, response.hash );
						}

						if ( is_move || $this.parents('.wd-create-group-on-page').length ) {
							$.magnificPopup.close();
						}

						var groups = $('.wd-wishlist-content').find('.wd-wishlist-group');

						if ( groups.length ) {
							var position = groups.last().offset().top - woodmart_settings.ajax_scroll_offset;

							$('html, body').stop().animate({
								scrollTop: position
							}, 500);
						}
					} else {
						console.log('something wrong loading wishlist data ', response);
					}
				},
				error: function () {
					console.log('We cant add to wishlist. Something wrong with AJAX response. Probably some PHP conflict.');
				},
				complete: function() {
					$this.removeClass('loading');
					$this.siblings('.wd-wishlist-create-group').find('.wd-wishlist-group-name').val('');
				},
			});
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.wishlistGroup();
	});
})(jQuery);
