<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
$req_type = $_POST['requestType'];
$v_code = $_POST['v_code'];
$api_key = $_POST['apikey'];
$userToken = $_POST['userToken'];
$uid = $_POST['user_id'];
$board_id = $_POST['board_id'];
$list_id = $_POST['list_id'];
$cardid = $_POST['cardid'];
$filetype = $_POST['type'];
$url_type = $_POST['url_type'];
$title_name = $_POST['title_name'];
$note_guide = $_POST['note_guide'];
$note_book_guide = $_POST['note_book_guide'];
$is_linked = $_POST['is_linked'];
$evernote_oauth_token = $_POST['evernote_oauth_token'];

$sessToken = $db->verifyUserToken($userToken,$uid);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){	
if($api_key == $apikey){

/* Code Will Go Here*/	
	
//$response = $db->gettemplatebyCatid($catid);	
//print_r($response);
	
/* End Of Code */		
if($filetype=='url'){
$filename = $_POST['filename'];
$pathurl = $filename;
$mainColor = '';
$ext = '';
}elseif($filetype=='file'){
//$filename = $_FILES['filename']['name'];

        $ext = end(explode(".", $_FILES['filename']['name']));
        $allowed_type = array("jpg","png","JPG","JPEG","jpeg");
	    //if (in_array($ext, $allowed_type)) {
		
        $filename = rand() . "." .$ext ;
	    $path = "../attachments/". $filename;
	    move_uploaded_file($_FILES['filename']['tmp_name'], $path);
	    $image=imagecreatefromjpeg("$path");
		$thumb=imagecreatetruecolor(100, 100); imagecopyresampled($thumb,$image,0,0,0,0,1,1,imagesx($image),imagesy($image));
		$mainColor=strtoupper(dechex(imagecolorat($thumb,0,0)));
		$filename = $filename;
		$pathurl = $db->site_url.'attachments/'.$filename;
}else{
	$filename = $_POST['filename'];
$pathurl = '';
$mainColor = '';
$ext = '';
}


		$userid = $_REQUEST['user_id'];
		$cardid = $_REQUEST['cardid'];
		$ckey = $db->generateRandomString();
		$attachment_insert = array(
			'cardid' 	=> $cardid,
			'board_id' 	=> $board_id,
			'list_id' 	=> $list_id,
			'userid' 	=> $userid,
			'file_type' => $filetype,
			'attachments' => $filename,
			'title_name' => $title_name,
			'background'  =>$mainColor,
			'datetime'	=> date("Y-m-d h:i:s"),
			'ckey'		=> $ckey,
			'status'	=> 1,
			'cover_image' => 0,
			'location' => $url_type,
			'file_extenstion' => $ext,	
			'note_guide' => $note_guide,	
			'note_book_guide' => $note_book_guide,	
			'is_linked' => $is_linked,	
			'evernote_oauth_token' => $evernote_oauth_token,	
		);
		//print_r($attachment_insert); 
		//die();
		$table = "tbl_board_list_card_attachements";
	    $insert = $db->insert($table,$attachment_insert);
	    
	    
	    //to send notification
	    $name= $db->getName($uid);
	        $dd=$db->getBoardKeyValue($board_id);
            $key = explode(",", $dd['mvalue']);
             $t= $key[0];
            $k= $key[1];
            $url="https://www.odapto.com/dashboard.php?page=board&b=".$board_id."&t=".$t."&k=".$k;
            
            $members=$db->getBoardmembers($board_id);

                $array1 = explode(",",$members);
                foreach ($array1 as $value1) {
                   
                   
                   $where=array(
                        'user_id' =>$value1
                       );
                      $user_token= $db->getsingledata('tbl_user_device',$where);
                      $usr_id=$user_token['user_id'];
                      $message= $name .' Added a '.$filename.' attachment';
                    $notification_type='add_attachment';
                    $device_type=$user_token['type'];
                      if($uid != $usr_id)
						{
						     if($user_token['push_token'])
                              {
                                  
                                 if($device_type=='ios')
                                 {
                                     $ios_device_token= $user_token['push_token'];
                                        $res=$db->pushNotification($ios_device_token, $device_type, $message,$board_id,$notification_type,$cardid);
                                      
                                 }
                                 if($device_type=='android')
                                 {
                                     $android_device_token= $user_token['push_token'];
                                     $db->pushNotification($android_device_token, $device_type, $message,$board_id,$notification_type,$cardid);
                                 }
                                 
                                
                                 
                              }
                              
                               //insert in database
                                 $notify_data=array(
                                                'notif_title' =>  'New Attachment Added',
                                                'notif_msg' => $message,
                                                'notif_time' => date('Y-m-d H:i:s'),
                                                'notif_repeat' => 1,
                                                'notif_loop' => 1,
                                                'notif_user_from' =>$uid,
                                                'notif_user_to' => $usr_id,
                                                'board_id' => $board_id,
                                                'notif_url' => $url,
                                                'notif_for' => 'mobile',
                                                
                                                'status' => 1
                                            );
                                 
                                     $insertNotification = $db->insert("tbl_push_notification",$notify_data);
						    
						}
						
						
                         }
                    
                        $activity_data=array(
                                    'title' =>  'New Attachment Added',
                                    'msg' => $name .' Added a '.$filename.' attachment',
                                    'board_id' => $board_id
                                  );
                                 
                     $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
	    
        //end notification code

if($filetype=='url'){
	$fileiconshow = 1;
	$fileicon = $db->site_url.'/icon/'.$url_type.'.png';
}elseif($filetype=='file'){
	if($ext=='jpg' OR $ext =='png' OR $ext =='jpeg' OR $ext =='gif' OR $ext =='tif' OR $ext =='ico'){
		$fileiconshow = 2;
		$fileicon = $pathurl;
	}else{
		$fileiconshow = 3;
		$fileicon = $ext;
	}
}elseif($filetype=='evernote'){
        $fileiconshow = 4;
		$fileicon = $db->site_url.'/icon/evernote.png';
	}


	    $res_array = array(
			'id' => ($insert) ? $insert : '',
			'filename' 	=> ($filename) ? $filename : '',
			'type' => ($filetype) ? $filetype : '',
			'url_type'  => ($url_type) ? $url_type : '',
			'file_extenstion' => ($ext) ? $ext : '',
			'cardid' => ($cardid) ? $cardid : '',
			'board_id' => ($board_id) ? $board_id : '',
			'list_id' => ($list_id) ? $list_id : '',
			'userid' => ($userid) ? $userid : '',
			'file_url' => ($pathurl) ? $pathurl : '',
			'title_name' => ($title_name) ? $title_name : '',
			'cover_image' => 0,
			'date' => date("Y-m-d h:i:s"),	
			'file_icon' => ($fileicon) ? $fileicon : '',
			'fileiconshow' => $fileiconshow,
			'is_linked' => ($is_linked) ? $is_linked : '0',
			'note_book_guide' => ($note_book_guide) ? $note_book_guide : '',
			'note_guide' => ($note_guide) ? $note_guide : '',
			'evernote_oauth_token' => ($evernote_oauth_token) ? $evernote_oauth_token : '',
		);

    
//}
if($insert){
	$response = array(
		"successBool" => true,
		"responseType" => "add_attachment",
		"successCode" => "200",
			"response" => array(
				'message' => "Added Attachment successfully",
				'add_attachment' => $res_array
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "109",
				"ErrorMsg"	=> "Internal Server Error"
			)		
	);
}



}else{
	
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "106",
				"ErrorMsg"	=> "Invalid APIkey"
			)		
	);
}

}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "105",
				"ErrorMsg"	=> "Update Your Version"
			)		
	);
}
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "105",
				"ErrorMsg"	=> "Token Mismatched"
			)		
	);
}
$result_response  = json_encode($response);

$data = array( "serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );
$db->insert("error_log",$data);

	header('content-type: application/json');
	echo $result_response;