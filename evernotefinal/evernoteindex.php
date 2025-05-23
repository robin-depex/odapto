<?php
require 'src/autoload.php';

 //use EDAM\NoteStore\NoteFilter;
//use Evernote\Client;
use EDAM\NoteStore\NoteStoreClient;
 use EDAM\NoteStore\NoteFilter;
 use Evernote\Client;
session_start();

/** Understanding SANDBOX vs PRODUCTION vs CHINA Environments
 *
 * The Evernote API 'Sandbox' environment -> SANDBOX.EVERNOTE.COM 
 *    - Create a sample Evernote account at https://sandbox.evernote.com
 * 
 * The Evernote API 'Production' Environment -> WWW.EVERNOTE.COM
 *    - Activate your Sandboxed API key for production access at https://dev.evernote.com/support/
 * 
 * The Evernote API 'CHINA' Environment -> APP.YINXIANG.COM
 *    - Activate your Sandboxed API key for Evernote China service access at https://dev.evernote.com/support/ 
 *      or https://dev.yinxiang.com/support/. For more information about Evernote China service, please refer 
 *      to https://dev.evernote.com/doc/articles/bootstrap.php
 *
 * For testing, set $sandbox to true; for production, set $sandbox to false and $china to false; 
 * for china service, set $sandbox to false and $china to true.
 * 
 */
$sandbox = true;
$china   = false;


$key      = 'dharma';
$secret   = 'cf0e2248025eb291';
$callback = 'https://www.odapto.com/evernotefinal/EDAMTest.php';
//$callback = $_SESSION['curent_page'];

try {
/*	if(!empty($_SESSION['oauth_token'])){

		$token = $_SESSION['oauth_token'];
	}else{
		$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox, false, $china);
		$oauth_data  = $oauth_handler->authorize($key, $secret, $callback);
		//print_r($oauth_data);
    $_SESSION['oauth_token'] = $oauth_data['oauth_token'];
    $_SESSION['edam_userId'] = $oauth_data['edam_userId'];
	}*/
	$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox, false, $china);
		$oauth_data  = $oauth_handler->authorize($key, $secret, $callback);
		//print_r($oauth_data);
    $_SESSION['oauth_token'] = $oauth_data['oauth_token'];
    $_SESSION['edam_userId'] = $oauth_data['edam_userId'];
    

//print_r($_SESSION);die;

} catch (Evernote\Exception\AuthorizationDeniedException $e) {
    //If the user decline the authorization, an exception is thrown.
    echo "Declined";
}
