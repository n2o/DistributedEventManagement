<?php 
/**
 * Manifest file for caching
 *
 * Simple manifest file to enable caching on alle pages
 */
header('Content-Type: text/cache-manifest');
echo "CACHE MANIFEST\n";
 
$hashes = "";
$lastFileWasDynamic = FALSE;
 
$dir = new RecursiveDirectoryIterator(".");
foreach(new RecursiveIteratorIterator($dir) as $file) {
	if ($file->IsFile() && $file != "./manifest.php" && substr($file->getFilename(), 0, 1) != "." && $dir != "websocket" && !preg_match('/.key$/', $file) && !preg_match('/.psd$/', $file)) {
		if(preg_match('/.php$/', $file)) {
			if(!$lastFileWasDynamic) {
				echo "\n\nNETWORK:\n";
			}
			$lastFileWasDynamic = TRUE;
		} else {
			if($lastFileWasDynamic) {
				echo "\n\nCACHE:\n";
				$lastFileWasDynamic = FALSE;
			}
		}
		echo $file . "\n";
		$hashes .= md5_file($file);
	}
}

// echo "\n\nNETWORK:\n";
// echo "https://maps.*\n";
// echo "http://maps.*\n";
// echo "https://maps.googleapis.com/maps/api/js?sensor=true\n";
// echo "http://maps.googleapis.com/maps/api/js?sensor=true\n";
// echo "https://maps.gstatic.com/cat_js/intl/de_de/mapfiles/api-3/14/3/%7Bcommon,util,stats%7D.js\n";
// echo "http://maps.gstatic.com/cat_js/intl/de_de/mapfiles/api-3/14/3/%7Bcommon,util,stats%7D.js\n";
// echo "https://maps.gstatic.com/*\n";

// echo "http://www.w3.org/2005/Atom\n";
// echo "http://maps.gstatic.com/\n";
// echo "http://maps.google.com/\n";
// echo "http://maps.googleapis.com/\n";
// echo "http://mt0.googleapis.com/\n";
// echo "http://mt1.googleapis.com/\n";
// echo "http://mt2.googleapis.com/\n";
// echo "http://mt3.googleapis.com/\n";
// echo "http://khm0.googleapis.com/\n";
// echo "http://khm1.googleapis.com/\n";
// echo "http://cbk0.googleapis.com/\n";
// echo "http://cbk1.googleapis.com/\n";
// echo "http://www.google-analytics.com/\n";
// echo "http://gg.google.com/\n";

// echo "https://www.w3.org/2005/Atom\n";
// echo "https://maps.gstatic.com/\n";
// echo "https://maps.google.com/\n";
// echo "https://maps.googleapis.com/\n";
// echo "https://mt0.googleapis.com/\n";
// echo "https://mt1.googleapis.com/\n";
// echo "https://mt2.googleapis.com/\n";
// echo "https://mt3.googleapis.com/\n";
// echo "https://khm0.googleapis.com/\n";
// echo "https://khm1.googleapis.com/\n";
// echo "https://cbk0.googleapis.com/\n";
// echo "https://cbk1.googleapis.com/\n";
// echo "https://www.google-analytics.com/\n";
// echo "https://gg.google.com/\n";

// echo "*socket.io.js*\n";
 
echo "# Hash: " . md5($hashes) . "\n";

?>