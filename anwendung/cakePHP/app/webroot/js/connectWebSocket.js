/**
 * Client application to connect to a remote WebSocket server
 *
 * Waits on states of socket and calls the corresponding function
 */
$(function () {
	var wsUri;
	var connected = false;

	// Initial call
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
				if (data.section == "events")
					noty({text: 'Your event '+data.title+" has been updated!", type: 'information'});
				break;

			case 'history':
				console.log("Received new chat history");
				incomingChatMessage(data);
				break;

			case 'message':
				console.log("Received new chat message");
				incomingChatMessage(data);
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
			socket.send(synMessage);
		}
	}

	function incomingChatMessage(message) {
		'use strict';

		if (typeof(socket) === undefined) {
			$('#chathistory').html($('<article>', { text: 'Sorry, but your browser doesn\'t support WebSockets.'} ));
			$('#chatinput').hide();
			$('span').hide();
			return;
		}

		var type = message.type;

		$('#chatstatus').hide();
		if (type === 'history') {
			$('#chatinput').removeAttr('disabled').focus();
			for (var i=0; i < message.data.length; i++) {
				addMessage(message.data[i].name, message.data[i].text, new Date(message.data[i].time));
			}
		} else if (type === 'message') {
			$('#chatinput').removeAttr('disabled'); // let the user write another message
			addMessage(message.data.name, message.data.text, new Date(message.data.time));
		} else {
			console.log('Something went wrong...');
		}
	}

	/**
	* Send mesage when user presses Enter key
	*/
	$('#chatinput').keydown(function(e) {
		if (e.keyCode === 13) {
			var msg = {
				name: name,
				type: 'message',
				text: $(this).val()
			}
			socket.send(JSON.stringify(msg));
			$(this).val('');

			// disable the input field to make the user wait until server
			// sends back response
			$('#chatinput').attr('disabled', 'disabled');

		}
	});

	function addMessage(author, message, dt) {
		$('#chathistory').prepend('<p>' + author + ' @ ' +
			+ (dt.getHours() < 10 ? '0' + dt.getHours() : dt.getHours()) + ':'
			+ (dt.getMinutes() < 10 ? '0' + dt.getMinutes() : dt.getMinutes())
			+ ': ' + message + '</p>');
	}

});