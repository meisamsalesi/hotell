/* global xts_settings */
(function($) {
	woodmartThemeModule.menuOverlay = function() {
		var hoverSelector = '.wd-header-nav.wd-with-overlay .item-level-0.menu-item-has-children.wd-event-hover, .wd-header-cats.wd-with-overlay .item-level-0.menu-item-has-children.wd-event-hover, .wd-sticky-nav:not(.wd-opened), .wd-header-cats.wd-with-overlay.wd-event-hover, .wd-header-my-account.wd-with-overlay, .wd-header-cart.wd-with-overlay, .wd-header-search.wd-display-dropdown.wd-with-overlay';
		var sideClasses;

		woodmartThemeModule.$document.on('mouseleave', hoverSelector, function() {
			if ( $(this).parents('.wd-header-cats.wd-with-overlay.wd-event-click.wd-opened').length ) {
				return;
			}

			$('.wd-close-side').attr('class', sideClasses);
		});

		woodmartThemeModule.$document.on('mouseenter mousemove', hoverSelector, function() {
			var $this = $(this);
			var $overlay = $('.wd-close-side');

			if ($overlay.hasClass('wd-close-side-opened') || $('html').hasClass('platform-iOS')) {
				return;
			}

			var isInHeader = $this.parents('.whb-header').length;
			var isInCloneHeader = $this.parents('.whb-clone').length;
			var isInCategories = $this.hasClass('wd-sticky-nav');
			var isInHeaderCategories = $this.parents('.wd-header-cats').length;
			sideClasses = $overlay.attr('class');

			if (isInHeader) {
				if ($this.parents('.whb-sticked').length) {
					$overlay.addClass('wd-location-header-sticky');
				} else {
					$overlay.addClass('wd-location-header');
				}
				if (isInHeaderCategories) {
					$overlay.addClass('wd-location-header-cats');
				}
			} else if (isInCloneHeader) {
				$overlay.addClass('wd-location-header-sticky');
			} else if (isInCategories) {
				$overlay.addClass('wd-location-sticky-nav');
			}

			$overlay.addClass('wd-close-side-opened');
		});

		woodmartThemeModule.$document.on('click', '.wd-header-nav.wd-with-overlay .item-level-0.menu-item-has-children.wd-event-click, .wd-header-cats.wd-with-overlay .item-level-0.menu-item-has-children.wd-event-click, .wd-header-cats.wd-with-overlay.wd-event-click', function() {
			var $side = $('.wd-close-side');
			var $item = $(this);

			if ( $item.hasClass('wd-opened') && $side.hasClass('wd-close-side-opened') ) {
				return;
			}

			if ( $item.parents('.wd-header-cats.wd-with-overlay.wd-event-click.wd-opened').length || $item.parents('.wd-header-cats.wd-with-overlay.wd-event-hover').length ) {
				return;
			}

			$side.toggleClass('wd-close-side-opened').toggleClass('wd-location-header');
		});

		woodmartThemeModule.$document.on('click touchstart', '.wd-close-side.wd-location-header', function() {
			$(this).removeClass('wd-location-header');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.menuOverlay();
	});
})(jQuery);