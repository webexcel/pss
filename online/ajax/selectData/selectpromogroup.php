<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');

//$yearId	=	$_SESSION['YEAR_ID'];

//$query	=	"SELECT * FROM `feegroup` where Year_Id = '".$yearId."'";
$query	=	"SELECT `feeGroupId`,`feeGroup` FROM `feegroup`";

$result	=	mysqli_query($con, $query);
$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}
# JSON-encode the response
$json_response = json_encode($arr);
// # Return the response
echo $json_response;


?>