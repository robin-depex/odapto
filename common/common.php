<?php
class Common
{
   function cleaninput(){   
	   if(get_magic_quotes_gpc())
	   {
	   $_GET = array_map('stripslashes', $_GET);
	   $_POST= array_map('stripslashes', $_POST);
	   $_COOKIE= array_map('stripslashes', $_COOKIE);   
	   }  
   }
 function Push_Error($message){    
   $msg = '<div class="errorBox">'.$message.'</div>'; 
   $_SESSION['sess_error_mess']=$msg;   
   }   
    function Show_message($message){    
   $msg = '<div class="messageBox">'.$message.'</div>'; 
   $_SESSION['sess_mess']=$msg;   
   }
    function Show_messages($message){    
   $msg = $message;
   $_SESSION['sess_mess']=$msg;   
   }
    function Show_messages_success($message){    
   $msg = $message;
   $_SESSION['sess_mess_suess']=$msg;   
   }
function wtRedirect($location){
	header("location:".$location."");
	exit();
}    
   function SentMail($name,$from,$to,$cc,$bcc,$subject,$body){
     include_once("class.phpmailer.php");	 
	// $mail = new attach_mailer($name = "Olaf", $from = "your@mail.com", $to = "he@gmail.com", $cc = "", $bcc = "", $subject = "Test text email with attachments");
	 $mail = new attach_mailer($name,$from,$to,$cc,$bcc,$subject);
$mail->text_body = $body;
//$mail->add_attach_file("image.gif");
//$mail->add_attach_file("ip2nation.zip"); 
$mail->process_mail();
   }
   
   function GetFieldVal($fieldname,$tablename,$where,$value){
$result = mysql_query("SELECT ".$fieldname." FROM ".$tablename." WHERE  ".$where."='".$value."'");   
$row = mysql_fetch_array($result);
return ucfirst(stripslashes($row[$fieldname]));
}



   function GetFieldValues($fieldname,$tablename,$where,$value){
$result = mysql_query("SELECT ".$fieldname." FROM ".$tablename." WHERE  ".$where."='".$value."'");   
$row = mysql_fetch_array($result);
return $row[$fieldname];
}

function make_url($str)
{
	$url=strtolower(trim($str));	
	$url=str_replace('(','',$url);
	$url=str_replace('[','',$url);
	$url=str_replace(']','',$url);
	$url=str_replace(')','',$url);
	$url=str_replace('.','-',$url);
	$url=str_replace('&','and',$url);
	$url=str_replace('_','-',$url);
	$url=str_replace('   ','-',$url);
	$url=str_replace('  ','-',$url);
	$url=str_replace(' ','-',$url);
	$url=str_replace('=','-',$url);
	$url=str_replace('%','-',$url);
	$url=str_replace('$','-',$url);
	$url=str_replace('@','-',$url);
	$url=str_replace('_','-',$url);
	$url=str_replace('/','',$url);
	$url=str_replace('?','',$url);
	$url=str_replace('#','',$url);
	$url=str_replace('!','',$url);
	$url=str_replace('\ ','',$url);
	$url=str_replace('"','',$url);
	$url=str_replace('---','-',$url);
	$url=str_replace('--','-',$url);
	$url = preg_replace('/[^a-zA-Z0-9_ ]/s', '-', $url);
return $url;
}	 
}

function mysql_escapes($values){
$valuesGet = mysql_real_escape_string($values);
return $valuesGet;
}
?>