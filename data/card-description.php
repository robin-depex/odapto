<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();
	
if(isset($_REQUEST['data'])){


	$data = explode("&",$_REQUEST['data']);
	
	$card = explode("=",$data[0]);
	$card_id = $card[1];

	$card_desc = explode("=",$data[1]);
	$card_desc = $card_desc[1];

	$data_update = array("card_description"=>$card_desc);
	$cond = array("card_id"=>$card_id);
	$update = $db->update("tbl_board_list_card",$data_update,$cond);

	if($update ){
		echo $card_desc;
	}else{
		echo $error;
	}

}



?>