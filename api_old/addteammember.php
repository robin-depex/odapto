<?php  
$input = file_get_contents('php://input');
//echo $input;
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
$uid = $arr['RequestData']['invited_by'];
$memebr_id = $arr['RequestData']['invite_member_id'];
$invite_email = $arr['RequestData']['invite_email'];
$team_id = $arr['RequestData']['team_id'];

$sessToken = $db->verifyUserToken($userToken,$uid);
$data2 = $db->getVcode();
foreach ($data2 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
if($api_key == $apikey){
$result = $db->getTeamDetails($team_id);
	$board_title = $result['team_name'];
	$board_url = $result['team_url'];
	$board_key = $result['team_key'];
	$date = date("Y-m-d H:i:s");
	$inv_token = md5($date."teamaddmembersbyemail");
	$count = $db->ChkTeamInviteToken($inv_token);

if($count > 0){
		$salt = "odaptonew";
		$invtoken = md5($date.$salt);
	}else{
		$invtoken = $inv_token;
	}
$ChkInviteMemberByEmail = $db->ChkInviteTeamMemberByEmail($invite_email,$team_id);
//echo $ChkInviteMemberByEmail;
if($ChkInviteMemberByEmail > 0){
	//echo "sdnfj";
			$update_data = array("invite_token"=>$invtoken);
		$condition = array("tid"=>$team_id,"user_email" => $invite_email);
		$update = $db->update("tbl_team_invite",$update_data,$condition);
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
		//echo "sdnfj12";
	$data_inv = array(	
		"tid"=>$team_id,
		"turl"=>$board_url,
		"tkey"=>$board_key,
		"user_email" => $invite_email,
		"invited_by"=>$uid,
		"invite_token"=>$invtoken,
		"invite_date"=>$date,
	);
if($memebr_id!=0){
$data_inv['member_id']=	$memebr_id;
}
	$db->insert("tbl_team_invite",$data_inv);

	}


if($memebr_id!=0){
	
$addmem = array('user_id'=>$uid,'team_id'=>$team_id,'member_id'=>$memebr_id,'member_status'=>1);
$db->insert('tbl_team_members',$addmem);

    //dc code
	    //to send notification
	    $name= $db->getName($uid);
	    
	    $url='';
           
                   
                   $where=array(
                        'user_id' =>$memebr_id
                       );
                      $user_token= $db->getsingledata('tbl_user_device',$where);
                      $usr_id=$user_token['user_id'];
                      
                       $r_name= $db->getName($usr_id);
                      
                      $message= $name .' invited you to join team';
                                  $notification_type='add_team_member';
                                  $device_type=$user_token['type'];
                      if($uid != $usr_id)
						{
						     if($user_token['push_token'])
                              {
                                  
                                 if($device_type=='ios')
                                 {
                                     $ios_device_token= $user_token['push_token'];
                                        $db->pushNotification($ios_device_token, $device_type, $message,$board_id,$notification_type);
                                      
                                 }
                                 if($device_type=='android')
                                 {
                                     $android_device_token= $user_token['push_token'];
                                     $db->pushNotification($android_device_token, $device_type, $message,$board_id,$notification_type);
                                 }
                                 
                                 
                                     
                              }
                         //insert in database
                                 $notify_data=array(
                                                'notif_title' =>  'Team member invitation',
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
                      
                                
                     
                $activity_data=array(
                     'title' =>  'Team  Member invitation',
                    'msg' => $name .' sent team  invitation to  '.$r_name,
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
                    
	    
	    
        //end dc code

$response = array(
			"successBool"=> true,
			"responseType" => "team_invite",
			"successCode"=>"200",
			"response" => array(
				'message'   => 'Successfully invited',
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
		));



	}else{
		$invite_link = $db->site_url."signup.php?page=team&b=".$team_id."&t=".$board_url."&k=".$board_key."&id=".$invited_by."&email=".$invite_email."&token=".$invtoken;	
		$to = $invite_email;
		$subject = "Odapto Team invitation Email";
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
			"successBool"=> true,
			"responseType" => "team_invite",
			"successCode"=>"200",
			"response" => array(
				'message'   => 'Successfully invited',
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
		));
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

$data = array( "serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));
if($db->insert("error_log",$data)){
	
}
header('content-type: application/json');
	echo $result_response;


