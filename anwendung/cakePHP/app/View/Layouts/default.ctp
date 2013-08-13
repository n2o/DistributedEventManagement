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
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<script type="text/javascript">
		var name = '<?php echo $username; ?>';
		var mobile = false;
	</script>
	<?php
		echo $this->Html->meta('icon');

		$jsimport = array(
			'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js',
			'slidingDiv.js',
			'connectWebSocket.js'
		);
		echo $this->Html->script($jsimport);

		$cssimport = array(
				'main',
				'default',
				'http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900'
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
</body>
</html>
