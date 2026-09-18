<?php

$dbconnect = new  mysqli('localhost','main','P@mani4u','pssenior'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
?>