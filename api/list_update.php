<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
$arr = json_decode($input,true);
$v_code = $_POST['v_code'];
$api_key = $_POST['apikey'];
$userToken = $_POST['userToken'];
$uid = $_POST['user_id'];
$requestType = $_POST['requestType'];
$sessToken = $db->verifyUserToken($userToken, $uid);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){


/* Code Will Go Here*/	

    $Boardlist = $db->getboardlistByid($_POST['list_id']);

	$list_id = $_POST['list_id'];
	if(empty($_POST['list_title']))
	{
	    $list_title = $Boardlist['list_title'];
	} 
	else
	{
	    $list_title = $_POST['list_title'];
	}
	
	if(empty($_POST['list_color']))
	{
	    $list_color = $Boardlist['list_color'];
	} 
	else
	{
	    $list_color = $_POST['list_color'];
	}
	if(empty($_FILES['list_icon']))
	{
	    $image_name = $Boardlist['list_icon'];
	}
	else
	{
	     $tmp_file=$_FILES['list_icon']['tmp_name'];
         $image_name=$_FILES['list_icon']['name'];
         $upload_dir="../list_icon/";
         move_uploaded_file($tmp_file, $upload_dir.$image_name);
	}
    
   


		$update_data = array('list_title' => $list_title,"list_color"=>$list_color,"list_icon"=>$image_name );
		$condition = array("list_id"=>$list_id);
		$update = $db->update("tbl_board_list",$update_data,$condition);
		//$result = $db->getBoardDetails($board_id);
				
			$response = array(
				"successBool" => true,
				"responseType" => "edit_list_title",
				"successCode" => "200",
					"response" => array(
						"message"=>"Title Update Successfully",
					),
					"ErrorObj"	 => array(
						"ErrorCode" => "",
						"ErrorMsg"	=> ""
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

$data = array( "serviceurl"=>$requestType,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

