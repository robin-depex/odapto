<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
if($_REQUEST['token'] == $_SESSION['Tocken']){
	$id = explode("_",$_REQUEST['title_id']);
	$list_id = $id[1]; 
	$list_name = $_REQUEST['name'];
	$list_data = array("list_title"=>$list_name);
	$cond = array("list_id"=>$list_id);
	$update_title = $db->update("tbl_board_list",$list_data,$cond);
	if($insert_list){
		$response = json_encode(array("result"=>"TRUE","message"=>$list_name));
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"Error"));
	}
	echo $response;

}
}
?>