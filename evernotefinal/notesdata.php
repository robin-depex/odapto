<?php 
session_start();
//
// A simple command-line Evernote API demo script that lists all notebooks in
// the user's account and creates a simple test note in the default notebook.
//
// Before running this sample, you must fill in your Evernote developer token.
//
// To run:
//   php EDAMTest.php
//

// Import the classes that we're going to be using
use EDAM\Types\Data, EDAM\Types\Note, EDAM\Types\Resource, EDAM\Types\ResourceAttributes;
use EDAM\Error\EDAMUserException, EDAM\Error\EDAMErrorCode;
use Evernote\Client;

ini_set("include_path", ini_get("include_path") . PATH_SEPARATOR . "lib" . PATH_SEPARATOR);
require_once 'autoload.php';

require_once 'Evernote/Client.php';

require_once 'packages/Errors/Errors_types.php';
require_once 'packages/Types/Types_types.php';
require_once 'packages/Limits/Limits_constants.php';

// A global exception handler for our program so that error messages all go to the console
function en_exception_handler($exception)
{
    echo "Uncaught " . get_class($exception) . ":\n";
    if ($exception instanceof EDAMUserException) {
        echo "Error code: " . EDAMErrorCode::$__names[$exception->errorCode] . "\n";
        echo "Parameter: " . $exception->parameter . "\n";
    } elseif ($exception instanceof EDAMSystemException) {
        echo "Error code: " . EDAMErrorCode::$__names[$exception->errorCode] . "\n";
        echo "Message: " . $exception->message . "\n";
    } else {
        echo $exception;
    }
}
set_exception_handler('en_exception_handler');

// Real applications authenticate with Evernote using OAuth, but for the
// purpose of exploring the API, you can get a developer token that allows
// you to access your own Evernote account. To get a developer token, visit
// https://sandbox.evernote.com/api/DeveloperToken.action
$sandbox = true;
$china   = false;






/*try {
  if(!empty($_SESSION['oauth_token'])){

    $authToken = $_SESSION['oauth_token'];
}else{
require 'evernoteindex.php';
    $authToken = $_SESSION['oauth_token'];
  }
    



} catch (Evernote\Exception\AuthorizationDeniedException $e) {
    echo "Declined";
}*/

$authToken = $_SESSION['oauth_token'];
print_r($_SESSION['oauth_token']);
if ($authToken == "your developer token") {
    print "Please fill in your developer token\n";
    print "To get a developer token, visit https://sandbox.evernote.com/api/DeveloperToken.action\n";
    exit(1);
}

// Initial development is performed on our sandbox server. To use the production
// service, change 'sandbox' => true to 'sandbox' => false and replace your
// developer token above with a token from
// https://www.evernote.com/api/DeveloperToken.action
$client = new Client(array('token' => $authToken, 'sandbox' => true));

$userStore = $client->getUserStore();
//echo $authToken;
// Connect to the service and check the protocol version
$versionOK =
    $userStore->checkVersion("Evernote EDAMTest (PHP)",
         $GLOBALS['EDAM_UserStore_UserStore_CONSTANTS']['EDAM_VERSION_MAJOR'],
         $GLOBALS['EDAM_UserStore_UserStore_CONSTANTS']['EDAM_VERSION_MINOR']);
//print "Is my Evernote API version up to date?  " . $versionOK . "\n\n";
if ($versionOK == 0) {
    exit(1);
}

$noteStore = $client->getNoteStore();

$notebooks = $noteStore->listNotebooks();

    $filter = new \EDAM\NoteStore\ NoteStore_findNotes_args();
    $notes = $noteStore->findNotes($authToken, $filter, 0, 100); // Fetch up to 100 notes
      if (!empty($notes->notes)) {
          foreach ($notes->notes as $note) {
            
              $fullNote = $noteStore->getNote($authToken, $note->guid, true, false, false, false);
              echo "<pre>";
         //   print_r($fullNote);
              $everndata = array(
'title' => $fullNote->title,
'guid' => $fullNote->guid,
'notebookGuid' => $fullNote->notebookGuid,
                );
           $evernotedata[] = $everndata;
        echo $fullNote->title. "</br>";

//echo $fullNote->content;
          }

/*foreach ($notebooks as $notebook) {
echo "    * " . $notebook->name . "</br>";
 $filter->notebookGuid = $notebook->guid;

      
      }*/
     $_SESSION['evernote'] = $evernotedata;

}
//echo $_SESSION['curent_page'];
header('Location:'.$_SESSION['curent_page']);