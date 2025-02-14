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
		
		$subject = "Odapto: Password changed confirmation mail";
		         
		//$message = "<p>In order to change your Password, Please click the link <a href=".$verificationUrl.">Click Here</a></p>";
		//$message .= "<h3>Thanks <br> Odapto Team</h3>";  





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
//$urlconfirm = $DB->site_url."welcome.php?userverify=".$token."&uid=";
$message .= '<body style="background:#e6e6e6">

  <div style="max-width:800px;margin:auto;margin-top:20px";>

    <div style="width:100%;background:#8c2d37 !important;border-radius:8px 8px 0 0;padding:10px;">
        <img style="max-width:120px;margin:auto;display:block" src="https://www.odapto.com/images/logo.png">
    </div>
       <div style="background:#fff;width:100%;padding:20px 0;padding-bottom:0">
       	<h2 style="text-align:center">We are glad you are here!</h2>
<h2 style="text-align:center">In order to change your Password, Please click below link </h2>
       	<a href="'.$verificationUrl.'" class="confirm-btn">Recovery Password</a>';
$message .= '<div style="text-align:center;margin:30px 0">
			<p style="margin-bottom:20px">We just want to confirm you are you.</p>
			</div>

  </div>
</div> 

</body>
</html>';




		         
    $fromemail = 'admin@odapto.com';    
$retval = $db->sendEmail1($subject,$message,$email,$fromemail);
	//	$retval = $db->sendEmail($subject,$message,$email);

		if($retval == 1){
			echo $response = "Please check your email to change password";
		}

	
	}else{
		echo $response = "Email Donot Matched";
	}
}
?>
