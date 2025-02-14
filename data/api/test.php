<?php
$result = shell_exec('getmac /fo csv /v');
preg_match('~{(.*?)}~', $result, $output);
$device_id = $output[1];
echo $device_id;
echo "####################################";
echo "<br>";
echo $host = $_SERVER['SERVER_NAME'];
