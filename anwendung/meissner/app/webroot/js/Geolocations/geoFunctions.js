var map, infoWindow, latitude, longitude, bounds;
var markersArray =	[];
var autoZoomCenter = true;

/**
 * Adds custom marker on the google map
 */
function addMarker(coords, title, icon, animation) {
	if (title == name)
		title = "You are here!";
	marker = new google.maps.Marker({
		position: coords,
		map: map,
		title: title,
		icon: icon,
		animation: animation
	});

	infoWindow = new google.maps.InfoWindow();

	infoWindow.setContent(title);
	infoWindow.open(map, marker);

	google.maps.event.addListener(marker, 'click', (function(marker) {
		return function() {
			infoWindow.setContent(title);
			infoWindow.open(map, marker);
		}
	})(marker));

	markersArray.push(marker);
}

/**
 * Removes the overlays from the map, but keeps them in the array
 */
function clearOverlays() {
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(null);
		}
	}
}

/**
 * Shows any overlays currently in the array
 */
function showOverlays() {
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(map);
		}
	}
}

/**
 * Deletes all markers in the array by removing references to them
 */
function deleteOverlays() {
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(null);
		}
		markersArray.length = 0;
	}
}

/**
 * Delete old references and update all markers based upon the data from WebSocket server
 */
function updateMarkers(locations) {
	var coords;
	var icon;
	if (autoZoomCenter)
		var bounds = new google.maps.LatLngBounds();

	delete locations.type;
	deleteOverlays();
	
	for (entry in locations) {
		if (entry == name) // mark own position with green marker
			icon = "//maps.gstatic.com/mapfiles/ms2/micons/green-dot.png";

		coords = new google.maps.LatLng(locations[entry].latitude, locations[entry].longitude);

		if (autoZoomCenter)
			bounds.extend(coords);
		
		addMarker(coords, entry, icon, "");
		icon = "";
	}

	// Autozoom to the center compared to all logged in clients
	if (autoZoomCenter && controller == "geolocations") {
		map.fitBounds(bounds);
		map.panToBounds(bounds); // Smoothly set center of map to bounds
	}

	showOverlays();
}

/**
 * Switch between auto zooming to interesting points or not
 */ 
function toggleAutoZoomCenter() {
	if (autoZoomCenter) {
		$('#autoZoomCenter').text("Enable autozoom");
		autoZoomCenter = false;
	} else {
		$('#autoZoomCenter').text("Disable autozoom");
		autoZoomCenter = true;
	}
}