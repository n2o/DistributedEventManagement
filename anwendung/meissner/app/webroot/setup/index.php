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

			<?php 
				$pathToConfigFile = "../../Config/database.php";
				if (!file_exists($pathToConfigFile)) {
			?>

				<article>
					<h1>Installing the Mei&szlig;ner Application</h1>
					<h4>Welcome to the installation of the fabulous Mei&szlig;ner Application.</h4>
					<br>
					<p>
						That you can see this page, shows, that your LAMP server is set up properly. So in the next steps we will create the correct
						structure for the MySQL Database. 
					</p>
					<br>
					<p>
						For this you need an valid account to your database, the password for this user and the location of the database.
					</p>
					<br><br>
					<p><a href="step1.php" class="button">Next</a></p>

				</article>

			<?php 
			} else {
				echo "<article><h1>Installing the Mei&szlig;ner Application</h1>
					<h4>Welcome to the installation of the fabulous Mei&szlig;ner Application.</h4>
					<br>
					<p>
						The installation could not be started: A database.php file has been found. 
					</p></article>";
			}
			?>
			</div>
			<footer>
			</footer>
		</section>
	</div>
</body>
</html>