/**
 * Client application to connect to a remote WebSocket server.
 *
 * Prepares 
 */

var wsUri, websocket;
var connected = false;

// Settings
var port = 9999;
var host = "192.168.178.59";
var delay = 10000;

if (name == null)
	var name = Math.random().toString().substr(2,5);

var wsUri = "ws://"+host+":"+port+"";

// Start
doConnect();
var timer = setInterval(function(){echoHandlePageLoad()}, delay);

function echoHandlePageLoad() {
	// Reconnect on disconnect
	if (!connected) {
		doConnect();
	} else {
		doSend();
	}
}

function doConnect() {
	websocket = new WebSocket(wsUri);
	websocket.onopen = function(evt) { onOpen(evt) };
	websocket.onclose = function(evt) { onClose(evt) };
	websocket.onmessage = function(evt) { onMessage(evt) };
	websocket.onerror = function(evt) { onError(evt) };
}

function doDisconnect() {
	websocket.close();
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

/**
 * Get current location, prepare JSON String and send it to WS server
 */
function doSend() {
	navigator.geolocation.getCurrentPosition(function(position) {
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
		websocket.send(msg);
	});
}

function onOpen(evt) {
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
	console.log('RESPONSE: '+evt.data);
}

function onError(evt) {
	console.log('ERROR: '+evt.data);
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

window.addEventListener("load", echoHandlePageLoad, false);