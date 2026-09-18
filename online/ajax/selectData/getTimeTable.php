<?php
define(DB_HOST, 'localhost');
define(DB_USER, 'root');
define(DB_PASS, 'webexcel@123');
define(DB_NAME, 'pademo');


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}


$query	=	" SELECT  `day`, `period1`, `period2`, `period3`, `period4`, `period5`, `period6`, `period7`, `period8` FROM `time_table` WHERE 1 ";
$result	=	$mysqli->query($query);

$arr = array();
if($result->num_rows > 0) {
	$sno = 0;
	while($row = $result->fetch_assoc()) {
		$sno++;
		
		$arr[]	=	$row;
	}
}

echo "<pre>";
print_r($arr);


foreach( $arr as $key => $val ) {
	echo $val['day'] . "<br />";
	echo $val['period1'] . "<br />";

}



exit;



# JSON-encode the response
//$json_response = json_encode($arr);
$json_response = json_encode($pnarr);

// # Return the response
echo $json_response;


exit;





?>
	