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
					<h4>Connecting to MySQL Database</h4>
					<br>
					<p>
						Please insert here your data to connect to your MySQL Database:
					</p>
					<br>
					<form name="connection_information" style="margin-left:1em;" action="step2.php" method="post">
						<input style="width:300px;" type="text" name="host" placeholder="Host" required><br>
						<input style="width:300px;" type="text" name="user" placeholder="User" required><br>
						<input style="width:300px;" type="password" name="password" placeholder="password" required><br><br>
						<input type="submit" value="Submit">
					</form>

				</article>
			</div>
			<footer>
			</footer>
		</section>
	</div>
</body>
</html>