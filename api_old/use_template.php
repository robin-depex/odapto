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
$tempid = $arr['RequestData']['tempid'];
$bids = $arr['RequestData']['board_ids'];

$board_ids = explode(',', $bids);
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
	$whereuser = array(
'ID' => $uid,
	);
$getuseredata = $db->getsingledata('tbl_users',$whereuser);
$membershipplan = $getuseredata['membership_plan'];


$temp_boards1=$db->get_temp_boards($tempid);
$countbord = count($temp_boards1);
if($countbord>0){
if($membershipplan==1){
	$whereboard = array(
'admin_id' => $uid,
	);
$countbord1 = $db->datafound('tbl_user_board',$whereboard);
$total_board = $countbord1+$countbord;
if($total_board>3){
	$response = array(
		"successBool" => true,
		"responseType" => "use_template",
		"successCode" => "200",
			"response" => array(
				"message" => "Please upgrade your membership plan",
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);


}else{
$j='createbord';
}
}else{
$j='createbord';
}
if($j=='createbord'){
$inserttemp = $db->insert('tbl_user_template',array('userid'=>$uid,'template_id'=>$tempid));

    foreach($board_ids as $board_id){
        
        $temp_boards2=$db->get_temp_boards_byId($board_id,$tempid);
        foreach ($temp_boards2 as $temp_boards) {
        $board_key=$db->generateRandomString();
        $temp_bid=$temp_boards['id'];
        
        $board_insert=array(
                    'admin_id'=>$uid,
                    'board_title'=>$temp_boards['board_name'],
                    'board_key'=>$board_key,
                    'board_url'=>$temp_boards['board_url'],
                    'bg_color'=>$temp_boards['board_bgcolor'],
                    'board_fontcolor'=>$temp_boards['board_fontcolor'],
                    'type'=>'PB',
                    'admin_board_id'=>$id,
                    'bg_img'=>$site_url.'admin/temp/images/'.$temp_boards['bg_img'],
        
                    );
        $boards=$db->insert('tbl_user_board',$board_insert);
        $bid = $db->getLastInsertedBoard($uid);
        
        $date = date("Y-m-d H:i:s");
        $inv_token = md5($date."boardaddmembers");
        $count = $db->ChkInviteToken($inv_token);
        if($count > 0){
        	$salt = "odaptonew";
        	$invtoken = md5($date.$salt);
        }else{
        	$invtoken = $inv_token;
        }
        
        $data_inv1 = array(	
        		"member_id"=>$uid,
        		"user_email"=>$getuseredata['Email_ID'],
        		"bid"=>$bid,
        		"burl"=>$temp_boards['board_url'],
        		"bkey"=>$board_key,
        		"invited_by"=>$uid,
        		"invite_token"=>$invtoken,
        		"invite_date"=> $date
        	);
        $dbinsert1 = $db->insert("tbl_board_invite",$data_inv1);
        $board_members_data1 = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$uid,"member_status"=>1,"team_id"=>$tempid);
        	$insert1 = $db->insert("tbl_board_members",$board_members_data1);
        
        	
        $board_list=$db->get_admin_BoardList($temp_bid);
        $countbrdlist = count($board_list);
        if($countbrdlist>0){
        foreach ($board_list as $board_list) {
        $list_id=$board_list['id'];
        			$list_key=$db->generateRandomString();
        			  $list_insert=array(
                    'board_id'=>$bid,
                    'list_title'=>$board_list['list_title'],
                    'listkey'=>$list_key,
                          );
         $db->insert('tbl_board_list',$list_insert);
              $last_insertlist = $db->getlast_insertlist($bid);
        
              	$list_card=$db->get_admin_Boardcards($list_id);
        $countlistcard = count($list_card);
        if($countlistcard>0){
        foreach ($list_card as $list_card) {
              		$card_insertdata=array(
                    'list_id'=>$last_insertlist,
                    'board_id'=>$bid,
                    'card_description'=>$list_card['card_description'],
                    'card_title'=>$list_card['card_name'],
                          );
        
        
                $db->insert('tbl_board_list_card',$card_insertdata);
        
              	}
        
        }else{
        			
        	$response = array(
        		"successBool" => true,
        		"responseType" => "use_template",
        		"successCode" => "200",
        			"response" => array(
        				"abc" => "Template use successfully",
        			),
        			"ErrorObj"	 => array(
        				"ErrorCode" => "",
        				"ErrorMsg"	=> ""
        			)		
        	);
        }
        
        
        }
        
        
        }else{
        			
        	$response = array(
        		"successBool" => true,
        		"responseType" => "use_template",
        		"successCode" => "200",
        			"response" => array(
        				"abc" => "Template use successfully",
        			),
        			"ErrorObj"	 => array(
        				"ErrorCode" => "",
        				"ErrorMsg"	=> ""
        			)		
        	);
        }
        
        if($boards==true){
        $rand = $db->generateRandomString();
        			$board_url = $db->make_url($board_title);
        $data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$bid);
        			$db->insert("tbl_user_boardmeta",$data_url);
        			
        			$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$bid);
        			$db->insert("tbl_user_boardmeta",$data_key);
        			
        			$data_team = array("meta_key"=>"team_id","meta_value"=>$teamId,"board_id"=>$bid);
        			$db->insert("tbl_user_boardmeta",$data_team);
        
        
        			$data_privacy = array("meta_key"=>"board_visibility","meta_value"=>$board_privacy,"board_id"=>$bid);
        			$db->insert("tbl_user_boardmeta",$data_privacy);
        
        
        			$board_team_data = array("team_id"=>$teamId, "board_id"=> $bid);
        			$db->insert("tbl_team_board",$board_team_data);
        
        			if(!empty($teamId)){
        				$updateboard = array("type"=>'TB');
        				$cond = array("board_id"=> $bid,"admin_id" => $uid);
        				$db->update("tbl_user_board",$updateboard,$cond);
        			}
        
        
        			$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
        			$db->insert("tbl_user_boardmeta",$data_visibility);
        
        			$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$bid);
        			$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);
        
        if($last_insert){
        				
        	$response = array(
        		"successBool" => true,
        		"responseType" => "use_template",
        		"successCode" => "200",
        			"response" => array(
        				"abc" => "Template use successfully",
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
        				"ErrorMsg"	=> "Internal server Error"
        			)		
        	);
        			}
        
        
        		}else{
        			$response = array(
        		"successBool" => false,
        		"successCode" => "",
        			"response" => array(),
        			"ErrorObj"	 => array(
        				"ErrorCode" => "109",
        				"ErrorMsg"	=> "Internal server Error"
        			)		
        	);
        		}
        
        
        }
        //end foreach
    }
    //end foreach


}

}else{
	$response = array(
		"successBool" => true,
		"responseType" => "use_template",
		"successCode" => "200",
			"response" => array(
				"message" => "Template board not available",
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
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

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;

