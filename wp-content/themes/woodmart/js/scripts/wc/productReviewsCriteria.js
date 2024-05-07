/* global woodmart_settings */
(function($) {
	woodmartThemeModule.singleProdReviewsCriteria = function() {
		if ( ! woodmart_settings.is_criteria_enabled ) {
			return;
		}

		$('#reviews')
			.on('click', '.wd-review-criteria div.stars a', function ( e ) {
				e.preventDefault();

				let $star      = $( this );
				let criteriaId = $star.closest( '.comment-form-rating' ).data('criteria-id');
				let $rating    = $( `#${ criteriaId }` );
				let	$container = $star.closest( '.stars' );

				$rating.val( $star.text() );
				$star.siblings( 'a' ).removeClass( 'active' );
				$star.addClass( 'active' );
				$container.addClass( 'selected' );
			})
			.on('click', '#respond #submit', function() {
				if ( 'yes' === woodmart_settings.reviews_criteria_rating_required  ) {
					let showAlert           = false;
					let $commentFormRatings = $('#review_form').find('.wd-review-criteria');

					$commentFormRatings.each(function () {
						let $commentFormRating = $(this);
						let criteriaId         = $commentFormRating.data('criteria-id');
						let $rating            = $commentFormRatings.find(`#${ criteriaId }`);

						if ( ! $( $rating ).val() ) {
							showAlert = true;
						}
					});

					if ( showAlert ) {
						window.alert( wc_single_product_params.i18n_required_rating_text );

						return false;
					}
				}
			});
	};

	$(document).ready(function() {
		woodmartThemeModule.singleProdReviewsCriteria();
	});
})(jQuery);
