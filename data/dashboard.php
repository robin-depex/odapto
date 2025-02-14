<?php  
error_reporting(0);
ini_set('display_errors', 1);
require_once("common/config.php");
session_start();
if(empty($_SESSION['auth'])){
  header("location:".SITE_URL);
}else{

require_once("DBInterface.php");
$db = new Database();
$db->connect();

$uid = $_SESSION['sess_login_id'];
$result = $db->getUserMeta($uid);
if($_REQUEST['page'] == "home"){
	$bg_color = $result['bg_color'];
	$span_dis = "none";	
}
else if($_REQUEST['page'] == "board")
{
	$bid = $_REQUEST['b'];
	$backgound = $db->get_board_background($bid);
	//print_r($backgound);die();
	
	//echo $_SERVER['REQUEST_URI'];die();	
	$bg_type = $backgound['bg_type'];

	if($backgound['bg_color']!='' AND $backgound['bg_img']!=""){
		$bg_img = $backgound['bg_img'];
		$bg_color = "url('https://www.odapto.com/admin/temp/images/".$bg_img."')";
	}
	
	elseif ($backgound['bg_img']!="") {
		$bg_img = $backgound['bg_img'];
		$bg_color = "url('https://www.odapto.com/admin/temp/images/".$bg_img."')";
	}

	elseif ($backgound['bg_img']=='' AND $backgound['bg_color']!='') {
		$bg_color = $backgound['bg_color'];	
		$span_dis = "none";
		
	}
	
	else{
		$bg_color = $backgound['bg_color'];	
		$span_dis = "none";
	}

	// if($bg_type == "color"){
	// 	$bg_color = $backgound['bg_color'];	
	// 	$span_dis = "none";
	// }else if($bg_type == "img"){
	// 	$bg_img = $backgound['bg_img'];
	// 	$bg_color = "url('https://www.odapto.com/admin/temp/images/".$bg_img."')";
	// }else{
	// 	$bg_color = $result['bg_color'];	
	// 	$span_dis = "none";
	//}


	
	
}else{
	$bg_color = $result['bg_color'];
	$span_dis = "none";	
}




include("inc/dashboard-header.php");
include("inc/dashboard-menu.php");

if(!empty($_SERVER['QUERY_STRING'])){
if(!empty($_REQUEST['page'])){
$pagename = $_REQUEST['page'];	

	switch ($pagename)
	{
		
		case "home":
		include("home.php");
		break;	

		case "board":
		include("dashboard-content.php");
		break;	

		case "profile":
		include("profile.php");
		break;	

		case "team":
		include("team.php");
		break;

		default:
		include("404.php");
	}	 
	 

}else{
	include("404.php");

}
}else{
	include("home.php");
}

}
include("inc/dashboard-footer.php");
?>