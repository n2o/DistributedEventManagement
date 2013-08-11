<article>
	<h1>Geolocations</h1>
	<div style="float:right;" class="connectionState"></div>
</article>

<script type="text/javascript">
	var name = '<?php echo $username; ?>';
</script>
<?php 
	# Include script to send current position to server
	echo $this->Html->script("Geolocations/sendPosition.js");
	# Include Google Maps API
	echo $this->Html->script("http://maps.googleapis.com/maps/api/js?sensor=true");
	# Show map on page
	echo $this->Html->script("Geolocations/drawMap.js");
	echo $this->Html->script("Geolocations/geoFunctions.js");
?>
