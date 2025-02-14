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
$uid = $arr['RequestData']['user_id'];
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}

if($code == $v_code){
	
if($api_key == $apikey){

/* Code Will Go Here*/	
$query = mysqli_query($db->dbh,"SELECT * FROM tbl_users WHERE ID = '".$uid."'");
	$res = mysqli_fetch_array($query);     
if($res['profile_pic_type']=='url'){
	$profile_pics = $res['profile_pics'];
}else if($res['profile_pic_type']=='file'){
	$profile_pics =  $db->site_url.'user_profile_Image/'.$res['profile_pics'];
}else{
	$profile_pics = '';
}
$response = array(
                "successBool" => true,
                "successCode" => "200",
                "response" => array(
                'message'=>'UserProfile',
                'user_id' => $res['ID'],
                'fullname' => $res['Full_Name'],
                'emailid' => $res['Email_ID'],
                'profile_pics' => $profile_pics,
                ),
                "ErrorObj"   => array(
                    "ErrorCode" => "",
                    "ErrorMsg"  => ""
                )       
            );

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

$result_response  = json_encode($response);

$data = array( "serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	
}

echo $result_response;