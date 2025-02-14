<?php 
session_start();
require_once('DBInterface.php');

$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
	if($_REQUEST['token'] == $_SESSION['Tocken']){
		
		$uid = $_REQUEST['tid'];
		$short_name = $_REQUEST['short_name'];
		$website = $_REQUEST['website'];
		$teamDesc = $_REQUEST['teamDesc'];


		$data = array("meta_value"=>$short_name);
		$con = array("meta_key"=>"short_name","team_id"=>$uid);
		$update = $db->update("tbl_user_teammeta",$data,$con);

		$data = array("meta_value"=>$website);
		$con = array("meta_key"=>"website","team_id"=>$uid);
		$update = $db->update("tbl_user_teammeta",$data,$con);
		
		$data = array("teamDesc"=>$teamDesc);
		$con = array("id"=>$uid);
		$update = $db->update("tbl_user_team",$data,$con);
		
		if($update){
			$response = json_encode(array("result"=>"TRUE","message"=>$teamDesc));	
		}else{
			$response = json_encode(array("result"=>"FALSE","message"=>"Error Found"));
		}
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"not a valid Entry"));
	}
	echo $response;
}


?>