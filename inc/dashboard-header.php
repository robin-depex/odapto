<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>odapto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://www.odapto.com/images/small-logo.png" sizes="16x16">
    <!--<link rel="stylesheet" href="./css/bootstrap.min.css">-->
	    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://www.odapto.com/js/bootstrap.min.js"></script>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://www.odapto.com/css/responsive.css" />
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="css/style.css" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <meta name="author" content="Odapto" />
  <meta name="description" content="Odapto enables to work smarter, Cards are a great medium for communicating quick stories. Think about flipping through, each board telling it’s own little tale. Cards let’s you focus on the important stuff." />
  <meta name="keywords"  content="A productivity Platform, Online work management,File Managment system, Time Managment system" />
  <meta name="Resource-type" content="Document" />
    <link rel="stylesheet" type="text/css" href="https://www.odapto.com/css/jquery.fullPage.css" />
  <link rel="stylesheet" type="text/css" href="https://www.odapto.com/css/examples.css" />
    <link rel="stylesheet" href="https://www.odapto.com/css/style.css">
    <link rel="stylesheet" href="https://www.odapto.com/css/ani.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <script src="js/nicescroll.js"></script>
    <!--[if IE]>
    <script type="text/javascript">
       var console = { log: function() {} };
    </script>
  <![endif]-->
    <script src="https://www.odapto.com/js/custom.js"></script>
   <script src="https://www.odapto.com/js/jquery.min.js"></script>
  <script src="https://www.odapto.com/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://www.odapto.com/js/scrolloverflow.js"></script>
  <script type="text/javascript" src="https://www.odapto.com/js/jquery.fullPage.js"></script>
  <script type="text/javascript" src="https://www.odapto.com/js/examples.js"></script>
   
<link rel="stylesheet" href="https://www.odapto.com/css/animate.css">

<!--  flip js -->
<script src="js/modernizr.js"></script>


<!-- flip js ends -->
<style>
.wow:first-child {
visibility: hidden;
}


.snow-bg {
   position: relative;
}

.snow-bg:after {
   content: '';
   display: block;
   position: absolute;
   z-index: 2;
   top: 0;
   left: 0;
   right: 0;
   bottom: 0;
   pointer-events: none;
   background-image: url('https://library.elementor.com/resources/christmas-snow-effect/s1.png'), url('https://library.elementor.com/resources/christmas-snow-effect/s2.png'), url('https://library.elementor.com/resources/christmas-snow-effect/s3.png');
    animation: snow 10s linear infinite;
}

@keyframes snow {
 0% {background-position: 0px 0px, 0px 0px, 0px 0px;}
 50% {background-position: 500px 500px, 100px 200px, -100px 150px;}
 100% {background-position: 500px 1000px, 200px 400px, -100px 300px;}
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