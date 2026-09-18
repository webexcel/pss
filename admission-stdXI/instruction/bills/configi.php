<?php
date_default_timezone_set('Asia/Kolkata');

define("DB_HOST", 'schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com');
define("DB_USER", 'main');
define("DB_PASS", 'P@mani4u');
define("DB_NAME", 'pss_website');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
$mysqli -> set_charset("utf8");
?>