<style type="text/css">
#popupPanel-popup {
    right: 0 !important;
    left: auto !important;
}
#popupPanel {
    width: 200px;
    border: 1px solid #000;
    border-right: none;
    background: rgba(0,0,0,.5);
    margin: -1px 0;
}
#popupPanel .ui-btn {
    margin: 2em 15px;
}
</style>

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