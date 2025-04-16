<?php  
date_default_timezone_set("Asia/Kolkata");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

// Get POST data
$board_id = $_POST['board_id'] ?? null;

if (!$board_id) {
    echo json_encode(["success" => false, "message" => "Missing board ID"]);
    exit;
}

// Optional: sanitize input
$board_id = intval($board_id);

// Delete query
$condition = array("board_id"=>$board_id);
	$update_data = array("status"=>0); 
	$update = $db->update("tbl_user_board",$update_data, $condition);

if ($update) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete"]);
}

?>