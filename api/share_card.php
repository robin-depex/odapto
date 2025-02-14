<?php  $input = file_get_contents('php://input');
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
$board_id = $arr['RequestData']['card_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}



if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
 $string = '';
 $random_string_length = 5;
 $max = strlen($characters) - 1;
 for ($i = 0; $i < $random_string_length; $i++) {
      $string .= $characters[mt_rand(0, $max)];
 }
 $day = date('d');
 $m = date('m');
 $y = date('Y');
$promocode = $m.$string.$y.$day;
//$pathhurl = 'https://odapto.com/confirmcard.php';
$pathhurl = 'https://odapto.com/login.php';



$pointdata = array(
	"refer_by" =>$uid, 
	"promocode" => $promocode, 
	 "status" => 0, 
	 "datetime" => date("Y-m-d H:i:s"),
	  "recever_id" => 0, 
	  "recever_email" => '',
	  	  );



$insertpoint = $db->insert('tbl_share_card', $pointdata);


$referpath = $pathhurl.'?procode='.$promocode.'cid='.$board_id;
  $response = array(
                "successBool" => true,
                "responseType" => "share_card",
                "successCode" => "200",
                    "response" => array(
                      "message" => "Share Card",
                      "refer_url" => $referpath,
                      "refer_code" => $promocode
                    ),
                       
            );

 

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