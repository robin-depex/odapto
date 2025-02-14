<?php
// error_reporting(0);
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

//echo $_REQUEST['data'];
$cardID = $_REQUEST['data'];
$data = explode("_",$_REQUEST['data']);
$card = $data[1];
$boardid = $data[2];
$result = $db->getCardDetails($card);
$uid = $_SESSION['sess_login_id'];
$cardid = $result['card_id'];
$card_title = $result['card_title'];
$list_title = $result['list_title'];
$list_id = $result['list_id'];
$card_description = $result['card_description'];
?>
<style type="text/css">
#profile_initials{
    width:30px;
    height:30px;
    background-color:#024058;
    display: inline-block;
    color: #fff;
    text-align: center;
    line-height: 30px;
    border-radius: 3px;
  }
  .pro-mar{
  	margin-right: 10px;
  }
  .name{
  	display: inline-block;
  	font-size: 16px;
  	font-weight: bold;
  	margin: 0px;
  }
  .comments{
  	color: #000;
  }
  .comentdiv{
  	position: relative;
  	min-height: 20px;
    padding: 10px 1px;
    margin-bottom: 5px;
    background-color: #rgba(221, 221, 211, 0.4);
    border: 1px solid rgba(0,0,0,0.3);
    border-radius: 3px !important;
  }
  .comment-action > a{
  	font-size: 13px;
  	color: #000 !important;
  	font-weight: bold;
  }

  .time-ago{
  	font-size: 12px;
  	color: #000;
  	position: absolute;
  	top: 5px;
  	right: 5px;
  }
  .side-list > a {
    margin-bottom: 8px;
    width: 100%;
    background-color: #fffefe;
    padding: 6px 10px;
    box-shadow: 1px 1px rgba(0, 0, 0, 0.19);
    color: #000 !important;
    display: inline-block;
    font-weight: bold;
}

  .side-div{
  	height: auto !important;
  }
  textarea{
  	border-radius: 0px;
    background: white;
    outline: none;
    border: 0px;
    word-break: break-all;
    box-shadow: 0px 0px 0px 1px rgba(0,0,0,0.1);
    resize: none;
  }
  .comment-box {
    position: relative;
}
.comment-box-options {
    position: absolute;
    bottom: 6px;
    right: 6px;
}
.comment-box-options-item {
    border-radius:3px;
    float: left;
    height: 22px;
    margin-left: 4px;
    padding: 3px 6px;
    
    line-height: 18px;
}
.icon {
	color: rgba(0, 0, 0, 0.6);
	font-size: 18px;
}
.comment-box-options-item:hover{
	background: #d2d0d0;
} 
, .icon:hover{
	color: #000;
} 
 
/* popupbox css */
.popup-container{
	display: none;
    background-color: #fdfdfd;
    width: 330px;
    margin-bottom: 10px;
    z-index: 9999;
    position: absolute;
    top:0px;
    right:0px;
}
.popup-heading{
	font-size: 16px; text-align: center;
	font-weight: normal;
	color: #7d7d7d;
}
.popup-text{
 	font-size: 15px;
 	color: #7d7d7d;
 	margin-left: 20px;
 	display: inline-block;
 }
 .popup-list{
 	margin:5px 0px;
 	padding:3px;
    padding-left: 15px;
    border-radius: 4px;
 }
 .popup-list:hover{
 	background: #e2e2e2;
 	cursor: pointer;
 }
 .n-b{
 	background: none;
 }
 .label-div{
 	width: 89%;
    height: 15px;
    display: inline-table;
    padding: 16px;
    margin-top: 9px;
    border-radius: 5px;
    cursor: pointer;
 }
 .edit-label-div{
 	width: 41px;
    height: 15px;
    display: inline-grid;
    padding: 16px;
    margin-top: 10px;
    border-radius: 5px;
    cursor: pointer;
    float: left;
    margin-right: 9px;
    margin-bottom: 9px;
    position: relative;
 }
 .editLabel{
 	width: 30px;
    height:30px;
    color:#b7b4b4;
    position: absolute;
    top: 9px;
    right: 0;
    text-align: center;
    line-height: 30px;
    vertical-align: middle;
    border-radius: 5px;
 }
 .editLabel:hover{
 	background:#d8d8d8;
 	color:#060606;
 }
 /* image preview code */
 .imagePreview{
	background-size: contain;
	background-color: #000;
	text-align: -webkit-center;
 }
 .col-sm-12.n-p.attachment_div:hover {
    background:#e0e0e0
 }
 .imagePreview img{
 	height: 200px;
 }
 .imagePreviewDb{
	background-size: contain;
	background-color: #000;
	text-align: -webkit-center;
	margin-bottom:15px;
 }
 .imagePreviewDb img{
 	height: 200px;
 }

