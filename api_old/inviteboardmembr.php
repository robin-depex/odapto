<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');

$arr = json_decode($input,true);

$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$userToken = $arr['RequestData']['userToken'];
$sender_id = $arr['RequestData']['user_id'];
$board_id = $arr['RequestData']['board_id'];
$revecer_id = $arr['RequestData']['invite_member_id'];
$invite_email = $arr['RequestData']['invite_email'];
$team_id = $arr['RequestData']['team_id'];
$sessToken = $db->verifyUserToken($userToken,$sender_id);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

/* Code Will Go Here*/

$result = $db->getBoardDetails($board_id);	
$board_url = $result['board_url'];
$board_key = $result['board_key'];
$date = date("Y-m-d H:i:s");
$inv_token = md5($date."boardaddmembers");
$count = $db->ChkInviteToken($inv_token);
if($count > 0){
	$salt = "odaptonew";
	$invtoken = md5($date.$salt);
}else{
	$invtoken = $inv_token;
}

$chk_invite_member = $db->ChkInviteMember($invite_email,$board_id);
if($chk_invite_member > 0){
$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "109",
				"ErrorMsg"	=> "Already Invited"
			)		
	);
}else{
	$data_inv = array(	
		"member_id"=>$revecer_id,
		"bid"=>$board_id,
		"burl"=>$board_url,
		"bkey"=>$board_key,
		"invited_by"=>$sender_id,
		"user_email"=>$invite_email,
		"invite_token"=>$invtoken,
		"invite_date"=> $date
	);
	$dbinsert = $db->insert("tbl_board_invite",$data_inv);
	

	    //to send notification
	    $name= $db->getName($sender_id);
	    
	    $dd=$db->getBoardKeyValue($board_id);
            $key = explode(",", $dd['mvalue']);
             $t= $key[0];
            $k= $key[1];
            $url="https://www.odapto.com/dashboard.php?page=board&b=".$board_id."&t=".$t."&k=".$k;
           
                   
                   $where=array(
                        'user_id' =>$revecer_id
                       );
                      $user_token= $db->getsingledata('tbl_user_device',$where);
                      $usr_id=$user_token['user_id'];
                      
                      $r_name= $db->getName($usr_id);
                      $message= $name .' invited you to join board';
                                  $notification_type='invite_board_member';
                                  $device_type=$user_token['type'];
                      if($sender_id != $usr_id)
						{
						     if($user_token['push_token'])
                              {
                                  
                                 if($device_type=='ios')
                                 {
                                     $ios_device_token= $user_token['push_token'];
                                        $res=$db->pushNotification($ios_device_token, $device_type, $message,$board_id,$notification_type);
                                      
                                 }
                                 if($device_type=='android')
                                 {
                                     $android_device_token= $user_token['push_token'];
                                     $res=$db->pushNotification($android_device_token, $device_type, $message,$board_id,$notification_type);
                                 }
                                 
                                 
                              }
                        	//insert in database
                                 $notify_data=array(
                                                'notif_title' =>  'Board member invitation',
                                                'notif_msg' => $message,
                                                'notif_time' => date('Y-m-d H:i:s'),
                                                'notif_repeat' => 1,
                                                'notif_loop' => 1,
                                                'notif_user_from' =>$sender_id,
                                                'notif_user_to' => $usr_id,
                                                'board_id' => $board_id,
                                                'notif_url' => $url,
                                                'notif_for' => 'mobile',
                                                'status' => 1
                                            );
                                 
                                     $insertNotification = $db->insert("tbl_push_notification",$notify_data);
						    
						}
					
                        
                $activity_data=array(
                     'title' =>  'Board Member invitation',
                    'msg' => $name .' sent invitation to  '.$r_name,
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
                      
                     
                    
	    
	    
        //end notification code
	
	
	
	

	if($revecer_id!=0){
		$board_members_data = array("user_id"=>$sender_id,"team_id"=>$team_id,"board_id"=>$board_id,"member_id"=>$revecer_id,"member_status"=>1);
	$insert = $db->insert("tbl_board_members",$board_members_data);
$response = array(
		"successBool" => true,
		"responseType" => "invite_member",
		"successCode" => "200",
			"response" => array(
				"message" => "Member invite Successfully",
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);


	}else{
		$invite_link = $db->site_url."signup.php?page=board&b=".$board_id."&t=".$board_url."&k=".$board_key."&id=".$sender_id."&email=".$invite_email."&token=".$invtoken;	
		$to = $invite_email;
		$subject = "Odapto Board invitation Email";
		$message = "<h5>Hello  </h5>";         
	$message .= "<p>You are invited to ".$board_title." Team<br>
	In order to Join this Team , Please click the link </p>";
	$message .= "<a style='width:150px;height:35px;background:#f1f1f1;padding:15px;' href=".$invite_link.">Join Team</a>";
	$message .= "<h3>Thanks <br> Odapto Team</h3>";  
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <odapto@odapto.com>' . "\r\n";
mail($to,$subject,$message,$headers);

$response = array(
		"successBool" => true,
		"responseType" => "invite_member",
		"successCode" => "200",
			"response" => array(
				"message" => "Member invite Successfully",
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);

	}
	


	
}
	
/* End Of Code */		

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

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;
