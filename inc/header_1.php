<?php  
require_once("./common/config.php");
require_once("./common/encryption.php");

$enc = new Encryption();
if(isset($_SESSION['auth'])){
  header("location:dashboard.php");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>odapto</title>
     <meta charset="utf-8">
      <link rel="icon" href="https://www.odapto.com/images/small-logo.png" sizes="16x16">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php SITE_URL ?>/css/style.css" />
  <link rel="stylesheet" href="<?php SITE_URL ?>/css/responsive.css" />
  <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
  <meta name="author" content="Odapto" />
  <meta name="description" content="Odapto enables to work smarter, Cards are a great medium for communicating quick stories. Think about flipping through, each board telling it’s own little tale. Cards let’s you focus on the important stuff." />
  <meta name="keywords"  content="A productivity Platform, Online work management,File Managment system, Time Managment system" />
  <meta name="Resource-type" content="Document" />
    <link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
  <link rel="stylesheet" type="text/css" href="css/examples.css" />
    <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/ani.css">
      <link href="//fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
      <link rel="stylesheet" href="css/jquery.idealforms.css">
     
  <!--[if IE]>
    <script type="text/javascript">
       var console = { log: function() {} };
    </script>
  <![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/scrolloverflow.js"></script>
  <script type="text/javascript" src="js/jquery.fullPage.js"></script>
  <script type="text/javascript" src="js/examples.js"></script>
    
<link rel="stylesheet" href="css/animate.css">
<style>
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
<div class="confirmBox">
  <p class="message"></p>
  <button class="btn btn-sm btn-danger yes" value="Yes">Yes</button>
  <button class="btn btn-sm btn-success No" value="No">No</button>
</div>

