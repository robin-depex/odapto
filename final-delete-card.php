<?php  ob_start();
session_start();
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();
	
if(isset($_REQUEST['data'])){
	$com_id = $_REQUEST['data'];
	$condition = array("card_id"=>$com_id);
	$condition1 = array("cardid"=>$com_id);
	$update_data = array("del_status"=>2); 
	$delete = $db->delete("tbl_board_list_card",$condition);
	$delete1 = $db->delete('tbl_board_card_members',$condition);
	$checklistdata = $db->getfieldvisedata('tbl_board_list_card_checklist','cardid',$com_id);
	if(count($checklistdata)>0){
		foreach($checklistdata as $checkval){
$condition2 = array("checklist_id"=>$checkval['id']);
	$delete2 = $db->delete('tbl_board_list_card_checklist_item',$condition2);
}
	}

$delete3 = $db->delete('tbl_board_list_card_checklist',$condition1);

	$delete4 = $db->delete('tbl_board_list_card_attachements',$condition1);
	$delete5 = $db->delete('tbl_board_list_card_labels',$condition1);
	$delete6 = $db->delete('tbl_board_list_duedate',$condition);
 $_SESSION['opencard']="";
	//$update = $db->update("tbl_board_list_card",$update_data, $condition);
	if($delete){
		echo "finalDelete";
	}else{
		echo "Error";
	}
}
?>