<?php
class Admin extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }
   
   function Admin($user,$pass)
   {
   
    $sql1 = "SELECT username FROM ".TBL_PREFIX."_admin WHERE username='".$user."'";
	$query1 = $this->query($sql1);
	$num1 = $this->numRows($query1);
		if($num1 > 0){	
		$sql2 = "SELECT * FROM ".TBL_PREFIX."_admin WHERE username='".$user."' AND password='".$pass."'";
		$query2 = $this->query($sql2);
		$fetchRow = $this->fetchNextObject($query2);
		$num2 = $this->numRows($query2);
			if($num2 > 0){	   
			   session_start();
			   ob_start();
			   $_SESSION['sess_login_id'] = $fetchRow->id;
			   $_SESSION['sess_user'] = $fetchRow->username;
			   $_SESSION['sess_pass'] = $fetchRow->password;			   
			   $this->common->wtRedirect(ADMIN_URL.'index.php?page=home');	
			   		   
			}else{
		$this->common->Push_Error("Password does not match."); 
		}	
		}else{
	 $this->common->Push_Error("Username does not match."); 
	}
  
   }
   
  function ForgotPassword($email){  
	$sql = "SELECT email FROM ".TBL_PREFIX."_admin WHERE email='".$email."'";
	$query = $this->query($sql);
	$num = $this->numRows($query); 	
	if($num > 0){
	$this->common->Show_message("Username and password sent successfully.");
	}else{
	$this->common->Push_Error("E-mail ID does not match.");
	}
  
  }
   
   
   function ChangePassword($username,$oldpassword,$newpassword,$confirmpass){   
		$sql3 = "SELECT password FROM ".TBL_PREFIX."_admin";
		$query3 = $this->query($sql3);
		$rows3 = $this->fetchNextObject($query3);	
		if(trim($rows3->password)==trim($oldpassword)){		
			if(trim($newpassword)==trim($confirmpass)){	
			$sqlUpdate = "Update ".TBL_PREFIX."_admin SET username='".trim($username)."',password='".trim($newpassword)."'";
			$this->execute($sqlUpdate);	
				
			$this->common->Show_message("You have updated username and password successfully.");
			}else{
			$this->common->Show_message("Confirm password does not match.");
			}		
		}else{
		$this->common->Show_message("Old password does not match.");
		}   
   } 
   
   
   function ChangeEmail($email){
   
     $regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
     if($email!=""){	 
	 if ( !preg_match($regexp, $email) ){
	 $this->common->Push_Error("Please enter valid E-mail ID.");
	 }else{
	 		$sql = "Update ".TBL_PREFIX."_admin SET email='".trim($email)."'";
			$this->execute($sql);	
	 $this->common->Show_message("You have updated E-mail ID successfully.");
	 }
	 
	 }else{
	 $this->common->Push_Error("Please enter your E-mail ID.");
	 }   
   }
}

?>