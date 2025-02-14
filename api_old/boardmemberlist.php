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
$board_id = $arr['RequestData']['board_id'];
$card_id = $arr['RequestData']['card_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data1 = $db->getVcode();
foreach ($data1 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

$member = $db->getBoardmembers($board_id);
	$array = explode(",",$member);
$data_array = array();
        if($member != 0){
foreach ($array as $value1) {
    

	$result = $db->getUserMeta($value1);
	
	$querypic = "SELECT profile_pic_type,profile_pics FROM `tbl_users` where id = '".$value1."'";
    $resultpic = mysqli_query($db->dbh,$querypic);

$final_result = mysqli_fetch_array($resultpic);

    if($final_result['profile_pic_type']=='url'){
$profile_pics = $final_result['profile_pics'];
        }else if($final_result['profile_pic_type']=='url'){
           $profile_pics =  $this->site_url.'/user_profile_Image/'.$final_result['profile_pics'];
        }else{
            $profile_pics = '';
        }
	
	

$data['member_id'] = $value1;
$data['member_name'] = $result['full_name'];
$useremil = $db->getsingledata('tbl_users',array('ID'=>$value1));
$data['member_emil'] = $useremil['Email_ID']; 
 $data['profile_pic'] = $profile_pics;
 $data_array[] = $data;
}

            $response = array(
                "successBool"   => true,
                "responseType"   => "board_memberlist",
                "successCode"   => "200",
                    "response"  => array(
                        'bord_memberlist'=> $data_array
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
echo json_encode($response);

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
header('content-type: application/json');
	echo $result_response;