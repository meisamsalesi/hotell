/* global jQuery, woodmartConfig */

(function($) {
	'use strict';

	function vcTemplatesLibrary() {
		var $head   = $('.xts-wpb-templates-heading'),
		    $list   = $('.woodmart-templates-list'),
		    $search = $head.find('.woodmart-templates-search');

		$search.on('keyup', function(e) {
			var val = $(this).val().toLowerCase();

			$list.find('.woodmart-template-item').each(function() {
				var $this = $(this);

				if (($this.attr('data-template_name') + $this.attr('data-template_title')).toLowerCase().indexOf(val) > -1) {
					$this.removeClass('hide-by-search').addClass('show-by-search');
				} else {
					$this.addClass('hide-by-search').removeClass('show-by-search');
				}
			});
		});

		/* filters */

		$list.on('click', '.woodmart-templates-tags a', function(e) {
			e.preventDefault();

			var slug = $(this).data('slug');

			$(this).parent().parent().find('.xts-active').removeClass('xts-active');
			$(this).parent().addClass('xts-active');

			$list.find('.woodmart-template-item').each(function() {
				var $this = $(this);

				if ($this.hasClass('tag-' + slug)) {
					$this.removeClass('hide-by-tag').addClass('show-by-tag');
				} else {
					$this.addClass('hide-by-tag').removeClass('show-by-tag');
				}
			});

		});

		/* loader function */

		$list.on('click', '[data-template-handler]', function() {
			$list.addClass('xts-loading element-adding');
		});

		var $vcTemplatesBtn = $('#vc_templates-editor-button, #vc_templates-more-layouts'),
		    templatesLoaded = false,
		    templates;

		$vcTemplatesBtn.on('click', function() {

			setTimeout(function() {
				$list.find('.woodmart-template-item').show();

				if ($list.hasClass('element-adding')) {
					$list.removeClass('element-adding xts-loading');
				}

				$search.val('');
				loadTemplates();
			}, 100);

		});

		$('#vc_inline-frame').on('load', function() {
			var iframeBody = $('body', $('#vc_inline-frame')[0].contentWindow.document);

			$(iframeBody).on('click', '#vc_templates-more-layouts', function() {
				$list.find('.woodmart-template-item').show();

				if ($list.hasClass('element-adding')) {
					$list.removeClass('element-adding xts-loading');
				}

				$search.val('');
				loadTemplates();
			});
		});

		function loadTemplates() {
			if (templatesLoaded) {
				return;
			}
			templatesLoaded = true;

			$.ajax({
				url        : woodmartConfig.demoAjaxUrl,
				data       : {
					action: 'woodmart_load_templates'
				},
				dataType   : 'json',
				crossDomain: true,
				method     : 'POST',
				success    : function(data) {
					if (data.count > 0) {
						renderElements(data.elements);
						renderTags(data.tags, data.count);
					}

				},
				error      : function(err) {
					$('.woodmart-templates-list').prepend('Can\'t load templates from the server.').removeClass('xts-loading');
					console.log('can\'t load templates from the server', err);
				}
			});

		}

		function renderTags(tags, count) {
			var html = '';
			Object.keys(tags).map(function(objectKey, index) {
				var tag = tags[objectKey];
				html = html + renderTag(tag);
			});
			html = '<div class="woodmart-templates-tags"><ul class="xts-filter"><li class="xts-active"><a href="#all" data-slug="all"><span class="tab-preview-name">All</span> <span class="tab-preview-count">' + count + '</span></a></li>' + html + '</ul></div>';
			// console.log(html)
			$('.woodmart-templates-list').prepend(html);
		}

		function renderTag(tag) {
			var html = '';
			html += '<li><a href="#' + tag.slug + '" data-slug="' + tag.slug + '"><span class="tab-preview-name">' + tag.title + '</span> <span class="tab-preview-count">' + tag.count + '</span></a></li>';

			return html;
		}

		function renderElements(elements) {
			var html = '';
			Object.keys(elements).map(function(objectKey, index) {
				var element = elements[objectKey];
				html = renderElement(element) + html;
			});
			// console.log(html)
			$('.woodmart-templates-list').prepend(html).removeClass('xts-loading');
		}

		function renderElement(element) {
			var html = '';
			html += '<div class="woodmart-template-item xts-import-item ' + element.class + '" data-template_id="' + element.id + '" data-template_unique_id="' + element.id + '" data-template_name="' + element.slug + '" data-template_type="woodmart_templates"  data-template_title="' + element.title + '" data-vc-content=".vc_ui-template-content">';
			html += '<div class="xts-import-item-image woodmart-template-image">';
			html += '<img src="' + element.image + '" title="' + element.title + '" alt="' + element.title + '" />';
			html += '<div class="woodmart-template-actions">';
			html += '<a class="woodmart-template-preview xts-btn xts-color-white xts-import-item-preview xts-i-view" label="Preview this template" title="Preview this template" href="' + element.link + '" target="_blank">Preview</a>';
			html += '</div>';
			html += '</div>';
			html += '<div class="xts-import-item-footer">';
			html += '<span class="xts-import-item-title woodmart-template-title">' + element.title + '</span>';
			html += '<a class="woodmart-template-add xts-bordered-btn xts-color-primary xts-i-import" label="Add this template" title="Add this template" data-template-handler="">Add template</a>';
			// html += '<div class="woodmart-template-preview"><a href="' + element.link + '" target="_blank">preview</a></div>';
			// html += '<div class="vc_ui-template-content" data-js-content>';
			// html += '</div>';
			html += '</div>';
			html += '</div>';

			return html;
		}

	}

	jQuery(document).ready(function() {
		vcTemplatesLibrary();
	});
})(jQuery);