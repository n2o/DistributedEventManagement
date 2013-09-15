<?php 
/**
 * Manifest file for caching
 *
 * Dynamic manifest file to enable caching on alle pages. Scanning all 
 * available folders for files to be cached.
 *
 * Based on the code snippet by Nial Giacomelli from 
 * http://nial.me/2010/01/using-the-html5-cache-manifest-with-dynamic-files/
 * 25.01.2010
 */
header('Content-Type: text/cache-manifest');
echo "CACHE MANIFEST\n";

echo "\n\nNETWORK:\n"; # Force app to load all files from the web which are not listed in the next sections
echo "*\n";

echo "\n\nCACHE:\n";
$hashes = "";
$lastFileWasDynamic = FALSE;
 
$dir = new RecursiveDirectoryIterator(".");
foreach(new RecursiveIteratorIterator($dir) as $file) {
	if ($file->IsFile() && $file != "./manifest.php" && substr($file->getFilename(), 0, 1) != "." && $dir != "websocket" && $dir != "setup" && !preg_match('/.key$/', $file) && !preg_match('/.psd$/', $file)) {
		if (preg_match('/.php$/', $file)) {
			if (!$lastFileWasDynamic) {
				echo "\n\nNETWORK:\n";
			}
			$lastFileWasDynamic = TRUE;
		} else {
			if ($lastFileWasDynamic) {
				echo "\n\nCACHE:\n";
				$lastFileWasDynamic = FALSE;
			}
		}
		echo $file . "\n";
		$hashes .= md5_file($file);
	}
} 
echo "# Hash: " . md5($hashes) . "\n";


### Get current version number from Web-App

$file_handle = fopen("manifest.version", "r");
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   echo "# Version: ".$line."\n";
}
fclose($file_handle);

?>