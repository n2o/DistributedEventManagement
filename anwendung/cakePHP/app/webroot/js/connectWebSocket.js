/**
 * Client application to connect to a remote WebSocket server
 */
var socket;

var wsUri, socket;
var connected = false;

doConnect();

function refresh() {
	// Reconnect on disconnect
	if (!connected) {
		doConnect();
	}
}

function doConnect() {
	try {
		socket = io.connect('wss://'+host+':'+port+'/');
		socket.on('connect', function (evt) {
			onOpen(evt);
			synSocketID();
			socket.on('disconnect', function (evt) { onDisconnect(evt) });
			socket.on('message', function (evt) { onMessage(evt) });
			socket.on('error', function (evt) { onError(evt) });
		});
	} catch (e) {
		$('.connectionState').text("Not connected");
		$('.connectionState').removeClass('connected');
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
	navigator.geolocation.getCurrentPosition(getPosition, noPosition);
}

function onOpen(evt) {
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
	// Update the marks on the map
	var data = JSON.parse(evt);
	switch(data.type) {
		case 'location':
			//noty({text: 'Incoming: New coordinates for geolocations.'});
			updateMarkers(data);
			break;
		case 'update':
			if (data.section == "events") {
				noty({text: 'Your event with id '+data.id+" has been updated!", type: 'information'});
			}
			break;
	}
}

function onError(evt) {
	console.log('ERROR: '+evt.data);
	connected = false;
	$('.connectionState').text("Not connected");
	$('.connectionState').removeClass('connected');
}

/**
 * Called automatically to authenticate with the server
 */
function synSocketID() {
	if (synMessage != null) {
		//console.log("--> " + msg);
		socket.send(synMessage);
	}
}

window.addEventListener("load", refresh, false);