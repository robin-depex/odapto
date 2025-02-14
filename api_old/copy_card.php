<?php  

$input = file_get_contents('php://input');
$input = $_REQUEST['data'];
if($input!=""){
require_once("config.php");
require_once("DBInterface.php");
require_once("encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');

$arr = json_decode($input,true);
$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);
$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];
//print_r($arr['RequestData']);die;
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

if($req_type == $request_url){
/* Code Will Go Here*/	
	
	$list_id = $arr['RequestData']['list_id'];
	$list_title 	= $arr['RequestData']['list_title'];
	$board_id 	= $arr['RequestData']['board_id'];
	$ckey = $db->generateRandomString();
	$copy_list = array(
		'board_id' 	=> $board_id,
		'list_title' 	=> $list_title,
		'listkey'	=> $ckey
			);
	
	//print_r($label_insert);die;

	$insert = $db->insert("tbl_board_list",$copy_list);
	$last_insertlist = $db->getlast_insertlist($board_id);
	//echo $list_id;die;
	$board_list_data = $db->getListCard($list_id);

/* Copy and Insert all  cards In List */
	foreach($board_list_data['response']['CardList'] as $cards)
	{
	$card_description = $cards['card_description'];
	$list_id 	    = $last_insertlist;
	$card_title 	= $cards['card_title'];
	$stickers 	    = $cards['stickers'];
	$def        	= $cards['def'];
	$del_status 	= $cards['del_status'];
	$date_time   	= $cards['date_time'];
	
	
	$copy_list_cards = array(
		'card_description' 	=> $card_description,
		'list_id' 	        => $last_insertlist,
		'card_title'	    => $card_title,
		'stickers'	        => $stickers,
		'def'	            => $def,
		'del_status'	    => $del_status,
		'date_time'       	=> $date_time
		
			);
$copy_list_cards = $db->insert("tbl_board_list_card",$copy_list_cards);

$lastcardID = $db->getlast_cardId($last_insertlist);
//echo $lastcardID;die;
$cord_comments = $db->getCardComments($cards['card_id']);
$card_attachment = $db->getCardAttachment($cards['card_id']);


/* Copy and Insert all  card Comments */	
	foreach($cord_comments as $cards_comment)
		{
		$cardid = $lastcardID;
		$userid 	    = $cards_comment['userid'];
		$comments 	= $cards_comment['comments'];
		$date_time 	    = $cards_comment['date_time'];
		$status        	= $cards_comment['status'];
		$ckey = $db->generateRandomString();
		
		$copy_list_cardscomment = array(
			'cardid' 	=> $cardid,
			'userid' 	        => $userid,
			'comments'	    => $comments,
			'date_time'	        => $date_time,
			'status'	            => $status,
			'ckey'	            => $ckey
					
				);
				
		$card_comment = $db->insert("tbl_board_list_card_comments",$copy_list_cardscomment);
		}
		
		/* End Copy and Insert all  card Comments */
		
		
	/* Copy and Insert all  card Attachment */	
			foreach($card_attachment as $card_attachment)
		{
		$cardid = $lastcardID;
		$userid 	    = $card_attachment['userid'];
		$attachments 	= $card_attachment['attachments'];
		$datetime 	    = $card_attachment['datetime'];
		$status        	= $card_attachment['status'];
		$cover_image    = $card_attachment['cover_image'];
		$ckey = $db->generateRandomString();
		
		$card_attachment = array(
			'cardid' 	=> $cardid,
			'userid' 	        => $userid,
			'attachments'	    => $attachments,
			'datetime'	        => $datetime,
			'status'	        => $status,
			'cover_image'	    => $cover_image,
			'ckey'	            => $ckey
					
				);
				
		$card_attachment = $db->insert("tbl_board_list_card_attachements",$card_attachment);
		}
	/*  End Copy and Insert all  card Attachment */	
	
	}
/* End Copy and Insert all  cards In List */
if($insert){
	$response = array(
		"successBool" => true,
		"responseType" => "copy_list",
		"successCode" => "200",
			"response" => array(
				'message' => "Copy List successfully"
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "109",
				"ErrorMsg"	=> "Internal Server Error"
			)		
	);
}
	
/* End Of Code */		
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "103",
				"ErrorMsg"	=> "Invalid Request Url"
			)		
	);
}
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

$data = array( "serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );

if($db->insert("error_log",$data)){
	header('content-type: application/json');
	echo $result_response;
}

}