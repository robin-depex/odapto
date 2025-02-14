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
		date_default_timezone_set("Asia/Kolkata");
		$date = date("Y-m-d H:i:s");
		$team_data = array("user_id"=>$uid,"team_name"=>$team_name,"cd"=>$date,"teamDesc"=>$teamDesc);
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

			if($last_insert){
				
			$url = SITE_URL."dashboard.php?page=team&t=$team_id&u=$team_url&k=$team_key";
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
?>