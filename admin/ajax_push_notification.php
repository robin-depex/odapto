<?php
session_start(); 
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$array=array(); 
$rows=array(); 
$listnotif = $db->listNotifUser($_SESSION['admin_id']);
//print_r($listnotif);
//print_r($listnotif[0]);
//print_r($listnotif[2]);
if(count($listnotif)>0)
{
        foreach ($listnotif as $key) {
    	$data['title'] = $key['notif_title'];
    	$data['msg'] = $key['notif_msg'];
    	$data['icon'] = 'https://www.odapto.com/images/logo.png';
    	$data['url'] = $key['notif_url'];
    	
    	$db->updateNotif($key['id']);
    	
    	$rows[] = $data;
    	// update notification database
    	//$nextime = date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s'))+($key['notif_repeat']*60));
    	//$db->updateNotif($key['id'],$nextime);
    }
    $array['notif'] = $rows;
    //$array['count'] = $listnotif[2];
    //$array['result'] = $listnotif[0];
    $array['result'] = true;
    echo json_encode($array);
    
}else{
    $array['result'] = false;
    echo json_encode($array);
}

?>