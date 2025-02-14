<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();

//date_default_timezone_set('Asia/Kolkata');
//time zone according to ip
/*$ip=$_SERVER['REMOTE_ADDR'];
$ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
$ipInfo = json_decode($ipInfo);
$timezone = $ipInfo->timezone;
date_default_timezone_set($timezone);*/
//echo date_default_timezone_get();
//echo date('Y/m/d H:i:s');


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
//$board_id = $arr['RequestData']['board_id'];
$list_id = $arr['RequestData']['list_id'];
$card_comment = $arr['RequestData']['comments'];	

$where2= array(
         'card_id' => $card_id
         );
	   $res1= $db->getsingledata('tbl_board_list_card',$where2);
	   $board_id=$res1['board_id'];

$ckey = $db->generateRandomString();	
$date = date("Y-m-d H:i:s");

$data_update = array("comments"=>$card_comment,"cardid"=>$card_id,"board_id"=>$board_id,"list_id"=>$list_id,"userid"=>$uid,"date_time"=>$date,"status"=>1,"ckey"=>$ckey);
$insert = $db->insert("tbl_board_list_card_comments",$data_update);	


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
                      $message= $name .' Added a new comment';
                                  $notification_type='card_comment';
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
                                                'notif_title' =>  'New Comment Added',
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
                     'title' =>  'New Comment Added',
                    'msg' => $name .' added a new comment ',
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
        //end dc code

	$result = $db->getLastComment($ckey);
	$response = array(
		"successBool" => true,
		"responseType" => "card_comments",
		"successCode" => "200",
			"response" => array(
				"message" => "message sent Successfully",
				"lastComment" => $result
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
