<?php 
session_start();
require_once('DBInterface.php');

$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
	if($_REQUEST['token'] == $_SESSION['Tocken']){
		
		$uid = $_SESSION['sess_login_id'];
		$fullname = $_REQUEST['fullname'];
		$username = $_REQUEST['username'];
		$initials = $_REQUEST['initials'];
		$bio = $_REQUEST['bio'];

		$data = array("meta_value"=>$fullname);
		$con = array("meta_key"=>"full_name","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);

		$data = array("meta_value"=>$username);
		$con = array("meta_key"=>"user_name","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);

		$data = array("meta_value"=>$initials);
		$con = array("meta_key"=>"intials","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);
		
		$data = array("meta_value"=>$bio);
		$con = array("meta_key"=>"Bio","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);
		
		if($update){
			$response = json_encode(array("result"=>"TRUE","message"=>"Updated"));	
		}else{
			$response = json_encode(array("result"=>"FALSE","message"=>"Error Found"));
		}
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"not a valid Entry"));
	}
	echo $response;
}
if($_POST['profile']==="profile"){
		$uid = $_SESSION['sess_login_id'];
		$fullname = $_REQUEST['fullname'];
		$username = $_REQUEST['username'];
		$initials = $_REQUEST['initials'];
		$bio = $_REQUEST['bio'];

		$data = array("meta_value"=>$fullname);
		$con = array("meta_key"=>"full_name","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);

		$data = array("meta_value"=>$username);
		$con = array("meta_key"=>"user_name","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);

		$data = array("meta_value"=>$initials);
		$con = array("meta_key"=>"intials","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);
		
		$data = array("meta_value"=>$bio);
		$con = array("meta_key"=>"Bio","user_id"=>$uid);
		$update = $db->update("tbl_usermeta",$data,$con);
		if($update){
			$response = json_encode(array("result"=>"TRUE","message"=>"Updated"));	
		}else{
			$response = json_encode(array("result"=>"FALSE","message"=>"Error Found"));
		}

}
if($_POST['update_password']==="update_password"){
	$password=md5($_REQUEST['retupe_password']);
	$uid = $_SESSION['sess_login_id'];
	$data = array("User_Password"=>$password);
	$update = $db->SingleRecordUpdate("tbl_users",$data,$uid);
}

if($_POST['update_email']==="update_email"){
	$email=$_REQUEST['email'];
	$uid = $_SESSION['sess_login_id'];
	$data = array("Email_ID"=>$password);
	$update = $db->SingleRecordUpdate("tbl_users",$data,$uid);
}

if (isset($_FILES['file']['name'])) {

	$password=$_FILES['file']['name'];
	$uid = $_SESSION['sess_login_id'];
	$data = array("profile_pics"=>$password);
	$update = $db->SingleRecordUpdate("tbl_users",$data,$uid);

    if (0 < $_FILES['file']['error']) {
        echo 'Error during file upload' . $_FILES['file']['error'];
    } else {
        if (file_exists('user_profile_Image/' . $_FILES['file']['name'])) {
           
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], 'user_profile_Image/' .$_FILES['file']['name']);
            
        }
    }
} else {
    echo 'Please choose a file';
}

?>