/* global woodmart_settings */
(function($) {
	woodmartThemeModule.checkoutQuantity = function() {
		var timeout;

		woodmartThemeModule.$document.on('change input', '.woocommerce-checkout-review-order-table .quantity .qty', function() {
			var input = $(this);
			var qtyVal = input.val();
			var itemName = input.attr('name');
			var itemID = itemName.substring(itemName.indexOf('[') + 1, itemName.indexOf(']') );
			var maxValue = input.attr('max');
			var cart_hash_key = woodmart_settings.cart_hash_key;
			var fragment_name = woodmart_settings.fragment_name;

			clearTimeout(timeout);

			if (parseInt(qtyVal) > parseInt(maxValue)) {
				qtyVal = maxValue;
			}

			timeout = setTimeout(function() {
				$.ajax({
					url     : woodmart_settings.ajaxurl,
					data    : {
						action : 'woodmart_update_cart_item',
						item_id: itemID,
						qty    : qtyVal
					},
					success : function( data ) {
						if (data && data.fragments) {
							$.each(data.fragments, function(key, value) {
								$(key).replaceWith(value);
							});

							if (woodmartThemeModule.supports_html5_storage) {
								sessionStorage.setItem(fragment_name, JSON.stringify(data.fragments));
								localStorage.setItem(cart_hash_key, data.cart_hash);
								sessionStorage.setItem(cart_hash_key, data.cart_hash);

								if (data.cart_hash) {
									sessionStorage.setItem('wc_cart_created', (new Date()).getTime());
								}
							}

							woodmartThemeModule.$body.trigger( 'wc_fragments_refreshed' );
						}

						$('form.checkout').trigger( 'update' );
					},
					dataType: 'json',
					method  : 'GET'
				});
			}, 500);
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.checkoutQuantity();
	});
})(jQuery);
