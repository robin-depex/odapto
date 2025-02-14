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
	$ckey = $db->generateRandomString();

	$data_update = array("checklist"=>$card_checklist,"cardid"=>$card_id,"userid"=>$userid,"date_time"=>$date,"status"=>1,"ckey"=>$ckey);

	$insert = $db->insert("tbl_board_list_card_checklist",$data_update);
	if($insert ){
		$result = $db->getLastChecklist($ckey);
		foreach ($result as $value) {
		$comm_id = $value['id'];
		$userid = $value['userid'];
		$comments = $value['comments'];
		$date_time = $value['date_time'];
		$time_diff = $db->dateDiff($date_time);
		$result = $db->getUserMeta($userid);
		?>
		<div class="col-md-12 checklist" id="checklist_<?php echo $comm_id; ?>">
			<div class="col-md-1 pro-mar">
				<span id="profile_initials"><?php echo $result['initials']; ?></span>
			</div>
			<div class="col-md-10 n-p" style="width: 88%">
				<h3 class="name">
	      			<span class="heading"><?php echo $result['full_name']; ?></span>
	      		</h3>
	      		<span class="time-ago pull-right">
	      				Justnow
	      		</span>
	      		<p class="comments" id="display_comm_<?php echo $comm_id; ?>">
	      		 <?php 
	      		 $regex = "/#+([a-zA-Z0-9_-]+)/";
	      		 $str = preg_replace($regex, '<img src="http://depextechnologies.org/odaptonew/smile/$1.png" style="width:20px">', $comments);
	      		 echo $str;
	      		 ?></p>
	      		<p class="pull-left comment-action" id="com_act_<?php echo $comm_id; ?>">
	      		<a href="javascript:void(0)" id="<?php echo $comm_id; ?>" onclick="return ShowComments(this.id)">Edit</a>
	      		 -
	      		<a href="javascript:void(0)" id="<?php echo $comm_id; ?>" onclick="return ShowDelComments(this.id)">Delete</a>
	      		</p>

	      		<div class="col-md-12 b-s" id="DelComment_<?php echo $comm_id; ?>" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:relative;top:0px;padding-bottom: 15px;">

				<div class="col-md-12 n-p">
					<div id="cardDiv">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete Comment...?
						<span class="close-div fa fa-times pull-right" id="<?php echo $comm_id ?>" onclick="return closeDelCommentDiv(this.id)"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					Deleting a comment is forever.?</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn" id="<?php echo $comm_id; ?>" onclick="return DelComments(this.id)">Delete</button>
					</div>
					<div class="col-md-6">
						<button class="list-btn" id="<?php echo $comm_id; ?>" onClick="return closeDelCommentDiv(this.id);">Cancel</button>
					</div>
					</div>
					<br style="clear: both">
				</div>
			</div>
	      		<!-- comment edit -->
	      		<div class="col-md-12 n-p" id="comm_div_<?php echo $comm_id; ?>" style="display: none">
	      		<form method="post">
					<div class="form-group">
						<input type="text" class="form-control input-lg" id="comments_<?php echo $comm_id; ?>" style="border-radius: 0px;padding: 5px;" value="<?php echo $comments; ?>">
						<button class="list-btn" type="button" id="<?php echo $comm_id; ?>" onclick="return updateComment(this.id)" style="border:0px;padding:5px 15px;font-size: 14px;"> Save </button>
						<span class="fa fa-times fa-2x" id="<?php echo $comm_id; ?>" onclick="return close_comment(this.id); " style="font-weight: normal;font-size: 20px;margin-left: 15px;cursor:pointer"></span>
					</div>
				</form>
	      		</div>
			</div>


		</div>
      	<script type="text/javascript">
      		function ShowComments(elem){
				var id = elem;
				var display_comm_ = "#display_comm_"+id;
				var com_act_ = "#com_act_"+id;
				var comm_div_ = "#comm_div_"+id;
				$(display_comm_).css({"display":"none"});
				$(com_act_).css({"display":"none"});
				$(comm_div_).css({"display":"block"});
			}
			function close_comment(elem){
				var id = elem;
				var display_comm_ = "#display_comm_"+id;
				var com_act_ = "#com_act_"+id;
				var comm_div_ = "#comm_div_"+id;
				$(comm_div_).css({"display":"none"});
				$(display_comm_).css({"display":"block"});
				$(com_act_).css({"display":"block"});

			}
			function DelComments(elem){
				var id = elem;
				var commentMainDiv_ = "#commentMainDiv_"+id;
				$.post('delete-card-comments.php', {data: id }, function(response) {
					if(response == "deleted"){
						$(commentMainDiv_).css({"display":"none"});
					}else{
						alert(response);
					}
					//alert(response);
					//$("#cardCommetns").html(response);
				});
			}
			function ShowDelComments(elem){
		var id = elem;
		var div = "#DelComment_"+id;
		$(div).css({"display":"block"});
	}

	function closeDelCommentDiv(elem){
		var id = elem;
		var div = "#DelComment_"+id;
		$(div).css({"display":"none"});
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
      	</script>
		<?php
		}
	}else{
		echo $error;
	}

}



?>
