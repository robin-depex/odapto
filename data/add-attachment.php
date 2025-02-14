<?php  
session_start();
require_once("common/config.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();

if($_FILES['image']['name'] != ''){

	$ext = end(explode(".", $_FILES['image']['name']));
	$allowed_type = array("jpg","png","JPG","JPEG");
	if (in_array($ext, $allowed_type)) {
		
		$new_name = rand() . "." .$ext ;
		$path = "attachments/". $new_name; 
		if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){

		$userid = $_REQUEST['userid'];
		$cardid = $_REQUEST['cardid'];
		$ckey = $db->generateRandomString();
		$attachment_insert = array(
			'cardid' 	=> $cardid,
			'userid' 	=> $userid,
			'attachments' => $path,
			'datetime'	=> date("Y-m-d"),
			'ckey'		=> $ckey,
			'status'	=> 1,
			'cover_image' => 1	
		);
		//echo json_encode($attachment_insert); die();
		$table = "tbl_board_list_card_attachements";
		$insert = $db->insert($table,$attachment_insert);
		if($insert){
		
		$update = $db->cover_update($table,$ckey,$cardid);

		$atachment = $db->getLastImage($ckey);
		foreach ($atachment as $key => $value) {
			$path = $value['image'];
		}	
		
		echo $path;
		}
			//tbl_board_list_card_attachements
		}

	}else{
		echo '<script>alert("please select valid file");</script>';		
	}

}else{

	echo '<script>alert("please select file");</script>';
}
?>