/**
 * Client application to connect to a remote WebSocket server.
 *
 * Prepares own position
 */

var wsUri, socket;
var connected = false;
var sentProcess = false;

// Settings
var port = 9999;
var host = "localhost";
var delay = 10000; // refresh rate in ms

if (name == null)
	var name = Math.random().toString().substr(2,5);

doConnect();
var timer = setInterval(function(){refresh()}, delay);

function refresh() {
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
			socket.on('disconnect', function (evt) { onDisconnect(evt) });
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
	if (!sentProcess) {
		sentProcess = true;
		navigator.geolocation.getCurrentPosition(getPosition, noPosition);
		sentProcess = false;
	}
}

function getPosition(position) {
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
	console.log("--> SENT: " + msg);
	socket.send(msg);
}

function noPosition() {
	console.log("Your position could not be located.");
}

function onOpen(evt) {
	console.log("Connected to WebSocket server.");
	connected = true;
	$('.connectionState').text("Connected");
	$('.connectionState').addClass('connected');
}

function onDisconnect(evt) {
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

function onMessage(evt) {
	console.log('<-- RESPONSE: ' + evt);
}

function onError(evt) {
	console.log('ERROR: '+evt.data);
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

//window.addEventListener("load", echoHandlePageLoad, false);