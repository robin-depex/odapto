<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['action'])){
	
	if($_REQUEST['action'] == "change_pwd"){


	$password = $_REQUEST['password'];
	$email = $_REQUEST['email'];
	$fp_token = $_REQUEST['fp_token'];

	$status = $db->verifyFpToken($email,$fp_token);
    if($status == 1){

		$new_token = md5("fp_".date("Y-m-d H:i:s"));
		$data_update = array(
			'User_Password' => md5($password),
			'fp_token' => $new_token,
		);
		$wh = array(
			'Email_ID' => $email
		);
		$update = $db->update('tbl_users', $data_update, $wh);
		$username = $db->getData($email);
		
		$subject = "Password Changed Confirmation Email";
		         
		$message .= "<p>Your Password is changed now. </p>";
		$message .= "<p>Your Email is ".$username.". </p>";
		$message .= "<p>Your Password is ".$password.". </p>";

		$message .= "<h3>Thanks <br> Odapto Team</h3>";   
		$retval = $db->sendEmail($subject,$message,$email);
		if($retval == 1){
			echo $response = 200;
		}

	
	}else{
		echo $response = "Token Donot Matched";
	}
	}else{
		echo $response = "Invalid Action";
	}	
}
?>
