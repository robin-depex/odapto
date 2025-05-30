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
$card_id = $arr['RequestData']['card_id'];
$checklist_item_id = $arr['RequestData']['checklist_item_id'];
$sessToken = $db->verifyUserToken($userToken,$uid);
$data3 = $db->getVcode();
foreach ($data3 as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($userToken == $sessToken){
if($code == $v_code){
	
if($api_key == $apikey){


/* Code Will Go Here*/	
$wherarraycheck = array(
'id' => $checklist_item_id,
	);


$delete = $db->delete('tbl_board_list_card_checklist_item',$wherarraycheck);


$wherarraycheckitem = array(
'checklist_id' => $checklist_id,
	);


$delete1 = $db->delete('tbl_board_list_card_checklist_item',$wherarraycheckitem);
$wherarray = array(
'status' => 1,
'cardid' => $card_id,
	);
$chelistdata = $db->getdata('tbl_board_list_card_checklist',$wherarray);
if(!empty($chelistdata)){
foreach($chelistdata as $check_data){
	$wherarray1 = array(
'checklist_id' => $check_data['id'],
	);

	$wherarray11 = array(
		'status' => 1,
'checklist_id' => $check_data['id'],
	);
$total_item = $db->datafound('tbl_board_list_card_checklist_item',$wherarray1);
$total_item1 = $db->datafound('tbl_board_list_card_checklist_item',$wherarray11);
$singlepar = 100/$total_item;
//echo $total_item;
if($total_item>0){
if($total_item1==1){
	$parcentcheck = intval($singlepar);
}else if($total_item1==$total_item){
$parcentcheck = 100;
}else if($total_item1==0){
$parcentcheck = 0;
}else{
	$parcentcheck = intval($singlepar*$total_item1);
} 
}else{
	$parcentcheck = 0;
}




	$chelistdataitem = $db->getdata('tbl_board_list_card_checklist_item',$wherarray1);
	if(!empty($chelistdataitem)){
			$data_check_item = '';
		$checkitem =array();
		foreach($chelistdataitem as $check_data_item){
$data_check_item = array(
'item_id' => $check_data_item['id'],
'item_name' => $check_data_item['item_name'],
'parent_id' => $check_data_item['checklist_id'],
'status' => $check_data_item['status'],
	);
$checkitem[] = $data_check_item;
	}
}else{
	$checkitem = [];
}
	
$data_check = array(
'checklist_id' => $check_data['id'],
'card_id' => $card_id,
'user_id' => $check_data['userid'],
'checklist_name' => $check_data['checklist'],
'date_time' => $check_data['date_time'],
'checklist_item' => $checkitem,
'progress' => $parcentcheck,
	);

$checkarry[] = $data_check;
}
  $response = array(
                "successBool" => true,
                "responseType" => "delete_checklist_item",
                "successCode" => "200",
                    "response" => array(
                        "deletechecklistitem" => $checkarry,
                        "message" => 'Delete successfully',
                    ),
                    "ErrorObj"   => array(
                        "ErrorCode" => "",
                        "ErrorMsg"  => ""
                    )       
            );
    
}else{
	 $response = array(
                    "successBool"   => false,
                    "successCode"   => "",
                        "response"  => array(),
                        "ErrorObj"   => array(
                            "ErrorCode" => "104",
                            "ErrorMsg"  => "No Data Found"
                        )
                );
}

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

$data = array("serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));


header('content-type: application/json');
	echo $result_response;