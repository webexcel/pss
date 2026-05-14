<?php 
session_start();
require_once('configi.php');
$id = trim($_GET['pid']);
//$otp = trim($_POST['otp']);
$_SESSION['yearid']	= trim($_GET['Year_Id']);

$qry 	= "SELECT `id`,`mobile` FROM `pay_login` where `id` = '".$id."'";
$result	= $dbconnect->query($qry) or $dbconnect->error;
  
  // if ($result) 
	//{ 
		if($result -> num_rows > 0)
		{		
			$row = mysqli_fetch_assoc($result); 
			$_SESSION['pid'] = $row['id'];
			$_SESSION['adno'] = $row['mobile'];
			header("Location:fee-details-new1.php");			
		}
		else
		{
			echo "Invalid OTP";
			header('Location:otp.php?valid=0');
		}	
	/*} 
	else{
		echo "Invalid OTP: " .$mysqli -> error;
		header('Location:otp.php?OTP=Invalid OTP');
	}*/

?>
