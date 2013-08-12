<article>
	<h1>Geolocations</h1>
	<div style="float:right;" class="connectionState"></div>
	<button class="button" onclick="window.location.reload()">Refresh page</button>
	<br>
</article>

<script type="text/javascript">
	var name = '<?php echo $username; ?>';
</script>
<?php 
	$scripts = array(
			"http://localhost:9999/socket.io/socket.io.js",
			"http://maps.googleapis.com/maps/api/js?sensor=true",
			"Geolocations/sendPosition.js",
			"Geolocations/drawMap.js",
			"Geolocations/geoFunctions.js"
		);
	echo $this->Html->script($scripts);
?>