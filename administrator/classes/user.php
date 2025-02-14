<?php
class User extends DB
{
   var $common;   
   var $encpst; 
   
   function __construct()
   {
      $this->common = new Common();
      $this->encpst = new Encryption();

   }   
   
   // Add user COde
   function AddUser($Full_Name,$Email_ID,$password){ 
   // echo $password; die;
   $sql = "INSERT INTO ".TBL_PREFIX."_users SET 
      Full_Name='".mysql_real_escape_string($Full_Name)."',
      Email_ID='".$Email_ID."',
      User_Password='".$password."',
      AddDate = '".date("Y-m-d")."'
		";
	$this->execute($sql);
   
   $this->common->Show_message("You have added country successfully.");
   $this->common->wtRedirect(ADMIN_URL.'index.php?page=user'); 
 

   } 
   // edit user COde     
   function EditUser($editid,$Full_Name,$Email_ID,$status){  
      
   $sql = "UPDATE ".TBL_PREFIX."_users SET 
          Full_Name='".mysql_real_escape_string($Full_Name)."',
          Email_ID='".$Email_ID."',
          status='".mysql_real_escape_string($status)."'
			 WHERE ID=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated country successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=user');	
   }
   
 
}
?>