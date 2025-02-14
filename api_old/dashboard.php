<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$arr = json_decode($input,true);
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

	/* Code Will Go Here*/	
	
	    $response = array(
                "successBool" => true,
                "responseType" => "dashboard_data",
                "successCode" => "200",
                    "response" => array(
                        "allMembers" => $db->getTotalUserMemebr($uid),
                        "overDues" => $db->getTotalOverDues($uid),
                        'completeTask' => $db->getTotalCompleteTask($uid),
                        'TodayTask' => $db->getTotalTodayTask($uid),
                       
                    ),
                    "board" => array(
                         'personal_board' => strval(count($db->getpersonalBoard($uid,''))),
                        'InvitedBoard' => strval(count($db->getInvitedBoard($uid))),
                         'TeamBoard' => strval(count($db->TeamData($uid))),
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
$result_response  = json_encode($response);

$data = array( "serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}