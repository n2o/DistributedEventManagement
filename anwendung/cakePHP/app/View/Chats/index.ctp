<article>
	<h1>Chats</h1>
	
	<div id="chathistory"></div>
	<div>
		<span id="chatstatus">Establishing connection...</span>
		<input type="text" id="chatinput"/>
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
</script>