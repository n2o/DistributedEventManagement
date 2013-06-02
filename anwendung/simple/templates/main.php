<!DOCTYPE HTML>
<!-- Basic page structure in html5 -->
<html>
	<head>
		<title><?php echo $this->_['page_title']; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
	</head>
	<body>
		<section id="page"> <!-- Starting the main page -->
			<header>
				<nav>
					<ul>
						<li>No Links</li>
						<li>at this time</li>
					</ul>
				</nav>
			</header>

		<!-- Start parsing the content to the page -->
				<?php echo $this->_['page_content']; ?>
		<!-- /Content -->

			<footer>
				<hr />
				<?php echo $this->_['page_footer']; ?>
			</footer>
		</section>
	</body>
</html>