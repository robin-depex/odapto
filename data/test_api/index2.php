<?php  
header('content-type: application/json');
$input = file_get_contents('php://input');
//$input = $_REQUEST['data'];
if($input!=""){

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


	$req_type = $arr['RequestData']['requestType'];
	define("API_LINK","https://www.odapto.com/test_api/");	
	if($req_type == "user_register"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_login"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_logout"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "edit_board_title"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_delete"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "get_vcode"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "resend_code"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "verify_code"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "list_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "list_card"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_card"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "star_board"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "board_privacy"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "create_team"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "team_list"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "user_team"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "update_list_title"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "update_card_title"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "card_comments"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "card_description"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "search_members"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "forgot_password"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "change_password"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "send_invitation"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
	}else if($req_type == "blank_api"){
		header("location:".API_LINK.$req_type.".php?data=".$input);
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

?>