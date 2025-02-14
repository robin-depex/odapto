<?php 
$input = file_get_contents('php://input');

// require_once("firebase.php");
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
$arr = json_decode($input,true);

$req_type = $arr['RequestData']['requestType'];

$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($code == $v_code){
if($api_key === $apikey){

$email = $arr['RequestData']['username'];
$passwd = $arr['RequestData']['password'];
$deviceType = $arr['RequestData']['deviceType'];
$deviceID = $arr['RequestData']['deviceID'];
$loginWith = $arr['RequestData']['loginWith'];
$device_token = $arr['RequestData']['device_token'];
$fullname = $arr['RequestData']['fullname'];
//$idToken = $arr['RequestData']['idToken'];

if($passwd=='' && $loginWith!='')
{
	$passwd=123456;
}


//echo $passwd;
//echo md5($passwd);
$response = $db->chkLogin($email,$passwd,$deviceType,$deviceID,$loginWith,$device_token,$fullname);

    
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
//echo json_encode($response);
$result_response  = json_encode($response);

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
header('content-type: application/json');
	echo $result_response;

?>