/* global woodmart_settings */
(function($) {
	woodmartThemeModule.menuOffsets = function() {
		var setOffset = function(li) {
			var $dropdown = li.find(' > .wd-dropdown-menu');
			var dropdownWidth = $dropdown.outerWidth();
			var dropdownOffset = $dropdown.offset();
			var toRight;
			var viewportWidth;
			var dropdownOffsetRight;

			$dropdown.attr('style', '');

			if (!dropdownWidth || !dropdownOffset) {
				return;
			}

			if ($dropdown.hasClass('wd-design-full-width') || $dropdown.hasClass('wd-design-aside')) {
				viewportWidth = woodmartThemeModule.$window.width();

				if (woodmartThemeModule.$body.hasClass('rtl')) {
					dropdownOffsetRight = viewportWidth - dropdownOffset.left - dropdownWidth;

					if (dropdownOffsetRight + dropdownWidth >= viewportWidth) {
						toRight = dropdownOffsetRight + dropdownWidth - viewportWidth;

						$dropdown.css({
							right: -toRight
						});
					}
				} else {
					if (dropdownOffset.left + dropdownWidth >= viewportWidth) {
						toRight = dropdownOffset.left + dropdownWidth - viewportWidth;

						$dropdown.css({
							left: -toRight
						});
					}
				}
			} else if ($dropdown.hasClass('wd-design-sized') || $dropdown.hasClass('wd-design-full-height')) {
				viewportWidth = woodmart_settings.site_width;

				if (woodmartThemeModule.$window.width() < viewportWidth || ! viewportWidth || li.parents('.whb-header').hasClass('whb-full-width')) {
					viewportWidth = woodmartThemeModule.$window.width();
				}

				dropdownOffsetRight = viewportWidth - dropdownOffset.left - dropdownWidth;

				var extraSpace = 15;
				var containerOffset = (woodmartThemeModule.$window.width() - viewportWidth) / 2;
				var dropdownOffsetLeft;
				var $stickyCat = $('.wd-sticky-nav');

				if (woodmartThemeModule.$body.hasClass('wd-sticky-nav-enabled') && $stickyCat.length) {
					extraSpace -= $stickyCat.width() / 2;
				}

				if (woodmartThemeModule.$body.hasClass('rtl')) {
					dropdownOffsetLeft = containerOffset + dropdownOffsetRight;

					if (dropdownOffsetLeft + dropdownWidth >= viewportWidth) {
						toRight = dropdownOffsetLeft + dropdownWidth - viewportWidth;

						$dropdown.css({
							right: -toRight - extraSpace
						});
					}
				} else {
					dropdownOffsetLeft = dropdownOffset.left - containerOffset;

					if (dropdownOffsetLeft + dropdownWidth >= viewportWidth) {
						toRight = dropdownOffsetLeft + dropdownWidth - viewportWidth;

						$dropdown.css({
							left: -toRight - extraSpace
						});
					}
				}
			}
		};

		$('.wd-header-main-nav ul.menu > li, .wd-header-secondary-nav ul.menu > li, .widget_nav_mega_menu ul.menu:not(.wd-nav-vertical) > li, .wd-header-main-nav .wd-dropdown.wd-design-aside ul > li').each(function() {
			var $menu = $(this);

			if ($menu.hasClass('menu-item')) {
				$menu = $(this).parent();
			}

			function recalc() {
				if ($menu.hasClass('wd-offsets-calculated') || $menu.parents('.wd-design-aside').length) {
					return;
				}

				$menu.find(' > .menu-item-has-children').each(function() {
					setOffset($(this));
				});

				woodmartThemeModule.$document.trigger('resize.vcRowBehaviour');

				$menu.addClass('wd-offsets-calculated');
			}

			$menu.on('mouseenter mousemove', function() {
				recalc()
			});

			woodmartThemeModule.$window.on('wdHeaderBuilderStickyChanged', recalc);

			if ('yes' === woodmart_settings.clear_menu_offsets_on_resize) {
				setTimeout(function() {
					woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
						$menu.removeClass('wd-offsets-calculated');
						$menu.find(' > .menu-item-has-children > .wd-dropdown-menu').attr('style', '');
					}, 300));
				}, 2000);
			}
		});
	};

	woodmartThemeModule.menuDropdownAside = function() {
		$('.wd-nav .wd-design-aside, .wd-header-cats.wd-open-dropdown .wd-nav').each( function () {
			var $links = $(this).find('.menu-item');

			if (!$links.length) {
				return;
			}

			var $firstLink = $links.first();

			if (!$firstLink.hasClass('menu-item-has-children')) {
				$firstLink.parents('.wd-sub-menu-wrapp').addClass('wd-empty-item');
			}

			$firstLink.addClass('wd-opened').find('.wd-dropdown').addClass('wd-opened');

			$links.on('mouseover', function () {
				var $this = $(this);
				var $wrap = $this.parents('.wd-sub-menu-wrapp');

				if ($this.hasClass('wd-opened')) {
					return;
				}

				if ( $this.hasClass('item-level-1') ) {
					if (!$this.hasClass('menu-item-has-children')) {
						$wrap.addClass('wd-empty-item');
					} else {
						$wrap.removeClass('wd-empty-item');
					}
				}

				$this.siblings().removeClass('wd-opened').find('.wd-dropdown').removeClass('wd-opened');
				$this.addClass('wd-opened').find('.wd-dropdown').addClass('wd-opened');
			});
		});
	}

	woodmartThemeModule.$window.on('wdEventStarted', function() {
		setTimeout(function () {
			woodmartThemeModule.menuDropdownAside();
			woodmartThemeModule.menuOffsets();
		}, 100);
	});
})(jQuery);
