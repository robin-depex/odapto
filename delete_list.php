<?php  
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

// Get POST data
$list_id = $_POST['list_id'] ?? null;

if (!$list_id) {
    echo json_encode(["success" => false, "message" => "Missing list ID"]);
    exit;
}

// Delete query
    $condition = array("list_id"=>$list_id);
	
	$delete = $db->delete("tbl_board_list",$condition);
	if($delete){
	    $delete7 = $db->delete("tbl_board_list_card",$condition);
        $delete1 = $db->delete('tbl_board_card_members',$condition);
        $delete2 = $db->delete('tbl_board_list_card_checklist_item',$condition);
        $delete3 = $db->delete('tbl_board_list_card_checklist',$condition);
        $delete4 = $db->delete('tbl_board_list_card_attachements',$condition);
    	$delete5 = $db->delete('tbl_board_list_card_labels',$condition);
    	$delete6 = $db->delete('tbl_board_list_duedate',$condition);
    	echo json_encode(["success" => true]);
	} else {
        echo json_encode(["success" => false, "message" => "Failed to delete"]);
    }

?>