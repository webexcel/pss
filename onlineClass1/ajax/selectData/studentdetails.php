<?php
//require_once('../../login/auth.php');
//require_once('../../login/config-mysqli.php');

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');

$db_pass	=	($_SERVER['HTTP_HOST']=='localhost') ? '' : 'webexcel@123';
define('DB_PASSWORD', $db_pass);

define('DB_NAME', 'shebha');


$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}


//$_GET	=	json_decode(file_get_contents('php://input'), true);

if( isset($_GET['mobileno']) && $_GET['mobileno'] != '' ) {
	$mobileno	=	trim($_GET['mobileno']);
} else {
	$mobileno	=	"9585900966";
}


if( $mobileno != "" ) {
	$query		=	"SELECT `CLASSSEC` `ADNO`, `STUDENTNAME`, `fathers_name`, `gender`, `mobile_number`, `dob` FROM `master` WHERE `mobile_number` = '".$mobileno."'";
	$results	=	$mysqli->query($query);
	$cntResults	=	$results->num_rows;
	if( $results->num_rows > 0 ) {
		while($row = $results->fetch_assoc()) {
			$arrStudents[] = $row;
		}
	} else {
		$arrStudents['error']	=	"No details found.";
	}
	$results->free();
} else {
	$arrStudents['error']	=	"No details found.";
}
$mysqli->close();

# JSON-encode the response
$json_response = json_encode(array("students" => $arrStudents));

// # Return the response
echo $json_response;


?>