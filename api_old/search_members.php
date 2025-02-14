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
$search = $arr['RequestData']['search'];
$board_id = $arr['RequestData']['board_id'];
//$response = $db->findUserByEmail($search);
 $query = "SELECT id,Full_Name,Email_ID,profile_pic_type,profile_pics FROM `tbl_users` where Email_ID LIKE '%".$search."%'";
    $result = mysqli_query($db->dbh,$query);
    $data_array = array();
    $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
    while($final_result = mysqli_fetch_array($result)){
$countmembr = $db->datafound('tbl_board_invite',array('bid'=>$board_id,'member_id'=>$final_result['id']));
if($countmembr>0){
	$checksts = 1;
}else{
	$checksts = 0;
}


        if($final_result['profile_pic_type']=='url'){
$profile_pics = $final_result['profile_pics'];
        }else if($final_result['profile_pic_type']=='url'){
           $profile_pics =  $db->site_url.'/user_profile_Image/'.$final_result['profile_pics'];
        }else{
            $profile_pics = '';
        }
        //print_r($final_result);
        $data1['id'] = $final_result['id'];
        $data1['name'] = $final_result['Full_Name'];
        $data1['email'] = $final_result['Email_ID'];
        $data1['profile_pic'] = $profile_pics;
        $data1['status'] = $checksts; 
        $data_array[] = $data1;
    }
    $response = array(
        "successBool" => true,
        "responseType" => "search_members",
        "successCode" => "200",
            "response" => array(
                'message' => $data_array
            ),
            "ErrorObj"   => array(
                "ErrorCode" => "",
                "ErrorMsg"  => ""
            )       
    ); 

     
    }else{
       $response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "106",
				"ErrorMsg"	=> "No Data Found"
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
	header('content-type: application/json');

}

	echo $result_response;