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
	$label_insert = array(
		'cardid' 	=> $cardid,
		'userid' 	=> $userid,
		'labels'	=> $label_name,
		'datetime'	=> date("Y-m-d"),
		'ckey'		=> $ckey,
		'status'	=> 1	
	);

	$insert = $db->insert("tbl_board_list_card_labels",$label_insert);
	if($insert){
		
		$data = $db->getLastInsertedLabels($ckey);

		foreach ($data as $value) {
		$lid = $db->getLabelId($value['labels']);		
		$label = $db->getLabelText($userid,$lid);
		?>
		<li style="background: <?php echo $value['labels']; ?>;" class="card-lables edit-labels"><?php if(!empty($label)){ echo $label; }else{ echo "&nbsp;";} ?></li>
		<?php
		}

	}

}
?>