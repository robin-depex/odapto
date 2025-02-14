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

$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];


$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}

if($code == $v_code){
	
if($api_key == $apikey){

if($req_type == $request_url){
/* Code Will Go Here*/	
	
$email = $arr['RequestData']['email'];	
$id = $db->getIdByEmail($email);	
$cond = array('ID' => $id);
$db->delete("tbl_users",$cond);
$cond_device = array('user_id' => $id);
$db->delete("tbl_user_device",$cond_device);
$condemta = array('user_id' => $id);
if($db->delete("tbl_usermeta",$condemta)){

$response = array(
	"successBool" => true,
	"responseType" => "user_delete",
	"successCode" => "200",
		"response" => array(
			"message" => "user Deleted Successfully"
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
	"response" => array(
	),
	"ErrorObj"	 => array(
		"ErrorCode" => "107",
		"ErrorMsg"	=> "Error Found"
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
$result_response  = json_encode($response);

$data = array( "serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

}