<?php 

require_once('configi.php');
$adno	= trim($_POST['mobile']);	
$yearid	= trim($_POST['yearid']);
	
$qry 	= "SELECT * FROM `v_studentlist` where Year_Id = '".$yearid."' and `ADMISSION_ID` = '".$adno."'";
$result	= $dbconnect->query($qry) or $dbconnect->error;

		if($result -> num_rows > 0)
		{
			$row = mysqli_fetch_assoc($result); 
			$mobile  = $row['contact'];
			$adno = $row['ADMISSION_ID'];
		
				$userotp = rand(1111,9999);
				$message = "Dear Parent, Your OTP ".$userotp.".PALERT";
				$ipAddress = $_SERVER['REMOTE_ADDR'];
				//smsApiCall($mobile, $message);
				$qry1 	= "INSERT INTO `pay_login`(`mobile`, `otp`,`ipAddress`) VALUES ('".$adno."','".$userotp."','".$ipAddress."')";			
				
				mysqli_query($dbconnect, $qry1);	
				$last_id = mysqli_insert_id($dbconnect);
				$_SESSION['pid'] = $last_id;
				header("Location: verify-otp.php?pid=$last_id&Year_Id=$yearid");
			//}
		}
		else
		{
			echo "Invalid Number: " .$mysqli -> error;
			header('Location:index.php?valid=0');
		}



	
?>