<?php
/**
 * Create mobile layout with jQuery Mobile
 */
$cakeDescription = __d('cake_dev', 'Mei&szlig;ner');
?>

<!DOCTYPE HTML>
<!-- Including manifest.php to cache page for offline application -->
<?php echo "<html manifest='".$this->webroot."manifest.php'>"; ?>
<!-- <html> -->
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription; ?>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes"> <!-- if added to iOS homescreen, it has fullscreen -->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<!-- iPhone Retina -->
	<link rel="apple-touch-startup-image" href="img/icons/apple-touch-startup-image-640x920.png" media="(device-width: 640px) and (device-height: 1136px) and (-webkit-device-pixel-ratio: 2)">
	<!-- iPhone Classic -->
	<link rel="apple-touch-startup-image" href="img/icons/apple-touch-startup-image-640x1096.png" media="(device-width: 320px) and (device-height: 1096px) and (-webkit-device-pixel-ratio: 2)">
	<link rel="apple-touch-icon" href="img/icon.png">

	<script type="text/javascript">
		// Check if a new cache is available on page load.
		// from: http://www.html5rocks.com/de/tutorials/appcache/beginner/
		window.addEventListener('load', function(e) {
			window.applicationCache.addEventListener('updateready', function(e) {
				if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
					// Browser downloaded a new app cache.
					// Swap it in and reload the page to get the new hotness.
					window.applicationCache.swapCache();
					//if (confirm('A new version of this site is available. Load it?')) {
						window.location.reload();
					//}
				} else {
					// Manifest didn't changed. Nothing new to server.
				}
			}, false);
		}, false);
	</script>

	<?php
		echo $this->Html->scriptBlock('
			var jsVars = '.$this->Js->object($jsVars).';
			var mobile = true;
			var socket = undefined;
		');

		echo $this->Html->meta('icon');

		$jsimport = array(
			'//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
			'//code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js',
			'config.js',
			'noty/jquery.noty.js',
			'noty/layouts/bottom.js',
			'noty/themes/default.js',
			'connectWebSocket.js',
			'Geolocations/geoFunctions.js',
			'//maps.googleapis.com/maps/api/js?sensor=true',
			'Geolocations/drawMap.js'
		);
		echo $this->Html->script($jsimport);

		$cssimport = array(
			'//code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css',
			'main',
			'mobile'
		);
		echo $this->Html->css($cssimport);
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<!-- Page -->
	<div data-role="page">
		<?php include('mobilenav.ctp'); ?>
		<?php echo $this->fetch('content'); ?>
		<?php echo $this->Session->flash(); ?>
	</div><!-- /Page -->

    <script type="text/javascript">
        window.scrollTo(0,1); // Older versions: Scroll 1 pixel down to let the status bar fade out
    </script>
    <?php echo $this->Js->writeBuffer(); // Write cached scripts ?>
</body>
</html>