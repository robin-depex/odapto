<?php
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$checklistid = $_POST['checklistid'];
$checklistitemid = $_POST['checklistitemid'];
$checkeddata = $_POST['checkeddata'];
$updatedata = array(
'status' => $checkeddata,
	);
$whearcon = array(
'checklist_id' => $checklistid,
'id' => $checklistitemid,
	);
$update = $db->update('tbl_board_list_card_checklist_item',$updatedata,$whearcon);
$total_item = $db->gettotalchecklistitem('tbl_board_list_card_checklist_item','checklist_id',$checklistid);
$total_item1 = $db->gettotalchecklistitemcheck('tbl_board_list_card_checklist_item','checklist_id',$checklistid);
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

?>

<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $parcentcheck; ?>%">
     <p id="progressbb_<?php echo $checklistid; ?>"> <?php echo $parcentcheck; ?>% </p>
    </div>