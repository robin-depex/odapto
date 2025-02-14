<?php  
$input = file_get_contents('php://input');
$input = $_REQUEST['data'];
//echo $input; die();
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
$sessToken = $db->verifyUserToken($userToken, $uid);
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
	
	$admin_id = $arr['RequestData']['user_id'];
	$board_id = $arr['RequestData']['board_id'];
	$board_key = $arr['RequestData']['board_key'];
	$board_title = $arr['RequestData']['board_title'];
	if(!empty($board_title)){
		$update_data = array('board_title' => $board_title );
		$condition = array('admin_id' => $admin_id,"board_id"=>$board_id,"board_key"=>$board_key );
		$update = $db->update("tbl_user_board",$update_data,$condition);
	if($update){
		$board_url = $db->make_url($board_title);
		$data_url = array("meta_value"=>$board_url);
		$conditionmeta = array("meta_key"=>"board_url","board_id"=>$board_id);
		$updatemeta = $db->update("tbl_user_boardmeta",$data_url,$conditionmeta);
		if($updatemeta){

			$result = $db->getBoardDetails($board_id);
				
			$response = array(
				"successBool" => true,
				"successCode" => "200",
					"response" => array(
						"message"=>"Title Edited Successfully",
						"BoardData"=>$result
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
						"ErrorCode" => "107",
						"ErrorMsg"	=> "Internal Error"
					)		
			);		
		}	
				
		}else{
			$response = array(
				"successBool" => false,
				"successCode" => "",
					"response" => array(),
					"ErrorObj"	 => array(
						"ErrorCode" => "107",
						"ErrorMsg"	=> "Internal Error"
					)		
			);	
		}
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "111",
				"ErrorMsg"	=> "Please Enter Board Title"
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