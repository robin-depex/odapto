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
$board_id = $arr['RequestData']['board_id'];
$list_id = $arr['RequestData']['list_id'];
$due_date = $arr['RequestData']['due_date'];
$due_time = $arr['RequestData']['due_time'];
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
   $wherecon = array(
'card_id' => $card_id,
        );
    $getcradstatus = $db->datafound('tbl_board_list_duedate',$wherecon);
if($getcradstatus>0){

$insertColor = array(
'duedate' => date('Y-m-d',strtotime($due_date)),
'duetime' => $due_time,
'userid' => $uid,
		);

$wheararry = array(
'card_id' => $card_id,
	);

$update = $db->update('tbl_board_list_duedate',$insertColor,$wheararry);
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
                      $message= $name .' Updated due date';
                                  $notification_type='add_due_date';
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
                                                'notif_title' =>  'Updated new Due date  ',
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
                     'title' =>  'Updated new Due date',
                    'msg' => $name .' Updated  Due date  ',
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
	    
        //end dc code
    


}else{
$insertColor = array(
'duedate' => $due_date,
'duetime' => $due_time,
'card_id' => $card_id,
'userid' => $uid,
'board_id' => $board_id,
'list_id' => $list_id,
		);
$insert = $db->insert('tbl_board_list_duedate',$insertColor);

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
                      if($uid != $usr_id)
						{
						     if($user_token['push_token'])
                              {
                                  $message= $name .' added new due date';
                                  $notification_type='add_due_date';
                                  $device_type=$user_token['type'];
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
						    
						}
						 //insert in database
                                 $notify_data=array(
                                                'notif_title' =>  'Added new Due date  ',
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
                     'title' =>  'Updated new Due date',
                    'msg' => $name .' Updated  Due date  ',
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
        //end dc code


}

$con1 = array(
'card_id' => $card_id,
	);

$duedata = $db->getdata('tbl_board_list_duedate',$con1);

$dataarray = array(
'due_id' => $duedata[0]['id'],
'card_id' => $duedata[0]['card_id'],
'duedate' => $duedata[0]['duedate'],
'duetime' => $duedata[0]['duetime'],
'duedatetime' => $duedata[0]['duedate'].' '.$duedata[0]['duetime'],
'complete_status' => $duedata[0]['complete_status'],
	);

 
  $response = array(
                "successBool" => true,
                "responseType" => "assign_duedate",
                "successCode" => "200",
                    "response" => array(
                      "assignduedate" => $dataarray,
                        "message" => 'Due Date assign successfully',
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
//print_r($response);
	
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
