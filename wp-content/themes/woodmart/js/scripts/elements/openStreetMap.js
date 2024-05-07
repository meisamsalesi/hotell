/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_open_street_map.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.wdOpenStreetMap();
		});
	});

	woodmartThemeModule.wdOpenStreetMap = function () {
		if ( 'undefined' === typeof leaflet ) {
			return;
		}

		/**
		 * Helper to add markers to our map.
		 *
		 * @param map map instance.
		 * @param markers list of markers.
		 */
		const buildMarkers = function ( map, markers ) {
			$.each(markers, function () {
				let $thisMarker   = this.marker;
				let markerOptions = $thisMarker.hasOwnProperty('markerOptions') ? $thisMarker.markerOptions : {};
				let marker        = L.marker( [this.lat, this.lng], markerOptions );

				// add marker to map
				marker.addTo(map);

				// prep tooltip content
				let tooltipContent = '<div class="marker-tooltip">';

				// add marker title
				if (this.marker.marker_title) {
					tooltipContent += `<div class="marker-title"><h5 class="title">${this.marker.marker_title}</h5></div>`;
				}

				// marker content
				tooltipContent += '<div class="marker-content">';

				// add marker description
				if (this.marker.marker_description) {
					tooltipContent += `<div class="marker-description">${this.marker.marker_description}</div>`;
				}

				// add marker button
				if (this.marker.show_button === 'yes' && this.marker.button_text) {
					let button_url_target = this.marker.hasOwnProperty('button_url_target') && this.marker.button_url_target ? this.marker.button_url_target : '_blank';
					tooltipContent += `<div class="marker-button">
                                                <a class="btn btn-color-primary btn-style-link" target="${button_url_target}" href='${this.marker.button_url}' role="button">
                                                   ${this.marker.button_text}
                                                </a>
                                            </div>`;
				}

				tooltipContent += '</div>';
				tooltipContent += '</div>';

				// Add tooltip / popup to marker.
				if (this.marker.marker_title || this.marker.marker_description || this.marker.button_text && this.marker.show_button) {
					let markerBehavior = this.marker.hasOwnProperty('marker_behavior') ? this.marker.marker_behavior : null;
					switch (markerBehavior) {
						case 'popup':
							marker.bindPopup(tooltipContent);
							break;

						case 'static_close_on':
							marker.bindPopup(tooltipContent,{closeOnClick: false, autoClose: false, closeOnEscapeKey: false}).openPopup();
							break;

						case 'static_close_off':
							marker.bindPopup(tooltipContent,{closeOnClick: false, autoClose: false, closeButton: false, closeOnEscapeKey: false}).openPopup();
							break;

						case 'tooltip':
							let tooltipOptions = {};

							marker.bindTooltip(tooltipContent, tooltipOptions);
							break;
					}
				}
			});

			setTimeout(function () {
				map.invalidateSize();
			}, 100);
		};

		/**
		 * Check whether we can render our map based on provided coordinates.
		 *
		 * @param markers list of markers.
		 */
		const canRenderMap = function ( markers ) {
			if ( ! markers ) {
				return false;
			}

			return markers.filter( function ( marker ) {
				return ! isNaN( marker.lat ) && ! isNaN( marker.lng )
			}).length > 0;
		}

		const mapInit = function ( $map, settings ) {
			let mapId         = $map.attr('id');
			let center        = settings.hasOwnProperty('center') ? settings.center : null;
			let markers       = settings.hasOwnProperty('markers') ? settings.markers : [];

			// Avoid recreating the html element.
			if ( undefined !== L.DomUtil.get( mapId ) && L.DomUtil.get( mapId ) ) {
				L.DomUtil.get(mapId)._leaflet_id = null;
			}

			const map = L.map( mapId, {
				scrollWheelZoom: settings.hasOwnProperty('scrollWheelZoom') && 'yes' === settings.scrollWheelZoom,
				zoomControl    : settings.hasOwnProperty('zoomControl') && 'yes' === settings.zoomControl,
				dragging       : settings.hasOwnProperty('dragging') && 'yes' === settings.dragging,
			});

			if ( center ) {
				map.setView( center.split(','), settings.zoom );
			}

			if ( ! settings.hasOwnProperty('geoapify_tile') || 'osm-carto' === settings.geoapify_tile || ( 'custom-tile' === settings.geoapify_tile && ( ! settings.hasOwnProperty('geoapify_custom_tile') ||  0 === settings.geoapify_custom_tile.length ) ) ) {
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
					maxZoom: 18
				}).addTo(map);
			}else if ( 'stamen-toner' === settings.geoapify_tile ) {
				L.tileLayer('https://stamen-tiles.a.ssl.fastly.net/toner/{z}/{x}/{y}.png', {
					attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://www.openstreetmap.org/copyright">ODbL</a>.',
					maxZoom: 18
				}).addTo(map);
			}else if ( 'stamen-terrain' === settings.geoapify_tile ) {
				L.tileLayer('https://stamen-tiles.a.ssl.fastly.net/terrain/{z}/{x}/{y}.jpg', {
					attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://www.openstreetmap.org/copyright">ODbL</a>.',
					maxZoom: 18
				}).addTo(map);
			}else if ( 'stamen-watercolor' === settings.geoapify_tile ) {
				L.tileLayer('https://stamen-tiles.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.jpg', {
					attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://creativecommons.org/licenses/by-sa/3.0">CC BY SA</a>.',
					maxZoom: 18
				}).addTo(map);
			}else if ( 'custom-tile' === settings.geoapify_tile && settings.hasOwnProperty('geoapify_custom_tile') &&  0 !== settings.geoapify_custom_tile.length ) {
				let tileUrl = settings.geoapify_custom_tile;
				tileUrl     = tileUrl.replaceAll( '$', '' );

				L.tileLayer( tileUrl, {
					attribution: `<a href="${ settings.osm_custom_attribution_url ? settings.osm_custom_attribution_url : null }" target="_blank"> ${settings.osm_custom_attribution ? settings.osm_custom_attribution : null} </a> | © OpenStreetMap <a href="https://www.openstreetmap.org/copyright" target="_blank">contributors</a>`,
					maxZoom: 18
				}).addTo(map);
			}

			if ( ! canRenderMap( markers ) ) {
				let lat = 51.50735;
				let lng = -0.12776;

				markers.push({
					lat: lat,
					lng: lng,
					marker: {
						button_text: "",
						button_url: "",
						marker_coords: {
							lat,
							lng
						},
						marker_description: "",
						marker_title: "",
						show_button: "no"
					}
				});

				map.setView([lat, lng], settings.zoom);
			}

			$.each(markers, function () {
				let $thisMarker = this.marker;

				if ($thisMarker.hasOwnProperty('image') && $thisMarker.hasOwnProperty('image_size') && ( ( $thisMarker.image.hasOwnProperty('url') && $thisMarker.image.url.length > 0 ) || ( 'string' === typeof $thisMarker.image && $thisMarker.image.length > 0 ) ) ) {
					let iconUrl = null;

					if ( $thisMarker.image.hasOwnProperty('url') && $thisMarker.image.url.length > 0 ) {
						iconUrl = $thisMarker.image.url
					} else if ( 'string' === typeof $thisMarker.image && $thisMarker.image.length > 0 ) {
						iconUrl = $thisMarker.image
					}

					$thisMarker['markerOptions'] = {
						icon: L.icon({
							iconUrl,
							iconSize: $thisMarker.image_size,
						}),
					}
				} else {
					$thisMarker['markerOptions'] = {
						icon: L.icon({
							iconUrl: settings.hasOwnProperty('iconUrl') ? settings.iconUrl : null,
							iconSize: settings.hasOwnProperty('iconSize') ? settings.iconSize : [ 25, 41 ],
						}),
					}
				}
			});

			buildMarkers( map, markers );
		}

		$('.wd-osm-map-container').each(function() {
			let $mapContainer = $(this);
			let $map          = $mapContainer.find('.wd-osm-map-wrapper');
			let settings      = $map.data('settings');

			if ( ! settings ) {
				return;
			}

			if ( settings.hasOwnProperty( 'init_type' ) && 'button' === settings.init_type) {
				$mapContainer.find('.wd-init-map').on('click', function(e) {
					e.preventDefault();

					if ($mapContainer.hasClass( 'wd-map-inited')) {
						return;
					}

					$mapContainer.addClass('wd-map-inited');
					mapInit($map, settings);
				});
			} else if ( settings.hasOwnProperty( 'init_type' ) && 'scroll' === settings.init_type) {
				woodmartThemeModule.$window.on('scroll', function() {
					if ( settings.hasOwnProperty('init_offset') && window.innerHeight + woodmartThemeModule.$window.scrollTop() + parseInt(settings.init_offset) > $mapContainer.offset().top) {
						if ($mapContainer.hasClass('wd-map-inited')) {
							return;
						}

						$mapContainer.addClass('wd-map-inited');
						mapInit($map, settings);
					}
				});
			} else if ( settings.hasOwnProperty( 'init_type' ) && 'interaction' === settings.init_type) {
				woodmartThemeModule.$window.on('wdEventStarted', function() {
					if ($mapContainer.hasClass('wd-map-inited')) {
						return;
					}

					$mapContainer.addClass('wd-map-inited');
					mapInit($map, settings);
				});
			} else {
				mapInit($map, settings);
			}
		});
	}

	$(document).ready(function() {
		woodmartThemeModule.wdOpenStreetMap();
	});
})(jQuery);
