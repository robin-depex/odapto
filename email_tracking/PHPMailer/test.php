<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
require("PHPMailerAutoload.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->SMTPSecure = "ssl"; 
$mail->Host = "plus.smtp.mail.yahoo.com";
$mail->Port = 465; // set the SMTP port
$mail->Username = "kapilsharma.undefined@yahoo.com";
$mail->Password = "21091988"; 
$mail->From = "kapilsharma.undefined@yahoo.com";
$mail->FromName = "kapil";
$mail->AddAddress("satyendra.yadav@xantatech.com");
$mail->Subject = "Test PHPMailer Message";
$mail->Body = "Hi! \n\n This was sent with phpMailer_example3.php.";
if(!$mail->Send())
{
    echo 'Message was not sent.';
    echo 'Mailer error: ' . $mail->ErrorInfo;
}
else
{
    echo 'Message has been sent.';
}
?>