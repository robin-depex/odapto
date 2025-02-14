<?php  

require_once("config.php");
require_once("DBInterface.php");
//require_once("encryption.php");
//$enc = new Encryption();
$db = new Database();
$db->connect();



$v_code = $_POST['v_code'];
$api_key = $_POST['apikey'];
$userToken = $_POST['userToken'];
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


   $tmp_file=$_FILES['image']['tmp_name'];
  $image_name=$_FILES['image']['name'];
  $upload_dir="../images/user_profile/";

  //$image=$image_name.time();

  $user_profile=array('user_images'=>$image_name);
  $where=array('id'=>$uid);

  $db->update('user',$user_profile,$where);
    if(move_uploaded_file($tmp_file, $upload_dir.$image_name))
    {
      


      $response = array(
      "successBool" => true,
      "responseType" => "upload image successFully",
      "successCode" => "200",
      "response" => array(
      'image' => $db->site_url."images/user_profile/".$image_name
      ),
           
      );
    }

    else{

        $response = array(
      "successBool" => false,
      "successCode" => "",
      "response" => array(),
      "ErrorObj"   => array(
      "ErrorCode" => "105",
      "ErrorMsg"  => "Token Mismatched"
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
	echo $result_response;
}
header('content-type: application/json');
	echo $result_response;
