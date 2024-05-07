/* global woodmart_settings */
(function($) {
	woodmartThemeModule.singleProdReviews = function() {
		let $reviewsTab = $('#reviews');

		function getSelectedStars() {
			let $activeStarRating = $('.wd-rating-summary-cont').find('.wd-active');

			if ( $activeStarRating.length > 0 ) {
				return $activeStarRating.find('.wd-rating-label').data('rating').toString();
			}

			return '';
		}

		function reloadReviewsWithAjax( clear = false, loaderForSummaryWrap = false ) {
			let $commentList  = $('.commentlist');
			let attr          = $commentList.length > 0 ? $commentList.data('reviews-columns') : {};
			let animationTime = 50;
			let data          = {
				action      : 'woodmart_filter_review',
				rating      : getSelectedStars(),
				product_id  : $reviewsTab.data('product-id'),
				order_by    : 0 < $reviewsTab.find(".wd-reviews-sorting-select :checked").length ? $reviewsTab.find(".wd-reviews-sorting-select :checked").val() : 'newest',
				only_images :$('#wd-with-image-checkbox').is(":checked"),
				summary_criteria_ids: woodmart_settings.summary_criteria_ids,
			}

			if ( attr.hasOwnProperty('reviews_columns') ) {
				data.reviews_columns = attr.reviews_columns;
			}

			if ( attr.hasOwnProperty('reviews_columns_tablet') ) {
				data.reviews_columns_tablet = attr.reviews_columns_tablet;
			}

			if ( attr.hasOwnProperty('reviews_columns_mobile') ) {
				data.reviews_columns_mobile = attr.reviews_columns_mobile;
			}

			if ( clear ) {
				data['rating']      = '';
				data['only_images'] = false;
			}

			$.ajax({
				url    : woodmart_settings.ajaxurl,
				method : 'GET',
				data,
				beforeSend: function() {
					let $commentList = $reviewsTab.find('#comments .commentlist');

					$reviewsTab.find('#comments .wd-loader-overlay').addClass('wd-loading');

					if ( loaderForSummaryWrap ) {
						$reviewsTab.find('.wd-rating-summary-wrap .wd-loader-overlay').addClass('wd-loading');
					}

					$commentList.removeClass('wd-active');
					$commentList.removeClass('wd-in');
				},
				complete: function() {
					$reviewsTab.find('#comments .wd-loader-overlay').removeClass('wd-loading');

					if ( loaderForSummaryWrap ) {
						$reviewsTab.find('.wd-rating-summary-wrap .wd-loader-overlay').removeClass('wd-loading');
					}

					setTimeout(function() {
						$reviewsTab.find('#comments .commentlist').addClass('wd-active');
					}, animationTime);

					setTimeout(function() {
						$reviewsTab.find('#comments .commentlist').addClass('wd-in');
					}, animationTime * 2);
				},
				success: function( response ) {
					if ( ! data.rating ?? ! data.only_images ) {
						$('.wd-reviews-sorting-clear').addClass('wd-hide');
					}

					if ( response.title ) {
						$reviewsTab
							.find('.woocommerce-Reviews-title')
							.html( response.title );
					}

					$(document).trigger('woodmart_reviews_sorting_clear', data );

					if ( response.content ) {
						$reviewsTab
							.find('#comments .wd-reviews-content')
							.html( response.content );
					}

					if ( woodmartThemeModule.hasOwnProperty( 'photoswipeImages' ) && 'function' === typeof woodmartThemeModule.photoswipeImages ) {
						woodmartThemeModule.photoswipeImages();
					}
				},
				error: function( request ) {
					console.error( request );
				}
			});
		}

		$reviewsTab
			.on( 'click', '.wd-rating-summary-item',function () {
				if ( ! woodmart_settings.is_rating_summary_filter_enabled || $(this).hasClass( 'wd-empty' ) ) {
					return;
				}

				$(this).siblings().removeClass('wd-active');
				$(this).toggleClass('wd-active');

				let selectedStars = getSelectedStars();

				$(document).on('woodmart_reviews_sorting_clear', function( e, data ) {
					if ( selectedStars ) {
						$('.wd-reviews-sorting-clear').removeClass('wd-hide');
					} else {
						$('.wd-reviews-sorting-clear').addClass('wd-hide');
					}
				});

				reloadReviewsWithAjax( false, true );
			})
			.on( 'click', '.wd-reviews-sorting-clear', function(e) {
				e.preventDefault();

				$('.wd-rating-summary-item').each(function (){
					$(this).removeClass('wd-active');
				});

				$(document).on('woodmart_reviews_sorting_clear', function( e, data ) {
					$('.wd-reviews-sorting-clear').addClass('wd-hide');
				});

				$('#wd-with-image-checkbox').prop( "checked", false );

				reloadReviewsWithAjax( true, true );
			})
			.on( 'click', '#wd-with-image-checkbox', function() {
				let checked = $(this).is(":checked");

				$(document).on('woodmart_reviews_sorting_clear', function( e, data ) {
					if ( checked ) {
						$('.wd-reviews-sorting-clear').removeClass('wd-hide');
					} else if ( 0 === data.rating.length ) {
						$('.wd-reviews-sorting-clear').addClass('wd-hide');
					}
				});

				reloadReviewsWithAjax();
			})
			.on( 'change', '.wd-reviews-sorting-select', function() {
				reloadReviewsWithAjax();
			});
	};

	$(document).ready(function() {
		woodmartThemeModule.singleProdReviews();
	});
})(jQuery);
