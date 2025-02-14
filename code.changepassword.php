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
		         
		//$message .= "<p>Your Password is changed now. </p>";
		//$message .= "<p>Your Email is ".$username.". </p>";
		//$message .= "<p>Your Password is ".$password.". </p>";

		//$message .= "<h3>Thanks <br> Odapto Team</h3>";   
		

$message = '
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
               <img  margin:0 auto; display:block" src="https://www.odapto.com/images/logo.png" width="150px" alt="Odapto">
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
              <h2 style="text-align:center;">Your Password is changed now.</h2>
            <br/>      
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <table width="90%" align="center;"  border="1" cellpadding="4" style="margin:auto; width:90%; text-align:center; margin:0 auto;border-collapse: collapse;margin-top: 20px;font-size: 13px;color: #666;">
                  
                  <tr>
                     <td>Email</td>
                     <td>'.$username.'</td>
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
</html>';

$fromemail = 'admin@odapto.com';    
//$retval = $db->sendEmail($subject,$message,$email);
$retval = $db->sendEmail1($subject,$message,$email,$fromemail);

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
