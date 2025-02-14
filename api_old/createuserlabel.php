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
$label_id = $arr['RequestData']['label_id'];
$label_name = $arr['RequestData']['label_name'];
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
	$insertColor = array(
'user_id' => $uid,
'label_id' => $label_id,
'label_name' => $label_name,
		);

	$inserlabcoor = $db->insert('tbl_label_users',$insertColor);
	
	
	
	$colordata = $db->getColorbyid($label_id);
	$lastid = $db->getLastInserteduserlabel($uid);
	//print_r($colordata);
	$data_array['label_id'] = $lastid;
	$data_array['label_name'] = $label_name;
	$data_array['color_id'] = $label_id;
	$data_array['color'] = $colordata['color'];
  $response = array(
                "successBool" => true,
                "responseType" => "createuser_label",
                "successCode" => "200",
                    "response" => array(
                        "AllCardComment" => $data_array
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
