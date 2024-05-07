/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdQuickShopSuccess wdQuickViewOpen wdUpdateWishlist', function() {
		woodmartThemeModule.swatchesVariations();
	});

	$.each([
		'frontend/element_ready/wd_single_product_add_to_cart.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
			$wrapper.find('.variations_form').each(function() {
				$(this).wc_variation_form();
			});

			woodmartThemeModule.swatchesVariations();
		});
	});

	woodmartThemeModule.swatchesVariations = function() {
		woodmartThemeModule.setupMainCarouselArg();

		var $variation_forms = $('.variations_form');
		var variationGalleryReplace = false;
		var variationData = $variation_forms.data('product_variations');
		var useAjax = false === variationData;

		// Firefox mobile fix
		$('.variations_form .label').on('click', function(e) {
			if ($(this).siblings('.value').hasClass('with-swatches')) {
				e.preventDefault();
			}
		});

		$variation_forms.each(function() {
			var $variation_form = $(this);

			if ($variation_form.data('swatches') || $variation_form.hasClass('wd-quick-shop-2')) {
				return;
			}

			$variation_form.data('swatches', true);

			if (!$variation_form.data('product_variations')) {
				$variation_form.find('.wd-swatches-product').find('> .wd-swatch').addClass('wd-enabled');
			}

			if ($('.wd-swatches-product > div').hasClass('wd-active')) {
				$variation_form.addClass('variation-swatch-selected');

				showWCVariationContent($variation_form);
			}

			var $selectChangesVariation = $variation_form.find('select.wd-changes-variation-image');

			$selectChangesVariation.on('change', function () {
				var $select = $(this);
				var attributeName = $select.attr('name');
				var attributeValue = $select.val();
				var productData = $variation_form.data('product_variations');
				var changeImage = false;

				$variation_form.find('select').each( function () {
					if ( ! $(this).val() ) {
						changeImage = true;
						return false;
					}
				});

				if ( ! changeImage || ! attributeValue || ! productData ) {
					return;
				}

				var $pageWrapper = $variation_form.parents('.product, .main-page-wrapper');
				var $firstThumb = $pageWrapper.find('.thumbnails .product-image-thumbnail img').first();
				var $mainImage = $pageWrapper.find('.woocommerce-product-gallery .woocommerce-product-gallery__image > a .wp-post-image').first();

				$.each( productData, function ( key, variation ) {
					if ( variation.attributes[attributeName] === attributeValue ) {
						setTimeout( function () {
							$variation_form.wc_variations_image_update(variation);

							if ( ! replaceMainGallery( variation.variation_id, $variation_form ) && ( $firstThumb.attr('src') !== variation.image.thumb_src || $firstThumb.attr('srcset') !== variation.image.thumb_src ) ) {
								$firstThumb = $pageWrapper.find('.thumbnails .product-image-thumbnail img').first();

								$firstThumb.wc_set_variation_attr( 'src', variation.image.src );
								$firstThumb.wc_set_variation_attr( 'srcset', variation.image.src );

								$mainImage.attr( 'data-o_src', variation.image.src );
								$mainImage.attr( 'data-o_srcset', variation.image.src );

								if ( $firstThumb.siblings('source').length ) {
									$firstThumb.siblings('source').attr( 'srcset', variation.image.src );
								}

								woodmartThemeModule.$document.trigger('wdResetVariation');
							}
						});

						return false;
					}
				});
			});

			if ( $selectChangesVariation.val() ) {
				$selectChangesVariation.trigger('change');
			}

			$variation_form
				.on('click', '.wd-swatches-single > .wd-swatch', function() {
					var $this = $(this);
					var value = $this.data('value');
					var id = $this.parent().data('id');
					var title = $this.data('title');

					resetSwatches($variation_form);

					if ( $this.parents('.wd-swatches-limited').length ) {
						$this.parents('.wd-swatches-limited').find('.wd-swatch-divider').trigger('click');
					}

					if ($this.hasClass('wd-active')) {
						return;
					}

					if ($this.hasClass('wd-disabled')) {
						return;
					}

					$variation_form.find('select#' + id).val(value).trigger('change');
					$this.parent().find('.wd-active').removeClass('wd-active');
					$this.addClass('wd-active');
					resetSwatches($variation_form);

					showSelectedAttr();
				})
				.on('woocommerce_update_variation_values', function() {
					showSelectedAttr();

					resetSwatches($variation_form);
				})
				.on('click', '.reset_variations', function() {
					$variation_form.find('.wd-active').removeClass('wd-active');

					if ((woodmart_settings.swatches_labels_name === 'yes' && woodmartThemeModule.$window.width() >= 769) || woodmartThemeModule.$window.width() <= 768) {
						$variation_form.find('.wd-attr-selected').html('');
					}
				})
				.on('reset_data', function() {
					var $this = $(this);
					var all_attributes_chosen = true;
					var some_attributes_chosen = false;
					var replaceGallery = true;

					$variation_form.find('.variations select').each(function() {
						var $select = $(this);
						var value = $this.val() || '';

						if (value.length === 0) {
							all_attributes_chosen = false;
						} else {
							some_attributes_chosen = true;
						}

						if ( $select.has('wd-changes-variation-image') && $select.val() ) {
							replaceGallery = false;
						}
					});

					if (all_attributes_chosen) {
						$this.parent().find('.wd-active').removeClass('wd-active');
					}

					$variation_form.removeClass('variation-swatch-selected');
					$variation_form.find('.woocommerce-variation').removeClass('wd-show');

					var $mainOwl = $('.woocommerce-product-gallery__wrapper.owl-carousel');
					var $galleryWrapper = $('.woocommerce-product-gallery');

					resetSwatches($variation_form);

					if ( replaceGallery ) {
						replaceMainGallery('default', $variation_form);
					}

					if (!$mainOwl.hasClass('owl-carousel')) {
						return;
					}

					if (woodmart_settings.product_slider_auto_height === 'yes') {
						if (!isQuickView() && isVariationGallery('default', $variation_form) && variationGalleryReplace) {
							$mainOwl.trigger('destroy.owl.carousel');
						}

						$('.product-images').imagesLoaded(function() {
							$mainOwl = $mainOwl.owlCarousel(woodmartThemeModule.mainCarouselArg);
							$mainOwl.trigger('refresh.owl.carousel');
						});
					} else {
						$mainOwl = $mainOwl.owlCarousel(woodmartThemeModule.mainCarouselArg);
						$mainOwl.trigger('refresh.owl.carousel');
					}

					var slide_go_to = $galleryWrapper.hasClass('thumbs-position-centered') ? woodmart_settings.centered_gallery_start : 0;

					if (isQuickView()) {
						slide_go_to = 0;
					}

					$mainOwl.trigger('to.owl.carousel', slide_go_to);

					woodmartThemeModule.$document.trigger('wdResetVariation');
				})
				.on('found_variation', function(event, variation) {
					if (useAjax) {
						replaceMainGallery(variation.variation_id, $variation_form, variation);
					}
				})
				.on('reset_image', function() {
					var $thumb = $('.thumbnails .product-image-thumbnail img').first();

					if (!isQuickView() && !isQuickShop($variation_form)) {
						$thumb.wc_reset_variation_attr('src');
					}
				})
				.on('show_variation', function(e, variation) {
					// Firefox fix after reload page.
					if ( $variation_form.find('.wd-swatch').length && ! $variation_form.find('.wd-swatch.wd-active').length ) {
						$variation_form.find('select').each(function () {
							var $select = $(this);
							var value = $select.val();

							if ( ! value ) {
								return;
							}

							$select.siblings('.wd-swatches-product').find('.wd-swatch[data-value=' + value + ']').addClass('wd-active');
						});
					}

					showSelectedAttr();

					$variation_form.addClass('variation-swatch-selected');

					if ( 'undefined' === typeof variation || ! variation.image.src) {
						return;
					}

					var $pageWrapper = $variation_form.parents('.product, .main-page-wrapper');
					var galleryHasImage = $pageWrapper.find('.thumbnails .product-image-thumbnail img[data-o_src="' + variation.image.thumb_src + '"]').length > 0;
					var $firstThumb = $pageWrapper.find('.thumbnails .product-image-thumbnail img').first();
					var originalImageUrl = $pageWrapper.find('.woocommerce-product-gallery .woocommerce-product-gallery__image > a').first().data('o_href');

					if (galleryHasImage) {
						$firstThumb.wc_reset_variation_attr('src');
					}

					if (!isQuickShop($variation_form) && !replaceMainGallery(variation.variation_id, $variation_form)) {
						if ($firstThumb.attr('src') !== variation.image.thumb_src) {
							$firstThumb.wc_set_variation_attr('src', variation.image.src);

							if ( variation.image.srcset.length ) {
								$firstThumb.wc_set_variation_attr('srcset', variation.image.srcset);
							}
						}

						woodmartThemeModule.$document.trigger('wdShowVariationNotQuickView');
					}

					showWCVariationContent($variation_form);

					if (!isQuickShop($variation_form) && !isQuickView() && originalImageUrl !== variation.image.full_src) {
						scrollToTop();
					}

					var $mainOwl = $('.woocommerce-product-gallery__wrapper.owl-carousel');

					if (!$mainOwl.hasClass('owl-carousel')) {
						return;
					}

					if (woodmart_settings.product_slider_auto_height === 'yes') {
						if (!isQuickView() && isVariationGallery(variation.variation_id, $variation_form) && variationGalleryReplace) {
							$mainOwl.trigger('destroy.owl.carousel');
						}

						$('.product-images').imagesLoaded(function() {
							$mainOwl = $mainOwl.owlCarousel(woodmartThemeModule.mainCarouselArg);
							$mainOwl.trigger('refresh.owl.carousel');
						});
					} else {
						$mainOwl = $mainOwl.owlCarousel(woodmartThemeModule.mainCarouselArg);
						$mainOwl.trigger('refresh.owl.carousel');
					}

					var $thumbs = $('.images .thumbnails');

					$mainOwl.trigger('to.owl.carousel', 0);

					if ($thumbs.hasClass('owl-carousel')) {
						$thumbs.owlCarousel().trigger('to.owl.carousel', 0);
						$thumbs.find('.active-thumb').removeClass('active-thumb');
						$thumbs.find('.product-image-thumbnail').eq(0).addClass('active-thumb');
					} else if ($thumbs.hasClass('slick-slider')) {
						$thumbs.slick('slickGoTo', 0);
						if (!$thumbs.find('.product-image-thumbnail').eq(0).hasClass('active-thumb')) {
							$thumbs.find('.active-thumb').removeClass('active-thumb');
							$thumbs.find('.product-image-thumbnail').eq(0).addClass('active-thumb');
						}
					}
				});
		});

		var resetSwatches = function($variation_form) {
			// If using AJAX
			if (!$variation_form.data('product_variations')) {
				return;
			}

			$variation_form.find('.variations select').each(function() {
				var select = $(this);
				var swatch = select.parent().find('.wd-swatches-product');
				var options = select.html();
				options = $(options);

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

		var isQuickView = function() {
			return $('.single-product-content').hasClass('product-quick-view');
		};

		var isQuickShop = function($form) {
			return $form.parent().hasClass('quick-shop-form');
		};

		var isVariationGallery = function(key, $variationForm) {
			if ('old' === woodmart_settings.variation_gallery_storage_method) {
				return isVariationGalleryOld(key);
			} else {
				return isVariationGalleryNew(key, $variationForm);
			}
		};

		var isVariationGalleryOld = function(key) {
			if (typeof woodmart_variation_gallery_data === 'undefined' && typeof woodmart_qv_variation_gallery_data === 'undefined') {
				return;
			}

			var variation_gallery_data = isQuickView() ? woodmart_qv_variation_gallery_data : woodmart_variation_gallery_data;

			return typeof variation_gallery_data !== 'undefined' && variation_gallery_data && variation_gallery_data[key];
		};

		var isVariationGalleryNew = function(key, $variationForm) {
			var data = getAdditionalVariationsImagesData($variationForm);

			return typeof data !== 'undefined' && data && data[key] && data[key].length > 1 || 'default' === key;
		};

		var isVariationGalleryAjax = function(key, data) {
			return typeof data !== 'undefined' && data && data.additional_variation_images && data.additional_variation_images.length > 1 || 'default' === key;
		};

		var scrollToTop = function() {
			if (0 === $('.woocommerce-product-gallery__wrapper').length) {
				return;
			}

			if ((woodmart_settings.swatches_scroll_top_desktop === 'yes' && woodmartThemeModule.$window.width() >= 1024) || (woodmart_settings.swatches_scroll_top_mobile === 'yes' && woodmartThemeModule.$window.width() <= 1024)) {
				var $page = $('html, body');

				$page.stop(true);

				woodmartThemeModule.$window.on('mousedown wheel DOMMouseScroll mousewheel keyup touchmove', function() {
					$page.stop(true);
				});

				$page.animate({
					scrollTop: $('.woocommerce-product-gallery__wrapper').offset().top - 150
				}, 800);

				$('.wd-swatch').tooltip('hide');
			}
		};

		var getAdditionalVariationsImagesData = function($variationForm, ajaxData) {
			if (ajaxData === undefined) {
				ajaxData = false;
			}

			var rawData = $variationForm.data('product_variations');

			if (ajaxData) {
				rawData = ajaxData;
			}

			if (!rawData) {
				rawData = $variationForm.data('wd_product_variations');
			}

			var data = [];

			if (!rawData) {
				return data;
			}

			if (typeof rawData === 'object' && !Array.isArray(rawData)) {
				data[rawData.variation_id] = rawData.additional_variation_images;
				data['default'] = rawData.additional_variation_images_default;
				$variationForm.data('wd_product_variations', JSON.stringify(
					[
						{
							additional_variation_images_default: rawData.additional_variation_images_default
						}
					]));
			} else {
				if (typeof rawData === 'string') {
					rawData = JSON.parse(rawData);
				}

				rawData.forEach(function(value) {
					data[value.variation_id] = value.additional_variation_images;
					data['default'] = value.additional_variation_images_default;
				});
			}

			return data;
		};

		var replaceMainGallery = function(key, $variationForm, ajaxData) {
			if (ajaxData === undefined) {
				ajaxData = false;
			}

			if ('old' === woodmart_settings.variation_gallery_storage_method) {
				if (!isVariationGallery(key, $variationForm) || isQuickShop($variationForm) || ('default' === key && !variationGalleryReplace)) {
					return false;
				}

				replaceMainGalleryOld(key, $variationForm);
			} else {
				if ((!isVariationGallery(key, $variationForm) && !ajaxData) || (ajaxData && !isVariationGalleryAjax(key, ajaxData)) || isQuickShop($variationForm) || ('default' === key && !variationGalleryReplace)) {
					return false;
				}

				var data = getAdditionalVariationsImagesData($variationForm, ajaxData);

				replaceMainGalleryNew(data[key], $variationForm, key);
			}

			$('.woocommerce-product-gallery__image').trigger('zoom.destroy');
			woodmartThemeModule.$document.trigger('wdReplaceMainGallery');
			if (!isQuickView()) {
				woodmartThemeModule.$document.trigger('wdReplaceMainGalleryNotQuickView');
			}

			variationGalleryReplace = 'default' !== key;

			woodmartThemeModule.$window.trigger('resize');

			return true;
		};

		var replaceMainGalleryOld = function(key, $variationForm) {
			var variation_gallery_data = isQuickView() ? woodmart_qv_variation_gallery_data : woodmart_variation_gallery_data;
			var imagesData = variation_gallery_data[key];
			var $pageWrapper = $variationForm.parents('.product, .main-page-wrapper');
			var $mainGallery = $pageWrapper.find('.woocommerce-product-gallery__wrapper');

			if (imagesData.length > 1) {
				$pageWrapper.find('.woocommerce-product-gallery').addClass('wd-has-thumb');
			} else {
				$pageWrapper.find('.woocommerce-product-gallery').removeClass('wd-has-thumb');
			}

			$mainGallery.empty();

			for (var index = 0; index < imagesData.length; index++) {
				var classes = '';

				if ( !isQuickView() && 'default' === key && 'undefined' !== typeof imagesData[index].video && 'undefined' !== typeof imagesData[index].video.classes ) {
					classes += imagesData[index].video.classes;
				}

				var $html = '<div class="product-image-wrap' + classes + '">';

				$html += '<figure data-thumb="' + imagesData[index].data_thumb + '" class="woocommerce-product-gallery__image">';

				if ( !isQuickView() && 'default' === key && 'undefined' !== typeof imagesData[index].video && 'undefined' !== typeof imagesData[index].video.controls ) {
					$html += imagesData[index].video.controls;
				}

				if (!isQuickView()) {
					$html += '<a href="' + imagesData[index].href + '">';
				}

				$html += imagesData[index].image;

				if (!isQuickView()) {
					$html += '</a>';
				}

				if ( !isQuickView() && 'default' === key && 'undefined' !== typeof imagesData[index].video && 'undefined' !== typeof imagesData[index].video.content ) {
					$html += imagesData[index].video.content;
				}

				$html += '</figure></div>';

				$mainGallery.append($html);
			}
		};

		var replaceMainGalleryNew = function(imagesData, $variationForm, galleryType = '') {
			var $pageWrapper = $variationForm.parents('.product, .main-page-wrapper');
			var $mainGallery = $pageWrapper.find('.woocommerce-product-gallery__wrapper');
			$mainGallery.empty();

			if (imagesData.length > 1) {
				$pageWrapper.find('.woocommerce-product-gallery').addClass('wd-has-thumb');
			} else {
				$pageWrapper.find('.woocommerce-product-gallery').removeClass('wd-has-thumb');
			}

			for (var key in imagesData) {
				if (imagesData.hasOwnProperty(key)) {
					var classes = '';

					if ( !isQuickView() && 'default' === galleryType && 'undefined' !== typeof imagesData[key].video && 'undefined' !== typeof imagesData[key].video.classes ) {
						classes += imagesData[key].video.classes;
					}

					var $html = '<div class="product-image-wrap' + classes + '">';

					if ( !isQuickView() && 'default' === galleryType && 'undefined' !== typeof imagesData[key].video && 'undefined' !== typeof imagesData[key].video.controls ) {
						$html += imagesData[key].video.controls;
					}

					$html += '<figure class="woocommerce-product-gallery__image" data-thumb="' + imagesData[key].thumbnail_src + '">';

					if (!isQuickView()) {
						$html += '<a href="' + imagesData[key].full_src + '" data-elementor-open-lightbox="no">';
					}

					var srcset = imagesData[key].srcset ? 'srcset="' + imagesData[key].srcset + '"' : '';

					$html += '<img width="' + imagesData[key].width + '" height="' + imagesData[key].height + '" src="' + imagesData[key].src + '" class="' + imagesData[key].class + '" alt="' + imagesData[key].alt + '" title="' + imagesData[key].title + '" data-caption="' + imagesData[key].data_caption + '" data-src="' + imagesData[key].data_src + '"  data-large_image="' + imagesData[key].data_large_image + '" data-large_image_width="' + imagesData[key].data_large_image_width + '" data-large_image_height="' + imagesData[key].data_large_image_height + '" ' + srcset + ' sizes="' + imagesData[key].sizes + '" />';

					if (!isQuickView()) {
						$html += '</a>';
					}

					if ( !isQuickView() && 'default' === galleryType && 'undefined' !== typeof imagesData[key].video && 'undefined' !== typeof imagesData[key].video.content ) {
						$html += imagesData[key].video.content;
					}

					$html += '</figure></div>';

					$mainGallery.append($html);
				}
			}
		};

		function showWCVariationContent( $variation_form ) {
			var $wrapper = $variation_form.find('.woocommerce-variation');
			var $showWrapper = false;

			if ( ! $wrapper.length ) {
				return;
			}

			$wrapper.find('> *').each( function () {
				if ( ! $(this).is(':empty') ) {
					$showWrapper = true;
				}
			});

			if ( $showWrapper ) {
				$wrapper.addClass('wd-show');
			}
		};

		function showSelectedAttr () {
			var swathesSelected = false;

			$('.variations_form').each(function() {
				var $variation_form = $(this);

				if (((woodmart_settings.swatches_labels_name === 'yes' && woodmartThemeModule.$window.width() >= 769) || woodmartThemeModule.$window.width() <= 768) && !swathesSelected) {
					$variation_form.find('.wd-active').each(function() {
						var $this = $(this);
						var title = $this.data('title');
						var wrapAttr = $this.parents('tr').find('.wd-attr-selected');

						if ( wrapAttr.length ) {
							wrapAttr.html(title);
						} else {
							$this.parents('tr').find(' > th').append(
								'<span class="wd-attr-selected">' + title + '</span>'
							);
						}
					});

					swathesSelected = true;
				}
			});
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.swatchesVariations();
	});
})(jQuery);
