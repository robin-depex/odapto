<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['action'])){
	$email = $_REQUEST['email'];
	$status = $db->chkEmail($email);
	if($status == 1){
		$fp_token = md5("fp_".date("Y-m-d H:i:s"));
		$data_update = array(
			'fp_token' => $fp_token
		);
		$wh = array(
			'Email_ID' => $email
		);
		$update = $db->update('tbl_users', $data_update, $wh);
		
		$verificationUrl = SITE_URL."changePassword.php?e=".$email."&t=".$fp_token;
		
		$subject = "Change Password Email";
		         
		$message = "<p>In order to change your Password, Please click the link <a href=".$verificationUrl.">Click Here</a></p>";
		$message .= "<h3>Thanks <br> Odapto Team</h3>";   
		         

		$retval = $db->sendEmail($subject,$message,$email);

		if($retval == 1){
			echo $response = "please check your email to change password";
		}

	
	}else{
		echo $response = "Email Donot Matched";
	}
}
?>
