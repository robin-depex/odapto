<?php
/*$result = shell_exec('getmac /fo csv /v');
preg_match('~{(.*?)}~', $result, $output);
$device_id = $output[1];
echo $device_id;
echo "####################################";
echo "<br>";
echo $host = $_SERVER['SERVER_NAME']; */

$token_id='erT5oX76qEY:APA91bHi8cOXxg_gd40zpJhT8W0fAkpRaeTHIjSNxatulPEwHYAElnuMJz0x0BFxLegYVV4X6BEP5H0N9nrBVTlqqEoWqRuqlhfnxuE9eslFbF__Db6r71H-M9T7UiSkE3-uGpTRhaNR';
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyAfU9-cx8fjT9Wd_X6gbwMmXTpALFCKmgQ' );
$registrationIds = array( $token_id );
// prep the bundle
$msg = array
(
	'message' 	=> 'here is a message. message',
	'title'		=> 'This is a title. title',
	'subtitle'	=> 'This is a subtitle. subtitle',
	'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon'
);
$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
);
 
$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
//echo $result;
