<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Geolocations</h1>
	<button class="switchInfo">Info</button>
</div>
<div class="body" data-role="content">
	<section id="overlay_map">
		<strong>Some preferences for the geolocations</strong><br>
		<button onclick="window.location.reload()" style="float:left;">Refresh page</button>
		<button onclick="clearOverlays()" style="float:left;">Clear Overlays</button>
		<button onclick="showOverlays()" style="float:left;">Show Overlays</button>
		<button id="autoZoomCenter" onclick="toggleAutoZoomCenter()" style="float:left;">Switch autozoom</button>
		<strong>Status of WebSocket connection: </strong> <div class="connectionState"></div>
		<br>
		<br>
		<br>
		<button class="switchInfo">Close</button>
	</section>

	<section id="map"></section>
</div>

<?php 
	$scripts = array(
		"Geolocations/geoFunctions.js",
		"http://maps.googleapis.com/maps/api/js?sensor=true",
		"Geolocations/drawMap.js"
	);
	echo $this->Html->script($scripts);
?>