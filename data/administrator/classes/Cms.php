<?php
class Cms extends DB
{
   var $common;   
   function __construct()
   {
   $this->common = new Common();
   }   
   function AddCms($menuid,$pagetitle,$seotitle,$seokey,$seodesc,$shortdesc,$fulldesc,$image1){   
   $sql = "INSERT INTO ".TBL_PREFIX."_pages SET `menu_id`='".$menuid."',
                                                   `page_title`='".$pagetitle."',
												   `seo_title`='".$seotitle."',
												    `seo_keyword`='".$seokey."',
												   `seo_desc`='".$seodesc."',
												   `short_desc`='".$shortdesc."',												   
												   	`img_path`='".$image1."',
												   `long_desc`='".$fulldesc."',												   											  
												    `status`=1, `adddate`=curdate()";
	$this->execute($sql);
	$this->common->Show_message("You have added cms successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=cms');	
   }   
   function EditCms($editid,$menuid,$pagetitle,$seotitle,$seokey,$seodesc,$shortdesc,$fulldesc,$image1){   
   $sql = "UPDATE ".TBL_PREFIX."_pages SET `menu_id`='".$menuid."',
                                                   `page_title`='".$pagetitle."',
												   `seo_title`='".$seotitle."',
												    `seo_keyword`='".$seokey."',
												   `seo_desc`='".$seodesc."',
												   `short_desc`='".$shortdesc."',
												   `img_path`='".$image1."',												   
												   													   `long_desc`='".$fulldesc."' WHERE id=".$editid."";
	$this->execute($sql);
	$this->common->Show_message("You have updated cms successfully.");
	$this->common->wtRedirect(ADMIN_URL.'index.php?page=cms');	
   }
   
   
}
?>