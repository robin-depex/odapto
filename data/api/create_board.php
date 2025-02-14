<?php  
$input = file_get_contents('php://input');
$input = $_REQUEST['data'];
if($input!=""){
require_once("config.php");
require_once("DBInterface.php");
require_once("encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');

$arr = json_decode($input,true);
$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);

$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];
$userToken = $arr['RequestData']['userToken'];
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$uid = $arr['RequestData']['user_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
//echo $userToken . " - " . $sessToken;die();
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}

if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

if($req_type == $request_url){

/* Code Will Go Here*/	
	
$board_title = $arr['RequestData']['board_title'];
$uid = $arr['RequestData']['user_id'];
$teamId = $arr['RequestData']['team_id'];
$rand = $db->generateRandomString();
date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d H:i:s");

$board_data = array("admin_id"=>$uid,"board_title"=>$board_title,"board_key" => $rand ,"type"=>"PB","createDate"=>$date);

$insert = $db->insert("tbl_user_board",$board_data);
$board_id = $db->getLastInsertedBoard($uid);
if($insert){
	
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

	if($last_insert){
		$result = $db->getBoardDetails($board_id);
		$response = array(
			"successBool"=> true,
			"successCode"=>"200",
			"response" => array(
				'message'   => 'board created successfully',
				'boardData' => $result 
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
		));
	}else{
		$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "109",
				"ErrorMsg"	=> "Internal code error"
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
				"ErrorMsg"	=> "Internal code error"
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
				"ErrorCode" => "103",
				"ErrorMsg"	=> "Invalid Request Url"
			)		
	);
}
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

$data = array( "serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

}