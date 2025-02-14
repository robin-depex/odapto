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
//date_default_timezone_set('Asia/Kolkata');


$v_code             =       $data->RequestData->v_code;
$api_key            =       $data->RequestData->apikey;

$task_id            =       $data->RequestData->task_id;
$amount             =       $data->RequestData->amount;
$nonce              =       $data->RequestData->payment_method_nonce;
$admin_commission   =       $data->RequestData->admin_commission;

//$order_id            =       $data->RequestData->order_id;





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
	    
	    
	    
	   if(!empty($amount) && !empty($nonce) && !empty($task_id)){
	       
	       $task_data       =   $db->getbyid('tasks',$task_id);
	       
	       //echo json_encode($task_data);  die;
           //$spData        =   $db->getbyid('user',$task_data['accepted_by']);
          
          $user_bank_detail =   $db->get_bank_type_detail('user_bankDetail',$task_data['accepted_by'],'paypal');
          $sp_paypal_account =  $user_bank_detail['account_number'];   //'info-buyer@okeyclick.com'
          
         
           
           $userData     =   $db->getbyid('user',$task_data['created_by']);
           
           $buyer_id      =   $userData['id'];
           $first_name    =   $userData['first_name'];
           $last_name     =   $userData['last_name'];
           $email         =   $userData['email'];
           
           
	       
	       
	       $platform_amount     =   $amount * ($admin_commission/100);
	       $seller_amount       =   $amount - $platform_amount;
	       
	       $result = $gateway->transaction()->sale([
                        'amount' => $amount,
                        'paymentMethodNonce' => $nonce,
                        'customer' => [
                            'id'        =>  $buyer_id,
                            'firstName' =>  $first_name,
                            'lastName'  =>  $last_name,
                            'email'     =>  $email,
                            
                          ],
                        'options' => [
                            'submitForSettlement' => true
                        ]
                    ]);
                    
                    /*$result = $gateway->transaction()->sale([
                                'amount' => $amount,
                                'paymentMethodNonce' => $nonce,
                                'orderId' => $order_id,
                                'options' => [
                                    'submitForSettlement' => true,
                                    'paypal' => [
                                        'customField' => 'paypal',
                                        'description' => 'Payement from paypal account',
                                  ],
                                ],
                            ]);*/
                
                    if ($result->success) {
                        
                       ######################################################################
            	       #################### Send money to seller/vendor #####################
            	        define('PAYPAL_CLIENT_ID', 'AT3HHq7K2jOyCpqKVG-_ac0KufvGrrNyQmWFwYxNvwM6Yguvi1yroG3nWeiWClTT9c8MCixC_DsPWLhz');
                        define('PAYPAL_SECRATE_KEY', 'EHJ3M0-zpCJzzpI-XOwGeFibbWkPuS_AOEOzyJd9StIbiGmFKxJSjQtYre7LBT9dzZvU4iGcpQZ6MV7g');
                        // Get access token from PayPal client Id and secrate key
                                    $ch = curl_init();
                        
                                    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRATE_KEY);
                        
                                    $headers = array();
                                    $headers[] = "Accept: application/json";
                                    $headers[] = "Accept-Language: en_US";
                                    $headers[] = "Content-Type: application/x-www-form-urlencoded";
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                                    $results = curl_exec($ch);
                                    $getresult = json_decode($results);
                        
                        
                                    // PayPal Payout API for Send Payment from PayPal to PayPal account
                                    curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payouts");
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        
                                    $array = array('sender_batch_header' => array(
                                            "sender_batch_id" => time(),
                                            "email_subject" => "You have a payout!",
                                            "email_message" => "You have received a payout."
                                        ),
                                        'items' => array(array(
                                                "recipient_type" => "EMAIL",
                                                "amount" => array(
                                                    "value" => $seller_amount,
                                                    "currency" => "EUR"
                                                ),
                                                "note" => "Thanks for the payout!",
                                                "sender_item_id" => time(),
                                                "receiver" => $sp_paypal_account
                                            ))
                                    );
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
                                    curl_setopt($ch, CURLOPT_POST, 1);
                        
                                    $headers = array();
                                    $headers[] = "Content-Type: application/json";
                                    $headers[] = "Authorization: Bearer $getresult->access_token";
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        
                                    $payoutResult = curl_exec($ch);
                                    //print_r($result);
                                    $getPayoutResult = json_decode($payoutResult);
                                    if (curl_errno($ch)) {
                                        echo 'Error:' . curl_error($ch);
                                    }
                                    curl_close($ch);
                                   // print_r($getPayoutResult);
                               
                                   
                                   if($getPayoutResult->batch_header->batch_status=='PENDING')
                                   {
                                          //payment is sent to the vendor successfully 
                                          
                                       
                                   }else{
                                      //payment is sent to the vendor failed to transer amount 
                                      
                                      
                                   }
                                    ##########################################################
                        
                        $response = array(
                                "successBool" => true,
                                "responseType" => "success_payment",
                                "successCode" => "200",
                                "response" =>array(
                                        "message"=> "Payment is successfully done.",
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

