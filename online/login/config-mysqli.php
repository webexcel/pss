<?php
date_default_timezone_set('Asia/Kolkata');
define("DB_HOST", 'schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com');
define("DB_USER", 'main');
define("DB_PASS", 'P@mani4u');
define("DB_NAME", 'pssenior');
$con =	mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ('Error connecting to SQL');
?>
