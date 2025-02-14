<?php  
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();

if(isset($_POST['action'])){
	
	$action  = $_POST['action'];
	if($action == 'make_cover'){
		$cardid = $_POST['card_id'];
	
	$att_id  = $_POST['att_id'];
		$update_data = array(
			'cover_image' => 0
		);
		$update_cond = array(
			'cardid' => $cardid	
		);
		$table = 'tbl_board_list_card_attachements';
		$update = $db->update($table,$update_data,$update_cond);
		if($update){
			$cov_update_data = array(
				'cover_image' => 1
			);
			$cover_update_cond = array(
				'id' => $att_id	
			);
			$table = 'tbl_board_list_card_attachements';
			$update = $db->update($table,$cov_update_data,$cover_update_cond);

			$cover = $db->getCoverImage($cardid);

			foreach ($cover as $key => $value) {
				$background="#";
				$path = $value['cover'];
				$background.= $value['background'];
			}

			if($background=='#')
{
	$class='div-border';
}	
			
			echo '
			<div class="imagePreviewDb <?php echo $class;?>" style="background-color:'.$background.'">
				<img src="attachments/'.$path.'" class="img-responsive">
			';

		}
	}else if($action == 'remove_cover'){
		$cardid = $_POST['card_id'];
	
	$att_id  = $_POST['att_id'];
		$update_data = array(
			'cover_image' => 0
		);
		$update_cond = array(
			'id' => $att_id	
		);
		$table = 'tbl_board_list_card_attachements';
		$update = $db->update($table,$update_data,$update_cond);
		if($update){
			echo "Done";
		}
	}else if($action == 'remove_attachment'){
		//$cardid = $_POST['card_id'];
	
	$att_id  = $_POST['att_id'];
		
		$update_cond = array(
			'id' => $att_id	
		);
		$table = 'tbl_board_list_card_attachements';
		$update = $db->delete($table,$update_cond);
		
	}
}

?>