.floatingPopupLeft{
	position: absolute;
	top:0px;
	left:0px;
}
.floatingPopupRight{
	position: absolute;
	top:0px;
	right:0px;
}
.createLabelLink{
	margin-top: 5px;
    margin-bottom: 5px;
    height: 30px;
    display: inline-block;
    width: 100%;
    border-radius: 5px;
}
.createLabelLink:hover{
	background-color: #ccc;
}
.fa-arrow-left{
	cursor: pointer;
}
.select-icon{
	position:relative;
    color: #fff;
    width:100% !important;
    height:100% !important;
    bottom: 10px; 
}
.select-icon2{
	position:absolute;
    color: #fff;
    right: 45px;
    top: 19px;
}
.my_check_right{
	position: relative;
	cursor:pointer;
}
.my_check_right:before{
	 content: "\f00c";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
/*--adjust as necessary--*/
    color: #000;
    font-size: 18px;
    padding-right: 0.5em;
    position: absolute;
    top: 8px;
    right: 5px;
}
.my_check_right.hiddeni:before{
	display:none;
}
.tog_bg{
	border: 1px solid #ffff !important;
    background-color: #000;
	}
	.checklist-new-item-text, .checklist-new-item-text:hover {
    background: 0 0;
    border-color: transparent;
    box-shadow: none;
    color: #8c8c8c;
    cursor: pointer;
    margin-bottom: 4px;
    max-height: 2pc;
    overflow: hidden;
    resize: none;
    text-decoration: none;
    width: 100%;
}
</style>

<div class="imagePreview"></div>
<?php  
$coverimage = $db->getCoverImage($cardid);
foreach ($coverimage as $key => $valuecover) {
?>
<div class="imagePreviewDb">
  <img src="<?php echo $valuecover['cover']; ?>" class="img-responsive">
</div>
<?php
}
?> 
<div class="col-md-11 n-p" id="alert-msg" style="display: none;">
	<div class="progress" style="height:30px !important;">
  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;padding-top:6px; padding-left: 20px; text-align: left !important;">
    <span style="font-size:16px;">This card will be deleted.....?</span>
  </div>
</div>
</div>
<h3 style="margin:0px ">
<form action="" method="post">
  <input type="text" class="form-control list-Title" id="<?php echo $cardid; ?>" onblur="return editCardTitle(this.id)" value="<?php echo ucfirst($card_title); ?>" style="padding: 0px;height: 20px;width:98%">
</form>
</h3>
<h3 style="margin:0px ">
<form action="" method="post">
<ul class="list-inline">
<?php
$my_user_id=$db->membersAjax();

foreach ($my_user_id as $value) {
$result = $db->getUserMeta($value);
?>
 <li id="show_me" style="color: #000;"><?php echo $result['initials']?></li>
 <?php
}
 ?>
  </ul>
</form>
</h3>

<h5 style="margin:0px ">in List: <?php echo $list_title; ?></h5>
<div class="clearfix"></div>
<a href="javascript:void(0)" id="editDesc" class="pull-right" style="color: #606060;">
<span class="fa fa-pencil"></span> Edit the Description</a>

<div class="col-md-12 editDescDiv">
<div class="col-md-12 n-p">
	<form method="post">
		<div class="form-group">
		<textarea class="form-control" rows="3" id="desc" style="border-radius: 0px;"><?php echo $card_description; ?></textarea>
		<input type="hidden" id="card" value="<?php echo $cardid; ?>">
		<button class="list-btn" type="button" id="saveCardDesc"> Save Description</button>

		<span class="fa fa-times close-div"></span>
		</div>
	</form>
	</div>
</div>
<p id="CardDesc"><?php echo $card_description; ?></p>
<div class="col-md-12 n-p" id="activityDiv">
<div class="col-md-12 n-p"  style="height:auto !important;padding-right: 10px; padding-left: 0px;">

<div class="col-md-9 n-p">

<!-- Card Labels Starts-->
<div class="col-sm-12 n-p" style="margin-bottom:15px">
	<?php  
	$labels = $db->getAllCardLabels($cardid);
	if(count($labels) > 0){
	?>
	<h4>Labels</h4>
	<?php } ?>
	<ul class="list-inline">
	<li id="cardLabels" style="display: none"></li>
	<?php  
	$labels = $db->getAllCardLabels($cardid);
	if(count($labels) > 0){
	?>
	
	<?php	
		foreach ($labels as $value) {
		$lid = $db->getLabelId($value['labels']);		
		$label = $db->getLabelText($uid,$lid);	
		?>
		
		<li style="background: <?php echo $value['labels']; ?>;" class="card-lables edit-labels"><?php if(!empty($label)){ echo $label; }else{ echo "&nbsp;";} ?></li>
		
		<?php
		}
	}
	?>
	</ul>
	
</div>
<!-- Card Labels Ends -->

<!-- Card Attachments  Starts -->
<?php  
$attachments = $db->allCardAttachments($cardid);
//echo json_encode($attachments);
if($attachments > 0){
?>
<div class="Attachemnts_div">
<div class="col-sm-12 n-p">
<h4> <span class="fa fa-paperclip"></span> Attachments</h4>
</div>
<?php	
foreach ($attachments as $key => $valueatt) {
if($valueatt['cover'] == 1){
	$cover = "Remove Cover";
	$class = "remove_cover";
}else{
	$cover = "Make Cover";
	$class = "make_cover";
}	
?>
<div class="col-sm-12 n-p attachment_div" style="margin-bottom:10px;margin-left: 16px;margin-top: 5px;">
 <div class="col-sm-2 n-p" style="margin-right: 20px;">
 <img src="<?php echo $valueatt['images']; ?>" class="img-responsive" style="height:80px;width: 100%">
</div> 
<div class="col-sm-8 n-p">
  	<h4><?php echo end(explode("/",$valueatt['images'])); ?></h4>
  	<a href="<?php echo SITE_URL."/".$valueatt['images']; ?>" download style="color: #000;margin-right: 8px;"> <span class="fa fa-download" ></span> Dwonload </a>
  	<a href="javascript:void(0)" class="<?php echo $class; ?>" id="makeremove_<?php echo $valueatt['id']; ?>" style="color: #000;margin-right: 8px;"> <span class="fa fa-picture-o"></span> <?php echo $cover ?> </a>
  	<a href="javascript:void(0)" class="deleteAttachment" id="<?php echo $valueatt['id']; ?>" style="color: #000;margin-right: 8px;"> <span class="fa fa-times"></span> Delete </a>
  	<a href="javascript:void(0)" style="color: #000;margin-right: 8px;"> <span class="fa fa-comments"></span> Comment </a>
  	
  </div>	
</div>  
<?php
}	
}
?>
</div>
<!-- Card Attachments Ends   -->

