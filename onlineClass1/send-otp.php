<?php 
session_start();
$dbconnect = new  mysqli('localhost','main','P@mani4u','pssenior'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}
$adno	= trim($_POST['adno']);	
$yearid	= '5';
	
$qry 	= "SELECT * FROM `v_coachlist` where Year_Id = '".$yearid."' and `adno` = '".$adno."' and `status` = '0'";
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