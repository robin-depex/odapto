<?php
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
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
	$card_id = $arr['RequestData']['card_id'];
	$board_id = $arr['RequestData']['board_id'];
//	$response = $db->getAllCardComment($card_id);
	    $response = array(
                "successBool" => true,
                "responseType" => "card_data",
                "successCode" => "200",
                    "response" => array(
                        "attachments" => $db->getCardAttachment($card_id),
                        "AllCardComment" => $db->getAllCardCommentios($card_id),
                        "DuedateDetails" => $db->getbordlistduedate($card_id),
                        "alllabel" => $db->getuserlabellistios($uid),
                        "allcardlabel" => $db->getcardlabellistios($card_id),
                       "board_card_member" => $db->getcardmemberios($card_id,$board_id),
                       "checklist_data" => $db->getcarchecklistios($card_id),
                       "card_description" => $db->getcardescriptionios($card_id),
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

$data = array( "serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

