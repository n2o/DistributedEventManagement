<?php session_start(); ?>

<!DOCTYPE html>

<?php 
	$host = $_POST['host'];
	$user = $_POST['user'];
	$password = $_POST['password'];
	$_SESSION['host'] = $host;
	$_SESSION['user'] = $user;
	$_SESSION['password'] = $password;

	$error = false;

	$connection = @mysql_connect($host, $user, $password);
?>

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

			<?php if (!$connection) { ?>

				<h4>An error has occured!</h4>
				<br>
				<p>Connection to MySQL Database could not be established. Please try again!</p>
				<br>
				<form name="connection_information" style="margin-left:1em;" action="step2.php" method="post">
					<input style="width:300px;" type="text" name="host" placeholder="Host" required><br>
					<input style="width:300px;" type="text" name="user" placeholder="User" required><br>
					<input style="width:300px;" type="password" name="password" placeholder="password" required><br><br>
					<input type="submit" value="Submit">
				</form>

			<?php } else { 

				$createDatabase = "CREATE DATABASE IF NOT EXISTS `meissner`";
				$db_result = mysql_query($createDatabase);

				if (!$db_result) {
					echo "<h4><font style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;Failed to create Database `meissner`. Maybe you have not the permission to do this? &#10005;</font></h4><br>";
					$error = true;
				} else {
					echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created database `meissner` &#10003;</font></h4><br>";
				}

				# Switch into new created database
				mysql_select_db("meissner");

				# Create table events
				$createTable = "
					CREATE TABLE IF NOT EXISTS `events` (
						`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						`title` varchar(50) DEFAULT NULL,
						`description` text,
						`user_id` int(11) NOT NULL,
						`created` datetime DEFAULT NULL,
						`modified` datetime DEFAULT NULL,
						PRIMARY KEY (`id`),
						UNIQUE KEY `title` (`title`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
				";
				$writeToSql = mysql_query($createTable);
				if (!$writeToSql) {
					echo "<h4><font style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;Failed to create table `events` &#10005;</font></h4><br>";
					$error = true;
				} else {
					echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created table `events` &#10003;</font></h4><br>";
				}


				# Create table events_users
				$createTable = "
					CREATE TABLE IF NOT EXISTS `events_users` (
						`event_id` varchar(6) NOT NULL DEFAULT '',
						`user_id` varchar(6) NOT NULL DEFAULT '',
						PRIMARY KEY (`event_id`,`user_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				";
				$writeToSql = mysql_query($createTable);
				if (!$writeToSql) {
					echo "<h4><font style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;Failed to create table `events_users` &#10005;</font></h4><br>";
					$error = true;
				} else {
					echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created table `events_users` &#10003;</font></h4><br>";
				}


				# Create table event_columns
				$createTable = "
					CREATE TABLE IF NOT EXISTS `event_columns` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`event_id` int(11) NOT NULL,
						`name` varchar(128) NOT NULL,
						`value` varchar(128) NOT NULL,
						PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
				";
				$writeToSql = mysql_query($createTable);
				if (!$writeToSql) {
					echo "<h4><font style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;Failed to create table `event_columns` &#10005;</font></h4><br>";
					$error = true;
				} else {
					echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created table `event_columns` &#10003;</font></h4><br>";
				}


				# Create table event_properties
				$createTable = "
					CREATE TABLE IF NOT EXISTS `event_properties` (
						`user_id` int(11) NOT NULL,
						`event_id` int(11) NOT NULL,
						`name` varchar(512) NOT NULL,
						`value` varchar(512) NOT NULL,
						PRIMARY KEY (`user_id`,`name`),
						UNIQUE KEY `user_id` (`user_id`,`name`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1;
				";
				$writeToSql = mysql_query($createTable);
				if (!$writeToSql) {
					echo "<h4><font style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;Failed to create table `event_properties` &#10005;</font></h4><br>";
					$error = true;
				} else {
					echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created table `event_properties` &#10003;</font></h4><br>";
				}


				# Create table users
				$createTable = "
					CREATE TABLE IF NOT EXISTS `users` (
						`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						`username` varchar(50) DEFAULT NULL,
						`password` varchar(50) DEFAULT NULL,
						`has_login` tinyint(1) NOT NULL,
						`pause` tinyint(1) NOT NULL DEFAULT '0',
						`role` varchar(20) DEFAULT NULL,
						`created` datetime DEFAULT NULL,
						`modified` datetime DEFAULT NULL,
						PRIMARY KEY (`id`),
						UNIQUE KEY `username` (`username`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
				";
				$writeToSql = mysql_query($createTable);
				if (!$writeToSql) {
					echo "<h4><font style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;Failed to create Table `users` &#10005;</font></h4><br>";
					$error = true;
				} else {
					echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created table `users` &#10003;</font></h4><br>";
				}

				if ($error) {
					echo "There were errors. Can not proceed to the next steps...";
				} else {
					echo "<strong>MySQL Database was set up successfully!<br><br><hr><br>Now creating config file `database.php`...</strong><br><br>";
					
					$pathToConfigFile = "../../Config/database.php";

					$dollar = '$';

					$configFile = '
<?php 
class DATABASE_CONFIG {
	public $default = array(
		"datasource" => "Database/Mysql",
		"persistent" => false,
		"host" => "'.$host.'",
		"login" => "'.$user.'",
		"password" => "'.$password.'",
		"database" => "meissner",
		"prefix" => "",
		//"encoding" => "utf8",
	);
}
?>
					';
					file_put_contents($pathToConfigFile, $configFile);

					if (!file_exists($pathToConfigFile)) {
						echo "There were errors while creating your config file. Can not proceed to the next steps...";
					} else {
						echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Config file successfully created &#10003;</font></h4><br><br><hr><br>";
						echo "<strong>Creating Administrator...<strong><br><br>";

						$createAdministrator = "REPLACE INTO  `meissner`.`users` (`id` , `username` , `password` , `has_login` , `pause` , `role` , `created` , `modified`) VALUES (NULL , 'Administrator', '6266bc341a9483fb5b04b06b782676d9f622d866', '1', '0', 'admin', NOW(), NOW());";
						$writeToSql = mysql_query($createAdministrator);

						if (!$writeToSql) {
							echo "<h4><font style='color:red;'>&nbsp;&nbsp;&nbsp;&nbsp;Failed to create Administrator &#10005;</font></h4><br><br><hr><br>";
						} else {
							echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created Administrator &#10003;</font></h4><br><br><hr><br>";
							echo "<strong>Generating 2048 Bit RSA keys for app internal encryption...<strong><br><br>";

							# Create new public / private key pair if not available on server
							if (!file_exists("../private.key") || !file_exists("../public.key")) {
								$privateKey = openssl_pkey_new(array(
									'digest_alg' => 'sha512',
									'private_key_bits' => 2048,
									'private_key_type' => OPENSSL_KEYTYPE_RSA,
								));
								openssl_pkey_export_to_file($privateKey, '../private.key');
								$a_key = openssl_pkey_get_details($privateKey);
								file_put_contents('../public.key', $a_key['key']);
								openssl_free_key($privateKey);
							}

							echo "<h4><font style='color:green;'>&nbsp;&nbsp;&nbsp;&nbsp;Created RSA Keys &#10003;</font></h4><br>";
							echo "<br><br><p><a href='step3.php' class='button'>Next</a></p>";
						}
					}
				}
			}
			?>
			</article>
			</div>
			<footer>
			</footer>
		</section>
	</div>
</body>
</html>