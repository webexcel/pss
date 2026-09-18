<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');

$data	=	json_decode(file_get_contents('php://input'), true);

$yearId	=	$_SESSION['YEAR_ID'];



$class	=	($data['fdatas']['class']) ? $data['fdatas']['class'] : 'All';
$gender	=	($data['fdatas']['gender']) ? $data['fdatas']['gender'] : 'All';


$fDate	=	($data['fdatas']['dateFrom']) ? date("Y-m-d", strtotime($data['fdatas']['dateFrom'])) : "";
$tDate	=	($data['fdatas']['dateFrom']) ? date("Y-m-d", strtotime($data['fdatas']['dateTo'])) : "";

$where	=	" WHERE T1.`stuStatus` = '1' AND T2.Status = '1' ";

if( $class == "All" ) {
	$where .= "";
} else {
	$where .= " AND T1.CLASS_ID = '".$class."' ";
}

if( $gender == "All" ) {
	$where .= "";
} else {
	$where .= " AND T1.Gender = '".$gender."'";
}

if($fDate != "" && $tDate != "") {
	$where .= " AND T1.DOB BETWEEN '".$fDate."' AND '".$tDate."' ";
} else {
	$where .= "";	
}

//$query	=	" SELECT * FROM student_info1 WHERE CLASS_ID = '".$class."' AND Gender = '".$gender."' AND DOB BETWEEN '".$fDate."' AND '".$tDate."' ";
//$query	=	" SELECT T1.StId AS ST_ID, T1.`ADMISSION_ID`, T1.`CLASS_ID`, T1.`NAME`, T1.`FATHER_NAME`, T1.`DOB`, T1.`Gender` AS GENDER,  T2.Standard AS STANDARD,  T2.Section AS SECTIONO FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.CLASS_ID = T2.CLASS_ID WHERE T1.`stuStatus` = '1' AND T2.Status = '1' AND T1.CLASS_ID = '".$class."' AND T1.Gender = '".$gender."' AND T1.DOB BETWEEN '".$fDate."' AND '".$tDate."' ORDER BY `T1`.`CLASS_ID`, T1.ADMISSION_ID, T1.NAME ASC ";
$query	=	" SELECT T1.StId AS ST_ID, T1.`ADMISSION_ID`, T1.`CLASS_ID`, T1.`NAME`, T1.`FATHER_NAME`, T1.`DOB`, T1.`Gender` AS GENDER,  T2.Standard AS STANDARD,  T2.Section AS SECTIONO FROM `student_info1` T1 LEFT JOIN `tbl_class` T2 ON T1.CLASS_ID = T2.CLASS_ID ".$where." ORDER BY `T1`.`CLASS_ID`, T1.ADMISSION_ID, T1.NAME ASC ";


//echo $query . "\n";
$result	=	$mysqli->query($query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	
	while($row = $result->fetch_assoc()) {
		$sno++;
		
		$arr[] = $row;
	}
}

/*
echo "<pre>";
print_r($arr);
*/

# JSON-encode the response
$json_response = json_encode($arr);

# Return the response
echo $json_response;


exit;


?>
	