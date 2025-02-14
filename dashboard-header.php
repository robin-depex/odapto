<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> Odapto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="stylesheet" href="./css/bootstrap.min.css">-->
	    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	 <link rel="stylesheet" href="css/fontawesome.css" />
  <link rel="stylesheet" href="css/responsive.css" />
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="css/style.css" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <meta name="author" content="Odapto | Odapto enables to work smarter" />
  <meta name="description" content="Cards are the new creative canvas, Everyone is moving into personalised or shared cards, Use the templates to have a quick start" />
  <meta name="keywords"  content="Sales Managment system, File Managment system, Time Managment system, Review Managment system, Create Card ,Create list" />
  <meta name="Resource-type" content="Document" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
  <link rel="stylesheet" type="text/css" href="css/examples.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/ani.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <script src="js/nicescroll.js"></script>
    <!--[if IE]>
    <script type="text/javascript">
       var console = { log: function() {} };
    </script>
  <![endif]-->
    <script src="js/custom.js"></script>
    <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/scrolloverflow.js"></script>
  <script type="text/javascript" src="js/jquery.fullPage.js"></script>
  <script type="text/javascript" src="js/examples.js"></script>
   
<link rel="stylesheet" href="css/animate.css">

<!--  flip js -->
<script src="js/modernizr.js"></script>
<!-- flip js ends -->
<style>
.wow:first-child {
visibility: hidden;
}

</style>
</head>
<body style="background:<?php echo $bg_color; ?> no-repeat;background-size: cover;background-position: center center; fixed">
<span style="position: absolute;width: 100%;height: 100%;background: rgba(0,0,0,0.34);display: <?php echo $span_dis ?>"></span>
 <script>
$(document).ready(function () {
if (window.location.href.indexOf('#_=_') > 0) {
window.location = window.location.href.replace(/#.*/, '');
}});
 
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
<span class="screen"></span>
<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
<input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>"> 