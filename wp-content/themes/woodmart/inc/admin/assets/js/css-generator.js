/* global jQuery, woodmartConfig, woodmartAdmin */

(function($) {
	'use strict';

	function cssGenerator () {
		// General.
		var $form = $('.xts-generator-form');
		$form.on('change', '[type=\"checkbox\"]', prepare);
		prepare();

		// General.
		function prepare() {
			var fields = {};
			var $this = $(this);
			var id = $this.attr('id');
			var checked = $this.prop('checked');
			var $children = $form.find('[data-parent="' + id + '"] [type=\"checkbox\"]');

			$children.prop('checked', checked);

			var parentChecked = function($this) {
				$form.find('[name="' + $this.parent().data('parent') + '"]').each(function() {
					$(this).prop('checked', 'checked');
					if ('none' !== $(this).parent().data('parent')) {
						parentChecked($(this));
					}
				});
			};

			if ('none' !== $this.parent().data('parent')) {
				parentChecked($(this));
			}

			var uncheckedEmpty = function($this) {
				var id = $this.parent().data('parent');
				var $children = $form.find('[data-parent="' + id + '"]');

				if ($children.length > 0) {
					var checked = false;

					$children.each(function() {
						if ($(this).find('[type="checkbox"]').prop('checked')) {
							checked = true;
						}
					});

					if (!checked) {
						$form.find('[name="' + id + '"]').prop('checked', '');
						uncheckedEmpty($form.find('[name="' + id + '"]'));
					}
				}
			};

			uncheckedEmpty($(this));

			$form.find('[type="checkbox"]').each(function() {
				fields[this.name] = $(this).prop('checked') ? true : false;
			});

			var base64 = btoa(JSON.stringify(fields));

			$form.find('[name="css-data"]').val(base64);
		}

		$('.css-update-button').on('click', function(e) {
			e.preventDefault();
			$form.find('[name="generate-css"]').click();
		});

		$form.on('click', '[name="generate-css"]', function() {
			$form.parents('.xts-box-content').addClass('xts-loading');
		});
	}

	jQuery(document).ready(function() {
		cssGenerator();
	});
})(jQuery);