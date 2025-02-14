<?php

require_once('DBInterface.php');
$db = new Database();
$db->connect();
$fbid = "1272267359538385";
$message = $db->userFbData($fbid);

print_r($message);
