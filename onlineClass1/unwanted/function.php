<?php
//require_once('../login/auth.php');
//require_once('../login/config-mysqli.php');

$sqlFeeHeads	=	" SELECT * FROM `feesettings` WHERE `Settings` = 'Monthly' ";
$exeFeeHeads	=	$mysqli->query($sqlFeeHeads);

$resFeeHeads	=	$exeFeeHeads->fetch_assoc();
$desc	=	$resFeeHeads['Description'];




function getQuotientAndRemainder($divisor, $dividend) {
    $quotient = (int)($divisor / $dividend);
    $remainder = $divisor % $dividend;
    return array( $quotient, $remainder );
}
function getFeeDetailsByAdno($mysqli, $adno) {
	$sqlFeeDetails	=	" SELECT `feeheadId`, `feehead`, `feetype`, `interval`, `feeamount`, `instalment` FROM `v_fees` WHERE `CLASS_ID` = (SELECT `CLASS_ID` FROM `v_studentlist` WHERE `ADMISSION_ID` = '".$adno."' ) ";
	$exeFeeDetails	=	$mysqli->query($sqlFeeDetails);
	$cntFeeDetails	=	$exeFeeDetails->num_rows;
	$arr	=	array();
	if( $cntFeeDetails > 0 ) {
		while( $row = $exeFeeDetails->fetch_assoc() ) {
			$arrFeeDetails = array();
			$arrFeeDetails['FEE_HEAD_ID']	=	$row['feeheadId'];
			$type							=	$row['feetype'];
			$paidPeriod		=	fPaidPeriod($type);
			$arrFeeDetails['FEE_TYPE']		=	$row['feeheadId'];
			$arrFeeDetails['PAID_PERIOD']	=	$paidPeriod;
			$arrFeeDetails['BALANCE_AMOUNT']=	$row['instalment'];
			$arr[] = $arrFeeDetails;
		}
	}
	return $arr;
}
function number2Month($abc) {
	global $arrMonth1;
	return $arrMonth1[$abc];
}
function month2Number($xyz) {
	global $arrMonth2;
	
	return $arrMonth2[$xyz];
}

function number2Term($abc) {
	global $arrTerm1;
	
	return $arrTerm1[$abc];
}
function term2Number($xyz) {
	global $arrTerm2;
	
	return $arrTerm2[$xyz];
}


function monthPeriod($cm) {
	global	$arrMonth2;
	
	//$arrMonth2	=	array("1" => "JUN", "2" => "JUL", "3" => "AUG", "4" => "SEP", "5" => "OCT", "6" => "NOV", "7" => "DEC", "8" => "JAN", "9" => "FEB", "10" => "MAR");
	
	return $arrMonth2[$cm];
}

function month2Num($cm) {
	global	$arrMonth1;
	
	//$arrMonth1	=	array("JUN" => '1', "JUL" => '2', "AUG" => '3', "SEP" => '4', "OCT" => '5', "NOV" => '6', "DEC" => '7', "JAN" => '8', "FEB" => '9', "MAR" => '10');
	
	return $arrMonth1[$cm];
}

function curTerm($cm) {
	$curMonVal	=	monthPeriod($cm);

	$curTerm	=	"";
	if( $curMonVal >= 1 && $curMonVal <= 4 ) {			//	First Term 4 Month from starting month
		$curTerm	=	"T1";
	} else if( $curMonVal >= 5 && $curMonVal <= 7 ) {	//	Second Term 3 Month
		$curTerm	=	"T2";
	} else if( $curMonVal >= 8 && $curMonVal <= 10 ) {	//	Third Term	3 Month
		$curTerm	=	"T3";
	}
	
	return $curTerm;
}

function cPaidPeriod($type, $xyz) {
	switch ($type) {
		case "Monthly":		//	Should be maintain the feetype in db
			$cPaidPeriod	=	month2Num($xyz);
			break;
		case "Term":		//	Should be maintain the feetype in db
			$cPaidPeriod	=	curTerm(month2Num($xyz));
			break;
		case "Annual":		//	Should be maintain the feetype in db
			$cPaidPeriod	=	'A1';
			break;
		default:
			$cPaidPeriod	=	'';
			break;
	}	
	return $cPaidPeriod;
}

function term2Month($tm) {
	switch ($tm) {
		case "T1":		
			$tMonth	=	1;
			break;
		case "T2":		
			$tMonth	=	2;
			break;
		case "T3":		
			$tMonth	=	3;
			break;
	}	

	
	return $tMonth;
}

function fPaidPeriod($type) {
	global	$arrMonth1;
	
	//$curMonth	=	strtoupper(date("M"));
	$curMonth	=	$arrMonth1[1];
	
	switch ($type) {
		case "Monthly":		//	Should be maintain the feetype in db
			$paidPariod	=	$curMonth;
			break;
		case "Term":		//	Should be maintain the feetype in db
			$paidPariod	=	curTerm($curMonth);
			break;
		case "Annual":		//	Should be maintain the feetype in db
			$paidPariod	=	'A1';
			break;
	}
	
	
	return $paidPariod;
}



function calBalance($type, $lPaid, $interval, $instalment, $preBalance) {
	$cMonth	=	strtoupper(date("M"));
	$cMonth	=	"JUN";

	switch ($type) {
		case "Monthly":
			$duePeriod	=	month2Number($cMonth) - month2Number($lPaid);
			$cBal		=	($duePeriod * $instalment) + $preBalance;
			break;
		case "Term":
			$lPaidTerm	=	term2Month($lPaid);
			$cPaidTerm	=	term2Month(curTerm($cMonth));
			$duePeriod	=	$cPaidTerm - $lPaidTerm;
			
			$cBal		=	($duePeriod * $instalment) + $preBalance;
			break;
		case "Annual":
			$cBal		=	$preBalance;
			break;
		case "PENDING":
			$cBal		=	$preBalance;
			break;
	}
	
	return $cBal;
	
}

function lastPaidMonth($m) {
	switch ($m) {
		case "01":
			$month	=	"JAN";
			break;
		case "02":
			$month	=	"FEB";
			break;
		case "03":
			$month	=	"MAR";
			break;
		case "04":
			$month	=	"APR";
			break;
		case "05":
			$month	=	"MAY";
			break;
		case "06":
			$month	=	"JUN";
			break;
		case "07":
			$month	=	"JUL";
			break;
		case "08":
			$month	=	"AUG";
			break;
		case "09":
			$month	=	"SEP";
			break;
		case "10":
			$month	=	"OCT";
			break;
		case "11":
			$month	=	"NOV";
			break;
		case "12":
			$month	=	"DEC";
			break;
		default:
			$month	=	"NULL";
	}
	
	return $month;

}



?>