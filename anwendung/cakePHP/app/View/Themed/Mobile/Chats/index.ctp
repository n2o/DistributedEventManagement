<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Chats</h1>
</div>
<div data-role="content">
	<article>
		<span id="chatstatus">If you can read this AND your WebSocket Server ist definitely running, please refresh this page</span>
		<div id="chathistory" style="height: 80%"></div>
		<input type="text" id="chatinput" placeholder="Type new message"/>
		<button onclick="sendChatMessage()">Send</button>
	</article>
</div>

<script type="text/javascript">

function sendChatMessage() {
	if ($('#chatinput').val().length > 0) {
		var msg = {
			name: name,
			type: 'message',
			text: $('#chatinput').val()
		}
		socket.send(JSON.stringify(msg));
		$('#chatinput').val('');
	}
}
</script>