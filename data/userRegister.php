<?php  
require_once("common/config.php");
require_once("DBInterface.php");
require_once("common/encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();


if(!empty($_REQUEST)){

if(isset($_REQUEST['agreestatus'])){

$name = $db->clean_input($_REQUEST['fullname']);
$emailadd = $db->clean_input_email($_REQUEST['emailadd']);
$pass = md5($db->clean_input($_REQUEST['pass']));
$passwd = $_REQUEST['pass'];

date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d H:i:s");

$token = md5($date.$name);
$status = 0;



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

if(!empty($_REQUEST['id']) || !empty($_REQUEST['bid']) || !empty($_REQUEST['invited_by'])){
	$id = $_REQUEST['id'];
	$board_id = $_REQUEST['bid'];
	$user_id = $_REQUEST['invited_by'];	
	$invite_data = array("user_id"=>$user_id,"board_id"=>$board_id,"member_id"=>$uid,"member_status"=>1);
	$insert = $db->insert("tbl_board_members",$invite_data);
	if($insert){
		$cond = array("id"=>$id);
		$inv_token = md5(date("Y-m-d-h-i-s")."saltvalue");
		$update_data = array("invite_token"=>$inv_token);
		$db->update("tbl_board_invite",$update_data,$cond);
	}
}

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
$verificationUrl = SITE_URL."activate.php?uid=".$uid."&token=".$token;
$subject = "Account Activation Email";
        
$message = "<p>Thank you for registration on ".$companyName."<br>
In order to activate your account, Please click the link <a href=".$verificationUrl.">Click Here</a></p>";
$message .= "<p>Your Login Details:</p>";   
$message .= "<p>Email: ".$emailadd."</p>";   
$message .= "<p>Password:".$_REQUEST['pass']."</p>";   
$message .= "<h3>Thanks <br> Odapto Team</h3>";   
        
$retval = $db->sendEmail($subject,$message,$emailadd);

if($retval == 1){
	ob_start();
	session_start();
	$_SESSION['user_token'] = $token;
	$url = SITE_URL."welcome.php?token=".$token;
	header('location: '.$url.'');
	exit();		
}else{
	$results = array(
			'result'=>'FALSE',
			'message'=>'Error While Registering!'
	);
}	
}
}
}else{
	$results = array(
			'result'=>'FALSE',
			'message'=>'Email Already Exists!'
		);	
}

if($results['result']=="FALSE"){
	$msg = str_replace(" ", "+", $results['message']);
	$url = SITE_URL."signup.php?msg=".$msg;
	header("location:".$url);
}
		
}

}

?>