<!-- checklist code by vinay -->

<p style="color:black;">Checklist</p>


<div class="col-md-12 n-p" id="checklist" style="display:block;"></div>
<?php
		$result = $db->getCardCheckList($cardid);
		foreach ($result as $value) {
		$comm_id = $value['id'];
		$userid = $value['userid'];
		$comments = $value['comments'];
		$date_time = $value['date_time'];
		$time_diff = $db->dateDiff($date_time);
		$result = $db->getUserMeta($userid);
		?>
		<div class="col-md-12 checklist" id="checklist_<?php echo $comm_id; ?>">
		<h2 style="color: black;"><?=$comments?></h2>
			<div>
			    <div class="progress">
    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:50%">
      70%
    </div>
	</div>
	<div id="my_check_item<?=$comm_id?>" style="display: block;"></div>
	<?php
		$result = $db->getLastChecklistItemData($comm_id);
		foreach ($result as $value) {
		$itemId = $value['id'];
		$itemname = $value['item_name'];
		
		?>

<div class="checkbox checkbox-primary">
                        <input id="checkbox<?=$comm_id?>" type="checkbox">
                        <label for="checkbox<?=$comm_id?>"><?=$itemname?>
                        </label>
                    </div>

<?php
}
?>

				

				<input type="text" name="checklistitem<?=$comm_id?>" id="additem<?=$comm_id?>" class="checklist-new-item-text" placeholder="Add an item…">

				<div style="display: none;" id="checklistitem<?=$comm_id?>">

					<input type="text" id="additemkm<?=$comm_id?>" class="checklist-new-item-text form-control" style="background-color: #fff;" placeholder="Add an item…">


					<input type="text" style="display: none;" name="checklist_id<?=$comm_id?>" id="checklist_id<?=$comm_id?>" value="<?=$comm_id?>">

					<button class="btn-success" id="add_item<?=$comm_id?>" onclick="return add_item(<?=$comm_id?>)">add</button>
<div id="close_item<?=$comm_id?>">
					<i class="fa fa-times" id="close_item" aria-hidden="true"></i>
					<span style="display: none;"><?php echo 'checklistitem'.$comm_id;?></span>
</div>
				</div>

			</div>
			


		</div>

		<?php
		}
	?>


<!-- end checkList code -->

<div class="col-sm-12" style="height:auto !important;padding-right: 10px; padding-left: 0px;">
	<h3 style="color:#606060;font-size:16px;font-weight: bold;letter-spacing: 1px;" ><span class="fa fa-comments"></span> Add Comments</h3>
	<div class="clearfix"></div>
	<form method="post">
		<div class="form-group">
			<input type="hidden" id="cardc" value="<?php echo $cardid; ?>">
			<div id="comment-box">
			<textarea class="form-control comment" id="comments" rows="3" style="border-radius: 0px;"></textarea>
			<div class="comment-box-options">
			<a class="comment-box-options-item js-comment-add-attachment" href="javascript:void(0)" title="Add an attachment…"><span class="fa fa-paperclip icon"></span></a>
			<a class="comment-box-options-item js-comment-add-emoji" href="javascript:void(0)" title="Add emoji…"><span class="fa fa-smile-o icon"></span></a>
			</div>
			<!-- emoji section -->

			<div class="col-md-12 b-s popup-container" id="emojiDiv">
			<h6 class="popup-heading">Emoji <span class="close-div fa fa-times pull-right"></span></h6>
			<hr>
			<form id="emoji">
			 <input type="text" class="form-control input-md" name="searchMember" id="searchemoji" placeholder="search emoji....">
			</form>
			<div class="col-md-12 n-p emojiresult"></div>
			<div class="col-md-12 n-p emoji">
			<ul style="margin: 0px; padding: 0px; list-style: none;">
			<?php  
			$result = $db->getEmoji();
			foreach ($result as $value) {
			?>
			<li class="popup-list">
				<span id="profile_initials n-b"><img src="<?php echo $value['icon']; ?>" style="width: 20px;"></span> 
				<span class="popup-text" id="<?php echo $value['code']; ?>" onclick="return addEmoji(this.id);"><?php echo $value['name']; ?></span></li>
			<?php		
			}
			?>
			
			</ul>
			<div class="clearfix"></div>
			</div>
		</div>
			<!-- emoji section ends -->
			</div>
			<button class="list-btn" type="button" id="saveCardComments"> Save </button>
		</div>
	</form>
	<div class="clearfix"></div>
	<h3 style="color:#606060;font-size:16px;font-weight: bold;letter-spacing: 1px;"><span class="fa fa-comments"></span> Activities:</h3>
	<div class="col-md-12 n-p" id="cardCommetns" style="display:block;"></div>
	<?php
		$result = $db->getCardComments($cardid);
		foreach ($result as $value) {
		$comm_id = $value['id'];
		$userid = $value['userid'];
		$comments = $value['comments'];
		$date_time = $value['date_time'];
		$time_diff = $db->dateDiff($date_time);
		$result = $db->getUserMeta($userid);
		?>
		<div class="col-md-12 comentdiv" id="commentMainDiv_<?php echo $comm_id; ?>">
			<div class="col-md-1 pro-mar">
				<span id="profile_initials"><?php echo $result['initials']; ?></span>
			</div>
			<div class="col-md-10 n-p" style="width: 88%">
				<h3 class="name">
	      			<span class="heading"><?php echo $result['full_name']; ?></span>
	      		</h3>
	      		<span class="time-ago pull-right">
	      				<?php echo $time_diff; ?> ago
	      		</span>
	      		<p class="comments" id="display_comm_<?php echo $comm_id; ?>">
	      		 <?php 
	      		 $regex = "/#+([a-zA-Z0-9_-]+)/";
	      		 $str = preg_replace($regex, '<img src="http://depextechnologies.org/odaptonew/smile/$1.png" style="width:20px">', $comments);
	      		 echo $str;
	      		 ?></p>
	      		<p class="pull-left comment-action" id="com_act_<?php echo $comm_id; ?>">
	      		<?php
	      		if($uid == $userid){
	      			?>
				<a href="javascript:void(0)" id="<?php echo $comm_id; ?>" onclick="return ShowComments(this.id)">Edit</a>
	      		 -
	      		<a href="javascript:void(0)" id="<?php echo $comm_id; ?>" onclick="return ShowDelComments(this.id)">Delete</a>  	      			<?php
	      		}
	      		?>

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
					<input type="text" class="form-control input-md" id="comments_<?php echo $comm_id; ?>" style="border-radius: 0px;padding: 5px;" value="<?php echo $comments; ?>">
						<button class="list-btn" type="button" id="<?php echo $comm_id; ?>" onclick="return updateComment(this.id)"> Save </button>
						<span class="fa fa-times fa-2x" id="<?php echo $comm_id; ?>" onclick="return close_comment(this.id); " style="font-weight: normal;font-size: 20px;margin-left: 15px;cursor:pointer"></span>
					</div>
				</form>
	      		</div>
			</div>


		</div>

		<?php
		}
	?>

