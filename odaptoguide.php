<?php  
session_start();
require_once("DBInterface.php");
$db = new Database();
$db->connect();
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

<!-- Menu section -->

<div class="section" id="section0">
    <header class="wow fadeInDown" id="header">
  <div class="container">
     <div class="row">
       <div class="col-sm-12">
         <div class="col-sm-6 col-xs-4 logo"><img src="images/logo.png" class="img-responsive" /></div>
          <div class="col-sm-6 col-xs-8 login-list">
            <ul class="list-inline pull-right bttn"><!--<li><h4 class="en">EN <span class="caret"></h4></li>-->
               <li>
               <a href="https://www.odapto.com/dashboard.php?page=home" class="btn btn-danger">Go to Your Boards</a></li>
                
      </ul>
   </div>
</div>
<div class="clearfix"></div>  
<div class="pos">
<div class="col-lg-12 animated fadeInDown delay-02" data-animation="fadeInDown" data-animation-delay="02">
         <h2>Odapto Boards Into Living Applications</h2>
</div>
<div class="col-lg-12  animated fadeInDown delay-03" data-animation="fadeInDown" data-animation-delay="03">
  <h4>Power-Ups help teams meet their unique business needs through adaptable features and integrations.  </h4>
</div>
<div class="clearfix"></div>
  <div class="col-lg-6 col-lg-offset-3 text-center top  animated fadeInDown delay-04" data-animation="fadeInDown" data-animation-delay="04">
       <h3>Or build your own official Power-Up here!</h3>
  </div>
<div class="clearfix"></div>
 <h3 class="top animated fadeInDown delay-05" data-animation="fadeInDown" data-animation-delay="05">Already use Odapto? <a href="login.php">Log in</a>.</h3>
       </div>
    </div>
  </div>
 </header>
</div>

<!-- end menu section -->


<!-- main content -->

<div class="section" id="section1">
      <div class="container-fluid">
     <div class="row">
        <div class="col-sm-6 col-sm-offset-3 sec-para"><p style="color:#797979">The Marketing Team moves blog content through the editorial calendar
all the way from "Writing" to "Published." </p></div>
<div class="col-sm-12 n-p">
<div class="col-lg-12">
<div class="col-sm-12">
<img src="images/green.jpg" class="img-responsive auto" />
</div>
</div>
<div class="pos-bot text-center">
<div class="col-sm-6 col-sm-offset-3">
  <p>From startups to Fortune 500 companies, Odapto is the most visual
way for teams to collaborate on any project. </p>
</div>
<div class="col-lg-4 col-lg-offset-4 text-center top">
       <a href="#" class="btn btn-primary btn-block"><strong>Create Your Board </strong></a>
       </div>
</div>
</div>
     </div>
  </div>
    </div>
         
        
        
  <div class="section" id="section2">
    <div class="sectionn1">
  <div class="container">
      <div class="row">
         <div class="col-sm-12 text-center n-p">
           <div class="col-sm-6 col-sm-offset-3 sec-head text-center"><h1><strong>Information At A Glance</strong></h1>
              <p>Dive into the details by adding comments, attachments, and
more directly to Odapto cards. Collaborate on projects
from beginning to end.</p>
           </div>
           <div class="col-sm-12"><img src="images/bluejpg.jpg" class="img-responsive auto" /></div>
         </div>
       </div>
  </div>
</div>
  </div>
    
    
    
    <div class="section" id="section3">
    <div class="sectionn3">
<div class="container">
   <div class="row">
      <div class="col-sm-12 n-p">
         <div class="col-sm-6 n-p"><img src="images/setting.png" class="img-responsive" /></div>  
         <div class="col-sm-6 text-left re">
       <h3><strong>A Productivity Platform</strong></h3>
       <p>Integrate the apps your team already uses
directly into your workflow. Power-Ups turn
Odapto boards into living applications to meet
your team's unique business needs.</p>
      </div>    
      </div>
   </div>
</div>
</div>
</div>
  <div class="section" id="section4">
  <div class="sectionn4">
   <div class="container">
      <div class="row">
         <div class="col-sm-12 n-p ">
             <div class="col-sm-6 re"><h3><strong>Always In Sync</strong></h3>
               <p>No matter where you are, Odapto stays in sync across
all of your devices. Collaborate with your team anywhere,
from sitting on the bus to sitting on the beach.</p>
<ul class="list-inline top"><li><a href="#"><img src="images/app.png" class="img-responsive" /></a></li>
<li><a href="#"><img src="images/play.png" class="img-responsive" /></a></li>
</ul>
 </div>
             <div class="col-sm-6"><img src="images/group.png" class="img-responsive" /></div>
            <div 
         </div>
      </div>
   </div>
</div>
</div>
</div>
  </div>
  
<div class="section" id="section6">  
  <div class="sectionn2">
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12 n-p">
      <div class="col-sm-6 text-left re">
       <h3><strong>Work With Any Team</strong></h3>
       <p>Whether it’s for work, a side project or even the next
family vacation, Odapto helps your team stay
organized.</p>
      </div>
       <div class="col-sm-6 text-center n-p"><img src="images/lightbluejpg.jpg" class="img-responsive pull-right re-one" />
       </div>
    </div>
  </div>
</div>
</div>
 </div> 

 
<!-- end main content part -->

<!-- footer part start -->

<div class="section" id="section5">
  <div class="sectionn5">
   <div class="container">
     <div class="row">
       <div class="col-sm-12">
         <div class="col-sm-8 col-sm-offset-2 text-center syns">
             <h2><strong>What are you waiting for?</strong></h2>
             <p class="syns">Sign up for free and become one of the millions of people around
the world who have fallen in love with Odapto. </p>
<div class="col-sm-4 col-sm-offset-4 text-center top">
       <a href="signup.php" class="btn btn-success" style="color: #fff">Sign up It`s Free</a>
       </div>
       <div class="clearfix"></div>
       <h4 class="text-center top">Already use Odapto?<span>
       <a href="login.php" style="color: #000">Log In</a></span></h4>
         </div>
       </div>
     </div>
   </div>
</div>
<div class="footer">
  <div class="container">
     <div class="row">
        <div class="col-sm-12 n-p">
          <div class="col-sm-10 col-sm-offset-1 text-center">
            <ul class="list-inline foot-link">
              <li><a href="#">Tour</a></li> |
              <li><a href="#">Pricing</a></li> |
              <li><a href="#">Apps </a></li> |
              <li><a href="#">Blog </a></li> |
              <li><a href="#">Help</a></li> |
               <li><a href="#">Legal </a></li> 
            </ul>
            <p>© Copyright 2016, Odapto. All rights reserved.</p>
          </div>
        </div>
     </div>
    </div>
   </div>
  </div>  
</div>



<script src="js/wow.js"></script>
<script src="js/script.js"></script>
<script src="js/classie.js"></script>
<script src="js/phoneSlideshow.js"></script>
<script>


wow = new WOW(
{
animateClass: 'animated',
offset:       100,
callback:     function(box) {
console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
}
}
);
wow.init();
document.getElementById('moar').onclick = function() {
var section = document.createElement('section');
section.className = 'section--purple wow fadeInDown';
this.parentNode.insertBefore(section, this);
};



</script>

</body>
</html>

<!-- end footer part -->