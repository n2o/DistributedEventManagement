/**
 * Script to start the WebSocket server
 *
 * simple-websocket-server.js needs to be in the same directory as this script
 * Execute it with: $node startEchoServer.js
 *
 * var port: set the port the servers needs to listen to
 * var host: set the hostname of the server
 */

var port = 9999;
var host = "localhost";

// Do not edit these lines
var websocket = require("./simpleWebsocketServer");

showSplashScreen();

websocket.listen(port, host, function(conn) {
	console.log("");
	console.log("* Incoming connection");

	conn.on("data", function(opcode, data) {
		console.log("Received: ", data);
		conn.send(data);
	});

	conn.on("close", function(code, reason) {
		console.log("Connection closed: ", code, reason);
	});
});

function showSplashScreen() {
	console.log("*********************************************");
	console.log("* Started WebSocket server                  *");
	console.log("*********************************************");
	console.log("* Waiting for incoming packets              *");
	console.log("*********************************************");
}

/**
 * Area to prepare the data just received, merge it with the other geolocations
 * and return an updated json file with all information
 */
