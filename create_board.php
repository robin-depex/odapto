<?php 
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();

if(isset($_REQUEST['token'])){
	
	if($_REQUEST['token'] == $_SESSION['Tocken']){
echo $_REQUEST['boardTitle'];die;
		$board_title = $_REQUEST['boardTitle'];
		$teamId = $_REQUEST['teamId'];
		$board_privacy = $_REQUEST['board_privacy'];

		//$bg_img=$db->getrand_boardimg();
		$bg_img='';
  $getbackcolor = $db->get_data('tbl_background_color',array('status'=>1));

  foreach ($getbackcolor as $value) {
$color[] = $value['color'];
  }

$random_keys=array_rand($color,7);


$rand1 = $db->generateRandomString();
		$uid = $_SESSION['sess_login_id'];
		//date_default_timezone_set("Asia/Kolkata");
		$date = date("Y-m-d H:i:s");
		if($teamId == 0){
			$board_data = array("admin_id"=>$uid,"team_id"=>$teamId,"board_title"=>$board_title,"board_key" => $rand1 ,"type"=>"PB","createDate"=>$date,"bg_img"=>$bg_img,"bg_color"=>$color[$random_keys[0]],"board_privacy"=>$board_privacy);
			
		}else{
			$board_data = array("admin_id"=>$uid,"team_id"=>$teamId,"board_title"=>$board_title,"board_key" => $rand1 ,"type"=>"TB","createDate"=>$date,"bg_img"=>$bg_img,"bg_color"=>$color[$random_keys[0]],"board_privacy"=>$board_privacy);
		}

		$insert = $db->insert("tbl_user_board",$board_data);
		$bid = $db->getLastInsertedBoard($uid);
		
		if($insert){

			$rand = $db->generateRandomString();
			$board_url = $db->make_url($board_title);

			$data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_url);
			
			$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_key);
			
			$data_team = array("meta_key"=>"team_id","meta_value"=>$teamId,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_team);


		$data_privacy = array("meta_key"=>"board_visibility","meta_value"=>$board_privacy,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_privacy);


			$board_team_data = array("team_id"=>$teamId, "board_id"=> $bid);
			$db->insert("tbl_team_board",$board_team_data);

			if(!empty($teamId)){
				$updateboard = array("type"=>'TB');
				$cond = array("board_id"=> $bid,"admin_id" => $uid);
				$db->update("tbl_user_board",$updateboard,$cond);
			}

 $team_admindata = $db->get_single_data('tbl_users',array('ID'=>$uid));
           $invitemembre = array("bid"=>$bid,"burl"=>$board_url,"bkey"=>$rand1,"member_id"=>$uid,"user_email"=>$team_admindata['Email_ID'],"invited_by"=>$uid,"invite_token"=>$_REQUEST['token'],"invite_date"=>date('Y-m-d H:i:s'));
			$db->insert("tbl_board_invite",$invitemembre);

			$bord_member = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$uid,"member_status"=>1,"team_id"=>$teamId);
			$db->insert("tbl_board_members",$bord_member);


