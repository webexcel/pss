<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	
    $contents_id = $del_id;

    
    $data_to_update=array();
    $data_to_update['status'] = '1';
    $db = getDbInstance();
    $db->where('sn',$contents_id);
    $stat = $db->update('contents', $data_to_update);
    
    if ($stat) 
    {
        $_SESSION['info'] = "Contents deleted successfully!";
        header('location: contents.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete contents";
    	header('location: contents.php');
        exit;

    }
    
}