<?php 
/**
 * Manifest file for caching
 *
 * Simple manifest file to enable caching on alle pages
 */
header('Content-Type: text/cache-manifest');
echo "CACHE MANIFEST\n";

echo "\n\nCACHE:\n";
echo "\n";

echo "\n\nNETWORK:\n";
echo "./chats/*\n";
echo "*\n";

echo "# Version 30\n";

?>