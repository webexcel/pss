<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
session_start();

$data   =   json_decode(file_get_contents('php://input'), true);
	
$section	=	trim($data['section']);
$yearId		=	$_SESSION['YEAR_ID'];
//$pyearId 	=   $yearId-1;
	
	$query	=	" SELECT * from v_studentlist T1 join student_info1 T2 on T1.ADMISSION_ID = T2.ADMISSION_ID  where T1.Year_Id = '".$yearId."' AND T1.CLASS_ID = '".$section."'";
	$result	=	$mysqli->query($query);

		$arr = array();
		if($result->num_rows > 0) {
			$sno = 0;
			while($row = $result->fetch_assoc()) {
				$sno++;
				$arr[]		=	$row;
			}
		}
		
	
	$query1	 =	"SELECT `rid` FROM `tbl_class` where `CLASS_ID` = '".$section."'";
	$result1 =	$mysqli->query($query1);
	$row1    =  $result1->fetch_assoc();
	$rid 	 =  $row1['rid'];
	
	$query2	 =	" SELECT `CLASS_ID`,`Standard`,`Section` FROM `tbl_class` where `rid` = '".$rid."' ";
	$result2 =	$mysqli->query($query2);
	
		$arr1 = array();
		if($result2->num_rows > 0) {
			$sno = 0;
			while($row2 = $result2->fetch_assoc()) {
				$sno++;
				$arr1[]		=	$row2;
			}
		}

$tarr = array_merge(array('result'=>$arr), array('promot' => $arr1));

$json_response = json_encode($tarr);
echo $json_response;
exit;

?>
	