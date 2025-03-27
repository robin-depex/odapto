<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
$arr = json_decode($input,true);

$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$userToken = $arr['RequestData']['userToken'];
$uid = $arr['RequestData']['user_id'];
$card_id = $arr['RequestData']['card_id'];
$userlabel_id = $arr['RequestData']['userlabel_id'];
$board_id = $arr['RequestData']['board_id'];
$list_id = $arr['RequestData']['list_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data2 = $db->getVcode();
foreach ($data2 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

/* Code Will Go Here*/	
$wheardel = array(
'cardid' => $card_id,
	);
$deletecardlabel = $db->delete('tbl_board_list_card_labels',$wheardel);
$explodelabel = explode(',',$userlabel_id);
$countexplode = count($explodelabel);
$data_array1 = array();
if(!empty($userlabel_id)){
for($m=0;$m<$countexplode;$m++){
$insertColor = array(
'cardid' => $card_id,
'userid' => $uid,
'board_id' => $board_id,
'list_id' => $list_id,
'labels' => $explodelabel[$m],
'status' => 1,
		);
		
$inserlabcoor = $db->insert('tbl_board_list_card_labels',$insertColor);



	$data3[] = $db->getassigncardata($card_id,$explodelabel[$m]);
	$data_array1['card_data']= $data3;
	//print_r($colordata);
}

}



	//$data_array = $data + $data_array1;
  $response = array(
                "successBool" => true,
                "responseType" => "assignusercard_label",
                "successCode" => "200",
                    "response" => array(
                        "AllCardLabels" => $data_array1,
                        //"Boardmember" => $data_array2
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
