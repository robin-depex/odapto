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
$team_id = $arr['RequestData']['team_id'];
if($team_id==0){
	$teamId = 0;
}else{
	$teamId = $team_id;
}
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
$newres = $db->getBoardDetails($board_id);
$rand1 = $db->generateRandomString();
//$bg_img=$db->getrand_boardimg();

$bg_img='';

$color = array("#f00000","#f52d39","#f56d39","#f5d26a","#b3dbc0","#2d907d","#5893ab","#3f9a69","#CD5C5C","#DC143C","#F08080","#FA8072","#E9967A","#B22222","#8B0000","#FFC0CB","#FF7F50","#FF4500","#FFD700","#FFA500","#FF8C00","#FF6347","#BDB76B");
$random_keys=array_rand($color,3);




$date = date("Y-m-d H:i:s");
$board_data = array("admin_id"=>$uid,"team_id"=>$teamId,"board_title"=>$newres['board_title'],"board_key" => $rand1 ,"type"=>"PB","createDate"=>$date,"bg_img"=>$bg_img,"bg_color"=>$color[$random_keys[0]]);
$bid = $db->insert("tbl_user_board",$board_data);
$rand = $db->generateRandomString();

$board_url = $db->make_url($newres['board_title']);

			$data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_url);
			
			$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_key);
			$data_team = array("meta_key"=>"team_id","meta_value"=>0,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_team);

			$data_privacy = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_privacy);

			$board_team_data = array("team_id"=>$teamId, "board_id"=> $bid);
			$db->insert("tbl_team_board",$board_team_data);

			$invitemembre = array("bid"=>$bid,"burl"=>$board_url,"bkey"=>$rand1,"member_id"=>$uid,"invited_by"=>$uid,"invite_token"=>$_REQUEST['token'],"invite_date"=>date('Y-m-d H:i:s'));
			$db->insert("tbl_board_invite",$invitemembre);

			$bord_member = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$uid,"member_status"=>1);
			$db->insert("tbl_board_members",$bord_member);

			$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_visibility);

			$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$bid);
			$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);




$team_admindata = $db->getsingledata('tbl_users',array('ID'=>$uid));
           $invitemembre = array("bid"=>$bid,"burl"=>$board_url,"bkey"=>$rand1,"member_id"=>$uid,"user_email"=>$team_admindata['Email_ID'],"invited_by"=>$uid,"invite_token"=>$_REQUEST['token'],"invite_date"=>date('Y-m-d H:i:s'));
			$db->insert("tbl_board_invite",$invitemembre);

$bord_member = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$uid,"member_status"=>1,"team_id"=>$teamId);
			$db->insert("tbl_board_members",$bord_member);



if($teamId != 0){
  $result_member = $db->getAllTeamMembers($teamId);
 foreach ($result_member as $value) {
 	if($uid!=$value['member_id']){
 $team_admindata1 = $db->getsingledata('tbl_users',array('ID'=>$value['member_id']));

           $invitemembres = array("bid"=>$bid,"burl"=>$board_url,"bkey"=>$rand1,"member_id"=>$value['member_id'],"user_email"=>$team_admindata1['Email_ID'],"invited_by"=>$uid,"invite_token"=>$_REQUEST['token'],"invite_date"=>date('Y-m-d H:i:s'));
			$db->insert("tbl_board_invite",$invitemembres);

		$bord_members = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$value['member_id'],"member_status"=>1,"team_id"=>$teamId);
			$db->insert("tbl_board_members",$bord_members);
 	}

  }
}

			
	$board_list=$db->getBoardList1($board_id);
