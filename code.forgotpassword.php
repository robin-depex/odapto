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
		
		$subject = "Odapto: Password recovery mail";
		         
		//$message = "<p>In order to change your Password, Please click the link <a href=".$verificationUrl.">Click Here</a></p>";
		//$message .= "<h3>Thanks <br> Odapto Team</h3>";  





$message = '<!doctype html> 
<html>
   <head>
      <meta charset="utf-8">
      <title>Password Recovery</title>
      <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
   ';
$message .= '<style type="text/css">';
$message .=  " 
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

</style>
</head>";

$message.='

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
               <h1 style="text-align:center;">We"re glad you"re here!</h1>
            </td>
         </tr>
         <tr>
            <td colspan="2">
            <br/>
            <h2 style="text-align:center">In order to change your Password, Please click below link </h2>
               <a href="'.$verificationUrl.'" class="confirm-btn">Recovery Password</a>
            <br/>      
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

		         
$fromemail = 'admin@odapto.com'; 
$retval = $db->sendEmail1($subject,$message,$email,$fromemail);
		if($retval == 1){
			echo $response = "Please check your email to change password";
		}

	
	}else{
		echo $response = "Email Donot Matched";
	}
}
?>
