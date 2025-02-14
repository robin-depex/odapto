<?php  
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();

$senderid = $_SESSION['sess_login_id'];
$name=$db->getName($senderid);

//print_r($_FILES['image']['name']);
//print_r($_POST);
if($_FILES['image']['name'] != ''){

	$ext = end(explode(".", $_FILES['image']['name']));
	$allowed_type = array("jpg","png","JPG","JPEG","jpeg");
	//if (in_array($ext, $allowed_type)) {
		$new_name = rand() . "." .$ext ;
		$path = "attachments/". $new_name; 
		 
		if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){

		$image=imagecreatefromjpeg("$path");
		$thumb=imagecreatetruecolor(100, 100); imagecopyresampled($thumb,$image,0,0,0,0,1,1,imagesx($image),imagesy($image));
		$mainColor=strtoupper(dechex(imagecolorat($thumb,0,0)));

		$userid = $_REQUEST['userid'];
		$cardid = $_REQUEST['cardid'];
	$card_data = $db->get_single_data('tbl_board_list_card',array('card_id'=>$cardid));
		$file_title= $_REQUEST['file_title'];
		$ckey = $db->generateRandomString();
		$attachment_insert = array(
			'cardid' 	=> $cardid,
			'userid' 	=> $userid,
			'board_id' 	=> $card_data['board_id'],
			'list_id' 	=> $card_data['list_id'],
			'title_name' 	=> $file_title,
			'attachments' => $new_name,
			'background'  =>$mainColor,
			'datetime'	=> date("Y-m-d h:m:s"),
			'ckey'		=> $ckey,
			'status'	=> 1,
			'cover_image' => 0,
            'file_type' => 'file',
			'file_extenstion' => $ext, 
		);
		//echo json_encode($attachment_insert); die();
		$table = "tbl_board_list_card_attachements";
		$insert = $db->insert($table,$attachment_insert);
		if($insert){
		    
		    //to push send notification
		    $board_id=$card_data['board_id'];
		    $dd=$db->getBoardKeyValue($board_id);
            $key = explode(",", $dd['mvalue']);
           $t= $key[0];
            $k= $key[1];
            $url="https://www.odapto.com/dashboard.php?page=board&b=".$board_id."&t=".$t."&k=".$k;
            
	    $member = $db->getBoardmembers($board_id);
                    $countmember = count(explode(",",$member));
                    //echo $countmember;
                    if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
    
						$usr_id=$result1['ID'];
						if($senderid != $usr_id)
						{
						    $notify_data=array(
                            'notif_title' => 'New attachment added',
                            'notif_msg' => $name.' added a  new attachment',
                            'notif_time' => date('Y-m-d H:i:s'),
                            'notif_repeat' => 1,
                            'notif_loop' => 1,
                            'notif_user_from' =>$senderid,
                            'notif_user_to' => $usr_id,
                            'notif_url' => $url,
                            'notif_for' => 'web',
                            'status' => 1
                        );
                    $insertNotification = $db->insert("tbl_push_notification",$notify_data);
						    
						}
					}
					
					}
	    //end notification
		    
		
		$update = $db->cover_update($table,$ckey,$cardid);

		$atachment = $db->getLastImage($ckey);
		foreach ($atachment as $key => $value) {
			$path = $value['image'];
			$background = $value['background'];
			$id=$value['id'];
			$ext =$value['ext']; 
			if(isset($value['cover']) && $value['cover'] == 1){
            	$cover = "Remove Cover";
            	$class = "remove_cover";
            }else{
            	$cover = "Make Cover";
            	$class = "make_cover";
            }
		}	
		
		
		}
			//tbl_board_list_card_attachements
		$bgclass='img-responsive';?>


	<div class="col-sm-12 n-p attachment_div deldiv_<?php echo $id; ?>" style="margin-bottom:10px;margin-left: 16px;margin-top: 5px;">
 <div class="col-sm-2 n-p <?php echo $bgclass; ?>" style="margin-right: 20px;" >
 
	  <img src="attachments/<?php echo $path; ?>"  style="height:80px;width: 100%">

</div> 
<div class="col-sm-10 n-p">
  	<h4><?php echo $value['title_name']; ?></h4>
  	<a href="<?php echo SITE_URL."attachments/".$path; ?>" download style="color: #000;margin-right: 8px;"> <span class="fa fa-download" ></span> Download </a>
	 
  	<a href="javascript:void(0)"  class="<?php echo $class; ?>" id="makeremove_<?php echo $id; ?>"  style="color: #000;margin-right: 8px;"> <span class="fa fa-picture-o"></span> <?php echo $cover ?> </a>
	 
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
						<h6 style="margin:0px 0px 5px 0px;font-size: 15px; font-weight: 500 ">Are you sure you want to delete attachment?</h6>
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
	<?php 	} }else{ echo '<script>alert("please select file");</script>'; } ?>

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