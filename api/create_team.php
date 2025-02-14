<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
$arr = json_decode($input,true);
$userToken = $arr['RequestData']['userToken'];
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
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
$team_name = $arr['RequestData']['team_name'];

date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d H:i:s");
$bg_img=$db->getrand_boardimg();
$team_data = array("user_id"=>$uid,"team_name"=>$team_name,"cd"=>$date,"teamDesc"=>'',"team_image"=>'profile.jpg');
		$team_id = $db->insert("tbl_user_team",$team_data);
	$team_key = $db->generateRandomString();
			$team_url = $db->make_url($team_name);
			$short_name = explode("-",$team_url);
			$srotname = $short_name[0];

			$data_url = array("meta_key"=>"team_url","meta_value"=>$team_url,"team_id"=>$team_id);
			$db->insert("tbl_user_teammeta",$data_url);

         	$data_short = array("meta_key"=>"short_name","meta_value"=>$srotname,"team_id"=>$team_id);
			$db->insert("tbl_user_teammeta",$data_short);
			
			$data_short1 = array("meta_key"=>"website","team_id"=>$team_id);
			$db->insert("tbl_user_teammeta",$data_short1);

			$data_visibility = array("meta_key"=>"team_visibility","team_id"=>$team_id,"meta_value"=>0);
			$db->insert("tbl_user_teammeta",$data_visibility);

			$data_key = array("meta_key"=>"team_key","meta_value"=>$team_key,"team_id"=>$team_id);
			$last_insert = $db->insert("tbl_user_teammeta",$data_key);
	
$response = array(
			"successBool"=> true,
			"responseType" => "create_team",
			"successCode"=>"200",
			"response" => array(
				'message'   => 'Team created successfully',
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
		));
	
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

