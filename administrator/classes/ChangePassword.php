<?php
class ChangePassword extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }  
 
   
   function ChangePassword($username,$oldpassword,$newpassword,$confirmpass){   
		$sql3 = "SELECT password FROM ".TBL_PREFIX."_admin";
		$query3 = $this->query($sql3);
		$rows3 = $this->fetchNextObject($query3);	
		if(trim($rows3->password)==trim($oldpassword)){		
			if(trim($newpassword)==trim($confirmpass)){	
			$sqlUpdate = "Update ".TBL_PREFIX."_admin SET username='".trim($username)."',password='".trim($newpassword)."' WHERE id=1";
			$this->execute($sqlUpdate);					
			$this->common->Show_message("You have updated username and password successfully.");
			$this->common->wtRedirect(ADMIN_URL.'index.php?page=passwords');	
			}else{
			$this->common->Show_message("Confirm password does not match.");
			$this->common->wtRedirect(ADMIN_URL.'index.php?page=passwords');	
			}		
		}else{
		$this->common->Show_message("Old password does not match.");
		$this->common->wtRedirect(ADMIN_URL.'index.php?page=passwords');	
		}   
   } 
   
  
}

?>