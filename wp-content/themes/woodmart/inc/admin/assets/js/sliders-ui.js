/* global jQuery, woodmartConfig */

(function($) {
	'use strict';

	function slidersUi() {
		var $sliderdiv = $('#woodmart_sliderdiv')
		var $sliderAll = $('#woodmart_slider-all');
		var $currentID = $('#post_ID').val();
		var sliderId = [];

		$sliderAll.find('input[checked="checked"]').each( function () {
			sliderId.push($(this).val());
		});

		$sliderdiv.addClass('xts-loading');

		$.ajax({
			url    : woodmartConfig.ajaxUrl,
			data   : {
				action   : 'woodmart_get_slides_data',
				slider_id: sliderId,
				security : woodmartConfig.get_slides_nonce
			},
			error  : function() {
				$sliderdiv.removeClass('xts-loading');
			},
			success: function(response) {
				$sliderdiv.removeClass('xts-loading');

				if (!response.data) {
					return false;
				}

				$('#woodmart_slider-all [id*="woodmart_slider-"]').each(function() {
					var $this = $(this);
					var slider_id = $this.attr('id').replace('woodmart_slider-', '');

					if ( 'undefined' === typeof response.data[slider_id] ) {
						return;
					}

					var data = response.data[slider_id];

					$this.append('<a class="xts-inline-btn xts-style-icon xts-i-cog xts-tooltip-mirror" href="' + data['slider_edit_link'] + '"><span class="xts-tooltip xts-left">' + data['slider_edit_text'] + '</span></a>');

					if ( 'undefined' === typeof data['slides'] ) {
						return;
					}

					$this.append('<ul class="children"></ul>');

					var $ul = $this.find('ul');

					for (const key in data['slides']) {
						var slide = data['slides'][key];
						var img = slide.img_url ? `<img src="${slide.img_url}" alt="slide">` : '';
						var classes = parseInt($currentID) === parseInt(slide.id) ? 'xts-current' : '';

						if ( !img && slide.bg_color ) {
							img = `<span class="xts-slider-bg-color" style="background-color: ${slide.bg_color}"></span>`
						}

						$ul.append(`<li class="${classes}"><a href="${slide.link}">${img}${slide.title}</a></li>`);
					}
				});

				var activeSlider = '';
				var params = new URLSearchParams(window.location.search)

				if ( params ) {
					for (let param of params) {
						if ( param[0] === 'slider_id' ) {
							activeSlider = param[1];
						}
					}
				}

				if ( activeSlider ) {
					$sliderAll.find('#in-woodmart_slider-' + activeSlider).prop('checked', true);
				}
			}
		});
	}

	jQuery(document).ready(function() {
		slidersUi();
	});
})(jQuery);