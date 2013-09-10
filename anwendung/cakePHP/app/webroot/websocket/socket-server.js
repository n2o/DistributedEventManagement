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
var locations = {type: 'location'};	// store all geo information about persons

var history = []
var clients = {};

// Open module for session based authentication
var express = require('express'), http = require('http'), https = require('https'), crypto = require("crypto");
var app = express();
app.configure(function() {
	app.use(express.static('/'));
});

// Define path to certificates for secure connection
var fs = require('fs');

var server = http.createServer(app)
server.listen(port);

var io = require('socket.io').listen(server);

io.set('log level', 3);	// Normal: 2, Debug Mode: 3
io.set('transports', [	// set fallbacks for unsupported browsers
	'websocket',
	'flashsocket',
	'htmlfile',
	'xhr-polling',
	'jsonp-polling'
]);

var killIdleTimer = setInterval(function() {killIdle()}, idleTime/3);

io.sockets.on('connection', function (socket) {
	socket.on('message', function (message) {
		try {
			var data = JSON.parse(message);
			if (typeof(data.name) !== "null" && data.name !== "false") {
				switch(data.type) {
					case 'location':
						if (clients[data.name] !== undefined) {
							saveToLocations(data);
							socket.broadcast.send(JSON.stringify(locations));
							socket.send(JSON.stringify(locations)); // Send current location back to sender
						} else {
							socket.disconnect('unauthorized');
						}
						break;

					case 'syn':
						if (validSignature(data)) {
							// Initialize a client and identify him by name
							if (clients[data.name] === undefined) {
								clients[data.name] = {};
								clients[data.name].sockets = [];
								clients[data.name].subscriptions = [];
							}
							clients[data.name].sockets.push(socket);
							socket.send(JSON.stringify({type: 'history', data: history}));
						} else {
							console.log("Invalid Signature");
							socket.disconnect('unauthorized'); // close socket if wrong signature was sent
						}
						break;

					case 'subscribe':
					console.log("Subscription: "+message);
						if (clients[data.name] !== undefined) {
							clients[data.name].subscriptions = data.events;
						} else {
							socket.disconnect('unauthorized');
						}
						break;

					case 'publishEvent':
						lookForSubscriber(data, 'event');
						break;

					case 'message':
						if (clients[data.name] !== undefined) {
							var obj = {
								time: (new Date()).getTime(),
								text: htmlEntities(data.text),
								name: data.name
							}
							history.push(obj);
							history = history.slice(-100);
							
							socket.send(JSON.stringify({type: 'message', data: obj}));
							socket.broadcast.send(JSON.stringify({type: 'message', data: obj}));
						} else {
							socket.disconnect('unauthorized');
						}
						break;

					case 'history':
						// if (clients[data.name] !== undefined) {
							// if (history.length > 0) {
								socket.send(JSON.stringify({type: 'history', data: history}));
							// }
						// } else {
						// 	socket.disconnect('unauthorized');
						// }
						break;					
						
					default:
						socket.disconnect('unauthorized');
				}
			}
		} catch (e) {
			console.log("Invalid message received");
			socket.disconnect('invalid');
		}
	});
	socket.on('disconnect', function () {
		removeSocketFromList(socket);
	});
});

/**********************************************************************************
 * Area to prepare the data just received, merge it with the other geolocations
 * and return an updated json file with all information
 **********************************************************************************/

/**
 * Remove current socket from client on disconnect
 */
function removeSocketFromList(closeSocket) {
	for (var client in clients)
		for (var socket in clients[client].sockets)
			if (clients[client].sockets[socket] == closeSocket)
				clients[client].sockets.splice(socket, 1);
}

/**
 * Adds current person transmitted in data to array with all persons
 */
function saveToLocations(data) {
	addTimestamp(data);
	locations[data.name] = data;
	delete locations[data.name]['name'];
}

/**
 * Look in clients[] which client has subscribed the data and send a notification to those
 */
function lookForSubscriber(data, type) {
	var id = data.id;
	var title = data.title;
	for (var client in clients) { // look up all clients
		for (var sub in clients[client].subscriptions) { // and check if they have subscribed to it
			for (var i = 0; i < clients[client].subscriptions[sub].length; i++) { // go through all subscriptions
				if (id == clients[client].subscriptions[sub][i]) { // check if the client has subscribed to the changes
					var msg = {
						type: "update",
						section: "events",
						title: title,
						id: id
					}
					msg = JSON.stringify(msg);
					for (var chooseSocket in clients[client].sockets)
						clients[client].sockets[chooseSocket].send(msg);
				}
			}
		}
	}
}

/**
 * Check the signature with the public key of web-app and verify an user
 */
function validSignature(data) {
	var signature = data.sig;
	checkUsername = data.name;
	var publicKey = fs.readFileSync(__dirname+"/../public.key");
	var verifier = crypto.createVerify('SHA1');
	verifier.update(checkUsername);
	var success = verifier.verify(publicKey, signature, 'base64');
	return success;
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
 * Extracting HTML Entities and correcting the format
 */
function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;')
                      .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}