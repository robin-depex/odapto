<?php

die;

	$image = $_POST['bg_img'];
	
	$image = 'https://www.odapto.com/admin/temp/images/'.$image;
	$bid = $_POST['bid'];
    $bid = $_POST['uid'];
    move_uploaded_file($image, '../board_img/' .$img_name);die;
	$data_color = array("bg_color"=>"","bg_img"=>$image,'bg_type'=>'img');
	$cond = array("board_id"=>$uid);
	$update = $db->update("tbl_user_board",$data_color,$cond);
	if($update){
		$result =array("result"=> "TRUE","message"=>"changed Successfully");
	}else{
		$result =array("result"=> "FALSE","message"=>"Error Found");
	}

	$response = json_encode($result);
	echo $response;
?>