/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function() {
		woodmartThemeModule.searchByFilters();
	});

	woodmartThemeModule.searchByFilters = function() {
		$('.wd-filter-search input').on('keyup', function() {
			var $this = $(this);
			var val = $this.val().toLowerCase();

			if (0 < val.length) {
				$this.parent().addClass('wd-active');
			} else {
				$this.parent().removeClass('wd-active');
			}

			$this.parents('.wd-filter-wrapper').find('.wd-filter-list li').each(function() {
				var $this = $(this);
				var $data = $this.find('.wd-filter-lable').text().toLowerCase();

				if ($data.indexOf(val) > -1) {
					$this.show();
				} else {
					$this.hide();
				}
			});
		});

		$('.wd-filter-search-clear a').on('click', function (e) {
			e.preventDefault();

			var $this = $(this);

			$this.parents('.wd-filter-search').removeClass('wd-active');

			$this.parent().siblings('input').val('');

			$this.parents('.wd-filter-wrapper').find('.wd-filter-list li').each(function() {
				$(this).show();
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.searchByFilters();
	});
})(jQuery);
