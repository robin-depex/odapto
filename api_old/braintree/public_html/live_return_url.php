<?php 
require_once("../../DBInterface.php");
$db = new Database();
$db->connect();

$paypal_url = "https://api.sandbox.paypal.com";  //for live https://api.paypal.com 



$user_id = @$_GET['state'];
/*echo "<pre>";
print_r($_GET);
echo "</pre>";*/
//   define('PAYPAL_CLIENT_ID', 'AT3HHq7K2jOyCpqKVG-_ac0KufvGrrNyQmWFwYxNvwM6Yguvi1yroG3nWeiWClTT9c8MCixC_DsPWLhz');
//   define('PAYPAL_SECRATE_KEY', 'EHJ3M0-zpCJzzpI-XOwGeFibbWkPuS_AOEOzyJd9StIbiGmFKxJSjQtYre7LBT9dzZvU4iGcpQZ6MV7g');

    define('PAYPAL_CLIENT_ID', 'AXLdPlpg58I0HZ_SgsrKBH-uv38xu6aLDsxErRvXw2k32_wWiifHkOQBzbzEcW7x5nOOSviEBXlK7ggp');
    define('PAYPAL_SECRATE_KEY', 'EDmqu99kzE0sA4h0uNbDYmYpeh0X4SInKM9qFZ_VYkXyc4cJDCBef3TeepyRTnEQr0REd5rJqbjNo4cH');

  //authenticate with paypal
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "$paypal_url/v1/oauth2/token");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=".$_GET['code']);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRATE_KEY);
      $headers = array();
      $headers[] = "Accept: application/json";
      $headers[] = "Accept-Language: en_US";
      $headers[] = "Content-Type: application/x-www-form-urlencoded";
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $results = curl_exec($ch);
      $getresult = json_decode($results);
      /*echo "<pre>";
      print_r($getresult);*/
      $f_access_token = $getresult->access_token;
      
     /* echo "firstaccess token : $getresult->access_token</pre>";*/
                                    
    //to get refresh token                                
      /*$ch1 = curl_init();
      curl_setopt($ch1, CURLOPT_URL, "$paypal_url/v1/oauth2/token");
      curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch1, CURLOPT_POSTFIELDS, "grant_type=refresh_token&refresh_token=".$getresult->refresh_token);
      curl_setopt($ch1, CURLOPT_POST, 1);
      curl_setopt($ch1, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ":" . PAYPAL_SECRATE_KEY);
      
      $head = array();
      $head[] = "Accept: application/json";
      $head[] = "Accept-Language: en_US";
      $head[] = "Content-Type: application/x-www-form-urlencoded";
      curl_setopt($ch1, CURLOPT_HTTPHEADER, $head);

      $res = curl_exec($ch1);
      $getres = json_decode($res);*/
     /* echo "Other Data";
      echo "<pre>";
      print_r($getres);
      echo "</pre>";*/
      
      /* $access_token = $getres->access_token;*/

      /* echo "Acess_token : ".$access_token ."<br>";*/
                                    
                                    
                                    

      $ch2 = curl_init();
      curl_setopt($ch2, CURLOPT_URL, "$paypal_url/v1/identity/oauth2/userinfo?schema=paypalv1.1");
      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
      $head2 = array();
      $head2[] = "Accept-Language: en_US";
      $head2[] = "Content-Type: application/json";
      $head2[] = "Authorization: Bearer $f_access_token";
      curl_setopt($ch2, CURLOPT_HTTPHEADER, $head2);

      $res2 = curl_exec($ch2);
      $getres2 = json_decode($res2);

      $paypal_email = $getres2->emails[0]->value;
      /*echo "final Data";
      echo "<pre>";
      print_r($getres2);
      echo "</pre>";

      echo "final_email :" .$paypal_email;*/



?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
.thnk{
    position: absolute;
    top: 50%;
    color: #fff;
    text-align: center;
    width: 100%;
    left: 50%;
    box-sizing: border-box;
    padding: 25px;
    transform: translate(-50%, -50%);
}

