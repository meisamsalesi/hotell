/* global jQuery, woodmartConfig, woodmartAdmin */

(function($) {
	'use strict';

	function wizardInstallPlugins() {
		var checkPlugin = function($link, callback) {
			setTimeout(function() {
				$.ajax({
					url    : woodmartConfig.ajaxUrl,
					method : 'POST',
					data   : {
						action     : 'woodmart_check_plugins',
						xts_plugin : $link.data('plugin'),
						xts_builder: $link.data('builder'),
						security   : woodmartConfig.check_plugins_nonce
					},
					success: function(response) {
						if ('success' === response.status) {
							changeNextButtonStatus(response.data.required_plugins);
							changePageStatus(response.data.is_all_activated);
						} else {
							woodmartAdmin.addNotice($('.xts-plugin-response'), 'warning', response.message);
							removeLinkClasses($link);
							woodmartAdmin.hideNotice();
						}
						if (response.data.status === 'deactivate') {
							reloadPage($link);
						}
						callback(response);
					}
				});
			}, 1000);
		};

		var activatePlugin = function($link, callback) {
			$.ajax({
				url    : xtsPluginsData[$link.data('plugin')]['activate_url'].replaceAll('&amp;', '&'),
				method : 'GET',
				success: function() {
					checkPlugin($link, function(response) {
						if ('success' === response.status) {
							if ('activate' === response.data.status) {
								activatePlugin($link, callback);
							} else {
								removeLinkClasses($link);
								changeLinkAction('activate', 'deactivate', $link, response);
								changeLinkAction('install', 'deactivate', $link, response);
								changeLinkAction('update', 'deactivate', $link, response);
								callback();
							}
						}
					});
				}
			});
		};

		var deactivatePlugin = function($link) {
			$.ajax({
				url    : woodmartConfig.ajaxUrl,
				method : 'POST',
				data   : {
					action     : 'woodmart_deactivate_plugin',
					xts_plugin : $link.data('plugin'),
					xts_builder: $link.data('builder'),
					security   : woodmartConfig.deactivate_plugin_nonce
				},
				success: function(response) {
					if ('error' === response.status) {
						woodmartAdmin.addNotice($('.xts-plugin-response'), 'warning', response.message);
						removeLinkClasses($link);
						woodmartAdmin.hideNotice();
						return;
					}

					checkPlugin($link, function(response) {
						if ('success' === response.status) {
							if ('activate' === response.data.status) {
								removeLinkClasses($link);
								changeLinkAction('deactivate', 'activate', $link, response);
								reloadPage($link);
							} else {
								deactivatePlugin($link);
							}
						}
					});
				}
			});
		};

		function parsePlugins($link, callback) {
			$.ajax({
				url    : $link.attr('href'),
				method : 'POST',
				success: function() {
					setTimeout(function() {
						checkPlugin($link, function(response) {
							if ('success' === response.status) {
								if ('activate' === response.data.status) {
									activatePlugin($link, callback);
								} else {
									removeLinkClasses($link);
									changeLinkAction('activate', 'deactivate', $link, response);
									callback();
								}
							}
						});
					}, 1000);
				}
			});
		}

		function reloadPage($link) {
			if ($link.parents('.woodmart-compatible-plugins').length) {
				location.reload();
			}
		}

		function addLinkClasses($link) {
			$link.parents('.xts-plugin-wrapper').addClass('xts-loading');
			$link.parents('.xts-plugin-wrapper').siblings().addClass('xts-disabled');
			$('.xts-wizard-footer').addClass('xts-disabled');

			$link.text(woodmartConfig[$link.data('action') + '_process_plugin_btn_text']);
		}

		function removeLinkClasses($link) {
			$link.parents('.xts-plugin-wrapper').removeClass('xts-loading');
			$link.parents('.xts-plugin-wrapper').siblings().removeClass('xts-disabled');
			$('.xts-wizard-footer').removeClass('xts-disabled');
		}

		function changeNextButtonStatus(status) {
			var $nextBtn = $('.xts-next');
			if ('has_required' === status) {
				$nextBtn.addClass('xts-disabled');
			} else {
				$nextBtn.removeClass('xts-disabled');
			}
		}

		function changePageStatus(status) {
			var $page = $('.xts-plugins');
			if ('yes' === status) {
				$page.addClass('xts-all-active');
			} else {
				$page.removeClass('xts-all-active');
			}
		}

		function changeLinkAction(actionBefore, actionAfter, $link, response) {
			if (response && response.data.version) {
				$link.parents('.xts-plugin-wrapper').find('.xts-plugin-version span').text(response.data.version);
			}

			$link.removeClass('xts-' + actionBefore).addClass('xts-' + actionAfter);
			$link.attr('href', xtsPluginsData[$link.data('plugin')][actionAfter + '_url'].replaceAll('&amp;', '&'));
			$link.data('action', actionAfter);
			$link.text(woodmartConfig[actionAfter + '_plugin_btn_text']);
		}

		$(document).on('click', '.xts-ajax-plugin:not(.xts-deactivate)', function(e) {
			e.preventDefault();

			var $link = $(this);
			addLinkClasses($link);
			parsePlugins($link, function() {});
		});

		$(document).on('click', '.xts-ajax-plugin.xts-deactivate', function(e) {
			e.preventDefault();

			var $link = $(this);
			addLinkClasses($link);
			deactivatePlugin($link);
		});

		$(document).on('click', '.xts-wizard-all-plugins', function(e) {
			e.preventDefault();

			var itemQueue = [];

			function activationAction() {
				if (itemQueue.length) {
					var $link = $(itemQueue.shift());

					if ($link.parents('.woodmart-compatible-plugins').length) {
						return;
					}

					addLinkClasses($link);

					parsePlugins($link, function() {
						activationAction();
					});
				}
			}

			$('.xts-plugin-wrapper .xts-ajax-plugin:not(.xts-deactivate)').each(function() {
				itemQueue.push($(this));
			});

			activationAction();
		});
	}

	function wizardBuilderSelect() {
		$('.xts-wizard-builder-select > div').on('click', function() {
			var $this = $(this);
			var builder = $(this).data('builder');

			$this.addClass('xts-active');
			$this.siblings().removeClass('xts-active');
			$('.xts-btn.xts-' + builder).removeClass('xts-hidden').addClass('xts-shown').siblings('.xts-next').addClass('xts-hidden').removeClass('xts-shown');
		});
	}

	function wizardInstallChildTheme() {
		$('.xts-install-child-theme').on('click', function(e) {
			e.preventDefault();
			var $btn = $(this);
			var $responseSelector = $('.xts-child-theme-response');

			$btn.addClass('xts-loading');

			$.ajax({
				url     : woodmartConfig.ajaxUrl,
				method  : 'POST',
				data    : {
					action  : 'woodmart_install_child_theme',
					security: woodmartConfig.install_child_theme_nonce
				},
				dataType: 'json',
				success : function(response) {
					$btn.removeClass('xts-loading');

					if (response && 'success' === response.status) {
						$('.xts-wizard-child-theme').addClass('xts-installed');
					} else if (response && 'dir_not_exists' === response.status) {
						woodmartAdmin.addNotice($responseSelector, 'error', 'The directory can\'t be created on the server. Please, install the child theme manually or contact our support for help.');
					} else {
						woodmartAdmin.addNotice($responseSelector, 'error', 'The child theme can\'t be installed. Skip this step and install the child theme manually via Appearance -> Themes.');
					}
				},
				error   : function() {
					$btn.removeClass('xts-loading');

					woodmartAdmin.addNotice($responseSelector, 'error', 'The child theme can\'t be installed. Skip this step and install the child theme manually via Appearance -> Themes.');
				}
			});
		});
	}

	jQuery(document).ready(function() {
		wizardInstallPlugins();
		wizardBuilderSelect();
		wizardInstallChildTheme();
	});
})(jQuery);