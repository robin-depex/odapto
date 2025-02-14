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


	$insert = $db->insert("tbl_board_list_card_checklist_item",$data_update);

	?>

<div class="progress" id="progress_<?php echo $card_checklist_item; ?>">
   	<?php $total_item = $db->gettotalchecklistitem('tbl_board_list_card_checklist_item','checklist_id',$card_checklist_item);
$total_item1 = $db->gettotalchecklistitemcheck('tbl_board_list_card_checklist_item','checklist_id',$card_checklist_item);
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
} ?>
    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $parcentcheck;?>%">
     <p id="progressbb_<?php echo $card_checklist_item; ?>"> <?php echo $parcentcheck; ?>% </p>
    </div>
	</div>

	<?php
$result = $db->getLastChecklistItemData($card_checklist_item);
		$countitem = count($result);
		foreach ($result as $value) {
		$itemId = $value['id'];
		$itemname = $value['item_name'];
		$status = $value['status'];
	
		
		?>

<div class="checkbox checkbox-primary">
	<div class="checklistsubitemname_<?php echo $itemId; ?>">
<div style="float:left;width:90%">
<input style="border:0;font-size: 14px;position: relative;top: -5px;" <?php if($status==1){ echo 'checked';} ?> class="checkstatuschecklist" name="locationthemes" value="<?php echo $itemId; ?>" id="<?php echo $card_checklist_item;?>_<?=$itemId?>" type="checkbox">
<label for="<?php echo $card_checklist_item;?>_<?=$itemId?>">

<input  style="border:0;font-size:12px" type="text" DISABLED <?php if($status==1){ ?> style="text-decoration: line-through;" <?php } ?> id="editcheckitem_<?php echo $itemId; ?>" value="<?=$itemname?>">
</label>

<button id="savechckitemcommnt_<?php echo $itemId; ?>" onclick="return updatechecklistitemComments(<?php echo $itemId; ?>)" class="savechckitemcommnt" style="display:none;" class="btn list-btn btn-success">Update</button>
</div>

<div style="float:right">
<span onclick="return Showchecklistitem(<?php echo $itemId; ?>)"  class="editchecklitsitemdata fa fa-pencil"></span>
<span class="comment-action" id="checkitem_act_<?php echo $itemId; ?>">
	      	<a href="javascript:void(0)"  onclick="return ShowchecklistitemComments(<?php echo $itemId; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
	      		</span>


	      		<div class="col-md-12 b-s" id="DelchecklistitemComment_<?php echo $itemId; ?>" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:relative;top:0px;padding-bottom: 15px;">

				<div class="col-md-12 n-p">
					<div id="cardDiv">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete checklist item...?
						<span class="close-div fa fa-times pull-right" onclick="return closecheckliDelitemDiv(<?php echo $itemId; ?>)"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					Deleting a checklist is forever.?</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn" onclick="return Delcheckliitem(<?php echo $itemId; ?>)">Delete</button>
					</div>
					<div class="col-md-6">
						<button class="list-btn" onClick="return closecheckliDelitemDiv(<?php echo $itemId; ?>);">Cancel</button>
					</div>
					</div>
					<br style="clear: both">
				</div>
			</div>



</div>
</div>
</div>

<?php
}
?>


				<div style="display: block;" id="checklistitem<?=$card_checklist_item?>">

					<input type="text" id="additemkm<?=$card_checklist_item?>" class="checklist-new-item-text form-control" style="background-color: #fff;" placeholder="Add an item…">


					<input type="text" style="display: none;" name="checklist_id<?=$card_checklist_item?>" id="checklist_id<?=$card_checklist_item?>" value="<?=$card_checklist_item?>">

					<button class="btn-success list-btn" id="add_item<?=$card_checklist_item?>" onclick="return add_item(<?=$card_checklist_item?>)">add</button>
	</div>

   
	<?php

      }
      	?>

		<script>
			$('input[type="checkbox"]').click(function(){
				var data1 = $(this).attr('id');
				var arr = data1.split('_');
				//alert(arr[0]);
				//alert(arr[1]);
				var mainid = arr[0];
				var id = arr[1];
				if($(this).prop("checked") == true){
               var checkeddata = 1;
            }else if($(this).prop("checked") == false){
            var checkeddata = 0;
            }
     $.ajax({
		url: 'checklistprocess.php',
		type: 'POST',
		data: {checklistid:mainid,checklistitemid:id,checkeddata:checkeddata},
		success: function(data){
		if(checkeddata==1){
				$('#editcheckitem_'+id).css('text-decoration','line-through');
			}else{
				$('#editcheckitem_'+id).css('text-decoration','');
			}
		
		$('#progress_'+mainid).html(data);
		}
	});


	});

			</script>	