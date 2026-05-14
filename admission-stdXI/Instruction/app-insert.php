<?php 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('configi.php');/*
echo "<pre>";
print_r($_POST);
print_r($_FILES);
exit;*/

$applied		=	trim($_POST['AppliedForKGS']);		
$name			=	addslashes($_POST['StudentName']);
$dob			=	trim($_POST['strDOB']);
$gender			=	trim($_POST['Gender']);
$community		=	addslashes($_POST['Community']);
$contact		=	trim($_POST['MobileNo']);
$contact1		=	trim($_POST['MobileNo1']);
$email			=	trim($_POST['Email_ID']);
$EmisNo   		=	trim($_POST['EmisNo']);
$basicstudy		=	trim($_POST['basicstudy']);
$schoolName		=	addslashes($_POST['schoolName']);
$addressP		=	addslashes($_POST['AddressP']);
$first			=	trim($_POST['first']);
$second			=	trim($_POST['second']);
$third			=	trim($_POST['third']);
$fourth			=	trim($_POST['fourth']);

$fname			=	addslashes($_POST['FatherName']);
$fquali			=	addslashes($_POST['FatherQualification']);
$focc			=	addslashes($_POST['FatherOccupation']);
$fincome		=	trim($_POST['FatherAnnualIncome']);
$foccdetails	=	addslashes($_POST['FatherOccDetail']);
$mname			=	addslashes($_POST['MotherName']);
$mquali			=	addslashes($_POST['MotherQualification']);
$mocc			=	addslashes($_POST['MotherOccupation']);
$mincome		=	trim($_POST['MotherAnnualIncome']);
$moccdetails	=	addslashes($_POST['MotherOccDetail']);
$gname			=	addslashes($_POST['GuardianName']);
$gquali			=	addslashes($_POST['GuardianQualification']);
$gocc			=	addslashes($_POST['GuardianOccupation']);
$gincome		=	trim($_POST['GuardianAnnualIncome']);
$goccdetails	=	addslashes($_POST['GuardianOccDetails']);
$adno1			=	trim($_POST['SiblingsAdmissionNo1']);
$class1			=	trim($_POST['SiblingsClass1']);
$sec1			=	trim($_POST['SiblingsSection1']);
$date		 	=   date('Y-m-d');

	$query	= mysqli_query($dbconnect,"SELECT count(`fno`) as fno FROM `application_xi`");
	$row 	= mysqli_fetch_assoc($query);
	$totalcount = $row['fno'];
	$totalcount1 = $totalcount+1;
	$insfno = "XI26/".$totalcount1;
	
	$sql = "Select * from `application_xi` where `contact` = '".$contact."' and `dob` = '".$dob."'";
	$query1 = mysqli_query($dbconnect, $sql);
	$row1 	= mysqli_fetch_assoc($query1);
	$con  = $row1['contact'];
	$dobs = $row1['dob'];

		if($con != $contact && $dobs != $dob ){	
			$sqlapp	=  "INSERT INTO `application_xi`(`fno`,`applied`, `name`, `dob`, `gender`,`community`, `addressP`,
			`basicstudy`,`schoolName`,`emis`,`contact`,`contact1`, `email`,`fname`, `fquali`, `focc`, `fincome`,`foccdetails`,
			 `mname`, `mquali`, `mocc`, `mincome`,`moccdetails`, `gname`, `gquali`, `gocc`, `gincome`,`goccdetails`,
			 `adno1`, `class1`, `sec1`, `first`, `second`, `third`, `fourth`,`ins_date`)
			VALUES ('".$insfno."','".$applied."','".$name."','".$dob."','".$gender."','".$community."','".$addressP."',
			'".$basicstudy."','".$schoolName."','".$EmisNo."','".$contact."','".$contact1."','".$email."',
			'".$fname."','".$fquali."','".$focc."','".$fincome."','".$foccdetails."','".$mname."','".$mquali."',
			'".$mocc."','".$mincome."','".$moccdetails."','".$gname."','".$gquali."','".$gocc."','".$gincome."','".$goccdetails."',
			'".$adno1."','".$class1."','".$sec1."','".$first."','".$second."','".$third."','".$fourth."',
			'".$date."')";				
			
			mysqli_query($dbconnect, $sqlapp);	
			$last_id = mysqli_insert_id($dbconnect);
			$_SESSION['curapplicationid'] = $last_id;
			header("Location: print.php?id=$last_id");
			exit();
		}
		else{
			echo "Duplicate date of birth and Mobile number.Already inserted";
		}
	
?>