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
$card_id = $arr['RequestData']['card_id'];
$due_id = $arr['RequestData']['duedate_id'];
$complete_status = $arr['RequestData']['complete_status'];

$sessToken = $db->verifyUserToken($userToken,$uid);
$data3 = $db->getVcode();
foreach ($data3 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

$insertColor = array(
'complete_status' => $complete_status,
'userid' => $uid,
		);

$wheararry = array(
'card_id' => $card_id,
	);

$update = $db->update('tbl_board_list_duedate',$insertColor,$wheararry);

$con1 = array(
'card_id' => $card_id,
	);

$duedata = $db->getdata('tbl_board_list_duedate',$con1);

$dataarray = array(
'due_id' => $duedata[0]['id'],
'card_id' => $duedata[0]['card_id'],
'duedate' => $duedata[0]['duedate'],
'duetime' => $duedata[0]['duetime'],
'duedatetime' => $duedata[0]['duedate'].' '.$duedata[0]['duetime'],
'complete_status' => $duedata[0]['complete_status'],
	);

 
  $response = array(
                "successBool" => true,
                "responseType" => "update_complete_status",
                "successCode" => "200",
                    "response" => array(
                      "updatecompstatus" => $dataarray,
                        "message" => 'Complete status update successfully',
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
//print_r($response);
	
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

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;
