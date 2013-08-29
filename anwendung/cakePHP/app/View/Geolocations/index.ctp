<article>
	<h1>Geolocations</h1>
	<button class="button" onclick="window.location.reload()" style="float:left;">Refresh page</button>
	<div style="float:right;" class="connectionState">Not connected</div>
	<button class="button" onclick="clearOverlays()" style="float:left;">Clear Overlays</button>
	<button class="button" onclick="showOverlays()" style="float:left;">Show Overlays</button>
	<button class="button" id="autoZoomCenter" onclick="toggleAutoZoomCenter()" style="float:left;">Disable autozoom</button>
	<section id="diff"></section>
</article>

<article>
	<section id="map"></section>
</article>