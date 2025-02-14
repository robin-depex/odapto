<?php 
$ip=$_SERVER['REMOTE_ADDR'];
$mac_string = shell_exec("arp -a $ip");
echo $mac_string;
$mac_array = explode(" ",$mac_string);
$mac = $mac_array[3];
echo($ip." - ".$mac);