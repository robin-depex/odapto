<?php
//Database credentials
$dbHost = 'localhost';
$dbUsername = 'odapto_odapto';
$dbPassword = '(F-HPS!r0-[+';
$dbName = 'odapto_odapto';
//Connect with the database
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}
?>
