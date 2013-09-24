<?php

// Check if we run in cli mode or not
// then verify out location

// Empty params
$connectionString = '';
$dbhost = 'localhost';
$dbdriver = 'mysql';
$dbname = '';
$dbuser = '';
$dbpass = '';
$dbextra = '';

if(verifyLocation('vadimgabriel')) {
	$dbname = 'vims30';
	$dbextra = ';unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
	$connectionString = $dbdriver.':host='.$dbhost.';dbname=' . $dbname . $dbextra;
	$dbuser = 'root';
	$dbpass = '';
} else {
	
}

// Set params
define('CONNECTION_STRING', $connectionString);
define('DB_NAME', $dbname);
define('DB_HOST', $dbhost);
define('DB_DRIVER', $dbdriver);
define('DB_USER', $dbuser);
define('DB_PASS', $dbpass);
define('DB_EXTRA', $dbextra);

function isCli() {
     if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) {
          return true;
     } else {
          return false;
     }
}

function verifyLocation($key) {
	if(isCli()) {
		return (strpos($_SERVER['PWD'], $key) !== false);
	} else {
		return (strpos($_SERVER['DOCUMENT_ROOT'], $key) !== false);
	}
}