.back a{
    background: #fff;
    display: inline-block;
    text-decoration: none;
    border-radius: 5px;
    font-size: 18px;
    letter-spacing: 2px;
    padding: 3px 16px;
    color: #000;
    margin-top: 20px;
}
.thnk h1{
    font-size: 30px;
}   
</style>
</head>
<body style="background:#3685c6 ">

<div class="thnk">
      <?php
            if(!empty($paypal_email))
            {
                 

                  $user_update = array(
                              'account_type'      =>  'paypal',
                              'account_number'    =>  $paypal_email,
                              'user_id'           =>  $user_id,
                              
                              );    

 
                    $userdata = $db->getbyid('user',$user_id);
                  if(empty($userdata['doc1']) OR empty($userdata['doc1']) OR empty($userdata['doc1']) OR empty($userdata['doc1']) OR empty($userdata['doc1'])){
                        $stepno = 2;
                  }else{
                        $stepno = 3;
                  }

                        $con=array('user_id'=>$user_id);  
                  $response1 = $db->update('user',array('step'=> $stepno), array('id'=> $user_id));
                  

                   if(!empty($doc1)){
                    $user_profile['doc1'] = $doc1;
                  }
                  if(!empty($doc2)){
                    $user_profile['doc2'] = $doc2;
                  }
                  if(!empty($doc3)){
                    $user_profile['doc3'] = $doc3;
                  }
                  if(!empty($doc4)){
                    $user_profile['doc4'] = $doc4;
                  }
                  if(!empty($doc5)){
                    $user_profile['doc5'] = $doc5;
                  }

                 $query = "select from user_bankDetail where user_id='$user_id' AND account_type='paypal' ";
                 $count_account =  $db->get_sql_query();
                 if(count($count_account)>0)
                 {
                  $update = array('account_number'=>$paypal_email);
                  $con    = array('user_id'=>$user_id);

                  $update=$db->update('user_bankDetail',$update,$con);

                 }else{

                  $response2 = $db->insert('user_bankDetail',$user_update); 

                        $up_data = array(
                                    'paypal_id_verify' => 1,
                                    );
                        $con    = array('id'=>$user_id);  
                        $db->update('user_bankDetail',$up_data,$con);
                 }

            ?>
                  <h1>Congratulations!!</h1>
                  <p>You have added your Paypal account with us and now onwards, you can accept the payment directly to your Paypal Account.</p>
                  <div class="back">
                    <?php  
                    
                    $s_status = "success";
                  $a = @$_SERVER['HTTP_USER_AGENT'];
                  if (strpos($a, 'iPhone') !== false) {
                   define('redirect_URI', 'okeyclick://paypalconnect');
                  $redirect_URI = redirect_URI . '/' . $s_status;
                  }else{
                       define('redirect_URI', 'okeyclick://paypalconnect');
                  $redirect_URI = redirect_URI . '/' . $s_status;
                  }

                  ?>
                     <a href="<?php echo $redirect_URI; ?>" class="back">Back to app</a>
                  </div>
            <?php

            }else{
                  ?>
                  <h1>Something went Wrong!!</h1>
                  <p>Unable to connect with paypal... Please try Again</p>
                  <div class="back">
                    <?php  
                    $status = 'failed';

                  $a = @$_SERVER['HTTP_USER_AGENT'];
                  if (strpos($a, 'iPhone') !== false) {
                   define('redirect_URI', 'okeyclick://paypalconnect');
                  $redirect_URI = redirect_URI . '/' . $status;
                  }else{
                       define('redirect_URI', 'okeyclick://paypalconnect');
                  $redirect_URI = redirect_URI . '/' . $status;
                  }

                  ?>
                     <a href="<?php echo $redirect_URI; ?>" class="back">Back to app</a>
                  </div>

                  <?php
            }
      ?>
   
</div>


</body>
</html>