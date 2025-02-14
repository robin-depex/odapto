<?php  
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if($_REQUEST['action'] == "bg_color"){
	$color = $_REQUEST['color'];
	$uid = $_REQUEST['id'];

	$data_color = array("meta_value"=>$color);

	$cond = array("meta_key"=>"bg_color","user_id"=>$uid);

	$update = $db->update("tbl_usermeta",$data_color,$cond);
	if($update){
		$result =array("result"=> "TRUE","message"=>"changed Successfully");
	}else{
		$result =array("result"=> "FALSE","message"=>"Error Found");
	}

	$response = json_encode($result);
	echo $response;
}

if($_REQUEST['action'] == "board_bg_color"){
	$color = $_REQUEST['color'];
	$uid = $_REQUEST['bid'];

	$data_color = array("bg_color"=>$color,'bg_type'=>'color');

	$cond = array("board_id"=>$uid);

	$update = $db->update("tbl_user_board",$data_color,$cond);
	if($update){
		$result =array("result"=> "TRUE","message"=>"changed Successfully");
	}else{
		$result =array("result"=> "FALSE","message"=>"Error Found");
	}

	$response = json_encode($result);
	echo $response;
}


if($_REQUEST['action'] == "board_bg_image"){
	$image = $_REQUEST['image'];
	$uid = $_REQUEST['bid'];

	$data_color = array("bg_img"=>$image,'bg_type'=>'img');

	$cond = array("board_id"=>$uid);

	$update = $db->update("tbl_user_board",$data_color,$cond);
	if($update){
		$result =array("result"=> "TRUE","message"=>"changed Successfully");
	}else{
		$result =array("result"=> "FALSE","message"=>"Error Found");
	}

	$response = json_encode($result);
	echo $response;
}

?>