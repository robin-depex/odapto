<?php  
session_start();
define('SITE_URL','https://www.odapto.com/admin/');
if(empty($_SESSION['admin_auth'])){
  header("location:".SITE_URL);
}else{?>

<style type="text/css">
.onec:after {
    height: 23px;
    width: 2px;
    background: #fff;
    position: absolute;
    left: 7px;
    top: 16px;
    content: '';
    z-index: 9;} 

  .onec{     top: unset !important;  }

</style>
<?php include('header.php');
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

		case "add_sticker":
		include("add_sticker.php");
		break;

		case "board_img":
		include("board_img.php");
		break;	

		case "add_board_img":
		include("add_board_img.php");
		break;
		case "board_member_plan":
		include("membership_plan.php");
		break;
		case "users_subscription":
		include("users-subscription.php");
		break;
		case "live_chat":
		include("live_chat.php");
		break;
		case "live_chat_offline":
		include("live_chat_allusers.php");
		break;
		case "notification":
		include("push_notification/send_notification.php");
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
<script type="text/javascript">
    count_unseen_notifications();
    count_unseen_messages();
    /*setInterval(function(){
    		count_unseen_messages();
    		count_unseen_notifications();
    	
    	}, 50000);*/
    function count_unseen_messages()
    {
       var user_id=<?php echo $_SESSION['admin_id'] ?>;
      
        $.ajax({
    			url:"live_chat/count_unseen_message.php",
    			method:"POST",
    			data :{'user_id':user_id,'action':'unseen_message'},
    			success:function(data){
    			    console.log(data);
    				$('#count_user_msgs').html(data);
    			}
    		});
    }
    
    function count_unseen_notifications()
    {
       var user_to=<?php echo $_SESSION['admin_id'] ?>;
      
        $.ajax({
    			url:"live_chat/count_unseen_message.php",
    			method:"POST",
    			data :{'notify_user_to':user_to,'action':'unseen_notification'},
    			success:function(data){
    			    console.log(data);
    			    var obj = jQuery.parseJSON(data);
                      if(obj.result=="TRUE")
                      {
                          $('#count_user_notification').html(obj.count);
                          
                          $('#notifications_list').html(obj.list);
                      }
                      else{
                          
                      }
    				
    			}
    		});
    }
    
</script>