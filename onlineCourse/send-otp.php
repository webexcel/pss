<?php 
session_start();
require('configi.php');
$adno	= trim($_POST['adno']);	
$yearid	= '6';
	
$qry 	= "SELECT * FROM `v_course` where Year_Id = '".$yearid."' and `adno` = '".$adno."' and `status` = '0'";
$result	= $dbconnect->query($qry) or $dbconnect->error;
	if($result -> num_rows > 0)
	{
		$row = mysqli_fetch_assoc($result); 
		$_SESSION['adno'] = $row['adno'];
		$_SESSION['Year_Id'] = $yearid;
		header("Location:fee-details-new1.php");	
	}
	else
	{
		echo "Invalid Number: " .$mysqli -> error;
		header('Location:index.php?valid=0');
	}
	
?>