<?php
$message = 'Testing Notification';
$badge = 3;
$sound = 'default';   //or put sound filename
$development = true;  //Change the $development boolean to switch between development and production pushes
 
$payload = array();
$payload['aps'] = array('alert' => $message, 'badge' => intval($badge), 'sound' => $sound);
$payload = json_encode($payload);
 
$apns_url = NULL;
$apns_cert = NULL;
$apns_port = 2195;
 
if($development)
{
  $apns_url = 'gateway.sandbox.push.apple.com';
	$apns_cert =  __DIR__.'/odaptoDevApns.pem';
}
else
{
	$apns_url = 'gateway.push.apple.com';
	$apns_cert =  __DIR__.'/odaptoDevApns.pem';
}
 
$stream_context = stream_context_create();
stream_context_set_option($stream_context, 'ssl', 'local_cert', $apns_cert);
 
$apns = stream_socket_client('ssl://' . $apns_url . ':' . $apns_port, $error, $error_string, 2, STREAM_CLIENT_CONNECT, $stream_context);
 
//	You will need to put your device tokens into the $device_tokens array yourself
$device_tokens = array("7380b09a455d8651f05b360b85fd7ccd093a15613f53aeb0b31390c70d3db746");
 
foreach($device_tokens as $device_token)
{
	$apns_message = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $device_token)) . chr(0) . chr(strlen($payload)) . $payload;
    $result=	fwrite($apns, $apns_message);
}
 
@socket_close($apns);
@fclose($apns);
if($result > 0)
    {
        echo "success";
    }else{
        echo "fail";
    }
?>