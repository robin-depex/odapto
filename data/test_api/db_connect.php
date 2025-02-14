<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();
$uid = 1;
$fieldname = 'accessTocken';
$data = $db->get_user_details($uid,$fieldname);

echo $data;

?>