</div>

</div>

<div class="col-md-3 side-div">
		<h3 style="color:#606060;font-size:16px;font-weight: bold;letter-spacing: 1px;"><span class="fa fa-plus"></span>Add:</h3>
		<hr>
		<div class="clearfix"></div>
		<ul style="list-style-type: none;padding: 0px;">
		<li class="side-list" onclick="return ShowHideAddMembers()">
			<a href="javascript:void(0)">Members</a>
		</li>

		<div class="col-md-12 b-s popup-container" id="addmembers">
			<h6 class="heading">Members <span class="close-div fa fa-times pull-right"></span></h6>
			<hr>
			<form id="teamMember">
			    <input type="text" class="form-control input-md" name="searchMember" id="searchMember">
			</form>
			<h6 class="heading">Board Members</h6>
			<div class="col-md-12 n-p boardMembers">
			<ul style="margin: 0px; padding: 0px; list-style: none;" id="my_id">
				<?php

					$member = $db->getBoardmembers($boardid);

					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$mamb = $db->BoardCardMembers($value);
						

						?>
						<li <?php
						if($value==$mamb){
							echo 'class="my_check_right my_class"';
							$idjs='hide_me'.rand(1,100);
						}
						else{
							echo 'class="my_check_right hiddeni tog_bg"';
							$idjs='showme'.rand(100,1000);
						}
						

						?> style="margin: 5px 0px;padding: 3px; background-color: #e8e8e8; border:1px solid #eeeeee;" onclick="addMyMember(<?=$boardid?>,<?=$result[0]?>,<?=$cardid?>,<?=$value?>,'<?=$result['initials']?>','<?=$idjs?>')" id="<?=$idjs?>"><span id="profile_initials"><?php echo $result['initials']; ?>
						</span> 

						<span class="heading"><?php echo $result['full_name'] . " " .$result['user_name']; ?></span>
						<span class="icon-sm icon-check checked-icon"></span>
						</li>
						<?php
					}
				?>
			</ul>
			<div class="clearfix"></div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('input[name=searchMember]').on('keyup', function() {
				  var value = $(this).val();
				  var patt = new RegExp(value, "i");
				  $('#my_id').find('li').each(function() {
				    if (!($(this).find('span').text().search(patt) >= 0)) {
				      $(this).not('.heading').hide();
				    }
				    if (($(this).find('span').text().search(patt) >= 0)) {

				      $(this).show();
				    }
				  });
				});	
				});

			</script>
			</div>
		</div>

		<li class="side-list">
		<a href="javascript:void(0)" onclick="return showaddlabels()">Labels</a>
		<!-- Label Popup --></li>
			<li class="side-list">
			<a href="javascript:void(0)" onclick="Checklist()">Checklist</a>
		</li>

		<div class="col-md-12 b-s popup-container" id="Checklistdiv">
			<h6 class="heading">Checklist <span class="close-div fa fa-times pull-right"></span></h6>
			<hr>
			
			
			<div class="col-md-12 n-p boardMembers">
			<h3>Title</h3>
			<textarea class="form-control comment" id="checkcomments" rows="3" style="border-radius: 0px;"></textarea>
        <div class="form-group">
			<h5><strong>Copy to…</strong></h5>


			<select class="form-control">
			<?php
			$result = $db->getCardCheckList($cardid);
			foreach ($result as $value) {
			$comm_id = $value['id'];
			$userid = $value['userid'];
			$comments = $value['comments'];
			?>
		  <optgroup label="<?=$comments?>">
		  <?php
		  	$result = $db->getLastChecklistItemData($comm_id);
			foreach ($result as $value) {
			$itemId = $value['id'];
			$itemname = $value['item_name'];
		  ?>
		    <option value="<?=$itemname?>"><?=$itemname?></option>
		    <?php
		}
		    ?>
		  </optgroup>
		  <?php
			}
		  ?>
		</select>
		</div>
		  <div class="form-group">
			<button class="list-btn addchecklist">Add</button>
		</div>	
			<div class="clearfix"></div>
			
			</div>
		</div>



		<li class="side-list">
		<a href="javascript:void(0)" onclick="return showaddDueDate()">Due Date</a>
		
		<!--  Calender -->	
		<div class="col-md-12 b-s popup-container" id="addDueDate" >
			<h6 class="heading">Change Due Date <span class="close-div fa fa-times pull-right"></span></h6>
			<hr>
			
			<div class="col-md-12 n-p Labels" style="min-height: 450px;">
				<?php  
				include('calander/index.php');
				?>
			<div class="clearfix"></div>
			</div>
		</div>
			</li>
			<li class="side-list">
			<a href="javascript:void(0)" id="attachment" >Attachments</a></li>
		</ul>

		<h3 style="color:#606060;font-size:16px;font-weight: bold;letter-spacing: 1px;"><span class="fa fa-plus"></span>Actions:</h3>
		<hr>
		<ul style="list-style-type: none;padding: 0px;position: relative">
		<li class="side-list">
			<a href="javascript:void(0)" onclick="Movedata()">Move</a></li>

			<div class="col-md-12 b-s popup-container" id="movedataid">
			<h6 class="heading">Move Card <span class="close-div fa fa-times pull-right"></span></h6>
			<hr>
			
			<h6 class="heading">Board Members</h6>
			<div class="col-md-12 n-p boardMembers">
			<h3>Title</h3>
			<textarea class="form-control comment" id="comments" rows="3" style="border-radius: 0px;"></textarea>
            <div class="form-group">
			<h5><strong>Copy to…</strong></span>
			<select class="form-control comment">
				<option>Board name</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
			</div>
			 <div class="form-group">
			<h5><strong>List…</strong></span>
			<select class="form-control comment">
				<option>List</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
			</div>
			 <div class="form-group">
			<select class="form-control comment">
				<option>Position</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
			</div>
			 <div class="form-group">
			<button class="list-btn">Move</button>
			</div>
			<div class="clearfix"></div>
			
			</div>
		</div>

			<li class="side-list">
			<a href="javascript:void(0)" id="click_me" onclick="copydata()">Copy</a></li>



			<div class="col-md-12 b-s popup-container" id="copydataid">
			<h6 class="heading">Copy Card <span class="close-div fa fa-times pull-right"></span></h6>
			<hr>
			
			<h6 class="heading">Board Members</h6>
			<div class="col-md-12 n-p boardMembers">
			<h3>Title</h3>
			<textarea class="form-control comment" id="comments" rows="3" style="border-radius: 0px;"></textarea>
            <div class="form-group">
			<h5><strong>Copy to…</strong></h5>
			<select class="form-control comment">
				<option>Board name</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
			</div>
			<div class="form-group">
			<h5><strong>List...</strong></h5>
			<select class="form-control comment">
				<option>List</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
			</div>
			<div class="form-group">
			<select class="form-control comment">
				<option>Position</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
			</select>
			</div>
			<div class="form-group">
			<button class="list-btn">Copy</button>
			</div>
			<div class="clearfix"></div>
			
			</div>
		</div>

			<li class="side-list">
			<a href="javascript:void(0)" onclick="return ShowCard()">Delete</a></li>
			<div class="col-md-12 b-s" id="DelCard_" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:absolute;top:-40px;padding-bottom: 15px;">

				<div class="col-md-12 n-p">
					<div id="cardDiv">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete Card<span class="close-div fa fa-times pull-right"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					Do u want to Delete This Card ?</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn" id="<?php echo $cardid ?>" onclick="return DeleteCard(this.id)">Delete</button>
					</div>
					<div class="col-md-6">
						<button class="list-btn" id="closeDelCard">Cancel</button>
					</div>
					</div>
					<div id="unDocardDiv" style="display: none">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete Card...?<span class="close-div fa fa-times pull-right"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					All actions will be removed from the activity feed and you won’t be able to re-open the card.</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn" id="<?php echo $cardid ?>" onclick="return FinalDeleteCard(this.id)">Delete</button>
					</div>
					<div class="col-md-6">
						<button class="list-btn close-div" id="<?php echo $cardid ?>" onclick="return UndoDeleteCard(this.id)"> <span class="fa fa-refresh"></span> Undo</button>
					</div>
					</div>
					<br style="clear: both">
				</div>
			</div>
		</ul>

