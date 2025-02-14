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
	
$fp_code = $arr['RequestData']['fp_code'];
$password = $arr['RequestData']['password'];

$status = $db->verify_fpcode($uid,$fp_code);
if($status == 1){

$fp_code = $db->generateRandomString();
$data_update = array(
	'User_Password' => md5($password),
	'fp_code' => $fp_code,
);
$wh = array(
	'ID' => $uid
);
$update = $db->update('tbl_users', $data_update, $wh);

$username = $db->getEmail($uid);
$name = $db->get_user_details($uid,'Full_Name');
$password = $password;

$companyName = "Odapto.com";

$to = $username;
$subject = "Password Changed Confirmation Email :: ".$companyName."";
$message = "<p>Dear ".$name." </p>";         
$message .= "<p>Your Password is changed now. </p>";
$message .= "<p>Your Email is ".$username.". </p>";
$message .= "<p>Your Password is ".$password.". </p>";

$message .= "<h3>Thanks <br> Odapto Team</h3>";   
         
$header = "From:odapto@odapto.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";

$retval = mail($to,$subject,$message,$header);
if($retval == 1){
	$response = array(
		"successBool" => true,
		"successCode" => "200",
			"response" => array(
				'message' => "password changed successfully! please check your email",
				'username' => $username,
				'password' => $password
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
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
				"ErrorMsg"	=> "Invalid Verification code"
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