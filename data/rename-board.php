<?php
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if(isset($_REQUEST['data'])){
$admin_id = $_SESSION['sess_login_id'];

$data = explode("&",$_REQUEST['data']);

$d_data1 = explode("=",$data[0]);
$d_data2 = explode("=",$data[1]);

$board_id = $d_data1[1];

$board_title = str_replace("%20"," ",$d_data2[1]);

if(!empty($board_title)){

  $update_data = array('board_title' => $board_title );
  $condition = array('admin_id' => $admin_id,"board_id"=>$board_id );
  $update = $db->update("tbl_user_board",$update_data,$condition);

  if($update){

    $board_url = $db->make_url($board_title);
    $data_url = array("meta_value"=>$board_url);
    $conditionmeta = array("meta_key"=>"board_url","board_id"=>$board_id);
    $updatemeta = $db->update("tbl_user_boardmeta",$data_url,$conditionmeta);

    if($updatemeta){

      echo $board_title;

    }else{

      echo "FALSE";

    }

  }
}else{
  $response = array("result"=>"FALSE","msg"=>"111");
}
}
?>
