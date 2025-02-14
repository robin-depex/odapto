<?php  
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();
	
if(isset($_REQUEST['data'])){

	$com_id = $_REQUEST['data'];
	$data = array("id"=>$com_id);
	$data1 = array("checklist_id"=>$com_id);
	$del = $db->delete("tbl_board_list_card_checklist",$data);
	$del1 = $db->delete("tbl_board_list_card_checklist_item",$data1);
	if($del){
		echo "deleted";
	}else{
		echo "Error";
	}
}
?>