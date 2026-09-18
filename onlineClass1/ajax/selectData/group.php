<?php
	require_once('../../login/auth.php');
	//Include database connection details
	require_once('../../login/config.php');
	error_reporting(0);
	session_start();
	
	$yearId		=	$_SESSION['YEAR_ID'];
	
//$result = mysql_query("SELECT Standard, `Section`, grp, COUNT(`grp`) AS NoStudent FROM `v_studentlist` WHERE grp!='' GROUP BY `grp`, `CLASS_ID` ORDER BY `CLASS_ID` ASC");
$result = mysql_query("SELECT T1.CLASSSEC, T2.groupName AS grp, COUNT( T1.`Group` ) AS NoStudent
FROM  `v_studentlist` T1,  `tbl_group` T2
WHERE T1.`Group` = T2.groupId
AND T1.`Group` !=  ''
AND T1.Year_Id = '".$yearId."'
GROUP BY T1.`CLASSSEC`,T1.`Group`
ORDER BY T1.`CLASS_ID` ASC");

while($row = mysql_fetch_array($result)) {
	
	$classsec[] = $row;
}
	print json_encode($classsec);


	?>