</div>
</div>
</div>
<!-- label popup starts-->
<div class="col-md-12 b-s popup-container" id="addlabels" >

<div class="col-md-12 n-p" id="LabelDiv">	
	<h6 class="heading">Labels <span class="close-div fa fa-times pull-right"></span></h6>
	<hr>
<form id="labels">
   <input type="text" class="form-control input-md" name="searchLabel" id="searchMember">
</form>
<ul style="margin: 0px; padding: 0px; list-style: none;">
<?php
	$labels = $db->getAlllabels();
	foreach ($labels as $value) {
	$uid = $_SESSION['sess_login_id'];
	$cid = $cardid;
	$label = $value['color'];
	$lid = $value['label_id'];
	$check = $db->checkCardLabel($uid,$cid,$label);
	
	if( $check > 0){
		$display = "block";
		$class = "delete-label";
	}else{
		$display = "none";
		$class = "submit-label";
	}
	$label = $db->getLabelText($uid,$lid);

	?>
	<li style="position:relative"> 
	<span class="label-div <?php echo $class; ?>" id="<?php echo $value['color']; ?>" style="background: <?php echo $value['color']; ?>">
		<span style="color: #fff;position: absolute; top: 15px;"><?php echo $label; ?></span>
		<span class="select-icon2 fa fa-check" style="display: <?php echo $display; ?>">
		</span>
	</span>
	<a href="javascript:void(0)" class="editLabel" id="<?php echo $value['label_id'] ?>" onclick="return showEditLabel(this.id); "> <i class="fa fa-pencil"></i> </a>
	</li>
	<?php
	}
