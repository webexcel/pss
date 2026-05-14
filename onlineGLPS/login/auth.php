<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	//Start session
	session_start();
	//Check whether the session variable mobile is present or not
	if(!isset($_SESSION['mobile'])) {
		header("location: ../index.php");
		exit();
	}
	else{
		$_SESSION['mobile'];
	}
	session_write_close();
?>