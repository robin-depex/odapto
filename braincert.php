<?php 
$lmsurl ='https://teacheo.braincert.com/'; # Your LMS Domain url. For example, https://acme.braincert.com/.
$email = "arvind.depex@gmail.com"; # Email address of the user
$username = "arvind1223"; # Username 
$first_name = "arvind"; # First name of the user
$last_name = "kumar"; # Last name of the user
$group_id = "1"; # LMS group IDs separated by a comma
$data = array();
$data['sso_api_key'] = "SbhVRDKEJzmG9fwh8yyLiMeUlFZB2jTbh15JfY1A"; # API KEY
$data['sso_auth_key']= "0uFptobinHghdUZhZqPtQ4xeQPBs3Uvsgq2H1Wny"; # AUTH KEY
$data['username'] = $username;
$data['email'] = $email;
$data_string = json_encode($data); 
$lmsurl = trim($lmsurl,"/");
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $lmsurl."/?task=request_token");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result_json = curl_exec($ch);
$result = json_decode($result_json, TRUE); 
if($result['status']=='ok'){
    echo '<pre>';
    print_r($result);
      $token =  $result['token'] ;
      echo $ssourl = "<a href='".$lmsurl."/?token=".$result['token']."&email=".$email."&username=".$username."&first_name=".$first_name."&last_name=".$last_name."&group_id=".$group_id."'>".$email."</a>" ;
}
else if($result['status']=='error'){
      echo $result['message'] ;
}
?>