if($teamId != 0){
  $result_member = $db->getAllTeamMembers($teamId);
 foreach ($result_member as $value) {
 	if($uid!=$value['member_id']){
 $team_admindata1 = $db->get_single_data('tbl_users',array('ID'=>$value['member_id']));

           $invitemembres = array("bid"=>$bid,"burl"=>$board_url,"bkey"=>$rand1,"member_id"=>$value['member_id'],"user_email"=>$team_admindata1['Email_ID'],"invited_by"=>$uid,"invite_token"=>$_REQUEST['token'],"invite_date"=>date('Y-m-d H:i:s'));
			$db->insert("tbl_board_invite",$invitemembres);

		$bord_members = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$value['member_id'],"member_status"=>1,"team_id"=>$teamId);
			$db->insert("tbl_board_members",$bord_members);
 	}

  }
}



			$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
			$db->insert("tbl_user_boardmeta",$data_visibility);

			$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$bid);
			$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);

			if($last_insert){
				
			$url = "dashboard.php?page=board&b=$bid&t=$board_url&k=$rand";
			$response = array("result"=>"TRUE","message"=>$url);

			}else{
				$response = array("result"=>"FALSE","message"=>"Error Found");
			}
		}else{
			$response = array("result"=>"FALSE","message"=>"Error Found");
		}

		echo json_encode($response);
		
	}
}
if(isset($_POST['board_type']) && $_POST['board_type']=="template"){
	$uid = $_SESSION['sess_login_id'];
	date_default_timezone_set("Asia/Kolkata");
	$date = date("Y-m-d H:i:s");
	$id=$_POST['id'];
	$c_ids=$_POST['card_ids'];
	$board_ids = explode(',', $c_ids);

	//$insert=$db->my_insert($id,$uid,$date);
$inserttemp = $db->insert('tbl_user_template',array('userid'=>$uid,'template_id'=>$id));
    	//$temp_boards=$db->get_temp_boards($id);
    	//print_r($temp_boards);die;
    foreach ($board_ids as $card_ids) {
        $temp_boards=$db->get_temp_boardsbyId($card_ids,$id);
    	foreach ($temp_boards as $temp_boards) {
    
    		$board_key=$db->generateRandomString();
    		//$boards=$db->my_insert($temp_boards['id'],$uid,$date);
    		  $temp_bid=$temp_boards['id'];
    		  $board_insert=array(
                'admin_id'=>$uid,
                'board_title'=>$temp_boards['board_name'],
                'board_key'=>$board_key,
                'board_url'=>$temp_boards['board_url'],
                'bg_color'=>$temp_boards['board_bgcolor'],
                'board_fontcolor'=>$temp_boards['board_fontcolor'],
                'type'=>'PB',
                'admin_board_id'=>$id,
                'bg_img'=>$db->site_url.'admin/temp/images/'.$temp_boards['bg_img'],
    
                );
            $boards=$db->insert('tbl_user_board',$board_insert);
    
    		$bid = $db->getLastInsertedBoard($uid);
    	
    $inv_token = md5($date."boardaddmembers");
    $count = $db->ChkInviteToken($inv_token);
    if($count > 0){
    	$salt = "odaptonew";
    	$invtoken = md5($date.$salt);
    }else{
    	$invtoken = $inv_token;
    }
    //$fldnm=array('ID'=>$uid);
    $getuseredata = $db->getsingledata('tbl_users','ID',$uid);
    $data_inv1 = array(	
    		"member_id"=>$uid,
    		"user_email"=>$getuseredata['Email_ID'],
    		"bid"=>$bid,
    		"burl"=>$temp_boards['board_url'],
    		"bkey"=>$board_key,
    		"invited_by"=>$uid,
    		"invite_token"=>$invtoken,
    		"invite_date"=> $date
    	);
    $dbinsert1 = $db->insert("tbl_board_invite",$data_inv1);
    $board_members_data1 = array("user_id"=>$uid,"board_id"=>$bid,"member_id"=>$uid,"member_status"=>1,"team_id"=>$id);
    	$insert1 = $db->insert("tbl_board_members",$board_members_data1);
    
    
    
    		$board_list=$db->get_admin_BoardList($temp_bid);
    		foreach ($board_list as $board_list) 
    		{
    			$list_id=$board_list['id'];
    			$list_key=$db->generateRandomString();
    			  $list_insert=array(
                'board_id'=>$bid,
                'list_title'=>$board_list['list_title'],
                'listkey'=>$list_key,
                'list_color'=>$board_list['bgcolor'],
                'list_icon'=>$board_list['bgimage'],
                      );
    
            $db->insert('tbl_board_list',$list_insert);
          $last_insertlist = $db->getlast_insertlist($bid);
    
          	$list_card=$db->get_admin_Boardcards($list_id);
    
          	foreach ($list_card as $list_card) 
          	{
          		$card_insertdata=array(
                'list_id'=>$last_insertlist,
                 'board_id'=>$bid,
                'card_description'=>$list_card['card_description'],
                'card_title'=>$list_card['card_name'],
                //'stickers'=>$list_card['stickers'],
                      );
    
             //print_r($card_insertdata);die;
    
            $db->insert('tbl_board_list_card',$card_insertdata);
    
          	}
    		
    		
    		if($boards==true){
    
    			$rand = $db->generateRandomString();
    			$board_url = $db->make_url($board_title);
    
    			$data_url = array("meta_key"=>"board_url","meta_value"=>$board_url,"board_id"=>$bid);
    			$db->insert("tbl_user_boardmeta",$data_url);
    			
    			$data_key = array("meta_key"=>"board_key","meta_value"=>$rand,"board_id"=>$bid);
    			$db->insert("tbl_user_boardmeta",$data_key);
    			
    			$data_team = array("meta_key"=>"team_id","meta_value"=>$teamId,"board_id"=>$bid);
    			$db->insert("tbl_user_boardmeta",$data_team);
    
    
    			$data_privacy = array("meta_key"=>"board_visibility","meta_value"=>$board_privacy,"board_id"=>$bid);
    			$db->insert("tbl_user_boardmeta",$data_privacy);
    
    
    			$board_team_data = array("team_id"=>$teamId, "board_id"=> $bid);
    			$db->insert("tbl_team_board",$board_team_data);
    
    			if(!empty($teamId)){
    				$updateboard = array("type"=>'TB');
    				$cond = array("board_id"=> $bid,"admin_id" => $uid);
    				$db->update("tbl_user_board",$updateboard,$cond);
    			}
    
    
    			$data_visibility = array("meta_key"=>"board_visibility","meta_value"=>0,"board_id"=>$bid);
    			$db->insert("tbl_user_boardmeta",$data_visibility);
    
    			$data_btype = array("meta_key"=>"BoardType","meta_value"=>0,"board_id"=>$bid);
    			$last_insert = $db->insert("tbl_user_boardmeta",$data_btype);
    
    			if($last_insert){
    				
    			$url = "dashboard.php?page=board&b=$bid&t=$board_url&k=$rand";
    			$response = array("result"=>"TRUE","message"=>$url);
    
    			}else{
    				$response = array("result"=>"FALSE","message"=>"Error Found");
    			}
    		}else{
    			$response = array("result"=>"FALSE","message"=>"Error Found");
    		}
    	}
    
    	}
    }


	
	echo json_encode($response);
	

}

?>