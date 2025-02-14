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
$card_id = $arr['RequestData']['card_id'];
$board_id = $arr['RequestData']['board_id'];
$list_id = $arr['RequestData']['list_id'];
$checklist_name = $arr['RequestData']['checklist_name'];
$refrence_id = $arr['RequestData']['refrence_id'];
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
$ckey = $db->generateRandomString();
$insertarray = array(
'cardid' => $card_id,
'board_id' => $board_id,
'list_id' => $list_id,
'userid' => $uid,
'checklist' => $checklist_name,
'date_time' => date('Y-m-d H:i:s'),
'ckey' => $ckey,
'status' => 1,
'refrenceid' => $refrence_id,
	);

$insertdata = $db->insert('tbl_board_list_card_checklist',$insertarray);
    
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
                      $message= $name .' created a new Checklist';
                                  $notification_type='create_check_list';
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
                                                'notif_title' =>  'New Checklist Added',
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
                     'title' =>  'New Checklist Added',
                    'msg' => $name .' added a new checklist',
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
	    
        //end dc code

$wherarray = array(
'status' => 1,
'cardid' => $card_id,
	);
$chelistdata = $db->getdata('tbl_board_list_card_checklist',$wherarray);
foreach($chelistdata as $check_data){
	$wherarray1 = array(
'checklist_id' => $check_data['id'],
	);
	$chelistdataitem = $db->getdata('tbl_board_list_card_checklist_item',$wherarray1);

	$wherarray11 = array(
		'status' => 1,
'checklist_id' => $check_data['id'],
	);
$total_item = $db->datafound('tbl_board_list_card_checklist_item',$wherarray1);
$total_item1 = $db->datafound('tbl_board_list_card_checklist_item',$wherarray11);
$singlepar = 100/$total_item;
//echo $total_item;
if($total_item>0){
if($total_item1==1){
	$parcentcheck = intval($singlepar);
}else if($total_item1==$total_item){
$parcentcheck = 100;
}else if($total_item1==0){
$parcentcheck = 0;
}else{
	$parcentcheck = intval($singlepar*$total_item1);
} 
}else{
	$parcentcheck = 0;
}




	if(!empty($chelistdataitem)){
		$data_check_item = '';
		$checkitem = array();
		foreach($chelistdataitem as $check_data_item){
$data_check_item = array(
'item_id' => $check_data_item['id'],
'item_name' => $check_data_item['item_name'],
'parent_id' => $check_data_item['checklist_id'],
'status' => $check_data_item['status'],
	);
$checkitem[] = $data_check_item;
	}
}else{
	$checkitem = [];
}
	
$data_check = array(
'checklist_id' => $check_data['id'],
'card_id' => $card_id,
'user_id' => $check_data['userid'],
'checklist_name' => $check_data['checklist'],
'date_time' => $check_data['date_time'],
'checklist_item' => $checkitem,
'progress' => $parcentcheck,
	);

$checkarry[] = $data_check;
}

$newadd = array(
'checklist_id' => $insertdata,
'card_id' => $card_id,
'user_id' => $uid,
'checklist_name' => $checklist_name,
'date_time' => date('Y-m-d H:i:s'),
'checklist_item' => [],
'progress' => 0,
	);


  $response = array(
                "successBool" => true,
                "responseType" => "create_checklist",
                "successCode" => "200",
                    "response" => array(
                        "createchecklist" => $checkarry,
                        "message" => 'Checklist create successfully',
                        "new_add" => $newadd,
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
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