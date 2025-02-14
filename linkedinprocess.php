<?php
session_start();
$baseURL = 'https://www.odapto.com/login.php';
$callbackURL = '';
$linkedinApiKey = '810ilox6yptgns';
$linkedinApiSecret = 'NiOtjOJHU89P2tgM';
$linkedinScope = 'r_basicprofile r_emailaddress';
include_once("LinkedIn/http.php");
include_once("LinkedIn/oauth_client.php");
require_once('DBInterface.php');
$db = new Database();
$db->connect();
if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
  // in case if user cancel the login. redirect back to home page.
  $_SESSION["err_msg"] = $_GET["oauth_problem"];
  header("location:index.php");
  exit;
}

$client = new oauth_client_class;

$client->debug = false;
$client->debug_http = true;
$client->redirect_uri = $callbackURL;

$client->client_id = $linkedinApiKey;
$application_line = __LINE__;
$client->client_secret = $linkedinApiSecret;

if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
  die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
      'create an application, and in the line '.$application_line.
      ' set the client_id to Consumer key and client_secret with Consumer secret. '.
      'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
      'necessary permissions to execute the API calls your application needs.';

/* API permissions
 */
$client->scope = $linkedinScope;
if (($success = $client->Initialize())) {
  if (($success = $client->Process())) {
    if (strlen($client->authorization_error)) {
      $client->error = $client->authorization_error;
      $success = false;
    } elseif (strlen($client->access_token)) {
      $success = $client->CallAPI(
          'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
          'GET', array(
            'format'=>'json'
          ), array('FailOnAccessError'=>true), $user);
    }
  }
  $success = $client->Finalize($success);


}
if ($client->exit) exit;
if ($success) {
  //$user_id = $db->checkUser($user);
  $date=date('Y-m-d');
 // $pass = $db->generateRandomString();
  $pass = md5('123456');
  $token = md5($date.$_SESSION['user_detaile']->formattedName);
  //echo "<pre>";
  //print_r($_SESSION['user_detaile']);die;
  $_SESSION['user_detaile']=$user;

  $emailCount = $db->chkEmail($_SESSION['user_detaile']->emailAddress);

if($emailCount<=0){
 $data = array(
    'Full_Name' => $_SESSION['user_detaile']->formattedName,
    //'FBID'    => $_SESSION['user_detaile']->id,
    'FBID'    => $_SESSION['user_detaile']->id,
    'Email_ID' => $_SESSION['user_detaile']->emailAddress,
    'User_Password' => $pass,
    'accessTocken' =>$token,
    'status' => 1,
    'AddDate' => $date,
    'user_verify_status' => 1,
    'login_type' => 'Linkedin',
  );

  $uid = $db->insert("tbl_users",$data);
// $uid = $db->lastInsertedId($token); 
 $profile_id = strtotime(date("Ymdhis"));
 $user_meta_pid = array("meta_key" => "profile_id","meta_value"=> $profile_id,"user_id" => $uid);      
 $insert = $db->insert("tbl_usermeta",$user_meta_pid);
 $user_meta_name = array(
      "meta_key" => "full_name",
      "meta_value"=> $_SESSION['user_detaile']->formattedName,
      "user_id" => $uid); 
 $insert = $db->insert("tbl_usermeta",$user_meta_name);

  $username = explode("@", $femail);
  $user_meta_username = array(
      "meta_key" => "user_name",
      "meta_value"=> "@".$username[0],
       "user_id" => $uid);  
$insert = $db->insert("tbl_usermeta",$user_meta_username);

  $first = explode(" ", $_SESSION['user_detaile']->formattedName);
  $initials = strtoupper(substr($first[0], 0, 1))."".strtoupper(substr($first[1], 0, 1));
  $user_meta_in = array(
      "meta_key" => "initials",
      "meta_value"=> $initials,
       "user_id" => $uid);      
  $insert = $db->insert("tbl_usermeta",$user_meta_in);
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

}else{
$value = $db->getsingledata('tbl_users','Email_ID',$_SESSION['user_detaile']->emailAddress);
}

  //session_start();
   /* $_SESSION['auth'] = true;
    $_SESSION['FBID'] = $value['FBID'];           
    $_SESSION['sess_login_id'] = $value['ID'];
    $_SESSION['fullname'] = $value['Full_Name'];
    $_SESSION['Tocken'] = $value['accessTocken']; */

//unset($_SESSION['user_detaile']);
unset($_SESSION['OAUTH_ACCESS_TOKEN']);
  
      $_SESSION['user_Id'] = $value['Email_ID'];
     $_SESSION['auth'] = true;
    $_SESSION['sess_login_id'] = $value['ID'];
   $_SESSION['fullname'] = $value['Full_Name'];
    $_SESSION['Tocken'] = $value['accessTocken']; 
    $_SESSION['membership_id'] = $value['membership_plan']; 
    $_SESSION['FBID'] = $value['FBID'];           
 
  


header("location:https://www.odapto.com/dashboard.php?page=home");

} 


else {


   $_SESSION["err_msg"] = $client->error;

}
header("location:index.php");
exit;
?>

