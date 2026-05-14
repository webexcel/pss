<?php 
session_start();
require_once('configi.php');
$sel =	trim($_POST['wait']);
$id  = trim($_POST['idwait']);


	$selval = 3;
	if($selval == $sel)	
	{		
		$sqlapp =  "UPDATE `application_xi` SET `sel_list` = '".$sel."' where id = '".$id."'";	
		mysqli_query($dbconnect, $sqlapp);


		$result = mysqli_query($dbconnect,"SELECT * FROM `application_xi` WHERE id =".$id);
		$row 	= mysqli_fetch_assoc($result);
		header("Location: view.php");
		exit();
		
	}
	else{
		echo"Already Selected";
	}	
	

?>