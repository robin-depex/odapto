<?php
error_reporting(0);
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//echo $_REQUEST['data'];
$_SESSION['opencard']=$_REQUEST['data'];
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
$_SESSION['boardid'] = $boardid;
$_SESSION['cardid'] = $cardid;
$_SESSION['list_id'] = $list_id;
  $singluserdata = $db->get_single_data('tbl_users',array('ID' => $uid));

?>
<div class="col-md-12">
<div class="imagePreview"></div>
<?php  
$coverimage = $db->getCoverImage($cardid);
if(isset($coverimage)) { foreach ($coverimage as $key => $valuecover) {
//$image= 'https://www.odapto.com/'.$valuecover["cover"];

if($valuecover['background']==0)
{
	$class='div-border';
}

?>
 
<style type="text/css">
 .google-drive{   margin-right: 20px;
    background: url("https://a.trellocdn.com/dist/images/services/google-drive-preview-logo.64011cc7e495af6d55d0.svg");
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
}

.dropbox{   margin-right: 20px;
    background: url("https://a.trellocdn.com/dist/images/services/dropbox-preview-logo.275d8a966e5d9d2b8e22.svg");
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
}
.choose-btn{
	background: #3a3a3a !important;
    color: #fff !important;
    padding: 6px 22px !important;
    text-align: left;
    transition: all ease-in-out .5s;
}
.choose-btn:hover{
	transition: all ease-in-out .5s;
	background: #f56d39 !important;
    color: #fff !important;
    padding: 6px 22px !important;
    text-align: left;
}
.dropbox-dropin-btn{
    padding: 9px 1px !important;
    color: #fff !important;
    border-radius: 4px !important;
    background: #3b3b3b !important;
    height: auto !important;
    font-size: 14px !important;
    font-weight: 400 !important;
    display: block !important;
}

.dropbox-dropin-btn:hover{
    padding: 9px 1px !important;
    color: #fff !important;
    border-radius: 4px !important;
	transition: all ease-in-out .5s;
	background: #f56d39 !important;
    height: auto !important;
    font-size: 14px !important;
    font-weight: 400 !important;
    display: block !important;
}
.drive-bg{
	position: relative;
}
.drive-bg:after{
    content: '';
    position: absolute;
    left: 4px;
    top: 9px;
    z-index: 999999999999;
    background: url(images/Google-Drive-Icon.ico);
    width: 18px;
    height: 17px;
    background-size: contain;
}
.checklist .progress{
    height: 5px;
    margin-bottom: 20px;
}
.checklist .progress .progress-bar > p{
    position: absolute;
    left: -30px;
    color: #000;
    font-size: 10px;
}
.list-btn {
    background: #2a8171;
    padding: 5px 10px;
    color: #FFF;
    font-size: 10px;
    font-weight: 400;
    letter-spacing: 1px;
    margin-top: 7px;
    display: inline-block;
    border-radius: 4px;
    cursor: pointer;
    border: 0px;
}

#CardDesc{
    display:inline-block !important;
}
</style>
<div class="imagePreviewDb <?php echo $class;?>" style="background-color: #<?php echo $valuecover['background'];?>;">
  <img src="attachments/<?php echo $valuecover['cover']; ?>" class="img-responsive" id="cover_img">
</div>

<?php
} }
?> 
</div>
<div class="clearfix"></div>
<br clear="all">
<div class="col-md-11 n-p" id="alert-msg" style="display: none;">
	<div class="progress" style="height:30px !important;">
  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;padding-top:6px; padding-left: 20px; text-align: left !important;">
    <span style="font-size:16px;">This card will be deleted.....?</span>
  </div>
</div>
</div>
<div class="col-md-12">
<h3 style="margin:0px ">
<form action="" method="post">
  <input type="text" class="cd-head list-Title" id="cardid_<?php echo $cardid; ?>" title="<?php echo ucfirst($card_title); ?>" onblur="return editCardTitle(this.id)" value="<?php echo ucfirst($card_title); ?>">
</form>
</h3>
<h5 style="margin:0px ">in List: <?php echo $list_title; ?></h5>
<div class="clearfix"></div>

 	
</div>

<div class="clearfix"></div>
<div class="col-md-12 n-p" id="activityDiv">
<div class="col-md-9 n-p">
<div class="col-sm-12">
<div class="memberdata">
 		<?php $my_user_id=$db->membersAjax($cardid);
 	//	print_r($my_user_id);completeStatus 
$countmember = count($my_user_id ?? []);
 ?>
<h5>Member</h5>
<!--<form action="" method="post">-->
<ul id="show_me1" class="list-inline">

<?php
if(isset($my_user_id)) { foreach ($my_user_id as $value) {
$result = $db->getUserMeta($value);
?>
 <li class="show_me_<?php echo $value; ?>" id="show_me_<?php echo $value; ?>" style="color: #000;"><span id="profile_initials"><?php echo $result['initials']?></span></li>
 <?php
} }
 ?>
  </ul>
</div>
<!--</form>-->

<!--Card label color start-->
<!-- Card Labels Starts-->
<div class="clearfix"></div>

<div class="cardlabelColor col-sm-12 n-p" style="margin-bottom:15px">
	<h5>Labels</h5>
	<?php  
	$labels = $db->getAllCardLabels($cardid);
?>
	<ul class="cardLabelDataColor list-inline">
	<!--<li id="cardLabels" style="display: block"></li>-->
	<?php  
	if(count($labels ?? []) > 0){
	?>
	
	<?php	
		foreach ($labels as $value) {
			//echo"<pre>";
			//print_r($value);
			$label = $db->getLabelText($uid,$value['labels']);	
			//print_r($label);
		$lid = $db->getLabelId($label['label_id']);	
		$lbldata = $db->getLabeldata($label['label_id']);
		//print_r($lbldata);
		
		?>
		
		<li style="background: <?php echo $lbldata['color']; ?>;" class="cardLabels<?php echo $value['labels']; ?> card-lables edit-labels"><?php if(!empty($label['label_name'])){ echo $label['label_name']; }else{ echo "&nbsp;";} ?></li>
		
		<?php
		}
	}
	?>
	</ul>
	
</div>





<!--Card label color end-->

<!--Due Date start-->
<div class="clearfix"></div>

<div class="cardduedate col-sm-12 n-p" style="margin-bottom:15px">
	<h5>Due Date</h5>
	<?php  
	$duedatedata = $db->getbordlistduedate($cardid);
?>
	<ul class="cardduedatelistnew list-inline">
	<!--<li id="cardLabels" style="display: block"></li>-->
	<?php  
	if(count($duedatedata ?? []) > 0){
		if($duedatedata['complete_status']==0){
if($duedatedata['duedate']<date('Y-m-d')){
$background = '#e91515';
}else{
	$background = '#8c8c8c';
}
		}else{
$background = 'green';
		}
	?>
	<li style="background: <?php echo $background ?>;"  class="cardduedatelist1">
			<input type="checkbox" onclick="completeStatus(<?=$cardid?>,'<?php echo $background;?>')" <?php if($duedatedata['complete_status']==1){ echo 'checked';} ?> id="duedate_<?php  echo $cardid ?>"> &nbsp; &nbsp;
			<span style="color:#fff"><?php echo $duedatedata['duedate']; ?>&nbsp; at <?php echo $duedatedata['duetime']; ?></span></li>
		
		<?php
		
	}
	?>
	</ul>
	
</div>
<!--Due Date End-->
<div class="col-sm-12 memberdata">
	<h5>Description</h5>
