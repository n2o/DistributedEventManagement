/**
 * Script which updates a JSON object and sends it via WebSocket 
 * to the specified
 */

$(function() {

	// Settings
	var port = 9999;
	var host = "localhost";
	var name = Math.random().toString().substr(2,2);
	var delay = 3000;

	// Start updating coords in 
	var timer = setInterval(function(){setup()}, delay);

	// Initialize WebSocket connection and event handlers
	function setup() {
		navigator.geolocation.getCurrentPosition(function(position) {
			var latitude = position.coords.latitude;
			var longitude = position.coords.longitude;

			var currentDate = new Date();
			var timestamp = currentDate.getHours() + ":" + currentDate.getMinutes() + ":" + currentDate.getSeconds();

			var msg = {
				person: {
					name: name,
					position: {
						latitude: latitude,
						longitude: longitude
					},
					lastsync: timestamp
				}
			}
			msg = JSON.stringify(msg);

			output = document.getElementById("output");
			ws = new WebSocket("ws://"+host+":"+port);

			// Check here all possible events: open, close, error, message
			ws.onopen = function(e) {
				log("Connected");
				sendMessage(msg);
			}

			ws.onclose = function(e) {
				log("Disconnected: " + e.reason);
			}

			ws.onerror = function(e) {
				log("Error ");
			}

			ws.onmessage = function(e) {
				log("Message received: " + e.data);
				// Close connection after message was received
				ws.close();
			}
		});
	}

	function sendMessage(msg) {
		ws.send(msg);
		log("Message sent: " + msg);
	}

	function log(s) {
		output = document.getElementById("output");
		var p = document.createElement("p");
		p.style.wordWrap = "break-word";
		p.textContent = s;
		output.appendChild(p);
		console.log(s);
	}

//timer = setInterval(function(){setup()}, 3000);
});