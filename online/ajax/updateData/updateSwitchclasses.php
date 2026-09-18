<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
require_once("../function.php");

$data	 =	json_decode(file_get_contents('php://input'), true);
$cnt 	 =	count($data);
$yearId	 =	$_SESSION['YEAR_ID'];

	if( $cnt > 0 ) {

		$SwitchCid	=	trim($data['promo']['promosection']);
		$pAdnoid	=	$data['adno'];
		print_r($pAdnoid);

		$query		= " SELECT `CLASS_ID`,`Standard`,`Section` FROM `tbl_class` where `CLASS_ID` =  '".$SwitchCid."' ";
		$result		= $mysqli->query($query);
		$row   		= $result->fetch_assoc();
		$cid		= $row['CLASS_ID'];
		$std		= $row['Standard'];
		$sec		= $row['Section'];				
		$classsec   = $std.'-'.$sec;
		
		$query1	= "update student_class_map set `class_id` = '".$cid."',`Standard` = '".$std."',`Section` = '".$sec."',`CLASSSEC` = '".$classsec."' WHERE Year_Id = '".$yearId."' AND Admission_No IN ('" . implode("','", $pAdnoid) . "')";
		$result1 =	$mysqli->query($query1);
		
		$query2	= "update fee_receipt set `CLASS_ID` = '".$cid."' WHERE YEAR_ID = '".$yearId."' AND ADMISSION_ID IN ('" . implode("','", $pAdnoid) . "')";
		$result2 =	$mysqli->query($query2);

		$query3	= "update feestatus set `classId` = '".$cid."' WHERE Year_Id = '".$yearId."' AND Admission_Id IN ('" . implode("','", $pAdnoid) . "')";
		$result3 =	$mysqli->query($query3);
		
		if($result3) {
				$arr =	array('Status' => true, 'message' => 'Student Class Change Successfully');
		} else {
				$arr =	array('Status' => false, 'message' => 'failled');
		}

	} else {
		$arr	=	array('Status' => false, 'message' => 'failled1');
	}

$json_response = json_encode($arr);
echo $json_response;
?>