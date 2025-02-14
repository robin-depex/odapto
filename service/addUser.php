<?php 
$input = file_get_contents('php://input');
/*$input = '{
			"roleName":"GL_TEST",
			"roleDis":"Testing",
			"isActive":"1"
		  }';*/
if($input!=""){
require_once('DBInterface.php');
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');
$arr = json_decode($input,true);

$name = $db->clean_input($arr['Full_Name']);
$emailadd = $db->clean_input_email($arr['Email_ID']);
$status = $db->clean_input($arr['status']);
$pass = $db->clean_input($arr['User_Password']);
$token = $db->clean_input($arr['accessTocken']);



if(empty($name)){
	echo  json_encode(array('result'=>'FALSE','message'=>'Please Enter Name'));
}else if(empty($emailadd)){
	echo  json_encode(array('result'=>'FALSE','message'=>'Please Enter Email Id!'));
}else{
	
	$data = array(
		'Full_Name' => $name,
		'Email_ID' => $emailadd,
		'User_Password' => $pass,
		'status' => $status,
		'accessTocken' => $token
	);
	
	$chkemail = $db->chkEmail($emailadd);	
	if($chkemail == 0){
		$insertDataUserTable = $db->insert("tbl_users",$data);
		if($insertDataUserTable == true){
	
		$results = array(
				'result'=>'TRUE',
				'message'=>'Successfully Registered!'
			);	
		}else{
			$results = array(
					'result'=>'FALSE',
					'message'=>'Error While Registering!'
				);
		}
	}else{
		$results = array(
				'result'=>'FALSE',
				'message'=>'Email Already Exists!'
			);	
	}
	$response = json_encode($results);
	header('content-type: application/json');
	echo $response;
}


}
?>