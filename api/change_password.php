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
$password = $arr['RequestData']['password'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data1 = $db->getVcode();
foreach ($data1 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

      
$update_data = array('User_Password' => md5($password));
$condition = array("ID"=>$uid);
$update = $db->update("tbl_users",$update_data,$condition);

$response = array(
                "successBool" => true,
                "responseType" => "change_password",
                "successCode" => "200",
                    "response" => array(
                        'message'   => 'password changed successfully',
                        "user_id" => $uid
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
	
	



	
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
 $result_response = json_encode($response);

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;
