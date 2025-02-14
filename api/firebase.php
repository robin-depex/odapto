<?php
require_once './vendor/autoload.php';

use Kreait\Firebase\Factory;

// Initialize Firebase
$factory = (new Factory)->withServiceAccount('firebase-service-account.json');
$auth = $factory->createAuth();

return $auth;
?>
