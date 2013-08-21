/**
 * Initialize frame for Google Map, draw map, add markers and show overlays
 */

$(function() {

	var lastLatitude = 0;
	var lastLongitude = 0;
	var firstRun = true;
	geo_options = {
		enableHighAccuracy: true,
		timeout: 5000
	}

	navigator.geolocation.getCurrentPosition(drawMap, noPosition, {enableHighAccuracy:false});
	navigator.geolocation.watchPosition(checkDiff, noPosition, geo_options);

	function checkDiff(position) {
		var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		latitude = position.coords.latitude;
		longitude = position.coords.longitude;

		if (firstRun) {
			lastLatitude = latitude;
			lastLongitude = longitude;
			sendPosition();
			firstRun = false;
		} else {
			var diff = calcDistance(latitude, longitude, lastLatitude, lastLongitude);

			// if (diff < 0) 
			// 	diff = diff*1000;
			// if (diff > 0 && typeof(connected) !== "undefined" && connected)
			// 	sendPosition();
			sendPosition();
		}
	}

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

	function calcDistance(myLat, myLong, otherLat, otherLong) {
		radius = 6371; 	// radius of earth in km

		lastLatitude = myLat;
		lastLongitude = myLong;

		// convert all latitudes and longitudes to degrees
		myLat = myLat * (Math.PI/180);
		myLong = myLong * (Math.PI/180);
		otherLat = otherLat * (Math.PI/180);
		otherLong = otherLong * (Math.PI/180);

		// convert latitude and longitude to x,y coords
		x0 = myLat * radius * Math.cos(myLat);
		y0 = myLong * radius;
		x1 = otherLat * radius * Math.cos(otherLat);
		y1 = otherLong * radius;

		dx = x0 - x1;
		dy = y0 - y1;

		// pythagorean theorem for the distance d between two points
		d = Math.sqrt((dx*dx) + (dy*dy));

		if (d < 1)
			return Math.round(d*1000)+" m";
		else
			return Math.round(d*10)/10+" km";
	}

	function sendPosition() {
		var msg = {
			name: name,
			type: 'location',
			latitude: lastLatitude,
			longitude: lastLongitude
		}
		msg = JSON.stringify(msg);
		//console.log("--> " + msg);
		socket.send(msg);
	}
});