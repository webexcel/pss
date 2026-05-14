<?php 

require_once('configi.php');
$adno	= trim($_POST['mobile']);	
$yearid	= trim($_POST['yearid']);
	
$qry 	= "SELECT * FROM `v_studentlist` where Year_Id = '".$yearid."' and `ADMISSION_ID` = '".$adno."'";
$result	= $dbconnect->query($qry) or $dbconnect->error;
//print_r($result);
//exit;
  // if ($result) 
	//{ 
		if($result -> num_rows > 0)
		{
			$row = mysqli_fetch_assoc($result); 
			$mobile  = $row['contact'];
			$adno = $row['ADMISSION_ID'];
			
			/*$qry2 	= "SELECT sum(`Balance_Amount`) as bal FROM `feestatus` where Year_Id < '".$yearid."' and `Admission_Id` = '".$adno."'";
			$result2 = $dbconnect->query($qry2) or $dbconnect->error;
			$row2 	 = mysqli_fetch_assoc($result2); 
			$balAmt  = $row2['bal'];
				
			if ($balAmt != 0) {
				echo "Fees defaulter for Last Year";
				header('Location:index.php?valid1=1');
			}
			else{*/			
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
		
	/*} 
	else{
		echo "Invalid Number: " .$mysqli -> error;
		header('Location:index.php?valid=0');
	}
*/

function smsApiCall($mobile, $message)
{
	$sender = "SMSJAY";
	$message = urlencode($message);	
	$URL = "https://www.myvaluefirst.com/smpp/sendsms?username=schooltree&password=Schooltree@123&to=".$mobile."&from=".$sender."&text=".$message;
	$ch = curl_init();		
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,"msgType=UC");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000);
    $buffer = curl_exec($ch);
    curl_close($ch);
	
	return  $buffer;
}

	
?>