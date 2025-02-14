<?php  
session_start();
define('SITE_URL','https://www.odapto.com/admin/');
if(empty($_SESSION['admin_auth'])){
  header("location:".SITE_URL);
}else{

include('header.php');
include('sidebar.php');
include('topbar.php');


if(!empty($_SERVER['QUERY_STRING'])){
if(!empty($_REQUEST['page'])){
$pagename = $_REQUEST['page'];	
	switch ($pagename){
		
		case "home":
		include("main.php");
		break;	

		case "user":
		include("user/user.php");
		break;	
		
		case "adduser":
		include("user/adduser.php");
		break;

		case "cpass":
		include("user/cpass.php");
		break;	
		
		case "temp":
		include("temp/template.php"); 
		break;
		
		case "add_temp":
		include("temp/add_template.php");
		break;

		case "temp_list_cat":
		include("temp/tmp_category_list.php");
		break;
		
		case "temp_add_cat":
		include("temp/tmp_add_category.php");
		break;

		case "add_timg":
		include("temp/add_tmp_image.php");
		break;

		case "boards":
		include("temp/tmp_boards.php");
		break;

		case "temp_add_board":
		include("temp/tmp_add_board.php");
		break;
		
		case "temp_blist":
		include("temp/temp_blist.php");
		break;
		
		case "temp_add_blist":
		include("temp/temp_add_blist.php");
		break;
		
		case "boardcards":
		include("temp/tmp_board_cards_list.php");
		break;

		case "add_boardcards":
		include("temp/tmp_add_boardcards.php");
		break;	
		
		case "boardmaster":
		include("boardmaster.php");
		break;

		case "teammaster":
		include("teammaster.php");
		break;
		
		case "stickers":
		include("stickers.php");
		break;	
		
		default:
		include("404.php");
		
	}

}else{
	include("404.php");
}
}else{
	include("main.php");
}

//include('main.php');


include('footer.php');

}
?>