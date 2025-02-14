
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

  <style>
body{
    font-family: 'Open Sans', sans-serif !important;
    font-size: 16px !important;
}
  </style>
<?php 
//session_start();
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


$authToken = $_REQUEST['oth_token'];
//echo $authToken;
$gid = $_REQUEST['gid'];
$bgid = $_REQUEST['bgid'];

$client = new Client(array('token' => $authToken, 'sandbox' => true));

$noteStore = $client->getNoteStore();
//print_r($noteStore);

// A global exception handler for our program so that error messages all go to the console
function en_exception_handler($exception)
{
   echo "Uncaught " . get_class($exception) . ":\n";
    if ($exception instanceof EDAMUserException) {
      // echo "Error code: " . EDAMErrorCode::$__names[$exception->errorCode] . "\n";
      // echo "Parameter: " . $exception->parameter . "\n";
    } elseif ($exception instanceof EDAMSystemException) {
      // echo "Error code: " . EDAMErrorCode::$__names[$exception->errorCode] . "\n";
      // echo "Message: " . $exception->message . "\n";
    } else {
      //  echo $exception;
    }
}
set_exception_handler('en_exception_handler');

// Real applications authenticate with Evernote using OAuth, but for the
// purpose of exploring the API, you can get a developer token that allows
// you to access your own Evernote account. To get a developer token, visit
// https://sandbox.evernote.com/api/DeveloperToken.action

$filter = new \EDAM\NoteStore\ NoteStore_findNotes_args();
 $fullNote = $noteStore->getNote($authToken, $gid, true, false, false, false);
 ?>

<title><?php echo $fullNote->title;?></title>
<body>
    <br><br><br>
 <div class="container">
<div class="row">
<div class="col-sm-12">
 <div class="panel panel-primary">
      <div class="panel-heading"><?php echo $fullNote->title;?></div>
      <div class="panel-body"><?php echo $fullNote->content;?></div>
    </div>
</div>
 </div>
 </div>
</body>
    

       




