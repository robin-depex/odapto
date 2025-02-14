<?php 
header('content-type: application/json');
$input = file_get_contents('php://input');
$input = $_REQUEST['data'];
//$data = '{"reqtype":"user-login","v_code":"1.0","RequestData":{"username":"rohit@depextechnologies.org","password":"123456"}}';

if($input!=""){

require_once("DBInterface.php");
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$arr = json_decode($input,true);
$response = "";

$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);

$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];

$req_type = $arr['RequestData']['requestType'];

$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
//echo $request_url . "--" .$req_type; die;
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($code == $v_code){
if($api_key === $apikey){
if($req_type === $request_url){

$username = $arr['RequestData']['username'];
$passwd = $arr['RequestData']['password'];
$deviceType = $arr['RequestData']['deviceType'];
$deviceID = $arr['RequestData']['deviceID'];
$push_token = $arr['RequestData']['pushtoken'];
$response = $db->chkLogin($username,md5($passwd),$deviceType,$deviceID,$push_token);
	
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

$result_response  = json_encode($response);

$data = array("serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

}

?>