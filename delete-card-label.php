<?php  
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();
if(isset($_REQUEST['userid'])){
	
	$label_name = $_REQUEST['label_name'];
	$cardid 	= $_REQUEST['cardid'];
	$userid 	= $_REQUEST['userid'];
	$ckey = $db->generateRandomString();
	$del_cond = array(
		'cardid' 	=> $cardid,
		'userid' 	=> $userid,
		'labels'	=> $label_name
	);

	$delete = $db->delete("tbl_board_list_card_labels",$del_cond);
	if($delete){
		echo "Deleted";		
	}else{
		echo "Error";
	}

}
?>