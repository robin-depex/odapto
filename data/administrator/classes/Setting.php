<?php
class Setting extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }   
  
   function EditSetting($editid,$website_title,$meta_title,$meta_keywords,$meta_desc,$admin_email,$logo_w,$logo_h,$copy_right,$powered_by,$powered_link,$analytic_code,$author_code,$site_varification_code,$favicon_url,$facebook_link,$google_link,$twitter_link,$youtube_link,$pin_link,$linkedin,$blogger_link,$skypid){   
   $sql = "UPDATE ".TBL_PREFIX."_site_parameter SET `website_title`='".$this->common->make_url($website_title)."', 
													`meta_title`='".$meta_title."', 
													`meta_keywords`='".$meta_keywords."',
													`meta_desc`='".$meta_desc."',  
													`admin_email`='".$admin_email."', 
													`logo_w`='".$logo_w."', 
													`logo_h`='".$logo_h."', 
													`copy_right`='".$copy_right."', 
													`powered_by`='".$powered_by."', 
													`powered_link`='".$powered_link."', 
													`analytic_code`='".$analytic_code."', 
													`author_code`='".$author_code."',
													`site_varification_code`='".$site_varification_code."', 
													`favicon_url`='".$favicon_url."', 
													`facebook_link`='".$facebook_link."', 
													`google_link`='".$google_link."', 
													`twitter_link`='".$twitter_link."', 
													`youtube_link`='".$youtube_link."', 
													`pin_link`='".$pin_link."', 
													`linkedin`='".$linkedin."',
													`blogger_link`='".$blogger_link."', 
													`skypid`='".$skypid."' WHERE id=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated Setting successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=addsetting');	
   }
   
   
}
?>