?>
<li class="createLabelLink"><a href="javascript:void(0)" style="color: #000;line-height: 30px;margin-left: 14px;">Create Label</a></li>
</ul>

	<div class="clearfix"></div>
</div>

<div class="col-md-12 n-p" id="editLabelDiv" style="display: none">
<h6 class="heading">
<span class="fa fa-arrow-left pull-left"></span>
 <span class="textHeading">Edit Labels</span></h6>
<hr>
<div id="editLabelDivAjax"></div>
<div class="clearfix"></div>
</div>

	<div class="clearfix"></div>
</div>
<!-- label popup ends  -->

<!-- Add Attachments starts-->
<div class="col-md-12 b-s popup-container" id="attachmentDiv">
<h6 class="popup-heading">Add File<span class="close-div fa fa-times pull-right"></span></h6>
<hr>
<div class="col-md-12 n-p emoji">
<ul style="margin: 0px; padding: 0px; list-style: none;">
<li>
	<form id="submit_form" method="POST" action="upload.php">
	<div class="col-sm-12 n-p clearfix">
		<div class="form-group col-sm-8 n-p">
			<input type="file" name="image" class="form-control input-sm" id="image_file" required>
		</div>
		<div class="form-group col-sm-3 n-p pull-right">
			<input type="submit" class="list-btn" name="uploadimage" id="uploadimage" value="Upload" style="margin-top: 0px;">
		<input type="hidden" name="userid" value="<?php echo $uid; ?>">
<input type="hidden" name="cardid" value="<?php echo $cardid; ?>">			
		</div>
		<div class="clearfix"></div>
	</div>
	</form>
</li>
</ul>
<div class="clearfix"></div>
</div>
</div>

<!-- Add Attachemnts ends -->


</div>
<input type="hidden" id="userid" value="<?php echo $uid; ?>">
<input type="hidden" id="cardid" value="<?php echo $cardid; ?>">


<!--  codeend -->

<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#comments").focus();

});

$(".createLabelLink").click(function(event) {
	$("#editLabelDiv > h6.heading > span.textHeading").text("Create Label");
	$("#LabelDiv").css({'display':'none'});
	$("#editLabelDiv").css({'display':'block'});
});
/* show edit labels */
function showEditLabel(elem){
	var id = elem;
	$.ajax({
		url: 'edit-labels.php',
		type: 'POST',
		data: { 
			id: id
		},
		success: function(data){
		//alert(data);
		$("#editLabelDivAjax").html(data);
		$("#editLabelDiv > h6.heading > span.textHeading").text("Edit Label");
		$("#LabelDiv").css({'display':'none'});
		$("#editLabelDiv").css({'display':'block'});
		}
	});	
}

$(".fa-arrow-left").click(function(event) {
	/* Act on the event */
	$("#LabelDiv").css({
		'display':'block'
	});
	$("#editLabelDiv").css({
		'display':'none'
	});
});


/* Add attachments starts */
	$("#submit_form").on('submit', function(e) {
	e.preventDefault();
	var cardid = $('#cardid').val();
	$.ajax({
		url: 'add-attachment.php',
		type: 'POST',
		data: new FormData(this),
		contentType: false,
		processData:false,
		beforeSend:function(){
			$("#uploadimage").val("uploading....");
		},
		success: function(data) {
			$("#uploadimage").val("Upload");

			$("#attachmentDiv,.imagePreviewDb").css('display','none');
			$(".imagePreview"+cardid).css('display','none');
			$image = '<img src="<?php echo $path ?>" class="img-responsive">';

			$(".imagePreview").html($image).css({'margin-bottom':'15px'});
			$(".imagePreviewDb"+cardid).html($image);

			$("#image_file").val("");
		}
	});

	});	
/* Add Attachmetns ends */


/* make cover starts */

jQuery(document).on('click', '.make_cover', function(event) {
	event.preventDefault();
	/* Act on the event */
	var att = $(this).attr('id');
	var dataid = att.split('_');
	var att_id = dataid[1];
	var div = "#"+att;
	var card_id = $("#cardid").val();
	$.ajax({
		url: 'card_cover.php',
		type: 'POST',
		data: {
			action:'make_cover',
			att_id: att_id,
			card_id: card_id
		},
		success: function(data){
			$("#attachmentDiv,.imagePreviewDb").css('display','none');
			$(".imagePreview"+card_id).css('display','none');
			$(".imagePreview").css('display','block');
			$(".imagePreview").html(data).css({'margin-bottom':'15px'});
			$(".imagePreviewDb"+card_id).html(data);
			$("#image_file").val("");
			$remove_cover = '<span class="fa fa-picture-o"></span> Remove Cover';
			$make_cover = '<span class="fa fa-picture-o"></span> Make Cover';
			
			$('.remove_cover').html($make_cover);
			$('.remove_cover').addClass('make_cover').removeClass('remove_cover');
			$(div).html($remove_cover);
			$(div).addClass('remove_cover').removeClass('make_cover');

		}
	});
	
	
});

