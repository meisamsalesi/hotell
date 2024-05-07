/* global woodmartConfig */

(function($) {
	'use strict';

	$(document).on('change', '.xts-bought-together-controls select', function(e) {
		var $this = $(this);
		var $wrapper = $this.parents('.xts-bought-together');
		var $input = $this.siblings('.xts-product-bundles-id');
		var bundlesID = $input.val();
		var value = $this.val();

		if ( bundlesID ) {
			var $ids = bundlesID.split(',');

			if ( $ids.includes( value ) ) {
				$this.val('').trigger('change.select2');

				return;
			}

			bundlesID += ',' + value;
		} else {
			bundlesID = value;
		}

		$wrapper.addClass('xts-loading');

		$.ajax({
			url    : woodmartConfig.ajaxUrl,
			method : 'POST',
			data   : {
				action    : 'xts_get_bundles_settings_content',
				bundles_id: bundlesID,
				product_id: $input.data('product-id'),
				security  : $input.data('nonce'),
			},
			success: function(response) {
				$wrapper.find('.wp-list-table tbody').html(response.content);
				$this.val('').trigger('change.select2');
				$input.val(bundlesID);
				$wrapper.removeClass('xts-loading');
			}
		});
	});

	$(document).on('click', '.xts-bought-together .xts-delete-bundle', function(e) {
		e.preventDefault();

		var $this = $(this);
		var $wrapper = $this.parents('.xts-bought-together');
		var $input = $wrapper.find('.xts-product-bundles-id');
		var bundlesID = $input.val();
		var id = $this.data('id').toString();

		if ( bundlesID ) {
			var $ids = bundlesID.split(',');
			var index = $ids.indexOf(id);

			if (index > -1) {
				$ids.splice(index, 1);
				bundlesID = $ids.join(',');

				$wrapper.addClass('xts-loading');

				$.ajax({
					url    : woodmartConfig.ajaxUrl,
					method : 'POST',
					data   : {
						action    : 'xts_get_bundles_settings_content',
						bundles_id: bundlesID,
						product_id: $input.data('product-id'),
						security  : $input.data('nonce'),
					},
					success: function(response) {
						$wrapper.find('.wp-list-table tbody').html(response.content);
						$wrapper.removeClass('xts-loading');
						$input.val(bundlesID);
					}
				});
			}
		}
	});

})(jQuery);