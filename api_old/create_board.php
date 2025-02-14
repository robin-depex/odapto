<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
$arr = json_decode($input,true);
$userToken = $arr['RequestData']['userToken'];
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
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


$board_title = $arr['RequestData']['board_title'];
$teamId = $arr['RequestData']['team_id'];
$members = $arr['RequestData']['members'];
$rand = $db->generateRandomString();
$date = date("Y-m-d H:i:s");
//$bg_img=$db->getrand_boardimg();
$bg_img='';
$color = array("#f00000","#f52d39","#f56d39","#f5d26a","#b3dbc0","#2d907d","#5893ab","#3f9a69","#CD5C5C","#DC143C","#F08080","#FA8072","#E9967A","#B22222","#8B0000","#FFC0CB","#FF7F50","#FF4500","#FFD700","#FFA500","#FF8C00","#FF6347","#BDB76B");
$random_keys=array_rand($color,3);


if($teamId==0){
$board_data = array("admin_id"=>$uid,"team_id"=>$teamId,"board_title"=>$board_title,"board_key" => $rand ,"type"=>"PB","createDate"=>$date,"bg_img"=>$bg_img,"bg_color"=>$color[$random_keys[0]]);
}else{
	$board_data = array("admin_id"=>$uid,"team_id"=>$teamId,"board_title"=>$board_title,"board_key" => $rand ,"type"=>"TB","createDate"=>$date,"bg_img"=>$bg_img,"bg_color"=>$color[$random_keys[0]]);
}


/* Code Will Go Here*/	
$whereuser = array(
'ID' => $uid,
	);
$getuseredata = $db->getsingledata('tbl_users',$whereuser);
$membershipplan = $getuseredata['membership_plan'];
//echo $membershipplan;die;
if($membershipplan==1){
	$whereboard = array(
'admin_id' => $uid,
	);
$countbord = $db->datafound('tbl_user_board',$whereboard);
if($countbord>=5){
$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "109",
				"ErrorMsg"	=> "Please upgrade your membership plan"
			)		
		);
}else{
$board_id = $db->insert("tbl_user_board",$board_data);
$board_url = $db->make_url($board_title);

if(!empty($members))
{
    foreach($members as $member)
    {
        $member_data = array("user_id"=>$uid,"board_id"=>$board_id,"member_id"=>$member['id'],"member_status"=>1,"team_id"=>'0');
	    $minsert1 = $db->insert("tbl_board_members",$member_data);
    }
}

	$data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_url);
	
	$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_key);

	$data_team = array("meta_key"=>"team_id","meta_value"=>$teamId,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_team);

	$board_team_data = array("team_id"=>$teamId, "board_id"=> $board_id);
	$db->insert("tbl_team_board",$board_team_data);

	$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_visibility);

	$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$board_id);
	$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);


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
		"bid"=>$board_id,
		"burl"=>$board_url,
		"bkey"=>$rand,
		"invited_by"=>$uid,
		"invite_token"=>$invtoken,
		"invite_date"=> $date
	);
$dbinsert1 = $db->insert("tbl_board_invite",$data_inv1);

$board_members_data1 = array("user_id"=>$uid,"board_id"=>$board_id,"member_id"=>$uid,"member_status"=>1,"team_id"=>$teamId);
	$insert1 = $db->insert("tbl_board_members",$board_members_data1);

$result = $db->getBoardDetails($board_id);
		$response = array(
			"successBool"=> true,
			"responseType" => "create_board",
			"successCode"=>"200",
			"response" => array(
				'message'   => 'board created successfully',
				'boardData' => $result ,
				//'board_bg'  =>$bg_img
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
		));
	
	
}
}else{
$insert = $db->insert("tbl_user_board",$board_data);
$board_id = $db->getLastInsertedBoard($uid);
	
	$board_url = $db->make_url($board_title);

	$data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_url);
	
	$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_key);

	$data_team = array("meta_key"=>"team_id","meta_value"=>$teamId,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_team);

	$board_team_data = array("team_id"=>$teamId, "board_id"=> $board_id);
	$db->insert("tbl_team_board",$board_team_data);

	$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$board_id);
	$db->insert("tbl_user_boardmeta",$data_visibility);

	$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$board_id);
	$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);
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
		"bid"=>$board_id,
		"burl"=>$board_url,
		"bkey"=>$rand,
		"invited_by"=>$uid,
		"invite_token"=>$invtoken,
		"invite_date"=> $date
	);
$dbinsert1 = $db->insert("tbl_board_invite",$data_inv1);
$board_members_data1 = array("user_id"=>$uid,"board_id"=>$board_id,"member_id"=>$uid,"member_status"=>1,"team_id"=>$teamId);
	$insert1 = $db->insert("tbl_board_members",$board_members_data1);



$result = $db->getBoardDetails($board_id);
		$response = array(
			"successBool"=> true,
			"responseType" => "create_board",
			"successCode"=>"200",
			"response" => array(
				'message'   => 'board created successfully',
				'boardData' => $result ,
				//'board_bg'  =>$bg_img
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
		));
		

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

