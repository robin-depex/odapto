<?php
class Registration extends DB
{
   var $common; 
   var $encpst;  
   function __construct()
   {
      $this->common = new Common();
      $this->encpst = new Encryption();
   }   
   function MakeRegistration($fullname,$emailadd,$pass,$repassword,$agreestatus,$typeofaccount,$captchavalue){
   
   	//START check the availability of email id
   if(trim($emailadd) != ""){
    $sqlcheck = "SELECT * FROM ".TBL_PREFIX."_users WHERE `Email_ID`='".mysql_real_escape_string($emailadd)."'";
	$reults = $this->query($sqlcheck);
	$numrw = $this->numRows($reults);
	}
	//END check the availability of email id
    
   if(trim($fullname) == ""){
 $this->common->Show_messages("Please enter your name.");
   $this->common->wtRedirect(SITE_URL.'register/');	
   } else if(trim($emailadd) == ""){
   $this->common->Show_messages("Please enter your email address.");
   $this->common->wtRedirect(SITE_URL.'register/');
   
   }else if(!filter_var($emailadd, FILTER_VALIDATE_EMAIL)){  	   
   $this->common->Show_messages("Please enter valid email address.");
   $this->common->wtRedirect(SITE_URL.'register/');  

   }  else if(trim($pass) == ""){   
	$this->common->Show_messages("Please enter password.");
   $this->common->wtRedirect(SITE_URL.'register/');
   } else if(strlen(trim($pass)) < 7 ){
	$this->common->Show_messages("Password length should be greater than six letters.");
   $this->common->wtRedirect(SITE_URL.'register/');	   
   }
   else if(trim($repassword) == ""){
   
	$this->common->Show_messages("Please enter confirm password.");
   $this->common->wtRedirect(SITE_URL.'register/');
   } else if(trim($repassword) != trim($pass)){
 	$this->common->Show_messages("Confirm password does not match.");
   $this->common->wtRedirect(SITE_URL.'register/');
   
   } else if($numrw > 0){
 	$this->common->Show_messages("Email id already exist. Please try another.");
   $this->common->wtRedirect(SITE_URL.'register/');


   } else if (strlen($this->encpst->decode($pass)) < 6 ){
   
   
   $this->common->Show_messages("Please enter password not less than 6 character.");
   $this->common->wtRedirect(SITE_URL.'register/');
   }else if($agreestatus == ""){
 	$this->common->Show_messages("Please check the terms &amp; condition.");
   $this->common->wtRedirect(SITE_URL.'register/');
   
   } else if($captchavalue != $_SESSION["vercode"]){
 	$this->common->Show_messages("Captcha code does not match.");
   $this->common->wtRedirect(SITE_URL.'register/');
   
   } else {   
    
  
   $DirName = rand(1111111, 99999999999);
   $sql = "INSERT INTO ".TBL_PREFIX."_users SET   `Full_Name`='".mysql_real_escape_string($fullname)."',
                                                   `Email_ID`='".mysql_real_escape_string($emailadd)."',
												    `User_Password`='".mysql_real_escape_string($pass)."',
												   `agree`='".mysql_real_escape_string($agreestatus)."',	
												   `User_Type`='".$typeofaccount."',
												   `Directory_Name`='".$DirName."',	  
												    `status`=0, `AddDate`=curdate()";
	$this->execute($sql);
	

	mkdir('../products/'.$DirName.'/');
	mkdir('../products/'.$DirName.'/big/');
	mkdir('../products/'.$DirName.'/thumb/');
	$lastids = $this->lastInsertedId();
	
	$this->Send_mail($emailadd,$fullname,$pass,$lastids);
	$this->common->Show_messages_success("You have been registered successfully. Please check your mail and verify own account.");
	return 1;
	$this->common->wtRedirect(SITE_URL.'register/');	
	
   }  
   } 
  
   
   
   function Send_mail($emailid,$name,$passwrd,$insertid){
	   
      $to = $emailid;

      $subject = "Activate Account [www.JustGoBox.com]";

      $message = 'Hello! '.$name.'<br><br>
      Thank you for registration on JustGoBox.com<br>
      In order to activate your account, Please click the link <a href="http://www.justgobox.com/register/activate.php?uid='.$this->encpst->encode($insertid).'">Click Here</a>
      <br><br>
      Email: '.$emailid.'<br>
      Password: '.$this->encpst->decode($passwrd).'<br><br>
      Sincerely yours,<br>
      JustGoBox.com';

      $header = "From:no-replay@justgobox.com \r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "Content-type: text/html\r\n";

      $retval = mail ($to,$subject,$message,$header);

   }
}
?>