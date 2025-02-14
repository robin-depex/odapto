<?php  
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();
	
if(isset($_REQUEST['data'])){
	$com_id = $_REQUEST['data'];
	$condition = array("card_id"=>$com_id);
	$update_data = array("del_status"=>1); 
	$update = $db->update("tbl_board_list_card",$update_data, $condition);
	if($update){
		echo "update";
	}else{
		echo "Error";
	}
}
?>