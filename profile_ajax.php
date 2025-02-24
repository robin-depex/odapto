<?php
ob_start();
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();

$senderid = $_SESSION['sess_login_id'];
$name=$db->getName($senderid);

if(isset($_POST['profile']) && $_POST['profile']==="profile"){
	$dataset = array();
	if(empty($dataset)){
		$dataset['Full_Name'] =$_POST['name'];
		$dataset['Username'] =$_POST['Initials'];
		$dataset['Initials'] =$_POST['Username'];
		$dataset['boi'] =$_POST['comment'];
	}
	$user_id = array();
	if(empty($user_id)){
		$user_id['ID']=$_POST['user_id'];
	}
	
	$response=$db->update('tbl_users', $dataset, $user_id);
	
}




if(isset($_POST['addmenber']) && $_POST['addmenber']==="addmenber"){
   
	$dataset = array();
	$mamb = $db->BoardCardMemberscount($_POST['menberId'],$_POST['cardId']);
// 	print_r($mamb);die;
	if($mamb>0){
		$dataset['Menber'] =$_POST['menberId'];
		$response=$db->delete('tbl_board_card_members',$dataset);
		$result = 0;
		echo $result;
	}else{
	    //to push send notification
	    $board_id=$_POST['board_id'];
		$listId = $_POST['listId'];
		$cardId = $_POST['cardId'];
	    $dd=$db->getBoardKeyValue($board_id);
            $key = explode(",", $dd['mvalue']);
           $t= $key[0];
            $k= $key[1];
            $url="https://www.odapto.com/dashboard.php?page=board&b=".$board_id."&t=".$t."&k=".$k;
            
	    $member = $db->getBoardmembers($_POST['board_id']);
                    $countmember = count(explode(',',$member));
                    //echo $countmember;
                    if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
    
						$usr_id=$result1['ID'];
						if($senderid != $usr_id)
						{
						    $notify_data=array(
                            'notif_title' => 'New Member added',
                            'notif_msg' => $name.' added a  new Member',
                            'notif_time' => date('Y-m-d H:i:s'),
                            'notif_repeat' => 1,
                            'notif_loop' => 1,
                            'notif_user_from' =>$senderid,
                            'notif_user_to' => $usr_id,
                            'notif_url' => $url,
                            'notif_for' => 'web',
                            'status' => 1
                        );
                    $insertNotification = $db->insert("tbl_push_notification",$notify_data);

					$card_notify_data=array(
						'title' =>  'New Member added',
						'message' =>  $name.' added a  new Member',
						'notify_date_time' => date('Y-m-d H:i:s'),
						'user_from' =>$senderid,
						'user_to' => $usr_id,
						'list_id' => $listId,
						'card_id' => $_POST['cardId'],
						'notif_for' => 'web'
					);
		 
			 $insertCardNotification = $db->insert("tbl_card_notification",$card_notify_data);
						    
						}
					}
					
					}
	    //end notification
	    
	    
	    
		$dataset['card_id'] =$_POST['cardId'];
		$dataset['user_id'] =$_POST['userId'];
		$dataset['board_id'] =$_POST['board_id'];
		$dataset['Menber'] =$_POST['menberId'];
		$response=$db->insert('tbl_board_card_members',$dataset);
		$result = 1;
		echo $result;
	}
	



}





