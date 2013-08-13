/**
 * Initialize frame for Google Map, draw map, add markers and show overlays
 */

$(function() {
	function drawMap(position) {
		initializeFrame();

		var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

		var options = {
			zoom: 15,
			center: coords,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map($('#map')[0], options);

		addMarker(coords, "You are here!", "//maps.gstatic.com/mapfiles/ms2/micons/green-dot.png", "google.maps.Animation.DROP");

		showOverlays();

		google.maps.event.addListener(marker, 'click', function() {
			marker.info.open(map, marker);
		});
	}

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(drawMap);
	} else {
		error('Geo Location is not supported');
	}

	function initializeFrame() {
		if (mobile) {
			// Display the map on top
			$('#map').addClass('active');

			// Switch between distances and map
			$('.switchInfo').on('click',function() {
				$('section').toggleClass('active');
			});
		} else {
			var mapcanvas = document.getElementById('map');
			mapcanvas.id = 'map';
			mapcanvas.style.height = '600px';
			mapcanvas.style.width = '100%';
		}
	}
});