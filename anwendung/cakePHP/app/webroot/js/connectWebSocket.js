/**
 * Client application to connect to a remote WebSocket server
 */
var socket;

var wsUri, socket;
var connected = false;
var sentProcess = false;

doConnect();

function refresh() {
	// Reconnect on disconnect
	if (!connected) {
		doConnect();
	}
}

function doConnect() {
	try {
		socket = io.connect('http://'+host+':'+port+'/');
		socket.on('connect', function (evt) {
			onOpen(evt);
			synSocketID();
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
	if (!sentProcess) {
		sentProcess = true;
		navigator.geolocation.getCurrentPosition(getPosition, noPosition);
		sentProcess = false;
	}
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
	console.log('<-- ' + evt);
	noty({text: 'Incoming WebSocket.'});
	// Update the marks on the map
	var data = JSON.parse(evt)
	switch(data.type) {
		case 'location':
			updateMarkers(data);

			break;
	}
}

function onError(evt) {
	console.log('ERROR: '+evt.data);
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

function includeSocketIO() {
	var head= document.getElementsByTagName('head')[0];
	var script= document.createElement('script');
	script.type= 'text/javascript';
	script.src= 'http://'+host+':'+port+'/socket.io/socket.io.js';
	head.appendChild(script);
}

/**
 * Called automatically to authenticate with the server
 */
function synSocketID() {
	var msg = {
		name: name,
		type: 'syn'
	}
	msg = JSON.stringify(msg);
	console.log("--> " + msg);
	socket.send(msg);
}

window.addEventListener("load", refresh, false);