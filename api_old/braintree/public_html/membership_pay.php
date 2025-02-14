<?php
require_once("../includes/braintree_init.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$data = json_decode(file_get_contents("php://input"));

require_once("../../DBInterface.php");
$db = new Database();
$db->connect();

$v_code         = $data->RequestData->v_code;
$api_key        = $data->RequestData->apikey;
$user_id        = $data->RequestData->user_id;
$amount         = $data->RequestData->membership_id;
$membership_id  = $data->RequestData->amount;
$nonce          = $data->RequestData->payment_method_nonce;

$response = "";

$page = $_SERVER['PHP_SELF'];
$page_name = explode("/",$page);

$file_name = $page_name[2];
$service_url = explode(".",$file_name);
$request_url = $service_url[0];

$data = $db->getVcode();
//print_r($data);
foreach ($data as $value){
	$code = $value['v_code'];
	$apikey = $value['APIKey'];
}
if($code == $v_code){
	if($api_key === $apikey){
	   if(!empty($amount) && !empty($nonce)){
                $result = $gateway->transaction()->sale([
                    'amount' => $amount,
                    'paymentMethodNonce' => $nonce,
                    'options' => [
                        'submitForSettlement' => true
                    ]
                ]);
            
                if ($result->success) {
                    
                    $response = array(
                            "successBool" => true,
                            "responseType" => "client_token",
                            "successCode" => "200",
                            "response" =>array(
                                    "message"=> "Your Client token",
                                    "transaction" => $result
                                )
                            
                        );
                    
                    
                    
                }else{
                    
                    $errorString = array();
                    foreach($result->errors->deepAll() as $error) {
                        $errorString[]= array('Error' => $error->code, 'message' => $error->message);
                    }
            
                   
                    $response = array(
                    			"successBool" => false,
                    			"successCode" => "400",
                    				"response" => array(),
                    				"ErrorObj"	 => array(
                    					"ErrorCode" => "106",
                    					"ErrorMsg"	=> "Unable to create Payment.",
                    					"error" => $errorString
                    				)		
                    		);
                }
            }else{
                
                $response = array(
                    			"successBool" => false,
                    			"successCode" => "400",
                    				"response" => array(),
                    				"ErrorObj"	 => array(
                    					"ErrorCode" => "106",
                    					"ErrorMsg"	=> "Unable to create Payment."
                    				)		
                    		);
              
            }
	    
	}else{
		$response = array(
			"successBool" => false,
			"successCode" => "400",
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
		"successCode" => "400",
			"response" => array(),
			"ErrorObj"	 => array(
				"ErrorCode" => "105",
				"ErrorMsg"	=> "Update Your Version"
			)		
	);
}

$result_response  = json_encode($response);

$data = array("serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));

header('content-type: application/json');
	echo $result_response;
?>

