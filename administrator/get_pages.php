<?php
$pagename = $_REQUEST['page'];
switch ($pagename)
{
case "email":
  include("email.php");
  break;
case "mobile":
   include("mobile.php");
  break;
case "help":
   include("help.php");
  break;
case "jobslist":
   include("jobslist.php");
  break;
case "addjob":
   include("addjob.php");
  break;
  
  
  case "profile":
   include("profile.php");
  break;
  
  case "membership":
   include("membership.php");
  break;
  
  case "passwords":
   include("change-password.php");
  break;
  case "logout":
   include("logout.php");
  break;
  
  
    case "download":
   include("downloads.php");
  break;
  
  case "applied_job":
   include("applied_job_by_candidate.php");
  break;
  
  case "search":
   include("search_candidate.php");
  break;
  case "condidate":
   include("candidates.php");
  break;
  
  
default:
 include("home.php");
}
?> 