<?php

require_once('../../login/auth.php');
require_once('../../login/configi.php');

session_start();

$data	=	json_decode(file_get_contents('php://input'), true);
$adno 	=   $data['adno'];

$query	= " SELECT `FINE_ID`,`ADMISSION_ID`,`FEE_TYPE`,`AMOUNT`,`REMARKS`,`INSERT_DATE` FROM `fee_fine` WHERE `ADMISSION_ID` = '".$adno."' ";
$result	= $mysqli->query($query);
$query1 = "SELECT  `CLASSSEC`, `NAME`, `FATHER_NAME` FROM `v_studentlist` WHERE `ADMISSION_ID` = '".$adno."'";
$result1= $mysqli->query($query1);
$row1	= mysqli_fetch_assoc($result1);

	
$arr	=	array();
$arrs	=	array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;		
		$db 	= $_SESSION['SESS_MEMBER_DBNAME'];	
		$name	= $row1['NAME'].'.'.$row1['FATHER_NAME'];
		$names	= $row1['NAME'];
		$class  = $row1['CLASSSEC'];		
		$arrs[]	= $row;
	}
}
//$arr =array_merge($arrs,'U_PDF' => $_SESSION['SESS_MEMBER_DBNAME']);
$narr = array_merge(array('result'=>$arrs), array('U_PDF' => $db,'name' => $name,'names' => $names,'class' => $class));
$json_response = json_encode($narr);
// # Return the response
echo $json_response;


?>