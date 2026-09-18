<?php
require_once('../../login/auth.php');
require_once('../../login/configi.php');
//require_once('../function.php');
session_start();

$data	=	json_decode(file_get_contents('php://input'), true);
	//$yearId	=	$_SESSION['YEAR_ID'];
	$yearId	=	$_SESSION['YEAR_ID'];
	$selclass	= $data['selclass'];
	
	if($selclass ==0)
	{
		/*$query	=	" SELECT T1.ADMISSION_ID, T1.NAME, T2.Standard AS STD, T2.Section AS SEC, T3.term_I AS term1, T3.term_II AS term2, T3.term_III AS term3
		FROM 
		v_studentlist T1, tbl_class T2, van_stage T3, van_stud_map T4
		WHERE T1.ADMISSION_ID = T4.adno AND T2.CLASS_ID = T1.CLASS_ID AND T4.stage_id = T3.id and T3.Year_Id ='".$yearId."' and T4.Year_Id = '".$yearId."'
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID ASC ";*/
		$query	= "SELECT T1.ADMISSION_ID, T1.NAME, T1.Standard AS STD, T1.Section AS SEC,T3.stage_name, T3.term_I AS term1, T3.term_II AS term2, T3.term_III AS term3
		FROM v_studentlist T1, van_stage T3, van_stud_map T4
		WHERE T1.ADMISSION_ID = T4.adno
		AND T4.stage_id = T3.id
		AND T1.Year_id =  '".$yearId."' AND T4.Year_id =  '".$yearId."' AND T3.Year_id =  '".$yearId."'
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID ASC ";
	}
	else
	{
		$query	=	" SELECT T1.ADMISSION_ID, T1.NAME, T2.Standard AS STD, T2.Section AS SEC,T3.stage_name, T3.term_I AS term1, T3.term_II AS term2, T3.term_III AS term3
		FROM 
		v_studentlist T1, tbl_class T2, van_stage T3, van_stud_map T4
		WHERE T1.ADMISSION_ID = T4.adno AND T2.CLASS_ID = T1.CLASS_ID AND T4.stage_id = T3.id and T2.CLASS_ID = '".$selclass."' 
		and T3.Year_Id ='".$yearId."' and T4.Year_Id = '".$yearId."'
		ORDER BY T1.CLASS_ID, T1.ADMISSION_ID ASC ";

	}
$result	=	$mysqli->query($query);
$arr = array();
if($result) {
	$sno = 0;
/*$subamount	= 0;
$subpaid= 0;
$subbalance= 0;*/
	while($row = $result->fetch_assoc()) {
		$sno++;		
		$paid_amount = "SELECT sum(amount) as TOT_PAID FROM `van_feetransection` where admission_id ='".$row['ADMISSION_ID']."' and Year_Id = '".$yearId."'";
		$result1	=	$mysqli->query($paid_amount);
		$row1 	= 	$result1->fetch_assoc();		
		$narr = array();				
		//$narr['SNO']		=	$sno;
		$narr['ADNO']		=	$row['ADMISSION_ID'];
		$narr['NAME']		=	$row['NAME'];
		//$narr['STD_SEC']	=	$row['STD'].($row['SEC']) ? '-'.$row['SEC'] : '';
		$narr['STD']	    =	$row['STD']; 
		$narr['SEC']	    =	$row['SEC'];		
		$narr['STD_SEC']	= 	$narr['STD'].'-'.$narr['SEC'];
		$narr['stage_name']	=	$row['stage_name'];
		$narr['term1']		=	$row['term1'];
		$narr['term2']		=	$row['term2'];	
		$narr['term3']		=	$row['term3'];
		$narr['total']		=	$narr['term1']+$narr['term2']+$narr['term3'];
		$narr['total_paid']	=	$row1['TOT_PAID'];
		$narr['balance']	=	$narr['total']-$narr['total_paid'];
		/*$subamount  += $narr['total'];
		$subpaid	+= $narr['total_paid'];
		$subbalance += $narr['balance'];*/
		
		$arr[] 				= 	$narr;
	}
}
$tarr = array_merge(array('result'=>$arr));
//$tarr = array_merge(array('result'=>$arr), array('SUB_TOTAL' => $subamount, 'SUB_BAL_TOTAL' => $subbalance, 'SUB_PAID_TOTAL' => $subpaid));

$json_response = json_encode($tarr);

echo $json_response;


exit;


?>
	