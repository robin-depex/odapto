<?php
session_start();
//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
//$clientId = '159171472076-qb78oj68j2k0kp21c1s7s7icfhmrtvc1.apps.googleusercontent.com'; //Google client ID
//$clientSecret = 'rjQbGf3Bo3t94mW_x47ngybF'; //Google client secret

//$clientId = '649854156531-l50vh5komqgr4u02fjafe6a4n2alqbd6.apps.googleusercontent.com'; //Google client ID 649854156531
$clientId = '649854156531-d6hj11s57t2ig7je3rcujkt4dhqeg40b.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'cWPo2N9BHAxPkz3RnkZZQf3M'; //Google client secret
//$clientSecret = 'nrGRmyDHxyzNwxIoEXKmkmiT'; //Google client secret
$redirectURL = 'https://odapto.com/login.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to google+');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>