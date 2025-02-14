<?php  
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$data = explode("_",$_REQUEST['data']);
$uid = $data[0];
$bid = $data[1];
$invited_by = $_SESSION['sess_login_id'];
$result = $db->getBoardDetails($bid);
$board_url = $result['board_url'];
$board_key = $result['board_key'];
date_default_timezone_set("Asia/Kolkata");
	$date = date("Y-m-d H:i:s");
$inv_token = md5($date."boardaddmembers");
$count = $db->ChkInviteToken($inv_token);
if($count > 0){
	$salt = "odaptonew";
	$invtoken = md5($date.$salt);
}else{
	$invtoken = $inv_token;
}
$chk_invite_member = $db->ChkInviteMember($uid,$bid);

if($chk_invite_member > 0){
	echo "already Invited";
}else{
	$data_inv = array(	
		"member_id"=>$uid,
		"bid"=>$bid,
		"burl"=>$board_url,
		"bkey"=>$board_key,
		"invited_by"=>$invited_by,
		"invite_token"=>$invtoken,
		"invite_date"=> $date
	);
	//echo json_encode($data);
	$dbinsert = $db->insert("tbl_board_invite",$data_inv);

	$board_members_data = array("user_id"=>$invited_by,"board_id"=>$bid,"member_id"=>$uid,"member_status"=>1);

	$insert = $db->insert("tbl_board_members",$board_members_data);
	if($insert)
	{
		echo "Invited Suucessfully";
	}else{
		echo  "Bugs";
	}
}
