<?php
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['data'])){

	//echo json_encode( $_REQUEST['data'] ); die();
	$data = $_REQUEST['data'];
	$details = $db->unserializeForm($data);

	$com_id = $details['id'];
	$comm = $details['comment'];

	$cond = array("id"=>$com_id);
	$update_data = array("checklist" => $comm);
	//echo json_encode($update_data);die();
	$update = $db->update("tbl_board_list_card_checklist",$update_data, $cond);
	
}
?>
