<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
if($_REQUEST['token'] == $_SESSION['Tocken']){
	
	$board_id = $_REQUEST['bid'];
	$list_name = $_REQUEST['list_name'];
	$string = $_REQUEST['qstring'];
	$rand = $db->generateRandomString();
	$list_data = array("board_id"=>$board_id,"list_title"=>$list_name,"listkey"=> $rand);
	$insert_list = $db->insert("tbl_board_list",$list_data);

	if($insert_list){
		$list_id = $db->getListId($rand);		
		$listcard = array("list_id"=>$list_id,"def"=>1,"del_status"=>1);
		$db->insert("tbl_board_list_card",$listcard);
		$url = SITE_URL."dashboard.php?".$string;
		$response = json_encode(array("result"=>"TRUE","message"=>$list_name,"url"=>$url));
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"Error"));
	}
	echo $response;

}
}
?>