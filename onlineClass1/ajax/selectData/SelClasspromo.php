<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');
$query	=	"SELECT CLASS_ID, CONCAT(Standard, '-', Section) AS CLASS_SECTION, subject_id FROM tbl_class WHERE Status = '1' ORDER BY feeGrpId";
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