/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_products.default',
		'frontend/element_ready/wd_products_tabs.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.quickShopVariationForm();
		});
	});

	woodmartThemeModule.quickShopVariationForm = function() {
		woodmartThemeModule.$document.on('mouseenter touchstart mousemove', '.product-grid-item.product-type-variable', function() {
			var $product          = $(this);
			var $form             = $product.find('.variations_form');
			var $button           = $product.find('.button.product_type_variable');
			var $price            = $product.find('.price').first();
			var $image            = $product.find('.product-image-link > img, .product-image-link > picture > img');
			var $source           = $product.find('.product-image-link picture source');

			var originalSrc       = $image.attr('src');
			var originalSrcSet    = $image.attr('srcset');
			var originalSizes     = $image.attr('sizes');
			var originalBtnText   = $button.text();
			var addToCartText     = woodmart_settings.add_to_cart_text;
			var priceOriginalHtml = $price.html();
			var $stockStatus      = $product.find('.wd-product-stock');
			var $sku              = $product.find('.wd-product-sku').find('span').not('.wd-label');

			if ( ! $form.length || $form.hasClass('wd-variations-inited')) {
				return;
			}

			if ( $stockStatus.length ) {
				var stockStatusOriginalText = $stockStatus.text();
				var stockStatusClasses = $stockStatus.attr('class');
			}
			if ( $sku.length ) {
				var skuOriginalText = $sku.text();
			}

			$form.wc_variation_form();

			$form.addClass('wd-variations-inited');

			$form.on('click', '.wd-swatch', function() {
				var $this = $(this);
				var $product = $this.parents('.product-grid-item');
				var value = $this.data('value');
				var id = $this.parent().data('id');
				var $select = $form.find('select#' + id);

				if (! $form.hasClass('wd-form-inited')) {
					$form.addClass('wd-form-inited');

					loadVariations($form);
				}

				resetSwatches($form);

				if ( $this.parents('.variations_form.wd-clear-double').length && $this.hasClass('wd-active') ) {
					$select.val('').trigger('change');
					$this.removeClass('wd-active');

					var swatchSelected = false;

					$product.find('.wd-swatch').each( function( key, value ) {
						if ( $( value ).hasClass('wd-active') ) {
							return swatchSelected = true;
						}
					});

					if ( ! swatchSelected ) {
						$product.trigger( 'wdImagesGalleryInLoopOn', $product );
					}

					return;
				} else if ( $this.hasClass('wd-active') || $this.hasClass('wd-disabled')) {
					return;
				}

				$select.val(value).trigger('change');
				$this.parent().find('.wd-active').removeClass('wd-active');
				$this.addClass('wd-active');

				$product.trigger( 'wdImagesGalleryInLoopOff', $product );

				resetSwatches($form);
			});
			$form.on('change', 'select', function() {
				if ($form.hasClass('wd-form-inited')) {
					return false;
				}

				$form.addClass('wd-form-inited');

				loadVariations($form);
			});

			$form.on('show_variation', function(event, variation, purchasable) {
				// Firefox fix after reload page.
				if ( $form.find('.wd-swatch').length && ! $form.find('.wd-swatch.wd-active').length ) {
					$form.find('select').each(function () {
						var $select = $(this);
						var value = $select.val();

						if ( ! value ) {
							return;
						}

						$select.siblings('.wd-swatches-product').find('.wd-swatch[data-value=' + value + ']').addClass('wd-active');
					});
				}

				if (variation.price_html.length > 1) {
					$price.html(variation.price_html);
				}

				if (variation.image.thumb_src.length > 1) {
					$product.addClass('wd-loading-image');

					$image.attr('src', variation.image.thumb_src);

					if ( $image.attr('srcset') && ! variation.image.srcset ) {
						$image.attr('srcset', variation.image.thumb_src);
					}

					$image.one('load', function() {
						$product.removeClass('wd-loading-image');
					});
				}

				if (variation.image.srcset.length > 1) {
					$image.attr('srcset', variation.image.srcset);

					if ($source.length > 0) {
						$source.attr('srcset', variation.image.srcset);
					}
				}

				if (variation.image.sizes.length > 1) {
					$image.attr('sizes', variation.image.sizes);

					if ($source.length > 0) {
						$source.attr('image_sizes', variation.image.sizes);
					}
				}

				if ( $stockStatus.length ) {
					if ( variation.availability_html ) {
						$stockStatus.removeClass('in-stock available-on-backorder out-of-stock');

						if ( 0 < variation.availability_html.search('available-on-backorder') ) {
							$stockStatus.addClass('available-on-backorder');
						} else if ( 0 < variation.availability_html.search('out-of-stock')) {
							$stockStatus.addClass('out-of-stock');
						} else {
							$stockStatus.addClass('in-stock');
						}

						$stockStatus.text( variation.availability_html.replace(/<\/?[^>]+(>|$)/g, '' ));
					} else {
						$stockStatus.attr( 'class', stockStatusClasses );
						$stockStatus.text( stockStatusOriginalText );
					}
				}
				if ( $sku.length ) {
					if ( variation.sku ) {
						$sku.text( variation.sku );
					} else {
						$sku.text( skuOriginalText );
					}
				}

				$form.addClass('variation-swatch-selected');
			});

			$form.on('woocommerce_update_variation_values', function() {
				resetSwatches($form);
			});

			$form.on('hide_variation', function() {
				$price.html(priceOriginalHtml);
				$button.find('span').text(originalBtnText);

				if ( $image.attr('src') !== originalSrc ){
					$image.attr('src', originalSrc);
					$image.attr('srcset', originalSrcSet);
					$image.attr('sizes', originalSizes);
				}

				if ($source.length > 0 && $source.attr('srcset') !== originalSrcSet ) {
					$source.attr('srcset', originalSrcSet);
					$source.attr('image_sizes', originalSizes);
				}
				if ( $stockStatus.length ) {
					$stockStatus.attr('class', stockStatusClasses);
					$stockStatus.text(stockStatusOriginalText);
				}
				if ( $sku.length ) {
					$sku.text(skuOriginalText);
				}
			});

			$form.on('click', '.reset_variations', function() {
				$form.find('.wd-active').removeClass('wd-active');
				$form.removeClass('wd-form-inited')

				$product.trigger( 'wdImagesGalleryInLoopOn', $product );
			});

			$form.on('reset_data', function() {
				var $this = $(this);
				var all_attributes_chosen = true;
				var some_attributes_chosen = false;

				$form.find('.variations select').each(function () {
					var value = $this.val() || '';

					if (value.length === 0) {
						all_attributes_chosen = false;
					} else {
						some_attributes_chosen = true;
					}
				});

				if (all_attributes_chosen) {
					$form.find('.wd-active').removeClass('wd-active');
				}

				$form.removeClass('variation-swatch-selected');

				resetSwatches($form);
			});

			$button.on('click', function(e) {
				var $formBtn = $form.find('.single_add_to_cart_button');

				if (!$(this).data('purchasable') || !$formBtn.length) {
					return;
				}

				e.preventDefault();

				if ( 'undefined' !== typeof wc_add_to_cart_variation_params && $formBtn.hasClass('disabled') ) {

					if ($formBtn.hasClass('wc-variation-is-unavailable') ) {
						alert( wc_add_to_cart_variation_params.i18n_unavailable_text );
					} else if ( $formBtn.hasClass('wc-variation-selection-needed') ) {
						alert( wc_add_to_cart_variation_params.i18n_make_a_selection_text );
					}

					return;
				}

				$form.trigger('submit');
				$button.addClass('loading');

				woodmartThemeModule.$body.one('added_to_cart', function() {
					$button.removeClass('loading').addClass('added');
				});
			});

			function resetSwatches($variation_form) {
				if (!$variation_form.data('product_variations')) {
					return;
				}

				$button.find('span').text(originalBtnText);
				$button.data('purchasable', false);
				$product.removeClass('wd-variation-active');

				$variation_form.find('.variations select').each(function() {
					var select = $(this);
					var swatch = select.parent().find('.wd-swatches-product');
					var options = select.html();
					options = $(options);

					if ( select.val() ) {
						$button.find('span').text(addToCartText);
						$button.data('purchasable', true);
						$product.addClass('wd-variation-active');
					}

					swatch.find('.wd-swatch').removeClass('wd-enabled').addClass('wd-disabled');

					options.each(function() {
						var value = $(this).val();

						if ($(this).hasClass('enabled')) {
							swatch.find('div[data-value="' + value + '"]').removeClass('wd-disabled').addClass('wd-enabled');
						} else {
							swatch.find('div[data-value="' + value + '"]').addClass('wd-disabled').removeClass('wd-enabled');
						}
					});
				});
			};
		});

		function loadVariations($form) {
			if ( false !== $form.data('product_variations') ) {
				return;
			}

			$form.addClass('wd-loading');

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action: 'woodmart_load_available_variations',
					id    : $form.data('product_id')
				},
				method  : 'get',
				dataType: 'json',
				success : function(data) {
					if (data.length > 0) {
						$form.data('product_variations', data).trigger('reload_product_variations');
					}
				},
				complete: function() {
					$form.removeClass('wd-loading');
				},
				error   : function() {
					console.log('ajax error');
				}
			});
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.quickShopVariationForm();
	});
})(jQuery);
