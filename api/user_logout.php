<?php
header('content-type: application/json');
$input = file_get_contents('php://input');
$input = $_REQUEST['data'];
if($input!=""){
require_once("config.php");
require_once("DBInterface.php");
require_once("encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();
date_default_timezone_set('Europe/Amsterdam');
//date_default_timezone_set('Asia/Kolkata');
ob_start();
session_start();
$arr = json_decode($input,true);


$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);

$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];


$req_type = $arr['RequestData']['requestType'];

$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$data = $db->getVcode();
 
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}

 
$user_id = $arr['RequestData']['user_id'];
$deviceType = $arr['RequestData']['deviceType'];
$deviceID = $arr['RequestData']['deviceID'];
$userToken = $arr['RequestData']['userToken'];
$uid = $arr['RequestData']['user_id'];

$sessToken = $db->verifyUserToken($userToken,$uid);

if($userToken == $sessToken){
	if($api_key == $apikey){
		if($code == $v_code){
			if($req_type === $request_url){
				$response = $db->userLogout($userToken,$uid);
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
					"ErrorCode" => "106",
					"ErrorMsg"	=> "Invalid API Key"
				)		
			);
	}

}else{
	$response = array(
	"successBool" => false,
	"successCode" => "",
	"response" => array(),
	"ErrorObj"	 => array(
		"ErrorCode" => "110",
		"ErrorMsg"	=> "Invalid userToken"
	)		
);
}
$result_response  = json_encode($response);
$data = array(
		"serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

if($db->insert("error_log",$data)){
	echo $result_response;
}


}


?>
