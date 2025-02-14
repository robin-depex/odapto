<?php
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();
if($_POST['profile']==="profile"){
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

if($_POST['addmenber']==="addmenber"){
	$dataset = array();
	$mamb = $db->BoardCardMembers($_POST['menberId']);
	if(!empty($mamb)){
		$dataset['Menber'] =$_POST['menberId'];
		$response=$db->delete('tbl_board_card_members',$dataset);
		return $response;
	}
	
	if(empty($dataset)){
		$dataset['card_id'] =$_POST['cardId'];
		$dataset['user_id'] =$_POST['userId'];
		$dataset['board_id'] =$_POST['board_id'];
		$dataset['Menber'] =$_POST['menberId'];
		$response=$db->insert('tbl_board_card_members',$dataset);
		return $response;
	}
	


}

