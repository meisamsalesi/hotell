var woodmartAdminModule, woodmart_media_init;

(function($) {
	'use strict';

	woodmartAdminModule = (function() {

		var woodmartAdmin = {
			addNotice: function($selector, $type, $message) {
				$selector.html('<div class="xts-notice xts-' + $type + '">' + $message + '</div>').fadeIn();

				woodmartAdmin.hideNotice();
			},

			hideNotice: function() {
				var $notice = $('.xts-notice:not(.xts-info)');

				$notice.each(function() {
					var $notice = $(this);
					setTimeout(function() {
						$notice.addClass('xts-hidden');
					}, 10000);
				});

				$notice.on('click', function() {
					$(this).addClass('xts-hidden');
				});
			},

			sizeGuideInit: function() {
				if ($.fn.editTable) {
					$('.woodmart-sguide-table-edit').each(function() {
						$(this).editTable();
					});
				}
			},

			variationGallery: function() {

				$('#woocommerce-product-data').on('woocommerce_variations_loaded', function() {

					$('.woodmart-variation-gallery-wrapper').each(function() {

						var $this = $(this);
						var $galleryImages = $this.find('.woodmart-variation-gallery-images');
						var $imageGalleryIds = $this.find('.variation-gallery-ids');
						var galleryFrame;

						$this.find('.woodmart-add-variation-gallery-image').on('click', function(event) {
							event.preventDefault();

							// If the media frame already exists, reopen it.
							if (galleryFrame) {
								galleryFrame.open();
								return;
							}

							// Create the media frame.
							galleryFrame = wp.media.frames.product_gallery = wp.media({
								states: [
									new wp.media.controller.Library({
										filterable: 'all',
										multiple  : true
									})
								]
							});

							// When an image is selected, run a callback.
							galleryFrame.on('select', function() {
								var selection = galleryFrame.state().get('selection');
								var attachment_ids = $imageGalleryIds.val();

								selection.map(function(attachment) {
									attachment = attachment.toJSON();

									if (attachment.id) {
										var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
										attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;

										$galleryImages.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '"><a href="#" class="delete woodmart-remove-variation-gallery-image"><span class="xts-i-close"></span></a></li>');

										$this.trigger('woodmart_variation_gallery_image_added');
									}
								});

								$imageGalleryIds.val(attachment_ids);

								$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
								$('#variable_product_options').find('input').eq(0).trigger('change');

							});

							// Finally, open the modal.
							galleryFrame.open();
						});

						// Image ordering.
						if (typeof $galleryImages.sortable !== 'undefined') {
							$galleryImages.sortable({
								items               : 'li.image',
								cursor              : 'move',
								scrollSensitivity   : 40,
								forcePlaceholderSize: true,
								forceHelperSize     : false,
								helper              : 'clone',
								opacity             : 0.65,
								placeholder         : 'wc-metabox-sortable-placeholder',
								start               : function(event, ui) {
									ui.item.css('background-color', '#f6f6f6');
								},
								stop                : function(event, ui) {
									ui.item.removeAttr('style');
								},
								update              : function() {
									var attachment_ids = '';

									$galleryImages.find('li.image').each(function() {
										var attachment_id = $(this).attr('data-attachment_id');
										attachment_ids = attachment_ids + attachment_id + ',';
									});

									$imageGalleryIds.val(attachment_ids);

									$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
									$('#variable_product_options').find('input').eq(0).trigger('change');
								}
							});
						}

						// Remove images.
						$(document).on('click', '.woodmart-remove-variation-gallery-image', function(event) {
							event.preventDefault();
							$(this).parent().remove();

							var attachment_ids = '';

							$galleryImages.find('li.image').each(function() {
								var attachment_id = $(this).attr('data-attachment_id');
								attachment_ids = attachment_ids + attachment_id + ',';
							});

							$imageGalleryIds.val(attachment_ids);

							$this.parents('.woocommerce_variation').eq(0).addClass('variation-needs-update');
							$('#variable_product_options').find('input').eq(0).trigger('change');
						});

					});

				});
			},

			product360ViewGallery: function() {

				// Product gallery file uploads.
				var product_gallery_frame;
				var $image_gallery_ids = $('#product_360_image_gallery');
				var $product_images = $('#product_360_images_container').find('ul.product_360_images');

				$('.add_product_360_images').on('click', 'a', function(event) {
					var $el = $(this);

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if (product_gallery_frame) {
						product_gallery_frame.open();
						return;
					}

					// Create the media frame.
					product_gallery_frame = wp.media.frames.product_gallery = wp.media({
						// Set the title of the modal.
						title : $el.data('choose'),
						button: {
							text: $el.data('update')
						},
						states: [
							new wp.media.controller.Library({
								title     : $el.data('choose'),
								filterable: 'all',
								multiple  : true
							})
						]
					});

					// When an image is selected, run a callback.
					product_gallery_frame.on('select', function() {
						var selection = product_gallery_frame.state().get('selection');
						var attachment_ids = $image_gallery_ids.val();

						selection.map(function(attachment) {
							attachment = attachment.toJSON();

							if (attachment.id) {
								attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
								var attachment_image = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

								$product_images.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>');
							}
						});

						$image_gallery_ids.val(attachment_ids);
					});

					// Finally, open the modal.
					product_gallery_frame.open();
				});

				// Image ordering.
				if (typeof $product_images.sortable !== 'undefined') {
					$product_images.sortable({
						items               : 'li.image',
						cursor              : 'move',
						scrollSensitivity   : 40,
						forcePlaceholderSize: true,
						forceHelperSize     : false,
						helper              : 'clone',
						opacity             : 0.65,
						placeholder         : 'wc-metabox-sortable-placeholder',
						start               : function(event, ui) {
							ui.item.css('background-color', '#f6f6f6');
						},
						stop                : function(event, ui) {
							ui.item.removeAttr('style');
						},
						update              : function() {
							var attachment_ids = '';

							$('#product_360_images_container').find('ul li.image').css('cursor', 'default').each(function() {
								var attachment_id = $(this).attr('data-attachment_id');
								attachment_ids = attachment_ids + attachment_id + ',';
							});

							$image_gallery_ids.val(attachment_ids);
						}
					});
				}

				// Remove images.
				$('#product_360_images_container').on('click', 'a.delete', function() {
					$(this).closest('li.image').remove();

					var attachment_ids = '';

					$('#product_360_images_container').find('ul li.image').css('cursor', 'default').each(function() {
						var attachment_id = $(this).attr('data-attachment_id');
						attachment_ids = attachment_ids + attachment_id + ',';
					});

					$image_gallery_ids.val(attachment_ids);

					// Remove any lingering tooltips.
					$('#tiptip_holder').removeAttr('style');
					$('#tiptip_arrow').removeAttr('style');

					return false;
				});
			},

			imageHotspot: function() {
				$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
					var _this = $(this);
					var shortcode = _this.data('vc-shortcode');

					if (shortcode != 'woodmart_image_hotspot' && shortcode != 'woodmart_hotspot') {
						return;
					}

					var _background_id = vc.shortcodes.findWhere({id: vc.active_panel.model.attributes.parent_id}).attributes.params.img;
					var preview = '.xts-image-hotspot-preview';

					$(preview).addClass('loading');
					$.ajax({
						url     : woodmartConfig.ajaxUrl,
						dataType: 'json',
						data    : {
							image_id: _background_id,
							action  : 'woodmart_get_hotspot_image',
							security: woodmartConfig.get_hotspot_image_nonce
						},
						success : function(response) {
							$(preview).removeClass('loading');

							if (response.status == 'success') {
								_this.find('.xts-image-hotspot-image').append(response.html).fadeIn(500);
								$(preview).css('min-width', _this.find('.woodmart-hotspot-img').outerWidth());
							} else if (response.status == 'warning') {
								$('.xts-image-hotspot-preview').remove();
								$('.xts-image-hotspot-position').after(response.html);
							}
						},
						error   : function(response) {
							console.log('ajax error');
						}
					});
				});
			},

			whiteLabel: function() {
				setTimeout(function() {
					$('.theme').on('click', function() {
						themeClass();
					});
					themeClass();

					function themeClass() {
						var $name = $('.theme-overlay .theme-name');
						if ($name.text().includes('woodmart') || $name.text().includes('Woodmart')) {
							$('.theme-overlay').addClass('wd-woodmart-theme');
						} else {
							$('.theme-overlay').removeClass('wd-woodmart-theme');
						}
					}
				}, 500);
			}
		};

		return {
			init: function() {
				$(document).ready(function() {
					woodmartAdmin.sizeGuideInit();
					woodmartAdmin.product360ViewGallery();
					woodmartAdmin.variationGallery();
					woodmartAdmin.whiteLabel();
				});
			},

			mediaInit: function() {
				var clicked_button = false;
				$('.woodmart-image-upload').each(function(i, input) {
					var button = $(this).parent().find('.woodmart-image-upload-btn');

					if (button.hasClass('wd-inited')) {
						return;
					}

					button.click(function(event) {
						event.preventDefault();
						clicked_button = $(this);

						// check for media manager instance
						// if(wp.media.frames.gk_frame) {
						//     wp.media.frames.gk_frame.open();
						//     return;
						// }
						// configuration of the media manager new instance
						wp.media.frames.gk_frame = wp.media({
							title   : 'Select image',
							multiple: false,
							library : {
								type: 'image'
							},
							button  : {
								text: 'Use selected image'
							}
						});

						// Function used for the image selection and media manager closing
						var gk_media_set_image = function() {
							var selection = wp.media.frames.gk_frame.state().get('selection');

							// no selection
							if (!selection) {
								return;
							}

							// iterate through selected elements
							selection.each(function(attachment) {
								var url = attachment.attributes.url;

								button.parent().find('.woodmart-image-upload').val(attachment.attributes.id);
								button.parent().find('.woodmart-image-src').attr('src', url).show();
							});
						};

						// closing event for media manger
						wp.media.frames.gk_frame.on('close', gk_media_set_image);
						// image selection event
						wp.media.frames.gk_frame.on('select', gk_media_set_image);
						// showing media manager
						wp.media.frames.gk_frame.open();
					});

					button.addClass('wd-inited');
				});
			}

		};

	}());

})(jQuery);

woodmart_media_init = woodmartAdminModule.mediaInit;

jQuery(document).ready(function() {
	woodmartAdminModule.init();
});
