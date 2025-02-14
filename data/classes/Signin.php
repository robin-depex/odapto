<?php
class Signin extends DB
{
   var $common;   
   var $encpst;
   function __construct()
   {
   $this->common = new Common();
   $this->encpst = new Encryption();
   }
   
   function Userlogin($user,$pass)
   {
   
    $sql1 = "SELECT Email_ID FROM ".TBL_PREFIX."_users WHERE Email_ID='".$user."' AND status=1";
	$query1 = $this->query($sql1);
	$num1 = $this->numRows($query1);
		if($num1 > 0){	
		$sql2 = "SELECT * FROM ".TBL_PREFIX."_users WHERE Email_ID='".$user."' AND User_Password='".$pass."' AND status=1";
		$query2 = $this->query($sql2);
		$fetchRow = $this->fetchNextObject($query2);
		$num2 = $this->numRows($query2);
			if($num2 > 0){	   
			   session_start();
			   ob_start();
			   $_SESSION['sess_login_id'] = $fetchRow->ID;
			   $_SESSION['sess_user'] = $fetchRow->Email_ID;
			   $_SESSION['sess_pass'] = $fetchRow->User_Password;			   
			   $this->common->wtRedirect(SITE_URL.'my-account/?action=dashboard');	
			   		   
			}else{
		$this->common->Show_messages("Password does not match."); 
		}	
		}else{
	 $this->common->Show_messages("Email address does not match."); 
	}
  
   }
   
   
   function ForgotPassword($email){  
	$sql = "SELECT Email_ID FROM ".TBL_PREFIX."_users WHERE Email_ID='".$email."'";
	$query = $this->query($sql);
	$num = $this->numRows($query); 	
	if($num > 0){
	$this->Send_mail_forgot($email);
	$this->common->Show_messages_success("Username and password sent successfully.");
	}else{
	$this->common->Show_messages("E-mail ID does not match.");
	}
  
  }
  
  
  function Send_mail_forgot($emailid){
   
   $sql2 = "SELECT Full_Name, Email_ID, User_Password, status FROM ".TBL_PREFIX."_users WHERE Email_ID='".$emailid."' AND status=1";
		$query2 = $this->query($sql2);
		$fetchRow = $this->fetchNextObject($query2);
   
$subject = "Forgot Password [JustGoBox.com]";
$message = 'Hello! '.$fetchRow->Full_Name.'<br><br>
Please check your Email and Password for login into accoount.
<br><br>
Email: '.$emailid.'<br>
Password: '.$this->encpst->decode($fetchRow->User_Password).'<br><br>
Sincerely yours,<br>
JustGoBox.com';

$header = "From:no-replay@justgobox.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";
mail($emailid,$subject,$message,$header);
   
   }
  
   
  
}

?>