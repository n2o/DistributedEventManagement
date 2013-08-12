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
var idleTime = 15; // Spec. after how many minutes a user is removed from the list

// Necessary, do not edit
var persons = {};	// store all information about persons

var io = require('socket.io').listen(port);

io.sockets.on('connection', function (socket) {
	socket.on('message', function (message) {
		saveToPersons(message);
		socket.send(JSON.stringify(persons));
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
function saveToPersons(data) {
	var entry = JSON.parse(data);
	addTimestamp(entry);
	persons[entry.person.name] = entry;
	delete persons[entry.person.name]['person']['name'];
}

/**
 * Checks if someone has not updated his positions for a spec. interval
 */
function killIdle() {
	var currentDate = new Date();
	var serverTime = currentDate.getHours() + ":" + currentDate.getMinutes();
	var diff;

	for (var key in persons) {
		diff = timeDiff(persons[key].person.lastsync, serverTime);
		if (diff > idleTime) {
			delete persons[key];
		}
	}
}

/**
 * Receives data and adds a timestamp to it
 */
function addTimestamp(entry) {
	var currentDate = new Date();
	var timestamp = currentDate.getHours() + ":" + currentDate.getMinutes();
	entry.person.lastsync = timestamp;
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