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
	$user_id = $arr['RequestData']['user_id'];
	$plan = $arr['RequestData']['plan']; 
	$amount = $arr['RequestData']['amount']; 
	$trn_id = $arr['RequestData']['trn_id']; 
	$payment_status = $arr['RequestData']['payment_status']; 
	if($plan==2){
$plan_name = 'Business Plan';
	}else{
	$plan_name = 'Enterprise Plan';	
	}
$data = $db->getVcode();
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($code == $v_code){
	
if($api_key == $apikey){
	$last_id = $db->insert('payments',array('txnid'=>$trn_id,'payment_amount'=>$amount,'payment_status'=>$payment_status,'itemid'=>$plan_name,'createdtime'=>date('Y-m-d H:i:s')));

	$insert1 = $db->insert('user_payment',array('user_id'=>$user_id,'pay_id'=>$last_id,'plan_id'=>$plan,'status'=>1));

	$con = array(
'ID' => $user_id,
		);
	$expiry_date= date('Y-m-d', strtotime('+1 months'));

				$data_user_device = array(
					'membership_plan' => $plan,
					'expiry_date'=>$expiry_date,
				);
				$db->update("tbl_users",$data_user_device,$con);
					$response = array(
					"successBool" => true,
					"responseType" => "plan_upgrade",
					"successCode" => "200",
					
						"response" => array(
							'message'=>'Successfully plan upgrade.',
                           'membership_plan' => $plan,
						),
						"ErrorObj"	 => array(
							"ErrorCode" => "",
							"ErrorMsg"	=> ""
						)		
					);
			
 

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
$result_response  = json_encode($response);
$data = array("serviceurl"=>$req_type,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));
$db->insert("error_log",$data);

header('content-type: application/json');
	echo $result_response;
?>