(function($) {

	//Frontend live save
	var $saveButton = $('[data-vc-ui-element="button-save"]');

	$saveButton.on('click', function() {
		if (!$('body').hasClass('vc_editor')) {
			return false;
		}

		var $vcIframe = $('#vc_inline-frame');
		var cssId = $('.woodmart-css-id').val();
		var $styleTag = $vcIframe.contents().find('#new' + cssId);
		var results = '';
		var rawResults = {
			desktop: {},
			tablet : {},
			mobile : {}
		};
		var rawCss = {
			desktop: '',
			tablet : '',
			mobile : ''
		};

		$('.wpb_el_type_woodmart_responsive_spacing').each(function() {
			var $control = $(this);
			var data = $control.find('.wpb_vc_param_value').val();

			if (!data || $control.hasClass('vc_dependent-hidden')) {
				return;
			}

			data = JSON.parse(window.atob(data));

			$.each(data.data, function(device, values) {
				$.each(values, function(property, value) {
					var selector = '.website-wrapper .wd-rs-' + cssId;
					if ('vc_column' === data.shortcode || 'vc_column_inner' === data.shortcode) {
						selector += ' > .vc_column-inner';
					}

					if (typeof rawResults[device][selector] !== 'object') {
						rawResults[device][selector] = {};
					}

					if (typeof rawResults[device][selector][property] !== 'object') {
						rawResults[device][selector][property] = {};
					}

					rawResults[device][selector][property] = property + ':' + value + ' !important;';
				});
			});
		});

		$('.wpb_el_type_wd_colorpicker, .wpb_el_type_wd_box_shadow, .wpb_el_type_wd_dimensions, .wpb_el_type_wd_number, .wpb_el_type_wd_select, .wpb_el_type_wd_slider').each(function() {
			var $control = $(this);
			var settings = $control.data('param_settings');
			var data = $control.find('.wpb_vc_param_value').val();

			if (!data || $control.hasClass('vc_dependent-hidden')) {
				return;
			}

			data = JSON.parse(window.atob(data));

			$.each(settings.selectors, function(selector, properties) {
				$.each(data.devices, function(device, deviceValue) {
					selector = selector.replace('{{WRAPPER}}', '.wd-rs-' + cssId);

					properties.forEach(function(property, index) {
						if (deviceValue.color || (deviceValue.value && '-' !== deviceValue.value)) {
							if (typeof rawResults[device][selector] !== 'object') {
								rawResults[device][selector] = {};
							}

							if (typeof rawResults[device][selector][property] !== 'object') {
								rawResults[device][selector][property] = {};
							}
						}

						var value;

						if (settings.type === 'wd_box_shadow' && deviceValue.color) {
							value = property.replace('{{HORIZONTAL}}', deviceValue.horizontal);
							value = value.replace('{{VERTICAL}}', deviceValue.vertical);
							value = value.replace('{{BLUR}}', deviceValue.blur);
							value = value.replace('{{SPREAD}}', deviceValue.blur);
							value = value.replace('{{COLOR}}', deviceValue.color);

							rawResults[device][selector][property] = value;
						} else if (deviceValue.value && '-' !== deviceValue.value) {
							value = property.replace('{{VALUE}}', deviceValue.value);

							if (deviceValue.unit) {
								value = value.replace('{{UNIT}}', deviceValue.unit);
							}

							rawResults[device][selector][property] = value;
						}
					});
				});
			});
		});

		$.each(rawResults, function(device, selectors) {
			$.each(selectors, function(selector, cssData) {
				rawCss[device] += selector + '{';
				$.each(cssData, function(index, cssValue) {
					rawCss[device] += cssValue;
				});
				rawCss[device] += '}';
			});
		});

		$.each(rawCss, function(device, cssValue) {
			if (device === 'desktop' && cssValue) {
				results += cssValue;
			} else if (device === 'tablet' && cssValue) {
				results += '@media (max-width: 1199px) {' + cssValue + '}';
			} else if (device === 'mobile' && cssValue) {
				results += '@media (max-width: 767px) {' + cssValue + '}';
			}
		});

		if ($styleTag.length === 0) {
			$vcIframe.contents().find('body').prepend('<style id="new' + cssId + '" data-type="woodmart_shortcodes-custom-css">' + results + '</style>');
		} else if ($styleTag.length > 0) {
			$styleTag.html(results);
		}
	});

	$saveButton.on('click', function() {
		if (!$('body').hasClass('vc_editor')) {
			return;
		}

		var $vcIframe = $('#vc_inline-frame');
		var cssId = $('.woodmart-css-id').val();
		var $styleTag = $vcIframe.contents().find('#' + cssId);
		var results = '';
		var sortedCssData = {};
		var css = {
			desktop: '',
			tablet : '',
			mobile : ''
		};

		$('.woodmart-rs-wrapper, .woodmart-vc-colorpicker').each(function() {
			dataSorting($(this));
		});

		$.each(sortedCssData, function(size, selectors) {
			$.each(selectors, function(selector, cssData) {
				css[size] += selector + '{';
				$.each(cssData, function(cssProp, cssValue) {
					css[size] += cssProp + ':' + cssValue + ';';
				});
				css[size] += '}';
			});
		});

		$.each(css, function(size, cssValue) {
			if (size == 'desktop' && cssValue) {
				results += cssValue;
			} else if (size == 'tablet' && cssValue) {
				results += '@media (max-width: 1199px) {' + cssValue + '}';
			} else if (size == 'mobile' && cssValue) {
				results += '@media (max-width: 767px) {' + cssValue + '}';
			}
		});

		if ($styleTag.length == 0) {
			$vcIframe.contents().find('body').prepend('<style id="' + cssId + '" data-type="woodmart_shortcodes-custom-css">' + results + '</style>');
		} else if ($styleTag.length > 0) {
			$styleTag.html(results);
		}

		function dataSorting($this) {
			if ($this.parents('.vc_shortcode-param').hasClass('vc_dependent-hidden')) {
				return;
			}
			var data = $this.find('.wpb_vc_param_value').val();

			if (data) {
				var parseData = JSON.parse(window.atob(data));

				$.each(parseData.data, function(size, cssValue) {
					if (typeof sortedCssData[size] != 'object') {
						sortedCssData[size] = {};
					}

					$.each(parseData.css_args, function(cssProp, classesArray) {
						$.each(classesArray, function(index, cssClass) {
							selector = '#wd-' + parseData.selector_id + cssClass;

							if (typeof sortedCssData[size][selector] != 'object') {
								sortedCssData[size][selector] = {};
							}

							if (typeof sortedCssData[size][selector][cssProp] != 'object') {
								sortedCssData[size][selector][cssProp] = {};
							}

							if (cssProp == 'font-size') {
								sortedCssData[size][selector]['line-height'] = parseInt(cssValue.replace('px', '')) + 10 + 'px';
							}
							if (cssProp == 'line-height') {
								delete sortedCssData[size][selector]['line-height'];
							}
							sortedCssData[size][selector][cssProp] = cssValue;
						});
					});
				});
			}
		}
	});

	//JS init on frontend editor
	if (typeof window.InlineShortcodeView != 'undefined') {
		window.InlineShortcodeView_woodmart_brands = window.InlineShortcodeView.extend({
			rendered: function() {
				$(document).trigger('FrontendEditorCarouselInit', [this.$el.find('.brands-items-wrapper')]);
				window.InlineShortcodeView_woodmart_brands.__super__.rendered.call(this);
			}
		});

		window.InlineShortcodeView_woodmart_categories = window.InlineShortcodeView.extend({
			rendered: function() {
				$(document).trigger('FrontendEditorCarouselInit', [this.$el.find('.categories-style-carousel')]);
				window.InlineShortcodeView_woodmart_categories.__super__.rendered.call(this);
			}
		});

		window.InlineShortcodeView_woodmart_blog = window.InlineShortcodeView.extend({
			rendered: function() {
				$(document).trigger('FrontendEditorCarouselInit', [this.$el.find('.slider-type-post')]);
				window.InlineShortcodeView_woodmart_blog.__super__.rendered.call(this);
			}
		});

		window.InlineShortcodeView_woodmart_gallery = window.InlineShortcodeView.extend({
			rendered: function() {
				$(document).trigger('FrontendEditorCarouselInit', [this.$el.find('.wd-images-gallery')]);
				window.InlineShortcodeView_woodmart_gallery.__super__.rendered.call(this);
			}
		});

		window.InlineShortcodeView_woodmart_instagram = window.InlineShortcodeView.extend({
			rendered: function() {
				$(document).trigger('FrontendEditorCarouselInit', [this.$el.find('.instagram-pics')]);
				window.InlineShortcodeView_woodmart_instagram.__super__.rendered.call(this);
			}
		});

		window.InlineShortcodeView_woodmart_products = window.InlineShortcodeView.extend({
			rendered: function() {
				$(document).trigger('FrontendEditorCarouselInit', [this.$el.find('.slider-type-product')]);
				window.InlineShortcodeView_woodmart_products.__super__.rendered.call(this);
			}
		});
	}

})(jQuery);
