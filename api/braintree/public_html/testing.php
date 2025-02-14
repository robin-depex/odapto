<?php 

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
                            "value" => '10',
                            "currency" => "EUR"
                        ),
                        "note" => "Thanks for the payout!",
                        "sender_item_id" => time(),
                        "receiver" => 'info-buyer@okeyclick.com'
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
            
            //echo $getPayoutResult['batch_header']['batch_status']."<br>";
            
            echo $getPayoutResult->batch_header->batch_status;
            
            ?>
            
        <!--    
            <span id='cwppButton'></span>
<script src='https://www.paypalobjects.com/js/external/connect/api.js'></script>
<script>
paypal.use( ['login'], function (login) {
  login.render ({
    "appid":"AT3HHq7K2jOyCpqKVG-_ac0KufvGrrNyQmWFwYxNvwM6Yguvi1yroG3nWeiWClTT9c8MCixC_DsPWLhz",
    "authend":"sandbox",
    "scopes":"openid",
    "containerid":"cwppButton",
    "responseType":"code",
    "locale":"en-us",
    "buttonType":"CWP",
    "buttonShape":"pill",
    "buttonSize":"lg",
    "fullPage":"true",
    "returnurl":"REPLACE_WITH_YOUR_RETURN_URL"
  });
});
</script>-->