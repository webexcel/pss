<?php
date_default_timezone_set('Asia/Kolkata');

$dbUser	=	($_SERVER['HTTP_HOST']=='13.200.251.117') ? 'root' : $_SESSION['dbuser'];
$dbPass	=	($_SERVER['HTTP_HOST']=='13.200.251.117') ? '' : $_SESSION['dbpass'];

define("DB_HOST", '13.200.251.117');
define("DB_USER", $dbUser);
define("DB_PASS", $dbPass);
define("DB_NAME", $_SESSION['SESS_MEMBER_DBNAME']);


try {
	$bdd = new PDO("mysql:host=13.200.251.117;dbname=".DB_NAME.";charset=utf8", $dbUser, $dbPass);
} catch(Exception $e) {
	die('Erreur : '.$e->getMessage());
}
