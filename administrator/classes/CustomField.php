<?php
class CustomField extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }   
   function AddCustomField($category,$fieldvalue){ 
   
   
 $sql = "INSERT INTO ".TBL_PREFIX."_custom_field SET `Category_ID`='".mysql_real_escape_string($category)."',
                                                  `Type_Name`='".mysql_real_escape_string($fieldvalue)."',
   												`Type_Url`='".$this->common->make_url($fieldvalue)."',`status`=1, `AddDate`=curdate()"; 
	$this->execute($sql);
	$this->common->Show_message("You have added custom field  successfully.");
	$this->common->wtRedirect(ADMIN_URL.'?page=customfield');

   }   
   function EditCustomField($editid,$category,$fieldvalue){    
   
   $sql = "UPDATE ".TBL_PREFIX."_custom_field SET `Category_ID`='".mysql_real_escape_string($category)."',
                                                  `Type_Name`='".mysql_real_escape_string($typeoffield)."',
   												`Type_Url`='".$this->common->make_url($fieldvalue)."'  WHERE ID=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated custom field successfully.");
	$this->common->wtRedirect(ADMIN_URL.'?page=customfield');	
   }
   
   
}
?>