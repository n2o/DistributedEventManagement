<article>
	<h1>Geolocations</h1>
	<div style="float:right;" class="connectionState"></div>
</article>

<script type="text/javascript">
	var name = '<?php echo $username; ?>';
</script>
<script src="http://localhost:9999/socket.io/socket.io.js"></script>
<?php 
	# Include script to send current position to server
	echo $this->Html->script("Geolocations/sendPosition.js");
	# Include Google Maps API
	echo $this->Html->script("http://maps.googleapis.com/maps/api/js?sensor=true");
	# Show map on page
	echo $this->Html->script("Geolocations/drawMap.js");
	echo $this->Html->script("Geolocations/geoFunctions.js");
?>

<button onclick="foo()">Send jeeeeah</button>

<script type="text/javascript">
	function foo() {
		socket.send("jeaaaah");
	}

</script>