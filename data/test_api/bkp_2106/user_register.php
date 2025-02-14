<?php  
$input = file_get_contents('php://input');
$input = $_REQUEST['data'];
if($input!=""){
require_once("config.php");
require_once("DBInterface.php");
require_once("encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();
date_default_timezone_set('Asia/Kolkata');

$arr = json_decode($input,true);
$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);

$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];


$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}

if($code == $v_code){
	
if($api_key == $apikey){

if($req_type == $request_url){

	$acessType = $arr['RequestData']['accessType'];
	$accessName = $arr['RequestData']['accessName']; 
	
	$fullname = $arr['RequestData']['fullname'];
	$emailadd = $arr['RequestData']['email'];
	$password = $arr['RequestData']['password'];
	$device_type = $arr['RequestData']['deviceType'];
	$device_id = $arr['RequestData']['deviceID'];
	
	$name = $db->clean_input($fullname);
	$emailadd = $db->clean_input_email($emailadd);
	$pass = md5($db->clean_input($password));
	$datet = date("Y-m-d-H-i-s");
	$token = md5($datet.$name); 
	$userKey = substr($token,0,4);
	$status = 0;

	if(empty($name)){
		
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "100",
				"ErrorMsg"	=> "Please Enter Your Full Name"
			)		
	);

	}else if(empty($emailadd)){
		
		$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "101",
				"ErrorMsg"	=> "Please Enter Your Email Address"
			)		
		);
	}else if(empty($password)){
		
		$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "102",
				"ErrorMsg"	=> "Please Enter Your Password"
			)		
		);
	}else{


		if($accessType == 'True' && empty($accessName)){
	
		$response = array(
			"successBool" => false,
			"successCode" => "",
				"response" => array(),
				"ErrorObj"	 => array(
					"ErrorCode" => "109",
					"ErrorMsg"	=> "Please Send Access Name"
				)		
		);
	
		}else{

			$data = array(
				'Full_Name' 	=> $name,
				'Email_ID' 		=> $emailadd,
				'User_Password' => $pass,
				'userKey'		=> $userKey,
				'status' 		=> $status,
				'AddDate' 		=> date("Y-m-d H:i:s")
			);
			
			//echo json_encode($data);die;		
			$chkemail = $db->chkEmail($emailadd);
			if($chkemail == 0){

				$insertDataUserTable = $db->insert("tbl_users",$data);

				if($insertDataUserTable == true){
							
				$uid = $db->lastInsertedId($userKey);	

				$code = date("his");

				$data_user_device = array(
					'user_id'		=> $uid,
					'type'			=> $device_type,
					'device_id'		=> $device_id,
					'token' 		=> $token,
					'vcode'			=> $code	
				);
				$db->insert("tbl_user_device",$data_user_device);
				//profileid
				$profile_id = strtotime(date("Ymdhis"));
				$user_meta_pid = array("meta_key" => "profile_id","meta_value"=> $profile_id,"user_id" => $uid);			
				$insert = $db->insert("tbl_usermeta",$user_meta_pid);

				//full name
				$user_meta_name = array(
						"meta_key" => "full_name",
						"meta_value"=> $name,
						"user_id" => $uid);			
				$insert = $db->insert("tbl_usermeta",$user_meta_name);

				$username = explode("@", $emailadd);
				$user_meta_username = array(
						"meta_key" => "user_name",
						"meta_value"=> "@".$username[0],
						 "user_id" => $uid);			
				$insert = $db->insert("tbl_usermeta",$user_meta_username);

				$first = explode(" ", $name);
				$initials = strtoupper(substr($first[0], 0, 1))."".strtoupper(substr($first[1], 0, 1));
				$user_meta_in = array(
						"meta_key" => "initials",
						"meta_value"=> $initials,
						 "user_id" => $uid);			
				$insert = $db->insert("tbl_usermeta",$user_meta_in);

				$user_meta_in = array(
					"meta_key" => "Bio",
					"user_id" => $uid);			
				$insert = $db->insert("tbl_usermeta",$user_meta_in);

				$user_meta_bg = array("meta_key" => "bg_color","meta_value"=>"#f52d39","user_id" => $uid);			
				$insert = $db->insert("tbl_usermeta",$user_meta_bg);

				/*if($insert){

				$verificationUrl = SITE_URL."activate.php?uid=".$enc->encode($uid)."&token=".$token;
				$companyName = "www.Odapto.com";

				$to = $emailadd;
				$subject = "Account Activation Email:: ".$companyName."";
				         
				$message = "<p>Thank you for registration on ".$companyName."<br>
				In order to activate your account, Please click the link <a href=".$verificationUrl.">Click Here</a></p>";
					
				$message .= "<p>Your Login Details:</p>";   
				$message .= "<p>Email: ".$emailadd."</p>";   
				$message .= "<p>Password:".$password."</p>";   
				$message .= "<h3>Thanks <br> Odapto Team</h3>";   
				         
				$header = "From:abc@depextechnologies.org \r\n";
				$header .= "Cc:afgh@depextechnologies.org \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";

				$retval = mail($to,$subject,$message,$header);

				if($retval == 1){
					$response = array(
					"successBool" => true,
					"successCode" => "200",
						"response" => array(
							'message'=>'Successfully Registered',
						),
						"ErrorObj"	 => array(
							"ErrorCode" => "",
							"ErrorMsg"	=> ""
						)		
					);
				}else{
					$response = array(
						"successBool" => false,
						"successCode" => "",
							"response" => array(),
							"ErrorObj"	 => array(
								"ErrorCode" => "107",
								"ErrorMsg"	=> "Email Not Send By Server"
							)		
					);

				}

				}*/
				$response = array(
					"successBool" => true,
					"successCode" => "200",
						"response" => array(
							'message'=>'Successfully Registered',
						),
						"ErrorObj"	 => array(
							"ErrorCode" => "",
							"ErrorMsg"	=> ""
						)		
					);
				}

				}else{

				$response = array(
				"successBool" => false,
				"successCode" => "",
				"response" => array(),
				"ErrorObj"	 => array(
					"ErrorCode" => "104",
					"ErrorMsg"	=> "Email Id Already Exists"
				)		
				);
				}

		}

}	
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "103",
				"ErrorMsg"	=> "Invalid Request Url"
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
$result_response  = json_encode($response);

$data = array( "serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

}

?>