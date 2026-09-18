<?php
	require_once('../../login/auth.php');
	require_once('../../login/config.php');
	error_reporting(0);
	
	$route = "SELECT * FROM veh_routes where `status` = '1'  ";
	$exeroute	=	$mysqli->query($route);
	$arrayfee = array();
	while( $row = $exeroute->fetch_assoc() ) {
		$arrayroute['route'][] = $row;
	}
	print json_encode($arrayroute);
	?>