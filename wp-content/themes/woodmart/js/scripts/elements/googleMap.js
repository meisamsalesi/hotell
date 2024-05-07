/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_google_map.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.googleMapInit();
		});
	});

	woodmartThemeModule.googleMapInit = function() {
		$('.google-map-container').each(function() {
			var $map = $(this);
			var data = $map.data('map-args');

			var config = {
				controls_on_map: false,
				map_div        : '#' + data.selector,
				start          : 1,
				map_options    : {
					zoom       : parseInt(data.zoom),
					scrollwheel: 'yes' === data.mouse_zoom
				}
			};

			if ( 'yes' === data.multiple_markers ) {
				config.locations = data.markers.map( marker => {
					var location = {
						lat      : marker.marker_lat,
						lon      : marker.marker_lon,
						image    : marker.marker_icon ? marker.marker_icon : data.marker_icon,
						image_w  : 40,
						image_h  : 40,
						animation: google.maps.Animation.DROP,
					}

					if ( marker.marker_icon_size ) {
						location.image_w = marker.marker_icon_size[0];
						location.image_h = marker.marker_icon_size[1];
					} else if ( data.marker_icon_size ) {
						location.image_w = data.marker_icon_size[0];
						location.image_h = data.marker_icon_size[1];
					}

					if ( marker.marker_title || marker.marker_description ) {
						location.html = `<h3 style="min-width:300px; text-align:center; margin:15px;">${marker.marker_title}</h3>${marker.marker_description}`;
					}

					return location;
				});

				if ( data.hasOwnProperty('center') ) {
					config.start = 0;
					config.map_options.set_center = data.center.split(',').map( function ( el ) {
						return parseFloat( el );
					});
				}
			} else {
				config.locations = [
					{
						lat      : data.latitude,
						lon      : data.longitude,
						image    : data.marker_icon,
						image_w  : data.marker_icon_size && data.marker_icon_size[0] ? data.marker_icon_size[0] : 40,
						image_h  : data.marker_icon_size && data.marker_icon_size[1] ? data.marker_icon_size[1] : 40,
						animation: google.maps.Animation.DROP
					}
				];

				if ('yes' === data.marker_text_needed) {
					config.locations[0].html = data.marker_text;
				}
			}

			if (data.json_style && !data.elementor) {
				config.styles = {};
				config.styles[woodmart_settings.google_map_style_text] = JSON.parse(data.json_style);
			} else if (data.json_style && data.elementor) {
				config.styles = {};
				config.styles[woodmart_settings.google_map_style_text] = JSON.parse(atob(data.json_style));
			}

			if ('button' === data.init_type) {
				$map.find('.wd-init-map').on('click', function(e) {
					e.preventDefault();

					if ($map.hasClass('wd-map-inited')) {
						return;
					}

					$map.addClass('wd-map-inited');
					new Maplace(config).Load();
				});
			} else if ('scroll' === data.init_type) {
				woodmartThemeModule.$window.on('scroll', function() {
					if (window.innerHeight + woodmartThemeModule.$window.scrollTop() + parseInt(data.init_offset) > $map.offset().top) {
						if ($map.hasClass('wd-map-inited')) {
							return;
						}

						$map.addClass('wd-map-inited');
						new Maplace(config).Load();
					}
				});
			} else if ('interaction' === data.init_type) {
				woodmartThemeModule.$window.on('wdEventStarted', function() {
					if ($map.hasClass('wd-map-inited')) {
						return;
					}

					$map.addClass('wd-map-inited');
					new Maplace(config).Load();
				});
			} else {
				new Maplace(config).Load();
			}
		});

		var $gmap = $('.google-map-container-with-content');

		woodmartThemeModule.$window.on('resize', function() {
			$gmap.css({
				'height': $gmap.find('.wd-google-map.with-content').outerHeight()
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.googleMapInit();
	});
})(jQuery);
