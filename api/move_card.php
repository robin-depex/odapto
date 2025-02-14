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
$list_id = $arr['RequestData']['list_id'];
$card_id = $arr['RequestData']['card_id'];		
$swap_position = $arr['RequestData']['swap_position'];	





    $carddatacount = mysqli_num_rows(mysqli_query($db->dbh,"select * FROM tbl_board_list_card WHERE list_id = '".$list_id."' AND position != '".$swap_position."' AND card_id = '".$card_id."'"));
   // echo "select * FROM tbl_board_list_card WHERE list_id = '".$list_id."' AND position != '".$swap_position."' AND card_id = '".$card_id."'";
   // echo $carddatacount;die;
    if($carddatacount>0){

    	$carddataqury = mysqli_query($db->dbh,"select * FROM tbl_board_list_card WHERE list_id = '".$list_id."' AND position > '".$swap_position."'");

  $rowcountcard = mysqli_num_rows($carddataqury);
  if($rowcountcard>0){
while($swapdata = mysqli_fetch_array($carddataqury)){

$newposition1 = $swapdata['position']+1;

$update_list_card = $db->update('tbl_board_list_card',array('board_id'=>$board_id,'list_id'=>$list_id,'position'=>$newposition1),array('card_id'=>$swapdata['card_id']));

    

}
  }
    }
  

  

$carddata = mysqli_fetch_array(mysqli_query($db->dbh,"select * FROM tbl_board_list_card WHERE list_id = '".$list_id."' AND position = '".$swap_position."'"));


  $newposition = $carddata['position']+1;

$update_list_card = $db->update('tbl_board_list_card',array('board_id'=>$board_id,'list_id'=>$list_id,'position'=>$newposition),array('card_id'=>$carddata['card_id']));


$move_card = array("list_id"=>$list_id);
//$cordcond = array("card_id"=>$card_id);
//$boardcond = array("board_id"=>$board_id);

$update_card_member = $db->update('tbl_board_card_members',array('board_id'=>$board_id,'list_id'=>$list_id),array('card_id'=>$card_id));
$update_board_list = $db->update('tbl_board_list',array('board_id'=>$board_id),array('list_id'=>$list_id));

$update_list_card = $db->update('tbl_board_list_card',array('board_id'=>$board_id,'list_id'=>$list_id,'position'=>$swap_position),array('card_id'=>$card_id));

$update_attachment = $db->update('tbl_board_list_card_attachements',array('board_id'=>$board_id,'list_id'=>$list_id),array('cardid'=>$card_id));

$update_checklist = $db->update('tbl_board_list_card_checklist',array('board_id'=>$board_id,'list_id'=>$list_id),array('cardid'=>$card_id));

$update_checklistitem = $db->update('tbl_board_list_card_checklist_item',array('board_id'=>$board_id,'list_id'=>$list_id),array('card_id'=>$card_id));

$update_comment = $db->update('tbl_board_list_card_comments',array('board_id'=>$board_id,'list_id'=>$list_id),array('cardid'=>$card_id));

$update_label = $db->update('tbl_board_list_card_labels',array('board_id'=>$board_id,'list_id'=>$list_id),array('cardid'=>$card_id));

$update_duedate = $db->update('tbl_board_list_duedate',array('board_id'=>$board_id,'list_id'=>$list_id),array('card_id'=>$card_id));


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
                      $message= $name .' Changed the Position of card from position '.$swap_position.' to '.$newposition;
                      $notification_type='move_card';
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
                                                'notif_title' =>  'Card position changed',
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
                     'title' =>  'card Position Changed',
                    'msg' => $name .' Changed the Position of card from position '.$swap_position.' to '.$newposition,
                     'board_id' => $board_id
                      );
                                 
            $insertActivity = $db->insert("tbl_board_activity",$activity_data);
                    
                    
	    
	    
        //end notification code


/*$update_title = $db->update("tbl_board_list_card",$move_card,$cordcond);

$update_title = $db->update("tbl_board_list",$boardcond,$move_card);*/

	$response = array(
		"successBool" => true,
		"responseType" => "move_card",
		"successCode" => "200",
			"response" => array(
				'board_id' => $board_id,
				'message' => "Move Card successfully"
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
