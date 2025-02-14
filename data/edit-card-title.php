<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();
	
if(isset($_REQUEST['data'])){

	$data = explode("&", $_REQUEST['data']);
	$card_title = explode("=",$data[0]);
	$card_id = explode("=",$data[1]);

	$data_update = array("card_title"=>$card_title[1]);
	$cond = array("card_id"=>$card_id[1]);
	$update = $db->update("tbl_board_list_card",$data_update,$cond);

	if($update ){
		echo $card_title[1];
	}else{
		echo $error;
	}

}



?>