/**
 * Update current position for Geolocations
 */

// Settings
var delay = 10000; // refresh rate in ms

var updatePosition = setInterval(function(){
	refresh();
}, delay);

function refresh() {
	console.log();
	if (typeof(connected) !== "undefined"&&connected) {
		navigator.geolocation.getCurrentPosition(getPosition, noPosition);
	}
}

function getPosition(position) {
	var latitude = position.coords.latitude;
	var longitude = position.coords.longitude;
	var msg = {
		name: name,
		type: 'location',
		latitude: latitude,
		longitude: longitude
	}
	msg = JSON.stringify(msg);
	console.log("--> " + msg);
	socket.send(msg);
}

function noPosition() {
	//console.log("Your position could not be located.");
}