<?php
/**
 * Create mobile layout with JQuery Mobile
 */
	$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>

<!DOCTYPE HTML>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $cakeDescription ?>:
			<?php echo $title_for_layout; ?>
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php
			echo $this->Html->meta('icon');

			$jsimport = array(
					'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js',
					'http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js'
				);
			echo $this->Html->script($jsimport);

			echo $this->Html->css('http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css');

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>
	<body>
		<div data-role="page">
			<?php echo $this->Session->flash(); ?>
			<div data-role="header">
				<?php include('nav.ctp'); ?>
			</div>
			<div data-role="content">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</body>
</html>