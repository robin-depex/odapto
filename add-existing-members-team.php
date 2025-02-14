<?php  
error_reporting(0);
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();

$data = explode("_",$_REQUEST['data']);
//print_r($data);die;
$uid = $data[0];
$bid = $data[1];
$invited_by = $_SESSION['sess_login_id'];
$result = $db->getTeamDetails($bid);
$board_url = $result['team_url'];
$board_key = $result['team_key'];
date_default_timezone_set("Asia/Kolkata");
	$date = date("Y-m-d H:i:s");
$inv_token = md5($date."teamaddmembers");
$count = $db->ChkInviteToken($inv_token);
if($count > 0){
	$salt = "odaptonew";
	$invtoken = md5($date.$salt);
}else{
	$invtoken = $inv_token;
}
$chk_invite_member = $db->ChkInviteTeamMember($uid,$bid);

if($chk_invite_member > 0){
	//echo "already Invited";
	$msgg = 0;
	echo $msgg;
}else{
	 $team_admindata = $db->get_single_data('tbl_users',array('ID'=>$uid));
	$data_inv = array(	
		"member_id"=>$uid,
		"tid"=>$bid,
		"turl"=>$board_url,
		"tkey"=>$board_key,
		"invited_by"=>$invited_by,
		"invite_token"=>$invtoken,
		"invite_date"=> $date,
		"user_email"=> $team_admindata['Email_ID']
	);
	//echo json_encode($data);
	$dbinsert = $db->insert("tbl_team_invite",$data_inv);
	
	//to send notification
	$name=$db->getName($invited_by);
	//https://www.odapto.com/dashboard.php?page=team&t=13&u=developer-team&k=xU4Jkh
	$invite_link = "https://www.odapto.com/dashboard.php?page=team&t=".$bid."&u=".$board_url."&k=".$board_key." ";
	$notify_data=array(
            'notif_title' => 'Team Invitation',
            'notif_msg' => $name.' Invited you to join the board',
            'notif_time' => date('Y-m-d H:i:s'),
            'notif_repeat' => 1,
            'notif_loop' => 1,
            'notif_user_from' =>$invited_by,
            'notif_user_to' => $uid,
            'notif_url' => $invite_link,
            'notif_for' => 'web',
            'status' => 1
        );
    $insertNotification = $db->insert("tbl_push_notification",$notify_data);
    
    //end notification

	$board_members_data = array("user_id"=>$invited_by,"team_id"=>$bid,"member_id"=>$uid,"member_status"=>1,"type"=>"Member");

	$insert = $db->insert("tbl_team_members",$board_members_data);
	// send Invite mail
	    $subject = "Odapto: Team Invitation.";
        $companyName = 'Odapto';
        $message='
<!doctype html> 
<html>
   <head>
      <meta charset="utf-8">
      <title>Team Invitation</title>
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
               <h2 style="text-align:center;">'.$name.' Invited you to join the board</h2>
            </td>
         </tr>
         <tr>
            <td colspan="2">
            
            <br>
            <p>Click Here To See Your Invitation </p>
            <p>'.$invite_link.'</p>
            <br/>      
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
$emailadd = $team_admindata['Email_ID'];
$retval = $db->sendEmail1($subject,$message,$emailadd,$fromemail);
echo "Invited Suucessfully";
$msgg = 1;
echo $msgg;
	
}
