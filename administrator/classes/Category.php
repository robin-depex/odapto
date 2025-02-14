<?php

class Category extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }   
   function AddCategory($Parentcategory,$CategoryNm,$CategoryUrl,$imgpath,$imgpath2,$CategoryDesc){ 
    
    
    $urlCategory = ($CategoryUrl != "")? $CategoryUrl:$this->common->make_url($CategoryNm);
     
    $sql = "INSERT INTO ".TBL_PREFIX."_category SET `Parent_ID`='".mysql_real_escape_string($Parentcategory)."',
                                                    `Category_Name`='".mysql_real_escape_string($CategoryNm)."',
     												`Category_Url`='".$urlCategory."',Category_Icon = '".$imgpath."',
                            category_banner = '".$imgpath2."',
                            `Category_Desc`='".mysql_real_escape_string($CategoryDesc)."',
  												  `status`=1, `AddDate`=curdate()";
  	$this->execute($sql);
  	$this->common->Show_message("You have added category  successfully.");
  	$this->common->wtRedirect(ADMIN_URL.'index.php?page=category');	

   }   
   function EditCategory($editid,$Parentcategory,$CategoryNm,$CategoryUrl,$CategoryDesc){  
   
   $urlCategory = ($CategoryUrl != "")? $CategoryUrl:$this->common->make_url($CategoryNm);
	  
   $sql = "UPDATE ".TBL_PREFIX."_category SET `Parent_ID`='".mysql_real_escape_string($Parentcategory)."',
                                                  `Category_Name`='".mysql_real_escape_string($CategoryNm)."',
   												`Category_Url`='".$urlCategory."',
                                                   `Category_Desc`='".mysql_real_escape_string($CategoryDesc)."'	
												   WHERE ID=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated category successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=category');	
   }
   
   
}
?>