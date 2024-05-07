/* global jQuery, woodmartConfig */

(function($) {
	'use strict';

	function listElement() {
		var $editor = $('#vc_ui-panel-edit-element');

		$editor.on('vcPanel.shown', function() {
			if ($editor.attr('data-vc-shortcode') != 'woodmart_list' && $editor.attr('data-vc-shortcode') != 'woodmart_table_row') {
				return;
			}

			var $groupField        = $editor.find('[data-param_type="param_group"]'),
			    $groupFieldOpenBtn = $groupField.find('.column_toggle:first');

			setTimeout(function() {
				$groupFieldOpenBtn.click();
			}, 300);
		});
	}

	jQuery(document).ready(function() {
		listElement();
	});
})(jQuery);