<?php 
session_start();
 //error_reporting(0);
if(isset($_POST['submit'])){
    
    
    if(!empty($_FILES['image']['name'])){
        $img_name=md5(date('ymdhis').$_FILES['image']['name']);
        $path='https://odapto.com/board_img/' .$img_name;
        move_uploaded_file($_FILES['image']['tmp_name'], './board_img/' .$img_name);
        
    }
    
    date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d H:i:s");
            $status = 1;
             $con = array(
                    'board_id' => $_SESSION['boardid']
                );
            $data = array();
            $updata = array();
            if(!empty($_FILES['image']['name'])){
                $data['bg_img']=$img_name;
                $updata['bg_img']=$img_name;
                $updata['bg_color']='';
                $updata['bg_type']='img';
            }else{
                 $data['bg_img']='';
                 $updata['bg_img']='';
                 $updata['bg_color']='#fff';
                 $updata['bg_type']='color';
            }
            
            
             if($db->insert("tbl_board_img",$data)){
                 $db->update("tbl_user_board",$updata, $con);
                    echo "added";
              
                }else{
                    $error .='Some thing Went Wrong';
                }
}

?>

<style>
    .panel {
       background-color:#1a1616; 
    }
</style>
<nav class="navbar navbar-inverse">
  <div style="padding:0" class="container-fluid">
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
          $userplan = $db->get_user_details($uid,'membership_plan');
         $owntotal_board = $db->count_rows_board($uid);
         $wheruser = array('ID' => $uid);
          $singluserdata = $db->get_single_data('tbl_users',$wheruser);
      
          //$uid = $_SESSION['sess_login_id'];
          $star_result = $db->getStaredBoard($uid);
          //echo "<pre>"; print_r($star_result);die;
          $star_board = json_decode($star_result,true);
          
          //print_r($star_board);
          if(isset($star_board) && sizeof($star_board) > 0) { ?>
          <li> <a class="accordion">Star Board</a>
            <div class="panel">
            <ul class="submenu">
              <?php  
              foreach ($star_board['starBoardData'] as $key => $value) {
              $board_url = $value['board_url'];
              $board_key = $value['board_key'];
              $Board_title = $value['title'];
              $bid = $value['board_id'];
              $url = "dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key";
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
         //   print_r($recent_board);
            if(isset($recent_board) && sizeof($recent_board) > 0){
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
                    $url = "dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key";
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
            if(isset($star_board) && sizeof($personal_board) > 0){
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
                            $url = "dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key";
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
 

          <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#cre-board">Create new board</a></li>
          <li> <a href="#about">Always keep the menu open</a></li>
           <li> <a>See closed boards</a></li>
          </ul>
        </li>

       <li style="margin-top:15px !important;"><div class="form-group">
           
    <?php
        if(isset($_REQUEST['page']) && $_REQUEST['page'] == "board")
        { ?>
            <input type="text" class="form-control form-control1" id="search_board_list" placeholder=" search"><i style="color:white" class="fa fa-search fonto" aria-hidden="true"></i>
      <?php  }
      if(isset($_REQUEST['page']) && $_REQUEST['page'] == "home" || ($_SERVER['SCRIPT_NAME']=="/dashboard.php" && empty($_SERVER['QUERY_STRING'])) )
        { ?>
            <input type="text" class="form-control form-control1 search_board"  placeholder=" search"><i style="color:white" class="fa fa-search fonto" aria-hidden="true"></i>
      <?php  }
      
      
    ?>
    
  
</div></li>
      </ul>
      </div>
      <div class="col-sm-2 hidden-xs"> <a class="navbar-brand" href="dashboard.php"><img src="images/small-logo.png" class="img-responsive"></a></div>
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
     <p><small>Create  Team...</small></p>
    <p><small>A team is a group of boards and
people. Use it to group boards in your
company,team, or family.</small></p></a>

<!-- 
 <div class="col-xs-12 border"></div>
<a data-toggle="modal" data-target="#cre-busi" href="#home">
     <p><small>Create Business Team...</small></p>
    <p><small>With Business Class. your team has
more security administrative controls
and superpowers.</small></p></a> -->
      </ul>
        </li>
       <li class="dropdown">
          <?php 
 $user_data=$db->userdata();

if(empty($user_data['profile_pic_type'])){
 $profile_img = "https://www.odapto.com/images/default.png";
}else{
if($user_data['profile_pic_type']=='file'){
 $profile_img="https://www.odapto.com/user_profile_Image/".$user_data['profile_pics'];
}else if($user_data['profile_pic_type']=='url'){
   $profile_img=$user_data['profile_pics'];
}
}

          ?>
          
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="position: relative;overflow:hidden">
          <span id="profile_pic" style="width:40px;height:40px;background: url('<?php echo $profile_img; ?>') no-repeat; background-size: cover; background-position: center center; display: inline-block; position: absolute; top: 0px; left: 0px;">
          </span>
          <span style="margin-left:40px;"><?php echo $user_data['Full_Name']; ?></span></a>
          <ul class="dropdown-menu">
     <li><a href="dashboard.php?page=profile">Profile</a></li>
 <li><a href="pricing.php">Pricing</a></li>
    <!--<li><a href="<?php echo LOGIN_SITE_URL ?>?page=profile&type=cards">Cards</a></li>-->
    
         <li><a href="javascript:void(0)" data-toggle="modal" data-target="#cre-board">Create new board</a></li>
         <!--  <li> <a  onclick="activeclassadd()" id="click_me">Settings</a></li> -->
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
          <li><a href="#" target="blank">Blog</a></li>
         <!-- <li><a href="#">More..</a></li>-->
        </ul>
        </li>
          </li>
         </ul>
        </li>
        
        
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-bell-o" aria-hidden="true" id="count_user_notification"> </i></a>
         <ul class="dropdown-menu for-left" id="notifications_list">
         <!-- notification comming from ajax  -->
          
         
          
          
          </ul>
          </li>
        
        
       <!-- <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-cog" aria-hidden="true"></i></a>
         <ul class="dropdown-menu" style="left:-190px;">
          <li>
             <h4 class="text-center">Information</h4>
          </li>
          <div class="border"></div>
          <li><p class="text-center">No Notification</p></li>
          </ul>
          </li>-->

<li class="dropdown"><a href="#" class="js-menuToggle"><i class="fa fa-bars" aria-hidden="true"></i></a></p></li>
         
</ul>
      </div>
    </div>
  </div>
</nav>

<nav>
  <ul class="pushNav js-topPushNav">
<li><div class="openLevel js-openLevel hdg"><h2 class="text-center">Menu</h2></div></li>
  

    <?php  

$uid = $_SESSION['sess_login_id'];
if(isset($_REQUEST['b'])){
$bid = $_REQUEST['b'];
$admin = $db->getBoardAdmin($bid);
//print_r($admin);
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
<?php  
if($_REQUEST['page'] == "board"){
?>
<div class="clearfix"></div>
    <div class="border1"></div>
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
  <input type="text" id="searchMember" name="searchMember" value="" class="form-control" placeholder="abc@odapto.com" style="width:100%;" autocomplete="off"  onKeyup="return searchMember()">
  <a href="javascript:void(0)" class="pull-right"  style="margin-top:-32px;padding:7px 4px; display: none"> <span class="fa fa-search" style="font-size:18px;display:block;color: #000;"></span> </a>
    </li>
    <div class="clearfix"></div>

    <div id="result"></div>
    <div class="clearfix"></div>
    <li>
    <h5 id="textAdd" style="color:#666; text-align:left;line-height:24px">Search for a person in Odapto by email address, or enter an email address to invite someone new.</h5>
    </li>
    <hr>
    <li>
    <a id="link_model" style="color:#666;font-size: 14px; text-align:left;line-height:24px" href="javascript:void(0)">Invite people by giving them a special invitation link to join this board…</a>  
        </li>
          </ul>
    </div>
    </li>
<?php } ?>
    <div class="clearfix"></div>
    <div class="border1"></div> 

<!-- background color -->
<li>
<div class="openLevel js-openLevel hdg"> 
    <img src="images/chbg.png" style="margin-right: 16px;width: 16px;">
    <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   // echo $actual_link;
 ?>  Change Background
</div>
<ul class="pushNav pushNav_level js-pushNavLevel scrolly" style="overflow-y: scroll;">
<h4 class="text-center arro">
<span class="fa fa-long-arrow-left pull-left js-closeLevel"></span> 
<span style="padding-right:70px"> Choose Color</span></h4>
<div class="clearfix"></div>
<div class="border"></div>
<div class="clearfix"></div>

<?php if($_REQUEST['page'] != "board"){  ?>
<h4>Dashboard Background</h4>     
<div class="col-sm-12">
 <?php  $getbackcolor = $db->get_data('tbl_background_color',array('status'=>1));

  foreach ($getbackcolor as $value) {
 ?>
   <div class="col-sm-4" onclick="userbodyChange(this.id)" id="<?php echo $value['color']; ?>">
    <div style="background:<?php echo $value['color']; ?>" class="col-sm-12 red"></div>
  </div>
   <?php 
  }
  ?> 
</div>

<?php } ?>
<!-- change Board background -->
<?php if($_REQUEST['page'] == "board"){
  ?>
<div class="clearfix"></div>
<h4>Board Background</h4>
<div class="clearfix"></div>
<div class="col-sm-12">
  <?php  
 $getbordbackcolor = $db->get_data('tbl_background_color',array('status'=>1));

  foreach ($getbordbackcolor as $value) {
   ?>
   <div class="col-sm-4" onclick="boardbodyChange(this.id)" id="<?php echo $value['color']; ?>">
    <div style="background:<?php echo $value['color']; ?>" class="col-sm-12 red"></div>
  </div>
   <?php 
  }
  ?> 
</div>
<?php 
} 
//if($_REQUEST['page'] == "board"){
?>
<div class="clearfix"></div>
<h4>Choose Board Image</h4>
<div class="clearfix"></div>
<div class="col-sm-12">
 <?php  
 $response = $db->get_board_bg_img();
 foreach ($response as $key => $value) {
  
?>
 <div class="col-sm-4" onclick="boardbodyImage(this.id)" id="<?php echo $value; ?>" style="overflow:hidden">
   <div class="col-sm-12 red" style="background: url('<?php echo SITE_URL; ?>/board_img/<?php echo $value; ?>') no-repeat; background-position: center center;background-size: cover;width: 100%;"></div>
</div>
<?php
}
?>

</div>


<div class="col-sm-12">
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image">
        <input type="submit" class="btn btn-primary" value="Upload" name="submit">
    </form>

</div>
<?php //} ?>
  </ul>
</li>
<?php  
/*if($_REQUEST['page'] != "home"){
?>
    <div class="clearfix"></div>
    <div class="border1"></div>
    <li>
      <div class="openLevel js-openLevel hdg"> <img src="images/Filter-Card.png" style="margin-right: 16px;width: 16px;"> Filter Cards </div>
      <ul class="pushNav pushNav_level js-pushNavLevel">
      
        <li class="pushNav_level-label hdg"> <h4 class="text-center arro"><span class="fa fa-long-arrow-left pull-left js-closeLevel"></span> <span style="padding-right:70px"> Filter Cards</span></h4></li>
        <li>
       
        <div class="form-group">
             <input type="text" class="form-control" placeholder="Filter" id="filter_cards" name="filter_cards"  onKeyup="return filter_cards()">
           </div>

            <div id="filtercard_result"></div>
           <p style="color:#fff">Type to filter by term or search for labels, members, or due times.</p>
        </li>
       
      </ul>
    </li>
    <?php }*/ ?>
    <div class="clearfix"></div>
    <div class="border1"></div>
    <li>
      <div class="openLevel js-openLevel hdg"> <img src="images/intregrate.png " style="margin-right: 16px;width: 16px;"> Integration </div>
      <ul class="pushNav pushNav_level js-pushNavLevel">
       <h4 class="text-center arro"><span class="fa fa-long-arrow-left pull-left js-closeLevel"></span><span style="padding-right:70px"> Integration</span></h4>
       <?php $integrate_data = $db->getsingledata('tbl_user_board','board_id',$_REQUEST['b']);
//print_r($integrate_data);
 ?>
        <li>
          <div class="form-group top">
             <input type="text" class="form-control" placeholder="Filter">
           </div>
         <p style="color:#fff">Type to filter by term or search for labels, members, or due times.</p>   
     
   
<?php

//print_r($singluserdata);
 if($singluserdata['membership_plan']!=1){ ?>
<div class="drive-section">
      <div class="col-sm-7">
       <img class="img-responsive" src="images/google-drive-banner.jpg">
       </div>
       <div style="padding: 0" class="col-sm-5">
       <div style="padding: 0" class="col-sm-12 d-pra"><p>Google Drive</p></div>
       <div style="padding: 0" class="googledrive col-sm-12">
 <?php
 if($singluserdata['googledrive']==0){ ?>
<input type="button" onclick = "changedrivestatus(1,'googledrive','ID',<?php echo $uid ?>)" class="drive-btn" style="background:#be360e" value="Disable">
 <!--<button class=" drive-btn" style="background:#be360e;">Disable</button>-->
<?php }else{ ?>

<input type="button" onclick = "changedrivestatus(0,'googledrive','ID',<?php echo $uid; ?>)" class="drive-btn" value="Enable">
  <!--<button class="drive-btn">Enable</button> -->
<?php } 

}else{ ?>
<div class="drive-section create-link1">
      <div class="col-sm-7">
       <img class="img-responsive create-link1" src="images/google-drive-banner.jpg">
       </div>
       <div style="padding: 0" class="col-sm-5">
       <div style="padding: 0" class="col-sm-12 d-pra"><p>Google Drive</p></div>
       <div style="padding: 0" class="googledrive col-sm-12">
<button class="drive-btn create-link1"><i class="fa fa-lock"></i></button> 
<?php } ?>
       </div>
       </div>
       <div class="clearfix"></div>
       <div class="col-sm-12">
       <p style="margin-top: 10px">
       Access all of your Drive files for a project directly from it’s Odapto card, or create and automatically attach new Drive files from a card.</p>
       </div>
     </div>

        <?php if($singluserdata['membership_plan']!=1){ ?>

       <div class="drive-section">
      <div class="col-sm-7">
       <img class="img-responsive" src="images/banners_dropbox1.png">
       </div>
       <div style="padding: 0" class="col-sm-5">
       <div style="padding: 0" class="col-sm-12 d-pra"><p>Dropbox</p></div>
       <div style="padding: 0" class="dropbox col-sm-12">
        <?php
if($singluserdata['dropbox']==0){ ?>
<input type="button" class="drive-btn" onclick = "changedrivestatus(1,'dropbox','ID',<?php echo $uid ?>)" style="background:#be360e" value="Disable">
 <!--<button class=" drive-btn" style="background:#be360e;">Disable</button>-->
<?php }else{ ?>
<input type="button" class="drive-btn" onclick = "changedrivestatus(0,'dropbox','ID',<?php echo $uid ?>)" value="Enable">
  <!--<button class="drive-btn">Enable</button> -->
<?php } 
}else{ ?>


       <div class="drive-section create-link1">
      <div class="col-sm-7">
       <img class="img-responsive create-link1" src="images/banners_dropbox1.png">
       </div>
       <div style="padding: 0" class="col-sm-5">
       <div style="padding: 0" class="col-sm-12 d-pra"><p>Dropbox</p></div>
       <div style="padding: 0" class="dropbox col-sm-12">

  <button class="drive-btn create-link1"><i class="fa fa-lock"></i></button>
<?php } ?>
      </div>
       </div>
         <div class="col-sm-12">
       <p style="margin-top: 10px">
       Access all of your Drive files for a project directly from it’s Odapto card, or create and automatically attach new Drive files from a card.</p>
       </div>
     </div>
    
      
<?php 
if($singluserdata['membership_plan']==3){ ?>
<div class="drive-section">
<div class="col-sm-7">
       <img class="img-responsive" src="images/evernotset.jpg">
       </div>
       <div style="padding: 0" class="col-sm-5">
       <div style="padding: 0" class="col-sm-12 d-pra"><p>Evernote</p></div>
       <div  style="padding: 0" class="evernote col-sm-12">
<?php
if($singluserdata['evernote']==0){ ?>
<input type="button" class="drive-btn" onclick = "changedrivestatus(1,'evernote','ID',<?php echo $uid ?>)" style="background:#be360e" value="Disable">
 <!--<button class=" drive-btn" style="background:#be360e;">Disable</button>-->
<?php }else{ ?>
<input type="button" class="drive-btn" onclick = "changedrivestatus(0,'evernote','ID',<?php echo $uid ?>)" value="Enable">
  <!--<button class="drive-btn">Enable</button> -->
<?php }
}else{ ?>
<div class="drive-section create-link1">
<div class="col-sm-7">
       <img class="img-responsive create-link1" src="images/evernotset.jpg">
       </div>
       <div style="padding: 0" class="col-sm-5">
       <div style="padding: 0" class="col-sm-12 d-pra"><p>Evernote</p></div>
       <div  style="padding: 0" class="evernote col-sm-12">
  <button class="drive-btn create-link1"><i class="fa fa-lock"></i></button>
<?php }
 ?>
      </div>
       </div>
         <div class="col-sm-12">
       <p style="margin-top: 10px">
       Access all of your Drive files for a project directly from it’s Odapto card, or create and automatically attach new Drive files from a card.</p>
       </div>
     </div>

          
        </li>
     </ul>
    </li>
    <?php  
if($_REQUEST['page'] == "board"){
?>
     <div class="clearfix"></div>
    <div class="border1"></div>
    <li>
      <div class="openLevel js-openLevel hdg"> 
    <img src="images/Stickers.png" style="margin-right: 16px;width: 16px;"> Stickers </div>
      <ul class="pushNav pushNav_level js-pushNavLevel">
      
         <h4 class="text-center arro"><span class="fa fa-long-arrow-left pull-left js-closeLevel"></span><span style="padding-right:70px"> stickers</span></h4>
        <li>
    <!--    <div class="form-group top">
             <input type="text" class="form-control form-control1" placeholder="Filter">
           </div> -->
           <!-- <p style="color:#fff">Type to filter by term or search for labels, members, or due times.</p> -->
    <div class="col-sm-12 n-p">
       <ul class="list-inline" >
    <?php 
$data=$db->my_data('stickers_images');

foreach ($data as $value) {
?>
 <li id="container1"><img style="width:60px" src="<?=$value['images']?>" id="my_drag<?=$value['id']?>" class="my_drag drag_box-item" ondragstart="dragStart(event)" draggable="true" id="dragtarget" /></li>
<?php 

}
 ?>


     </ul>
    </div>     
        </li>
     </ul>
    </li>

    <?php } ?>
    <div class="clearfix"></div>
    <div class="border1"></div>
   
    <li>
   <a href="dashboard.php?page=home&cat=featured"> <img src="images/templset.png" style="margin-right: 16px;width: 16px;"> Template </a>
  </li>
  <div class="clearfix"></div>
    <div class="border1"></div>
   
    <li>
   <a href="#"> <img src="images/helpset.png" style="margin-right: 16px;width: 16px;"> Help </a>
  </li>


  <div class="clearfix"></div>
    <div class="border1"></div>
   
    <li>
   <a href="dashboard.php?page=live_chat"> <img src="images/supportset.png" style="margin-right: 16px;width: 16px;"> Support </a>
  </li>

   <div class="clearfix"></div>
    <div class="border1"></div>
   <?php  
if($_REQUEST['page'] == "board"){
?>
    <li>
  <!-- <a href="#"> <img src="images/startnonfill.png" style="margin-right: 16px;width: 16px;"> Star Board </a>-->
   <?php 
$result4 = $db->getBoardDetails($bid);
if ($result4['board_star'] == 1) {
?>
<a href="javascript:void(0)" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$result4['board_star']; ?>" title="Click to star or unstar this board. Starred boards show up at the top of your boards list."> <img src="images/starfill.png" style="margin-right: 16px;width: 16px;"> Star Board </a>

  <?php
}else{
  ?>
  <a href="javascript:void(0)" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$result4['board_star']; ?>" title="Click to star or unstar this board. Starred boards show up at the top of your boards list."> <img src="images/startnonfill.png" style="margin-right: 16px;width: 16px;"> Star Board </a>

  <?php
}
 ?>
   <!--<a href="#"> <img src="images/startfill.png" style="margin-right: 16px;width: 16px;"> Star Board </a>-->
  </li>

   <div class="clearfix"></div>
    <div class="border1"></div>
   
    <li>
      <a href="javascript:void(0)" onclick="return copyBoard(this.id);" aria-hidden="true" id="copy_<?php echo $bid; ?>" > <img src="images/copybord.png" style="margin-right: 16px;width: 16px;"> Copy Board </a>
  </li>
  <?php } ?>
    <div class="clearfix"></div>
    <div class="border1"></div>
    <li class="closeLevel js-closeLevelTop"> 
    <img src="images/Close.png" style="margin-right: 16px;width: 16px;">
     Close</li>
  </ul>
</nav>
<script type="text/javascript">
function copyBoard(clicked){
      var id = clicked;
      var token = document.getElementById("token").value;
      var qstring = document.getElementById("qstring").value;
      var data = "copyDetails="+id+"&token="+token;
     // alert(data);
       $.ajax({
        url: "./copy_board.php",
        type: "POST",
        data: data,
        success: function(rel){
       //   alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            var redirect = "dashboard.php?page=home";
            //alert(redirect);
            window.location.href = redirect;
          }else if(obj.result=="FALSE"){
            $("#error").html(obj.message);
          }
        }
      });
      return false;
   }




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
               var redirect = "dashboard.php?page=home";
            //alert(redirect);
          //  window.location.href = redirect;
         $('body').css("background-color", color);
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
      }
    })
 }
 
