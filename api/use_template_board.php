<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");

$db = new Database();
$db->connect();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
$arr = json_decode($input,true);

$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$userToken = $arr['RequestData']['userToken'];
$uid = $arr['RequestData']['user_id'];
$tempid = $arr['RequestData']['tempid'];

$sessToken = $db->verifyUserToken($userToken,$uid);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
   
   if($code == $v_code){
       
       if($api_key == $apikey){
           
           $whereuser = array('ID' => $uid);
           $getuseredata = $db->getsingledata('tbl_users',$whereuser);
           $response=$db->getTemplateBoard($tempid);
           
           
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
       
   } else {
       
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

            $db->insert("error_log",$data);
            	header('content-type: application/json');
            	echo $result_response;
