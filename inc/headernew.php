<?php  
session_start();
// print_r($_SESSION);
require_once("./DBInterface.php");
$db = new Database();
$db->connect();
if(isset($_SESSION['auth'])){
 header("location:dashboard.php");
}
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title>Odapto</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="https://www.odapto.com/images/small-logo.png" sizes="16x16">
 <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/jquery.idealforms.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/ani.css">
      <link rel="stylesheet" href="css/animate.css">
      <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/homepage.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,400i,500,700" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body class="animated fadeIn">
 <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '128539921031141',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.9'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

