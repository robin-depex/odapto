<?php
session_start();
error_reporting(1);
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '442336999632031','e3b1232aec8fa1c58bb746e2ec12affe' );
// login helper with redirect_uri

    $helper = new FacebookRedirectLoginHelper('https://www.odapto.com/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
$accessToken = $session->getAccessToken();
//print_r($session);
/*$fields = 'id,email,first_name,last_name,link,name,picture';
$profileResponse = client->request('GET', 'https://graph.facebook.com/v2.5/me', [
    'query' => [
        'access_token' => $accessToken,
        'fields' => $fields
    ]
]);


print_r($profileResponse);die;*/

//echo $accessToken;
 //$request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=id,name,email,picture,first_name,last_name,link&access_token='.$accessToken);
 

  //$response = $request->execute();
  
  $request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=id,name,email,picture,first_name,last_name,link&access_token='.$accessToken);
  $response = $request->execute();
  
 //echo "<pre>";
  //print_r($response);

  $graphObject = $response->getGraphObject();

  $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
  $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
  $femail1 = $graphObject->getProperty('email');    // To Get Facebook email ID
  $pic = $graphObject->getProperty('picture');
  $picurl = $pic->getProperty('url');

  
  $date = date("Y-m-d H:i:s");
 $token = md5($date.$fbfullname);
// $pass = $db->generateRandomString();
  $pass = md5('123456');
require_once('DBInterface.php');
$db = new Database();
$db->connect();

if(empty($femail1)){
  $femail = $fbid;
}else{
  $femail = $femail1;
}

 

 $chkemail = $db->chkEmail($femail);

  if($chkemail<=0){
 $data = array(
    'Full_Name' => $fbfullname,
    'FBID'    => $fbid,
    'Email_ID' => $femail,
    'User_Password' => $pass,
    'accessTocken' => $token,
    'status' => 1,
    'AddDate' => $date,
    'user_verify_status' => 1,
    'login_type' => 'Facebook',
    'profile_pics' => $picurl,
    'profile_pic_type' => 'url',
  ); 

$insertDataUserTable = $db->insert("tbl_users",$data);

  $uid = $db->lastInsertedId($token); 
    //profileid
  $profile_id = strtotime(date("Ymdhis"));
  $user_meta_pid = array("meta_key" => "profile_id","meta_value"=> $profile_id,"user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_pid);

  //full name
  $user_meta_name = array(
      "meta_key" => "full_name",
      "meta_value"=> $fbfullname,
      "user_id" => $uid);     
  $insert = $db->insert("tbl_usermeta",$user_meta_name);

  // username
  $username = explode("@", $femail);
  $user_meta_username = array(
      "meta_key" => "user_name",
      "meta_value"=> "@".$username[0],
       "user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_username);

  // initials
  $first = explode(" ", $fbfullname);
  $initials = strtoupper(substr($first[0], 0, 1))."".strtoupper(substr($first[1], 0, 1));
  $user_meta_in = array(
      "meta_key" => "initials",
      "meta_value"=> $initials,
       "user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_in);

  // boi informations
  $user_meta_in = array(
    "meta_key" => "Bio",
    "user_id" => $uid);     
  $insert = $db->insert("tbl_usermeta",$user_meta_in);

  // bg color
  $user_meta_bg = array("meta_key" => "bg_color","meta_value"=>"#f52d39","user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_bg);

    $id = session_id();
    $cond = array(
      "ID" => $uid
    );
    $update_data = array("accessTocken" => $id);
    $update = $db->update("tbl_users",$update_data, $cond);

    $value = $db->newUserFbData($id,$uid);
    session_start();
    $_SESSION['auth'] = true;
    $_SESSION['FBID'] = $value['FBID'];           
    $_SESSION['sess_login_id'] = $value['ID'];
    $_SESSION['fullname'] = $value['Full_Name'];
    $_SESSION['Tocken'] = $value['accessTocken']; 
   header("Location:dashboard.php?page=home");

}else{

  /* ---- Session Variables -----*/

    session_start(); 
    $id = session_id();

    $cond = array(
            "FBID" => $fbid
        );
    $update_data = array("accessTocken" => $id);
    $update = $db->update("tbl_users",$update_data, $cond);

    $value = $db->userFbData($fbid);
   
    $_SESSION['auth'] = true;
    $_SESSION['FBID'] = $value['FBID'];           
    $_SESSION['sess_login_id'] = $value['ID'];
    $_SESSION['fullname'] = $value['Full_Name'];
    $_SESSION['Tocken'] = $value['accessTocken']; 
    
  
  /* ---- header location after session ----*/
header("Location:dashboard.php?page=home");

  } 

 
} else {
 $loginUrl = $helper->getLoginUrl();
 header("Location:".$loginUrl);
}
?>