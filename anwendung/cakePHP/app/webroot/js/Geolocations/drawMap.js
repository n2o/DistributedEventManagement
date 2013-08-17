/**
 * Initialize frame for Google Map, draw map, add markers and show overlays
 */

$(function() {
	function drawMap(position) {
		initializeFrame();
		var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		latitude = position.coords.latitude;
		longitude = position.coords.longitude;

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

		var infoWindow = new google.maps.InfoWindow({
			content: "You are here!"
		});

		google.maps.event.addListener(marker, 'click', function() {
			infoWindow.open(map, marker);
		});

		showOverlays();
	}

	navigator.geolocation.getCurrentPosition(drawMap, noPosition);

	function noPosition() {
		initializeFrame();
		var coords = new google.maps.LatLng(51.1793042, 7.193936);

		var options = {
			zoom: 15,
			center: coords,
			navigationControlOptions: {
				style: google.maps.NavigationControlStyle.SMALL
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map($('#map')[0], options);

		showOverlays();
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