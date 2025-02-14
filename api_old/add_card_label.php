<?php  

$input = file_get_contents('php://input');
/* echo $input;
$input = $_REQUEST['data']; */
if($input!=""){
require_once("config.php");
require_once("DBInterface.php");
require_once("encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');

$arr = json_decode($input,true);

$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);
$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];
//print_r($arr['RequestData']);die;
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
	
$userid = $arr['RequestData']['user_id'];
$cardid = $arr['RequestData']['card_id'];	
$labels = $arr['RequestData']['labelcolor'];	
$ckey=$db->generateRandomString();
$insertdata = array("cardid"=>$cardid,"userid"=>$userid,"labels"=>$labels,"ckey"=>$ckey);

$insert = $db->insert("tbl_board_list_card_labels",$insertdata);
if($insert){
	$response = array(
		"successBool" => true,
		"responseType" => "add_card_label",
		"successCode" => "200",
			"response" => array(
				'message' => "Add Label successfully"
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
				"ErrorMsg"	=> "Internal Server Error"
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

