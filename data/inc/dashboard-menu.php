<?php  error_reporting(0);

?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <div class="col-sm-5">
      <ul class="nav navbar-nav">
      
     <li class="dropdown">
          <a id="login4">Board</a>
          <ul id="login-panel4" class="dropdown-menu scrollbar">
         <li> <a> <input type="text" class="form-control my-input" id="myInput" onkeyup="filterFunction()" placeholder="Find boards by name..."></a></li>
          
         <?php  
          $uid = $_SESSION['sess_login_id'];
          $star_result = $db->getStaredBoard($uid);
          $star_board = json_decode($star_result,true);
          if(sizeof($star_board) > 0) { ?>
          <li> <a class="accordion">Star Board</a>
            <div class="panel">
            <ul class="submenu">
              <?php  
              foreach ($star_board['starBoardData'] as $key => $value) {
              $board_url = $value['board_url'];
              $board_key = $value['board_key'];
              $Board_title = $value['title'];
              $bid = $value['board_id'];
              $url = SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key";
              ?>
              <li><a class="sublist" href="<?php echo $url ?>"><?php echo $Board_title; ?></a></li>
              <?php
              }
               ?> 
               </ul>
            </div>
          </li>
          <?php } ?>

         
          <?php  
            $uid = $_SESSION['sess_login_id'];
            $recent = $db->getRecentBoard($uid);
            $recent_board = json_decode($recent,true);
            if(sizeof($recent_board) > 0){
              ?>
               <li> <a class="accordion">Recent Board</a>
            <div class="panel">
          <ul class="submenu">
              <?php
               foreach ($recent_board['recentBoardData'] as $value) {
            $board_url = $value['board_url'];
            $board_key = $value['board_key'];
            $Board_title = $value['title'];
            $bid = $value['board_id'];
            $url = SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key";
            ?>
        <li><a class="sublist" href="<?php echo $url ?>"><?php echo $Board_title; ?></a></li>
      <?php   
            }
           ?>
           </ul>
    </div></li>
           <?php
      }
    ?> 
          
          
          <?php  
            $uid = $_SESSION['sess_login_id'];
            $personal = $db->getUserBoard($uid);
            $personal_board = json_decode($personal,true);
            if(sizeof($personal_board) > 0){
              ?>
               <li><a class="accordion" >Personal Boards</a>
            <div class="panel" >
              <ul class="submenu">
              <?php
               foreach ($personal_board['BoardData'] as $key => $value) {
            $board_url = $value['board_url'];
            $board_key = $value['board_key'];
            $Board_title = $value['title'];
            $bid = $value['board_id'];
            $url = SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key";
            ?>
              <li><a class="sublist" href="<?php echo $url ?>"><?php echo $Board_title; ?></a></li>
            <?php   
            }
            ?>
             </ul>
            </div></li>
            <?php
            }
          ?>

           <?php  
          $uid = $_SESSION['sess_login_id'];
          $team_result = $db->getUserTeamDetails($uid);
          $team_board = json_decode($team_result,true);
          if(sizeof($team_board) > 0) { 
            foreach ($team_board['teamData'] as $key => $value) {
               $team_url = $value['team_url'];
               $team_key = $value['team_key'];
               $team_title = $value['team_name'];
               $team_id = $value['team_id'];
               $bid = $db->getboardId($team_id);
               $board = $db->getBoardListByTid($bid);
          ?>
          <li> <a class="accordion"><?php echo $team_title; ?></a>
            <div class="panel">
            <ul class="submenu">
              <?php  
              foreach ($board['boardListData'] as $key => $value) {
                  $board_title = $value['board_title'];
                  $bstar = $value['board_star'];  
                  if($bstar == 0){
                    $star = "fa fa-star-o";
                  }else{
                    $star = "fa fa-star";
                  }
                  $board_url = $value['board_url'];
                  $board_key = $value['board_key'];
                  $board_id = $value['board_id'];
                  $url = SITE_URL."dashboard.php?page=board&b=$board_id&t=$board_url&k=$board_key";
              ?>
              <li><a class="sublist" href="<?php echo $url ?>"><?php echo $board_title; ?></a></li>
              <?php
              }
               ?> 
               </ul>
            </div>
          </li>
          <?php } }?>    

          <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#cre-board">Create new board</a></li>
          <li> <a href="#about">Always keep the menu open</a></li>
           <li>  <a>See closed boards</a></li>
          </ul>
        </li>

       <li style="margin-top:15px !important;"><div class="form-group">

  <input type="text" class="form-control form-control1" id="myinput" placeholder="">
  <i style="color:white" class="fa fa-search fonto" aria-hidden="true"></i>
