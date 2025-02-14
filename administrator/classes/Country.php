<?php
class Country extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }   
   function AddCountry($CountryNm,$CountryUrl,$CountryCd,$CountryDesc){ 
   
   $urlCountry = ($CountryUrl != "")? $CountryUrl:$this->common->make_url($CountryNm);
   
   $sql = "INSERT INTO ".TBL_PREFIX."_country SET `Country_Name`='".mysql_real_escape_string($CountryNm)."',
   												`Country_Url`='".$urlCountry."',
                                                   `Country_Code`='".mysql_real_escape_string($CountryCd)."',
												   `Country_Desc`='".mysql_real_escape_string($CountryDesc)."',			  
												    `status`=1, `AddDate`=curdate()";
	$this->execute($sql);
	$this->common->Show_message("You have added country successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=country');	
   } 
     
   function EditCountry($editid,$CountryNm,$CountryUrl,$CountryCd,$CountryDesc){  
      $urlCountry = ($CountryUrl != "")? $CountryUrl:$this->common->make_url($CountryNm); 
   $sql = "UPDATE ".TBL_PREFIX."_country SET `Country_Name`='".mysql_real_escape_string($CountryNm)."',
   												`Country_Url`='".$urlCountry."',
                                                   `Country_Code`='".mysql_real_escape_string($CountryCd)."',
												   `Country_Desc`='".mysql_real_escape_string($CountryDesc)."' 
												   WHERE ID=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated country successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=country');	
   }
   
   
}
?>