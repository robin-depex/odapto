<?php  
$input = file_get_contents('php://input');
if (!$input) {
    die("No JSON received!");
}
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
$arr = json_decode($input,true);
$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);

$file_name = isset($page_name[3]) ? $page_name[3] : '';
$service_url = explode(".",$file_name);
$request_url = $service_url[0];

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
	$board_id = $arr['RequestData']['board_id'];
	$list_title = $arr['RequestData']['list_title'];
    $list_color = $arr['RequestData']['list_color'];
    if($arr['RequestData']['list_icon'] == '')
    {
        $image_name = '';
    } else{
        $image_name = $arr['RequestData']['list_icon'];
    }
    
    
	$rand = $db->generateRandomString();
	$list_data = array("board_id"=>$board_id,"list_title"=>$list_title,"list_color"=>$list_color,"list_icon"=>$image_name,"listkey"=> $rand);
	$insert_list = $db->insert("tbl_board_list",$list_data);
   

	if($insert_list){
	    
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
                      
                      $message= $name .' Added a new List';
                                  $notification_type='create_list';
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
                                                'notif_title' =>  'New List Added',
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
                                    'title' =>  'New List Added',
                                    'msg' => $name .' Added a new List',
                                    'board_id' => $board_id
                                  );
                                 
                     $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
	    
        //end dc code
        
		$list_id = $db->getListId($rand);		
		/*$listcard = array("list_id"=>$list_id,"def"=>1,"del_status"=>1);
		$db->insert("tbl_board_list_card",$listcard);*/

		$listdata=array('list_title' => $list_title,
				'list_id'  =>$list_id,
				'board_id'  =>$board_id);
		
		$response = array(
		"successBool" => true,
		 "responseType"   => "create_list",
		"successCode" => "200",
			"response" => array(
				'message' 	=> 'List Created Successfully',
				'list'=>$listdata,
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
				"ErrorMsg"	=> "Internal Error"
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

$data = array( "serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

