<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../css/main.css" />
	<link rel="stylesheet" type="text/css" href="../css/default.css" />

	<title>Installing the Mei&szlig;ner Application</title>
</head>
<body>
	<div id="container">
		<section id="page">
			<header>
				<img src="../img/logo/logo.png" width="100px">
			</header>

			<div id="content">
				<article>
					<h1>Installing the Mei&szlig;ner Application</h1>
					<h4>That's it!</h4>
					<br>
					<p>
						Everything is set up. You can now log in into your app with this account:<br>
						<br>
						<ul>
							<li>User: Administrator</li>
							<li>Password: greatmeissnerapp</li>
						</ul>
						<br>
						You need to change this password within your Account. Click on the button to do so...<br>
						<br>

						<?php 

							echo "<a href='http://".$_SERVER['SERVER_NAME']."/meissner' class='button'>Get out of here!</a>";

						?>
					</p>
				</article>
			</div>
			<footer>
			</footer>
		</section>
	</div>
</body>
</html>