<span style="margin-bottom:10px;display: inline-block;" id="CardDesc"><?php echo $card_description; ?></span>
<a href="javascript:void(0)" id="editDesc" style="color: #606060;color: #606060;position: absolute;right: 10px;top: 8px;">
<span class="fa fa-pencil"></span></a>

<div class="col-md-12 editDescDiv">
<div class="col-md-12 n-p">
	<form method="post">
		<div class="form-group">
		<textarea class="form-control" rows="3" id="desc" style="border-radius: 0px;"><?php echo $card_description; ?></textarea>
		<input type="hidden" id="card" value="<?php echo $cardid; ?>">
		<button class="list-btn" type="button" id="saveCardDesc"> Save Description</button>

		<span class="fa fa-times close-div" id="close_div" ></span>
		</div>
	</form>
	</div>
</div>
</div>
</div>
<div class="col-md-12">
<!-- Card Labels Ends -->

<!-- Card Attachments  Starts -->

<div class="Attachemnts_div" id="Attachemnts_div">
<div class="col-sm-12 n-p">
<h4> <span class="fa fa-paperclip"></span> Attachments</h4>
</div>
<?php  
$attachments = $db->allCardAttachments($cardid);
//print_r($attachments);
//echo json_encode($attachments);
if($attachments > 0){
?>
<?php	
foreach ($attachments as $key => $valueatt) {
if($valueatt['cover'] == 1){
	$cover = "Remove Cover";
	$class = "remove_cover";
}else{
	$cover = "Make Cover";
	$class = "make_cover";
}


$link = $valueatt['images'];

$link_array = explode('=',$link);
$page = end($link_array);	
//echo $page;
if($page=='drive_web')
{
	$bgclass='background-image: url(https://a.trellocdn.com/prgb/dist/images/services/google-drive-preview-logo.64011cc7e495af6d55d0.svg);';
	$strattchnam = $valueatt['title_name'];
}

elseif($page=='0')
{
	$bgclass='background-image:url(https://a.trellocdn.com/prgb/dist/images/services/dropbox-preview-logo.275d8a966e5d9d2b8e22.svg';
	$link_array1 = explode('.',$valueatt['title_name']);
	//$link_array2 = explode('?',$link_array1[5]);
	$strattchnam = $link_array1 [0];
}
if($valueatt['location']!='')
{
	?>

	<div class="col-sm-12 n-p attachment_div deldiv_<?php echo $valueatt['id']; ?>" style="margin-bottom:10px;margin-left: 16px;margin-top: 5px;border: 1px solid #e0e0e0;">

<?php if($valueatt['location']=='evernote'){ ?>

	<div class="col-sm-2 n-p" style="margin-right: 20px;height: 80px;border: 1px solid #e0e0e0;    display: flex;"> 
		<img src="images/evernotset.jpg"  style="height: 66px;width: 100%;max-width: 75px;margin: auto;">
	</div>

	<div style="margin-top:25px" class="col-sm-10 n-p">
	<h4><?php echo $valueatt['title_name']; ?></h4>
		<a href="evernotefinal/viewevernote.php?oth_token=<?php echo $valueatt['evernote_oauth_token'];?>&gid=<?php echo $valueatt['note_guide']; ?>&bgid=<?php echo $valueatt['note_book_guide']; ?>" target="_blank" style="color: #000;margin-right: 8px;"> <span class="fa fa-eye" ></span>View</a>
	
	<a href="javascript:void(0)" class="deleteAttachment"  id="<?php echo $valueatt['id']; ?>"  style="color: #000;margin-right: 8px;"> <span class="fa fa-times"></span> Delete </a>

	</div>	

<?php }else{ ?>
<a href="<?php echo $valueatt['images'];?>" target="_blank">
	<div class="col-sm-2 n-p" style="height: 80px;background-color: white;width: 80px;background-size: cover;<?php echo $bgclass; ?>">
	</div></a> 

	<div style="margin-top:25px" class="col-sm-10 n-p">
		<h4><?php echo $valueatt['title_name']; ?></h4>
		<a href="<?php echo $valueatt['images']; ?>" target="_blank" style="color: #000;margin-right: 8px;"> <span class="fa fa-eye" ></span>View</a>
	
	<a href="javascript:void(0)" class="deleteAttachment"  id="<?php echo $valueatt['id']; ?>"  style="color: #000;margin-right: 8px;"> <span class="fa fa-times"></span> Delete </a>

	</div>	
<?php } ?>

	
	




	</div>  
<?php }else{
	$bgclass='img-responsive';
	$ext = $valueatt['ext'];
	
	?>
	<div class="col-sm-12 n-p attachment_div deldiv_<?php echo $valueatt['id']; ?>" style="margin-bottom:10px;margin-left: 16px;margin-top: 5px;">
 <div class="col-sm-2 n-p <?php echo $bgclass; ?>" style="margin-right: 20px;" >

	  <img src="attachments/<?php echo $valueatt['images']; ?>"  style="height:80px;width: 100%">
 
</div> 
<div class="col-sm-10 n-p">
  	<h4><?php echo $valueatt['title_name']; ?></h4>
		<a href="attachments/<?php echo $valueatt['images']; ?>" download style="color: #000;margin-right: 8px;"> <span class="fa fa-download" ></span> Download </a>
  <!--	<a href="<?php echo $db->site_url?>/attachments/<?php echo $valueatt['images']; ?>" download style="color: #000;margin-right: 8px;"> <span class="fa fa-download" ></span> Download </a>-->
	 
  	<a href="javascript:void(0)" class="<?php echo $class; ?>" id="makeremove_<?php echo $valueatt['id']; ?>"  style="color: #000;margin-right: 8px;"> <span class="fa fa-picture-o"></span> <?php echo $cover ?> </a>
  
  	<a href="javascript:void(0)" class="deleteAttachment"  id="<?php echo $valueatt['id']; ?>"  style="color: #000;margin-right: 8px;"> <span class="fa fa-times"></span> Delete </a>
	
	
		
  	<!--<a href="javascript:void(0)" style="color: #000;margin-right: 8px;"> <span class="fa fa-comments"></span> Comment </a>-->
  	
  </div>	
</div>



<?php }
?>
  <div class="col-md-12 b-s" id="Delattachment_<?php echo $valueatt['id']; ?>" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:relative;top:0px;padding-bottom: 15px;">

				<div class="col-md-12 n-p">
					<div id="cardDiv">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete Attachment...?
						<span class="close-div fa fa-times pull-right" id="<?php echo $valueatt['id'] ?>" onclick="return closeDelAttachmentDiv(this.id)"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					Are you sure you want to delete attachment?</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn" id="<?php echo $valueatt['id']; ?>" onclick="return Delattachment(this.id)">Delete</button>
					</div>
					<div class="col-md-6">
						<button class="list-btn" id="<?php echo $valueatt['id']; ?>" onClick="return closeDelAttachmentDiv(this.id);">Cancel</button>
					</div>
					</div>
					<br style="clear: both">
				</div>
			</div>	
<?php } ?>
<?php } 

	function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>
</div>


</div>
<div class="clearfix"></div>
<!-- Card Attachments Ends   -->

<!-- checklist code by vinay -->
<div class="col-md-12">
<!-- <p style="color:black;">Checklist</p> -->


<div class="col-md-12 n-p" id="checklist" style="display:block;">

	   
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
		<div class="maindata_<?php echo $comm_id; ?>">
		<div class="row">
		<div class="col-sm-10">
		<div style="float:left">
		<div style="margin-top: 20px;" class="checkcomentbox">
		<input style="border: 0;background: none;font-size: 18px;" type="text" DISABLED id="editcheck_<?php echo $comm_id; ?>" value="<?php echo $comments; ?>">
		<!--<h2 style="color: black;"><?php echo $comments; ?></h2>
		-->
		<button style="font-size:10px" id="savechckcommnt_<?php echo $comm_id; ?>" onclick="return updatechecklistComments(<?php echo $comm_id; ?>)" class="savechckcommnt list-btn" style="display:none;" class="btn btn-success">Update</button>
		</div>
		</div>
		</div>
