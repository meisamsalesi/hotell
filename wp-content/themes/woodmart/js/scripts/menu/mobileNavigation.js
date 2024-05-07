/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdCloseMobileMenu', function() {
		woodmartThemeModule.closeMobileNavigation();
	});

	woodmartThemeModule.mobileNavigation = function() {
		var body        = woodmartThemeModule.$body,
		    mobileNav   = $('.mobile-nav'),
		    dropDownCat = $('.mobile-nav .wd-nav-mobile .menu-item-has-children'),
		    elementIcon = '<span class="wd-nav-opener"></span>';

		var closeSide = $('.wd-close-side');

		dropDownCat.append(elementIcon);

		mobileNav.on('click', '.wd-nav-opener', function(e) {
			e.preventDefault();
			var $this = $(this);
			var $parent = $this.parent();

			if ($parent.hasClass('opener-page')) {
				$parent.removeClass('opener-page').find('> ul').slideUp(200);
				$parent.removeClass('opener-page').find('.wd-dropdown-menu .container > ul, .wd-dropdown-menu > ul').slideUp(200);
				$parent.find('> .wd-nav-opener').removeClass('wd-active');
			} else {
				$parent.addClass('opener-page').find('> ul').slideDown(200);
				$parent.addClass('opener-page').find('.wd-dropdown-menu .container > ul, .wd-dropdown-menu > ul').slideDown(200);
				$parent.find('> .wd-nav-opener').addClass('wd-active');
			}

			woodmartThemeModule.$document.trigger('wood-images-loaded');
		});

		mobileNav.on('click', '.wd-nav-mob-tab li', function(e) {
			e.preventDefault();
			var $this = $(this);
			var menuName = $this.data('menu');

			if ($this.hasClass('wd-active')) {
				return;
			}

			$this.parent().find('.wd-active').removeClass('wd-active');
			$this.addClass('wd-active');
			$('.wd-nav-mobile').removeClass('wd-active');
			$('.mobile-' + menuName + '-menu').addClass('wd-active');

			woodmartThemeModule.$document.trigger('wood-images-loaded');
		});

		body.on('click', '.wd-header-mobile-nav > a', function(e) {
			e.preventDefault();

			if (mobileNav.hasClass('wd-opened')) {
				woodmartThemeModule.closeMobileNavigation();
			} else {
				$(this).parent().addClass('wd-opened');
				openMenu();
			}
		});

		body.on('click touchstart', '.wd-close-side', function(e) {
			e.preventDefault();

			woodmartThemeModule.closeMobileNavigation();
		});

		body.on('click', '.mobile-nav .login-side-opener, .mobile-nav .close-side-widget', function(e) {
			e.preventDefault();

			woodmartThemeModule.closeMobileNavigation();
		});

		function openMenu() {
			mobileNav.addClass('wd-opened');
			closeSide.addClass('wd-close-side-opened');
			woodmartThemeModule.$document.trigger('wood-images-loaded');
		}
	};

	woodmartThemeModule.closeMobileNavigation = function() {
		$('.wd-header-mobile-nav').removeClass('wd-opened');
		$('.mobile-nav').removeClass('wd-opened');
		$('.wd-close-side').removeClass('wd-close-side-opened');
		$('.mobile-nav .searchform input[type=text]').blur();
	};

	$(document).ready(function() {
		woodmartThemeModule.mobileNavigation();
	});
})(jQuery);
