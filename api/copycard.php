<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');

$arr = json_decode($input,true);
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$userToken = $arr['RequestData']['userToken'];
$uid = $arr['RequestData']['user_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

/* Code Will Go Here*/	
	
$board_id = $arr['RequestData']['board_id'];
$list_id = $arr['RequestData']['list_id'];
$card_id = $arr['RequestData']['card_id'];	
$card_title = $arr['RequestData']['card_title'];	



$wherecard = array(
'card_id' => $card_id
	);
$card_data = $db->getsingledata('tbl_board_list_card',$wherecard);

$insert_array = array(
'card_description' => $card_data['card_description'],
'board_id' => $board_id,
'list_id' => $list_id,
'card_title' => $card_title,
'date_time' => date('Y-m-d H:i:s'),
	);
$cid = $db->insert('tbl_board_list_card',$insert_array);

/*$insertm_array = array(
'card_id'=>$cid,
'list_id'=>$list_id,
'user_id'=>$uid,
'board_id'=>$board_id,
'Menber'=>$uid,
		);
	$insert_member = $db->insert('tbl_board_card_members',$insertm_array);*/


$wherecard2 = array(
'cardid' => $card_id
	);

$attach_data = $db->getdata('tbl_board_list_card_attachements',$wherecard2);


foreach($attach_data as $attchdata){
	$insertatch_array = array(
'cardid' => $cid,
'board_id' => $board_id,
'list_id' => $list_id,
'userid' => $uid,
'attachments' => $attchdata['attachments'],
'title_name' => $attchdata['title_name'],
'ckey' => $attchdata['ckey'],
'datetime' => date('Y-m-d H:i:s'),
'status' => 1,
'cover_image' => 0,
'background' => $attchdata['background'],
'location' => $attchdata['location'],
'file_type' => $attchdata['file_type'],
'file_extenstion' => $attchdata['file_extenstion'],
		);
	$insert_attach = $db->insert('tbl_board_list_card_attachements',$insertatch_array);
}

$checklist_data = $db->getdata('tbl_board_list_card_checklist',$wherecard2);

foreach($checklist_data as $checkdata){
	$insertcheck_array = array(
'cardid' => $cid,
'board_id' => $board_id,
'list_id' => $list_id,
'userid' => $uid,
'checklist' => $checkdata['checklist'],
'date_time' => date('Y-m-d H:i:s'),
'ckey' => $checkdata['ckey'],
'status' => 1,
'refrenceid' => $checkdata['refrenceid'],
		);
	//print_r($insertcheck_array);
	$maincheckid = $db->insert('tbl_board_list_card_checklist',$insertcheck_array);
$wherecard3 = array(
'checklist_id' => $checkdata['id']
	);

	$checklist_item_data = $db->getdata('tbl_board_list_card_checklist_item',$wherecard3);
	foreach($checklist_item_data as $checkitemdata){
$insertcheckitem_array = array(
'item_name' => $checkitemdata['item_name'],
'status' => $checkitemdata['status'],
'checklist_id' => $maincheckid,
'board_id' => $board_id,
'list_id' => $list_id,
		);
	$mainitmcheckid = $db->insert('tbl_board_list_card_checklist_item',$insertcheckitem_array);
	}
}

$cardcomment_data = $db->getdata('tbl_board_list_card_comments',$wherecard2);
foreach($cardcomment_data as $cardcomment){
$insertcomment_array = array(
'cardid' => $cid,
'board_id' => $board_id,
'list_id' => $list_id,
'userid' => $uid,
'comments' => $cardcomment['comments'],
'date_time' => date('Y-m-d H:i:s'),
'ckey' => $cardcomment['ckey'],
'status' => 1,
		);
$commentid = $db->insert('tbl_board_list_card_comments',$insertcomment_array);
}

$cardlabl_data = $db->getdata('tbl_board_list_card_labels',$wherecard2);
foreach($cardlabl_data as $cardlabl){
$insertlabl_array = array(
'cardid' => $cid,
'board_id' => $board_id,
'list_id' => $list_id,
'userid' => $uid,
'labels' => $cardlabl['labels'],
'datetime' => date('Y-m-d H:i:s'),
'ckey' => $cardlabl['ckey'],
'status' => 1,
		);
$lablid = $db->insert('tbl_board_list_card_labels',$insertlabl_array);
}


$duedate_data = $db->getsingledata('tbl_board_list_duedate',$wherecard);

$insertdue_array = array(
'duedate' => $duedate_data['duedate'],
'duetime' => $duedate_data['duetime'],
'card_id' => $cid,
'userid' => $uid,
'board_id' => $board_id,
'list_id' => $list_id,
'complete_status' => $duedate_data['complete_status'],
	);
$dueid = $db->insert('tbl_board_list_duedate',$insertdue_array);





	$response = array(
		"successBool" => true,
		"responseType" => "copy_card",
		"successCode" => "200",
			"response" => array(
				'message' => "Copy Card successfully"
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);

	
/* End Of Code */		

}else{
	
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "106",
				"ErrorMsg"	=> "Invalid APIkey"
			)		
	);
}

}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "105",
				"ErrorMsg"	=> "Update Your Version"
			)		
	);
}
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "105",
				"ErrorMsg"	=> "Token Mismatched"
			)		
	);
}
$result_response  = json_encode($response);

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;