<div style="float:right"> 
	<span id="<?php echo $comm_id; ?>" class="editchecklitsdata fa fa-pencil"></span>
	<span style="margin-left:5px" class="comment-action" id="com_act_<?php echo $comm_id; ?>">
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
						<button class="list-btn"  onclick="return DelcheckliComments(<?php echo $comm_id; ?>)">Delete</button>
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
		

		<div style="padding-left:0" class="col-md-12 checklist" id="checklist_<?php echo $comm_id; ?>">
 

 <div style="margin-top:10px" class="progress" id="progress_<?php echo $comm_id; ?>">
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
<div style="float:left;width:90%;margin-bottom:10px">
<input style="border:0;font-size: 14px;position: relative;top: -5px;" <?php if($status==1){ echo 'checked';} ?> class="checkstatuschecklist" name="locationthemes" value="<?php echo $itemId; ?>" id="<?php echo $comm_id;?>_<?=$itemId?>" type="checkbox">
<label for="<?php echo $comm_id;?>_<?=$itemId?>">

<input style="border:0;font-size: 14px;position: relative;top: -5px;<?php if($status==1){ ?> text-decoration: line-through; <?php } ?>" type="text"  DISABLED id="editcheckitem_<?php echo $itemId; ?>" value="<?=$itemname?>">
</label>

<button id="savechckitemcommnt_<?php echo $itemId; ?>" onclick="return updatechecklistitemComments(<?php echo $itemId; ?>)" class="savechckitemcommnt list-btn" style="display:none;" class="btn btn-success">Update</button>
</div>

<div style="float:right">
<span style="cursor:pointer" onclick="return Showchecklistitem(<?php echo $itemId; ?>)"  class="editchecklitsitemdata fa fa-pencil"></span>
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


				<div style="display: block;" id="checklistitem<?=$comm_id?>">

					<input type="text" id="additemkm<?=$comm_id?>" class="checklist-new-item-text form-control" style="background-color: #fff;" placeholder="Add an item…">


					<input type="text" style="display: none;" name="checklist_id<?=$comm_id?>" id="checklist_id<?=$comm_id?>" value="<?=$comm_id?>">

					<button class="list-btn" id="add_item<?=$comm_id?>" onclick="return add_item(<?=$comm_id?>)">add</button>
</div>

  
		</div>


</div>


		<?php
		}
	?>


	</div>
</div>


<div class="clearfix"></div>
<!-- end checkList code -->
<div class="col-sm-12">
<div class="col-sm-12" style="height:auto !important;padding-right: 10px; padding-left: 0px;">
	<h3 style="color:#606060;font-size:14px;letter-spacing: 1px;" ><span class="fa fa-comments"></span> Add Comments</h3>
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
			<button class="list-btn" type="button" id="saveCardComments"> Comment </button>
		</div>
	</form>
	<div class="clearfix"></div>
	<!--<h3 style="color:#606060;font-size:16px;font-weight: bold;letter-spacing: 1px;"><span class="fa fa-comments"></span> Activities:</h3>-->
	<div class="col-md-12 n-p" id="cardNotification">

	<?php 
	 	$notification = $db->getCardNotification($cardid);
		 foreach ($notification as $value) {
			$title = $value['title'];
			$message = $value['message'];
			$user_from = $db->getUserMeta($value['user_from']);
			$user_to = $db->getUserMeta($value['user_to']);
			$list_id = $value['list_id'];
			$notify_date_time = $db->dateDiff($value['notify_date_time']);
		?>
		<div class="col-md-12" id="cardnotiicationfMainDiv">
			
			<div class="col-md-10 n-p" style="width: 88%">
				<h3 class="name">
	      			<span class="heading"><?php echo $result['full_name']; ?></span>
	      		</h3>
	      		<span class="time-ago pull-right">
	      				<?php echo $notify_date_time; ?> ago
	      		</span>
	      		<p class="cardsnotify" id="display_notify">
	      		 <?php 
	      		 $regex = "/#+([a-zA-Z0-9_-]+)/";
	      		 $str = preg_replace($regex, '<img src="'.SITE_URL.'smile/$1.png" style="width:20px">', $message);
	      		 echo $str;
	      		 ?></p>
				 

	      		<!-- comment edit -->
	      		
			</div>


		</div>
		<?php
		 }
	?>		


	</div>
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
	      		 $str = preg_replace($regex, '<img src="'.SITE_URL.'smile/$1.png" style="width:20px">', $comments);
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
</div>
<button class="btn btn-primary" onclick="reloadPage()">Done</button>
<div class="col-md-3 side-div">
		<h3 style="color:#606060;font-size:16px;font-weight: bold;letter-spacing: 1px;"><span class="fa fa-plus"></span>Add:</h3>
		<hr>
		<div class="clearfix"></div>
		<ul style="list-style-type: none;padding: 0px;">
		<li class="side-list" onclick="return ShowHideAddMembers()">
			<a href="javascript:void(0)"><i class="fa fa-user" aria-hidden="true"></i> Members</a>
		</li>
