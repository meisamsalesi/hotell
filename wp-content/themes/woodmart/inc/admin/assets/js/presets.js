/* global jQuery, woodmartConfig */

(function($) {
	'use strict';

	function optionsPresets() {
		$('.xts-preset').each(function() {
			var $preset = $(this);
			var presetID = $preset.data('id');

			$preset.on('click', '.xts-preset-edit', function(e) {
				e.preventDefault();

				$preset.toggleClass('xts-opened');
			});

			$preset.on('click', '.xts-preset-save', function(e) {
				e.preventDefault();

				var data = [];

				$preset.find('.xts-condition').each(function() {
					var $condition = $(this);

					data.push({
						type      : $condition.find('.xts-condition-type select').val(),
						comparison: $condition.find('.xts-condition-comparison select').val(),
						post_type : $condition.find('.xts-condition-post-type select').val(),
						taxonomy  : $condition.find('.xts-condition-taxonomy select').val(),
						custom    : $condition.find('.xts-condition-custom select').val(),
						value_id  : $condition.find('.xts-condition-value-id').val(),
						user_role : $condition.find('.xts-condition-user-role select').val()
					});
				});

				$preset.addClass('xts-loading');

				$.ajax({
					url     : woodmartConfig.ajaxUrl,
					method  : 'POST',
					data    : {
						action   : 'xts_save_preset_action',
						data     : data,
						priority : $preset.find('.xts-priority').val(),
						name     : $preset.find('.xts-preset-name input').val(),
						preset_id: presetID,
						security : woodmartConfig.presets_nonce
					},
					dataType: 'json',
					success : function(response) {
						$('.xts-notices-wrapper').html('<div class="xts-notice xts-success">' + response.data.message + '</div>');
						$preset.removeClass('xts-loading');
					}
				});
			});

			$preset.on('submit', '.xts-preset-remove-form', function(e){
				var choice = confirm('Are you sure you want to remove the this preset?');

				if (!choice) {
					e.preventDefault();
				}
			});

			$preset.on('click', '.xts-preset-add-condition', function(e) {
				e.preventDefault();
				var $template = $('.xts-condition-template').clone();

				$template.find('.xts-condition').removeClass('xts-hidden');
				$preset.find('.xts-preset-add-condition').before($template.html());
				initSelect2();
			});

			$preset.on('click', '.xts-condition-remove', function(e) {
				e.preventDefault();
				$(this).parent().remove();
			});

			$preset.on('change', '.xts-condition-type select', function() {
				var $type = $(this);
				var $condition = $type.parents('.xts-condition');
				var $postType = $condition.find('.xts-condition-post-type');
				var $taxonomy = $condition.find('.xts-condition-taxonomy');
				var $custom = $condition.find('.xts-condition-custom');
				var $valueID = $condition.find('.xts-condition-value-wrapper');
				var $userRole = $condition.find('.xts-condition-user-role');
				var type = $type.val();

				switch (type) {
					case 'post_type':
						$postType.removeClass('xts-hidden');
						$taxonomy.addClass('xts-hidden');
						$custom.addClass('xts-hidden');
						$valueID.addClass('xts-hidden');
						$userRole.addClass('xts-hidden');
						break;
					case 'taxonomy':
						$postType.addClass('xts-hidden');
						$taxonomy.removeClass('xts-hidden');
						$custom.addClass('xts-hidden');
						$valueID.addClass('xts-hidden');
						$userRole.addClass('xts-hidden');
						break;
					case 'post_id':
					case 'term_id':
					case 'single_posts_term_id':
						$postType.addClass('xts-hidden');
						$taxonomy.addClass('xts-hidden');
						$custom.addClass('xts-hidden');
						$valueID.removeClass('xts-hidden');
						$userRole.addClass('xts-hidden');
						break;
					case 'custom':
						$postType.addClass('xts-hidden');
						$taxonomy.addClass('xts-hidden');
						$custom.removeClass('xts-hidden');
						$valueID.addClass('xts-hidden');
						$userRole.addClass('xts-hidden');
						break;
					case 'user_role':
						$postType.addClass('xts-hidden');
						$taxonomy.addClass('xts-hidden');
						$custom.addClass('xts-hidden');
						$valueID.addClass('xts-hidden');
						$userRole.removeClass('xts-hidden');
						break;

					case '':
						$postType.addClass('xts-hidden');
						$taxonomy.addClass('xts-hidden');
						$custom.addClass('xts-hidden');
						$valueID.addClass('xts-hidden');
						$userRole.addClass('xts-hidden');
						break;
				}
			});

			initSelect2();

			function initSelect2() {
				if (typeof ($.fn.select2) === 'undefined') {
					return;
				}

				$preset.find('.xts-preset-conditions .xts-condition').each(function() {
					var $condition = $(this);

					$condition.find('.xts-condition-value-id').select2({
						ajax             : {
							url     : woodmartConfig.ajaxUrl,
							data    : function(params) {
								return {
									action  : 'xts_get_entity_ids_action',
									type    : $condition.find('.xts-condition-type select').val(),
									security: woodmartConfig.presets_nonce,
									name    : params.term
								};
							},
							method  : 'POST',
							dataType: 'json'
						},
						theme            : 'xts',
						dropdownAutoWidth: false,
						width            : 'resolve'
					});
				});
			}
		});
	}

	jQuery(document).ready(function() {
		optionsPresets();
	});
})(jQuery);