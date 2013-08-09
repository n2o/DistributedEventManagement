var wsUri, websocket;
var connected = false;

// Settings
var port = 9999;
var host = "localhost";
var name = Math.random().toString().substr(2,2);
var delay = 10000;
var wsUri = "ws://"+host+":"+port+"";

// Start
doConnect();
var timer = setInterval(function(){echoHandlePageLoad()}, delay);

function echoHandlePageLoad() {
	// Reconnect on disconnect
	if (!connected) {
		doConnect();
	}
	doSend();
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
}

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
}

function onClose(evt) {
	connected = false;
}

function onMessage(evt) {
	console.log('RESPONSE: '+evt.data);
}

function onError(evt) {
	console.log('ERROR:'+evt.data);
	connected = false;
}

window.addEventListener("load", echoHandlePageLoad, false);