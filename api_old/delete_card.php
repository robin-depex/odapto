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
$card_id = $arr['RequestData']['card_id'];	

//to send notification
	    $where=array(
	            'card_id' => $card_id
	        );
	   $res= $db->getsingledata('tbl_board_list_card',$where);
	   $board_id=$res['board_id'];
	   
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
                      $message= $name .' deleted Card';
                                  $notification_type='delete_card';
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
                                                'notif_title' =>  'Deleted Card',
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
                     'title' =>  'Deleted card',
                    'msg' => $name .' Deleted card ',
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
        //end notification code






$wherecard = array(
'card_id' => $card_id
	);
$delete = $db->delete('tbl_board_list_card',$wherecard);

	$delete1 = $db->delete('tbl_board_card_members',$wherecard);


$wherecard2 = array(
'cardid' => $card_id
	);

$delete3 = $db->delete('tbl_board_list_card_attachements',$wherecard2);
$checklist_data = $db->getdata('tbl_board_list_card_checklist',$wherecard2);

foreach($checklist_data as $checkdata){
	$wherecard3 = array(
'checklist_id' => $checkdata['id']
	);

	$delete4 = $db->delete('tbl_board_list_card_checklist_item',$wherecard3);

}
$delete5 = $db->delete('tbl_board_list_card_checklist',$wherecard2);
$delete6 = $db->delete('tbl_board_list_card_comments',$wherecard2);
$delete7 = $db->delete('tbl_board_list_card_labels',$wherecard2);
$delete8 = $db->delete('tbl_board_list_duedate',$wherecard);



	$response = array(
		"successBool" => true,
		"responseType" => "delete_card",
		"successCode" => "200",
			"response" => array(
				'message' => "Delete Card successfully"
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);

	
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
