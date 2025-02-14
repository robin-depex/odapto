<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if (isset($_FILES['file']['name'])) {
    if (0 < $_FILES['file']['error']) {
        echo 'Error during file upload' . $_FILES['file']['error'];
    } else {
        if (file_exists('../../stickers/' . $_FILES['file']['name'])) {
           
        } else {
        	$path='stickers/' .$_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], '../../stickers/' .$_FILES['file']['name']);
            $data=array('images'=>$path);
            $db->insert("stickers_images",$data);

            
        }
    }
} else {
    echo 'Please choose a file';
}