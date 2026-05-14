<?php
require_once('../functions.php');	
session_start();
	
$dbhost = '13.200.251.117';
$dbuser = 'main';
$dbpass = 'P@mani4u';
$dbname = 'main';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);
date_default_timezone_set('Asia/Kolkata');
$script_tz = date_default_timezone_get();
	

//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = clean($_POST['loginn']);
	$password = clean($_POST['password']);
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Invalid Username';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Invalid Password';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ../index.php?lf=1");
		exit();
	}
	
		//Create query
		#$qry="SELECT * FROM members WHERE login='$login' AND passwd='$password'";

		#$qry="SELECT * FROM member_view WHERE UserName='$login' AND Password='$password'";

	
	if (strpos($login, '@') !== false) {
		
		$ulogin	=	substr($login, 4);
		
		$pos = strpos($login, '@');
		if( $pos == 3 ) {
			list($sCode, $sUname) = explode("@", $login);
			$qry	=	"SELECT * FROM member_view WHERE code = '".$sCode."' AND UserName = '". $sUname ."' AND Password = '". $password ."' AND Is_Migrated = 'N' ";	
		} else {
			$qry	=	"SELECT * FROM member_view WHERE UserName='$login' AND Password='$password'";
		}
		
	} 
	else {
		$qry	=	"SELECT * FROM member_view WHERE UserName = '". $login ."' AND Password = '". $password ."' AND Is_Migrated = 'Y' ";
	}
	
	//debug($qry, true);	
	$result	=	mysql_query($qry);
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			$member = mysql_fetch_assoc($result);
						
			#MULTIPLE USER LOGIN
			$_SESSION['MUSER_ID']	=	$member['UserId'];
			$_SESSION['CODE']		=	$member['code'];
	
			$_SESSION['IS_ADMIN']	=	$member['Is_Admin'];			
			$_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
			$_SESSION['SESS_MEMBER_DBNAME'] = $member['dbname'];
			$_SESSION['SCHOOL_NAME'] = $member['firstname'];
			//$_SESSION['USER_NAME'] = $member['login'];
			$_SESSION['firstname'] = $member['firstname'];
			$_SESSION['mail'] = $member['mail'];
			$_SESSION['dbuser'] = $member['dbuser'];
			$_SESSION['dbpass'] = $member['dbpass'];
			$_SESSION['smspasswd'] = $member['smspasswd'];
			$_SESSION['senderid'] = $member['senderid'];
			//$_SESSION['phone'] = $member['phone'];
			$_SESSION['valid'] = $member['valid'];
			$_SESSION['Type'] = $member['Type'];
			$_SESSION['credits'] = $member['credits'];
			$_SESSION['logo'] = $member['logo'];
			//$_SESSION['YEAR_ID'] = '1';
			
			
			$query = "SELECT max(`YearId`) as yearid, Sdate as Sdate, Edate as Edate FROM ".$member['dbname'].".`tbl_academicyear`";
			//exit();
			$result1 = mysql_query($query);
			$member1 = mysql_fetch_assoc($result1);
			$_SESSION['YEAR_ID'] = $member1['yearid'];
			$_SESSION['Sdate'] = $member1['Sdate'];
			$_SESSION['Edate'] = $member1['Edate'];
			
			
			
			$query1 = "SELECT * FROM ".$member['dbname'].".`configuration` WHERE `Config_Value` = '1'";
			$result2 = mysql_query($query1);
			$member2 = mysql_fetch_assoc($result2);
			$_SESSION['Config_Code'] = $member2['Config_Code'];
			/*
			$query1 = "SELECT * FROM ".$member['dbname'].".`configuration` WHERE `Config_Value` = '1'";
			$result2 = mysql_query($query1);
			$arr	=	array();
			while($row = mysql_fetch_array($result2)) {	
			$tmp	=	array();			
			$tmp['Config_Code'] = $row['Config_Code'];
			$_SESSION['Config_Code'] = $tmp['Config_Code'];
			
			$arr[]	= $tmp;
			}
			echo $_SESSION['Config_Code'];
			print_r($arr);*/
			//exit;
			
			session_write_close();
			$types = $_SESSION['Type'];

			header("location: ../dashboard.php");
			exit();
		}
		else 
		{
			//Login failed
			header("location: ../index.php?lf=1");
			exit();
		}
		
			
			//exit;
			//$result	=	$mysqli->query($query1);
			//$arr = array();
			//while( $row = $result2->fetch_assoc() ) {		
				//$tmp	=	array();
			//echo	$_SESSION[$row['Config_Code']] = $row['Config_Code'];
			//exit;
				//$_SESSION['Edate'] = $tmp;
				//$arr[]	= $tmp;
			//}
			
			
	}
	else 
	{
		die("Query failed");
	}
?>