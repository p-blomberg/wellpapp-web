<?php
// Cacha headers och innehåll så att vi kan ändra oss och skicka
// en Location-header även efter att vi börjat eka ut innehåll.
ob_start();

// Sätt den globala $repo_root till sökvägen till svn-repots root-mapp.
if(file_exists('classes'))
	$repo_root = '';
else if(file_exists('../classes'))
	$repo_root = '..';
else if(file_exists('../../classes'))
	$repo_root = '../..';

/**
 * Automatiskt anropad av php on-demand för att include:a filer med klassdefinitioner.
 * Antar att den globala variabeln $repo_root innehåller sökvägen till svn-repots root-mapp.
 */
function __autoload($class)
{
	global $repo_root;
	if(file_exists($repo_root.'/classes/'.$class.'.php'))
		require_once $repo_root.'/classes/'.$class.'.php';
}

/**
 * Klasser som behöver instantieras till en global.
 */
try {
	$wpc = new wellpappConnection("db_settings", $settings['debug']);
} catch (Exception $e) {
	header("HTTP/1.0 500 Internal Server Error");
	echo "<h1>Internal error: could not connect to wellpapp server</h1>";
	echo "<p>Error: ".$e->getMessage()."</p>";
	die();
}

?>
