(function($) {
	'use strict';

	$(document).on('mouseenter', '.xts-popup .xts-hint', function () {
		var $wrapper = $(this);
		var offset = $wrapper.offset();
		var top = offset.top - $(window).scrollTop();
		var content = '';

		if ( ! $wrapper.hasClass( 'xts-loaded' ) ) {
			var $attachment = $wrapper.find('img');

			if ( ! $attachment.length ) {
				$attachment = $wrapper.find('video');
			}

			if ( ! $attachment.length || $wrapper.hasClass('xts-loaded')) {
				return;
			}

			$wrapper.addClass('xts-loaded xts-loading');

			$attachment.each( function () {
				var $this = $(this);

				if ( $this.attr('src') ) {
					return;
				}

				$this.attr('src', $this.data('src') );
			});

			$attachment.on('load play', function () {
				$wrapper.removeClass('xts-loading');
			});
		}

		if ( 350 >= top ) {
			$wrapper.find('.xts-tooltip').removeClass('xts-top').addClass('xts-bottom')
			content = $wrapper.html();
			$wrapper.find('.xts-tooltip').removeClass('xts-bottom').addClass('xts-top')
		} else {
			content = $wrapper.html();
		}

		$wrapper.find('.xts-tooltip').addClass('xts-hidden');

		setTimeout( function () {
			$('body').append(`
				<div class="xts-hint-wrapper" style="top: ${top}px; left: ${offset.left}px">
					${content}
				</div>
			`);
		}, 100);
	});

	$(document).on('mouseleave', '.xts-hint', function () {
		$('.xts-hint-wrapper').remove();

		$(this).find('.xts-tooltip').removeClass('xts-hidden');
	});
})(jQuery);