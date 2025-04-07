<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
$arr = json_decode($input,true);
$userToken = $_POST['userToken'];
$req_type = $_POST['requestType'];
$v_code = $_POST['v_code'];
$api_key = $_POST['apikey'];
$uid = $_POST['user_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){
$board_title = $_POST['board_title'];
$board_id = $_POST['board_id'];
$board_data = $db->getBoardDetails($board_id);
$members = array();
$bg_color = isset($_POST['bg_color']) ? $_POST['bg_color'] : '';

$tmp_file=isset($_FILES['bg_img']['tmp_name']) ? $_FILES['bg_img']['tmp_name'] : '';
$image_name=isset($_FILES['bg_img']['name']) ? $_FILES['bg_img']['name'] : '';
$upload_dir="../admin/temp/images/";
//$bg_img = $db->site_url."/admin/temp/images/".$image_name;
 if($tmp_file && $image_name && move_uploaded_file($tmp_file, $upload_dir.$image_name))
    {
        
        	$bg_img = $db->site_url."admin/temp/images/".$image_name;
    }
    else
    {
        $bg_img = '';
    }
 
$date = date("Y-m-d H:i:s");

$color = array("#f00000","#f52d39","#f56d39","#f5d26a","#b3dbc0","#2d907d","#5893ab","#3f9a69","#CD5C5C","#DC143C","#F08080","#FA8072","#E9967A","#B22222","#8B0000","#FFC0CB","#FF7F50","#FF4500","#FFD700","#FFA500","#FF8C00","#FF6347","#BDB76B");
$random_keys=array_rand($color,3);
if(empty($bg_color)){
    $bg_color = $color[$random_keys[0]];
}

$update_data = array('board_title' => $board_title,"bg_img"=>$bg_img,"bg_color"=>$bg_color,"ud"=>$date );
$condition = array("board_id"=>$board_id);
$update = $db->update("tbl_user_board",$update_data,$condition);

$response = array(
                "successBool" => true,
                "responseType" => "update_board",
                "successCode" => "200",
                    "response" => array(
                        "board_id" => $board_id
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

