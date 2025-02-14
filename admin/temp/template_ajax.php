<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');

if($_REQUEST['action'] == "temp_add_board"){

	$data = array(
		'cat_id' =>  $db->clean_input($_REQUEST['category']),
		'board_name' => $db->clean_input($_REQUEST['board_name']),
		//'board_url' => $db->clean_input($_REQUEST['board_url']),
		//'board_key' => $db->clean_input($_REQUEST['board_key']),
		//'board_bgcolor' => $_REQUEST['board_bgcolor'],
		'board_bgimage' => $_REQUEST['image'],
		//'board_fontcolor' => $db->clean_input($_REQUEST['description']),
		'status'=>'1');

	
	//$channelodata=$db->AlldataUser();
	//$db->pushNotification($channelodata,$db->clean_input($_REQUEST['board_name']));
	$insertDataUserTable = $db->insert("tbl_tmp_board",$data);

		
}

/* Delete Template */
if($_REQUEST['action'] == "deleteboard_cards"){
	
	$id = $_REQUEST['id'];
	
	$where = array('id' => $id);
	
	$update = $db->delete("tbl_tmp_board_list_card",$where);
	if($update){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error Found'
		);
	}
	echo json_encode($results);
}

/* Delete Template */
if($_REQUEST['action'] == "deleteTemp_blist"){
	$id = $_REQUEST['id'];
	$where = array(
		'id' => $id
	);
	
	$update = $db->delete("tbl_tmp_board_list",$where);
	$update = $db->delete("tbl_tmp_board_list_card",array('list_id'=>$id));
	if($update){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error Found'
		);
	}
	echo json_encode($results);
}
/* Delete Template */
if($_REQUEST['action'] == "deleteTemp"){
	$id = $_REQUEST['id'];
	$where = array(
		'id' => $id
	);
	$get_img_link = $db->get_img_link("tbl_templates",$id);
    $img_url=$get_img_link["image"];
	$update = $db->delete("tbl_templates",$where);
	$update = $db->delete("tbl_tmp_board",array('cat_id'=>$id));
	$update = $db->delete("tbl_tmp_board_list",array('cat_id'=>$id));
	$update = $db->delete("tbl_tmp_board_list_card",array('cat_id'=>$id));
	if($update){
	   $abc=$_SERVER['DOCUMENT_ROOT']."/admin/temp/images/".$img_url;
        unlink($abc);
	    
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error !! Please try again'
		);
	}
	echo json_encode($results);
}

/* Delete Template */
if($_REQUEST['action'] == "deleteTempCat"){
	$id = $_REQUEST['id'];
	$where = array(
		'id' => $id
	);
	
	$update = $db->delete("tbl_tmp_category",$where);
	if($update){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error Found'
		);
	}
	echo json_encode($results);
}
/* Delete Template */
if($_REQUEST['action'] == "deleteSubsEmail"){
	$id = $_REQUEST['id'];
	$where = array(
		'id' => $id
	);
	$update = $db->delete("tbl_users_subscriptions",$where);
	if($update){
	  
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error !! Please try again'
		);
	}
	echo json_encode($results);
}

//temp_add_cat
if($_REQUEST['action'] == "temp_add_cat"){

	$data = array(
		'cat_name' =>  $_REQUEST['cat_name'],
		'status' => 1
	);
	
	$insertDataUserTable = $db->insert("tbl_tmp_category",$data);

	if($insertDataUserTable == true){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Created Successfully.'
		);		
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Something went wrong please Try again.'
		);	
	}
	echo json_encode($results);
}
// Template Update Category

if($_REQUEST['action'] == "temp_edit_cat"){

	$data = array(
		'cat_name' =>  $db->clean_input($_REQUEST['cat_name']),
		'status' => $_REQUEST['status']
		);
		$id = array('id' => $_REQUEST['id']);
	
	$insertDataUserTable = $db->update("tbl_tmp_category", $data, $id);

	if($insertDataUserTable == true){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Created Successfully.'
		);		
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Something went wrong please Try again.'
		);	
	}
	echo json_encode($results);
}

/* Delete Board */
if($_REQUEST['action'] == "delete_boards"){
	$id = $_REQUEST['id'];
	$where = array(
		'id' => $id
	);
	
	$update = $db->delete("tbl_tmp_board",$where);
	$update = $db->delete("tbl_tmp_board_list",array('board_id'=>$id));
	$update = $db->delete("tbl_tmp_board_list_card",array('board_id'=>$id));
	if($update){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error Found'
		);
	}
	echo json_encode($results);
}



if($_REQUEST['action'] == "deletesticker"){
	$id = $_REQUEST['id'];
	$where = array(
		'id' => $id
	);
	
	$update = $db->delete("stickers_images",$where);
	if($update){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error Found'
		);
	}
	echo json_encode($results);
}


// Update Board
if($_REQUEST['action'] == "temp_edit_board"){

	$data = array('status' => $_REQUEST['status']);
	
	if(!empty($_REQUEST['board_name'])){
				$data['board_name']=$_REQUEST['board_name'];
	}
	/*if(!empty($_REQUEST['board_key'])){
				$data['board_key']=$_REQUEST['board_key'];
	}
	if(!empty($_REQUEST['board_url'])){
				$data['board_url']=$_REQUEST['board_url'];
	}*/
	if(!empty($_REQUEST['category'])){
				$data['cat_id']=$_REQUEST['category'];
	}

	/*if(!empty($_REQUEST['board_bgcolor'])){
				$data['board_bgcolor']=$_REQUEST['board_bgcolor'];
	}
	if(!empty($_REQUEST['board_fontcolor'])){
				$data['board_fontcolor']=$_REQUEST['board_fontcolor'];
	}*/
	
	if(!empty($_REQUEST['image'])){
				$data['board_bgimage']=$_REQUEST['image'];
	}
	
	$id = array('id' => $_REQUEST['id']);
	
	$insertDataUserTable = $db->update("tbl_tmp_board", $data, $id);

	if($insertDataUserTable == true){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Updated Successfully.'
		);		
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Something went wrong please Try again.'
		);	
	}
	echo json_encode($results);
}


if($_REQUEST['action'] == "delete_board_img"){
	$id = $_REQUEST['id'];
	$where = array(
		'id' => $id
	);
	
	$update = $db->delete("tbl_board_img",$where);
	if($update){
		$results = array(
			'result'=>'TRUE',
			'message'=>'Remove Successfully'
		);	 	
	}else{
		$results = array(
			'result'=>'FALSE',
			'message'=>'Error Found'
		);
	}
	echo json_encode($results);
}




?>