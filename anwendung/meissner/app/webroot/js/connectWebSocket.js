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

	/**
	 * Reconnect on disconnect, called by window eventlistener
	 */
	function refresh() {
		try {
			if (!connected) {
				doConnect();
			}
		} catch (e) {
			// If socket.io could not be received, do nothing
		}
	}

	/**
	 * Connect to websocket server
	 */
	function doConnect() {
		if (typeof(name) == null) {
			return;
		}
		try {
			if (io !== undefined) {
				socket = io.connect('ws://'+host+':'+port+'/');
				synSocketID();
				socket.on('connect', function (evt) { 
					onOpen(evt);
					socket.on('disconnect', function (evt) { onDisconnect(evt) });
					socket.on('message', function (evt) { onMessage(evt) });
					socket.on('error', function (evt) { onError(evt) });
				});
			}
		} catch (e) {
			$('.connectionState').text("Not connected");
			$('.connectionState').removeClass('connected');
		}
	}

	/**
	 * On new websocket connection, update state
	 */
	function onOpen(evt) {
		connected = true;
		$('.connectionState').text("Connected");
		$('.connectionState').addClass('connected');
	}

	/**
	 * On closed connection, update state
	 */
	function onDisconnect(evt) {
		connected = false;
		$('.connectionState').text("Not connected");
		$('.connectionState').removeClass('connected');
		doConnect();
	}

	/**
	 * Close socket and update state
	 */
	function doDisconnect() {
		socket.close();
		connected = false;
		$('.connectionState').text("Not connected");
		$('.connectionState').removeClass('connected');
	}

	/**
	 * Look up type of message when received new message
	 */
	function onMessage(evt) {
		// Update the marks on the map
		var data = JSON.parse(evt);
		switch(data.type) {
			case 'location':
				//noty({text: 'Incoming: New coordinates for geolocations.'});
				if (controller == "Geolocations") {
					updateMarkers(data);
				}
				break;
			
			case 'update':
				if (data.section == "events") {
					noty({text: 'Your event '+data.title+" has been updated!", type: 'information'});
				}
				break;

			case 'history':
				incomingChatMessage(data);
				break;

			case 'message':
				incomingChatMessage(data);
				break;
		}
	}

	/**
	 * Print error message on error event
	 */
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

/************************** Chat section **************************/
	/**
	 * Main Logic for Chat function
	 *
	 * Sending new messages to websocket server and wait for new messages 
	 * from other users. Request history on first connect.
	 */
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
			for (var i=0; i < message.data.length; i++) {
				addMessage(message.data[i].name, message.data[i].text, new Date(message.data[i].time));
			}
		} else if (type === 'message') {
			addMessage(message.data.name, message.data.text, new Date(message.data.time));
		} else {
			console.log('Something went wrong...');
		}
	}

	/**
	* Send mesage when user presses Enter key
	*/
	$('#chatinput').keydown(function(e) {
		if (e.keyCode === 13 && $(this).val().length > 0) {
			var msg = {
				name: name,
				type: 'message',
				text: $(this).val()
			}
			socket.send(JSON.stringify(msg));
			$(this).val('');
		}
	});

	/**
	 * Prepend the new text message on screen
	 */
	function addMessage(author, message, dt) {
		$('#chathistory').prepend('<p>' + author + ' @ ' +
			+ (dt.getHours() < 10 ? '0' + dt.getHours() : dt.getHours()) + ':'
			+ (dt.getMinutes() < 10 ? '0' + dt.getMinutes() : dt.getMinutes())
			+ ': ' + message + '</p>');
	}
});