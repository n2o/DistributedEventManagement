<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Bachelorarbeit Christian Meter');
?>
<!DOCTYPE html>

<!-- Including manifest.php to cache page for offline application -->
<!--<?php echo "<html manifest='".$this->webroot."manifest.php'>"; ?>-->
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription; ?>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<?php
		echo $this->Html->scriptBlock('
			var jsVars = '.$this->Js->object($jsVars).';
			var mobile = false;
			var socket = undefined;
		');

		echo $this->Html->meta('icon');

		$jsimport = array(
			'config.js',
			'jquery.min.js',
			'noty/jquery.noty.js',
			'noty/layouts/bottom.js',
			'noty/themes/default.js',
			'slidingDiv.js',
			'connectWebSocket.js',
			'Geolocations/geoFunctions.js',
			'https://maps.googleapis.com/maps/api/js?sensor=true',
			'Geolocations/drawMap.js'
		);
		echo $this->Html->script($jsimport);

		$cssimport = array(
				'main',
				'default'
			);
		echo $this->Html->css($cssimport);

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<section id="page">
			<header>
				<?php 
					echo $this->Html->image("logo/logo.png", array('fullBase' => true, 'width' => '100px'));
					include ('nav.ctp'); 
				?>
			</header>
			<div id="content">
				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
			</div>
			<footer>
				<?php include ('footer.ctp'); ?>
			</footer>
		</section>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

			// Generate a dropdown menu in the navigation
			$("nav li:has(ul)").hover(function(){
				$(this).find("ul").slideDown();
			}, function(){
				$(this).find("ul").hide();
			});

			// Enable sliding divs
			$('.slide_div').slidingDiv({
				speed: 500,	// speed you want the toggle to happen	
			}); 
		});
	</script>
	<?php echo $this->Js->writeBuffer(); // Write cached scripts ?>
</body>
</html>
