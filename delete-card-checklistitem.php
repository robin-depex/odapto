<?php
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['data'])){

	//echo json_encode( $_REQUEST['data'] ); die();
	$data = $_REQUEST['data'];
	//$details = $db->unserializeForm($data);

	$com_id = $data;

	$cond = array("id"=>$com_id);

	
	 $singlerecord = $db->getsingledata('tbl_board_list_card_checklist_item','id',$com_id);
$update = $db->delete("tbl_board_list_card_checklist_item",$cond);
	   $total_item = $db->gettotalchecklistitem('tbl_board_list_card_checklist_item','checklist_id',$singlerecord['checklist_id']);
$total_item1 = $db->gettotalchecklistitemcheck('tbl_board_list_card_checklist_item','checklist_id',$singlerecord['checklist_id']);
$singlepar = 100/$total_item;
if($total_item>0){
if($total_item1==1){
	$parcentcheck = intval($singlepar);
}else if($total_item1==$total_item){
$parcentcheck = 100;
}else if($total_item1==0){
$parcentcheck = 0;
}else{
	$parcentcheck = intval($singlepar*$total_item1);
} 
}else{
	$parcentcheck = 0;
} 
$returndata = $singlerecord['checklist_id'].'_'.$parcentcheck;
echo $returndata;

}
?>
