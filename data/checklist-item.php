<?php
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['data'])){


	$data = explode("&",$_POST['data']);

	$date = date("Y-m-d H:i:s");
	$card = explode("=",$data[0]);
	$checklist_itemname = $card[1];

	$card_com = explode("=",$data[1]);
	$card_checklist_item = $card_com[1];

	$card_comment_user = explode("=",$data[2]);
	

	$data_update = array("item_name"=>$checklist_itemname,"checklist_id"=>$card_checklist_item);


	$insert = $db->insert("tbl_board_list_card_checklist_item
",$data_update);

	if($insert){
	
		$result = $db->getLastChecklistItem();
		foreach ($result as $value) {
		$id = $value['id'];
		$item_name = $value['item_name'];
		
		?>
	
		<div class="col-md-12 checklist" id="my_check_item_<?=$id?>">
			 <div class="checkbox checkbox-primary">
                        <input id="checkbox<?=$id?>" type="checkbox">
                        <label for="checkbox<?=$id?>"><?=$item_name?>
                        </label>
                    </div>

		</div>
      	 <?php
      		}
      	}
      }
      	?>



