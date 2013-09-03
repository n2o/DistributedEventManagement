<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Chats</h1>
</div>
<div data-role="content">
	<article>
		<span id="chatstatus">Please refresh page if you can read this...</span>
		<div id="chathistory" style="height: 80%"></div>
		<input type="text" id="chatinput" data-mini="true" disabled="disabled" placeholder="Type new message"/>
		<button onclick="sendChatMessage()">Send</button>
	</article>
</div>

<script type="text/javascript">
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