<?php 
session_start();
require_once('configi.php');/*
echo "<pre>";
print_r($_POST);
print_r($_FILES);
exit;*/

$applied		=	trim($_POST['AppliedForKGS']);		
$name			=	addslashes($_POST['StudentName']);
$bg				=	trim($_POST['BloodGroup']);
$dob1			=	trim($_POST['strDOB1']);
$dob2			=	trim($_POST['strDOB2']);
$dob3			=	trim($_POST['strDOB3']);
if($dob1 != ''){
	echo $dob  =   date("Y-m-d", strtotime($dob1));	
}else if($dob2 != ''){
	echo $dob  =   date("Y-m-d", strtotime($dob2));
}else if($dob3 != ''){
	echo $dob  =   date("Y-m-d", strtotime($dob3));
}else{
	echo $dob  =   '0000-00-00';
}

$nationality	=	trim($_POST['drpNationality']);
$religion		=	trim($_POST['drpReligion']);
$gender			=	trim($_POST['Gender']);
$community		=	addslashes($_POST['Community']);
$contact		=	trim($_POST['MobileNo']);
$contact1		=	trim($_POST['MobileNo1']);
$addressP		=	addslashes($_POST['AddressP']);
$Pincode   		=	trim($_POST['Pincode']);
$health   		=	trim($_POST['health']);
$email			=	trim($_POST['Email_ID']);
$aadhar   		=	trim($_POST['AadharNo']);

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
$distance		=	trim($_POST['Distance']);
$sname1			=	addslashes($_POST['SiblingsName1']);
$sname2			=	addslashes($_POST['SiblingsName2']);
$adno1			=	trim($_POST['SiblingsAdmissionNo1']);
$adno2			=	trim($_POST['SiblingsAdmissionNo2']);
$class1			=	trim($_POST['SiblingsClass1']);
$class2			=	trim($_POST['SiblingsClass2']);
$sec1			=	trim($_POST['SiblingsSection1']);
$sec2			=	trim($_POST['SiblingsSection2']);

$aname			=	addslashes($_POST['AName']);
$yadno			=	trim($_POST['YAdno']);
$yclass			=	trim($_POST['YClass']);
$ycom			=	trim($_POST['YCom']);
$cclass			=	trim($_POST['CClass']);
$alumni		    =	trim($_POST['SiblingStudied2']);