jQuery(document).on('click', '.remove_cover', function(event) {
	event.preventDefault();
	/* Act on the event */
	var att = $(this).attr('id');
	var dataid = att.split('_');
	var att_id = dataid[1];
	var div = "#"+att;
	var card_id = $("#cardid").val();
	$.ajax({
		url: 'card_cover.php',
		type: 'POST',
		data: {
			action: 'remove_cover',
			att_id: att_id,
			card_id: card_id
		},
		success: function(data){
			//alert(data);
			$("#attachmentDiv,.imagePreviewDb").css('display','none');
			$(".imagePreview").css('display','none');
			$("#image_file").val("");
			$make_cover = '<span class="fa fa-picture-o"></span></a> Make Cover';
			
			$('.make_cover').html($make_cover);
			$(div).html($make_cover);
			$(div).addClass('make_cover').removeClass('remove_cover');
		}
	});
});


/* make cover ends*/

/* edit label */
$(document).on('click','.edit-labels', function(event) {
  $("#addlabels").addClass('floatingPopupLeft').removeClass('floatingPopupRight').css({'display':'block','top':'0px','right':'0px'});
});
function showaddlabels(){
  $("#addlabels").addClass('floatingPopupRight').removeClass('floatingPopupLeft').css({'display':'block','top':'129px','right':'-140px'});
}
function showaddDueDate(){

	$("#addDueDate").css({"display":"block","top":"50px;"});
}

jQuery(document).on('click', '.submit-label', function(event) {
	var label_text = $(this).attr('id');
	var cardid = $("#cardid").val();
	var userid = $("#userid").val();
	//alert(id);
	$.post(
		'submit-card-label.php', 
		{
			cardid: cardid,
			label_name: label_text,
			userid: userid
		 }, 
		function(response){
		//alert(response);
		$("#activityDiv,#cardLabels").css({'display': 'inline-block'});
		$("#cardLabels").html(response);
		
	});
});

