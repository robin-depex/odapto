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
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
$arr = json_decode($input,true);
$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);
$file_name = $page_name[3];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$userToken = $arr['RequestData']['userToken'];
$uid = $arr['RequestData']['user_id'];
$card_id = $arr['RequestData']['card_id'];
$board_id = $arr['RequestData']['board_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data2 = $db->getVcode();
foreach ($data2 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

if($req_type == $request_url){

$member = $db->getBoardmembers($board_id);
//print_r($member);
$countmember = count($member);
// echo $countmember;
if($countmember>0){
	$array = explode(",",$member);
	$data_array = array();				
		foreach ($array as $value) {
			$result = $db->getUserMeta($value);
			$mamb = $db->getboardcardmembers($value, $card_id);
			
            $data['member_id'] = $value;
            $data['member_name'] = $result['full_name'];
            $data['member_initials'] = $result['initials'];


			$data_array[] = $data;

}

    $response = array(
                "successBool" => true,
                "responseType" => "assignboardmember",
                "successCode" => "200",
                    "response" => array(
                        "Boardmember" => $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
//print_r($response);
	}else{
            $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
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