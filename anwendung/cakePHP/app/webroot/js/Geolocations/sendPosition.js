/**
 * Client application to connect to a remote WebSocket server.
 *
 * Prepares own position
 */

var wsUri, socket;
var connected = false;

// Settings
var port = 9999;
var host = "localhost";
var delay = 10000; // refresh rate in ms

if (name == null)
	var name = Math.random().toString().substr(2,5);

console.log("Starting...");
doConnect();
var timer = setInterval(function(){refresh()}, delay);

function refresh() {
	console.log("Refreshing...");
	// Reconnect on disconnect
	if (!connected) {
		doConnect();
	} else {
		doSend();
	}
}

function doConnect() {
	try {
		socket = io.connect('http://'+host+':'+port+'/');
		socket.on('connect', function (evt) {
			onOpen(evt);
			socket.on('disconnect', function (evt) { onClose(evt) });
			socket.on('message', function (evt) { onMessage(evt) });
			socket.on('error', function (evt) { onError(evt) });
		});
	} catch (e) {
		console.log("Remote WebSocket server is currently not running.");
	}
}

function doDisconnect() {
	socket.close();
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

/**
 * Get current location, prepare JSON String and send it to WS server
 */
function doSend() {
	console.log("Sending...");
	navigator.geolocation.getCurrentPosition(getPosition, noPosition);
}

function getPosition(position) {
	console.log("...");
	var latitude = position.coords.latitude;
	var longitude = position.coords.longitude;
	var msg = {
		person: {
			name: name,
			latitude: latitude,
			longitude: longitude
		}
	}
	msg = JSON.stringify(msg);
	console.log("Sent: " + msg);
	socket.send(msg);
}

function noPosition() {
	console.log("Your position could not be located.");
}

function onOpen(evt) {
	console.log("Connected.");
	connected = true;
	$('.connectionState').text("Connected");
	$('.connectionState').addClass('connected');
}

function onClose(evt) {
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

function onMessage(evt) {
	console.log('RESPONSE: '+evt);
}

function onError(evt) {
	console.log('ERROR: '+evt.data);
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

//window.addEventListener("load", echoHandlePageLoad, false);