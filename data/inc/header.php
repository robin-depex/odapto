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
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>odapto</title>
     <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <meta name="author" content="Alvaro Trigo Lopez" />
  <meta name="description" content="fullPage full-screen navigation and sections control menu." />
  <meta name="keywords"  content="fullpage,jquery,demo,screen,fullscreen,navigation,control arrows, dots" />
  <meta name="Resource-type" content="Document" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
  <link rel="stylesheet" type="text/css" href="css/examples.css" />
    <link rel="stylesheet" href="css/style.css">
	  <link rel="stylesheet" href="css/component.css" />
      <link rel="stylesheet" href="css/ani.css">
      <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <!--[if IE]>
    <script type="text/javascript">
       var console = { log: function() {} };
    </script>
  <![endif]-->

  <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/scrolloverflow.js"></script>
  <script type="text/javascript" src="js/jquery.fullPage.js"></script>
  <script type="text/javascript" src="js/examples.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#fullpage').fullpage({
        anchors: ['firstPage', 'secondPage', '3rdPage'],
        sectionsColor: ['', '', ''],
        navigation: true,
        navigationPosition: 'right'
      });
    });
  </script>
<link rel="stylesheet" href="css/animate.css">
<style>
#section0{background: url(../images/banner.jpg) no-repeat;
 background-size:cover;
}
#section2{background:#2ec9f7;
}
.wow:first-child {
visibility: hidden;
}
.confirmBox{
    width:420px;
    height:100px;
    position:fixed;
    top:-50px;
    left:38%;
    background:#fdfdfd;
    border:1px solid rgba(0,0,0,0.3);
    z-index:99999999;
    display:none;
  }
  .yes{
    position: absolute;
    bottom: 6px;
    right: 54px;
  }
  .No{
    position: absolute;
    bottom: 6px;
    right: 10px;
  }
  .message{
    color:red;
  }

.close {
    float: right;
    position: absolute;
    font-size: 36px;
    right: -12px;
    top: -16px;
    font-weight: 400;
    width: 36px;
    height: 36px;
    background: #17473e !important;
    line-height: 1;
    border-radius: 50px;
    color: #c5c5c5;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity:1;
}
.modal-content{
  width:100%;
    float:left;}
</style>

</head>
<body>
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
<div class="confirmBox">
  <p class="message"></p>
</div>
<div id="fullpage">
