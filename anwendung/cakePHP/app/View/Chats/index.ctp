<style>
#chathistory { 
	padding:5px; 
	background:#ddd; 
	border-radius:5px; 
	overflow-y: scroll;
	border:1px solid #CCC; 
	margin-top:10px; 
	height: 160px; 
}
#chatinput { 
	border-radius:2px; 
	border:1px solid #ccc;
	margin-top:10px; 
	padding:5px; 
	width:400px;
}
#chatstatus { 
	display:block; 
	margin-top:15px; 
}
</style>

<article>
	<h1>Chats</h1>
	
	<div id="chathistory"></div>
	<div>
		<span id="chatstatus">Establishing connection...</span>
		<input type="text" id="chatinput"/>
	</div>
</article>

<script type="text/javascript">
	var firstRun = true;
</script>