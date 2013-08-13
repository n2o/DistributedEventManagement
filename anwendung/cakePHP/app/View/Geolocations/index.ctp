<article>
	<h1>Geolocations</h1>
	<button class="button" onclick="window.location.reload()" style="float:left;">Refresh page</button><div style="float:right;" class="connectionState"></div>
	<button class="button" onclick="clearOverlays()" style="float:left;">Clear Overlays</button>
	<button class="button" onclick="showOverlays()" style="float:left;">Show Overlays</button>
</article>

<article>
	<section id="map"></section>
</article>
<?php 
	$scripts = array(
		"Geolocations/geoFunctions.js",
		"http://maps.googleapis.com/maps/api/js?sensor=true",
		"Geolocations/sendPosition.js",
		"Geolocations/drawMap.js"
	);
	echo $this->Html->script($scripts);
?>