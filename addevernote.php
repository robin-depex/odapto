<?php  
session_start();
require_once('DBInterface.php');
$db = new Database();
$db->connect();
		$userid = $_REQUEST['uid'];
		$cardid = $_REQUEST['cardid'];
		$file_title= $_REQUEST['title'];
		$guid= $_REQUEST['guid'];
		$notebookGuid= $_REQUEST['notebookGuid'];
		$oauth_token= $_REQUEST['oauth_token'];
		$ckey = $db->generateRandomString();
//print_r($_REQUEST);

	$attachment_insert = array(
			'cardid' 	=> $cardid,
			'userid' 	=> $userid,
			'title_name' 	=> $file_title,
			'attachments' => $file_title,
			'background'  =>'',
			'datetime'	=> date("Y-m-d h:m:s"),
			'ckey'		=> $ckey,
			'status'	=> 1,
			'cover_image' => 0,
            'file_type' => 'evernote',
			'file_extenstion' => '', 
			'location' => 'evernote', 
			'note_guide' => $guid, 
			'note_book_guide' => $notebookGuid, 
			'is_linked' => 0, 
			'evernote_oauth_token' => $oauth_token, 
		);

$table = "tbl_board_list_card_attachements";
		$insert = $db->insert($table,$attachment_insert);


	$bgclass='img-responsive';?>


	<div class="col-sm-12 n-p attachment_div deldiv_<?php echo $insert; ?>" style="margin-bottom:10px;margin-left: 16px;margin-top: 5px;">
 <div class="col-sm-2 n-p" style="margin-right: 20px;height: 80px;border: 1px solid #e0e0e0;    display: flex;" >
	  <img src="images/evernotset.jpg"  style="height: 66px;width: 100%;max-width: 75px;margin: auto;">
</div> 
<div class="col-sm-12 n-p">
  	<h4><?php echo $file_title; ?></h4>
  	<!--<a href="<?php echo SITE_URL."images/evernotset.jpg"; ?>" target="_blank" style="color: #000;margin-right: 8px;"> <span class="fa fa-download" ></span> <?php echo $file_title; ?> </a>-->
	
	<a href="evernotefinal/viewevernote.php?oth_token=<?php echo $oauth_token;?>&gid=<?php echo $guid; ?>&bgid=<?php echo $notebookGuid; ?>" target="_blank" style="color: #000;margin-right: 8px;"> <span class="fa fa-eye" ></span>View</a>
  	<a href="javascript:void(0)" class="deleteAttachment"  id="<?php echo $insert; ?>"  style="color: #000;margin-right: 8px;"> <span class="fa fa-times"></span> Delete </a>
  	<!--<a href="javascript:void(0)" style="color: #000;margin-right: 8px;"> <span class="fa fa-comments"></span> Comment </a>-->
  	
  </div>	
</div>
<div class="col-md-12 b-s" id="Delattachment_<?php echo $insert; ?>" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:relative;top:0px;padding-bottom: 15px;">

				<div class="col-md-12 n-p">
					<div id="cardDiv">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete Attachment...?
						<span class="close-div fa fa-times pull-right" id="<?php echo $insert ?>" onclick="return closeDelAttachmentDiv(this.id)"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					Are you sure you want to delete attachment?</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn" id="<?php echo $insert; ?>" onclick="return Delattachment(this.id)">Delete</button>
					</div>
					<div class="col-md-6">
						<button class="list-btn" id="<?php echo $insert; ?>" onClick="return closeDelAttachmentDiv(this.id);">Cancel</button>
					</div>
					</div>
					<br style="clear: both">
				</div>
			</div>


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