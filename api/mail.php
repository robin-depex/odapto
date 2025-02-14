<?php
$to = "priyaitdeveloper64@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: webmaster@example.com" . "\r\n" .
"CC: somebodyelse@example.com";

echo mail($to,$subject,$txt,$headers);
?> 