if(!empty($board_list)){
foreach ($board_list as $board_list) 
		{
			$list_id=$board_list['list_id'];
			$list_key=$db->generateRandomString();
			 $list_insert=array(
            'board_id'=>$bid,
            'list_title'=>$board_list['list_title'],
            'listkey'=>$list_key,
                  );

      $last_insertlist = $db->insert('tbl_board_list',$list_insert);
	$list_card = $db->getListCard1($list_id);

if(!empty($list_card)){
	      	foreach ($list_card as $list_card1) 
      	{
			$card_insertdata=array(
            'list_id'=>$last_insertlist,
            'board_id'=>$bid,
            'card_description'=>$list_card1['card_description'],
            'card_title'=>$list_card1['card_title'],
            'stickers'=>$list_card1['stickers'],
                  );
 $card_id = $db->insert('tbl_board_list_card',$card_insertdata);
$card_attachment=$db->allCardAttachments($list_card1['card_id']);

if(!empty($card_attachment)){
 	foreach($card_attachment as $cardattch){
 		$cardattch11 = array(
'cardid' => $card_id,
'list_id'=>$last_insertlist,
'board_id'=>$bid,
'userid' => $uid,
'attachments' => $cardattch['images'],
'title_name' => $cardattch['title_name'],
'cover_image' => $cardattch['cover'],
'location' => $cardattch['location'],
'file_type' => $cardattch['file_type'],
'file_extenstion' => $cardattch['ext'],
'note_guide' => $cardattch['note_guide'],
'note_book_guide' => $cardattch['note_book_guide'],
'is_linked' => $cardattch['is_linked'],
'status' =>1,
 			);

 		$db->insert('tbl_board_list_card_attachements',$cardattch11);
 	}
 }


	$card_checklist=$db->getCardCheckList($list_card1['card_id']);
 	if(!empty($card_checklist)){
 	foreach($card_checklist as $carcheck){
 		$carchecklist= array(
'cardid' => $card_id,
'list_id'=>$last_insertlist,
'board_id'=>$bid,
'userid' => $uid,
'checklist' => $carcheck['comments'],
'date_time' => date('Y-m-d H:i:s'),
'status' => 1,
'refrenceid' => 0,
 			);
 	$checklist_id = $db->insert('tbl_board_list_card_checklist',$carchecklist);
 	$card_checklistitem=$db->getLastChecklistItemData($carcheck['id']);
 	foreach($card_checklistitem as $carchecki){
$carchecklistitem= array(
'checklist_id' => $checklist_id,
'item_name' => $carchecki['item_name'],
'status' => 0,
'list_id'=>$last_insertlist,
'board_id'=>$bid,
 			);
 $db->insert('tbl_board_list_card_checklist_item',$carchecklistitem);
 	}

 	}
 }


	$card_comment=$db->getCardComments($list_card1['card_id']);
	if(!empty($card_comment)){
	 	foreach($card_comment as $ccomment){
	 
$cardcomment= array(
'cardid' => $card_id,
'list_id'=>$last_insertlist,
'board_id'=>$bid,
'userid' => $uid,
'comments' => $ccomment['comments'],
'date_time' => date('Y-m-d H:i:s'),
'status' => 1,
 			);
 $db->insert('tbl_board_list_card_comments',$cardcomment);
	 	}
	 	}

$card_label=$db->getAllCardLabels($list_card1['card_id']);
	if(!empty($card_label)){
	 	foreach($card_label as $clabel){
 $cardlbl = array(
'cardid' => $card_id,
'list_id'=>$last_insertlist,
'board_id'=>$bid,
'userid' => $uid,
'labels' => $clabel['labels'],
'datetime' => date('Y-m-d H:i:s'),
'status' => 1,
                	);
	 

 $db->insert('tbl_board_list_card_labels',$cardlbl);
	 	}
	 	}



	$card_duedate=$db->getbordlistduedate2($list_card1['card_id']);
	//print_r($card_duedate);
	if(!empty($card_duedate)){
 $carddued = array(
'card_id' => $card_id,
'list_id'=>$last_insertlist,
'board_id'=>$bid,
'userid' => $uid,
'duedate' => $card_duedate['duedate'],
'duetime' => $card_duedate['duetime'],
'complete_status' => 0,
);
	 
$db->insert('tbl_board_list_duedate',$carddued);

}


	}

      }
    	
		
	}

}

	$response = array(
		"successBool" => true,
		"responseType" => "copy_board",
		"successCode" => "200",
			"response" => array(
				'message' => "Copy Board successfully"
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

$data = array( "serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a") );
$db->insert("error_log",$data);

/*if($db->insert("error_log",$data)){

}*/

	header('content-type: application/json');
	echo $result_response;

