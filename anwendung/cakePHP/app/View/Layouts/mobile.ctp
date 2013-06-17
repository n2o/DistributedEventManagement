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
			<?php echo $cakeDescription; ?>
			<?php echo $title_for_layout; ?>
		</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
		<meta name="apple-mobile-web-app-capable" content="yes">  
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<?php
			echo $this->Html->meta('icon');

			$jsimport = array(
					'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js',
					'http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.js',
					'jquery.jpanelmenu.min.js'
				);
			echo $this->Html->script($jsimport);

			$cssimport = array(
					'http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.min.css',
					'main',
					'mobile'
				);
			echo $this->Html->css($cssimport);
			
			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>
	<header class="main">
        <div class="menu-trigger">Click Me</div>
        <ul id="menu" style="display: none;">
            <li><a href="/">Overview</a></li>
            <li><a href="#usage">Usage</a></li>
            <li><a href="#inner-workings">Inner-Workings</a></li>
            <li><a href="#animation">Animation</a></li>
            <li><a href="#options">Options</a></li>
            <li><a href="#api">API</a></li>
            <li><a href="#tips">Tips &amp; Examples</a></li>
            <li><a href="#about">About</a></li>
        </ul>
</header>
<script type="text/javascript">
    $(document).ready(function () {
        var jPM = $.jPanelMenu();
        jPM.on();
    });
</script>
	<body>
		<div data-role="page">
			<?php echo $this->fetch('content'); ?> <!-- Include contents -->
			<?php echo $this->Session->flash(); ?>
			<div data-role="footer" data-position="fixed">
				<div data-role="navbar">
					<?php include('nav.ctp'); ?>
				</div>
			</div>
		</div>
	</body>
</html>