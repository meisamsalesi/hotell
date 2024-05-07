/* global woodmartConfig */

(function($) {
	'use strict';

	$(document).on('click', '.xts-create-backup', function(e) {
		e.preventDefault();

		$('.xts-box-content').addClass('xts-loading');
		cleanNotices();

		$.ajax({
			url    : woodmartConfig.ajaxUrl,
			method : 'POST',
			data   : {
				action  : 'xts_create_backup',
				security: woodmartConfig.backup_nonce
			},
			success: function(response) {
				$('.xts-box').replaceWith(response.data.content);
				printNotice(response.success, response.data.message);
				$('.xts-box-content').removeClass('xts-loading');
			}
		});
	});

	$(document).on('click', '.xts-delete-backup', function(e) {
		e.preventDefault();

		if (!confirm(woodmartConfig.remove_backup_text)) {
			return;
		}

		var $this = $(this);

		$('.xts-box-content').addClass('xts-loading');
		cleanNotices();

		$.ajax({
			url    : woodmartConfig.ajaxUrl,
			method : 'POST',
			data   : {
				action  : 'xts_delete_backup',
				id      : $this.parents('.xts-backup-item').data('id'),
				security: woodmartConfig.backup_nonce
			},
			success: function(response) {
				$('.xts-box').replaceWith(response.data.content);
				printNotice(response.success, response.data.message);
				$('.xts-box-content').removeClass('xts-loading');
			}
		});
	});

	$(document).on('click', '.xts-apply-backup', function(e) {
		e.preventDefault();

		var $this = $(this);

		if (!confirm(woodmartConfig.apply_backup_text)) {
			return;
		}

		$('.xts-box-content').addClass('xts-loading');
		cleanNotices();

		$.ajax({
			url    : woodmartConfig.ajaxUrl,
			method : 'POST',
			data   : {
				action  : 'xts_apply_backup',
				id      : $this.parents('.xts-backup-item').data('id'),
				security: woodmartConfig.backup_nonce
			},
			success: function(response) {
				printNotice(response.success, response.data.message);
				$this.removeClass('xts-loading');
				$('.xts-box-content').removeClass('xts-loading');
			}
		});
	});

	function cleanNotices() {
		$('.xts-notices-wrapper').html('');
	}

	function printNotice(success, message) {
		$('.xts-notices-wrapper').append(`
			<div class="xts-notice xts-${success ? 'success' : 'error'}">
				${message}
			</div>
		`);
	}
})(jQuery);