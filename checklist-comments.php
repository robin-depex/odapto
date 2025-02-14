<?php
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['data'])){


	$data = explode("&",$_REQUEST['data']);

	$date = date("Y-m-d H:i:s");
	$card = explode("=",$data[0]);
	$card_id = $card[1];

	$card_com = explode("=",$data[1]);
	$card_checklist = $card_com[1];

	$card_comment_user = explode("=",$data[2]);
	$userid = $card_comment_user[1];
	
	$oldcomentid1 = explode("=",$data[3]);
	$oldcomentid = $oldcomentid1[1];
	$ckey = $db->generateRandomString();

	$data_update = array("checklist"=>$card_checklist,"cardid"=>$card_id,"userid"=>$userid,"date_time"=>$date,"status"=>1,"ckey"=>$ckey,"refrenceid"=>$oldcomentid);

	$insert = $db->insert("tbl_board_list_card_checklist",$data_update);
	
	
			if($oldcomentid!=0){
	 	$resultcheckid = $db->getLastChecklistItemData($oldcomentid);
			foreach ($resultcheckid as $value) {
			$itemname = $value['item_name'];
			$data_item = array("item_name"=>$itemname,"status"=>0,"checklist_id"=>$insert);

	$insert1 = $db->insert("tbl_board_list_card_checklist_item",$data_item);
		}
}


/* Display code start*/

		$result = $db->getCardCheckList($card_id);
		foreach ($result as $value) {
		$comm_id = $value['id'];
		$userid = $value['userid'];
		$comments = $value['comments'];
		$date_time = $value['date_time'];
		$time_diff = $db->dateDiff($date_time);
		$result = $db->getUserMeta($userid);
		?>
		<div class="maindata_<?php echo $comm_id; ?>">
		<div class="row">
<div class="col-sm-12" style="float:left">
	<div class="checkcomentbox">
<input type="text" DISABLED id="editcheck_<?php echo $comm_id; ?>" value="<?php echo $comments; ?>">
	<!--<h2 style="color: black;"><?php echo $comments; ?></h2>
-->
<button id="savechckcommnt_<?php echo $comm_id; ?>" onclick="return updatechecklistComments(<?php echo $comm_id; ?>)" class="savechckcommnt" style="display:none;" class="btn btn-success">Update</button>
</div>
</div>

<div style="float:right"> 
	<span id="<?php echo $comm_id; ?>" class="editchecklitsdata fa fa-pencil"></span>
	<span class="comment-action" id="com_act_<?php echo $comm_id; ?>">
	      	<a href="javascript:void(0)" id="<?php echo $comm_id; ?>" onclick="return ShowchecklistComments(this.id)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
	      		</span>


	      		<div class="col-md-12 b-s" id="DelchecklistComment_<?php echo $comm_id; ?>" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:relative;top:0px;padding-bottom: 15px;">

				<div class="col-md-12 n-p">
					<div id="cardDiv">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete checklist...?
						<span class="close-div fa fa-times pull-right" id="<?php echo $comm_id ?>" onclick="return closecheckliDelCommentDiv(this.id)"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					Deleting a checklist is forever.?</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn"  onclick="return DelcheckliComments(<?php echo $comm_id; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
					</div>
					<div class="col-md-6">
						<button class="list-btn" onClick="return closecheckliDelCommentDiv(<?php echo $comm_id; ?>);">Cancel</button>
					</div>
					</div>
					<br style="clear: both">
				</div>
			</div>



	      	</div>
		</div>
		

		<div class="col-md-12 checklist" id="checklist_<?php echo $comm_id; ?>">
 

 <div class="progress" id="progress_<?php echo $comm_id; ?>">
   	<?php $total_item = $db->gettotalchecklistitem('tbl_board_list_card_checklist_item','checklist_id',$comm_id);
$total_item1 = $db->gettotalchecklistitemcheck('tbl_board_list_card_checklist_item','checklist_id',$comm_id);
$singlepar = 100/$total_item;
//echo $total_item;
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



//echo $parcentcheck;
?>
 <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $parcentcheck;?>%">
     <p id="progressbb_<?php echo $comm_id; ?>"> <?php echo $parcentcheck; ?>% </p>
    </div>
	</div>
<?php
		$result = $db->getLastChecklistItemData($comm_id);
		$countitem = count($result);
?>
     <?php
		$sum =0;
		foreach ($result as $value) {
		$itemId = $value['id'];
		$itemname = $value['item_name'];
		$status = $value['status'];
	
		
		?>

<div class="checkbox checkbox-primary">
	<div class="checklistsubitemname_<?php echo $itemId; ?>">
<div class="col-sm-12" style="float:left">
<input <?php if($status==1){ echo 'checked';} ?> class="checkstatuschecklist" name="locationthemes" value="<?php echo $itemId; ?>" id="<?php echo $comm_id;?>_<?=$itemId?>" type="checkbox">
<label for="<?php echo $comm_id;?>_<?=$itemId?>">

<input type="text" <?php if($status==1){ ?> style="text-decoration: line-through;" <?php } ?> DISABLED id="editcheckitem_<?php echo $itemId; ?>" value="<?=$itemname?>">
</label>

<button id="savechckitemcommnt_<?php echo $itemId; ?>" onclick="return updatechecklistitemComments(<?php echo $itemId; ?>)" class="savechckitemcommnt" style="display:none;" class="btn btn-success">Update</button>
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
						<button class="list-btn" onclick="return Delcheckliitem(<?php echo $itemId; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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


				<div style="display: block;" id="checklistitem<?=$comm_id?>">

					<input style="border:0;font-size:12px" type="text" id="additemkm<?=$comm_id?>" class="checklist-new-item-text form-control" style="background-color: #fff;" placeholder="Add an item…">


					<input style="border:0;font-size:12px" type="text" style="display: none;" name="checklist_id<?=$comm_id?>" id="checklist_id<?=$comm_id?>" value="<?=$comm_id?>">

					<button class="btn-success list-btn" id="add_item<?=$comm_id?>" onclick="return add_item(<?=$comm_id?>)">add</button>
</div>

  
		</div>


</div>

<script type="text/javascript">

$('.editchecklitsdata').click(function(){
	var ids = $(this).attr('id');
	$('#editcheck_'+ids).removeAttr("disabled");
	$('#savechckcommnt_'+ids).css('display','block');
	  //$('.disabledCheckboxes').removeAttr("disabled");
});

function updatechecklistComments(ids){
var checkname = $('#editcheck_'+ids).val();
	var details = "id="+ids+"&comment="+checkname;
$.post('update-card-checklist.php', {data: details }, function(response) {
	$('#editcheck_'+ids).val(checkname);
	  $('#editcheck_'+ids).prop("disabled", true);
	$('#savechckcommnt_'+ids).css('display','none');

});
}

function updatechecklistitemComments(ids){
var checkname = $('#editcheckitem_'+ids).val();
	var details = "id="+ids+"&comment="+checkname;
$.post('update-card-checklistitem.php', {data: details }, function(response) {
	$('#editcheckitem_'+ids).val(checkname);
	  $('#editcheckitem_'+ids).prop("disabled", true);
	$('#savechckitemcommnt_'+ids).css('display','none');

});
}


function Showchecklistitem(elem){
	//alert(elem);
		var id = elem;
		var div = "#savechckitemcommnt_"+id;
		$('#editcheckitem_'+id).removeAttr("disabled");
		$(div).css('display','block');
	}


		function ShowchecklistitemComments(elem){
		var id = elem;
		var div = "#DelchecklistitemComment_"+id;
		$(div).css({"display":"block"});
	}


function closecheckliDelitemDiv(elem){
		var id = elem;
		var div = "#DelchecklistitemComment_"+id;
		$(div).css({"display":"none"});
	}


function Delcheckliitem(elem){
				var id = elem;
				var commentMainDiv_ = "#DelchecklistitemComment_"+id;
				$.post('delete-card-checklistitem.php', {data: id }, function(response) {
					var arr = response.split('_');
						$(commentMainDiv_).css({"display":"none"});
						$('.checklistsubitemname_'+id).css('display','none');
						$('#progress_'+arr[0]).html('<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:'+arr[1]+'%"><p id="progressbb_'+arr[0]+'"> '+arr[1]+'% </p></div>');
				});
			}


      			function ShowchecklistComments(elem){
		var id = elem;
		var div = "#DelchecklistComment_"+id;
		$(div).css({"display":"block"});
	}


	function closecheckliDelCommentDiv(elem){
		var id = elem;
		var div = "#DelchecklistComment_"+id;
		$(div).css({"display":"none"});
	}

			
			function DelcheckliComments(elem){
				var id = elem;
			//	alert(id);
				var commentMainDiv_ = "#DelchecklistComment_"+id;
				$.post('delete-card-comments1.php', {data: id }, function(response) {
					if(response == "deleted"){
						$(commentMainDiv_).css({"display":"none"});
						$('.maindata_'+id).css('display','none');
					}else{
						//alert(response);
					}
					//alert(response);
					//$("#cardCommetns").html(response);
				});
			}
		

			function updateComment(elem){
				var id = elem;
				//alert(id);
				var comm_div_ = "#comm_div_"+id;
				var comments_ = "#comments_"+id;
				var display_comm_ = "#display_comm_"+id;
				var data = $(comments_).val();
				//alert(data);
				var details = "id="+id+"&comment="+data;
				//alert(details);
				$.post('update-card-comments.php', {data: details }, function(response) {
					//alert(response);
					$(comm_div_).css({"display":'none'});
					$(display_comm_).css({"display":'block'});
					$(com_act_).css({"display":'block'});
					$(display_comm_).html(response);
				});
			}

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


		<?php
		}


	
/*Display code end*/


		}


?>
