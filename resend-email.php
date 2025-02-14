<?php  
require_once("common/config.php");
require_once("DBInterface.php");
require_once("common/encryption.php");
$enc = new Encryption();
$db = new Database();
$db->connect();

if(isset($_REQUEST['user_email']))
{
    $emailadd = $db->clean_input_email($_REQUEST['user_email']);
    
    $chkemail = $db->chkEmail($emailadd);

    if($chkemail == 1)
    {
        $user_id = $db->getIdandAccesstoken($emailadd);
        
        $uid=$user_id['ID'];
        $token=$user_id['accessTocken'];
        $verificationUrl = SITE_URL."activate.php?uid=".$uid."&token=".$token;
       
$subject = "Odapto: Account activation mail.";
         $companyName = 'Odapto';

$message = '
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
                <img style="max-width:100%; min" src="https://www.odapto.com/images/click-button.png" alt="Click Here To Verify Your Email Address">
            </a>
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
    	
    	$results = array(
    			'result'=>'TRUE',
    			'message'=>'<b>Mail Successfully Sent.</b><br> Check your inbox or spam/junk mail.'
    	);
    	//exit();		
    }else{
    	$results = array(
    			'result'=>'FALSE',
    			'message'=>'Error While Sending mail!'
    	);
    }	
    }
   echo json_encode($results);
}

if($_REQUEST['action']=='Subscription')
{
    $subscription_email=$_REQUEST['subs_email'];
    $data=array(
            'subscribe_email' => $subscription_email,
            'subscribe_on' => date('d-m-Y')
            
        );
    $insert=$db->insert('tbl_users_subscriptions',$data);
    if($insert)
    {
        $results = array(
    			'result'=>'TRUE',
    			'message'=>'Successfully Subscribed'
    	);
        
    }else{
        $results = array(
    			'result'=>'FALSE',
    			'message'=>'Failed !! Please try again..'
    	);
    }
    echo json_encode($results);
}



?>