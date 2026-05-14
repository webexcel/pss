<?php
require_once('configi.php');
$id = $_POST['id'];
$fss = $_POST['status'];
if($fss == 'Y'){
	$fs = 'Y';
	
}else{
	$fs = 'N';
}

$sql = "UPDATE `application_xi` SET `fsubmit` = '$fs' ,`form_date` = now() WHERE `id` = $id";

if ($dbconnect->query($sql) === TRUE) {
    echo json_encode(['new_status' => $fs]);
} else {
    echo json_encode(['error' => 'Failed to update status']);
}

// Close the connection
$dbconnect->close();
?>
