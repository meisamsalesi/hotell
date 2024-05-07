(function($) {
	$.each([
		'frontend/element_ready/wd_single_product_stock_status.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.stockStatus();
		});
	});

	woodmartThemeModule.stockStatus = function() {
		$( '.variations_form' )
			.on('show_variation', '.woocommerce-variation',function( event, variation ) {
				$('.wd-single-stock-status').each(function() {
					let $wrapper = $(this);

					if ( 0 !== $wrapper.find('.elementor-widget-container').length ) {
						$wrapper = $wrapper.find('.elementor-widget-container');
					}

					if ( variation.hasOwnProperty( 'availability_html' ) ) {
						$wrapper.html( variation.availability_html );
					}
				});
			})
			.on('click', '.reset_variations', function() {
				$('.wd-single-stock-status').each(function() {
					let $wrapper = $(this);

					if ( 0 !== $wrapper.find('.elementor-widget-container').length ) {
						$wrapper = $wrapper.find('.elementor-widget-container');
					}

					$wrapper.html('');
				});
			});
	};

	$(document).ready(function() {
		woodmartThemeModule.stockStatus();
	});
})(jQuery);
