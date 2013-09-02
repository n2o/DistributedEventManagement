<div data-role="header">
	<a href="#nav" data-role="button" data-inline="true" data-icon="bars">Menu</a>
	<h1>Geolocations</h1>
	<a href="#popupPanel" data-rel="popup" data-transition="slide" data-position-to="window" data-role="button">Options</a>
</div>
<div class="body" data-role="content">
	<div data-role="popup" id="popupPanel" data-corners="false" data-theme="none" data-shadow="false" data-tolerance="0,0">
		<button data-theme="a" data-icon="refresh" data-mini="true" onclick="window.location.reload()">Refresh Page</button>
		<button data-theme="a" data-icon="gear" data-mini="true" onclick="clearOverlays()">Clear Overlays</button>
		<button data-theme="a" data-icon="gear" data-mini="true" onclick="showOverlays()">Show Overlays</button>
		<button data-theme="a" data-icon="info" data-mini="true" onclick="toggleAutoZoomCenter()" id="autoZoomCenter">Switch autozoom</button>

		<div class="connectionState"></div>
	</div>

	<section id="map"></section>
</div>

<script type="text/javascript">
$(document).ready(function() {
	try {
		window.addEventListener("load", refresh, false);
	} catch (e) {
		// Ignore because first attempt often gets failed
	}
});
</script>