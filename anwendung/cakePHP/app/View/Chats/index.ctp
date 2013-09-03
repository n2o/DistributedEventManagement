<article>
	<h1>Chats</h1>
	
	<span id="chatstatus">Please refresh page if you can read this...</span>
	<div id="chathistory"></div>
	<input type="text" id="chatinput" placeholder="Type new message" disabled="disabled"/>
	<button onclick="sendChatMessage()" class="button" style="margin-top:1em;">Send</button>

</article>

<script type="text/javascript">
$(document).ready(function(){
	setTimeout("getHistory()", 3000);
});

function getHistory() {
	var msg = {
		name: name,
		type: 'message',
		text: $('#chatinput').val()
	}
	socket.send(JSON.stringify(msg));
}

function sendChatMessage() {
	var msg = {
		name: name,
		type: 'message',
		text: $('#chatinput').val()
	}
	socket.send(JSON.stringify(msg));
	$('#chatinput').val('');

	// disable the input field to make the user wait until server sends back response
	$('#chatinput').attr('disabled', 'disabled');
}
</script>