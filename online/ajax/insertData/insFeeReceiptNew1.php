<?php
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
define("DB_HOST", 'schooltree-prod.cfcyioeqyfml.ap-south-1.rds.amazonaws.com');
define("DB_USER", 'main');
define("DB_PASS", 'P@mani4u');
define("DB_NAME", 'pssenior');

$dbconnect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($dbconnect->connect_error) {
    die('Error : ('. $dbconnect->connect_errno .') '. $dbconnect->connect_error);
}

$dbconnect->set_charset("utf8");

$sqlInsFee = "select * from `razorpay` where `order_id` = '".$_POST['razorpay_order_id']."'";
//$sqlInsFee = "SELECT * FROM `razorpay` WHERE `order_id` = 'order_RiFpPcbMJBQ5kY'";
$exeInsFee = $dbconnect->query($sqlInsFee);

$postData = '';

if ($exeInsFee->num_rows > 0) {
    $row      = $exeInsFee->fetch_assoc();
    $postData = $row['paydetails'];

    // For debugging only:
    // echo $postData;
}

// If nothing found or empty JSON
if (empty($postData)) {
    die('No paydetails found for this order_id');
}

// Decode JSON as array
$myArray = json_decode($postData, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Invalid JSON in paydetails: ' . json_last_error_msg());
}

// Use the actual array to count
$data = isset($myArray['stuFeeDetails1']) && is_array($myArray['stuFeeDetails1'])
    ? $myArray['stuFeeDetails1']
    : [];

$cnt = count($data);

if ($cnt > 0) {

    $ADNO          = $data[0]['ADNO'];
    $classId       = $data[0]['CLASS_ID'];
    $YEAR_ID       = $data[0]['Year_Id'];
    $PAYMENT_DATE  = date("Y-m-d");
    $mobile        = $data[0]['contact'];
	$payment_id    = $_POST['razorpay_payment_id']; // ////// 
    $RECPNO        = ""; // //////Insert Id if razor table payment_id

    $sql = "SELECT * FROM `fee_receipt` WHERE `FEE_MODE_REF_NO` = '".$dbconnect->real_escape_string($payment_id)."'";
    $exe = $dbconnect->query($sql);
    $row = $exe->fetch_assoc();
    $p_id = $row['FEE_MODE_REF_NO'] ?? null;

    if ($p_id != $payment_id) {

        $sqlInsFeeReceipt = "
            INSERT INTO `fee_receipt`
                (`RECEIPT_NO`,`ADMISSION_ID`,`CLASS_ID`,`RECEIPT_DATE`,`FEE_MODE`,`FEE_MODE_REF_NO`,`YEAR_ID`)
            VALUES
                ('".$RECPNO."', '".$ADNO."', '".$classId."', '".$PAYMENT_DATE."', 'Online', '".$payment_id."', '".$YEAR_ID."')
        ";
        $exeInsFeeReceipt = $dbconnect->query($sqlInsFeeReceipt);
        $receptId         = $dbconnect->insert_id;

        // Make sure this exists and is an array
        if (!empty($myArray['stuFeeDetails']) && is_array($myArray['stuFeeDetails'])) {
            foreach ($myArray['stuFeeDetails'] as $item) {

                $FHeadID      = $item['FHeadID'];
                $FAsofBalance = $item['FAsofBalance'];
                $FSID         = $item['FSID'];

                if ($FHeadID != 14) {

                    if ($FAsofBalance !== '' && is_numeric($FAsofBalance)) {

                        $sqlInsFeeRecDetails = "
                            INSERT INTO `fee_transanction`
                                (`RECEIPT_ID`, `feeHead`, `Amount`, `Year_Id`)
                            VALUES
                                ('".$receptId."', '".$FHeadID."', '".$FAsofBalance."', '".$YEAR_ID."')
                        ";
                        $exeInsFeeRecDetails = $dbconnect->query($sqlInsFeeRecDetails);

                        $arr['success'] = $dbconnect->affected_rows;

                        // Update fee status
                        $sqlUpdFeesStatus = "
                            UPDATE `feestatus`
                            SET `Balance_Amount` = '0'
                            WHERE `FSID` = '".$FSID."' AND `Year_Id` = '".$YEAR_ID."'
                        ";
                        $exeUpdFeesStatus = $dbconnect->query($sqlUpdFeesStatus);

                    } else {
                        $arr['fail'] = '0';
                    }
                }
            }
        } else {
            $arr['fail'] = 'stuFeeDetails missing or invalid';
        }

    } else {
        echo "Payment already exist";
        $arr['message'] = "Payment already exist";
    }

    $json_response = json_encode($arr);
    echo $json_response;
}
?>
