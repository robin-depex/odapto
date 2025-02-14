<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
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

/* Code Will Go Here*/	
	
$list_id = $arr['RequestData']['list_id'];
$listData = $db->getboardlistByid($list_id);
$list_title = $arr['RequestData']['list_title'];
if($list_title == '')
{
    $list_title = $listData[0]['list_title'];
}
$list_color = $arr['RequestData']['list_color'];
if($list_color == '')
{
    $list_color = $listData[0]['list_color'];
}


if($arr['RequestData']['list_icon'] == '')
{ 
     $image_name =  $listData[0]['list_icon'];
} else
{
    $image_name = $arr['RequestData']['list_icon'];
}

 
$list_data = array("list_title"=>$list_title,'list_color'=>$list_color,'list_icon'=>$image_name);
$cond = array("list_id"=>$list_id);
$update_title = $db->update("tbl_board_list",$list_data,$cond);
if($update_title){
	$response = array(
		"successBool" => true,
		"responseType" => "update_list_title",
		"successCode" => "200",
			"response" => array(
				'message' => "update list title successfully"
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "109",
				"ErrorMsg"	=> "Internal Server Error"
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
//	header('content-type: application/json');
	echo $result_response;
}
