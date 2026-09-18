<?php
require_once('../../login/auth.php');
require_once('../../login/config-mysqli.php');

/*
define('DB_HOST', 'localhost');
define('DB_NAME', 'palert');
define('DB_USERNAME', 'root');

$db_pass	=	($_SERVER['HTTP_HOST']=='localhost') ? '' : 'webexcel@123';
define('DB_PASSWORD', $db_pass);


$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if( mysqli_connect_error()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
*/

$query	=	"SELECT `exam_type_id`, `exam_type_name` FROM `tbl_exam_type` ORDER BY `exam_type_id` ASC";
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