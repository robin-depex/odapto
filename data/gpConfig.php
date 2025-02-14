<?php
session_start();
//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '159171472076-qb78oj68j2k0kp21c1s7s7icfhmrtvc1.apps.googleusercontent.com'; //Google client ID
$clientSecret = 'rjQbGf3Bo3t94mW_x47ngybF'; //Google client secret
$redirectURL = 'https://www.odapto.com/login.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to google+');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>