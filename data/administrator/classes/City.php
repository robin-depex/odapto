<?php
class City extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }   
   function AddCity($countryid,$selectstate,$cityNm,$cityUrl,$cityCd,$optionalNm,$cityDesc){ 
   
   $urlCity = ($cityUrl != "")? $cityUrl:$this->common->make_url($cityNm);
   
   $sql = "INSERT INTO ".TBL_PREFIX."_city SET `Country_ID`='".mysql_real_escape_string($countryid)."',
                                                  `State_ID`='".mysql_real_escape_string($selectstate)."',
												  `City_Name`='".mysql_real_escape_string($cityNm)."',
   												   `City_Url`='".$urlCity."',
                                                   `City_Code`='".mysql_real_escape_string($cityCd)."',
												   `City_Optional`='".mysql_real_escape_string($optionalNm)."',
												   `City_Desc`='".mysql_real_escape_string($cityDesc)."',			  
												    `status`=1, `AddDate`=curdate()";
	$this->execute($sql);
	$this->common->Show_message("You have added city successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=city');	
   }   
   function Editcity($editid,$countryid,$selectstate,$cityNm,$cityUrl,$cityCd,$optionalNm,$cityDesc){  
   
       $urlCity = ($cityUrl != "")? $cityUrl:$this->common->make_url($cityNm);
	  
   $sql = "UPDATE ".TBL_PREFIX."_city SET `Country_ID`='".mysql_real_escape_string($countryid)."',
                                                  `State_ID`='".mysql_real_escape_string($selectstate)."',
												  `City_Name`='".mysql_real_escape_string($cityNm)."',
   												   `City_Url`='".$urlCity."',
                                                   `City_Code`='".mysql_real_escape_string($cityCd)."',
												   `City_Optional`='".mysql_real_escape_string($optionalNm)."',
												   `City_Desc`='".mysql_real_escape_string($cityDesc)."' 
												   WHERE ID=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated city successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=city');	
   }
   
   
}
?>