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
		$board_details = explode("_", $_REQUEST['copyDetails']);
		$board_id = $board_details[1];
$newres = $db->getBoardDetails($board_id);
$rand1 = $db->generateRandomString();
$bg_img=$db->getrand_boardimg();
$uid = $_SESSION['sess_login_id'];
		$date = date("Y-m-d H:i:s");

$board_data = array("admin_id"=>$uid,"team_id"=>0,"board_title"=>$newres['board_title'],"board_key" => $rand1 ,"type"=>"PB","createDate"=>$date,"bg_img"=>$bg_img);
$insert = $db->insert("tbl_user_board",$board_data);
		$bid = $db->getLastInsertedBoard($uid);
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

			$board_team_data = array("team_id"=>0, "board_id"=> $bid);
			$db->insert("tbl_team_board",$board_team_data);

			$invitemembre = array("bid"=>$bid,"burl"=>$board_url,"bkey"=>$rand1,"member_id"=>$uid,"invited_by"=>$uid,"invite_token"=>$_REQUEST['token'],"invite_date"=>date('Y-m-d H:i:s'));
			$db->insert("tbl_board_invite",$invitemembre);

			$bord_member = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$uid,"member_status"=>1);
			$db->insert("tbl_board_members",$bord_member);

			$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_visibility);

			$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$bid);
			$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);

/*List insert code start*/
		$board_list=$db->getBoardList($board_id);
		foreach ($board_list as $board_list) 
		{
			$list_id=$board_list['list_id'];
			$list_key=$db->generateRandomString();
			 $list_insert=array(
            'board_id'=>$bid,
            'list_title'=>$board_list['list_title'],
            'listkey'=>$list_key,
                  );

        $db->insert('tbl_board_list',$list_insert);
      $last_insertlist = $db->getlast_insertlist($bid);

      	$list_card=$db->getListCard1($list_id);
//print_r($list_card);
      	if(!empty($list_card)){
      	foreach ($list_card as $list_card1) 
      	{
      		//print_r($list_card1);
      		$card_insertdata=array(
            'list_id'=>$last_insertlist,
            'card_description'=>$list_card1['card_description'],
            'card_title'=>$list_card1['card_title'],
            'stickers'=>$list_card1['stickers'],
            //'stickers'=>$list_card['stickers'],
                  );

         //print_r($card_insertdata);die;

      $card_id = $db->insert('tbl_board_list_card',$card_insertdata);

      /*Card Attachment Start*/
    //  echo $list_card1['card_id'];
 	$card_attachment=$db->allCardAttachments($list_card1['card_id']);
 	if(!empty($card_attachment)){
 	foreach($card_attachment as $cardattch){
 		$cardattch11 = array(
'cardid' => $card_id,
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
/*Card Attachment End*/




      /*Card Checklist Start*/
 	$card_checklist=$db->getCardCheckList($list_card1['card_id']);
 	if(!empty($card_checklist)){
 	foreach($card_checklist as $carcheck){
 		$carchecklist= array(
'cardid' => $card_id,
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
 			);
 $db->insert('tbl_board_list_card_checklist_item',$carchecklistitem);
 	}

 	}
 }
/*Card Checklist End*/

/*Card Comment Start*/
	$card_comment=$db->getCardComments($list_card1['card_id']);
	if(!empty($card_comment)){
	 	foreach($card_comment as $ccomment){
	 
$cardcomment= array(
'cardid' => $card_id,
'userid' => $uid,
'comments' => $ccomment['comments'],
'date_time' => date('Y-m-d H:i:s'),
'status' => 1,
 			);
 $db->insert('tbl_board_list_card_comments',$cardcomment);
	 	}
	 	}

/*Card Comment End*/

/*Card label Start*/
	$card_label=$db->getAllCardLabels($list_card1['card_id']);
	if(!empty($card_label)){
	 	foreach($card_label as $clabel){
 $cardlbl = array(
'cardid' => $card_id,
'userid' => $uid,
'labels' => $clabel['labels'],
'datetime' => date('Y-m-d H:i:s'),
'status' => 1,
                	);
	 

 $db->insert('tbl_board_list_card_labels',$cardlbl);
	 	}
	 	}

/*Card label End*/

/*Card duedate Start*/
	$card_duedate=$db->getbordlistduedate($list_card1['card_id']);
	if(!empty($card_duedate)){
 $carddued = array(
'card_id' => $card_id,
'userid' => $uid,
'duedate' => $card_duedate['duedate'],
'duetime' => $card_duedate['duetime'],
'complete_status' => 0,
                	);
	 

 $db->insert('tbl_board_list_duedate',$carddued);

}
/*Card duedate End*/
	}
		
	}	
		
	}

/*List insert code end*/
$response = json_encode(array("result"=>"TRUE"));
echo $response;
			exit();

	
		
	}
}
?>