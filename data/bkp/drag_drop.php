<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$data = explode("&",$_REQUEST['data']);
$d_drag = explode("_",$data[0]);
$d_drop = explode("_",$data[1]);

$card_id = $d_drag[1];
$list_id = $d_drop[1];

$data_update = array("list_id"=>$list_id);
$cond = array("card_id"=>$card_id);

if($db->update("tbl_board_list_card",$data_update,$cond)){
	echo "done";
}

?>