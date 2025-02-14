<?php
class State extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }   
   function AddState($countryid,$StateNm,$StateUrl,$StateCd,$StateDesc,$imgpath,$imgpath2){ 
   
   $urlState = ($StateUrl != "")? $StateUrl:$this->common->make_url($StateNm);
   
   $sql = "INSERT INTO ".TBL_PREFIX."_state SET Country_ID ='".mysql_real_escape_string($countryid)."',State_Name='".mysql_real_escape_string($StateNm)."',State_Url='".$urlState."',
    state_thumbnail = '".$imgpath."', state_banner = '".$imgpath2."',
    State_Code='".mysql_real_escape_string($StateCd)."',
		State_Desc='".mysql_real_escape_string($StateDesc)."',			  
		status=1, AddDate=curdate()";

	$this->execute($sql);
	$this->common->Show_message("You have added state successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=state');	
   }

   function EditState($editid,$countryid,$StateNm,$StateUrl,$StateCd,$StateDesc){  
   
      $urlState = ($StateUrl != "")? $StateUrl:$this->common->make_url($StateNm);
	  
   $sql = "UPDATE ".TBL_PREFIX."_state SET Country_ID='".mysql_real_escape_string($countryid)."',
                                                  State_Name='".mysql_real_escape_string($StateNm)."',
   												State_Url='".$urlState."',
                                                   State_Code='".mysql_real_escape_string($StateCd)."',
												   State_Desc='".mysql_real_escape_string($StateDesc)."'		
												   WHERE ID=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated state successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=state');	
   }
   
   
}
?>