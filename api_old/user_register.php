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
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}

if($code == $v_code){
	
if($api_key == $apikey){

	$acessType = $arr['RequestData']['accessType'];
	$accessName = $arr['RequestData']['accessName']; 
	
	$fullname = $arr['RequestData']['fullname'];
	$emailadd = $arr['RequestData']['email'];
	$password = $arr['RequestData']['password'];
	$device_type = $arr['RequestData']['deviceType'];
	$device_id = $arr['RequestData']['deviceID'];
	$singupWith = $arr['RequestData']['singupWith'];
	$device_token = $arr['RequestData']['device_token'];


 if($password=='' && $singupWith!='')
{
	$password=123456;
	$status=1;
}
	
	
	
	$name = $fullname;
	$emailadd = $emailadd;
	$pass = md5($password);
	$datet = date("Y-m-d-H-i-s");
	$token = md5($datet.$name); 
	$userKey = substr($token,0,4);
	$status = 1;
	


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
	}
	else if(empty($password) && $singupWith==''){
		
		$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "102",
				"ErrorMsg"	=> "Please Enter Your Password"
			)		
		);
	}
	


	else if($singupWith=='google' ){


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
				'login_type' 		=> $singupWith,
				'AddDate' 		=> date("Y-m-d H:i:s")
			);
			
			//echo json_encode($data);die;		
			$chkemail = $db->chkEmail($emailadd);
			if($chkemail == 0){

				$insertDataUserTable = $db->insert("tbl_users",$data);

				if($insertDataUserTable == true){
							
				$uid = $db->lastInsertedId($userKey);	
				//$fullname = $db->getname('tbl_users',$uid);	

				$code = date("his");

				$data_user_device = array(
					'user_id'		=> $uid,
					'type'			=> $device_type,
					'device_id'		=> $device_id,
					'token' 		=> $token,
					'push_token'	=> $device_token,
					'vcode'			=> $code,
					'status'        =>1
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
				
				$user_meta_bgimg = array("meta_key" => "bg_img","meta_value"=>"","user_id" => $uid);			
				$insert = $db->insert("tbl_usermeta",$user_meta_bgimg);

				if($insert){

				
				$companyName = "www.Odapto.com";

				$to = $emailadd;
				$subject = "Odapto: Your account details.";
                
$message = '<html>
<head>
<title>Mailer</title>
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">';
$message .= '<style type="text/css">';
$message .=  " *{
	margin: 0;
	padding: 0;
	box-sizing:border-box;
	font-family: 'Montserrat', sans-serif;
}
.confirm-btn{
    border-radius: 3px;
    background: #3aa54c;
    color: #fff !important;
    display: block;
    font-weight: 700;
    font-size: 16px;
    line-height: 1.25em;
    margin: 24px auto 24px;
    padding: 10px 18px;
    text-decoration: none;
    width: 300px;
    letter-spacing: 1px;
    text-align: center;
}
table, th, td {
  border: 1px solid #e8e8e8;
  border-collapse: collapse;
  font-size: 13px;
  color: #666;
}
th, td {
  padding: 5px;
  text-align: left;
}
body p {
	color: #666;
	font-size: 14px;
}
</style>
</head>";

$message .= '<body style="background:#e6e6e6">

  <div style="max-width:800px;margin:auto;margin-top:20px";>

    <div style="width:100%;background:#8c2d37 !important;border-radius:8px 8px 0 0;padding:10px;">
        <img style="max-width:120px;margin:auto;display:block" src="https://www.odapto.com/images/logo.png">
    </div>
       <div style="background:#fff;width:100%;padding:20px 0;padding-bottom:0">
        <h2 style="text-align:center">We are glad you are here!</h2>';

        
       $message .= '<table style="width:540px;margin:auto">
      <tr>
      <td>Email</td>
      <td>'.$emailadd.'</td>
      </tr>
      <tr>
      <td>Password</td>
      <td>********</td>
      </tr>
      </table>';

$message .= '<div style="text-align:center;margin:30px 0">
      <p style="margin-bottom:20px">We just want to confirm you are you.</p>
      <p>If you did not create a Odapto account, just delete this email and everything will go back to the way it was.</p>
      </div>

  </div>
</div> 

</body>
</html>';

				         
				$header = "From:admin@odapto.com \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";
                $fromemail = 'admin@odapto.com';
                $retval = $db->sendEmail1($subject,$message,$emailadd,$fromemail);

				/*if($retval == 1){*/
					$response = array(
					"successBool" => true,
					"responseType" => "user_register",
					"successCode" => "200",
					
						"response" => array(
							"user_id" => $uid,
							"fullname" => $name,
							"userToken" => $token,
							"emailid"   => $emailadd,
							"profileImage" =>"",
                           'membership_plan' => 1,
						'message'=>'Successfully Registered. ',
						),
						"ErrorObj"	 => array(
							"ErrorCode" => "",
							"ErrorMsg"	=> ""
						)		
					);



			/*	}
				/*else{
					$response = array(
						"successBool" => false,
						"successCode" => "",
							"response" => array(),
							"ErrorObj"	 => array(
								"ErrorCode" => "107",
								"ErrorMsg"	=> "Email Not Send By Server"
							)		
					);

				}*/

				}
				
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



	else{


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

				if($insert){

				
				$companyName = "www.Odapto.com";

				$to = $emailadd;
				$subject = "Odapto: Your account details.";
				$verificationUrl = SITE_URL."activate.php?uid=".$uid."&token=".$token;         
		$message='
<!doctype html> 
<html>
   <head>
      <meta charset="utf-8">
      <title>Odapto Registration</title>
      <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
   </head>
   <body>
      <div style="margin:auto;background: #f7f7f7; float:left;  margin-top: 2px;padding:2px 0; border: 2px solid #8c2d37;
    border-radius: 10px;">
      <table  align="center;" border="0" style="margin:auto; width:100%; text-align:center;font-size: 13px;color: #666;background: #fff;">
         <tr>
            <td colspan="2" style="background-color:#8c2d37; border-radius: 8px 8px 0 0; padding: 7px 0;">
               <img  margin:0 auto; display:block" src="https://www.odapto.com/images/logo.png" width="150px">
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h2 style="text-align:center;">We"re glad you"re here!</h2>
            </td>
         </tr>
         <tr>
            <td colspan="2">
            <br/>
               <a href="'.$verificationUrl.'" title="Click Here"> 
                <img style="max-width:100%; " src="https://www.odapto.com/images/click-button.png" alt="Click Here To Verify Your Email Address">
            </a>
            <br>
            <p>If you face any problem with above button then copy this link and paste on your browser </p>
            <p>'.$verificationUrl.'</p>
            <br/>      
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <table width="90%" align="center;"  border="1" cellpadding="4" style="margin:auto; width:90%; text-align:center; margin:0 auto;border-collapse: collapse;margin-top: 20px;font-size: 13px;color: #666;">
                  
                  <tr>
                     <td>Email</td>
                     <td>'.$emailadd.'</td>
                  </tr>
                             
                  <tr>
                     <td>Password</td>
                     <td>***********</td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <p style="margin-bottom:5px;">We just want to confirm you"re you.</p>
               <p>If you didn"t create a Odapto account, just delete this email and everything will go back to the way it was.</p>
            </td>
          </tr>  
          <tr>
                                <td>
                                <img style="width:650px" width="650" src="https://www.odapto.com/images/mailer.jpg">     
                                </td>     
                                </tr>
      </table>
   </div>
   </body>
</html>
';
 
				         
				$header = "From:admin@odapto.com \r\n";
				//	$header .= "From:Odapto Team \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";

				//$retval = mail($to,$subject,$message,$header);
				$fromemail = 'admin@odapto.com';
                $retval = $db->sendEmail1($subject,$message,$emailadd,$fromemail);
				if($retval == 1){
					$response = array(
					"successBool" => true,
					"successCode" => "200",
						"response" => array(
							"user_id" => $uid,
							"fullname" => $name,
							"userToken" => $token,
							"emailid"   => $emailadd,
							"profileImage" =>"",
                           'membership_plan' => 1,
						'message'=>'Successfully Registered. Please check your email check your login detail',
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

				}
				
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

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;


?>