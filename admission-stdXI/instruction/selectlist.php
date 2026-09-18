<?php 
session_start();
require_once('configi.php');

$sel =	trim($_POST['sel']);
$id  = trim($_POST['idsel']);

	$sqlapp =  "UPDATE `application_xi` SET `sel_list` = '".$sel."' where id = '".$id."'";	
	mysqli_query($dbconnect, $sqlapp);
	header("Location: view.php");
	exit();	
	

?>