jQuery(document).on('click', '.delete-label', function(event) {
	var label_text = $(this).attr('id');
	var cardid = $("#cardid").val();
	var userid = $("#userid").val();
	//alert(id);
	$.post(
		'delete-card-label.php', 
		{
			cardid: cardid,
			label_name: label_text,
			userid: userid
		 }, 
		function(response){
		//alert(response);
		$("#activityDiv,#cardLabels").css({'display': 'inline-block'});
		$("#cardLabels").html(response);
		
	});
});
$(".close-div,#closeDelCard").click(function(event) {
		var card_listid = "#<?php echo $cardID; ?>";
		$(card_listid).css({"display":"block"});
		$("#desc").val("");
		$(".editDescDiv,#addmembers,#DelCard_,#alert-msg,#emojiDiv,#addlabels,#addDueDate,#attachmentDiv").css({'display': 'none'});
		$("#activityDiv").css({'display': 'block'});
	});

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

	$("#editDesc").click(function(event) {
		//alert();
		$("#desc").val();
		$("#activityDiv").css({'display': 'none'});
		$(".editDescDiv").css({'display': 'block'});
	});
	$("#saveCardDesc").click(function(event) {
		var desc = $("#desc").val();
		var cardid = $("#card").val();
		var data = "card="+cardid+"&desc="+desc;
		//alert(data);
		$.post('card-description.php', {data: data }, function(response) {
			//alert(response)	;
			$(".editDescDiv").css({'display': 'none'});
			$("#desc").val("");
			$("#CardDesc").html(response);
			$("#activityDiv").css({'display': 'block'});
		});
	});
	$("#saveCardComments").click(function(event) {
		var comments = $("#comments").val();
		var cardid = $("#cardc").val();
		var user_id = $("#userid").val();
		if(comments == ""){
			$("#comments").focus();
		}else{
			var data = "card="+cardid+"&comm="+comments+"&userid="+user_id;
		//alert(data);
		$.post('card-comments.php', {data: data }, function(response) {
			alert(response);
			$("#cardCommetns").html(response);
			$("#comments").focus().val("");
		});
		}

	});
	function addEmoji(elem){
		var code = elem;
		//alert(code);
		var box = "#comments";
		$(box).val($(box).val()+code);
		$("#emojiDiv").css({ 'display':'none'});
		
	}

	$("#searchemoji").keyup(function(event) {
		/* Act on the event */
		var name = $(this).val();
		var emoji = ".emoji";
		var emojiDiv = ".emojiresult";
		//alert(name);
		if(name != ""){
		$.post('search-emojis.php', {data: name }, function(response) {
			//alert(response);
			$(emoji).css({"display":'none'});
			$(emojiDiv).css({"display":'block'});
			$(emojiDiv).html(response);
		});
		}else{
			$(this).focus();
			$(emoji).css({"display":'block'});
			$(emojiDiv).css({"display":'none'});
		}
	});
	
	
	function updateComment(elem){
		var id = elem;
		var comm_div_ = "#comm_div_"+id;
		var display_comm_ = "#display_comm_"+id;
		var com_act_ = "#com_act_"+id;
		var comments_ = "#comments_"+id;
		var comments = $(comments_).val();
		var details = "id="+id+"&comment="+comments;
		//alert(details);
		$.post('update-card-comments.php', {data: details }, function(response) {
			//alert(response);
			$(comm_div_).css({"display":'none'});
			$(display_comm_).css({"display":'block'});
			$(com_act_).css({"display":'block'});
			$(display_comm_).html(response);
		});
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

	function DeleteCard(elem){
		var id = elem;
		var card_listid = "#<?php echo $cardID; ?>";
		$.post('delete-card.php', {data: id }, function(response) {
			if(response == "update"){
				$(card_listid).css({"display":"none"});
				$("#cardDiv").css({"display":"none"});
				$("#unDocardDiv").css({"display":"block"});
			}else{
				alert(response);
			}
			//alert(response);
			//$("#cardCommetns").html(response);
		});
	}

	function UndoDeleteCard(elem){
		var id = elem;
		var card_listid = "#<?php echo $cardID; ?>";
		$.post('undo-card.php', {data: id }, function(response) {
			if(response == "undoSuccess"){
				$(card_listid).css({"display":"block"});
				$("#DelCard_").css({"display":"none"});
			}else{
				alert(response);
			}
			//alert(response);
			//$("#cardCommetns").html(response);
		});
	}
	function FinalDeleteCard(elem){
		var id = elem;
		$.post('final-delete-card.php', {data: id }, function(response) {
			if(response == "finalDelete"){
				$("#DelCard_,#cardModal").css({"display":"none"});
			}else{
				alert(response);
			}
			//alert(response);
			//$("#cardCommetns").html(response);
		});
	}

	function ShowCard(){
		var card_listid = "#<?php echo $cardID; ?>";
		$(card_listid).css({"display":"none"});
		$("#DelCard_,#alert-msg").css({"display":"block"});
	}

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
function editCardTitle(clicked){
  var id = clicked;
  //alert(id);
  var cardid = "<?php echo $_REQUEST['data']; ?>";
  var token = document.getElementById("token").value;
  var list_name = document.getElementById(id).value;
  var data = "name="+list_name+"&title_id="+id;
 // alert(data);
 	$.post('edit-card-title.php', {data: data }, function(response) {
		//alert(response)	;
		$(id).html(response);
		$(cardid).html(response);
	});
  return false;
}


function ShowHideAddMembers(){
	$("#addmembers").css({"display":"block","top":"50px"});
}
$(".js-comment-add-emoji").click(function(event) {
	/* Act on the event */
	$("#emojiDiv").css({'display':'block','top':'113px','right':'-300px'});
});
$(".js-comment-add-attachment").click(function(event) {
	/* Act on the event */
	$("#attachmentDiv").css({'display':'block','top':'157px','right':'-57px','minHeight':'318px'});
});

//code by vinay

$('#attachment').click(function(){
$("#attachmentDiv").css({'display':'block','top':'157px','right':'-57px','minHeight':'318px'});
$('#attachmentDiv').show();
});

function copydata(){
	$("#copydataid").css({'display':'block','top':'-450px','right':'-57px','minHeight':'318px','position': 'absolute'});
$('#copydataid').show();

}
$('.close-div').click(function(event) {
 $("#copydataid").hide();
});
function Movedata(){
	$("#movedataid").css({'display':'block','top':'-450px','right':'-57px','minHeight':'318px','position': 'absolute'});
$('#movedataid').show();
}
$('.close-div').click(function(event) {
 $("#movedataid").hide();
});
function Checklist(){
	$("#Checklistdiv").css({'display':'block','top':'140px','right':'0px','minHeight':'318px','position': 'absolute'});
$('#Checklistdiv').show();
}
$('.close-div').click(function(event) {
 $("#Checklistdiv").hide();
});
</script>
<script>


function addMyMember(board_id,userId,cardId,menberId,myname,idjs){
	var myid = $(this).attr("id");
    
	if($('#'+idjs).length){
		$('#show_me').append("<p style=color: #000;>"+myname+"</p>");
		$('#'+idjs).removeClass("hiddeni tog_bg");
		$('.my_check_right').addClass("my_new_class");
	}


	var addmenber='addmenber';
	$.ajax({
		url: 'profile_ajax.php',
		type: 'POST',
		data: { board_id: board_id,userId:userId,cardId:cardId,addmenber:addmenber,menberId:menberId},
		success: function(data){
		
		}
	});
	
}

$('.addchecklist').bind('click', function(event) {
	var comments = $("#checkcomments").val();
		var cardid = $("#cardc").val();
		var user_id = $("#userid").val();
		if(comments == ""){
			$("#checkcomments").focus();
		}else{
			var data = "card="+cardid+"&comm="+comments+"&userid="+user_id;}
			$.post('checklist-comments.php', {data: data }, function(response) {
			$("#checklist").html(response);
			
		});
		
		
});

function add_item(id){
	var additem = $('#additemkm'+id).val();
	var data = "additem="+additem+"&checklist_id="+id;
	$.post('checklist-item.php', {data: data }, function(response) {
		$("#my_check_item"+id).html(response);
			
    	});
}

$( document ).ready(function() {
$('input[id^="additem"]').on('click', function() {  
   $('#'+this.name).show();
});

$('div[id^="close_item"]').on('click', function() {  
    $('#'+$(this).find('span').html()).hide();
    $('#additem').show();
});


});



</script>