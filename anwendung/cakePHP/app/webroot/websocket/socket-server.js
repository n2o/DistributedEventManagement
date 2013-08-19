/**
 * Script to start the socket.io WebSocket server
 *
 * Starts WebSocket server, which receives the current positions of all connected users,
 * creates one big JSON object and sends it back to the clients.
 * After idleTime delete those positions, which have not been updated for idleTime.
 *
 * Execute it with: $node socket-server.js
 *
 * var port: set the port the servers needs to listen to
 */

// Settings
var port = 9999;
var idleTime = 150; // Spec. after how many minutes a user is removed from the list

// Necessary, do not edit
var locations = {type: 'location'};	// store all geo information about persons
var clients = {};

var io = require('socket.io').listen(port);
io.set('log level', 2);

var killIdleTimer = setInterval(function() {killIdle()}, idleTime/3);

io.sockets.on('connection', function (socket) {
	socket.on('message', function (message) {
		var data = JSON.parse(message);
		switch(data.type) {
		case 'location':
			saveToLocations(data);
			socket.broadcast.send(JSON.stringify(locations));
			socket.send(JSON.stringify(locations)); //Send current location back to sender
			break;
		case 'syn':
			clients[data.name] = socket;
			clients[data.name].subscriptions = data.subscribe;
			clients[data.name].name = data.name;
			break;
		case 'publishEvent':
			lookForSubscriber(data, 'event', socket);
			break;
		}

		// console.log("Sending message to Admin...");
		// var sendTo = clients['Admin'];
		// sendTo.send("Bombe!");
	});
	socket.on('disconnect', function () { });
});

/**********************************************************************************
 * Area to prepare the data just received, merge it with the other geolocations
 * and return an updated json file with all information
 **********************************************************************************/
/**
 * Adds current person transmitted in data to array with all persons
 */
function saveToLocations(data) {
	addTimestamp(data);
	locations[data.name] = data;
	console.log("New location from: "+data.name);
	delete locations[data.name]['name'];
}

/**
 * Look in clients[] which client has subscribed the data and send a notification to those
 */
function lookForSubscriber(data, type, socket) {
	var id = data.id;
	for (var client in clients) { // look up all clients
		for (var sub in clients[client].subscriptions) { // and check if they have subscribed to it
			for (var i = 0; i < clients[client].subscriptions[sub].length; i++) { // go through all subscriptions
				if (id == clients[client].subscriptions[sub][i]) { // check if the client has subscribed to the changes
					var msg = {
						type: "update",
						section: "events",
						id: id
					}
					msg = JSON.stringify(msg);
					socket = clients[client];
					socket.send(msg);
				}
			}
		}
	}
}

/**
 * Checks if someone has not updated his positions for a spec. interval
 */
function killIdle() {
	var currentDate = new Date();
	var serverTime = currentDate.getHours() + ":" + currentDate.getMinutes();
	var diff;

	for (var key in locations) {
		if (key != "type") {
			diff = timeDiff(locations[key].lastsync, serverTime);
			if (diff > idleTime)
				delete locations[key];
		}
	}
}

/**
 * Receives data and adds a timestamp to it
 */
function addTimestamp(entry) {
	var currentDate = new Date();
	var timestamp = currentDate.getHours() + ":" + currentDate.getMinutes();
	entry.lastsync = timestamp;
	return entry;
}

/**
 * Calc. the difference between two times
 * Usage: timeDiff("10:00", "11:45") will return 1:45
 */
function timeDiff(start, end) {
	start = start.split(":");
	end = end.split(":");
	var startDate = new Date(0, 0, 0, start[0], start[1], 0);
	var endDate = new Date(0, 0, 0, end[0], end[1], 0);
	var diff = endDate.getTime() - startDate.getTime();
	var hours = Math.floor(diff / 1000 / 60 / 60);
	diff -= hours * 1000 * 60 * 60;
	var minutes = Math.floor(diff / 1000 / 60);
	return minutes;
}

/**
 * Check if an array contains a specific value
 */
function isInArray(value, array) {
	return array.indexOf(value) > -1 ? true : false;
}