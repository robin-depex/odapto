<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
if(!empty($_REQUEST)){

/* Add user */
if($_REQUEST['action'] == "adduser"){

$name = $db->clean_input($_REQUEST['fullname']);
$emailadd = $db->clean_input_email($_REQUEST['emailadd']);
$pass = md5($db->clean_input($_REQUEST['pass']));
$passwd = $_REQUEST['pass'];

date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d H:i:s");

$token = md5($date.$name);
$status = 1;

$data = array(
	'Full_Name' => $name,
	'Email_ID' => $emailadd,
	'User_Password' => $pass,
	'accessTocken' => $token,
	'status' => $status,
	'AddDate' => $date
);

$chkemail = $db->chkEmail($emailadd);

if($chkemail == 0){


$insertDataUserTable = $db->insert("tbl_users",$data);

if($insertDataUserTable == true){
			
$uid = $db->lastInsertedId($token);	


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

// username
$username = explode("@", $emailadd);
$user_meta_username = array(
		"meta_key" => "user_name",
		"meta_value"=> "@".$username[0],
		 "user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_username);

// initials
$first = explode(" ", $name);
$initials = strtoupper(substr($first[0], 0, 1))."".strtoupper(substr($first[1], 0, 1));
$user_meta_in = array(
		"meta_key" => "initials",
		"meta_value"=> $initials,
		 "user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_in);

// boi informations
$user_meta_in = array(
	"meta_key" => "Bio",
	"user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_in);

// bg color
$user_meta_bg = array("meta_key" => "bg_color","meta_value"=>"#f52d39","user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_bg);

if($insert){

$login_url = "https://www.odapto.com/login.php";
$subject = "Account Creation Email";
        
$message = "<p>Thank you for registration on Odapto</p>";
$message .= "<p>Your Login Details:</p>";   
$message .= "<p>Email: ".$emailadd."</p>";   
$message .= "<p>Password:".$_REQUEST['pass']."</p>";   
$message .= "<p> <a href='".$login_url."' style='background:#fff;border:1px solid #000;'> Login Now</a></p>";   
$message .= "<h3>Thanks <br> Odapto Team</h3>";   
        
$retval = $db->sendEmail($subject,$message,$emailadd);

$results = array(
			'result'=>'TRUE',
			'message'=>'Profile Creadted Successfully'
		);		
}
}
}else{
	$results = array(
			'result'=>'FALSE',
			'message'=>'Email Already Exists!'
		);	
}

echo json_encode($results);
	
}


/* Edit User */
if($_REQUEST['action'] == "edituser"){
$name = $db->clean_input($_REQUEST['fullname']);
$emailadd = $db->clean_input_email($_REQUEST['emailadd']);
$pass = md5($db->clean_input($_REQUEST['pass']));
$Password = $_REQUEST['pass'];
$user_id = $_REQUEST['user_id'];

date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d H:i:s");

$token = md5($date.$name);
$status = $_REQUEST['status'];



$update_userdata = array(
	'Full_Name' => $name,
	'Email_ID' => $emailadd,
	'User_Password' => $pass,
	'status' => $status
);
$cond = array("ID" => $user_id);
$updateDataUserTable = $db->update("tbl_users",$update_userdata, $cond);
if($updateDataUserTable == true){
			
//full name
$meta_name = array("meta_value"=> $name);
$cond_name = array("meta_key" => "full_name","user_id" => $user_id);
$insert = $db->update("tbl_usermeta",$meta_name,$cond_name);

// username
$username = explode("@", $emailadd);
$meta_username = array("meta_value"=> "@".$username[0],);
$cond_username = array("meta_key" => "user_name","user_id" => $user_id);		
$insert = $db->update("tbl_usermeta",$meta_username,$cond_username);

// initials
$first = explode(" ", $name);
$initials = strtoupper(substr($first[0], 0, 1))."".strtoupper(substr($first[1], 0, 1));
$user_metain = array("meta_value"=> $initials);			
$cond_metain = array("meta_key" => "initials","user_id" => $user_id);
$insert = $db->update("tbl_usermeta",$user_metain,$cond_metain);

if($insert){

$login_url = "https://www.odapto.com/login.php";
$subject = "Account Updation Email";
        
$message = "<p>Your profile Have been updated by admin</p>";
$message .= "<p>Your Login Details:</p>";   
$message .= "<p>Email: ".$emailadd."</p>";   
$message .= "<p>Password:".$_REQUEST['pass']."</p>";   
$message .= "<p> <a href='".$login_url."' style='background:#fff;border:1px solid #000;'> Login Now</a></p>";   
$message .= "<h3>Thanks <br> Odapto Team</h3>";   
        
$retval = $db->sendEmail($subject,$message,$emailadd);

$results = array(
	'result'=>'TRUE',
	'message'=>'Profile Updated Successfully'
);		
}
}
	echo json_encode($results);
}

/* Delete User */
if($_REQUEST['action'] == "deleteUser"){
	$user_id = $_REQUEST['id'];
	$update_data = array("status"=> '-1');
	$cond_disable= array("ID"=>$user_id);
	$update = $db->update("tbl_users",$update_data, $cond_disable);
	if($update == true || $update == 1){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Profile Updated Successfully'
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error Found'
		);
	}
	echo json_encode($results);
	
}

/* change Password */
if($_REQUEST['action'] == 'CahngePwd'){

	$password = $_REQUEST['password'];
	$user_id = $_REQUEST['user_id'];
    $emailadd = $_REQUEST['user_email'];
	$change_data = array(
		'User_Password' => md5($password)
	);
	$change_cond = array(
		'ID' => $user_id
	);
	$update = $db->update('tbl_users',$change_data, $change_cond);
	if($update == true || $update == 1){
	
	$login_url = "https://www.odapto.com/login.php";
	$subject = "Password Change Confirmation";
	        
	$message = "<p>Your profile Have been Changed by admin</p>";
	$message .= "<p>Your Login Details:</p>";   
	$message .= "<p>Email: ".$emailadd."</p>";   
	$message .= "<p>Password:".$password."</p>";   
	$message .= "<p> <a href='".$login_url."' style='background:#fff;border:1px solid #000;'> Login Now</a></p>";   
	$message .= "<h3>Thanks <br> Odapto Team</h3>";   
	        
	$retval = $db->sendEmail($subject,$message,$emailadd);
	$results = array(
		'result'=>'TRUE',
		'message'=>'Password Changed Successfully'
	);

	}
	echo json_encode($results);
}


}
?>