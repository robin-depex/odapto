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
$uid = $arr['RequestData']['user_id'];
$card_id = $arr['RequestData']['card_id'];
$userlabel_id = $arr['RequestData']['userlabel_id'];
$board_id = $arr['RequestData']['board_id'];
$list_id = $arr['RequestData']['list_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data2 = $db->getVcode();
foreach ($data2 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

/* Code Will Go Here*/	
$wheardel = array(
'cardid' => $card_id,
	);
$deletecardlabel = $db->delete('tbl_board_list_card_labels',$wheardel);
$explodelabel = explode(',',$userlabel_id);
$countexplode = count($explodelabel);
$data_array1 = array();
if(!empty($userlabel_id)){
for($m=0;$m<$countexplode;$m++){
$insertColor = array(
'cardid' => $card_id,
'userid' => $uid,
'board_id' => $board_id,
'list_id' => $list_id,
'labels' => $explodelabel[$m],
'status' => 1,
		);
$inserlabcoor = $db->insert('tbl_board_list_card_labels',$insertColor);



	$data3[] = $db->getassigncardata($card_id,$explodelabel[$m]);
	$data_array1['card_data']= $data3;
	//print_r($colordata);
}

}

//dc code
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
                       $message= $name .' assigned new card label';
                                  $notification_type='assign_card_label';
                                  $device_type=$user_token['type'];
                      if($uid != $usr_id)
						{
						     if($user_token['push_token'])
                              {
                                 
                                 if($device_type=='ios')
                                 {
                                     $ios_device_token= $user_token['push_token'];
                                        $res=$db->pushNotification($ios_device_token, $device_type, $message,$board_id,$notification_type,$card_id);
                                      
                                 }
                                 if($device_type=='android')
                                 {
                                     $android_device_token= $user_token['push_token'];
                                     $res=$db->pushNotification($android_device_token, $device_type, $message,$board_id,$notification_type,$card_id);
                                 }
                                 
                                 
                                 
                              }
                              	//insert in database
                                 $notify_data=array(
                                                'notif_title' =>  'New Card Label',
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
                     'title' =>  'New Card Label',
                    'msg' => $name .' added new card label  ',
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
        //end dc code


	$data['cardid'] = $card_id;

/* New Code for assign board member */
$member = $db->getBoardmembers($board_id);
$countmember = count($member);
if($countmember>0){
	$array = explode(",",$member);
	$data_array2 = array();				
		foreach ($array as $value) {
			$result = $db->getUserMeta($value);
			$mamb = $db->getboardcardmembers($value, $card_id);
			
            $data['member_id'] = $value;
            $data['member_name'] = $result['full_name'];
            $data['member_initials'] = $result['initials'];


			$data_array2[] = $data;

}


/* New code ends */

	$data_array = $data + $data_array1;
  $response = array(
                "successBool" => true,
                "responseType" => "createusercard_label",
                "successCode" => "200",
                    "response" => array(
                        "AllCardComment" => $data_array,
                        "Boardmember" => $data_array2
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
