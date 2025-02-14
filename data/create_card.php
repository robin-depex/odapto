<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
if($_REQUEST['token'] == $_SESSION['Tocken']){
	
	//echo json_encode($_REQUEST); die();
	$list_id = $_REQUEST['list_id'];
	$card_title = $_REQUEST['card_title'];
	$page = $_REQUEST['qstring'];
	$b = $_REQUEST['b'];
	$t = $_REQUEST['t'];
	$k = $_REQUEST['k'];
	$string = $page."&b=".$b."&t=".$t."&k=".$k; 
	
	$card_data = array("list_id"=>$list_id,"card_title"=>$card_title);
	$insert_card = $db->insert("tbl_board_list_card",$card_data);
	if($insert_card){
		$url = SITE_URL."dashboard.php?".$string;
		$response = json_encode(array("result"=>"TRUE","url"=>$url));
	}else{
		$response = json_encode(array("result"=>"FALSE","message"=>"Error"));
	}
	echo $response;

}
}
?>