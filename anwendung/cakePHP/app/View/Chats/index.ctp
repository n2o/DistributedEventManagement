<article>
	<h1>Chats</h1>
	
	<!-- <span id="chatstatus">If you can read this AND your WebSocket Server ist definitely running, please refresh this page</span> -->
	<div id="chathistory"></div>
	<input type="text" id="chatinput" placeholder="Type new message"/>
	<button onclick="sendChatMessage()" class="button" style="margin-top:1em;">Send</button>

</article>

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