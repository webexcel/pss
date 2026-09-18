<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	//error_reporting(0);
	
	
$data = array();
 //Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

$class=$_POST['section'];
$yearId		=	$_SESSION['YEAR_ID'];
 if($class!=""){
	 	$abslist = "SET @r=0";
		//$abslistq = "UPDATE `student_info1`  SET `rollNumber`= (SELECT @r := @r+1) WHERE `CLASS_ID`=$class AND `stuStatus` = '1' ORDER BY  `Group`, `IILanguage`, `NAME` ASC";
		echo $abslistq = "UPDATE `student_class_map` T1 SET `T1`.`rollNumber`= (SELECT @r := @r+1) FROM `v_studentlist` T2
		WHERE `T2`.`CLASS_ID`='".$class."' AND `T2`.`Year_Id` = '".$yearId."' AND `T1`.`NAME` = `T2`.`NAME` ORDER BY  `T2`.`NAME` ASC";
	
	}
	 $abslistexe = mysql_query($abslist);
	echo $abslistexeq = mysql_query($abslistq);
	
	
	?>
	