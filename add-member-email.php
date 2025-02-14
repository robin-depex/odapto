<?php  
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();


	$data = explode("&",$_REQUEST['data']);

	$name_d = explode("=",$data[0]);
	$name = $name_d[1]; 

	$email_d = explode("=",$data[1]);
	$email = $email_d[1]; 

	$bid_d = explode("=",$data[2]);
	$bid = $bid_d[1]; 

	$invited_by = $_SESSION['sess_login_id'];

	$result = $db->getBoardDetails($bid);
	$board_title = $result['board_title'];
	$board_url = $result['board_url'];
	$board_key = $result['board_key'];
	date_default_timezone_set("Asia/Kolkata");
	$date = date("Y-m-d H:i:s");
	$inv_token = md5($date."boardaddmembersbyemail");

	$count = $db->ChkInviteToken($inv_token);

	if($count > 0){
		$salt = "odaptonew";
		$invtoken = md5($date.$salt);
	}else{
		$invtoken = $inv_token;
	}

	$ChkInviteMemberByEmail = $db->ChkInviteMemberByEmail($email,$bid);
	if($ChkInviteMemberByEmail > 0){
		
		$update_data = array("invite_token"=>$invtoken);
		$condition = array("bid"=>$bid,"user_email" => $email);
		$update = $db->update("tbl_board_invite",$update_data,$condition);

	}else{

	$data_inv = array(	
		"bid"=>$bid,
		"burl"=>$board_url,
		"bkey"=>$board_key,
		"user_email" => $email,
		"invited_by"=>$invited_by,
		"invite_token"=>$invtoken,
		"invite_date"=>$date
	);
	$insert = $db->insert("tbl_board_invite",$data_inv);

	}
	
$senderdetail = mysqli_fetch_array(mysqli_query($db->dbh,"select * FROM tbl_users WHERE ID = '".$invited_by."'"));
$sendername = $senderdetail['Full_Name'];

	$invite_link = "https://www.odapto.com/signup.php?page=board&b=".$bid."&t=".$board_url."&k=".$board_key."&id=".$invited_by."&email=".$email."&token=".$invtoken;
	
	
	
	$subject = "Board invitation Email ";
	
	/*$message = "<h5>Hello ".$name." </h5>";         
	$message .= "<p>You are invited to ".$board_title."Board.<br>
	In order to Join this Board , Please click the link </p>";
	$message .= "<a style='width:150px;height:35px;background:#f1f1f1;padding:15px;' href=".$invite_link.">Join Board</a>";
	
	$message .= "<h3>Thanks <br> Odapto Team</h3>";   */



	$message = '<html>
<head>
<title>Odapto | Board Invitation</title>
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">';
$message .= '<style type="text/css">';
$message .=  " *{
	margin: 0;
	padding: 0;
	box-sizing:border-box;
	font-family: 'Montserrat', sans-serif;
}
.confirm-btn{
    border-radius: 3px;
    background: #3aa54c;
    color: #fff !important;
    display: block;
    font-weight: 700;
    font-size: 16px;
    line-height: 1.25em;
    margin: 24px auto 24px;
    padding: 10px 18px;
    text-decoration: none;
    width: 300px;
    letter-spacing: 1px;
    text-align: center;
}
table, th, td {
  border: 1px solid #e8e8e8;
  border-collapse: collapse;
  font-size: 13px;
  color: #666;
}
th, td {
  padding: 5px;
  text-align: left;
}
body p {
	color: #666;
	font-size: 14px;
}
</style>
</head>";
//$urlconfirm = $DB->site_url."welcome.php?userverify=".$token."&uid=";
$message .= '<body style="background:#e6e6e6">

  <div style="max-width:800px;margin:auto;margin-top:20px";>

    <div style="width:100%;background:#8c2d37 !important;border-radius:8px 8px 0 0;padding:10px;">
        <img src="https://odapto.com/images/logo.png" style="max-width:120px;margin:auto;display:block" >
    </div>
       <div style="background:#fff;width:100%;padding:20px 0;padding-bottom:0">
       	<p style="color:#333333;font:14px/1.25em ,Arial,Helvetica;font-weight:bold;line-height:20px;text-align:center;padding-left:56px;padding-right:56px"> Hey there! '.$sendername.' invited you to join the '.$board_title.' board on Odapto: </p>

<p style="text-align: center;margin-top: 10px;">In order to Join this Board , Please click the link</p>
    
    <a href="'.$invite_link.'" class="confirm-btn" target="_blank" >Join Board</a>
       	<div style="background:#fff;border:solid 1px #f0f0f0;margin-left:56px;margin-right:56px;border-radius:3px">
 <p style="line-height:20px;text-align:center;padding-left:24px;padding-right:24px;padding-top:17px"> I am working on this project in Odapto and wanted to share it with you! </p>
 <table style="background-color:#00aecc;border-radius:3px;font:14px/1.25em ,Arial,Helvetica;line-height: 12px;font-weight:bold;color:#ffffff;height: 168px;width: 298px;margin-top: 32px;"> <tbody>
  <tr> <td style="padding-left:8px;padding-right:8px;padding-top:4px;padding-bottom:0;color: black;"> '.$board_title.' </td> </tr>


  <tr> <td> <img src="https://odapto.com/images/board_elements.png" style="width:224px;height:91px;border-radius:1.55px;padding-left:8px;padding-right:8px;padding-bottom:8px" class="CToWUd"> </td> </tr> </tbody></table> </div> 
       	</div>';
        
			

$message .= '<div style="text-align:center;margin:30px 0">
				<p style="font:14px/1.25em ,Arial,Helvetica;color:#838c91;text-align:center;padding-left:56px;padding-right:56px;padding-bottom:8px"> Odapto boards help you put your plans into action and achieve your goals. <a href="https://www.odapto.com" style="color:#0079bf;text-decoration:none" target="_blank" >Learn more</a> </p>
			</div>

  </div>
</div> 

</body>
</html>';

	         

$fromemail = 'admin@odapto.com';
//	$retval = $db->sendEmail1($subject,$message,$email,$sendEmail1);
    $retval = $db->sendEmail1($subject,$message,$email,$fromemail);
	if($retval == 1){
		echo "Invited Successfully";
		exit();		
	}else{
		echo "Bugs";
	}	


	

