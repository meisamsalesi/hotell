var woodmartOptions;

/* global jQuery, wp, xtsTypography, WebFont */

(function($) {
	'use strict';

	woodmartOptions = (function() {

		var woodmartOptionsAdmin = {
			optionsPage: function() {
				var $options = $('.xts-options'),
				    $lastTab = $options.find('.xts-last-tab-input');

				$options.on('click', '.xts-nav-vertical a', function(e) {
					e.preventDefault();
					var $btn = $(this),
					    id   = $btn.data('id');

					$options.find('.xts-active-nav').removeClass('xts-active-nav');

					$options.find('.xts-section.xts-section').removeClass('xts-active-section').addClass('xts-hidden');

					if ($btn.parent().hasClass('xts-has-child')) {
						$btn.parent().addClass('xts-active-nav');

						id = $btn.parent().find('.xts-sub-menu-item').first().find('> a').data('id');
					}

					$options.find('.xts-section[data-id="' + id + '"]').addClass('xts-active-section').removeClass('xts-hidden');

					$options.find('a[data-id="' + id + '"]').parent().addClass('xts-active-nav');

					if ($btn.parent().hasClass('xts-sub-menu-item')) {
						$btn.parent().parent().parent().addClass('xts-active-nav');
					}

					$lastTab.val(id);

					woodmartOptionsAdmin.editorControl();

					$(document).trigger('xts_section_changed');
				});
				$(document).trigger('xts_section_changed');

				woodmartOptionsAdmin.editorControl();

				$options.on('click', '.xts-reset-options-btn', function(e) {
					return confirm(
						'Are you sure you want to reset ALL settings (not only this section) to default values? This process cannot be undone. Continue?');
				});

				$('.toplevel_page_xts_theme_settings').parent().find('li a').on('click', function(e) {
					var $this   = $(this),
					    href    = $this.attr('href'),
					    section = false;

					if (href) {
						var hrefParts = href.split('tab=');
						if (hrefParts[1]) {
							section = hrefParts[1];
						}
					}

					if (!section) {
						return true;
					}

					var $sectionLink = $('.xts-nav-vertical [data-id="' + section + '"]');

					if ($sectionLink.length == 0) {
						return true;
					}

					e.preventDefault();

					$sectionLink.trigger('click');

					$this.parent().parent().find('.current').removeClass('current');
					$this.parent().addClass('current');

				});
			},

			switcherControl: function() {
				var $switchers = $('.xts-active-section .xts-switcher-control, .xts-active-section .xts-checkbox-control');

				if ($switchers.length <= 0) {
					return;
				}

				$switchers.each(function() {
					var $field    = $(this),
					    $switcher = $field.find('.xts-switcher-btn'),
					    $input    = $field.find('input[type="hidden"]'),
					    $notice   = $switcher.siblings('.xts-field-notice');


					if ($field.hasClass('xts-field-inited')) {
						return;
					}

					$switcher.on('click', function() {
						if ($switcher.hasClass('xts-active')) {
							$input.val($switcher.data('off')).trigger('change');
							$switcher.removeClass('xts-active');
							$notice.addClass('xts-hidden');
						} else {
							$input.val($switcher.data('on')).trigger('change');
							$switcher.addClass('xts-active');
							$notice.removeClass('xts-hidden');
						}
					});

					$field.addClass('xts-field-inited');
				});
			},

			buttonsControl: function() {
				var $sets = $('.xts-buttons-control');

				$sets.each(function() {
					var $set   = $(this),
					    $input = $set.find('input[type="hidden"]');

					if ($set.hasClass('xts-field-inited')) {
						return;
					}

					$set.addClass('xts-field-inited');

					$set.on('click', '.xts-set-item', function() {
						var $btn = $(this);
						if ($btn.hasClass('xts-active')) {
							return;
						}
						var val = $btn.data('value');

						$set.find('.xts-active').removeClass('xts-active');

						$btn.addClass('xts-active');

						$input.val(val).trigger('change');
					});
				});
			},

			colorControl: function() {
				var $colors = $('.xts-active-section .xts-color-control');

				if ($colors.length <= 0) {
					return;
				}

				$colors.each(function() {
					var $color = $(this),
					    $input = $color.find('input[type="text"]');

					if ($color.hasClass('xts-field-inited')) {
						return;
					}

					$input.wpColorPicker();

					$color.addClass('xts-field-inited');
				});
			},

			uploadControl: function(force_init) {
				var $uploads = $('.xts-active-section .xts-upload-control, .form-table .xts-upload-control');

				if (force_init) {
					$uploads = $('.widget-content .xts-upload-control');
				}

				if ($uploads.length <= 0) {
					return;
				}

				$uploads.each(function() {
					var $upload       = $(this),
					    $removeBtn    = $upload.find('.xts-remove-upload-btn'),
					    $inputURL     = $upload.find('input.xts-upload-input-url'),
					    $inputID      = $upload.find('input.xts-upload-input-id'),
					    $preview      = $upload.find('.xts-upload-preview'),
					    $previewInput = $upload.find('.xts-upload-preview-input');

					if ($upload.hasClass('xts-field-inited') && !force_init || $upload.parents('.xts-custom-fonts-template.hide').length) {
						return;
					}

					$upload.off('click').on('click', '.xts-upload-btn, img', function(e) {
						e.preventDefault();

						var custom_uploader = wp.media({
							title   : 'Insert file',
							button  : {
								text: 'Use this file' // button label text
							},
							multiple: false // for multiple image selection set
							// to true
						}).on('select', function() { // it also has "open" and "close" events
							var attachment = custom_uploader.state().get('selection').first().toJSON();
							$inputID.val(attachment.id);
							$inputURL.val(attachment.url).trigger('change');
							$preview.find('img').remove();
							$previewInput.val(attachment.url);
							$preview.prepend(
								'<img src="' + attachment.url + '" />');
							$removeBtn.addClass('xts-active');
						}).open();
					});

					$removeBtn.on('click', function(e) {
						e.preventDefault();

						if ($preview.find('img').length == 1) {
							$preview.find('img').remove();
						}

						$previewInput.val('');
						$inputID.val('');
						$inputURL.val('');
						$removeBtn.removeClass('xts-active');
					});

					$upload.addClass('xts-field-inited');
				});
			},

			uploadListControl: function(force_init) {
				var $uploads = $('.xts-active-section .xts-upload_list-control');

				if (force_init) {
					$uploads = $('.widget-content .xts-upload_list-control');
				}

				if ($uploads.length <= 0) {
					return;
				}

				$uploads.each(function() {
					var $upload = $(this);
					var $inputID = $upload.find('input.xts-upload-input-id');
					var $preview = $upload.find('.xts-upload-preview');
					var $clearBtn = $upload.find('.xts-btn-remove');

					if ($upload.hasClass('xts-field-inited') && !force_init) {
						return;
					}

					$upload.off('click').on('click', '.xts-upload-btn, img', function(e) {
						e.preventDefault();

						var custom_uploader = wp.media({
							title   : 'Insert file',
							button  : {
								text: 'Use this file' // button label text
							},
							multiple: true // for multiple image selection set
							// to true
						}).on('select', function() { // it also has "open" and "close" events
							var attachments = custom_uploader.state().get('selection');
							var inputIdValue = $inputID.val();

							attachments.map(function(attachment) {
								attachment = attachment.toJSON();

								if (attachment.id) {
									var attachment_image = attachment.sizes &&
									attachment.sizes.thumbnail
										? attachment.sizes.thumbnail.url
										: attachment.url;
									inputIdValue = inputIdValue ? inputIdValue +
										',' + attachment.id : attachment.id;

									$preview.append(
										'<div data-attachment_id="' +
										attachment.id + '"><img src="' +
										attachment_image +
										'"><a href="#" class="xts-remove"><span class="xts-i-close"></span></a></div>');
								}
							});

							$inputID.val(inputIdValue).trigger('change');
							$clearBtn.addClass('xts-active');
						}).open();
					});

					$preview.on('click', '.xts-remove', function(e) {
						e.preventDefault();
						$(this).parent().remove();

						var attachmentIds = '';

						$preview.find('div').each(function() {
							var attachmentId = $(this).attr('data-attachment_id');
							attachmentIds = attachmentIds + attachmentId + ',';
						});

						$inputID.val(attachmentIds).trigger('change');

						if (!attachmentIds) {
							$clearBtn.removeClass('xts-active');
						}
					});

					$clearBtn.on('click', function(e) {
						e.preventDefault();
						$preview.empty();
						$inputID.val('').trigger('change');
						$clearBtn.removeClass('xts-active');
					});

					$upload.addClass('xts-field-inited');
				});
			},

			selectControl: function(force_init) {
				if ( typeof ($.fn.select2) === 'undefined' ) {
					return;
				}

				var $select = $('.xts-active-section .xts-select.xts-select2:not(.xts-autocomplete)');

				if (force_init) {
					$select = $('.widget-content .xts-select.xts-select2:not(.xts-autocomplete)');
				}

				if ($select.length > 0) {
					var select2Defaults = {
						width      : '100%',
						allowClear : true,
						theme      : 'xts',
						tags       : true,
						placeholder: 'Select'
					};

					$select.each(function() {
						var $select2 = $(this);

						if ($select2.hasClass('xts-field-inited')) {
							return;
						}

						if ($select2.attr('multiple')) {
							$select2.on('select2:select', function(e) {
								var $elm = $(e.params.data.element);

								$(this).find('option[value=""]')
									.prop('selected', false);

								$elm.attr('selected', 'selected');
								$select2.append($elm);
								$select2.trigger('change.select2');
							});

							$select2.on('select2:unselect', function(e) {
								var $this = $(this);
								var $elm  = $(e.params.data.element);

								$elm.removeAttr('selected');
								$select2.trigger('change.select2');

								if ( 0 === $this.find('option[selected="selected"]').length ) {
									$this.find('option[value=""]')
										.prop('selected', 'selected');
								}
							});

							$select2.parent().find('.xts-select2-all').on('click', function(e) {
								e.preventDefault();

								$select2.select2('destroy')
									.find('option')
									.each( function (key, option) {
										var $option = $(option);

										if ( 0 === $option.val().length ) {
											$option.prop('selected', false);
										} else {
											$option.attr('selected', 'selected');
											$option.prop('selected', 'selected');
										}
									})
									.end()
									.select2(select2Defaults);
							});

							$select2.parent().find('.xts-unselect2-all').on('click', function(e) {
								e.preventDefault();

								$select2.select2('destroy')
									.find('option')
									.each( function (key, option) {
										var $option = $(option);

										if ( 0 === $option.val().length ) {
											$option.prop('selected', 'selected');
										} else {
											$option.attr('selected', false);
											$option.prop('selected', false);
										}
									})
									.end()
									.select2(select2Defaults);
							});
						}

						if ($select2.parents('#widget-list').length > 0) {
							return;
						}

						$select2.select2(select2Defaults);

						$select2.addClass('xts-field-inited');
					});
				}

				$('.xts-active-section .xts-select.xts-select2.xts-autocomplete').each(function() {
					var $field = $(this);
					var type = $field.data('type');
					var value = $field.data('value');
					var search = $field.data('search');

					if ($field.hasClass('xts-field-inited') || $field.parents('.xts-item-template').length) {
						return;
					}

					$field.select2({
						theme            : 'xts',
						allowClear       : true,
						placeholder      : 'Select',
						dropdownAutoWidth: false,
						width            : 'resolve',
						ajax             : {
							url           : woodmartConfig.ajaxUrl,
							data          : function(params) {
								return {
									action: search,
									type  : type,
									value : value,
									selected : $field.val(),
									params: params
								};
							},
							method        : 'POST',
							dataType      : 'json',
							delay         : 250,
							processResults: function(data) {
								$.each(data, function ( $key, $item ) {
									$item['text'] = $item['text'].replace('&amp;', '&');
									data[$key] = $item;
								});
								return {
									results: data
								};
							},
							cache         : true
						}
					}).on('select2:select select2:unselect', function(e) {
						// $(e.currentTarget).find('option').each(function(e) {
						// 	$(this).removeAttr('selected');
						// });
					});

					$field.addClass('xts-field-inited');
				});

				var $selectWithAnimation = $('.xts-active-section .xts-select.xts-animation-preview');

				if ( ! $selectWithAnimation.length ) {
					return;
				}

				$selectWithAnimation.each( function () {
					var $select  = $(this);
					var value    = $select.val();
					var $wrapper = $select.parent();

					if ( ! $wrapper.find('.xts-animation-preview-wrap').length ) {
						var classes = '';

						if ( value && 'none' !== value ) {
							classes = ' wd-animated wd-animation-ready wd-animation-' + value;
						}

						$wrapper.append(`
							<div class="xts-animation-preview-wrap">
								<button class="xts-btn xts-color-primary${classes}">${woodmartConfig.animate_it_btn_text}</button>
							</div>
						`);
					}

					$select.on('change', function () {
						var $this = $(this);
						var $preview = $this.siblings('.xts-animation-preview-wrap').find('.xts-btn');

						$preview.removeClass(function (index, css) {
							return (css.match(/(^|\s)wd-animat\S+/g) || []).join(' ');
						});

						$preview.addClass('wd-animation-ready wd-animation-' + $this.val() );

						setTimeout( function () {
							$preview.addClass('wd-animated');
						}, 100);
					});

					$wrapper.find('.xts-animation-preview-wrap .xts-btn').on('click', function (e) {
						e.preventDefault();
						var $this = $(this);

						$this.removeClass('wd-animated');

						setTimeout( function () {
							$this.addClass('wd-animated');
						}, 100);
					});
				});
			},

			selectWithTableControl: function () {
				if ( typeof ($.fn.select2) === 'undefined' ) {
					return;
				}

				$('.xts-active-section .xts-select_with_table-control').each( function () {
					var $control = $(this);

					$control.on('click', '.xts-remove-item', function (e) {
						e.preventDefault();

						$(this).parent().parent().remove();
					});

					$control.find('.xts-add-row').on('click', function (e) {
						e.preventDefault();

						var $content = $control.find('.xts-controls-wrapper');
						var $template = $control.find('.xts-item-template').clone();

						$template = $template.html().replace( /{{index}}/gi, $content.find('> div').length );

						$content.append($template);

						woodmartOptionsAdmin.selectControl(true);
					});
				});
			},

			backgroundControl: function() {
				if ( typeof ($.fn.select2) === 'undefined' ) {
					return;
				}

				var $bgs = $('.xts-active-section .xts-background-control');

				if ($bgs.length <= 0) {
					return;
				}

				$bgs.each(function() {
					var $bg               = $(this),
					    $uploadBtn        = $bg.find('.xts-upload-btn'),
					    $removeBtn        = $bg.find('.xts-remove-upload-btn'),
					    $inputURL         = $bg.find('input.xts-upload-input-url'),
					    $inputID          = $bg.find('input.xts-upload-input-id'),
					    $preview          = $bg.find('.xts-upload-preview'),
					    $colorInput       = $bg.find(
						    '.xts-bg-color input[type="text"]'),
					    $bgPreview        = $bg.find('.xts-bg-preview'),
					    $repeatSelect     = $bg.find('.xts-bg-repeat'),
					    $sizeSelect       = $bg.find('.xts-bg-size'),
					    $imageOptions     = $bg.find('.xts-bg-image-options'),
					    $attachmentSelect = $bg.find('.xts-bg-attachment'),
					    $positionSelect   = $bg.find('.xts-bg-position'),
					    data              = {};

					if ($bg.hasClass('xts-field-inited')) {
						return;
					}

					$colorInput.wpColorPicker({
						change: function(e) {
							updatePreview();
						},
						clear: function() {
							updatePreview();
						}
					});

					$bg.find('select').select2({
						allowClear: true,
						theme     : 'xts'
					});

					$bg.on('click', '.xts-upload-btn, img', function(e) {
						e.preventDefault();

						var custom_uploader = wp.media({
							title   : 'Insert image',
							library : {
								// uncomment the next line if you want to
								// attach image to the current post uploadedTo
								// : wp.media.view.settings.post.id,
								type: 'image'
							},
							button  : {
								text: 'Use this image' // button label text
							},
							multiple: false // for multiple image selection set
							// to true
						}).on('select', function() { // it also has "open" and "close" events
							var attachment = custom_uploader.state().get('selection').first().toJSON();
							$inputID.val(attachment.id);
							$inputURL.val(attachment.url);
							$preview.find('img').remove();
							$preview.prepend(
								'<img src="' + attachment.url + '" />');
							$removeBtn.addClass('xts-active');
							$imageOptions.removeClass('xts-hidden');
							updatePreview();
						}).open();
					});

					$removeBtn.on('click', function(e) {
						e.preventDefault();
						$preview.find('img').remove();
						$inputID.val('');
						$inputURL.val('');
						$removeBtn.removeClass('xts-active');
						$imageOptions.addClass('xts-hidden');
						updatePreview();
					});

					$bg.on('change', 'select', function() {
						updatePreview();
					});

					function updatePreview() {
						data.backgroundColor = $colorInput.val();
						data.backgroundImage = 'url(' + $inputURL.val() + ')';
						data.backgroundRepeat = $repeatSelect.val();
						data.backgroundSize = $sizeSelect.val();
						data.backgroundAttachment = $attachmentSelect.val();
						data.backgroundPosition = $positionSelect.val();
						data.height = 100;

						console.log($colorInput);
						if (data.backgroundColor || $inputURL.val()) {
							$bgPreview.css(data).show();
						} else {
							$bgPreview.hide();
						}
					}

					$bg.addClass('xts-field-inited');
				});
			},

			customFontsControl: function() {
				$('.xts-custom-fonts').each(function() {
					var $parent = $(this);

					$parent.on('click', '.xts-custom-fonts-btn-add',
						function(e) {
							e.preventDefault();

							var $template = $parent.find(
								'.xts-custom-fonts-template').clone();
							var key = $parent.data('key') + 1;

							$parent.find('.xts-custom-fonts-sections').append($template);
							var regex = /{{index}}/gi;
							$template.removeClass('xts-custom-fonts-template hide').html($template.html().replace(regex, key)).attr('data-id', $template.attr('data-id').replace(regex, key));

							$parent.data('key', key);

							woodmartOptionsAdmin.uploadControl( false );
						});

					$parent.on('click', '.xts-custom-fonts-btn-remove',
						function(e) {
							e.preventDefault();

							$(this).parent().remove();
						});
				});
			},

			typographyControlInit: function() {
				var $typography = $('.xts-active-section .xts-advanced-typography-field');

				if ($typography.length <= 0) {
					return;
				}

				$.ajax({
					url     : woodmartConfig.ajaxUrl,
					method  : 'POST',
					data    : {
						action: 'woodmart_get_theme_settings_typography_data',
						security: woodmartConfig.get_theme_settings_data_nonce,
					},
					dataType: 'json',
					success : function(response) {
						woodmartOptionsAdmin.typographyControl(response.typography);
					},
					error   : function() {
						console.log('AJAX error');
					}
				});
			},

			typographyControl: function(typographyData) {
				if ( typeof ($.fn.select2) === 'undefined' ) {
					return;
				}

				var $typography = $('.xts-active-section .xts-advanced-typography-field');
				var isSelecting     = false,
				    selVals         = [],
				    select2Defaults = {
					    width     : '100%',
					    allowClear: true,
					    theme     : 'xts'
				    },
				    defaultVariants = {
					    '100'      : 'Thin 100',
					    '200'      : 'Light 200',
					    '300'      : 'Regular 300',
					    '400'      : 'Normal 400',
					    '500'      : 'Medium 500',
					    '600'      : 'Semi Bold 600',
					    '700'      : 'Bold 700',
					    '800'      : 'Extra Bold 800',
					    '900'      : 'Black 900',
					    '100italic': 'Thin 100 Italic',
					    '200italic': 'Light 200 Italic',
					    '300italic': 'Regular 300 Italic',
					    '400italic': 'Normal 400 Italic',
					    '500italic': 'Medium 500 Italic',
					    '600italic': 'Semi Bold 600 Italic',
					    '700italic': 'Bold 700 Italic',
					    '800italic': 'Extra Bold 800 Italic',
					    '900italic': 'Black 900 Italic'
				    };

				$typography.each(function() {
					var $parent = $(this);

					if ($parent.hasClass('xts-field-inited')) {
						return;
					}

					$parent.find('.xts-typography-section:not(.xts-typography-template)').each(function() {
						var $section = $(this),
						    id       = $section.data('id');

						initTypographySection($parent, id);
					});

					$parent.on('click', '.xts-typography-btn-add', function(e) {
						e.preventDefault();

						var $template = $parent.find('.xts-typography-template').clone(),
						    key       = $parent.data('key') + 1;

						$parent.find('.xts-typography-sections').append($template);
						var regex = /{{index}}/gi;

						$template.removeClass('xts-typography-template hide').html($template.html().replace(regex, key)).attr('data-id',
							$template.attr('data-id').replace(regex, key));

						$parent.data('key', key);

						initTypographySection($parent, $template.attr('data-id'));
					});

					$parent.on('click', '.xts-typography-btn-remove',
						function(e) {
							e.preventDefault();

							$(this).parent().remove();
						});

					$parent.addClass('xts-field-inited');
				});

				function initTypographySection($parent, id) {
					var $section            = $parent.find('[data-id="' + id + '"]'),
					    $family             = $section.find('.xts-typography-family'),
					    $familyInput        = $section.find(
						    '.xts-typography-family-input'),
					    $googleInput        = $section.find(
						    '.xts-typography-google-input'),
					    $customInput        = $section.find(
						    '.xts-typography-custom-input'),
					    $customSelector     = $section.find(
						    '.xts-typography-custom-selector'),
					    $selector           = $section.find('.xts-typography-selector'),
					    $transform          = $section.find('.xts-typography-transform'),
					    $color              = $section.find('.xts-typography-color'),
					    $colorHover         = $section.find(
						    '.xts-typography-color-hover'),
					    $responsiveControls = $section.find(
						    '.xts-typography-responsive-controls'),
						$background         = $section.find('.xts-typography-background'),
						$backgroundHover    = $section.find(
							'.xts-typography-background-hover');

					if ($family.data('value') !== '') {
						$family.val($family.data('value'));
					}

					syncronizeFontVariants($section, true, false);

					//init when value is changed
					$section.find(
						'.xts-typography-family, .xts-typography-style, .xts-typography-subset').on(
						'change',
						function() {
							syncronizeFontVariants($section, false, false);
						}
					);

					var fontFamilies = [
						    {
							    id  : '',
							    text: ''
						    }
					    ],
					    customFonts  = {
						    text    : 'Custom fonts',
						    children: []
					    },
					    stdFonts     = {
						    text    : 'Standard fonts',
						    children: []
					    },
					    googleFonts  = {
						    text    : 'Google fonts',
						    children: []
					    };

					$.map(typographyData.stdfonts, function(val, i) {
						stdFonts.children.push({
							id      : i,
							text    : val,
							selected: (i == $family.data('value'))
						});
					});

					$.map(typographyData.googlefonts, function(val, i) {
						googleFonts.children.push({
							id      : i,
							text    : i,
							google  : true,
							selected: (i == $family.data('value'))
						});
					});

					$.map(typographyData.customFonts, function(val, i) {
						customFonts.children.push({
							id      : i,
							text    : i,
							selected: (i == $family.data('value'))
						});
					});

					if (customFonts.children.length > 0) {
						fontFamilies.push(customFonts);
					}

					fontFamilies.push(stdFonts);
					fontFamilies.push(googleFonts);

					if ( ! $family.hasClass('xts-field-inited')) {
						$family.addClass('xts-field-inited');

						$family.empty();

						$family.select2({
							data             : fontFamilies,
							allowClear       : true,
							theme            : 'xts',
							dropdownAutoWidth: false,
							width            : 'resolve'
						}).on(
							'select2:selecting',
							function(e) {
								var data = e.params.args.data;
								var fontName = data.text;

								$familyInput.attr('value', fontName);

								// option values
								selVals = data;
								isSelecting = true;

								syncronizeFontVariants($section, false, true);
							}
						).on(
							'select2:unselecting',
							function(e) {
								$(this).one('select2:opening', function(ev) {
									ev.preventDefault();
								});
							}
						).on(
							'select2:unselect',
							function(e) {
								$familyInput.val('');

								$googleInput.val('false');

								$family.val(null).trigger('change');

								syncronizeFontVariants($section, false, true);
							}
						);

						$family.hide();
					}

					// CSS selector multi select field
					$selector.select2({
						width     : '100%',
						theme     : 'xts',
						allowClear: true,
						templateSelection: function (state) {
							if ( !state.id || !state.element || !$(state.element).data('hint-src') ) {
								return state.text;
							}

							return $('<span>' + state.text + '</span>' + '<span class="xts-hint"><span class="xts-tooltip xts-top"><img data-src="' + $(state.element).data('hint-src') + '"></span></span>');
						},
					}).on(
						'select2:select',
						function(e) {
							var val = e.params.data.id;
							if (val != 'custom') {
								return;
							}
							$customInput.val(true);
							$customSelector.removeClass('hide');

						}
					).on(
						'select2:unselect',
						function(e) {
							var val = e.params.data.id;
							if (val != 'custom') {
								return;
							}
							$customInput.val('');
							$customSelector.val('').addClass('hide');
						}
					);

					$transform.select2(select2Defaults);

					// Color picker fields
					$color.wpColorPicker({
						change: function(event, ui) {
							// needed for palette click
							setTimeout(function() {
								updatePreview($section);
							}, 5);
						}
					});
					$colorHover.wpColorPicker();

					$background.wpColorPicker({
						change: function(event, ui) {
							// needed for palette click
							setTimeout(function() {
								updatePreview($section);
							}, 5);
						}
					});
					$backgroundHover.wpColorPicker();

					// Responsive font size and line height
					$responsiveControls.on('click',
						'.xts-typography-responsive-opener', function() {
							var $this = $(this);
							$this.parent().find(
								'.xts-typography-control-tablet, .xts-typography-control-mobile').toggleClass('show hide');
						}).on('change', 'input', function() {
						updatePreview($section);
					});
				}

				function updatePreview($section) {
					var sectionFields = {
						familyInput    : $section.find(
							'.xts-typography-family-input'),
						weightInput    : $section.find(
							'.xts-typography-weight-input'),
						preview        : $section.find('.xts-typography-preview'),
						sizeInput      : $section.find(
							'.xts-typography-size-container .xts-typography-control-desktop input'),
						heightInput    : $section.find(
							'.xts-typography-height-container .xts-typography-control-desktop input'),
						colorInput     : $section.find('.xts-typography-color'),
						backgroundInput: $section.find('.xts-typography-background')
					};

					var size       = sectionFields.sizeInput.val(),
					    height     = sectionFields.heightInput.val(),
					    weight     = sectionFields.weightInput.val(),
					    color      = sectionFields.colorInput.val(),
					    family     = sectionFields.familyInput.val(),
					    background = sectionFields.backgroundInput.val();

					if (!height) {
						height = size;
					}

					//show in the preview box the font
					sectionFields.preview.css('font-weight', weight).css('font-family', family + ', sans-serif').css('font-size', size + 'px').css('line-height', height + 'px');

					if (family === 'none' && family === '') {
						//if selected is not a font remove style "font-family"
						// at preview box
						sectionFields.preview.css('font-family', 'inherit');
					}

					if (color) {
						var bgVal = '#444444';
						if (color !== '') {
							// Replace the hash with a blank.
							color = color.replace('#', '');

							var r = parseInt(color.substr(0, 2), 16);
							var g = parseInt(color.substr(2, 2), 16);
							var b = parseInt(color.substr(4, 2), 16);
							var res = ((r * 299) + (g * 587) + (b * 114)) /
								1000;
							bgVal = (res >= 128) ? '#444444' : '#ffffff';
						}

						if (!color.indexOf('gb(')) {
							color = '#' + color;
						}
						sectionFields.preview.css('color', color).css('background-color', bgVal);
					}

					if (background) {
						if (background !== '') {
							background = background.replace('#', '');
						}

						if (!background.indexOf('gb(')) {
							background = '#' + background;
						}
						sectionFields.preview.css('background-color', background);
					}

					sectionFields.preview.slideDown();
				}

				function loadGoogleFont(family, style, script) {

					if (family == null || family == 'inherit') {
						return;
					}

					//add reference to google font family
					//replace spaces with "+" sign
					var link = family.replace(/\s+/g, '+');

					if (style && style !== '') {
						link += ':' + style.replace(/\-/g, ' ');
					}

					if (script && script !== '') {
						link += '&subset=' + script;
					}

					if (typeof (WebFont) !== 'undefined' && WebFont) {
						WebFont.load({
							google: {
								families: [link]
							}
						});
					}
				}

				function syncronizeFontVariants($section, init, changeFamily) {

					var sectionFields = {
						family     : $section.find('.xts-typography-family'),
						familyInput: $section.find(
							'.xts-typography-family-input'),
						style      : $section.find('select.xts-typography-style'),
						styleInput : $section.find(
							'.xts-typography-style-input'),
						weightInput: $section.find(
							'.xts-typography-weight-input'),
						subsetInput: $section.find(
							'.xts-typography-subset-input'),
						subset     : $section.find('select.xts-typography-subset'),
						googleInput: $section.find(
							'.xts-typography-google-input'),
						preview    : $section.find('.xts-typography-preview'),
						sizeInput  : $section.find(
							'.xts-typography-size-container .xts-typography-control-desktop input'),
						heightInput: $section.find(
							'.xts-typography-height-container .xts-typography-control-desktop input'),
						colorInput : $section.find('.xts-typography-color')
					};

					// Set all the variables to be checked against
					var family = sectionFields.familyInput.val();

					if (!family) {
						family = null; //"inherit";
					}

					var style = sectionFields.style.val();
					var script = sectionFields.subset.val();

					// Is selected font a google font?
					var google;
					if (isSelecting === true) {
						google = selVals.google;
						sectionFields.googleInput.val(google);
					} else {
						google = woodmartOptionsAdmin.makeBool(
							sectionFields.googleInput.val()
						); // Check if font is a google font
					}

					// Page load. Speeds things up memory wise to offload to
					// client
					if (init) {
						style = sectionFields.style.data('value');
						script = sectionFields.subset.data('value');

						if (style !== '') {
							style = String(style);
						}

						if (typeof (script) !== undefined) {
							script = String(script);
						}
					}

					// Something went wrong trying to read google fonts, so
					// turn google off
					if (typographyData.googlefonts === undefined) {
						google = false;
					}

					// Get font details
					var details = '';
					if (google === true &&
						(family in typographyData.googlefonts)) {
						details = typographyData.googlefonts[family];
					} else {
						details = defaultVariants;
					}

					sectionFields.subsetInput.val(script);

					// If we changed the font. Selecting variable is set to
					// true only when family field is opened
					if (isSelecting || init || changeFamily) {
						var html = '<option value=""></option>';

						// Google specific stuff
						if (google === true) {

							// STYLES
							var selected = '';
							$.each(
								details.variants,
								function(index, variant) {
									if (variant.id === style ||
										woodmartOptionsAdmin.size(
											details.variants) === 1) {
										selected = ' selected="selected"';
										style = variant.id;
									} else {
										selected = '';
									}

									html += '<option value="' + variant.id +
										'"' + selected + '>' +
										variant.name.replace(
											/\+/g, ' '
										) + '</option>';
								}
							);

							// destroy select2
							if (sectionFields.subset.data('select2')) {
								sectionFields.style.select2('destroy');
							}

							// Instert new HTML
							sectionFields.style.html(html);

							// Init select2
							sectionFields.style.select2(select2Defaults);

							// SUBSETS
							selected = '';
							html = '<option value=""></option>';

							$.each(
								details.subsets,
								function(index, subset) {
									if (subset.id === script ||
										woodmartOptionsAdmin.size(
											details.subsets) === 1) {
										selected = ' selected="selected"';
										script = subset.id;
										sectionFields.subset.val(script);
									} else {
										selected = '';
									}
									html += '<option value="' + subset.id +
										'"' + selected + '>' +
										subset.name.replace(
											/\+/g, ' '
										) + '</option>';
								}
							);

							// Destroy select2
							if (sectionFields.subset.data('select2')) {
								sectionFields.subset.select2('destroy');
							}

							// Inset new HTML
							sectionFields.subset.html(html);

							// Init select2
							sectionFields.subset.select2(select2Defaults);

							sectionFields.subset.parent().fadeIn('fast');
							// $( '#' + mainID + ' .typography-family-backup'
							// ).fadeIn( 'fast' );
						} else {
							if (details) {
								$.each(
									details,
									function(index, value) {
										if (index === style || index ===
											'normal') {
											selected = ' selected="selected"';
											sectionFields.style.find(
												'.select2-chosen').text(value);
										} else {
											selected = '';
										}

										html += '<option value="' + index +
											'"' + selected + '>' +
											value.replace(
												'+', ' '
											) + '</option>';
									}
								);

								// Destory select2
								if (sectionFields.subset.data('select2')) {
									sectionFields.style.select2('destroy');
								}

								// Insert new HTML
								sectionFields.style.html(html);

								// Init select2
								sectionFields.style.select2(select2Defaults);

								// Prettify things
								sectionFields.subset.parent().fadeOut('fast');
							}
						}

						sectionFields.familyInput.val(family);
					}

					// Check if the selected value exists. If not, empty it.
					// Else, apply it.
					if (sectionFields.style.find(
						'option[value=\'' + style + '\']').length === 0) {
						style = '';
						sectionFields.style.val('');
					} else if (style === '400') {
						sectionFields.style.val(style);
					}

					// Weight and italic
					if (style.indexOf('italic') !== -1) {
						sectionFields.preview.css('font-style', 'italic');
						sectionFields.styleInput.val('italic');
						style = style.replace('italic', '');
					} else {
						sectionFields.preview.css('font-style', 'normal');
						sectionFields.styleInput.val('');
					}

					sectionFields.weightInput.val(style);

					// Handle empty subset select
					if (sectionFields.subset.find(
						'option[value=\'' + script + '\']').length === 0) {
						script = '';
						sectionFields.subset.val('');
						sectionFields.subsetInput.val(script);
					}

					if (google) {
						loadGoogleFont(family, style, script);
					}

					if (!init) {
						updatePreview($section);
					}

					isSelecting = false;
				}
			},

			sorterControl: function () {
				$('.xts-sorter-control').each( function () {
					var $this = $(this);
					var $lists = $this.find('.xts-sorter-wrapper ul');

					$lists.sortable({
						connectWith: '.' + $lists.attr('class'),
						update: function () {
							var orders = {};

							$this.find('.xts-sorter-wrapper').each( function () {
								var $wrapper = $(this);
								var wrapperKey = $wrapper.data('key');
								var currentOrder = [];

								$wrapper.find('li').each( function () {
									currentOrder.push($(this).data('id'));
								});

								orders[wrapperKey] = currentOrder;
							})

							$this.find('input[type=hidden]').val(JSON.stringify(orders));
						}
					}).disableSelection();
				})
			},

			themeSettingsTooltips: function () {
				$(document).on('mouseenter mousemove', '.xts-hint:not(.xts-loaded)', function () {
					var $wrapper = $(this);
					var $attachment = $wrapper.find('img');

					if ( ! $attachment.length ) {
						$attachment = $wrapper.find('video');
					}

					if ( ! $attachment.length || $wrapper.hasClass('xts-loaded')) {
						return;
					}

					$wrapper.addClass('xts-loaded xts-loading');

					$attachment.each( function () {
						var $this = $(this);

						if ( $this.attr('src') ) {
							return;
						}

						$this.attr('src', $this.data('src') );
					});

					$attachment.on('load play', function () {
						$wrapper.removeClass('xts-loading');
					});
				});
			},

			makeBool: function(val) {
				if (val == 'false' || val == '0' || val === false || val ===
					0) {
					return false;
				} else if (val == 'true' || val == '1' || val === true || val ==
					1) {
					return true;
				}
			},

			size: function(obj) {
				var size = 0,
				    key;

				for (key in obj) {
					if (obj.hasOwnProperty(key)) {
						size++;
					}
				}

				return size;
			},

			rangeControl: function() {
				var $ranges = $('.xts-active-section .xts-range-control');

				if ($ranges.length <= 0) {
					return;
				}

				$ranges.each(function() {
					var $range  = $(this),
					    $input  = $range.find('.xts-range-value'),
					    $slider = $range.find('.xts-range-slider'),
					    $text   = $range.find('.xts-range-field-value-text'),
					    data    = $input.data();

					$slider.slider({
						range: 'min',
						value: data.start,
						min  : data.min,
						max  : data.max,
						step : data.step,
						slide: function(event, ui) {
							$input.val(ui.value).trigger('change');
							$text.text(ui.value);
						}
					});

					// Initiate the display
					$input.val($slider.slider('value')).trigger('change');
					$text.text($slider.slider('value'));

					$range.addClass('xts-field-inited');
				});

			},

			responsiveRangeControl: function() {
				var $ranges = $('.xts-active-section .xts-responsive_range-control');

				if ($ranges.length <= 0) {
					return;
				}

				$ranges.each(function() {
					$(this).find('.xts-responsive-range').each(function () {
						initSlider($(this));
					});
				});

				$ranges.find('.xts-device').on('click', function () {
					var $this = $(this);
					var $wrapper = $this.parents('.xts-responsive-range-wrapper');

					$this.siblings('.xts-active').removeClass('xts-active');
					$this.addClass('xts-active');

					$wrapper.find('.xts-responsive-range').removeClass('xts-active').siblings('[data-device=' + $this.data('value') + ']').addClass('xts-active');
				});

				$ranges.find('.wd-slider-unit-control').on('click', function () {
					var $this = $(this);
					var $wrapper = $this.parents('.xts-responsive-range');

					if( !$this.siblings().length ) {
						return;
					}

					$this.siblings('.xts-active').removeClass('xts-active');
					$this.addClass('xts-active');

					$wrapper.attr('data-unit', $this.data('unit') );
					initSlider($wrapper);
				});

				$ranges.find('.xts-range-field-value').on('change', function () {
					var $this = $(this);
					var $wrapper = $this.parents('.xts-responsive-range');
					var $mainInput = $wrapper.parent().siblings('.xts-responsive-range-value');
					var $deviceRangeSettings = $mainInput.data('settings');
					var rangeSettings = $deviceRangeSettings.range[$wrapper.data('unit')];
					var valueNew = $this.val();

					if ( valueNew.length ) {
						if ( valueNew >= rangeSettings.max ) {
							valueNew = rangeSettings.max;
							$this.val(valueNew);
						}
						if ( valueNew <= rangeSettings.min ) {
							valueNew = rangeSettings.min;
							$this.val(valueNew);
						}
					}

					$wrapper.attr('data-value', valueNew );
					setMainValue( $mainInput );
					initSlider($wrapper);
				});

				function setMainValue( $input ) {
					let $results = {
						devices: {}
					};

					var changeValue = false;

					$input.siblings('.xts-responsive-range-wrapper').find('.xts-responsive-range').each(function() {
						let $this = $(this);

						if ($this.attr('data-value')) {
							changeValue = true;
						}

						$results.devices[$this.attr('data-device')] = {
							unit : $this.attr('data-unit'),
							value: $this.attr('data-value')
						};
					});

					if (changeValue) {
						$input.attr('value', window.btoa(JSON.stringify($results)));
					} else {
						$input.attr('value', '');
					}
				}

				function initSlider( $deviceRange ) {
					var $slider              = $deviceRange.find('.xts-range-slider');
					var $wrapper             = $deviceRange.parents('.xts-responsive-range-wrapper');
					var $input               = $wrapper.siblings('.xts-responsive-range-value');
					var $deviceRangeSettings = $input.data('settings');
					var device               = $deviceRange.data('device');
					var unit                 = $deviceRange.attr('data-unit');
					var data                 = $deviceRangeSettings['range'][unit];
					var $inputNumber         = $deviceRange.find('.xts-range-field-value');

					if ($deviceRange.attr('data-value')) {
						data.start = $deviceRange.attr('data-value');
					} else {
						data.start = $deviceRangeSettings.devices[device].value;
					}

					if ('undefined' !== typeof $slider.slider()) {
						$slider.slider('destroy');
					}

					$slider.slider({
						range: 'min',
						value: data.start,
						min  : data.min,
						max  : data.max,
						step : data.step,
						slide: function(event, ui) {
							$slider.parent().attr('data-value', ui.value)
							$inputNumber.val(ui.value);
							setMainValue($input);
						}
					});
				}
			},

			uploadIconControl: function () {
				$('.xts-active-section .xts-icon-font-select, .xts-active-section .xts-icon-weight-select').on('change', function () {
					var $wrapper = $(this).parents( '.xts-fields-group' );
					var $preview = $wrapper.find('.xts-icons-preview');
					var font = $wrapper.find('.xts-icon-font-select').val();
					var weight = $wrapper.find('.xts-icon-weight-select').val();

					if ( ! font || ! weight ) {
						return;
					}

					$preview.addClass('xts-loading');
					$wrapper.addClass('xts-loading');

					$.ajax({
						url     : woodmartConfig.ajaxUrl,
						method  : 'GET',
						data    : {
							action  : 'woodmart_get_enqueue_custom_icon_fonts',
							security: woodmartConfig.get_theme_settings_data_nonce,
							font    : font,
							weight  : weight,
						},
						dataType: 'json',
						success : function(response) {
							if ( response.enqueue ) {
								$('style#wd-icon-font').replaceWith(response.enqueue);
							}
						},
						error   : function() {
							console.log('AJAX error');
						},
						complete: function() {
							$preview.removeClass('xts-loading');
							$wrapper.removeClass('xts-loading');
						}
					});
				});
			},

			editorControl: function() {
				var $editors = $('.xts-active-section .xts-editor-control');

				$editors.each(function() {
					var $editor  = $(this),
					    $field   = $editor.find('textarea'),
					    language = $field.data('language');

					if ($editor.hasClass('xts-editor-initiated')) {
						return;
					}

					var editorSettings = wp.codeEditor.defaultSettings
						? _.clone(wp.codeEditor.defaultSettings)
						: {};

					editorSettings.codemirror = _.extend(
						{},
						editorSettings.codemirror,
						{
							indentUnit: 2,
							tabSize   : 2,
							mode      : language
						}
					);

					var editor = wp.codeEditor.initialize($field,
						editorSettings);

					$editor.addClass('xts-editor-initiated');

				});

			},

			fieldsDependencies: function() {
				var $fields = $('.xts-field[data-dependency], .xts-tabs[data-dependency]');

				$fields.each(function() {
					var $field       = $(this),
					    dependencies = $field.data('dependency').split(';');

					dependencies.forEach(function(dependency) {
						if (dependency.length == 0) {
							return;
						}
						var data = dependency.split(':');

						var $parentField = $('.xts-' + data[0] + '-field');

						$parentField.on('change', 'input, select', function(e) {
							testFieldDependency($field, dependencies);
						});

						$parentField.find('input, select').trigger('change');
					});

				});

				function testFieldDependency($field, dependencies) {
					var show = true;
					dependencies.forEach(function(dependency) {
						if (dependency.length == 0 || show == false) {
							return;
						}
						var data         = dependency.split(':'),
						    $parentField = $('.xts-' + data[0] + '-field'),
						    value        = $parentField.find('.xts-option-control input, .xts-option-control select').val();

						switch (data[1]) {
							case 'equals':
								var values = data[2].split(',');
								show = false;
								for (let i = 0; i < values.length; i++) {
									const element = values[i];
									if (value == element) {
										show = true;
									}
								}
								break;
							case 'not_equals':
								var values = data[2].split(',');
								show = true;
								for (let i = 0; i < values.length; i++) {
									const element = values[i];
									if (value == element) {
										show = false;
									}
								}
								break;
						}

					});

					if (show) {
						$field.addClass('xts-shown').removeClass('xts-hidden');
					} else {
						$field.addClass('xts-hidden').removeClass('xts-shown');
					}
				}

			},

			settingsSearch: function() {
				var $searchForm  = $('.xts-options-search');
				var $searchInput = $searchForm.find('input');
				var themeSettingsData;

				if (0 === $searchForm.length) {
					return;
				}

				$.ajax({
					url     : woodmartConfig.ajaxUrl,
					method  : 'POST',
					data    : {
						action: 'woodmart_get_theme_settings_search_data',
						security: woodmartConfig.get_theme_settings_data_nonce,
					},
					dataType: 'json',
					success : function(response) {
						themeSettingsData = response.theme_settings
					},
					error   : function() {
						console.log('AJAX error');
					}
				});

				$searchForm.find('form').submit(function(e) {
					e.preventDefault();
				});

				var $autocomplete = $searchInput.autocomplete({
					source: function(request, response) {
						response(themeSettingsData.filter(function(value) {
							return -1 !== value.text.search(new RegExp(request.term, 'i'));
						}));
					},

					select: function(event, ui) {
						var $field = $('.xts-' + ui.item.id + '-field');

						$('.xts-nav-vertical a[data-id="' + ui.item.section_id + '"]').click();

						$('.xts-highlight-field').removeClass('xts-highlight-field');
						$field.addClass('xts-highlight-field');

						setTimeout(function() {
							if (!isInViewport($field)) {
								$('html, body').animate({
									scrollTop: $field.offset().top - 200
								}, 400);
							}
						}, 300);
					},

					open: function( event, ui ) {
						$searchForm.addClass('xts-searched');
					},

					close: function( event, ui ) {
						$searchForm.removeClass('xts-searched');
					}

				}).data('ui-autocomplete');

				$autocomplete._renderItem = function(ul, item) {
					var $itemContent = '<i class="el ' + item.icon + '"></i><span class="setting-title">' + item.title + '</span><br><span class="settting-path">' + item.path + '</span>';
					return $('<li>')
						.append($itemContent)
						.appendTo(ul);
				};

				$autocomplete._renderMenu = function(ul, items) {
					var that = this;

					$.each(items, function(index, item) {
						that._renderItemData(ul, item);
					});

					$(ul).addClass('xts-settings-result');
				};

				var isInViewport = function($el) {
					var elementTop = $el.offset().top;
					var elementBottom = elementTop + $el.outerHeight();
					var viewportTop = $(window).scrollTop();
					var viewportBottom = viewportTop + $(window).height();
					return elementBottom > viewportTop && elementTop < viewportBottom;
				};
			},

			widgetDependency: function() {
				if ( ! $(document.body).hasClass('widgets-php') ) {
					return;
				}

				if ( ! $(document.body).hasClass('wp-embed-responsive') ) {
					$('.widget').each( function () {
						initWidgetField( $(this) );
					});
				}

				$(document).on('widget-added', function ( e, $element ) {
					initWidgetField( $element );
				});

				function initWidgetField( $element ) {
					$element.find('.wd-widget-field').each( function () {
						var $this = $(this);
						var value = $this.data( 'value' );

						if ( 'undefined' === typeof value || ! $this.data( 'param_name' ) ) {
							return;
						}

						process($this, value);

						$this.find('.widefat').on( 'change', function () {
							var $thisInput = $(this);
							var $parent = $thisInput.parent('.wd-widget-field');
							var value = $thisInput.val();

							$parent.attr( 'data-value', value);

							process($parent, value);
						});
					});
				}

				function process( $element, value ) {
					$element.siblings().each( function () {
						var $this = $(this);
						var dependency = $this.data( 'dependency' );

						if ( 'undefined' !== typeof dependency && dependency.element === $element.data('param_name') ) {
							if ( 'undefined' !== typeof dependency.value ) {
								if ( dependency.value.includes( value ) ) {
									$this.show();
								} else {
									$this.hide();
								}
							}
							if ( 'undefined' !== typeof dependency.value_not_equal_to ) {
								if ( dependency.value_not_equal_to.includes( value ) ) {
									$this.hide();
								} else {
									$this.show();
								}
							}
						}
					});
				}
			},

			presetsActive: function() {
				function checkAll() {
					$('.xts-nav-vertical li').each(function() {
						var $li = $(this);
						var sectionId = $li.find('a').data('id');

						$('.xts-section[data-id="' + sectionId + '"]').find('.xts-inherit-checkbox-wrapper input').each(function() {
							if (!$(this).prop('checked')) {
								$li.addClass('xts-not-inherit');
							}
						});
					});
				}

				function checkChild() {
					$('.xts-nav-vertical .xts-has-child').each(function() {
						var $this  = $(this);
						var $child = $this.find('.xts-not-inherit');
						var checked = false;

						if ($child.length > 0) {
							checked = true;
						}

						if (checked) {
							$this.addClass('xts-not-inherit');
						} else {
							$this.removeClass('xts-not-inherit');
						}
					});
				}

				checkAll();
				checkChild();

				$('.xts-inherit-checkbox-wrapper input').on('change', function() {
					var $this  = $(this);
					var sectionId = $this.parents('.xts-section').data('id');
					var checked = false;
					var $parent = $('.xts-nav-vertical li a[data-id="' + sectionId + '"]').parent();

					$this.parents('.xts-section').find('.xts-inherit-checkbox-wrapper input').each(function() {
						if (!$(this).prop('checked')) {
							checked = true;
						}
					});

					if (checked) {
						$parent.addClass('xts-not-inherit');
					} else {
						$parent.removeClass('xts-not-inherit');
					}

					checkChild();
					checkAll();
				});
			},

			optionsPresetsCheckbox: function() {
				var $options = $('.xts-options');
				var $fieldsToSave = $options.find('.xts-fields-to-save');
				var $checkboxes = $options.find('.xts-inherit-checkbox-wrapper input');

				$checkboxes.on('change', function() {
					var $checkbox = $(this);
					var $field = $checkbox.parents('.xts-field');
					var checked = $checkbox.prop('checked');
					var name = $checkbox.data('name');

					var addField = function(name) {
						var current     = $fieldsToSave.val();
						var fieldsArray = current.split(',');
						var index       = fieldsArray.indexOf(name);

						if (index > -1) {
							return;
						}

						if (current.length === 0) {
							fieldsArray = [name];
						} else {
							fieldsArray.push(name);
						}

						$fieldsToSave.val(fieldsArray.join(','));
					}

					var removeField = function(name) {
						var current     = $fieldsToSave.val();
						var fieldsArray = current.split(',');
						var index       = fieldsArray.indexOf(name);

						if (index > -1) {
							fieldsArray.splice(index, 1);
							$fieldsToSave.val(fieldsArray.join(','));
						}
					}

					if (!checked) {
						$field.removeClass('xts-field-disabled');
						addField(name);
					} else {
						$field.addClass('xts-field-disabled');
						removeField(name);
					}
				});
			}
		};

		return {
			init: function() {
				$(document).ready(function() {
					woodmartOptionsAdmin.optionsPage();
					woodmartOptionsAdmin.optionsPresetsCheckbox();
					woodmartOptionsAdmin.presetsActive();
					woodmartOptionsAdmin.switcherControl();
					woodmartOptionsAdmin.buttonsControl();
					woodmartOptionsAdmin.fieldsDependencies();
					woodmartOptionsAdmin.customFontsControl();
					woodmartOptionsAdmin.settingsSearch();
					woodmartOptionsAdmin.widgetDependency();
					woodmartOptionsAdmin.sorterControl();
					woodmartOptionsAdmin.themeSettingsTooltips();
					woodmartOptionsAdmin.selectWithTableControl();

					woodmart_media_init();
					woodmartOptionsAdmin.selectControl(true);
					woodmartOptionsAdmin.uploadControl(true);
					woodmartOptionsAdmin.uploadListControl(true);
				});

				$(document).on('widget-updated widget-added', function(e, widget) {
					woodmart_media_init();
					woodmartOptionsAdmin.selectControl(true);
					woodmartOptionsAdmin.uploadControl(true);
					woodmartOptionsAdmin.uploadListControl(true);
				});

				$(document).on('xts_section_changed', function() {
					setTimeout(function() {
						woodmartOptionsAdmin.typographyControlInit();
					});
					woodmartOptionsAdmin.buttonsControl();
					woodmartOptionsAdmin.selectControl(false);
					woodmartOptionsAdmin.uploadControl(false);
					woodmartOptionsAdmin.uploadListControl(false);
					woodmartOptionsAdmin.colorControl();
					woodmartOptionsAdmin.backgroundControl();
					woodmartOptionsAdmin.switcherControl();
					woodmartOptionsAdmin.rangeControl();
					woodmartOptionsAdmin.responsiveRangeControl();
					woodmartOptionsAdmin.uploadIconControl();
				});
			}
		};
	}());
})(jQuery);

jQuery(document).ready(function() {
	woodmartOptions.init();
});
