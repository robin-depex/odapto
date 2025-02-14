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
$board_id = $arr['RequestData']['board_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data1 = $db->getVcode();
foreach ($data1 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

$member = $db->getmemberslist();
	$array = explode(",",$member);
$data_array = array();
        if($member != 0){
foreach ($array as $value1) {

	$result = $db->getUserMeta($value1);
$countmembr = $db->datafound('tbl_board_invite',array('bid'=>$board_id,'member_id'=>$value1));
if($countmembr>0){
	$checksts = 1;
}else{
	$checksts = 0;
}
$data['cardid'] = 0;
$data['member_id'] = $value1;
$useremil = $db->getsingledata('tbl_users',array('ID'=>$value1));
//print_r($useremil);
$data['member_name'] = $useremil['Full_Name'];
$data['member_emil'] = $useremil['Email_ID']; 
$data['card_status'] = $checksts; 
 $data_array[] = $data;
}



            $response = array(
                "successBool"   => true,
                "responseType"   => "memberlist",
                "successCode"   => "200",
                    "response"  => array(
                        'memberlist'=> $data_array
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )
            );                
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
 $result_response = json_encode($response);

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;
