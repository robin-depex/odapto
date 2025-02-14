<?php
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
//date_default_timezone_set('Asia/Kolkata');

$v_code = $data->RequestData->v_code;
$api_key = $data->RequestData->apikey;
$user_id = $data->RequestData->user_id;

$firstName      =   $data->RequestData->firstName;
	    $lastName       =   $data->RequestData->lastName;
	    $email          =   $data->RequestData->email;
	    $phone          =   $data->RequestData->phone;
	    $dateOfBirth    =   $data->RequestData->dateOfBirth;
	    $ssn            =   $data->RequestData->ssn;
	    $streetAddress  =   $data->RequestData->streetAddress;
	    $locality       =   $data->RequestData->locality;
	    $region         =   $data->RequestData->region;
	    $postalCode     =   $data->RequestData->postalCode;
	    
	   


	    
	    //business data
	    $legalName       =   $data->RequestData->legalName;
	    $dbaName         =   $data->RequestData->dbaName;
	    $taxId           =   $data->RequestData->taxId;
	    $b_streetAddress  =   $data->RequestData->b_streetAddress;
	    $b_locality       =   $data->RequestData->b_locality;
	    $b_region         =   $data->RequestData->b_region;
	    $b_postalCode     =   $data->RequestData->b_postalCode;
	    
	    //funding
	    $descriptor          =   $data->RequestData->descriptor;
	    $funding_email      =   $data->RequestData->funding_email;
	    $mobilePhone        = $data->RequestData->mobilePhone;
	    $accountNumber       = $data->RequestData->accountNumber;
	    $routingNumber       = $data->RequestData->routingNumber;

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
	    
	   
	    
	    
	    $masterMerchantAccountId = 'depex';
	    $id = '87z43w';
	    
	    
	    
	    
	    $merchantAccountParams = [
                          'individual' => [
                            'firstName' => $firstName,
                            'lastName' => $lastName,
                            'email' => $email,
                            'phone' => $phone,
                            'dateOfBirth' => $dateOfBirth,
                            'ssn' => $ssn,
                            'address' => [
                              'streetAddress' => $streetAddress,
                              'locality' => $locality,
                              'region' => $region,
                              'postalCode' => $postalCode
                            ]
                          ],
                          'business' => [
                            'legalName' => $legalName,
                            'dbaName' => $dbaName,
                            'taxId' => $taxId,
                            'address' => [
                              'streetAddress' => $b_streetAddress,
                              'locality' => $b_locality,
                              'region' => $b_region,
                              'postalCode' => $b_postalCode
                            ]
                          ],
                          'funding' => [
                            'descriptor' => $descriptor,
                            'destination' => Braintree_MerchantAccount::FUNDING_DESTINATION_BANK,
                            'email' => $funding_email,
                            'mobilePhone' => $mobilePhone,
                            'accountNumber' => $accountNumber,
                            'routingNumber' => $routingNumber
                          ],
                          'tosAccepted' => true,
                          'masterMerchantAccountId' => $masterMerchantAccountId,
                          'id' => $id
                        ];
                        $result = $gateway->merchantAccount()->create($merchantAccountParams);
                if($result)
                {
                  
                    $response = array(
                            "successBool" => true,
                            "responseType" => "create_merchant",
                            "successCode" => "200",
                            "response" =>array(
                                    "message"=> "Your Client token",
                                    "merchantdata" => $result
                                )
                            
                        );
                }else{
                    $response = array(
                			"successBool" => false,
                			"successCode" => "400",
                				"response" => array(),
                				"ErrorObj"	 => array(
                					"ErrorCode" => "106",
                					"ErrorMsg"	=> "Failed To create Merchant"
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