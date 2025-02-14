<?php  
require_once("common/config.php");
require_once("DBInterface.php");
require_once("common/encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();


if(!empty($_REQUEST)){

if(isset($_REQUEST['agreestatus'])){

$name = $db->clean_input($_REQUEST['fullname']);
$emailadd = $db->clean_input_email($_REQUEST['emailadd']);
$pass = md5($_REQUEST['pass']);
$passwd = $_REQUEST['pass'];

date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d H:i:s");

$token = md5($date.$name);
$status = 0;



$data = array(
	'Full_Name' => $name,
	'Email_ID' => $emailadd,
	'User_Password' => $pass,
	'accessTocken' => $token,
	'status' => $status,
	'AddDate' => $date,
);


		
$chkemail = $db->chkEmail($emailadd);

if($chkemail == 0){


$insertDataUserTable = $db->insert("tbl_users",$data);



if($insertDataUserTable == true){
			
$uid = $db->lastInsertedId($token);	

//to push send notification
$admin_id=$db->getAdminId('tbl_admin');
 
$notify_data=array(
        'notif_title' => 'New User Registration',
        'notif_msg' => $name.' created account on Odapto',
        'notif_time' => date('Y-m-d H:i:s'),
        'notif_repeat' => 1,
        'notif_loop' => 1,
        'notif_user_from' =>$uid,
        'notif_user_to' => $admin_id['id'],
        'notif_url' => 'https://odapto.com/admin/dashboard.php?page=user',
        'notif_for' => 'web',
        'status' => 1,
        'role' => 'admin'
    );
$insertNotification = $db->insert("tbl_push_notification",$notify_data);

if(!empty($_REQUEST['id']) || !empty($_REQUEST['bid']) || !empty($_REQUEST['invited_by'])){
	$id = $_REQUEST['id'];
	$board_id = $_REQUEST['bid'];
	$user_id = $_REQUEST['invited_by'];	
	$invite_data = array("user_id"=>$user_id,"board_id"=>$board_id,"member_id"=>$uid,"member_status"=>1);
	$insert = $db->insert("tbl_board_members",$invite_data);
	if($insert){
		$cond = array("id"=>$id);
		$inv_token = md5(date("Y-m-d-h-i-s")."saltvalue");
		$update_data = array("invite_token"=>$inv_token);
		$db->update("tbl_board_invite",$update_data,$cond);
	}
}

//profileid
$profile_id = strtotime(date("Ymdhis"));
$user_meta_pid = array("meta_key" => "profile_id","meta_value"=> $profile_id,"user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_pid);

//full name
$user_meta_name = array(
		"meta_key" => "full_name",
		"meta_value"=> $name,
		"user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_name);

// username
$username = explode("@", $emailadd);
$user_meta_username = array(
		"meta_key" => "user_name",
		"meta_value"=> "@".$username[0],
		 "user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_username);

// initials
$first = explode(" ", $name);
$initials = strtoupper(substr($first[0], 0, 1));

// Get second initial if it exists
if (isset($first[1])) {
    $initials .= strtoupper(substr($first[1], 0, 1));
}
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

// bg image
$user_meta_bgimg = array("meta_key" => "bg_img","meta_value"=>"","user_id" => $uid);			
$insert = $db->insert("tbl_usermeta",$user_meta_bgimg);

if($insert){
$verificationUrl = SITE_URL."activate.php?uid=".$uid."&token=".$token;
//$subject = "Account Activation Email";
$subject = "Odapto: Account activation mail.";
         $companyName = 'Odapto';
/*$message = "<p>Thank you for registration on Odapto<br>
In order to activate your account, Please click the link <a href=".$verificationUrl.">Click Here</a></p>";*/
/*$message = "<p>Thank you for registration on Odapto<br></p>";
$message .= "<p>Your Login Details:</p>";   
$message .= "<p>Email: ".$emailadd."</p>";   
$message .= "<p>Password:".$_REQUEST['pass']."</p>";   
$message .= "<h3>Thanks <br> Odapto Team</h3>";  */




//dc code
$message='
<!doctype html> 
<html>
   <head>
      <meta charset="utf-8">
      <title>Odapto Registration</title>
      <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
   </head>
   <body>
      <div style="margin:auto;background: #f7f7f7; float:left;  margin-top: 2px;padding:2px 0; border: 2px solid #8c2d37;
    border-radius: 10px;">
      <table  align="center;" border="0" style="margin:auto; width:100%; text-align:center;font-size: 13px;color: #666;background: #fff;">
         <tr>
            <td colspan="2" style="background-color:#8c2d37; border-radius: 8px 8px 0 0; padding: 7px 0;">
               <img  margin:0 auto; display:block" src="https://www.odapto.com/images/logo.png" width="150px">
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <h2 style="text-align:center;">We"re glad you"re here!</h2>
            </td>
         </tr>
         <tr>
            <td colspan="2">
            <br/>
               <a href="'.$verificationUrl.'" title="Click Here"> 
                <img style="max-width:100%; " src="https://www.odapto.com/images/click-button.png" alt="Click Here To Verify Your Email Address">
            </a>
            <br>
            <p>If you face any problem with above button then copy this link and paste on your browser </p>
            <p>'.$verificationUrl.'</p>
            <br/>      
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <table width="90%" align="center;"  border="1" cellpadding="4" style="margin:auto; width:90%; text-align:center; margin:0 auto;border-collapse: collapse;margin-top: 20px;font-size: 13px;color: #666;">
                  
                  <tr>
                     <td>Email</td>
                     <td>'.$emailadd.'</td>
                  </tr>
                             
                  <tr>
                     <td>Password</td>
                     <td>***********</td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="2">
               <p style="margin-bottom:5px;">We just want to confirm you"re you.</p>
               <p>If you didn"t create a Odapto account, just delete this email and everything will go back to the way it was.</p>
            </td>
          </tr>  
          <tr>
                                <td>
                                <img style="width:650px" width="650" src="https://www.odapto.com/images/mailer.jpg">     
                                </td>     
                                </tr>
      </table>
   </div>
   </body>
</html>
';






    $fromemail = 'admin@odapto.com';
$retval = $db->sendEmail1($subject,$message,$emailadd,$fromemail);
//print_r($retval);
if($retval == 1){
	/*ob_start();
	session_start();
	$_SESSION['user_token'] = $token;
	$url = $DB->site_url."welcome.php?token=".$token;
	header('location: '.$url.'');*/
	$results = array(
			'result'=>'TRUE',
			'message'=>'Your account is successfully registered. Please check your registered email to Activate your account'
	);
	//exit();		
}else{
	$results = array(
			'result'=>'FALSE',
			'message'=>'Error While Registering!'
	);
}	
}
}
}else{
	$results = array(
			'result'=>'FALSE',
			'message'=>'Email Already Exists!'
		);	
}

echo json_encode($results);

	/*$msg = str_replace(" ", "+", $results['message']);
	$url = $DB->site_url."signup.php?msg=".$msg;
	header("location:".$url);*/



		
}

}

?>