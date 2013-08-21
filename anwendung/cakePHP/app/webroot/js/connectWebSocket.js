/**
 * Client application to connect to a remote WebSocket server
 */
var socket;

var wsUri, socket;
var connected = false;

$('.connectionState').text("Not connected");
doConnect();

function refresh() {
	// Reconnect on disconnect
	if (!connected) {
		doConnect();
	} else {
		publishChanges();
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
		$('.connectionState').text("Not connected");
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

// Look up all events, which has not been sent, and send it to the ws server
function publishChanges() {
	if (publishEventsArray.length > 0) {
		var msg = {
			type: 'publishEvent',
			id: publishEventsArray
		}
		msg = JSON.stringify(msg);
		//console.log("--> " + msg);
		socket.send(msg);
		publishEventsArray.length = 0;
	}
}

/**
 * Called automatically to authenticate with the server
 */
function synSocketID() {
	var msg = {
		name: name,
		type: 'syn',
		subscribe: {
			events: subEventsArray,
		}
	}
	msg = JSON.stringify(msg);
	//console.log("--> " + msg);
	socket.send(msg);
	publishChanges();
}

window.addEventListener("load", refresh, false);