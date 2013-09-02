<article>
	<h1>Chats</h1>
	
	<div id="chathistory"></div>
	<div>
		<span id="chatstatus">Establishing connection...</span>
		<input type="text" id="chatinput" placeholder="Type new message" style=""/>
		<button onclick="sendChatMessage()" class="button" style="margin-top:1em;">Send</button>
	</div>

</article>

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