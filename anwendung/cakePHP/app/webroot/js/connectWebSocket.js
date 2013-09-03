/**
 * Client application to connect to a remote WebSocket server
 *
 * Waits on states of socket and calls the corresponding function
 */
$(function () {
	var wsUri;
	var connected = false, gotHistory = false;

	// Initial call
	doConnect();

	/**
	 * Reconnect on disconnect, called by window eventlistener
	 */
	function refresh() {
		if (!connected) {
			doConnect();
		}
	}

	/**
	 * Connect to websocket server
	 */
	function doConnect() {
		try {
			socket = io.connect('wss://'+host+':'+port+'/');
			socket.on('connect', function (evt) { 
				onOpen(evt);
				socket.on('disconnect', function (evt) { onDisconnect(evt) });
				socket.on('message', function (evt) { onMessage(evt) });
				socket.on('error', function (evt) { onError(evt) });
			});
		} catch (e) {
			$('.connectionState').text("Not connected");
			$('.connectionState').removeClass('connected');
		}
	}

	/**
	 * Get current location, prepare JSON String and send it to WS server
	 */
	function doSend() {
		navigator.geolocation.getCurrentPosition(getPosition, noPosition);
	}

	/**
	 * On new websocket connection, update state
	 */
	function onOpen(evt) {
		synSocketID();

		var reference = (function initHistory(){
			var msg = {
				name: name,
				type: 'history'
			}
			socket.send(JSON.stringify(msg));
			return initHistory; //return the function itself to reference
		}()); //auto-run

		// reference(); //call it again
		// reference(); //and again

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
				try {
					updateMarkers(data);
				} catch (e) {
					// Map not correctly loaded!
				}
				break;
			
			case 'update':
				if (data.section == "events")
					noty({text: 'Your event '+data.title+" has been updated!", type: 'information'});
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