<?php

 error_reporting(0);
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
echo $_FILES['file']['name'];
if (isset($_FILES['file']['name'])) {
   
$imagePath = $path."/admin/temp/images/";
					$uniquesavename=time().uniqid(rand());
			$destFile = $imagePath.$_FILES['file']['name'];
					$image_name = $uniquesavename.$_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'],$destFile);
//echo $_FILES['file']['name'];
//echo $status;
        /*if (file_exists('images/' . $_FILES['file']['name'])) {
           
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], 'images/' .$_FILES['file']['name']);
            
        }*/
   
} else {
    echo 'Please choose a file';
}
    
/* 
 * End of script
 */