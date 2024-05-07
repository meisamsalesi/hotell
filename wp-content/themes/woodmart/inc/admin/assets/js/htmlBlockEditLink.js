/* global woodmartConfig */

(function($) {
	'use strict';

	document.addEventListener('wdBuilderPopupOpened', (event) => {
		htmlBlockEditLink();
	});

	$('#vc_ui-panel-edit-element').on('vcPanel.shown', function() {
		htmlBlockEditLink();
	});

	jQuery(window).on('elementor:init', function() {
		elementor.hooks.addAction('panel/open_editor/widget', function () {
			htmlBlockEditLink();
		});
	});

	function htmlBlockEditLink() {
		$('.xts-edit-block-link').each(function() {
			var $link = $(this);
			var $parent = $link.parent();

			if ($link.parents('.whb-editor-field-inner').length) {
				$parent = $link.parents('.whb-editor-field-inner');
			}

			var $select = $parent.find('select');

			if (!$select.length) {
				$select = $parent.parent().find('select');
			}

			if ( ! $select.length ) {
				return;
			}

			changeLink();

			$select.on( 'change', function() {
				changeLink();
			});

			function changeLink() {
				var selectValue = $select.find('option:selected').val();
				var currentHref = $link.attr('href');

				var newHref = currentHref.split('post=')[0] + 'post=' + selectValue + '&action=';
				if ( $('body').hasClass('elementor-editor-active') || 'undefined' !== typeof woodmartConfig && 'elementor' === woodmartConfig.current_page_builder) {
					newHref += 'elementor';
				} else {
					newHref += 'edit';
				}

				if (!selectValue || '0' === selectValue || 0 === selectValue) {
					$link.hide();
					$link.siblings('.xts-add-block-link').show();
				} else {
					$link.attr('href', newHref).show();
					$link.siblings('.xts-add-block-link').hide();
				}
			}
		});
	}

	$(document).ready(function() {
		htmlBlockEditLink();
	});
})(jQuery);