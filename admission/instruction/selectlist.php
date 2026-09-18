<?php 
session_start();
require_once('configi.php');
/*
$sel =	trim($_POST['sel']);
$id  = trim($_POST['idsel']);


	$sqlapp =  "UPDATE `application` SET `sel_list` = '".$sel."' where id = '".$id."'";	
	mysqli_query($dbconnect, $sqlapp);
	header("Location: view.php");
	exit();	
	
*/

// basic validation
if (!isset($_POST['sel'], $_POST['idsel'])) {
    echo "Missing parameters";
    exit;
}

$sel = trim($_POST['sel']);
$ids = $_POST['idsel'];   // this MUST be an array (idsel[] in JS)

if (!is_array($ids) || count($ids) == 0) {
    echo "No IDs received";
    exit;
}

// clean status
$sel = mysqli_real_escape_string($dbconnect, $sel);

// clean IDs
$cleanIds = [];
foreach ($ids as $id) {
    $cleanIds[] = (int)$id;  // cast to int for safety
}

$idList = implode(',', $cleanIds);
if($sel == 4){
$sqlapp = "
    UPDATE `application`
    SET `sel_list` = '".$sel."',`sel_date` = now()
    WHERE id IN ($idList)
";
}else{
$sqlapp = "
    UPDATE `application`
    SET `sel_list` = '".$sel."'
    WHERE id IN ($idList)
";
}


if (mysqli_query($dbconnect, $sqlapp)) {
    echo "OK: Updated ".count($cleanIds)." record(s)";
} else {
    echo "DB Error: " . mysqli_error($dbconnect);
}
?>