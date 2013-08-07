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

websocket.listen(port, host, function(conn) {
	console.log("connection opened");

	conn.on("data", function(opcode, data) {
		console.log("message: ", data);
		conn.send(data);
	});

	conn.on("close", function(code, reason) {
		console.log("connection closed: ", code, reason);
	});
});