/**
 * Initialize frame for Google Map, draw map, add markers and show overlays
 */

$(function() {

	var lastLatitude = 0;
	var lastLongitude = 0;
	var latitude = 0;
	var longitude = 0;
	var firstRun = true;
	geo_options = {
		enableHighAccuracy: true,
		timeout: 5000
	}

	// Checks if geolocation is enabled or disabled by browser
	navigator.geolocation.getCurrentPosition(drawMap, noPosition, {enableHighAccuracy:false});

	// Start watching on new updates of the clients location
	navigator.geolocation.watchPosition(checkDiff, noPosition, geo_options);

	/**
	 * Function to reduce unnecessary traffic by websockets
	 * Specifies when an update should be promoted
	 */
	function checkDiff(position) {
		var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		latitude = position.coords.latitude;
		longitude = position.coords.longitude;
		
		if (lastLatitude != latitude || lastLongitude != longitude)
			sendPosition();
		lastLatitude = latitude;
		lastLongitude = longitude;
	}

	/** 
	 * Initializes the map and draws it to the section/article with id #map.
	 * Marks own position on map with a green marker
	 */
	function drawMap(position) {
		//if (controller == "geolocations") {
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

			// Adds own position to an array of markers
			addMarker(coords, "You are here!", "//maps.gstatic.com/mapfiles/ms2/micons/green-dot.png", "google.maps.Animation.DROP");

			google.maps.event.addListener(marker, 'click', function() {
				infoWindow.open(map, marker);
			});

			showOverlays();
		//}
	}

	/**
	 * If the browser does not support geolocations, set the center of the map to Remscheid
	 */
	function noPosition() {
		if ("geolocation" in navigator) {
 			// ignore this, just needed to avoid a Firefox bug
		} else {
  			// Geolocation IS NOT available. Focus on Remscheid
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
	}

	/**
	 * Different schemes for mobile / desktop:
	 * mobile: initialize overlay for options
	 * desktop: has enough space to display it the whole time above the map
	 */
	function initializeFrame() {
		if (!mobile) {
			if (document.getElementById('map') != null) {
				var mapcanvas = document.getElementById('map');
				mapcanvas.id = 'map';
				mapcanvas.style.height = '600px';
				mapcanvas.style.width = '100%';
			}
		}
	}

	/**
	 * Calculate the distance in (kilo-)meters for two points
	 */
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

	/**
	 * Send current location to websocket server
	 */
	function sendPosition() {
		var msg = {
			name: name,
			type: 'location',
			latitude: latitude,
			longitude: longitude
		}
		msg = JSON.stringify(msg);
		if (typeof(socket) !== "undefined" && name !== "null") {
			socket.send(msg);
		}
	}
});