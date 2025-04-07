<?php  
$input = file_get_contents('php://input');
require_once("DBInterface.php");
$db = new Database();
$db->connect();
//date_default_timezone_set('Asia/Kolkata');
//date_default_timezone_set('Europe/Amsterdam');
$arr = json_decode($input,true);
$req_type = $arr['RequestData']['requestType'];
$v_code = $arr['RequestData']['v_code'];
$api_key = $arr['RequestData']['apikey'];
$userToken = $arr['RequestData']['userToken'];
$uid = $arr['RequestData']['user_id'];
$board_id = $arr['RequestData']['board_id'];



$sessToken = $db->verifyUserToken($userToken,$uid);
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){

/* Code Will Go Here*/	
	
// $delete_card_member = $db->delete('tbl_board_card_members',array('board_id'=>$board_id));
// $delete_invite = $db->delete('tbl_board_invite',array('bid'=>$board_id));
// $delete_list = $db->delete('tbl_board_list',array('board_id'=>$board_id));
// $delete_card = $db->delete('tbl_board_list_card',array('board_id'=>$board_id));
// $delete_attachment = $db->delete('tbl_board_list_card_attachements',array('board_id'=>$board_id));
// $delete_checklist = $db->delete('tbl_board_list_card_checklist',array('board_id'=>$board_id));
// $delete_checklistitm = $db->delete('tbl_board_list_card_checklist_item',array('board_id'=>$board_id));
// $delete_comment = $db->delete('tbl_board_list_card_comments',array('board_id'=>$board_id));
// $delete_label = $db->delete('tbl_board_list_card_labels',array('board_id'=>$board_id));
// $delete_duedate = $db->delete('tbl_board_list_duedate',array('board_id'=>$board_id));
// $delete_member = $db->delete('tbl_board_members',array('board_id'=>$board_id));
// $delete_board = $db->delete('tbl_user_board',array('board_id'=>$board_id));
// $delete_boardmeta = $db->delete('tbl_user_boardmeta',array('board_id'=>$board_id));


        $updateData = array(
                'status' => 0
            );
            $cond = array(
                'board_id' => $board_id
            );
            $update = $db->update("tbl_user_board",$updateData,$cond);
            
	$response = array(
		"successBool" => true,
		"responseType" => "delete_board",
		"successCode" => "200",
			"response" => array(
				'message' => "Delete Board successfully"
			),
			"ErrorObj"	 => array(
				"ErrorCode" => "",
				"ErrorMsg"	=> ""
			)		
	);

	
/* End Of Code */		

}else{
	
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "106",
				"ErrorMsg"	=> "Invalid APIkey"
			)		
	);
}

}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "105",
				"ErrorMsg"	=> "Update Your Version"
			)		
	);
}
}else{
	$response = array(
		"successBool" => false,
		"successCode" => "",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "105",
				"ErrorMsg"	=> "Token Mismatched"
			)		
	);
}
$result_response  = json_encode($response);

$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

$db->insert("error_log",$data);
	header('content-type: application/json');
	echo $result_response;
