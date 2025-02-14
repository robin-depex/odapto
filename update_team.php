<?php 
session_start();
require_once('DBInterface.php');

$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
	if($_REQUEST['token'] == $_SESSION['Tocken']){
		
		$uid = $_REQUEST['tid'];
		$team_name = $_REQUEST['team_name'];
		//$short_name = $_REQUEST['short_name'];
		//$website = $_REQUEST['website'];
		$teamDesc = $_REQUEST['teamDesc'];


		/*$data = array("meta_value"=>$short_name);
		$con = array("meta_key"=>"short_name","team_id"=>$uid);
		$update = $db->update("tbl_user_teammeta",$data,$con);

		$data = array("meta_value"=>$website);
		$con = array("meta_key"=>"website","team_id"=>$uid);
		$update = $db->update("tbl_user_teammeta",$data,$con);*/
		
		$data = array("teamDesc"=>$teamDesc,"team_name"=>$team_name);
		$con = array("id"=>$uid);
		$update = $db->update("tbl_user_team",$data,$con);
		
		if($update){
			$response = json_encode(array("result"=>"TRUE","message"=>$teamDesc,"message1"=>$team_name));	
		}else{
			$response = json_encode(array("result"=>"FALSE","message"=>"Error Found"));
		}
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"not a valid Entry"));
	}
	echo $response;
}



/*if (isset($_FILES['file']['name'])) {

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
}*/


?>