</div></li>
      </ul>
      </div>
      <div class="col-sm-2 hidden-xs"> <a class="navbar-brand" href="<?php echo LOGIN_SITE_URL ?>?page=home"><img src="images/small-logo.png" class="img-responsive"></a></div>
       <div class="col-sm-5 c-b">
<ul class="nav navbar-nav pull-right">
<li class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-plus" aria-hidden="true"></i></a>
      <ul class="dropdown-menu">
      <li><h4 class="text-center">Create Boards</h4></li>
     <div class="col-xs-12 border"></div>
     <li> <a data-toggle="modal" data-target="#cre-board" href="#home">
     <p><small>Create Board...</small></p>
    <p><small>A board is a collection of cards
ordered in a list of lists. Use it to
manage a project, track a collection or
organize anything.</small></p></a>
 <div class="col-xs-12 border"></div>
 

    <a data-toggle="modal" data-target="#cre-team" href="#home">
     <p><small>Create Personal Team...</small></p>
    <p><small>A team is a group of boards and
people. Use it to group boards in your
company,team, or family.</small></p></a>


 <div class="col-xs-12 border"></div>
<a data-toggle="modal" data-target="#cre-busi" href="#home">
     <p><small>Create Business Team...</small></p>
    <p><small>With Business Class. your team has
more security administrative controls
and superpowers.</small></p></a>
      </ul>
        </li>
       <li class="dropdown">
          <?php  
          if(!empty($_SESSION['FBID'])){
            $profile_img = "https://graph.facebook.com/".$_SESSION['FBID']."/picture";
          }

          elseif(!empty($_SESSION['user_detaile']->pictureUrl)){
            $profile_img = $_SESSION['user_detaile']->pictureUrl;
          }
          else{
            $profile_img = "https://www.odapto.com/images/default.png";
          }
          ?>
          
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="position: relative;overflow:hidden">
          <span style="width:40px;height:40px;background: url('<?php echo $profile_img; ?>') no-repeat; background-size: cover; background-position: center center; display: inline-block; position: absolute; top: 0px; left: 0px;">
          </span>
          <span style="margin-left:40px;"><?php echo $_SESSION['fullname']; ?></span></a>
          <ul class="dropdown-menu">
     <li><a href="<?php echo LOGIN_SITE_URL ?>?page=profile">Profile</a></li>
    <li><a href="<?php echo LOGIN_SITE_URL ?>?page=profile&type=cards">Cards</a></li>
    
         <li><a href="javascript:void(0)" data-toggle="modal" data-target="#cre-board">Create new board</a></li>
          <li> <a  onclick="activeclassadd()" id="click_me">Settings</a></li>
          <li> <a href="#">Help</a></li>
          <!-- <li>  <a href="#">Shortcuts</a></li> -->
          <!-- <li> <a href="#">Change Language</a></li> -->
         <li>  <a href="logout.php">Log Out</a></li>
          </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
         <ul class="dropdown-menu for-left" >
          <li>
             <h4 class="text-center">Information</h4>
          </li>
          <li><div class="border"></div></li>
          <li>
          <a href="odaptoguide.php" target="blank">
          <img src="images/short-sett.jpg" class="img-responsive auto">
          </a>
          </li>
          <li>
          <div class="col-sm-8 col-sm-offset-2 check">
        <h5 class="text-center">New to Odapto? Check Out The  Guide</h5>
        <a style="color:#f56d39" class="text-center" href="#">Get a tip</a>
        </div>
        <div class="border"></div>
        <li>
        <ul class="list-inline info-list">
          <li><a href="tour.php" target="blank">Tour</a></li>
          <li><a href="pricing.php" target="blank">Pricing</a></li>
          <li><a href="#" target="blank">Apps</a></li>
          <li><a href="blog" target="blank">Blog</a></li>
          <li><a href="#">More..</a></li>
        </ul>
        </li>
          </li>
         </ul>
        </li>
        
        
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-bell-o" aria-hidden="true"></i></a>
         <ul class="dropdown-menu for-left">
          <li>
             <h4 class="text-center">Information</h4>
          </li>
          <div class="border"></div>
          <li><p class="text-center">No Notification</p></li>
          </ul>
          </li>
        
        
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-cog" aria-hidden="true"></i></a>
         <ul class="dropdown-menu" style="left:-190px;">
          <li>
             <h4 class="text-center">Information</h4>
          </li>
          <div class="border"></div>
          <li><p class="text-center">No Notification</p></li>
          </ul>
          </li>
<?php  
if($_REQUEST['page'] != "home"){
?>
<li class="dropdown"><a href="#" class="js-menuToggle"><i class="fa fa-bars" aria-hidden="true"></i></a></p></li>
<?php  
}
?>          
</ul>
      </div>
    </div>
  </div>
</nav>

<nav>
  <ul class="pushNav js-topPushNav">
