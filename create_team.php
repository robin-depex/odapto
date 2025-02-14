<?php 
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();



if(isset($_REQUEST['token'])){
	if($_REQUEST['token'] == $_SESSION['Tocken']){

		$team_name = $_REQUEST['teamname'];
		$teamDesc = $_REQUEST['teamDesc'];
		$uid = $_SESSION['sess_login_id'];
		$date = date("Y-m-d H:i:s");
		$team_data = array("user_id"=>$uid,"team_name"=>$team_name,"cd"=>$date,"teamDesc"=>$teamDesc,"team_image"=>'profile.jpg');
		$insert = $db->insert("tbl_user_team",$team_data);
		$team_id = $db->getLastInsertedTeam($uid);
		if($insert){

			$team_key = $db->generateRandomString();
			$team_url = $db->make_url($team_name);
			$short_name = explode("-",$team_url);
			$srotname = $short_name[0];
			
			$data_url = array("meta_key"=>"team_url","meta_value"=>$team_url,"team_id"=>$team_id);
			$db->insert("tbl_user_teammeta",$data_url);
			
			$data_short = array("meta_key"=>"short_name","meta_value"=>$srotname,"team_id"=>$team_id);
			$db->insert("tbl_user_teammeta",$data_short);
			
			$data_short = array("meta_key"=>"website","team_id"=>$team_id);
			$db->insert("tbl_user_teammeta",$data_short);

			$data_visibility = array("meta_key"=>"team_visibility","team_id"=>$team_id,"meta_value"=>0);
			$db->insert("tbl_user_teammeta",$data_visibility);

			$data_key = array("meta_key"=>"team_key","meta_value"=>$team_key,"team_id"=>$team_id);

			$last_insert = $db->insert("tbl_user_teammeta",$data_key);

$team_admindata = $db->get_single_data('tbl_users',array('ID'=>$uid));


$date = date("Y-m-d H:i:s");
	$inv_token = md5($date."teamaddmembersbyemail");

	$count = $db->ChkInviteToken($inv_token);

	if($count > 0){
		$salt = "odaptonew";
		$invtoken = md5($date.$salt);
	}else{
		$invtoken = $inv_token;
	}


			$data_inv = array(	
		"tid"=>$team_id,
		"turl"=>$team_url,
		"tkey"=>$team_key,
		"member_id"=>$uid,
		"user_email"=>$team_admindata['Email_ID'],
		"invited_by"=>$uid,
		"invite_token"=> $invtoken,
		"invite_date"=> $date,
	);
	//echo json_encode($data);
	$dbinsert = $db->insert("tbl_team_invite",$data_inv);

	$board_members_data = array("user_id"=>$uid,"team_id"=>$team_id,"member_id"=>$uid,"member_status"=>1,"type"=>'Admin');

	$insert = $db->insert("tbl_team_members",$board_members_data);




			if($last_insert){
				
			$url = "dashboard.php?page=team&t=$team_id&u=$team_url&k=$team_key";
			$response = array("result"=>"TRUE","message"=>$url);

			}else{
				$response = array("result"=>"FALSE","message"=>"Error Found");
			}
		}else{
			$response = array("result"=>"FALSE","message"=>"Error Found");
		}

		echo json_encode($response);
		
	}
}

///////////////////////////////////////////////////// Update team profile pic //////////////////////////////////////////////

if (isset($_FILES['file']['name'])) {

	//print_r($_REQUEST);die;

	$image=$_FILES['file']['name'];
	$tid = $_FILES['file']['tid'];
	$data = array("profile_pics"=>$image,"tid"=>$tid);

	print_r($data);die;
	$update = $db->SingleRecordUpdate("tbl_users",$data,$uid);

    if (0 < $_FILES['file']['error']) {
        echo 'Error during file upload' . $_FILES['file']['error'];
    } else {
        if (file_exists('user_profile_Image/' . $_FILES['file']['name'])) {
           
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], 'user_profile_Image/' .$_FILES['file']['name']);
            
        }
    }
} 
?>