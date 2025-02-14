<?php  
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();
	
if(isset($_REQUEST['data'])){
	$com_id = $_REQUEST['data'];
	$data = array("id"=>$com_id);
	$del = $db->delete("tbl_board_list_card_comments",$data);
	if($del){
		echo "deleted";
	}else{
		echo "Error";
	}
}
?>