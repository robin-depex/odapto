<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');

if($_REQUEST['action'] == "temp_add_board"){

	$data = array(
		'cat_id' =>  $db->clean_input($_REQUEST['category']),
		'board_name' => $db->clean_input($_REQUEST['board_name']),
		'board_url' => $db->clean_input($_REQUEST['board_url']),
		'board_key' => $db->clean_input($_REQUEST['board_key']),
		'board_bgcolor' => $_REQUEST['board_bgcolor'],
		'board_bgimage' => $_REQUEST['image'],
		'board_fontcolor' => $db->clean_input($_REQUEST['description']),
		'status'=>'1');

	
	$channelodata=$db->AlldataUser();
	$db->pushNotification($channelodata,$db->clean_input($_REQUEST['board_name']));
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
	
	$update = $db->delete("tbl_templates",$where);
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

//temp_add_cat
if($_REQUEST['action'] == "temp_add_cat"){

	$data = array(
		'cat_name' =>  $db->clean_input($_REQUEST['cat_name']),
		'cat_slug' => $db->clean_input($_REQUEST['cat_slug']),
		'status' => 1,
		'description' => $db->clean_input($_REQUEST['description']));
	
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
		'cat_slug' => $db->clean_input($_REQUEST['cat_slug']),
		'description' => $db->clean_input($_REQUEST['description']),
		'status' => $db->clean_input($_REQUEST['status'])
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

	$data = array('status' => $db->clean_input($_REQUEST['status']));
	
	if(!empty($_REQUEST['board_name'])){
				$data['board_name']=$_REQUEST['board_name'];
	}
	if(!empty($_REQUEST['board_key'])){
				$data['board_key']=$_REQUEST['board_key'];
	}
	if(!empty($_REQUEST['board_url'])){
				$data['board_url']=$_REQUEST['board_url'];
	}
	if(!empty($_REQUEST['category'])){
				$data['cat_id']=$_REQUEST['category'];
	}

	if(!empty($_REQUEST['board_bgcolor'])){
				$data['board_bgcolor']=$_REQUEST['board_bgcolor'];
	}
	if(!empty($_REQUEST['board_fontcolor'])){
				$data['board_fontcolor']=$_REQUEST['board_fontcolor'];
	}
	/*
	if(!empty($_REQUEST['board_bgimage'])){
				$data['board_bgimage']=$_REQUEST['board_bgimage'];
	}	
	*/
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

?>