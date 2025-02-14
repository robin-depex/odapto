<?php
echo 'Hi hello......';
die();
require_once("../includes/braintree_init.php");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 // get posted data
$data = json_decode(file_get_contents("php://input"));

	require_once("../../DBInterface.php");
$db = new Database();
$db->connect();

date_default_timezone_set('Asia/Kolkata');

$v_code = $data->RequestData->v_code;
$api_key = $data->RequestData->apikey;
$user_id = $data->RequestData->user_id;



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
	    
	    if(!empty($user_id)){
            // create the product
            $Client_token = $gateway->ClientToken()->generate();
            if($Client_token){
                
        $response = array(
                    "successBool" => true,
                    "responseType" => "client_token",
                    "successCode" => "200",
                    "response" =>array(
                            "message"=> "Your Client token",
                            "Client_token" => $Client_token
                        )
                    
                );
               
            }else{
                
                $response = array(
                    		"successBool" => false,
                    		"successCode" => "",
                    			"response" => array(),
                    			"ErrorObj"	 => array(
                    				"ErrorCode" => "105",
                    				"ErrorMsg"	=> "Unable to create product."
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
                    				"ErrorMsg"	=> "Unable to create product. Data is incomplete."
                    			)		
                    	);
         
        }
	    
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

$data = array("serviceurl"=>$file_name,"request"=>$input,"response"=>$result_response,"entrydate"=>date("Y-m-d H:i:s a"));


header('content-type: application/json');
	echo $result_response;






?>