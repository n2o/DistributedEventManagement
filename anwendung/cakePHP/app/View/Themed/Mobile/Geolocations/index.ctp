<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Geolocations</h1>
	<button class="switchInfo">Info</button>
</div>
<div class="body" data-role="content">

	<section id="overlay_map">
		<strong>Distances</strong>
		<p>
			<ul></ul>
		</p>
		<br/>
		<strong>Status of WebSocket connection: </strong> <div class="connectionState"></div>
		<br>
		<br>
		<br>
		<button class="switchInfo">Close</button>
	</section>
	<section id="map"></section>
</div>

<script type="text/javascript">
	var name = '<?php echo $username; ?>';
	var mobile = true;
</script>
<?php 
	$scripts = array(
		"Geolocations/geoFunctions.js",
		"http://maps.googleapis.com/maps/api/js?sensor=true",
		"Geolocations/sendPosition.js",
		"Geolocations/drawMap.js"
	);
	echo $this->Html->script($scripts);
?>