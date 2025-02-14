<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '236909236175-cni6dspr0gttffdkoi74146nlrmi47h1.apps.googleusercontent.com'; //Google client ID
$clientSecret = '4zXUkKnK-SjqdirLg-ziFTSx'; //Google client secret
$redirectURL = 'https://www.odapto.com/dashboard.php?page=home'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login to CodexWorld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>