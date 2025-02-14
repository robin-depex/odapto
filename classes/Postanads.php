<?php
class Postanads extends DB
{
   var $common; 
   function __construct()
   {
   $this->common = new Common();
   }   
   function PostAds($userid,$ListTitle,$Category,$ListDesc,$keyword,$address,$CountryList,$StateList,$CityList,$ListPrice,$agreeStatus,$negotiable,$mobilesnm,$imgpaths){

      

   $sql = "INSERT INTO ".TBL_PREFIX."_ads SET 
               User_ID='".mysql_real_escape_string($userid)."',
               Title='".mysql_real_escape_string($ListTitle)."',
					Category_ID='".mysql_real_escape_string($Category)."',
					Description='".mysql_real_escape_string($ListDesc)."',
					Keywords='".mysql_real_escape_string($keyword)."',
               Address='".mysql_real_escape_string($address)."',
					Country_ID='".mysql_real_escape_string($CountryList)."',
					State_ID='".mysql_real_escape_string($StateList)."',
					City_ID='".mysql_real_escape_string($CityList)."',
               Price='".mysql_real_escape_string($ListPrice)."',
               Mobile_number='".($mobilesnm)."',
					City_optional='".mysql_real_escape_string($cityname_optional)."',
               Option_Type='".mysql_real_escape_string($typeoption)."',
					Agree='".mysql_real_escape_string($agreeStatus)."',
					Negotiable_Status='".mysql_real_escape_string($negotiable)."',
					Title_Url='".$this->common->make_url(mysql_real_escape_string($ListTitle))."',  
					status=1, adddate=curdate()";

	$this->execute($sql);
	
	
   $lastid = $this->lastInsertedId();
   
   //$Imgp = explode(", ",substr($imgpaths, 0, (strlen($imgpaths)-2)));
   $sqlnews = "INSERT INTO ".TBL_PREFIX."_ads_meta SET   
               Ads_ID='".$lastid."',
               Ads_Key='image',
               Ads_Value='".$imgpaths."'";
   $this->execute($sqlnews);

   $this->common->Show_messages_success("You have been added ads successfully.");
   
   $this->common->wtRedirect(SITE_URL.'index.php?p=post');  
   return 1;
   } 
  
   
}
?>