function changedrivestatus(status,type,fname,fval){
 
 var addtype = 'drivestatus';
 $.ajax({
      url: './profile_ajax.php',
      type: 'POST',
      data: {status: status,type:type,fname:fname,fval:fval,addtype
        :addtype},
      success: function(rel){
       // alert(rel);
        var colon = "'";
     //  alert('<input type="button" onclick = "changedrivestatus(0,'+type+','+fname+','+fval+')" class="drive-btn" style="background:#be360e" value="Disable"');
        if(status==1){

$("."+type).html('<input type="button" onclick = "changedrivestatus(0,'+colon+type+colon+','+colon+fname+colon+','+fval+')"  class="drive-btn"  value="Enable">');
//$("."+type).html('<input type="button" onclick = "changedrivestatus(0,'+type+','+fname+','+fval+')" class="drive-btn" style="background:#be360e" value="Disable">');
        }else{
$("."+type).html('<input type="button" onclick = "changedrivestatus(1,'+colon+type+colon+','+colon+fname+colon+','+fval+')" style="background:red" class="drive-btn" value="Disable">');
        }
          /*var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }*/
      }
    })
}

  function boardbodyChange(elem){
    var bg_color = elem;
   // alert(bg_color);
    var bid = "<?php echo $_GET['b']; ?>";
    
    //alert(redirect_url);
    $.ajax({
      url: './changeBgColor.php',
      type: 'POST',
      data: {action: 'board_bg_color',color:bg_color,bid:bid},
      success:function(rel){
      //  alert(rel);
          var obj = jQuery.parseJSON(rel);
       // alert(obj);
          if(obj.result=="TRUE")
          {
            location.reload();
            
             $('body').css("background-color", bg_color);
            $(".error").html(obj.message).css('color', 'white'); 
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
      }
    })
  }

  function boardbodyImage(elem){
    var bg_img = elem;
    //alert(bg_img); return false;
    var bid = "<?php echo $_GET['b']; ?>";
    var id = $("#userid").val();
   
    //alert(redirect_url);
    $.ajax({
      url: './changeBgColor.php',
      type: 'POST',
      data: {action: 'board_bg_image',image:bg_img,bid:bid,id:id},
      success:function(rel){
          var obj = jQuery.parseJSON(rel);
          
          if(obj.result=="TRUE")
          {
            location.reload();
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
      jQuery( "#home, #cards, #menu3" ).removeClass( "active in" );function statedBoard(clicked){
      var id = clicked;
      var token = document.getElementById("token").value;
      var qstring = document.getElementById("qstring").value;
      var data = "bDetails="+id+"&token="+token;
      //alert(data);
       $.ajax({
        url: "star_board.php",
        type: "POST",
        data: data,
        success: function(rel){
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            var redirect = "dashboard.php?"+qstring;
            //alert(redirect);
            window.location.href = redirect;
          }else if(obj.result=="FALSE"){
            $("#error").html(obj.message);
          }
        }
      });
      return false;
   }
      jQuery( "#Settings" ).addClass( "active in" );
   }
   
   $("#bg_img").change(function(){
       var img = $('#bg_img').val().split('\\').pop();
       var token = document.getElementById("token").value;
       var qstring = document.getElementById("qstring").value;
        var bid = "<?php echo $_GET['b']; ?>";
        var uid = $("#userid").val();
       var data = "bg_img="+img+"&token="+token+"&bid="+bid+"&uid="+uid;
        $.ajax({
        url: "./board_backImg.php",
        type: "POST",
        data: data,
        success: function(rel){
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            var redirect = "dashboard.php?"+qstring;
            //alert(redirect);
            window.location.href = redirect;
          }else if(obj.result=="FALSE"){
            $("#error").html(obj.message);
          }
        }
      });
      
});
   
</script>
<style>
@media only screen and (max-width:768px) {
.c-b ul.pull-right{
  float:left !important;
}
}
#result > p {
  text-align: left !important;
  line-height: 24px;
}
.drive-section{
width: 100%;
    border-radius: 4px;
    float: left;
    margin: 20px 0;
    border: 1px solid #651821;
    padding: 0px 0;
}
.drive-btn{
    display: inline-block;
    padding: 4px 10px;
    background: #3c7a6e;
    border: 0;
    font-size: 13px;
    letter-spacing: 1px;
}
.d-pra{
    padding: 0;
    border-bottom: 1px solid #651821;
    margin-bottom: 8px;
}
.d-pra p{
    margin: 0;
    padding: 7px 0;
  }
.drive-section .col-sm-7 .img-responsive{
  width:100%;
  height:90px;
  object-fit:cover;
}
</style>

<script>
$(document).ready(function(){
  $('.create-link1').click(function(){
   // alert('hi');
    $('#cre-board_upgrade1').css('display','block');
  });


   $('#closeintter').click(function(){
        //alert('hi');
        $('#cre-board_upgrade1').css('display','none');
      });
      
      $('#count_user_notification').click(function(){
        ///alert('hi');
        var notify_user_to=<?php echo $_SESSION['sess_login_id']; ?>;
        //alert(notify_user_to);
         $.ajax({
            url: "live_chat/count_unseen_message.php",
            type: "POST",
            data: {'action':'seen_notification','notify_user_to':notify_user_to},
            success: function(rel){
              var obj = jQuery.parseJSON(rel);
              if(obj.result=="TRUE")
              {
                $('#count_user_notification').html(obj.count);
                $('#notifications_list').html(obj.list);
               
              }
            }
          });
          return false;
    
      });
      
      
});




   
</script>

<script>
$(document).ready(function(){
    //search cards & lists
  $("#search_board_list").on("keyup", function() {
    var value = $(this).val().toLowerCase();
   $(".dc_filter").filter(function() {
      $(this).toggle($('.dc_filter_val',this).val().toLowerCase().indexOf(value) > -1)
    }); 
  });
  
  //search board
  $(".search_board").on("keyup", function() {
    var value = $(this).val().toLowerCase();
   $(".board_filter").filter(function() {
      $(this).toggle($('.board_filter_val',this).text().toLowerCase().indexOf(value) > -1)
    }); 
  });
  
});
</script>




<div class="modal" id="cre-board_upgrade1" role="dialog" style="display: none; padding-right: 15px;">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeintter" data-dismiss="modal">×</button>
          <h4 class="modal-title text-center" style="font-size: 16px;">You are right now a free version user and you need to upgrade your account to be able to use these features, so kindly upgrade from the option below</h4>
        </div>
        <button class="btn btn-info top"><a href="pricing.php">Upgrade</a></button>
        <div class="border"></div>
      </div>
    </div>
  </div>