<?php  
ob_start();
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();



if(isset($_REQUEST['token'])){
	if($_REQUEST['token'] == $_SESSION['Tocken']){
		//echo json_encode($_REQUEST); die;
		
		$board_details = explode("_", $_REQUEST['bDetails']);
		$board_id = $board_details[1];
		$board_star_status = $board_details[2];
		if($board_star_status == 0){
			$star = 1;
			$data = array("board_star"=>$star);
			$con = array("board_id"=>$board_id);
			$update = $db->update("tbl_user_board",$data,$con);
			if($update){
				
				$response = json_encode(array("result"=>"TRUE"));
			}else{
				$response = json_encode(array("result"=>"FALSE","message"=>"Error Found"));
			}
			echo $response;
			exit();
		}else{
			$star = 0;
			$data = array("board_star"=>$star);
			$con = array("board_id"=>$board_id);
			$update = $db->update("tbl_user_board",$data,$con);
			if($update){
				$response = json_encode(array("result"=>"TRUE"));
			}else{
				$response = json_encode(array("result"=>"FALSE","message"=>"Error Found"));
			}
			echo $response;
			exit();
		}
		
	}
}
?>