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
	$update_data = array("comments" => $comm);
	//echo json_encode($update_data);die();
	$update = $db->update("tbl_board_list_card_comments",$update_data, $cond);
	if($update){
	 $regex = "/#+([a-zA-Z0-9_-]+)/";
	 $str = preg_replace($regex, '<img src="http://depextechnologies.org/odaptonew/smile/$1.png" style="width:20px">', $comm);
	 echo $str;
	}else{
		echo "Error";
	}
}
?>
