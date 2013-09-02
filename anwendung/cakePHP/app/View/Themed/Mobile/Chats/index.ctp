<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Chats</h1>
</div>
<div data-role="content">
	<article>
		<div id="chathistory" style="height: 80%"></div>
			<span id="chatstatus">Establishing connection...</span>
			<input length="100%" type="text" id="chatinput" data-mini="true" placeholder="Type new message"/>
			<button onclick="sendChatMessage()">Send</button>
	</article>
</div>

<script type="text/javascript">
/**
 * Execute this after DOM has loaded to get current history from 
 * WebSocket Server
 */
$(document).ready(function() {
	var msg = {
		name: name,
		type: 'history'
	}
	socket.send(JSON.stringify(msg));
});

function sendChatMessage() {
	var msg = {
		name: name,
		type: 'message',
		text: $('#chatinput').val()
	}
	socket.send(JSON.stringify(msg));
	$('#chatinput').val('');

	// disable the input field to make the user wait until server
	// sends back response
	$('#chatinput').attr('disabled', 'disabled');
}
</script>