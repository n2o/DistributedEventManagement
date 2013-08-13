var map;
var markersArray =	[];
var autoupdate = true;
var bounds;

function addMarker(coords, title, icon, animation) {
	marker = new google.maps.Marker({
		position: coords,
		map: map,
		title: title,
		icon: icon,
		animation: animation
	});
	marker.info = new google.maps.InfoWindow({
		content: title
	});
	markersArray.push(marker);
}

// Removes the overlays from the map, but keeps them in the array
function clearOverlays() {
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(null);
		}
	}
}

// Shows any overlays currently in the array
function showOverlays() {
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(map);
		}
	}
}

// Deletes all markers in the array by removing references to them
function deleteOverlays() {
	if (markersArray) {
		for (i in markersArray) {
			markersArray[i].setMap(null);
		}
		markersArray.length = 0;
	}
}

// Delete old references and update all markers based upon the data from WebSocket server
function updateMarkers(locations) {
	var coords;
	var icon;
	if (autoupdate)
		var bounds = new google.maps.LatLngBounds();

	delete locations.type;
	deleteOverlays();
	
	for (entry in locations) {
		if (entry == name)
			icon = "//maps.gstatic.com/mapfiles/ms2/micons/green-dot.png";
		coords = new google.maps.LatLng(locations[entry].latitude, locations[entry].longitude);
		if (autoupdate)
			bounds.extend(coords);
		
		addMarker(coords, entry, icon, "");
		icon = "";
	}

	// If the markers are first called, auto center and auto zoom to all markers
	if (autoupdate) {
		map.fitBounds(bounds);
		map.panToBounds(bounds);
		// autoupdate = false;
	}

	showOverlays();
}

function calcDistance(myLat, myLong, otherLat, otherLong) {
	radius = 6371; 	// radius of earth in km

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
};