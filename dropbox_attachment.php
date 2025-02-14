<?php  
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();

		
		 $path =  $_REQUEST['image']; 
		$userid = $_REQUEST['userid'];
		$cardid = $_REQUEST['cardid'];
		$name = $_REQUEST['name'];
		$filename1 = $_REQUEST['filename1'];
		$title_name = $_REQUEST['title_name'];
		if(!empty($title_name)){
			$title_name1 = $title_name;
		}else{
			$title_name1 = $filename1;
		}
		$ckey = $db->generateRandomString();
		/*$attachment_insert = array(
			'cardid' 	=> $cardid,
			'userid' 	=> $userid,
			'attachments' => $path,
			'filename'  =>$name,
			'datetime'	=> date('Y-m-d H:i:s'),
			'ckey'		=> $ckey,
			'status'	=> 1,
			'cover_image' => 0	
		);*/
		
		$attachment_insert = array(
			'cardid' 	=> $cardid,
			'board_id' => $_SESSION['boardid'],
			'list_id' => $_SESSION['list_id'],
			'userid' 	=> $userid,
			'attachments' => $path,
			'location'  =>$name ,
			'datetime'	=> date('Y-m-d H:i:s'),
			'ckey'		=> $ckey,
			'status'	=> 1,
			'cover_image' => 0,
            'title_name' => $title_name1,	
			'file_type' => 'url',
		);

		
		//echo json_encode($attachment_insert); die();
		$table = "tbl_board_list_card_attachements";
		$insert = $db->insert($table,$attachment_insert);
		$atachment = $db->getLastImage($ckey);

		foreach ($atachment as $key => $value) {
			$path = $value['image'];
			$background = $value['background'];
			$id=$value['id'];
		}
		 
$link = $path;
$link_array = explode('=',$link);
$page = end($link_array);	
if($page=='drive_web')
{
	$bgclass='background-image: url(https://a.trellocdn.com/prgb/dist/images/services/google-drive-preview-logo.64011cc7e495af6d55d0.svg);';
$strattchnam = $value['title_name'];
	}

elseif($page=='0')
{
	$bgclass='background-image:url(https://a.trellocdn.com/prgb/dist/images/services/dropbox-preview-logo.275d8a966e5d9d2b8e22.svg';
	$link_array1 = explode('/',$value['title_name']);
	$link_array2 = explode('?',$link_array1[5]);
	$strattchnam = $link_array1[0];
}
		
?>

<div class="col-sm-12 n-p attachment_div deldiv_<?php echo $id; ?>" style="margin-bottom:10px;margin-left: 16px;margin-top: 5px;border: 1px solid #e0e0e0;">
	<div class="col-sm-2 n-p" style="height: 80px;background-color: white;width: 80px;background-size: cover;<?php echo $bgclass; ?>" >

	</div>
	<div style="margin-top:25px" class="col-sm-10 n-p">
			<h4><?php  echo $strattchnam ;?></h4>
		<a href="<?php echo $path; ?>" target="_blank" style="color: #000;margin-right: 8px;"> <span class="fa fa-eye" ></span>View</a>
	<a href="javascript:void(0)" class="deleteAttachment"  id="<?php echo $id; ?>"  style="color: #000;margin-right: 8px;"> <span class="fa fa-times"></span> Delete </a>
	<!--<a href="javascript:void(0)" style="color: #000;margin-right: 8px;"> <span class="fa fa-comments"></span> Comment </a>-->

	</div>	
	</div> 
<div class="col-md-12 b-s" id="Delattachment_<?php echo $value['id']; ?>" style="display: none;background-color: #fdfdfd; width:300px; margin-bottom: 10px;z-index:9999; position:relative;top:0px;padding-bottom: 15px;">

				<div class="col-md-12 n-p">
					<div id="cardDiv">
						<h6 class="heading" style="font-weight: bold;font-size: ">Delete Attachment...?
						<span class="close-div fa fa-times pull-right" id="<?php echo $value['id'] ?>" onclick="return closeDelAttachmentDiv(this.id)"></span></h6>
						<hr style="margin-bottom:0px;">
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">
					Are you sure you want to delete attachment?</h6>
					<div class="col-md-6 n-p" style="width:auto !important;">
						<button class="list-btn" id="<?php echo $value['id']; ?>" onclick="return Delattachment(this.id)">Delete</button>
					</div>
					<div class="col-md-6">
						<button class="list-btn" id="<?php echo $value['id']; ?>" onClick="return closeDelAttachmentDiv(this.id);">Cancel</button>
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