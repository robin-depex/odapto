<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();
$uid = 69;
$dev_id = "BE5BA3D0-971C-4418-9ECF-E2D1ABC562BE";
$type = "android";
$status = $db->chkUserDevice($uid,$dev_id,$type);
if($status == 0){
	$data = array(
		'user_id' => $uid,
		'type' => $type,
		'device_id' => $dev_id
	);
	$db->insert('tbl_user_device',$data);
}

?> 