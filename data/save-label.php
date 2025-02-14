<?php  
ob_start();
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();
if(isset($_POST['action'])){
	if($_POST['action'] == "saveLabel"){

		$uid = $_SESSION['sess_login_id'];
		$id = $_POST['id'];
		$label = $_POST['label'];
		
		if($db->checkLabelText($uid, $id) > 0){
			$update_label = array(
				'label_name' => $label
			);
			$cond = array(
				'user_id' => $uid,
				'label_id'=> $id
			);
			$update = $db->update('tbl_label_users', $update_label, $cond);		
			if($update){
				echo "Done";
			}else{
				echo "Error";
			}
		}else{

			$update_label = array(
				'label_name' => $label,
				'user_id' => $uid,
				'label_id'=> $id
			);
			
			$update = $db->insert('tbl_label_users', $update_label);		
			if($update){
				echo "Done";
			}else{
				echo "Error";
			}
		}
		
		

	}
} 
?>