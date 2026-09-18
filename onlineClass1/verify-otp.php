<?php 
session_start();
$dbconnect = new  mysqli('localhost','main','P@mani4u','pssenior'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}
$id = trim($_GET['pid']);
$_SESSION['yearid']	= trim($_GET['Year_Id']);

$qry 	= "SELECT `id`,`otp` FROM `pay_login` where `id` = '".$id."'";
$result	= $dbconnect->query($qry) or $dbconnect->error;
  
	if($result -> num_rows > 0)
	{		
		$row = mysqli_fetch_assoc($result); 
		$_SESSION['pid'] = $row['id'];
		$_SESSION['adno'] = $row['otp'];
		header("Location:fee-details-new1.php");			
	}
	else
	{
		echo "Invalid OTP";
		header('Location:otp.php?valid=0');
	}	

?>
