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

if($req_type == $request_url){
/* Code Will Go Here*/	
	
$visibility = 	$arr['RequestData']['board_visibility'];
$board_id = 	$arr['RequestData']['board_id'];
$team_id = 	$arr['RequestData']['team_id'];

if( ($privacy == "0") || ($privacy == "2") ){
	$update = array("meta_value"=>$visibility);
	$condition = array("meta_key"=>"board_visibility" , "board_id" => $board_id );
	if($db->update("tbl_user_boardmeta",$update, $condition)){
		$response = array(
			"successBool" => true,
			"successCode" => "200",
				"response" => array(
					"message"=>"Privacy updated successfully",
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
					"ErrorMsg"	=> "Internal code error"
				)		
		);
	}
}else{
	$update = array("meta_value"=>$visibility);
	$condition = array("meta_key"=>"board_visibility" , "board_id" => $board_id );
	$db->update("tbl_user_boardmeta",$update, $condition);
	
	$condition_team_board = array("board_id"=>$board_id);
	$update_team_baord = array("team_id"=>$team_id);
	$db->update("tbl_team_board",$update_team_baord, $condition_team_board);

	$condition_user_board = array("board_id"=>$board_id,"admin_id"=>$uid);
	$update_user_baord = array("type"=>"TB");
	if($db->update("tbl_user_board",$update_user_baord, $condition_user_board)){
		$response = array(
			"successBool" => true,
			"successCode" => "200",
				"response" => array(
					"message"=>"Privacy updated successfully",
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
					"ErrorMsg"	=> "Internal code error"
				)		
		);
	}
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