<li><div class="openLevel js-openLevel hdg"><h2 class="text-center">Menu</h2></div></li>
  <div class="clearfix"></div>
    <div class="border1"></div>

    <?php  

$uid = $_SESSION['sess_login_id'];
if(isset($_REQUEST['b'])){
$bid = $_REQUEST['b'];
$admin = $db->getBoardAdmin($bid);
if($uid != $admin){
  $display = "none";
}else{
  $display = "block";
}

}else{
  if($_REQUEST['page'] == "team"){
    $display = "none";  
  }
}
    ?>

    <li class="dropdown" style="display: <?php echo $display; ?>">
    <div class="openLevel js-openLevel hdg">
    <a href="javascript:void(0)" id="inviteBtn" > <img src="images/ADD-MEMBER.png" style="margin-right: 16px;width: 16px;"> Add Members  </a>

    <ul id="inviteDiv" style="display:none;position: absolute; max-height:500px; background-color:#f1f1f1;padding: 10px;border-radius: 6px;">
    <li>
      <h4 style="color:#666;text-align: left;" class="text-center mem"> Members
      <span class="fa fa-times close-invite pull-right" style="font-size:16px;"></span>
      </h4>
      
    </li>
    <hr>
     <div class="clearfix"></div>
    <li>
    <input type="hidden" id="bid" value="<?php echo $_GET['b']; ?>">
  <input type="text" id="searchMember" name="searchMember" value="" class="form-control" placeholder="abc@odapto.com" style="width:100%;" onKeyup="return searchMember()">
  <a href="javascript:void(0)" class="pull-right"  style="margin-top:-32px;padding:7px 4px; display: none"> <span class="fa fa-search" style="font-size:18px;display:block;color: #000;"></span> </a>
    </li>
    <div class="clearfix"></div>

    <div id="result"></div>
    <div class="clearfix"></div>
    <li>
    <h5 id="textAdd" style="color:#666; text-align:justify">Search for a person in Odapto by email address, or enter an email address to invite someone new.</h5>
    </li>
    <hr>
    <li>
    <a id="link_model" style="color:#666;font-size: 14px; text-align:justify" href="javascript:void(0)">Invite people by giving them a special invitation link to join this board…</a>  
        </li>
          </ul>
    </div>
    </li>

    <div class="clearfix"></div>
    <div class="border1"></div> 

<!-- background color -->
<li>
<div class="openLevel js-openLevel hdg"> 
    <img src="images/chbg.png" style="margin-right: 16px;width: 16px;">
      Change Background
</div>
<ul class="pushNav pushNav_level js-pushNavLevel scrolly" style="overflow-y: scroll;">
<h4 class="text-center arro">
<span class="fa fa-long-arrow-left pull-left js-closeLevel"></span> 
<span style="padding-right:70px"> Choose Color</span></h4>
<div class="clearfix"></div>
<div class="border"></div>
<div class="clearfix"></div>
<h4>Dashboard Background</h4>         
<div class="col-sm-12">
 <?php  
  $color = array(
    "#f00",
    "#f52d39",
    "#f56d39",
    "#f5d26a",
    "#b3dbc0",
    "#2d907d",
    "#5893ab",
    "#3f9a69"
  );
  foreach ($color as $key => $value) {
 ?>
   <div class="col-sm-4" onclick="userbodyChange(this.id)" id="<?php echo $value; ?>">
    <div style="background:<?php echo $value; ?>" class="col-sm-12 red"></div>
  </div>
   <?php 
  }
  ?> 
</div>
<!-- change Board background -->
<div class="clearfix"></div>
<h4>Board Background</h4>
<div class="clearfix"></div>
<div class="col-sm-12">
  <?php  
  $color = array(
    "#f00",
    "#f52d39",
    "#f56d39",
    "#f5d26a",
    "#b3dbc0",
    "#2d907d",
    "#5893ab",
    "#3f9a69"
  );
foreach ($color as $key => $value) {
   ?>
   <div class="col-sm-4" onclick="boardbodyChange(this.id)" id="<?php echo $value; ?>">
    <div style="background:<?php echo $value; ?>" class="col-sm-12 red"></div>
  </div>
   <?php 
  }
  ?> 
</div>
<div class="clearfix"></div>
<h4>Choose Board Image</h4>
<div class="clearfix"></div>
<div class="col-sm-12">
 <?php  
 $response = $db->get_board_bg_img();
 foreach ($response as $key => $value) {
  
?>
 <div class="col-sm-4" onclick="boardbodyImage(this.id)" id="<?php echo $value; ?>" style="overflow:hidden">
   <div class="col-sm-12 red" style="background: url('https://www.odapto.com/admin/temp/images/<?php echo $value; ?>') no-repeat; background-position: center center;background-size: cover;width: 100%;"></div>
</div>
<?php
}
?>
</div>

  </ul>
