<?php 
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
	
	if($_REQUEST['token'] == $_SESSION['Tocken']){

		$board_title = $_REQUEST['boardTitle'];
		$teamId = $_REQUEST['teamId'];
		$board_privacy = $_REQUEST['board_privacy'];

		$uid = $_SESSION['sess_login_id'];
		date_default_timezone_set("Asia/Kolkata");
		$date = date("Y-m-d H:i:s");
		if($teamId == 0){
			$board_data = array("admin_id"=>$uid,"board_title"=>$board_title,"type"=>"PB","createDate"=>$date);
			
		}else{
			$board_data = array("admin_id"=>$uid,"board_title"=>$board_title,"type"=>"TB","createDate"=>$date);
		}

		$insert = $db->insert("tbl_user_board",$board_data);
		$bid = $db->getLastInsertedBoard($uid);
		
		if($insert){

			$rand = $db->generateRandomString();
			$board_url = $db->make_url($board_title);

			$data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_url);
			
			$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_key);
			
			$data_team = array("meta_key"=>"team_id","meta_value"=>$teamId,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_team);


			$data_privacy = array("meta_key"=>"board_visibility","meta_value"=>$board_privacy,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_privacy);


			$board_team_data = array("team_id"=>$teamId, "board_id"=> $bid);
			$db->insert("tbl_team_board",$board_team_data);

			if(!empty($teamId)){
				$updateboard = array("type"=>'TB');
				$cond = array("board_id"=> $bid,"admin_id" => $uid);
				$db->update("tbl_user_board",$updateboard,$cond);
			}


			$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_visibility);

			$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$bid);
			$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);

			if($last_insert){
				
			$url = SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$rand";
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
if($_POST['board_type']=="copy"){
	$uid = $_SESSION['sess_login_id'];
	date_default_timezone_set("Asia/Kolkata");
	$date = date("Y-m-d H:i:s");
	$id=$_POST['id'];
	$insert=$db->my_insert("tbl_user_board",$id,$uid,$date);
	$bid = $db->getLastInsertedBoard($uid);
		
		if($insert==true){

			$rand = $db->generateRandomString();
			$board_url = $db->make_url($board_title);

			$data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_url);
			
			$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_key);
			
			$data_team = array("meta_key"=>"team_id","meta_value"=>$teamId,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_team);


			$data_privacy = array("meta_key"=>"board_visibility","meta_value"=>$board_privacy,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_privacy);


			$board_team_data = array("team_id"=>$teamId, "board_id"=> $bid);
			$db->insert("tbl_team_board",$board_team_data);

			if(!empty($teamId)){
				$updateboard = array("type"=>'TB');
				$cond = array("board_id"=> $bid,"admin_id" => $uid);
				$db->update("tbl_user_board",$updateboard,$cond);
			}


			$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_visibility);

			$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$bid);
			$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);

			if($last_insert){
				
			$url = SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$rand";
			$response = array("result"=>"TRUE","message"=>$url);

			}else{
				$response = array("result"=>"FALSE","message"=>"Error Found");
			}
		}else{
			$response = array("result"=>"FALSE","message"=>"Error Found");
		}
	echo json_encode($response);

}

?>