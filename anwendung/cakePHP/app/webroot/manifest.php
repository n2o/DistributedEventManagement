<?php 
/**
 * Manifest file for caching
 *
 * Dynamic manifest file to enable caching on alle pages. Scanning all 
 * available folders for files to be cached.
 */
header('Content-Type: text/cache-manifest');
echo "CACHE MANIFEST\n";

echo "\n\nNETWORK:\n";
echo "*\n";

echo "\n\nCACHE:\n";
$hashes = "";
$lastFileWasDynamic = FALSE;
 
$dir = new RecursiveDirectoryIterator(".");
foreach(new RecursiveIteratorIterator($dir) as $file) {
	if ($file->IsFile() && $file != "./manifest.php" && substr($file->getFilename(), 0, 1) != "." && $dir != "websocket" && !preg_match('/.key$/', $file) && !preg_match('/.psd$/', $file)) {
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
echo "# Version: 38";

?>