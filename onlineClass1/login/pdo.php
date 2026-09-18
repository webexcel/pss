<?php
date_default_timezone_set('Asia/Kolkata');

$dbUser	=	($_SERVER['HTTP_HOST']=='localhost') ? 'root' : $_SESSION['dbuser'];
$dbPass	=	($_SERVER['HTTP_HOST']=='localhost') ? '' : $_SESSION['dbpass'];

define("DB_HOST", 'localhost');
define("DB_USER", $dbUser);
define("DB_PASS", $dbPass);
define("DB_NAME", $_SESSION['SESS_MEMBER_DBNAME']);


try {
	$bdd = new PDO("mysql:host=localhost;dbname=".DB_NAME.";charset=utf8", $dbUser, $dbPass);
} catch(Exception $e) {
	die('Erreur : '.$e->getMessage());
}
