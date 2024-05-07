/* global woodmart_settings */
(function($) {
	woodmartThemeModule.frequentlyBoughtTogether = function () {
		$('form.wd-fbt-form').each( function () {
			var timeout = '';
			var $form = $(this);

			$form.on('change', '.wd-fbt-product input, .wd-fbt-product select', function () {
				var $this = $(this);
				var productsID = getProductsId($form);
				var mainProduct = $form.find('input[name=wd-fbt-main-product]').val();
				var btn = $form.find('.wd-fbt-purchase-btn');

				if ( ! productsID || 'undefined' === typeof productsID[mainProduct] ) {
					return;
				}

				if ( 2 > Object.keys(productsID).length ) {
					btn.addClass('wd-disabled');
				} else {
					btn.removeClass('wd-disabled');
				}

				var $carousel = $form.parents('.wd-fbt').find('.owl-carousel')
				var index = $this.parents('.wd-fbt-product').index();

				if ( !$($carousel.find('.owl-item')[index]).hasClass('active') ) {
					if ( 1 === index && 'undefined' !== typeof $carousel.data('owl.carousel') && 1 < $carousel.data('owl.carousel').settings.items ) {
						index = 0;
					}

					$carousel.trigger('to.owl.carousel', [index, 500, true]);
				}

				clearTimeout(timeout);

				timeout = setTimeout(function () {
					updatePrice($form, productsID);
				}, 1000);
			});

			$form.on('change', '.wd-fbt-product select', function () {
				var $this = $(this);
				var productID = $this.parents('.wd-fbt-product').data('id');
				var productWrapper = $this.parents('.wd-fbt').find('.product-grid-item[data-id=' + productID + ']');
				var $img = productWrapper.find('.product-image-link > img, .product-image-link > picture > img');
				var imageSrc = $this.find('option:selected').data('image-src');
				var imageSrcset = $this.find('option:selected').data('image-srcset');

				if ( $img.attr('srcset') ) {
					if ( ! imageSrcset ) {
						imageSrcset = imageSrc;
					}

					$img.attr('srcset', imageSrcset);
				}

				$img.attr('src', imageSrc);
			});

			$form.on('click', '.wd-fbt-purchase-btn', function (e) {
				e.preventDefault();

				var $this       = $(this);

				if ( $this.hasClass('wd-disabled') ) {
					return;
				}

				var productsID  = getProductsId($form);
				var mainProduct = $form.find('input[name=wd-fbt-main-product]').val();
				var bundlesId   = $form.find('input[name=wd-fbt-bundle-id]').val();

				if ( ! productsID || 'undefined' === typeof productsID[mainProduct] ) {
					return;
				}

				clearTimeout(timeout);

				$this.addClass('loading');

				$.ajax({
					url     : woodmart_settings.ajaxurl,
					data    : {
						action        : 'woodmart_purchasable_fbt_products',
						products_id   : productsID,
						main_product  : mainProduct,
						bundle_id     : bundlesId,
						key           : woodmart_settings.frequently_bought,
					},
					method  : 'POST',
					success : function(response) {
						var $noticeWrapper = $('.woocommerce-notices-wrapper');
						$noticeWrapper.empty();

						if (response.notices && response.notices.indexOf('error') > 0) {
							$noticeWrapper.append(response.notices);

							var scrollTo = $noticeWrapper.offset().top - woodmart_settings.ajax_scroll_offset;

							$('html, body').stop().animate({
								scrollTop: scrollTo
							}, 400);

							return;
						}

						if ('undefined' !== typeof response.fragments) {
							if ('undefined' !== typeof $.fn.magnificPopup && woodmart_settings.add_to_cart_action === 'widget') {
								$.magnificPopup.close();
							}

							$this.addClass('added');

							woodmartThemeModule.$body.trigger('added_to_cart', [
								response.fragments,
								response.cart_hash,
								''
							]);
						}
					},
					error   : function() {
						console.log('ajax error');
					},
					complete: function() {
						$this.removeClass('loading');
					}
				});
			});
		});

		function getProductsId($form) {
			var productsID = {};

			$form.find('.wd-fbt-product').each( function () {
				var $this = $(this);
				var $input = $(this).find('input');
				var productId = $this.data('id');
				var productWrapper = $form.parents('.wd-fbt');

				if ( $input.length ) {
					if ( $input.is(':checked') ) {
						if ( $this.find('.wd-fbt-product-variation').length ) {
							productsID[productId] = $this.find('.wd-fbt-product-variation select').val();
						} else {
							productsID[productId] = '';
						}

						productWrapper.find('.product.post-' + productId ).removeClass('wd-disabled-fbt');
					} else if ( ! $input.parents('.wd-fbt-form').hasClass('wd-checkbox-uncheck') ) {
						productWrapper.find('.product.post-' + productId).addClass('wd-disabled-fbt');
					}
				} else {
					if ( $this.find('.wd-fbt-product-variation').length ) {
						productsID[productId] = $this.find('.wd-fbt-product-variation select').val();
					} else {
						productsID[productId] = '';
					}
				}
			});

			return productsID;
		}

		function updatePrice( $wrapper, productsID ) {
			var mainProduct = $wrapper.find('input[name=wd-fbt-main-product]').val();
			var bundleId    = $wrapper.find('input[name=wd-fbt-bundle-id]').val();

			$wrapper.find('.wd-loader-overlay').addClass( 'wd-loading' );

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action      : 'woodmart_update_frequently_bought_price',
					products_id : productsID,
					main_product: mainProduct,
					bundle_id   : bundleId,
					key         : woodmart_settings.frequently_bought,
				},
				method  : 'POST',
				success : function(response) {
					if (response.fragments) {
						$.each( response.fragments, function( key, value ) {
							$( key ).replaceWith(value);
						});
					}
				},
				error   : function() {
					console.log('ajax error');
				},
				complete: function() {
					$wrapper.find('.wd-loader-overlay').removeClass('wd-loading');
				}
			});
		}
	}

	$(document).ready(function() {
		woodmartThemeModule.frequentlyBoughtTogether();
	});
})(jQuery);
