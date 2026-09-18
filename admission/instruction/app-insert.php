<?php 
session_start();
require_once('configi.php');
/*
echo "<pre>";
print_r($_POST);
exit;
*/

$applied		=	trim($_POST['AppliedForKGS']);

if($applied =='I'){
	$II_L			=	'TAMIL';
	$III_L			=	'HINDI';
	$int_course		=	'N';
}elseif($applied == 'II'){
	$II_L			=	'TAMIL';
	$III_L			=	'HINDI';
	$int_course		=	'N';
}
elseif($applied == 'III'){
	$II_L			=	'TAMIL';
	$III_L			=	'HINDI';
	$int_course		=	'N';
}
elseif($applied == 'IV'){
	$II_L			=	'TAMIL';
	$III_L			=	'HINDI';
	$int_course		=	'N';
}
elseif($applied == 'V'){
	$II_L			=	'TAMIL';
	$III_L			=	'HINDI';
	$int_course		=	'N';
}
elseif($applied == 'IX'){
	$II_L			=	trim($_POST['II_L']);
	$III_L			=	'NIL';
	$int_course		=	trim($_POST['int_course']);
}else{
	$II_L			=	trim($_POST['II_L']);
	$III_L			=	trim($_POST['III_L']);
	$int_course		=	'N';
}
	
$name			=	addslashes($_POST['StudentName']);
$bg				=	trim($_POST['BloodGroup']);
$dob1			=	trim($_POST['strDOB']);
$dob  		    =   date("Y-m-d", strtotime($dob1));
$gender			=	trim($_POST['Gender']);
$nationality	=	trim($_POST['drpNationality']);
$religion		=	trim($_POST['drpReligion']);
$community		=	addslashes($_POST['Community']);
$mt				=	trim($_POST['drpMotherTongue']);
$schoolName   	=	addslashes($_POST['schoolName']);
$addressR		=	addslashes($_POST['AddressR']);
$emis			=	trim($_POST['EmisNo']);

$aadhar			=	trim($_POST['AadharNo']);
$contact		=	trim($_POST['MobileNo']);
$contact1		=	trim($_POST['MobileNo1']);
$Land   		=	trim($_POST['MobileNo2']);
$email			=	trim($_POST['Email_ID']);
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

$date		 	=   date('Y-m-d');


/*
	$file_name11 = rand(1111,9999).time().$_FILES['file1']['name'];
	$file_name1 = addslashes($file_name11);
	$filenewpath1 = 'var/www/pss/admission/instruction/crop/'.$file_name11;
	move_uploaded_file($_FILES['file1']['tmp_name'], $filenewpath1);
	
	$file_name21 = rand(1111,9999).time().$_FILES['file2']['name'];
	$file_name2 = addslashes($file_name21);
	$filenewpath2 = 'var/www/pss/admission/instruction/crop/'.$file_name21;
	move_uploaded_file($_FILES['file2']['tmp_name'], $filenewpath2);
	
	$file_name31 = rand(1111,9999).time().$_FILES['file3']['name'];
	$file_name3 = addslashes($file_name31);
	$filenewpath3 = 'var/www/pss/admission/instruction/crop/'.$file_name31;
	move_uploaded_file($_FILES['file3']['tmp_name'], $filenewpath3);
*/


	

	$query	= mysqli_query($dbconnect,"SELECT count(`fno`) as fno FROM `application`");
	$row 	= mysqli_fetch_assoc($query);
	$totalcount = $row['fno'];
	$totalcount1 = $totalcount+1;
	$insfno = "PS2026/".$totalcount1;
	
	$sql = "Select * from application where contact = '".$contact."' and dob = '".$dob."'";
	$query1 = mysqli_query($dbconnect, $sql);
	$row1 	= mysqli_fetch_assoc($query1);
	$con  = $row1['contact'];
	$dobs = $row1['dob'];
	
	
	
		if($con != $contact && $dobs != $dob ){
			$sqlapp	=  "INSERT INTO `application`(`fno`,`applied`, `name`, `bg`, `dob`, `gender`, `nationality`, `religion`, `community`, `mt`,`emis`,`II_L`,`III_L`,`schoolName`, `addressP`,`addressR`,`aadhar`,`landline`,`contact`,`contact1`, `email`, `fname`, `fquali`, `focc`, `fincome`,`foccdetails`, `mname`, `mquali`, `mocc`, `mincome`,`moccdetails`, `gname`, `gquali`, `gocc`, `gincome`,`goccdetails`, `distance`, `sname1`, `sname2`, `adno1`, `adno2`, `class1`, `class2`, `sec1`, `sec2`, `aname`, `yadno`, `yclass`, `ycom`, `cclass`,`int_course`, `ins_date`)
			VALUES ('".$insfno."','".$applied."','".$name."','".$bg."','".$dob."','".$gender."','".$nationality."','".$religion."',
			'".$community."','".$mt."','".$emis."','".$II_L."','".$III_L."','".$schoolName."','".$addressR."','".$addressR."',
			'".$aadhar."','".$Land."','".$contact."','".$contact1."','".$email."','".$fname."','".$fquali."','".$focc."','".$fincome."','".$foccdetails."','".$mname."','".$mquali."','".$mocc."','".$mincome."','".$moccdetails."','".$gname."','".$gquali."','".$gocc."','".$gincome."','".$goccdetails."','".$distance."','".$sname1."','".$sname2."','".$adno1."','".$adno2."','".$class1."','".$class2."','".$sec1."','".$sec2."','".$aname."','".$yadno."','".$yclass."','".$ycom."','".$cclass."','".$int_course."','".$date."')";					
			//exit;
			//$sqlapp	=  "INSERT INTO `application`(`fno`,`applied`, `name`, `bg`, `dob`, `gender`, `nationality`, `religion`, `community`, `mt`,`emis`,`II_L`,`III_L`,`schoolName`, `addressP`,`addressR`,`aadhar`,`landline`,`contact`,`contact1`, `email`,`photo`,`fphoto`,`mphoto`, `fname`, `fquali`, `focc`, `fincome`,`foccdetails`, `mname`, `mquali`, `mocc`, `mincome`,`moccdetails`, `gname`, `gquali`, `gocc`, `gincome`,`goccdetails`, `distance`, `sname1`, `sname2`, `adno1`, `adno2`, `class1`, `class2`, `sec1`, `sec2`, `aname`, `yadno`, `yclass`, `ycom`, `cclass`,`int_course`, `ins_date`)
			//VALUES ('".$insfno."','".$applied."','".$name."','".$bg."','".$dob."','".$gender."','".$nationality."','".$religion."','".$community."','".$mt."','".$emis."','".$II_L."','".$III_L."','".$schoolName."','".$addressR."','".$addressR."','".$aadhar."','".$Land."','".$contact."','".$contact1."','".$email."','".$file_name1."','".$file_name2."','".$file_name3."','".$fname."','".$fquali."','".$focc."','".$fincome."','".$foccdetails."','".$mname."','".$mquali."','".$mocc."','".$mincome."','".$moccdetails."','".$gname."','".$gquali."','".$gocc."','".$gincome."','".$goccdetails."','".$distance."','".$sname1."','".$sname2."','".$adno1."','".$adno2."','".$class1."','".$class2."','".$sec1."','".$sec2."','".$aname."','".$yadno."','".$yclass."','".$ycom."','".$cclass."','".$int_course."','".$date."')";					
			//exit;
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