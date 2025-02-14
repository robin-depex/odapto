<?php  
require_once("DBInterface.php");
$db = new Database();
$db->connect();

echo json_encode($_REQUEST['data']); die;
$data = explode("&",$_REQUEST['data']);

$bid = explode("=",$data[0]);
$bid= $bid[1];

$burl = explode("=",$data[1]);
$burl= $burl[1];

$bkey = explode("=",$data[2]);
$bkey= $bkey[1];

$uid = explode("=",$data[3]);
$uid= $uid[1];

$inv_token = explode("=",$data[4]);
$inv_token= $inv_token[1];

$type = explode("=",$data[5]);
$inv_type= $type[1];

$count = $db->ChkInviteToken($inv_token);
if($count > 0){
	date_default_timezone_set("Asia/Kolkata");
	$date = date("Y-m-d H:i:s");
	$salt = "odaptonew";
	$invtoken = md5($date.$salt);
}else{
	$invtoken = $inv_token;
}
$data = array(
		"bid"			=> $bid,
		"burl"			=> $burl, 
		"bkey"			=> $bkey,	
		"invited_by"	=> $uid,
		"invite_token"	=> $invtoken,
		"invite_date"	=> $date
	);
$insert = $db->insert("tbl_board_invite",$data);
if($insert){
	
	$invite_link = "signup.php?page=board&b=".$bid."&t=".$burl."&k=".$bkey."&id=".$uid."&token=".$invtoken;
	echo $invite_link;
}
?>