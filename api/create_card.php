<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');

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
	
$list_id = 	$arr['RequestData']['list_id'];
$board_id = 	$arr['RequestData']['board_id'];
$card_title = 	$arr['RequestData']['card_title'];
$description = 	$arr['RequestData']['description'];
$querycard = "SELECT * FROM tbl_board_list_card WHERE list_id = $list_id";
$resultcard = mysqli_query($db->dbh,$querycard);
$rowcountcard = mysqli_num_rows($resultcard);
$positioncart = $rowcountcard+1;
$card_data = array("board_id"=>$board_id,"list_id"=>$list_id,"card_title"=>$card_title,"card_description"=>$description,"position"=>$positioncart);
$card_id = $db->insert("tbl_board_list_card",$card_data);

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
                      $message= $name .' created a new Card';
                      $notification_type='create_card';
                      $device_type=$user_token['type'];
                      if($uid != $usr_id)
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
                                                'notif_title' =>  'New Card Added',
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
                     'title' =>  'New Card Added',
                    'msg' => $name .' created a new card',
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
	    
        //end dc code

	//	$card_id = $db->lastcardId($list_id);	
$obj3 = (object)[];
             
$response = array(
		"successBool" => true,
		"responseType" => "create_card",
		"successCode" => "200",
			"response" => array(
				"message" => "card created Successfully",
 				"card_id" =>intval($card_id),
 				"list_id" =>intval($list_id),
 				"board_id" =>intval($board_id),
 				"card_title" =>$card_title,
 				"card_description" =>$description,
 				"del_status"=>0,
 				"cardComments"=>0,
 				"total_attachments"=>0,
 				"cover_image"=>'',
 				"total_checklist"=>0,
 				"total_checklist_checked"=>0,
 				"duedate"=>$obj3,
 				"member"=>[],
 				"label"=>[],
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

$data = array( "serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );
$db->insert("error_log",$data);

	header('content-type: application/json');
	echo $result_response;
