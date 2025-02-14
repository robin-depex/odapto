<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->Host = 'smtp-relay.brevo.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mrabhishekpatel24@gmail.com';
    $mail->Password = 'FxgLC7MkhQ0pnSsb'; // Use environment variables in production
    $mail->SMTPSecure = 'AUTO';
    $mail->Port = 587;


    $mail->setFrom('admin@odapto.com', 'abhishek');

    $mail->addAddress('robinsingh252510@gmail.com');


    $mail->isHTML(true);
    $mail->Subject = 'test on local';
    $mail->Body = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if($mail->send()){
        echo '<script>alert("sent") </script>';
    } else {
        echo '<script>alert("not sent") </script>';
    }
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>