$date		 	=   date('Y-m-d');


    /*
	$file_name11 = rand(1111,9999).time().$_FILES['file1']['name'];
	$file_name1 = addslashes($file_name11);
	$filenewpath1 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name11;
	move_uploaded_file($_FILES['file1']['tmp_name'], $filenewpath1);
	
	$file_name21 = rand(1111,9999).time().$_FILES['file2']['name'];
	$file_name2 = addslashes($file_name21);
	$filenewpath2 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name21;
	move_uploaded_file($_FILES['file2']['tmp_name'], $filenewpath2);
	
	$file_name31 = rand(1111,9999).time().$_FILES['file3']['name'];
	$file_name3 = addslashes($file_name31);
	$filenewpath3 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name31;
	move_uploaded_file($_FILES['file3']['tmp_name'], $filenewpath3);
	
	$file_name41 = rand(1111,9999).time().$_FILES['file4']['name'];
	$file_name4 = addslashes($file_name41);
	$filenewpath4 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name41;
	move_uploaded_file($_FILES['file4']['tmp_name'], $filenewpath4);
	
	$file_name51 = rand(1111,9999).time().$_FILES['file5']['name'];
	$file_name5 = addslashes($file_name51);
	$filenewpath5 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name51;
	move_uploaded_file($_FILES['file5']['tmp_name'], $filenewpath5);
	
	$file_name61 = rand(1111,9999).time().$_FILES['file6']['name'];
	$file_name6 = addslashes($file_name61);
	$filenewpath6 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name61;
	move_uploaded_file($_FILES['file6']['tmp_name'], $filenewpath6);
	
	$file_name71 = rand(1111,9999).time().$_FILES['file7']['name'];
	$file_name7 = addslashes($file_name71);
	$filenewpath7 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name71;
	move_uploaded_file($_FILES['file7']['tmp_name'], $filenewpath7);
	
	$file_name81 = rand(1111,9999).time().$_FILES['file8']['name'];
	$file_name8 = addslashes($file_name81);
	$filenewpath8 = 'var/www/pss/admission-prekg/instruction/cropimg/'.$file_name81;
	move_uploaded_file($_FILES['file8']['tmp_name'], $filenewpath8);
	*/

	$query	= mysqli_query($dbconnect,"SELECT count(`fno`) as fno FROM `application_prekg`");
	$row 	= mysqli_fetch_assoc($query);
	$totalcount = $row['fno'];
	$totalcount1 = $totalcount+1;
	$insfno = "KG26/".$totalcount1;
	
	$sql = "Select * from `application_prekg` where `contact` = '".$contact."' and `dob` = '".$dob."'";
	$query1 = mysqli_query($dbconnect, $sql);
	$row1 	= mysqli_fetch_assoc($query1);
	$con  = $row1['contact'];
	$dobs = $row1['dob'];

		if($con != $contact && $dobs != $dob ){	
			/*
			$sqlapp	=  "INSERT INTO `application_prekg`(`fno`,`applied`, `name`, `bg`, `dob`, `gender`,`nationality`,`religion`, `community`, `addressP`,`aadhar`,`pincode`,`health`,`contact`,`contact1`, `email`,`photo`,`fphoto`,
			`fqphoto`,`mqphoto`,`fophoto`,`mophoto`,`fiphoto`,`miphoto`,`fname`, `fquali`, `focc`, `fincome`,`foccdetails`, `mname`, `mquali`, `mocc`, `mincome`,`moccdetails`, `gname`, `gquali`, `gocc`, `gincome`,`goccdetails`, `distance`, `sname1`, `sname2`, `adno1`, `adno2`, `class1`, `class2`, `sec1`, `sec2`, `aname`, `yadno`, `yclass`, `ycom`, `cclass`,`alumni`, `ins_date`)
			VALUES ('".$insfno."','".$applied."','".$name."','".$bg."','".$dob."','".$gender."','".$nationality."','".$religion."','".$community."','".$addressP."','".$aadhar."','".$Pincode."','".$health."','".$contact."','".$contact1."','".$email."',
			'".$file_name1."','".$file_name2."','".$file_name3."','".$file_name4."','".$file_name5."','".$file_name6."',
			'".$file_name7."','".$file_name8."','".$fname."','".$fquali."','".$focc."','".$fincome."','".$foccdetails."','".$mname."','".$mquali."','".$mocc."','".$mincome."','".$moccdetails."','".$gname."','".$gquali."','".$gocc."','".$gincome."','".$goccdetails."','".$distance."','".$sname1."','".$sname2."','".$adno1."','".$adno2."','".$class1."','".$class2."','".$sec1."','".$sec2."','".$aname."','".$yadno."','".$yclass."','".$ycom."','".$cclass."','".$alumni."','".$date."')";					
			*/
			$sqlapp	=  "INSERT INTO `application_prekg`(`fno`,`applied`, `name`, `bg`, `dob`, `gender`,`nationality`,`religion`, `community`, `addressP`,`aadhar`,`pincode`,`health`,`contact`,`contact1`, `email`,
			`fname`, `fquali`, `focc`, `fincome`,`foccdetails`, `mname`, `mquali`, `mocc`, `mincome`,`moccdetails`, `gname`, `gquali`, `gocc`, `gincome`,`goccdetails`, `distance`, `sname1`, `sname2`, `adno1`, 
			`adno2`, `class1`, `class2`, `sec1`, `sec2`, `aname`, `yadno`, `yclass`, `ycom`, `cclass`,`alumni`, `ins_date`)
			VALUES ('".$insfno."','".$applied."','".$name."','".$bg."','".$dob."','".$gender."','".$nationality."','".$religion."','".$community."','".$addressP."','".$aadhar."','".$Pincode."','".$health."','".$contact."','".$contact1."','".$email."',
			'".$fname."','".$fquali."','".$focc."','".$fincome."','".$foccdetails."','".$mname."','".$mquali."','".$mocc."','".$mincome."','".$moccdetails."','".$gname."','".$gquali."','".$gocc."','".$gincome."','".$goccdetails."','".$distance."',
			'".$sname1."','".$sname2."','".$adno1."','".$adno2."','".$class1."','".$class2."','".$sec1."','".$sec2."','".$aname."','".$yadno."','".$yclass."','".$ycom."','".$cclass."','".$alumni."','".$date."')";					
			
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