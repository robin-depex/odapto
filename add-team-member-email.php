<?php  
error_reporting(0);
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();
$data = explode("&",$_REQUEST['data']);
$name_d = explode("=",$data[0]);
$name = $name_d[1]; 
$email_d = explode("=",$data[1]);	
$email = $email_d[1]; 

	$bid_d = explode("=",$data[2]);
	$bid = $bid_d[1]; 

	$invited_by = $_SESSION['sess_login_id'];

	$result = $db->getTeamDetails($bid);
	$board_title = $result['team_name'];
	$board_url = $result['team_url'];
	$board_key = $result['team_key'];
	date_default_timezone_set("Asia/Kolkata");
	$date = date("Y-m-d H:i:s");
	$inv_token = md5($date."teamaddmembersbyemail");

	$count = $db->ChkInviteToken($inv_token);

	if($count > 0){
		$salt = "odaptonew";
		$invtoken = md5($date.$salt);
	}else{
		$invtoken = $inv_token;
	}

	$ChkInviteMemberByEmail = $db->ChkInviteTeamMemberByEmail($email,$bid);
	if($ChkInviteMemberByEmail > 0){
		
		$update_data = array("invite_token"=>$invtoken);
		$condition = array("tid"=>$bid,"user_email" => $email);
		$update = $db->update("tbl_team_invite",$update_data,$condition);

	}else{

	$data_inv = array(	
		"tid"=>$bid,
		"turl"=>$board_url,
		"tkey"=>$board_key,
		"user_email" => $email,
		"invited_by"=>$invited_by,
		"invite_token"=>$invtoken,
		"invite_date"=>$date
	);
			$invite_link = $db->site_url."signup.php?page=team&b=".$bid."&t=".$board_url."&k=".$board_key."&id=".$invited_by."&email=".$email."&token=".$invtoken;
	
	$subject = "Team invitation Email";
	
	$message = "<h5>Hello </h5>";         
	//$message = "<h5>Hello ".$name." </h5>";         
	//$message .= "<p>You are invited to ".$board_title."Board.<br>
	//In order to Join this Board , Please click the link </p>";
	//$message .= "<a style='width:150px;height:35px;background:#f1f1f1;padding:15px;' href=".$invite_link.">Join Board</a>";
	
	//$message .= "<h3>Thanks <br> Odapto Team</h3>";   
	         
	require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;

//$mail->isSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 587; // or 587
$mail->isHTML(true);
$mail->Username = "rohit.depex@gmail.com";
$mail->Password = "Rohit@depex#";
$mail->setFrom("mahendra.depex@gmail.com","Odapto Team");

$mail->Subject = $subject;
$mail->Body = $message;
//$mail->addAddress($email);
$mail->addAddress('pkumatiya@gmail.com');
	//$retval = $db->sendEmail($subject,$message,$email);
if(!$mail->Send()) {
    $response = "Mailer Error: " . $mail->ErrorInfo;
    echo "Invited Successfully";
		//exit();	
} else {
	$insert = $db->insert("tbl_team_invite",$data_inv);
   	echo "Bugs";
}
	

	}




	/*if($retval == 1){
		echo "Invited Successfully";
		exit();		
	}else{
		echo "Bugs";
	}	*/


	