</li>

    <div class="clearfix"></div>
    <div class="border1"></div>
    <li>
      <div class="openLevel js-openLevel hdg"> <img src="images/Filter-Card.png" style="margin-right: 16px;width: 16px;"> Filter Cards </div>
      <ul class="pushNav pushNav_level js-pushNavLevel">
      
        <li class="pushNav_level-label hdg"> <h4 class="text-center arro"><span class="fa fa-long-arrow-left pull-left js-closeLevel"></span> <span style="padding-right:70px"> Filter Cards</span></h4></li>
        <li>
       
        <div class="form-group">
             <input type="text" class="form-control" placeholder="Filter">
           </div>
           <p style="color:#fff">Type to filter by term or search for labels, members, or due times.</p>
        </li>
       
      </ul>
    </li>
    <div class="clearfix"></div>
    <div class="border1"></div>
    <li>
      <div class="openLevel js-openLevel hdg"> <img src="images/intregrate.png " style="margin-right: 16px;width: 16px;"> Integrate </div>
      <ul class="pushNav pushNav_level js-pushNavLevel">
       <h4 class="text-center arro"><span class="fa fa-long-arrow-left pull-left js-closeLevel"></span><span style="padding-right:70px"> Integrate</span></h4>
        <li>
       <div class="form-group top">
             <input type="text" class="form-control" placeholder="Filter">
           </div>
           <p style="color:#fff">Type to filter by term or search for labels, members, or due times.</p>
        </li>
     </ul>
    </li>
    
     <div class="clearfix"></div>
    <div class="border1"></div>
    <li>
      <div class="openLevel js-openLevel hdg"> 
    <img src="images/Stickers.png" style="margin-right: 16px;width: 16px;"> Stickers </div>
      <ul class="pushNav pushNav_level js-pushNavLevel">
      
         <h4 class="text-center arro"><span class="fa fa-long-arrow-left pull-left js-closeLevel"></span><span style="padding-right:70px"> stickers</span></h4>
        <li>
       <div class="form-group top">
             <input type="text" class="form-control form-control1" placeholder="Filter">
           </div>
           <p style="color:#fff">Type to filter by term or search for labels, members, or due times.</p>
	  <div class="col-sm-12 n-p">
	     <ul class="list-inline" >
    <?php 
$data=$db->my_data('stickers_images');

foreach ($data as $value) {
?>
 <li id="container1"><img style="width:40px" src="<?=$value['images']?>" id="my_drag<?=$value['id']?>" class="my_drag drag_box-item" ondragstart="dragStart(event)" draggable="true" id="dragtarget" /></li>
<?php 

}
 ?>


		 </ul>
	  </div>	   
        </li>
     </ul>
    </li>
    
    
    <div class="clearfix"></div>
    <div class="border1"></div>
    <li class="closeLevel js-closeLevelTop"> 
    <img src="images/Close.png" style="margin-right: 16px;width: 16px;">
     Close</li>
  </ul>
</nav>
<script type="text/javascript">

 function userbodyChange(elem){
    var color = elem;
    var id = $("#userid").val();
    var action = 'bg_color';
    $.ajax({
      url: './changeBgColor.php',
      type: 'POST',
      data: {action: action,color:color,id:id},
      success: function(rel){
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
      }
    })
 }
 
  function boardbodyChange(elem){
    var bg_color = elem;
    var bid = "<?php echo $_GET['b']; ?>";
    var redirect_url = "<?php echo $_SESSION['REQUEST_URI'];?>";
    //alert(redirect_url);
    $.ajax({
      url: './changeBgColor.php',
      type: 'POST',
      data: {action: 'board_bg_color',color:bg_color,bid:bid},
      success:function(rel){
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            window.location.href = redirect_url;
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
      }
    })
  }

  function boardbodyImage(elem){
    var bg_img = elem;
    var bid = "<?php echo $_GET['b']; ?>";
    var redirect_url = "<?php echo $_SESSION['REQUEST_URI'];?>";
    //alert(redirect_url);
    $.ajax({
      url: './changeBgColor.php',
      type: 'POST',
      data: {action: 'board_bg_image',image:bg_img,bid:bid},
      success:function(rel){
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            window.location.href = redirect_url;
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
      }
    })
  }

    function activeclassadd(){
     
      jQuery('.pull-right li').removeClass( "active" );
      jQuery('a[href="#Settings"]').parent('li').addClass('active');
      jQuery( "#home, #cards, #menu3" ).removeClass( "active in" );
      jQuery( "#Settings" ).addClass( "active in" );
   }
</script>
<style>
@media only screen and (max-width:768px) {
.c-b ul.pull-right{
	float:left !important;
}
}
</style>