if(isset($_POST['addlabel']) && $_POST['addlabel']==="addlabel"){
	$dataset = array();
	$labcount = $db->BoardCardlabelcount($_POST['cardId'],$_POST['userId'],$_POST['labelId']);
//echo $labcount;
if($labcount>0){
	//echo $labcount;
		$dataset['cardid'] = $_POST['cardId'];
		$dataset['userid'] = $_POST['userId'];
		$dataset['labels'] = $_POST['labelId'];
		$response=$db->delete('tbl_board_list_card_labels',$dataset);
		$result = 0;
		echo $result;
}

if($labcount<=0){
	//echo 'hi';
$dataset['cardid'] = $_POST['cardId'];
		$dataset['userid'] = $_POST['userId'];
		$dataset['labels'] = $_POST['labelId'];
			$dataset['status'] = 1;
		$response=$db->insert('tbl_board_list_card_labels',$dataset);
		$result = 1;
		echo $result;
}
	/*if($labcount>0){
		echo $labcount;
		$dataset['cardid'] = $_POST['cardId'];
		$dataset['userid'] = $_POST['userId'];
		$dataset['labels'] = $_POST['labelId'];
		$response=$db->delete('tbl_board_list_card_labels',$dataset);
		$result = 0;
		echo $result;
	}else{

	$dataset['cardid'] = $_POST['cardId'];
		$dataset['userid'] = $_POST['userId'];
		$dataset['labels'] = $_POST['labelId'];
			$dataset['status'] = 1;
		$response=$db->insert('tbl_board_list_card_labels',$dataset);
		$result = 1;
		echo $result;
	}*/
	}

	if(isset($_POST['addduedate']) && $_POST['addduedate']==="addduedate"){
	$dataset = array();
	$duedatecount = $db->getbordlistduedate($_POST['cardid']);
//echo $labcount;
	$duedate = date('Y-m-d',strtotime($_POST['duedate']));
	$duetime = $_POST['duetime'];
	$cardid = $_POST['cardid'];
	$listid= $_POST['listid']; 
	$userid = $_POST['userid'];
	$boardid = $_POST['boardid'];
if(count($duedatecount ?? [])>0){
	//echo $labcount;
	    //to push send notification
	    $dd=$db->getBoardKeyValue($boardid);
            $key = explode(",", $dd['mvalue']);
           $t= $key[0];
            $k= $key[1];
            $url="https://www.odapto.com/dashboard.php?page=board&b=".$boardid."&t=".$t."&k=".$k;
	    
	    $member = $db->getBoardmembers($boardid);
                    $countmember = count(explode(",",$member));
                    //echo $countmember;
                    if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
    
						$usr_id=$result1['ID'];
						if($senderid != $usr_id)
						{
						    $notify_data=array(
                            'notif_title' => 'New due added',
                            'notif_msg' => $name.' added a  new Due date',
                            'notif_time' => date('Y-m-d H:i:s'),
                            'notif_repeat' => 1,
                            'notif_loop' => 1,
                            'notif_user_from' =>$senderid,
                            'notif_user_to' => $usr_id,
                            'notif_url' => $url,
                            'notif_for' => 'web',
                            'status' => 1
                        );
                    $insertNotification = $db->insert("tbl_push_notification",$notify_data);

					$card_notify_data=array(
						'title' =>  'New due added',
						'message' =>  $name.' added a  new Due date',
						'notify_date_time' => date('Y-m-d H:i:s'),
						'user_from' =>$senderid,
						'user_to' => $usr_id,
						'list_id' => $listid,
						'card_id' => $cardid,
						'notif_for' => 'web'
					);
		 
			 $insertCardNotification = $db->insert("tbl_card_notification",$card_notify_data);
						    
						}
					}
					
					}
	    //end notification
	
	
		$dataset['card_id'] = $cardid;
		$dataset1['complete_status'] = $duedatecount['complete_status'];
		$response=$db->delete('tbl_board_list_duedate',$dataset);
		$dataset1['duedate'] = $duedate;
		$dataset1['duetime'] = $duetime;
		$dataset1['card_id'] = $cardid;
		$dataset1['userid'] = $userid;
		$dataset['board_id'] = $boardid;
		$response=$db->insert('tbl_board_list_duedate',$dataset1);
		if($dataset1['complete_status']==0){
			$result=0;
		}else{
			$result=2;
		}
	
		echo $result;
}

if(count($duedatecount ?? [])<=0){
	//echo 'hi';
	 //to push send notification
	 $dd=$db->getBoardKeyValue($boardid);
            $key = explode(",", $dd['mvalue']);
           $t= $key[0];
            $k= $key[1];
            $url="https://www.odapto.com/dashboard.php?page=board&b=".$boardid."&t=".$t."&k=".$k;
	 
	 
	    $member = $db->getBoardmembers($boardid);
                    $countmember = count(explode(",",$member));
                    //echo $countmember;
                    if($countmember>0){
					$array = explode(",",$member);
					
					foreach ($array as $value) {
						$result = $db->getUserMeta($value);
						$result1 = $db->getsingledata('tbl_users','ID',$value);
    
						$usr_id=$result1['ID'];
						if($senderid != $usr_id)
						{
						    $notify_data=array(
                            'notif_title' => 'New due added',
                            'notif_msg' => $name.' added a  new Due date',
                            'notif_time' => date('Y-m-d H:i:s'),
                            'notif_repeat' => 1,
                            'notif_loop' => 1,
                            'notif_user_from' =>$senderid,
                            'notif_user_to' => $usr_id,
                            'notif_url' => $url,
                            'notif_for' => 'web',
                            'status' => 1
                        );
                    $insertNotification = $db->insert("tbl_push_notification",$notify_data);
						    
						}
					}
					
					}
	    //end notification
$dataset['duedate'] = $duedate;
		$dataset['duetime'] = $duetime;
		$dataset['card_id'] = $cardid;
		$dataset['userid'] = $userid;
		$dataset['board_id'] = $boardid;
		$response=$db->insert('tbl_board_list_duedate',$dataset);
		$result = 1;
		echo $result;
}
	
	}

		if(isset($_POST['updatecompletestats']) && $_POST['updatecompletestats']==="updatecompletestats"){
	$dataset = array();
	$datasset1 = array();
	$duedatecount = $db->getbordlistduedate($_POST['cartId']);
	//print_r($duedatecount);
	$cardid = $_POST['cartId'];

	$datasset1['card_id'] = $_POST['cartId'];
if($duedatecount['complete_status']==1){
		$dataset['complete_status']=0;
		$response=$db->update('tbl_board_list_duedate',$dataset,$datasset1);
		$result = 0;
		echo $result;
}

if($duedatecount['complete_status']==0){
$dataset['complete_status']=1;
		$response=$db->update('tbl_board_list_duedate',$dataset,$datasset1);
		$result = 1;
		echo $result;
}
}



		if(isset($_POST['addtype']) &&  $_POST['addtype']==="drivestatus"){
			
	$dataset = array();
	$datasset1 = array();

$type = $_POST['type'];
$fname = $_POST['fname'];
$dataset = array(
$type => $_POST['status'],
	);
$datasset1 = array(
$fname => $_POST['fval'],
	);

$response=$db->update('tbl_users',$dataset,$datasset1);


}
	
	