<?php $mclass = 'col-md-12 b-s popup-container ui-widget-content'; 
function mod_heading($heading){
return '<h6 class="heading">'.$heading.' <span class="close-div fa fa-times pull-right"></span></h6>';
}
?>
		<div class="<?php echo $mclass; ?>" id ="addmembers">
			<?php echo mod_heading('Members'); ?>
			<div class="model-container">
			<form id="teamMember">
			    <input type="hidden" id="m_bid" value="<?php echo $boardid ?>">
			    <input type="text" class="form-control input-md" name="searchMember" autocomplete="off" id="searchBoardMember" > 
			</form>
			<h6 class="heading">Board Members</h6>
			
			<div id="result_member"></div>
			<div class="col-md-12 n-p boardMembers">
			<ul style="margin: 0px; padding: 0px; list-style: none;" id="my_id">
				<?php

					$member = $db->getBoardmembers($boardid);
                    $countmember = count(explode(',',$member));
                    if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
						$mamb = $db->BoardCardMembers($value,$_SESSION['cardid']);
						

						?>
						<li <?php
						if($value==$mamb){
							echo 'class="meber'.$value.' my_check_right my_class"';
							$idjs='hide_me'.$value;
						}
						else{
							echo 'class="meber'.$value.' my_check_right hiddeni tog_bg"';
							$idjs='showme'.$value;
						}
						

						?> style="margin: 5px 0px;padding: 3px; background-color: #e8e8e8; border:1px solid #eeeeee;" onclick="addMyMember(<?=$boardid?>,<?=$result[0]?>,<?=$list_id?>,<?=$cardid?>,<?=$value?>,'<?=$result['initials']?>','<?=$idjs?>')" id="meber<?php echo $result[0] ?> <?=$idjs?>"><span id="profile_initials"><?php echo $result['initials']; ?>
						</span> 

						<span class="heading"><?php echo $result1['Email_ID'] ;  ?></span>
						<span class="icon-sm icon-check checked-icon"></span>
						</li>
						<?php
					}
					
					}
				?>
			</ul>
			<div class="clearfix"></div>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
				    
					$('input[name=searchMember]').on('keyup', function() {
					    
					  var email = $("#searchBoardMember").val();
                      var bid = $("#m_bid").val();
                      
                      var type = "board";
                        var data = "type="+type+"&email="+email+"&bid="+bid;
                        $.post('./add-members.php', {data: data}, function(response) {
                            $("#result_member").css({'display':'block'});
                            $("#result_member").html(response);
                            /*$("#textAdd").css({'display':'none'});*/
                        });
					    
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

			 $(document).ready(function(){ 
					$('input[id=searchlabel]').on('keyup', function() {
						var value = $(this).val();
				 var patt = new RegExp(value, "i");
				  $('#my_lab').find('li').each(function() {
				    if (!($(this).find('span').text().search(patt) >= 0)) {
				      $(this).not('.labmyname').hide();
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
		</div>

		<li class="side-list">
		<a href="javascript:void(0)" onclick="return showaddlabels()"> <i class="fa fa-tags" aria-hidden="true"></i> Labels</a>
		<!-- Label Popup --></li>
			<li class="side-list">
			<a href="javascript:void(0)" onclick="Checklist()"> <i class="fa fa-list" aria-hidden="true"></i> Checklist</a>
		</li>

		<div class="<?php echo $mclass; ?>" id="Checklistdiv">
			<?php echo mod_heading('Checklist'); ?>
			<div class="model-container">	
			
			<div class="col-md-12 n-p boardMembers">
			<h3>Title</h3>
			<!--<textarea class="form-control comment" id="checkcomments" rows="3" style="border-radius: 0px;"></textarea>-->
			<input type="text" class="form-control comment" id="checkcomments" style="border-radius: 0px;">
			<input type="hidden" class="form-control oldcomentid" id="oldcomentid" value="" style="border-radius: 0px;">
        <div class="form-group">
			<h5><strong>Copy to…</strong></h5>


			<select class="form-control" id="checklistolddata" name="checklistolddata" class="checklistolddata">
			<option></option>
			<?php
			$result = $db->getCardCheckList($cardid);
			foreach ($result as $value) {
			$comm_id = $value['id'];
			$userid = $value['userid'];
			$comments = $value['comments'];
			  ?>
		    <option value="<?=$comments;?>,<?php echo $comm_id; ?>"><?=$comments?></option>
		    <?php
			}
			
			
			
			/*$result = $db->getCardCheckList($cardid);
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
			}*/
		  ?>
		</select>
		</div>
		  <div class="form-group">
			<button class="list-btn addchecklist">Add</button>
		</div>	
			<div class="clearfix"></div>
			
			</div>
		</div>
		</div>
<script>

$('.addchecklist').bind('click', function(event) {
	var comments = $("#checkcomments").val();
		var cardid = $("#cardc").val();
		var user_id = $("#userid").val();
		var oldcomentid1 = $("#oldcomentid").val();
		if(oldcomentid1==''){
			var oldcomentid = 0;
}else{
	var oldcomentid = oldcomentid1;
}
		if(comments == ""){
			$("#checkcomments").focus();
		}else{
			var data = "card="+cardid+"&comm="+comments+"&userid="+user_id+"&oldcomentid="+oldcomentid;
			
			$.post('checklist-comments.php', {data: data }, function(response) {
			//$("#checklist").append(response);
				$("#checklist").html(response);
			$("#checkcomments").val('');
			$("#oldcomentid").val('');
			$('#checklistolddata option:not(:selected)');
			$('#Checklistdiv').css('display','none');
			$.post('checklist-comments1.php', {cardid: cardid }, function(response1) {
$('#checklistolddata').append(response1);
			});
		});
		
		}
});
function addMyMember(board_id,userId,listId,cardId,menberId,myname,idjs){
    
	var myid = $(this).attr("id");
	//alert(myid);
  var addmenber='addmenber';
	$.ajax({
		url: 'profile_ajax.php',
		type: 'POST',
		data: { board_id: board_id,userId:userId,listId:listId,cardId:cardId,addmenber:addmenber,menberId:menberId},
		success: function(data){
			//alert(data);
			//alert('#meber'+userId);
		if(data==1){
			$('#show_me1').append("<li class='show_me_"+menberId+"' id='show_me_"+menberId+"' style='color: #000;'><span id='profile_initials'>"+myname+"</span></li>");
			$('.meber'+menberId).removeClass("hiddeni tog_bg");
		$('.meber'+menberId).addClass("my_check_right my_class");
		}else{
			$('.show_me_'+menberId).css('display','none');
			$('.meber'+userId).addClass("hiddeni tog_bg");
		$('.meber'+userId).removeClass("my_check_right my_class");
		}
		}
	});
	
}



function addMylabel(board_id,userId,labelId,listId,cardId,idjlab,labelname,labelColor){
	var myid = $(this).attr("id");
	if(labelname==''){
var labname = '&nbsp';
	}else{
var labname = labelname;
	}
	//alert(labname);
  var addlabel='addlabel';
  
	$.ajax({
		url: 'profile_ajax.php',
		type: 'POST',
		data: { board_id: board_id,userId:userId,listId:listId,cardId:cardId,addlabel:addlabel,labelId:labelId,idjlab:idjlab,labelname:labelname,labelColor:labelColor},
		success: function(data){
		if(data==1){
			$('#'+idjlab).removeClass("hiddeni tog_bg");
		$('#'+idjlab).addClass("my_check_right my_class");
		$('.cardLabelDataColor').append("&nbsp;<li style='background:"+labelColor+"' class='cardLabels"+labelId+" card-lables edit-labels'>"+labname+"</li>");

		}else{
			$('.cardLabels'+labelId).css('display','none');
		$('#'+idjlab).addClass("hiddeni tog_bg");
		$('#'+idjlab).removeClass("my_check_right my_class");
		}
		}
	});
	
}



function add_item(id){
	var additem = $('#additemkm'+id).val();
	if(additem==""){
		$('#additemkm'+id).focus();
	}else{
	var data = "additem="+additem+"&checklist_id="+id;
	$.post('checklist-item.php', {data: data }, function(response) {
		//$("#my_check_item"+id).append(response);
		$('#additemkm'+id).val('');	
		$("#checklist_"+id).html(response);
    	});	
	}
	
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

function reloadPage()
{
    document.getElementById('cardModal').style.display = "none";
    window.location.reload();
     
}


</script>
<script>
$('#checklistolddata').change(function(){
	var chkoldata = $(this).val();
	var result = chkoldata.split(',');
	$('#checkcomments').val(result[0]);
	$('#oldcomentid').val(result[1]);
});

</script>



		<li class="side-list">
		<a href="javascript:void(0)" onclick="return showaddDueDate()"> <i class="fa fa-calendar-o" aria-hidden="true"></i> Due Date</a>
	
		<!--  Calender -->	
<div class="<?php echo $mclass; ?>" id="addDueDate">
			<?php echo mod_heading('Change Due Date'); ?>
			<div class="model-container">
			<?php $duedatedata = $db->getbordlistduedate($cardid);
                  $countduedate = count($duedatedata ?? []);
			 ?>		
			
			<div class="col-md-12 n-p Labels" style="min-height: 235px;">
				<div class="form-group">	
   <label class="heading">Date</label>	
   <input type="text" class="date start form-control" value="<?php echo $duedatedata['duedate'] ?? ''?>" name="duedate" id="duedate">
   <!--<input type="date" class="date start form-control" value="<?php echo $duedatedata['duedate'] ?? ''?>" name="duedate" id="duedate">-->
 </div>

 <div class="form-group">	
   <label class="heading">Time</label>	
   <!--<input type="text" class="form-control input-md" value="<?php echo $duedatedata['duetime'] ?? ''?>" name="duetime" id="duetime">-->
   <input type="text" placeholder="Select Time" class="single-input form-control" name="duetime" value="<?php echo $duedatedata['duetime'] ?? ''?>" id="duetime">
   
 </div>
<div class="clearfix"></div>
 <div class="form-group">	
 	<input type="hidden" id="duecardid" value="<?php echo $_SESSION['cardid']; ?>">
	 <input type="hidden" id="duelistid" value="<?php echo $_SESSION['list_id']; ?>">
 	<input type="hidden" id="dueuserid" value="<?php echo $_SESSION['sess_login_id']; ?>">
 	<input type="hidden" id="dueboardid" value="<?php echo $_SESSION['boardid'] ; ?>">
   <button type="button" class="form-control btn btn-primary" name="saveduedate" id="saveduedate">Save</button>
 </div>
<script>

function completeStatus(cartId,backcolor){

var updatecompletestats='updatecompletestats';
$.ajax({
		url: 'profile_ajax.php',
		type: 'POST',
		data: {cartId:cartId,updatecompletestats:updatecompletestats},
		success: function(data){
			//alert(data);
		if(data==1){
			var colorname = 'green';
			$('.cardduedatelist1').css('background-color',colorname);
			 $('#duedate_'+cartId).attr('checked',true);
		}else{
		if(backcolor=='#e91515'){
			var colorname = 'red';
		}else{
			var colorname = 'gray';
		}
				$('.cardduedatelist1').css('background-color',colorname);
			 $('#duedate_'+cartId).attr('checked',false);
		}
		}
	});
}
$('#saveduedate').click(function(event){
	var duedate = $('#duedate').val();
	var duetime = $('#duetime').val();
	var cardid = $('#duecardid').val();
	var listid = $('#duelistid').val();
	var userid = $('#dueuserid').val();
	var boardid = $('#dueboardid').val();

var addduedate='addduedate';

	$.ajax({
		url: 'profile_ajax.php',
		type: 'POST',
		data: {listid:listid,cardid:cardid,userid:userid,addduedate:addduedate,duedate:duedate,duetime:duetime,boardid:boardid},
		success: function(data){
			//alert(data);
			//alert('#meber'+userId);
			if(new Date(duedate) < new Date()){
				var color = 'red';
			}else{
var color = '#8c8c8c';
			}
		if(data==1){
			var backcolor = "'#8c8c8c'";
			$('.cardduedatelistnew').append('<li onclick="completeStatus('+cardid+','+backcolor+')" style="background: '+color+';" class="cardduedatelist1"><input type="checkbox" id="duedate_'+<?php echo $_SESSION['cardid'] ?>+'"><u>'+duedate+'&nbsp; at '+duetime+'</u></li>');
			$('#addDueDate').css("display",'none');
		}else if(data==0){
			
			var backcolor = "'#8c8c8c'";
				$('#addDueDate').css("display",'none');
				$('.cardduedatelistnew').html('');
				$('.cardduedatelistnew').append('<li onclick="completeStatus('+cardid+','+backcolor+')" style="background: '+color+'" class="cardduedatelist1"><input type="checkbox" id="duedate_'+<?php echo $_SESSION['cardid'] ?>+'"><u>'+duedate+'&nbsp; at '+duetime+'</u></li>');
		}else if(data==2){
			var backcolor = "'green'";
				$('#addDueDate').css("display",'none');
				$('.cardduedatelistnew').html('');
				$('.cardduedatelistnew').append('<li onclick="completeStatus('+cardid+','+backcolor+')" style="background: green" class="cardduedatelist1"><input checked type="checkbox" id="duedate_'+<?php echo $_SESSION['cardid'] ?>+'"><u>'+duedate+'&nbsp; at '+duetime+'</u></li>');
		}
		}
	});
});
 /*$('.date').datepicker({
                    'format': 'yyyy/m/d',
                    'autoclose': true
                });*/

</script> <!--   <script src="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.standalone.css" />
    <input type="text" class="date start" />
    <input type="text" class="time start" /> -->



            <script>
             /*   $('.time').timepicker({
                    'showDuration': true,
                    'timeFormat': 'g:ia'
                });

                $('.date').datepicker({
                    'format': 'yyyy/m/d',
                    'autoclose': true
                });*/

            </script>
				<?php 
				/*include 'calendar.php';
 
$calendar = new Calendar();
 
echo $calendar->show() */
				//include('calander/index.php');
				?>
			<div class="clearfix"></div>
			</div>
		</div>
</div>		
			</li>
			<li class="side-list"><a href="javascript:void(0)" id="attachment" onclick="dropboxapi()"> <i class="fa fa-paperclip" aria-hidden="true"></i> Attachments</a></li>
		
		<?php if($singluserdata['membership_plan']==3){
if($singluserdata['evernote']==1){
if(!empty($_SESSION['oauth_token'])){
//echo $_SESSION['oauth_token'];
 ?>
		<li class="side-list"><a href="javascript:void(0)" class="evernote" id="evernote">Evernote Notes</a></li>
	
<script>
$(document).ready(function(){
	$('.evernote').click(function(){
		$('#evernoteDiv').css({'display':'block','top':'247px','right':'-57px','minHeight':'318px'});
	});
});
</script>
<!--<li class="side-list"><a href="evernote_final/notesdata.php" id="attachment1" >Evernote</a></li>-->
	<?php	}else{ ?>
<li class="side-list"><a href="evernotefinal/evernoteindex.php" id="evernote">Evernote</a></li>
		<?php } } } ?>

<div class="<?php echo $mclass; ?>" id="evernoteDiv">
<?php echo mod_heading('Evernote List'); ?>
<div class="model-container">
<div class="col-md-12 n-p emoji">
<ul style="margin: 0px; padding: 0px; list-style: none;" id="my_evrnote">
<?php foreach($_SESSION['evernote'] as $evernotelist){ ?>
<li style="position:relative"> 
	<span onclick="addMyevernote('<?php echo $evernotelist['guid']; ?>','<?php echo $evernotelist['notebookGuid']; ?>','<?php echo $_SESSION['oauth_token']; ?>',<?php echo $uid ?>,<?php echo $cardid; ?>,'<?php echo $evernotelist['title']; ?>')" id="showme721" class="label-div my_check_right hiddeni tog_bg" style="background: #b8b7ae">
		<span class="labmyname" ><?php echo $evernotelist['title']; ?></span>
			</span>
	</li>
	<?php } ?>	
</ul>
<div class="clearfix"></div>
</div>
</div>
</div>

<script>
function addMyevernote(guid,notebookGuid,oauth_token,uid,cardid,title){
$.ajax({
		url: 'addevernote.php',
		type: 'POST',
		data: { guid: guid,notebookGuid:notebookGuid,oauth_token:oauth_token,uid:uid,cardid:cardid,title:title},
		success: function(respnoce){
			//alert(respnoce);
			$("#Attachemnts_div").append(respnoce);
		}
	});




}

</script>

	</ul>

		<h3 style="color:#606060;font-size:16px;font-weight: bold;letter-spacing: 1px;"><span class="fa fa-plus"></span>Actions:</h3>
		<hr>
		<ul style="list-style-type: none;padding: 0px;position: relative">
		<li class="side-list">
			<a href="javascript:void(0)" onclick="Movedata()"> <i class="fa fa-arrows" aria-hidden="true"></i> Move</a></li>

			<div class="<?php echo $mclass; ?>" id="movedataid">
			<?php echo mod_heading('Move Card'); ?>
			<div class="model-container">	
			
			<!--<h6 class="heading">Board Members</h6>-->
			<div class="col-md-12 n-p boardMembers">
			<!--<h3>Title</h3>
			<textarea class="form-control comment" id="comments" rows="3" style="border-radius: 0px;"></textarea>-->
            <div class="form-group">
			<h5><strong>Board</strong></h5>
<?php $userboard = $db->getUserBoard($_SESSION['sess_login_id']);
$userboard = json_decode($userboard,true);

 ?>

			<select class="form-control" id="board_list">
				<?php foreach($userboard['BoardData'] as $key=>$val){ ?>
				<option <?php if($_SESSION['boardid']==$val['board_id']){ echo 'selected';} ?> value="<?php echo $val['board_id']; ?>"><?php echo $val['title']; ?></option>
				<?php } ?>

			</select>
			</div>
			 <div class="form-group">
			<h5><strong>List…</strong></h5>
				
			<select class="form-control" id="listlist">
				<?php $list_data = $db->getBoardList($_SESSION['boardid']); ?>
					<?php  foreach ($list_data as  $value) { ?>
				<option <?php if($value['list_id']==$_SESSION['list_id']){ echo 'selected';} ?> value="<?php echo $value['list_id']; ?>"><?php echo $value['list_title']; ?></option>
				<?php } ?>
			</select>
			</div>
			 <div class="form-group">
			 	<h5><strong>Position</strong></h5>
			
			<select class="form-control" id="position_list">
				 	<?php  $card_data = $db->getListCard($_SESSION['list_id']); 
$cardlst_count = count($card_data['cardList'])+1;

			 	?>
<?php for($cs=1;$cs<=$cardlst_count;$cs++){ ?>
				<option value="<?php echo $cs; ?>"><?php echo $cs; ?></option>
<?php } ?>
			</select>
			</div>
			 <div class="form-group">
			<button id="movecarddetail" class="list-btn">Move</button>
			</div>
			<div class="clearfix"></div>
			
			</div>
		</div>
		</div>

	

			<li class="side-list">
			<a href="javascript:void(0)" id="click_me" onclick="copydata()"> <i class="fa fa-files-o" aria-hidden="true"></i> Copy</a></li>



			<div class="<?php echo $mclass; ?>" id="copydataid">
			<?php echo mod_heading('Copy Card'); ?>
			<div class="model-container">
			
			<div class="col-md-12 n-p boardMembers">
			<h3>Title</h3>
			<textarea class="form-control" id="copycomment" rows="3" style="border-radius: 0px;">
<?php echo $card_title; ?>
			</textarea>
            <div class="form-group">
			<h5><strong>Board</strong></h5>
			<?php $userboard1 = $db->getUserBoard($_SESSION['sess_login_id']);
$userboard1 = json_decode($userboard1,true);

 ?>

			<select class="form-control" id="board_list1">
				<?php foreach($userboard1['BoardData'] as $key1=>$val1){ ?>
				<option <?php if($_SESSION['boardid']==$val1['board_id']){ echo 'selected';} ?> value="<?php echo $val1['board_id']; ?>"><?php echo $val1['title']; ?></option>
				<?php } ?>

			</select>
			</div>
		 <div class="form-group">
			<h5><strong>List…</strong></h5>
				
			<select class="form-control" id="listlist1">
				<?php $list_data1 = $db->getBoardList($_SESSION['boardid']); ?>
					<?php  foreach ($list_data1 as  $value1) { ?>
				<option <?php if($value1['list_id']==$_SESSION['list_id']){ echo 'selected';} ?> value="<?php echo $value1['list_id']; ?>"><?php echo $value1['list_title']; ?></option>
				<?php } ?>
			</select>
			</div>
			 <div class="form-group">
			 	<h5><strong>Position</strong></h5>
			
			<select class="form-control" id="position_list1">
				 	<?php  $card_data1 = $db->getListCard($_SESSION['list_id']); 
$cardlst_count1 = count($card_data1['cardList'])+1;

			 	?>
<?php for($cs1=1;$cs1<=$cardlst_count1;$cs1++){ ?>
				<option value="<?php echo $cs1; ?>"><?php echo $cs1; ?></option>
<?php } ?>
			</select>
			</div>
			<div class="form-group">
			<button id="copycarddetail" class="list-btn">Copy</button>
			</div>
			<div class="clearfix"></div>
			
			</div>
		</div>
		</div>

			<script>
$('#copycarddetail').click(function(){
	var bordid = $('#board_list1').val();
	var copycomment = $('#copycomment').val();
	var listid = $('#listlist1').val();
	var positionid = $('#position_list1').val();
	var data = "bordidmove1="+bordid+"&listmove1="+listid+"&positionmove1="+positionid+"&copycomment="+copycomment;
	    $.ajax({
        url: "movecardajax.php",
        type: "POST",
        data: data,
        success: function(rel){
        	//alert(rel);
   window.location.replace(rel);
        }
      });
});

$('#board_list1').change(function(){
	var boardid = $(this).val();
	var data = "bid="+boardid;
      //alert(data);
       $.ajax({
        url: "movecardajax.php",
        type: "POST",
        data: data,
        success: function(rel){
$('#listlist1').html(rel);
   $('#position_list1').html('<option value="">Select Position</option>');      
        }
      });
})

$('#listlist1').change(function(){
	var listid = $(this).val();
	var data = "listid="+listid;
      //alert(data);
       $.ajax({
        url: "movecardajax.php",
        type: "POST",
        data: data,
        success: function(rel){
        	//alert(rel);
$('#position_list1').html(rel);
        }
      });
})



$('#movecarddetail').click(function(){
	var bordid = $('#board_list').val();
	var listid = $('#listlist').val();
	var positionid = $('#position_list').val();
	var data = "bordidmove="+bordid+"&listmove="+listid+"&positionmove="+positionid;
	    $.ajax({
        url: "movecardajax.php",
        type: "POST",
        data: data,
        success: function(rel){
   window.location.replace(rel);
        }
      });
});

$('#board_list').change(function(){
	var boardid = $(this).val();
	var data = "bid="+boardid;
      //alert(data);
       $.ajax({
        url: "movecardajax.php",
        type: "POST",
        data: data,
        success: function(rel){
$('#listlist').html(rel);
   $('#position_list').html('<option value="">Select Position</option>');      
        }
      });
})

$('#listlist').change(function(){
	var listid = $(this).val();
	var data = "listid="+listid;
      //alert(data);
       $.ajax({
        url: "movecardajax.php",
        type: "POST",
        data: data,
        success: function(rel){
        	//alert(rel);
$('#position_list').html(rel);
        }
      });
})
		</script>

			<li class="side-list">
			<a href="javascript:void(0)" onclick="return ShowCard()"> <i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
			<div class="<?php echo $mclass; ?>" id="DelCard_" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:absolute;top:-40px;padding-bottom: 15px;">
<?php echo mod_heading('Delete Card'); ?>
			<div class="model-container" id="cardDiv">
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
		</ul>

</div>

</div>
<!-- label popup starts-->
<div class="<?php echo $mclass; ?>"  id="addlabels" >
	<div id="crelabdata">
<?php //echo mod_heading('Labels'); ?>
<h6 class="heading">Labels<span class="close-div2 fa fa-times pull-right"></span></h6>
<div class="model-container">
<div class="col-md-12 n-p" id="LabelDiv">	
<form id="labels">
   <input type="text" Placeholder = "Search Labels..." class="form-control input-md" name="searchLabel" id="searchlabel">
</form>
<ul style="margin: 0px; padding: 0px; list-style: none;" id="my_lab">
<?php
	$getlabelbyuser = $db->getlblbyuserid('tbl_labels','tbl_label_users',$_SESSION['sess_login_id']);
	if(isset($getlabelbyuser)) { foreach ($getlabelbyuser as $value) {
	$uid = $_SESSION['sess_login_id'];
$labelcardcount = $db->BoardCardlabelcount($cardid,$uid,$value['id']);
if($labelcardcount>0){
							$classlab = 'my_check_right';
							$idjlab='hide_me'.rand(1,100);
						}
						else{
							$classlab = 'my_check_right hiddeni tog_bg';
							$idjlab='showme'.rand(100,1000);
						}
	?>
<?php $labelname = $value['label_name']; 
$labelColor = $value['color'];
	?>
<li style="position:relative"> 
	
	<span onclick="addMylabel(<?=$boardid?>,<?php echo $uid;?>,<?=$value['id']?>,<?=$list_id?>,<?=$cardid?>,'<?=$idjlab?>','<?php echo $labelname ?>','<?php echo $labelColor;?>')" id="<?php echo $idjlab; ?>" class="label-div <?php echo $classlab; ?>" id="<?php echo $value['color'] ?>" style="background: <?php echo $value['color'] ?>">
		<span class="labmyname" style="color: #fff;"><?php echo $value['label_name'] ?></span>
		<!--<span class="select-icon2 fa fa-check" >-->

		</span>
	</span>
	<a href="javascript:void(0)" class="editLabel" id="<?php echo $value['id']?>" onclick="return showEditLabel(this.id); "> <i class="fa fa-pencil"></i> </a>
	</li>
	<?php
	} }
?>

</ul>

	<div class="clearfix"></div>
	<div class="createLabelLink"><a href="javascript:void(0)" style="color: #000;line-height: 30px;margin-left: 14px;">Create a new label</a></div>
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
</div>
<div id="createlab"></div>
</div>
<!-- label popup ends  -->

<!-- Add Attachments starts-->
<div class="<?php echo $mclass; ?>" id="attachmentDiv">
<?php echo mod_heading('Add File'); ?>
<div class="model-container">
<div class="col-md-12 n-p emoji">
<ul style="margin: 0px; padding: 0px; list-style: none;">
<li>
	<!--<form id="submit_form" method="POST" action="upload.php"> -->
	<form id="submit_form" method="POST" action="">
	<div class="col-sm-12 n-p clearfix">
	<div class="form-group col-sm-9 n-p">
	<input type="hidden" name="file_title" class="form-control choose-btn" id="file_title">

		</div>
		<label>Computer</label>
		<div class="form-group col-sm-9 n-p">

			<input style="border: 0;border-radius: 4px 0 0 4px" type="file" name="image" class="form-control choose-btn" id="image_file">
		</div>
        <div class="form-group col-sm-3 n-p pull-right">
			<input type="submit" class="list-btn" name="uploadimage" id="uploadimage" value="Upload" style="margin-top: 0px;padding: 7px 10px;border-radius: 0 4px 4px 0">
		<input type="hidden" name="userid" value="<?php echo $uid; ?>" id="userid">
        <input type="hidden" name="cardid" value="<?php echo $cardid; ?>" id="cardc">			
		</div>
		 <?php if($singluserdata['membership_plan']!=1){
if($singluserdata['googledrive']==1){
		  ?>
		  
		<div class="form-group col-sm-12 drive-bg n-p">
			<label>Google Drive</label>
<input class="form-control choose-btn" type="button" value="Google Drive" onclick="loadPicker()">
        <div id="result"></div>
		</div>
<?php } ?>

<?php if($singluserdata['dropbox']==1){ ?>
	
		<div class="form-group col-sm-12 n-p">
			<label>Dropbox</label>
			 <div id="dropbox-container"></div>
			   <ul id="img_list" class="small-block-grid-1 medium-block-grid-2 large-block-grid-3">
        <div id="result"></div>
		</div>
		<?php } } ?>


		

		
		<div class="clearfix"></div>
	</div>
	</form>
</li>
</ul>
<div class="clearfix"></div>
</div>
</div>
</div>
<!-- Add Attachemnts ends -->
</div>
<input type="hidden" id="userid" value="<?php echo $uid; ?>">
<input type="hidden" id="cardid" value="<?php echo $cardid; ?>">


<!--  codeend -->
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
				//	alert(response);
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
      	</script>
<script type="text/javascript">






jQuery(document).ready(function($) {
	//$("#comments").focus();

});
$(".close-div2").click(function(event) {

		$("#addlabels").css('display','none');
	});

$(".createLabelLink").click(function(event) {
	$.ajax({
		url: 'create_labels.php',
		type: 'POST',
		data: { 
			userid: <?php echo $_SESSION['sess_login_id'] ?>
		},
		success: function(data){
		$("#createlab").css('display','block');
		$("#crelabdata").css('display','none');
		$("#createlab").html(data);
		}
});
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
		$("#createlab").css('display','block');
		$("#crelabdata").css('display','none');
		$("#createlab").html(data);

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
			$("#uploadimage").val("uploading...");
		},
		success: function(respnoce) {
			//alert(respnoce);
			console.log(respnoce);
			console.log(respnoce['path']);
			$("#uploadimage").val("Upload");
			$("#Attachemnts_div").append(respnoce);
			$('#image_file').val('');
			$('#file_title').val('');
			$('.popup-container').css('display','none');
			$('#dropbox-container').html('');
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
	//alert();
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
		$(this).parent('.heading').parent('.popup-container').css('display', 'none');
		$("#activityDiv").css({'display': 'block'});
		$('#dropbox-container').html('');
	});

	function ShowDelComments(elem){
		var id = elem;
		//alert(id);
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
		//$(".editDescDiv").css({'display': 'block'});
		$(".editDescDiv").toggle();
		$("#activityDiv").css({'display': 'block'});
		$("#CardDesc").css({'display': 'none'});
	});
	 $("#close_div").click(function(event) {
	
		$(".editDescDiv").css({'display': 'none'});
		
	}); 
	
	$("#saveCardDesc").click(function(event) {
		var desc = $("#desc").val();
		var cardid = $("#card").val();
		var data = "card="+cardid+"&desc="+desc;
		//alert(data);
		$.post('card-description.php', {data: data }, function(response) {
			//alert(response)	;
			$(".editDescDiv").css({'display': 'none'});
			//$("#desc").val("");
			$("#CardDesc").css({'display': 'inline-block'});
			$("#CardDesc").html(desc);
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
			//alert(response);
			$("#cardCommetns").prepend(response);
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
				//alert(response);
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
				//alert(response);
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
				//alert(response);
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
  var card_title = clicked;
  var id= clicked.split("_");
id=id['1'];
 
 
  var cardid = "<?php echo $_REQUEST['data']; ?>";
  var token = document.getElementById("token").value;
  var list_name = document.getElementById(card_title).value;
 
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
//$("#emojiDiv").toggle();
 
	$("#emojiDiv").css({'display':'block','top':'113px','right':'-300px'});
});



// $('.js-comment-add-emoji').toggle(function () {
//     $("#emojiDiv").css({'display':'block','top':'113px','right':'-300px'});
// });


$(".js-comment-add-attachment").click(function(event) {
	/* Act on the event */
	$("#attachmentDiv").css({'display':'block','top':'247px','right':'-57px','minHeight':'318px'});
});

//code by vinay

$('#attachment').click(function(){
$("#attachmentDiv").css({'display':'block','top':'247px','right':'-57px','minHeight':'318px'});
$('#attachmentDiv').show();
});

function copydata(){
	$("#copydataid").css({'display':'block','right':'-57px','minHeight':'318px','position': 'absolute'});
$('#copydataid').show();

}
$('.close-div').click(function(event) {
 $("#copydataid").hide();
});
function Movedata(){
	$("#movedataid").css({'display':'block','right':'-57px','minHeight':'318px','position': 'absolute'});
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

  
  <script>
  $( function() {
    $(".deleteAttachment").click(function(){
		var id = $(this).attr('id');
		$('#Delattachment_'+id).css('display','block');
	});
  } );
    function Delattachment(elem){
		var id = elem;
		$.ajax({
		url: 'card_cover.php',
		type: 'POST',
		data: {
			action: 'remove_attachment',
			att_id: id,
		},
		success: function(data){
			$('#Delattachment_'+id).css('display','none');
		$('.deldiv_'+id).html('');
		}
	});
	}
    
function closeDelAttachmentDiv(elem){
		var id = elem;
		var div = "#Delattachment_"+id;
		$(div).css({"display":"none"});
	}
  </script>
<!-- Google Drive API Integration -->
<script type="text/javascript" src="https://apis.google.com/js/api.js"></script>
  <script type="text/javascript">

    // The Browser API key obtained from the Google API Console.
    // Replace with your own Browser API key, or your own key.
    //var developerKey = 'AIzaSyByIaGHDdCJIF632EP6XXFpfHJTomrGzt8';
    //preivious key
    var developerKey = 'AIzaSyCKMQcF1xc3pWlC_Cn4T2i8mJPP9jHBdVg';
  //dc key
  //var developerKey = 'AIzaSyCNEh8mnhEwvDG_QngeLqiAR6CBg0DdQ1c';
  
  

    // The Client ID obtained from the Google API Console. Replace with your own Client ID.
    //var clientId = "728850243222-11dnnlv5brofk51087hgqhrglfk6mnun.apps.googleusercontent.com"
   // var clientId = "429120944985-kp87adkkr8m4dc4q54rr20ll9j83amtm.apps.googleusercontent.com"
  //preivious key
    //var clientId = "649854156531-d6hj11s57t2ig7je3rcujkt4dhqeg40b.apps.googleusercontent.com";

//dc client id
    var clientId = "100820254738-t5f0uhm40s1sbvqfdorjf1cohs0a7r44.apps.googleusercontent.com"

    // Replace with your own project number from console.developers.google.com.
    // See "Project number" under "IAM & Admin" > "Settings"
    //var appId = "1234567890";
    var appId = "649854156531";

    // Scope to use to access user's Drive items.
    var scope = ['https://www.googleapis.com/auth/drive'];

    var pickerApiLoaded = false;
    var oauthToken;

    // Use the Google API Loader script to load the google.picker script.
    function loadPicker() {
      gapi.load('auth', {'callback': onAuthApiLoad});
      gapi.load('picker', {'callback': onPickerApiLoad});
    }

    function onAuthApiLoad() {
      window.gapi.auth.authorize(
          {
            'client_id': clientId,
            'scope': scope,
            'immediate': false
          },
          handleAuthResult);
    }

    function onPickerApiLoad() {
      pickerApiLoaded = true;
      createPicker();
    }

    function handleAuthResult(authResult) {
      if (authResult && !authResult.error) {
        oauthToken = authResult.access_token;
        createPicker();
      }
    }

    // Create and render a Picker object for searching images.
    function createPicker() {
      if (pickerApiLoaded && oauthToken) {
        var view = new google.picker.View(google.picker.ViewId.DOCS);
        //view.setMimeTypes("image/png,image/jpeg,image/jpg");
        var picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setAppId(appId)
            .setOAuthToken(oauthToken)
            .addView(view)
            .addView(new google.picker.DocsUploadView())
            .setDeveloperKey(developerKey)
            .setCallback(pickerCallback)
            .build();
         picker.setVisible(true);
      }
    }

    // A simple callback implementation.
    function pickerCallback(data) {
      if (data.action == google.picker.Action.PICKED) {
        var fileId = data.docs[0].id;
       var doc = data[google.picker.Response.DOCUMENTS][0];
                    url = doc[google.picker.Document.URL];
                     name = doc.title;
// alert(url);
// console.log(doc.name);
		var cardid = $('#cardid').val();
		var userid = $('#userid').val();
		var file_title = $('#file_title').val();
		//var imagefile=url;
		//var filename1=doc.name;
		var filename = 'google_drive';
//alert('hello');
        var documents = data[google.picker.Response.DOCUMENTS];
        for (var i = 0 ; i < documents.length ; i++) {
          
           
           var filename1= documents[i][google.picker.Document.NAME];
           var imagefile= documents[i][google.picker.Document.URL];
           
           
           var dataString={image:imagefile,cardid:cardid,userid:userid,name:filename,title_name:file_title,filename1:filename1};
           //console.log(cardid);
             $.ajax({
                url: 'dropbox_attachment.php',
                type: 'POST',
                data: dataString,
                success: function(data){
            		$('#file_title').val('');
                	$("#attachmentDiv,.imagePreviewDb").css('display','none');
            		$('#dropbox-container').html('');
                $("#Attachemnts_div").append(data);
                }
              });
           
          
        }
    console.log(dataString);
 /*  $.ajax({
    url: 'dropbox_attachment.php',
    type: 'POST',
    data: {image:imagefile,cardid:cardid,userid:userid,name:filename,title_name:file_title,filename1:filename1},
    success: function(data){
		$('#file_title').val('');
    	$("#attachmentDiv,.imagePreviewDb").css('display','none');
		$('#dropbox-container').html('');
    $("#Attachemnts_div").append(data);
    }
  }); */
                   
      }
    }
    </script>

  <!-- End Google Drive API Integration -->
<!-- Dropbox File Picker -->
  <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="pn89jgplnlxfqbh"></script>
  <script>
/**
 * Chooser (Drop Box)
 * https://www.dropbox.com/developers/dropins/chooser/js
 */


function dropboxapi()
{

options = {
    success: function(files) {
      files.forEach(function(file) {
        add_img_to_list(file);
      });
    },
    cancel: function() {
      //optional
    },
    linkType: "preview", // "preview" or "direct"
    multiselect: true, // true or false
   // extensions: ['.png', '.jpg'],
};
 


var button = Dropbox.createChooseButton(options);
//document.getElementById("dropbox-container").Remove(button);
document.getElementById("dropbox-container").appendChild(button);

function add_img_to_list(file) {
  var li  = document.createElement('li');
  var a   = document.createElement('a');
  a.href = file.link;
var cardid = $('#cardid').val();
var userid = $('#userid').val();
var file_title = $('#file_title').val();
var imagefile=file.link;
//var name = li.files[0].name;
//console.log("filenamepriya"+file.name);
var filename1=file.name;
var filename = 'dropbox';
   $.ajax({
    url: 'dropbox_attachment.php',
    type: 'POST',
    data: {image:imagefile,cardid:cardid,userid:userid,name:filename,title_name:file_title,filename1:filename1},
    success: function(data){
		$('#file_title').val('');
    	$("#attachmentDiv,.imagePreviewDb").css('display','none');
    $("#Attachemnts_div").append(data);
	$('#dropbox-container').html('');
    }
  });

  // var img = new Image();
  // var src = file.thumbnailLink;
  // src = src.replace("bounding_box=75", "bounding_box=256");
  // src = src.replace("mode=fit", "mode=crop");
  // img.src = src;
  // img.className = "th"
  // document.getElementById("cover_img").appendChild(li).appendChild(a).appendChild(img);
}

}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>

  <script>
  $( function() {
    $( "#duedate" ).datepicker();
  } );
  </script>
  <script>
  
   $( function() {
    //$('#duetime').timepicker();
    
  } );
  </script>
  
 

<link rel="stylesheet" type="text/css" href="https://www.odapto.com/css/bootstrap-clockpicker.min.css">


<script type="text/javascript" src="https://www.odapto.com/js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
var input = $('.single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now'
});


</script>

