<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Europe/Amsterdam');
//date_default_timezone_set('Asia/Kolkata');
$arr = json_decode($input,true);
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$userToken = $arr['RequestData']['userToken'];
$uid = $arr['RequestData']['user_id'];
$card_id = $arr['RequestData']['card_id'];
$cardmember_id = $arr['RequestData']['cardmember_id'];
$board_id = $arr['RequestData']['board_id'];
$list_id = $arr['RequestData']['list_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data3 = $db->getVcode();
foreach ($data3 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
if($api_key == $apikey){
/* Code Will Go Here*/	
$wheardel = array(
'card_id' => $card_id,
	);
$deletecardlabel = $db->delete('tbl_board_card_members',$wheardel);
$explodelabel = explode(',',$cardmember_id);
$countexplode = count($explodelabel);
$data_array1 = array();
for($m=0;$m<$countexplode;$m++){
	if(!empty($explodelabel[$m])){
    $insertColor = array(
    'card_id' => $card_id,
    'user_id' => $uid,
    'board_id' => $board_id,
    'list_id' => $list_id,
    'Menber' => $explodelabel[$m],
    		);
    $inserlabcoor = $db->insert('tbl_board_card_members',$insertColor);
    
    //dc code
	    //to send notification
	    $name= $db->getName($uid);
	    
	    $url='';
	    $memebr_id=$explodelabel[$m];
                   $where=array(
                        'user_id' =>$memebr_id
                       );
                      $user_token= $db->getsingledata('tbl_user_device',$where);
                      $usr_id=$user_token['user_id'];
                      
                       $r_name= $db->getName($usr_id);
                      
                      $message= $name .' assign card member';
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
                                                'notif_title' =>  'Card invitation',
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
                     'title' =>  'Card invitation',
                    'msg' => $name .' sent card  invitation to  '.$r_name,
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
                    
	    
	    
        //end dc code
    
    
    
    }

}

	

/* New Code for assign board member */
   $member = $db->getBoardmembers($board_id);
  $array = explode(",",$member);
  $data_array2 = array();
        if($member != 0){
foreach ($array as $value1) {
    $wherecon = array(
'card_id' => $card_id,
'Menber' => $value1,
        );
    $getcradstatus = $db->datafound('tbl_board_card_members',$wherecon);

    $result2 = $db->getUserMeta($value1);
if($getcradstatus>0){
$card_status = 1;
}else{
$card_status = 0;
}
$data2['cardid'] = $card_id;
$data2['member_id'] = $value1;
$data2['member_name'] = $result2['full_name'];
$useremil = $db->getsingledata('tbl_users',array('ID'=>$value1));
$data2['member_emil'] = $useremil['Email_ID']; 
$data2['card_status'] = $card_status;
 $data_array2[] = $data2;
}
/* New code ends */
  $response = array(
                "successBool" => true,
                "responseType" => "createcard_member",
                "successCode" => "200",
                    "response" => array(
                        "Cardmember" => $data_array2,
                        "message" => 'Member assign successfully',
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
//print_r($response);
}else{
            $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
                        )
                );
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