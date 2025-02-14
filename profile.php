<?php 

$result = $db->getUserMeta($uid);
// echo '<pre>';
// print_r($result);die;
$board = $db->getAllUserBoard($uid);

$invited_board_result = $db->getInvitedBoard($uid);
$invited_board = json_decode($invited_board_result,true);

$team_board = $db->getUserTeamDetails($uid);
if(isset($_REQUEST['type'])){
  $type = $_REQUEST['type'];
  if( $type == "cards"){
     $c_active = "active";
     $c_in = "in";
  }else{
     $active = "active";
     $in = "in";
  }
}else{
  $active = "active";
  $in = "in";
}
?>
<style type="text/css">
  .boardlist{
    color:#fff;margin:10px 0px;padding:0px 10px 10px 0px;width: 100%; 
    border-radius: 5px;
  }
  .boardlist:hover{
     background:rgba(253, 253, 253, 0.37);cursor: pointer;
  }
  .count{
    background: #000;
    color: #fff;
    border-radius: 2px;
    margin-left: 5px;
    padding: 0px 5px;
  }
  .heading_profile{
    color: #060606;
    background: rgba(245, 237, 237, 0.43);
    padding: 10px 15px;
    font-size: 18px;
  }
  /* popupbox css */
.popup-container{
  display: none;
    background-color: #fdfdfd;
    width: 330px;
    margin-bottom: 10px;
    z-index: 9999;
    position: absolute;
    top: 112px;
    right: 3px;
    padding-bottom: 20px;
}
.u-link {
    color: #42548e;
    border: 2px solid #fff;
    padding: 7px 26px;
    background: #fff;
    font-weight: bold;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 25px;
    margin-bottom: 50px !important;
    display: block;
    max-width: 200px;
    font-size: 17px;
    margin: 50px auto;
}
.popup-text{
  font-size: 15px;
  color: #7d7d7d;
  margin-left: 20px;
  display: inline-block;
 }
 .popup-list{
  margin:5px 0px;
  padding:3px;
  padding-left:15px;
  border-radius:4px;
 }
 .popup-list:hover{
  background: #e2e2e2;
  cursor: pointer;
 }
 .n-b{
  background: none;
 }
.col-sm-3.my-card {
  background: #fdfdfd;
  border:1px solid rgba(247, 247, 247, 0.58);
  margin:10px 10px;
  padding:15px;
  border-radius:8px;
  box-shadow:1px 1px 1px rgba(0,0,0,0.1);
}
.col-sm-4.heading-card {
    background:rgba(253, 253, 253, 0.37) ;
    padding:5px;
    border-radius:5px;
    width:100% 
}
.window-module .big-link:focus{
    color:#fff !important;
}

.head_title{
    margin-bottom: 15px;
    margin-top: 20px;
    padding:10px;
    padding-left: 10px !important;
}
</style>

<style>
body
{
 width:100%;
 margin:0 auto;
 padding:0px;
 font-family:helvetica;
 background-color:#0B3861;
}
#wrapper
{
 text-align:center;
 margin:0 auto;
 padding:0px;
 width:995px;
}
#output_image
{
 max-width:200px;
}
.u-link {
    color: #42548e !important;
    border: 2px solid #fff;
    padding: 7px 26px;
    background: #fff;
    font-weight: bold;
    letter-spacing: 2px;
    text-transform: uppercase;
    border-radius: 25px;
    margin-bottom: 50px !important;
    display: block;
    max-width: 200px;
    font-size: 17px;
    margin: 50px auto;
}
</style>
<div class="container">
    <div class="row">
    <div class="col-sm-12 top n-p">
<div class="col-sm-6 col-sm-offset-3">
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
  <div class="col-sm-3" style="position:relative;padding: 0px;">


    <img src="<?php echo $profile_img; ?>" style="width:136px;height: 136px;" id="profile_image">


    <div style="position: absolute;bottom: 0px; right: 0px; width:100%; background: rgba(0,0,0,0.5); text-align: center;padding:8px;display: <?php echo $display; ?>">
        <!--<a href="javascript:void(0)" onclick="return ShowAddProfile()"> Change </a>-->
        <a href="javascript:void(0)" data-toggle="modal" data-target="#AddProfile"> Change </a>
        </div>
<!--
    <div class="col-md-12 b-s popup-container" id="AddProfile" style="">
      <h6 class="popup-heading"> Upload profile <span class="close-div fa fa-times pull-right"></span></h6>
      <hr>
     
      <div class="col-sm-12">
          <label> Profile Pic</label>
        <img id="output_image" style="width:136px;height: 136px; display:none;"/>
       <input type="file" class="form-control input-md " name="user" id="file" onchange="preview_image(event)" >
         
       
      </div>
    
    
      <div class="clearfix"></div>
    </div>  -->
    <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddProfile">Open Modal</button>-->
    <!-- dc code to ipload image via modal -->
    <div id="AddProfile" class="modal fade" role="dialog" style="">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload profile</h4>
          </div>
          <div class="modal-body">
            
          <label> Profile Pic</label>
            <img id="output_image" style="width:136px;height: 136px; display:none;"/>
           <input type="file" class="form-control input-md " name="user" id="file" onchange="preview_image(event)" >
           
          </div>
          
        </div>
    
      </div>
    </div>
    
    
    <!-- end -->
  </div>
  <div class="col-sm-4" id="profile" style="margin-left: 20px;">
      <p class="text-success" id="succ_msg"></p>
  <h4 style="color:#FFF"> <?php echo $user_data['Full_Name']; ?>  </h4>
 
    <span style="font-size: 14px;color:#FFF">
    <?php echo trim($result['user_name']); ?></span> </br> 
     <span style="font-size: 13px;color:#FFF">
    <?php if($user_data['membership_plan']==1){ echo 'Free';}elseif($user_data['membership_plan']==2){ echo 'Business';}elseif($user_data['membership_plan']==3){ echo 'Enterprise'; } ?> Membership</span>  

  <?php if(!empty($result['Bio'])){ ?>
  <p id="bio"><?php echo trim($result['Bio']); ?></p>
  <?php } ?>      
  <a onclick="return editprofile()" href="javascript:void(0)" class="list-btn">Edit Profile</a>
  </div>
<div class="col-sm-8" id="edit-pro" style="margin-left: 20px;">
<form action="" method="profile" id="profileForm">
  <div class="form-group" id="error"></div>
  <div class="form-group">
    <label for="email">Full Name</label>
    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo trim($result['full_name']); ?>">
  </div>
  <div class="form-group">
    <label for="pwd">Username:</label>
    <input type="text" class="form-control" id="username" name="username" value="<?php echo trim($result['user_name']); ?>">
  </div>
  <div class="form-group">
    <label for="pwd">Initials:</label>
    <input type="text" class="form-control" id="initials" name="initials" value="<?php echo trim($result['initials']); ?>">
  </div>
  <div class="form-group">
  <label for="comment">Bio (optional):</label>
  <textarea class="form-control" rows="5" id="bio" name="bio">
    <?php echo trim($result['Bio']); ?>
  </textarea>
  <input type="hidden" name="token_ses" id="token_ses" value="<?php echo $_SESSION['Tocken'] ?>">
</div>
  <button type="button" onclick="return update_profile()" class="btn btn-default">Submit</button>
  <button type="button" class="btn btn-default" onclick=" return closeDiv()">cancel</button>
</form>
</div>
</div>

<div class="clearfix"></div>
<ul class="nav nav-tabs pull-right">
    <li class="<?php echo $active; ?>">
    <a data-toggle="tab" href="#home">Profile</a></li>
    <li class="<?php echo $c_active; ?>"><a data-toggle="tab" href="#cards">Cards</a></li>
    <li><a data-toggle="tab" href="#Settings">Settings</a></li>
    <li><a data-toggle="tab" href="#menu3">Odapto Offers</a></li>
  </ul>
 <div class="clearfix"></div> 
 <div class="border"></div>
 <div style="    background: #184c43;color: #000;padding-bottom: 20px;padding-top:10px;" class="col-sm-10 col-sm-offset-1">
  <div class="tab-content">

    <div id="home" class="tab-pane fade <?php echo $active. " " . $in; ?>">
    <div class="row jumbotron head_title">
         <span class="fa fa-users"></span> Personal Boards List :
     </div>
      <div class="col-sm-4 heading-card"> <span class="fa fa-users"></span> Boards :  <span class="pull-right count"><?php echo sizeof($board); ?></span></div>
      <hr>
      <?php  
      foreach ($board as $value) {
      $board_url = $value['board_url'];
      $board_key = $value['board_key'];
      $Board_title = $value['title'];
      $bid = $value['board_id'];
      $lists = $db->getBoardListCount($bid);
      $cards = $db->getBoardListCardCount($bid);
      $members = $db->getBoardMemberCount($bid);
      $bstar = $value['board_star'];  
      if($bstar == 0){
        $class = "fa-star-o";
      }else{
        $class = "fa-star";
      }
      ?>
      <div class="boardlist col-sm-12">

        <div class="col-sm-4">
          <a href="dashboard.php?page=board&b=<?php echo $bid;?>&t=<?php echo $board_url;?>&k=<?php echo $board_key;?>"> <i class="fa <?php echo $class; ?> top1"></i> <?php echo $Board_title; ?></a>   
        </div>
        <div class="col-sm-8">
            <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> List: <span class="count"><?php echo $lists; ?></span></div>
            <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Cards: <span class="count"><?php echo $cards; ?></span></div>
            <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Members: <span class="count"><?php echo $members; ?></span></div>
        </div>
        
      </div>
      <?php  
      }
      ?>
      <div class="clearfix"></div>
      <div class="col-sm-4 heading-card"> <span class="fa fa-user"></span> Team :  <span class="pull-right count"><?php echo sizeof($team_board); ?></span></div>
      <hr> 
      <?php  
      foreach ($team_board as $value) {
         $team_url  = $value['team_url'];
         $team_key  = $value['team_key'];
         $team_title = $value['team_name'];
         $team_id   = $value['team_id'];
         $bid       = $db->getboardId($team_id);
         $board     = $db->getBoardListByTid($bid);
         $team_member = $db->getTeamMemberCount($team_id);
         $teamurl     = "dashboard.php?page=team&t=$team_id&u=$team_url&k=$team_key";
         ?>
        <div class="boardlist col-sm-12">
          <div class="col-sm-4">
          <a href="<?php echo $teamurl;?>"> <span class="fa fa-star top1"></span> <?php echo $team_title; ?> </a> 
          </div>
           <div class="col-sm-8">
            <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Boards: <span class="count"><?php echo sizeof($board); ?></span></div>
            <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Members: <span class="count"><?php echo $team_member; ?></span></div>
        </div>
        </div>
      <?php } ?>
      
      <!--dc code-->
      <br clear="all">
         <div class="row jumbotron head_title">
             <span class="fa fa-users"></span> Invited Boards List :
         </div>
         <div class="col-sm-4 heading-card"> <span class="fa fa-users"></span> Boards :  <span class="pull-right count"><?php echo sizeof($invited_board['invitedBoardData']); ?></span></div>
          <hr>
          <?php  
        
          foreach ($invited_board['invitedBoardData'] as $key => $value) {
          $board_url    = $value['board_url'];
          $board_key    = $value['board_key'];
          $Board_title  = $value['title'];
          $bid          = $value['board_id'];
          $lists        = $db->getBoardListCount($bid);
          
          $cards        = $db->getBoardListCardCount($bid);
          $members      = $db->getBoardMemberCount($bid);
          $bstar        = $value['board_star'];  
          if($bstar == 0){
            $class = "fa-star-o";
          }else{
            $class = "fa-star";
          }
          ?>
          <div class="boardlist col-sm-12">
    
            <div class="col-sm-4">
              <a href="dashboard.php?page=board&b=<?php echo $bid;?>&t=<?php echo $board_url;?>&k=<?php echo $board_key;?>"> <i class="fa <?php echo $class; ?> top1"></i> <?php echo $Board_title; ?></a>   
            </div>
            <div class="col-sm-8">
                <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> List: <span class="count"><?php echo $lists; ?></span></div>
                <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Cards: <span class="count"><?php echo $cards; ?></span></div>
                <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Members: <span class="count"><?php echo $members; ?></span></div>
            </div>
            
          </div>
          <?php  
          }
          ?>
          <div class="clearfix"></div>
          <div class="col-sm-4 heading-card"> <span class="fa fa-user"></span> Team :  <span class="pull-right count"><?php echo sizeof($team_board); ?></span></div>
          <hr> 
          <?php  
          foreach ($team_board as $value) {
             $team_url = $value['team_url'];
             $team_key = $value['team_key'];
             $team_title = $value['team_name'];
             $team_id = $value['team_id'];
             $bid = $db->getboardId($team_id);
             $board = $db->getBoardListByTid($bid);
             $team_member = $db->getTeamMemberCount($team_id);
             $teamurl = "dashboard.php?page=team&t=$team_id&u=$team_url&k=$team_key";
             ?>
            <div class="boardlist col-sm-12">
              <div class="col-sm-4">
              <a href="<?php echo $teamurl;?>"> <span class="fa fa-star top1"></span> <?php echo $team_title; ?> </a> 
              </div>
               <div class="col-sm-8">
                <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Boards: <span class="count"><?php echo sizeof($board); ?></span></div>
                <div class="col-sm-4"> <i class="fa <?php echo $class; ?> top1"></i> Members: <span class="count"><?php echo $team_member; ?></span></div>
            </div>
            </div>
          <?php } ?>

    
      
      
      
      <!--end dc code-->

      </div><br clear="all">
      
      
      

   
    
    <div id="cards" class="tab-pane fade <?php echo $c_active. " ". $c_in; ?>">
    <div class="row jumbotron head_title">
         <span class="fa fa-users"></span> Personal Card List :
     </div>
      <?php  
      $boards = $db->getAllUserBoard($uid);
      foreach ($boards as $values) {
        $board_url = $values['board_url'];
        $board_key = $values['board_key'];
        $Board_title = $values['title'];
        $board_visibility = $values['board_visibility'];
        $bid = $values['board_id'];
        $bstar = $values['board_star']; 
        $board_url = "dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key"; 
        $list_data = $db->getBoardList($bid);
        if($board_visibility == 0){
          $icon = "fa fa-lock";
        }else if($board_visibility == 1){
          $icon = "fa fa-users";
        }else if($board_visibility == 2){
          $icon = "fa fa-globe";
        }
       if(sizeof($list_data) > 0){
       ?>

       <div class="col-sm-12">
        <div class="col-sm-4 heading-card" style="margin-top:20px"> 
        <a href="<?php echo $board_url; ?>"><?php echo $Board_title; ?>: </a><span class="<?php echo $icon; ?>"></span>    <span class="pull-right">List <span class="count"><?php echo sizeof($list_data); ?></span></span></div>
        <div class="clearfix"></div>
        <?php  
        foreach ($list_data as  $values) {
           
         $listid = $values['list_id'];
         $card_data = $db->getListCard($listid);
          foreach($card_data['cardList'] as  $value) {
            $card_id = $value['card_id'];
            $def = $value['def'];
            $del_status = $value['del_status'];
            if($def == 1 && $del_status == 1){
                $dis = "none";
            }
            if($def == 0){
              $dis = "block";
            }
            if($def == 0 && $del_status == 0){
              $dis = "block";
            }
            if($def == 0 && $del_status == 1){
              $dis = "none";
            }
            if($def == 0 && $del_status == 2){
              $dis = "none";
            }  
          ?>
          <div class="col-sm-3 my-card" style="z-index:99;display: <?php echo $dis; ?>; height: auto;">
              <h5 id="<?php echo $listid."_".$card_id."_".$bid; ?>" onClick="return openCardModal(this.id)"><?php echo ucfirst($value['card_title']); ?></h5>  
          <?php
          $count = $db->getCardCommentsCount($card_id);
          if($count == "0"){
           ?>
          <div style="display:none;">
          <span class="fa fa-comments edit-card"></span>
            <span class="pull-right"><?php echo $count; ?></span>
          </div>
           <?php
          }else{
            ?>
            <div style="display:inline-block;">
          <span class="fa fa-comments edit-card"></span>
            <span class="pull-right"><?php echo $count; ?></span>
          </div>
            <?php
          }
          ?>
            <span>
              In <?php echo $values['list_title']; ?>
            </span>
          </div>
          <?php
          }
       
        }
        ?>
        </div>
        <div class="clearfix"></div>
       <?php
        }
      }
      ?>
      
      <!--code by dc -->
      <div class="row jumbotron head_title">
         <span class="fa fa-users"></span> Invited Card List :
     </div>
        <?php  
          $invited_boards_result = $db->getInvitedBoard($uid);
          $invited_boards = json_decode($invited_boards_result,true);
          
          foreach ($invited_boards['invitedBoardData'] as $key => $values) {
            $board_url = $values['board_url'];
            $board_key = $values['board_key'];
            $Board_title = $values['title'];
            $board_visibility = $values['board_visibility'];
            $bid = $values['board_id'];
            $bstar = $values['board_star']; 
            $board_url = "dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key"; 
            $list_data = $db->getBoardList($bid);
            if($board_visibility == 0){
              $icon = "fa fa-lock";
            }else if($board_visibility == 1){
              $icon = "fa fa-users";
            }else if($board_visibility == 2){
              $icon = "fa fa-globe";
            }
           if(sizeof($list_data) > 0){
           ?>
    
           <div class="col-sm-12">
            <div class="col-sm-4 heading-card" style="margin-top:20px"> 
            <a href="<?php echo $board_url; ?>"><?php echo $Board_title; ?>: </a><span class="<?php echo $icon; ?>"></span>    <span class="pull-right">List <span class="count"><?php echo sizeof($list_data); ?></span></span></div>
            <div class="clearfix"></div>
            <?php  
            foreach ($list_data as  $values) {
               
             $listid = $values['list_id'];
             $card_data = $db->getListCard($listid);
              foreach($card_data['cardList'] as  $value) {
                $card_id = $value['card_id'];
                $def = $value['def'];
                $del_status = $value['del_status'];
                if($def == 1 && $del_status == 1){
                    $dis = "none";
                }
                if($def == 0){
                  $dis = "block";
                }
                if($def == 0 && $del_status == 0){
                  $dis = "block";
                }
                if($def == 0 && $del_status == 1){
                  $dis = "none";
                }
                if($def == 0 && $del_status == 2){
                  $dis = "none";
                }  
              ?>
              <div class="col-sm-3 my-card" style="z-index:99;display: <?php echo $dis; ?>; height: auto;">
                  <h5 id="<?php echo $listid."_".$card_id."_".$bid; ?>" onClick="return openCardModal(this.id)"><?php echo ucfirst($value['card_title']); ?></h5>  
              <?php
              $count = $db->getCardCommentsCount($card_id);
              if($count == "0"){
               ?>
              <div style="display:none;">
              <span class="fa fa-comments edit-card"></span>
                <span class="pull-right"><?php echo $count; ?></span>
              </div>
               <?php
              }else{
                ?>
                <div style="display:inline-block;">
              <span class="fa fa-comments edit-card"></span>
                <span class="pull-right"><?php echo $count; ?></span>
              </div>
                <?php
              }
              ?>
                <span>
                  In <?php echo $values['list_title']; ?>
                </span>
              </div>
              <?php
              }
           
            }
            ?>
            </div>
            <div class="clearfix"></div>
           <?php
            }
          }
          ?>
        
        
        <!--end dc code-->
        <style>
         .window-module .big-link{
            display: block;
            margin: 10px 0;
          } 
        </style>
      <br>
    </div>
    
    
    
    <div id="Settings" class="tab-pane fade">
     <div class="col-sm-12"> <h3 style="color:#fff">Settings</h3> </div>
     <!--  <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p> -->
    <div class="col-sm-6">
     <div class="window-module u-clearfix">
     <div class="window-module-title">
     <h3>Account Details</h3>
     </div>
     <a data-toggle="modal" data-target="#myModal-1"  class="big-link js-change-name-and-bio" href="#">
     <span class="text">Change Name, Initials, or Bio…</span>
   </a>
<!-- 


     <a data-toggle="modal" data-target="#myModal-2" class="big-link js-change-avatar" href="#">
     <span class="text">Change Avatar…</span>
     </a>


 -->
     <a class="big-link js-change-email" data-toggle="modal" data-target="#myModal-3" href="#">
     <span class="text">Change Password…</span>
     </a>

     <a data-toggle="modal" data-target="#myModal-4" class="big-link js-change-email" href="#">
     <span class="text">Change Email…</span>
     </a>

     <!-- <a class="big-link js-change-locale" href="#">
     <span class="text">Change Language…</span>
     </a> -->
  </div>
   </div>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Odapto Offers</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>

</div>
    </div>
  </div>
         </div>
     </div>
 </div> 

 <div style="width: 100%;min-height:100% !important; background-color: rgba(0,0,0,0.5);position: absolute;top: 0px;left: 0px; display: none;padding:0px 20px 20px 20px; z-index: 99" id="cardModal">

  <div class="col-md-4" style="background-color: #f1f1f1;height:auto !important;width:65%;left:17%; padding:20px;border-radius:5px;position:relative;top:10px;z-index:1;">
    <span class="fa fa-times pull-right close-invite"></span>
    <div class="clearfix"></div>
    <div id="cardResult" class="col-md-12 n-p" style="margin-top:0px;"></div>
  </div>
</div>

<!--all pop here for profile-->

<div id="myModal-1" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title cust-title text-center">Change Name and Bio</h4>
      </div>
      <div class="modal-body n-p">
        <div class="col-sm-10 col-sm-offset-1 cust-pop">
          <div class="col-sm-12">
           <div class="form-group"></div>
            <label for="text">Full Name:</label>
               <input type="text" class="form-control" value="<?php echo trim($result['full_name']); ?>" id="name">
        </div>
        <div class="col-sm-12">
           <div class="form-group"></div>
            <label for="text">Initials:</label>
               <input type="text" class="form-control" id="Initials" value="<?php echo trim($result['intials']); ?>">
        </div>
        <div class="col-sm-12">
           <div class="form-group"></div>
            <label for="text">Username:</label>
               <input type="text" class="form-control" id="Username" value="<?php echo trim($result['user_name']); ?>">
        </div>
        <div class="col-sm-12">
        <div class="form-group">
  <label for="comment">Bio:</label>
  <textarea class="form-control" rows="5" id="comment"><?php echo trim($result['Bio']); ?></textarea>
  <input type="hidden" name="user" id="user_id" value="<?php print_r($_SESSION['sess_login_id']);?>">
</div>
</div>
    <div class="col-sm-4">
      <a style="margin-bottom:10px" class="btn btn-danger btn-block" id="my_profile">SAVE</a></div>
  </div>
      </div>
    </div>
    </div>
  </div>

  <!-- first model end and second model start -->

  <div id="myModal-2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title cust-title text-center">Change Avatar</h4>
      </div>
      <div class="modal-body n-p">
        <div class="col-sm-10 col-sm-offset-1 cust-pop">
          <div class="col-sm-12">
           <span class="member-initials"><?=$_SESSION['fullname']?></span>
           <span class="text">Initials (no avatar)</span>

          <hr><p class="error  js-error"></p>
          <div class="uploader">
          <input  type="file" name="file" id="file">
          </div>
        </div>
      </div>
<div class="col-sm-4">
      <a style="margin-bottom:10px" class="btn btn-danger btn-block" id="imguplaod">Uploade</a></div>

    </div>
    </div>
  </div>
</div>
  <!-- second model end and third model start -->

  <div id="myModal-3" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title cust-title text-center">Change Password</h4>
      </div>
      <div class="modal-body n-p">
        <div class="col-sm-10 col-sm-offset-1 cust-pop" style="padding-top:5px;">
          <!-- <div class="col-sm-12">
           <div class="form-group"></div>
            <label for="text">Old password:</label>
               <input type="password" name="old-password" class="form-control" id="old_password">
        </div> -->

        <span id="msg" style="color: red;     font-size: 17px;
    font-family: cursive;">Password does not matched!!!!</span>
        <div class="col-sm-12" >
           <div class="form-group">
            <label for="text">New password:</label>
               <input type="password" name="password" class="form-control" id="new_password">
               </div>
        </div>
        <div class="col-sm-12">
           <div class="form-group">
            <label for="text">New Password (again):</label>
               <input type="password" name="retupe-password" class="form-control" id="retupe_password">
               </div>
        </div>
        <div class="col-sm-12">
           <div class="form-group">
               <a style="margin-bottom:10px" class="btn btn-danger pull-right" id="pass_update">Update</a>
            </div>
        </div>
       
    <div class="col-sm-4">
      </div>
  </div>
      </div>
    </div>
    </div>
  </div>

  <!-- third model end and fourth model start -->

<div id="myModal-4" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title cust-title text-center">Change Email</h4>
      </div>
      <div class="modal-body n-p">
        <div class="col-sm-10 col-sm-offset-1 cust-pop">
          <div class="col-sm-12" style="padding-top:5px;">
           <div class="form-group">
            <label for="text">Current Email</label>
               <?=$_SESSION['user_Id']?>
               </div>
        </div>
        <div class="col-sm-12">
           <div class="form-group">
            <label for="text">New Email:</label>
               <input type="email" class="form-control" id="email">
               </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
              <a style="margin-bottom:10px" class="btn btn-danger pull-right " id="Change_email">Change Email</a> 
          </div>
        </div>
        
        
    <div class="col-sm-4">
    
     
      </div><br>
      
  </div>
      </div>
    </div>
    </div>
  </div>

  <!-- fourth model end -->

 


 <script type="text/javascript">
  function openCardModal(elem){
  var id = elem;
  $.post('./card-details.php', {data: id}, function(response) {
    document.getElementById('cardModal').style.display = "block";
    $("#cardResult").html(response);
  });

}
$(".close-invite").click(function(event) {
 $("#cardModal,#renameBoardDiv").css({'display':'none'});
});

  function ShowAddProfile(){
    //$("#AddProfile").css({'display':'block','top':'113px','right':'-300px'});
    $("#AddProfile").modal('show');
  }
  /*
  $(".close-div").click(function(){
    $("#AddProfile").css({'display':'none'});
  });
  setTimeout(function(){
    $("#error").fadeOut(fast);
  }, 2000);
  */

  function editprofile(){
    document.getElementById('profile').style.display = "none";
    document.getElementById('edit-pro').style.display = "block";
    
  }
  function closeDiv(){
    document.getElementById('edit-pro').style.display = "none";
    document.getElementById('profile').style.display = "block";
  }

  function update_profile(){

      var name = document.getElementById('fullname').value;
      var username =document.getElementById('username').value;
      var initials =document.getElementById('initials').value;
      var bio =document.getElementById('bio').value;
      
      if(name == ""){
        document.getElementById("error").innerHTML = "this is invalid name";
       
      // }else if(initials.length > 4){
      //   document.getElementById("error").innerHTML = "initials should be 1-4 character";
         
      // }else if(username == ""){
        document.getElementById("error").innerHTML = "please enter username";
        
      }else{
        var data = $("#profileForm").serialize();
        //alert(data);  
        $.ajax({
        url: "/update_profile.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=='TRUE')
          {
            $("#succ_msg").html(obj.message);
            $('#edit-pro').css({'display':'none'});
            $('#profile').css({'display':'block'}); 
            //console.log(obj.message);
            location.reload();
          }else if(obj.result=="FALSE"){ 
            $("#error").html(obj.message);
          }
        }
      });        
      return false; 
      }
      
  }
</script> 
<style>
.cust-title, label{font-size:14px !important;}
</style>
<script type="text/javascript">
  jQuery(document).ready(function() {
    $('#msg').hide();
    jQuery('#my_profile').click(function(e) {
      var bio=jQuery('#comment').val();
      var fullname=jQuery('#name').val();
      var initials=jQuery('#Initials').val();
      var username=jQuery('#Username').val();
      var user_id=jQuery('#user_id').val();
      var profile="profile";
      $.ajax({
              url:'update_profile.php',
              type:'POST',
               data: {'profile':profile,'fullname':fullname,'initials':initials,'username':username,'bio':bio},
               success: function(rel){
                $('#myModal-1').hide();
                $('.modal-backdrop').hide();
         alert("Profile Successfully Update");
            
        }
      })
    });
  });
$('#pass_update').click(function(event) {

  $('#msg').hide();
      var new_password=jQuery('#new_password').val();
      var retupe_password=jQuery('#retupe_password').val();
      var update_password='update_password';
      if(new_password!=retupe_password){
        $('#msg').fadeIn('200', function() {
           $('#msg').show();
        });;
        return;
      }
      else{
        $('#msg').fadeOut('200', function() {
          $('#msg').hide();
        });
      }
    $.ajax({
              url:'update_profile.php',
              type:'POST',
               data: {'update_password':update_password,'new_password':new_password,'retupe_password':retupe_password},
               success: function(rel){
                $('#myModal-3').hide();
                $('.modal-backdrop').hide();
         alert("Password Successfully Update");
            
        }
      })

 });


$('#Change_email').click(function(event) {

 
      var email=jQuery('#email').val();
      alert(email);
      var update_email='update_email';
      
    $.ajax({
              url:'update_profile.php',
              type:'POST',
               data: {'update_email':update_email,'email':email},
               success: function(rel){
                $('#myModal-4').hide();
                $('.modal-backdrop').hide();
         alert("Email Successfully Update");
            
        }
      })

 });
</script>

<link rel="stylesheet" href="//code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
<script type="text/javascript">
// $(document).ready(function (e) {
//     $('#imguplaod').on('click', function () {
        
//                     var file_data = $('#file').prop('files')[0];
//                     var form_data = new FormData();
//                     form_data.append('file', file_data);
                   
//                       $.ajax({
//                         url: 'update_profile.php', // point to server-side PHP script 
//                         dataType: 'text', // what to expect back from the PHP script
//                         cache: false,
//                         contentType: false,
//                         processData: false,
//                         data: form_data,
//                         type: 'post',
//                         success: function (response) {

//                            $('#myModal-2').hide();
//                           $('.modal-backdrop').hide();
//                           alert("image Uploade Successfully");
//                         }
//                     });


//     });

// });


</script>

<script type='text/javascript'>
function preview_image(event) 
{
      var reader = new FileReader();
      reader.onload = function()
      {
      var output = document.getElementById('output_image');
      $('#output_image').show();
      output.src = reader.result;
      }
      reader.readAsDataURL(event.target.files[0]);
      var file_data = $('#file').prop('files')[0];
      var form_data = new FormData();
      form_data.append('file', file_data);

      $.ajax({
      url: 'update_profile.php', // point to server-side PHP script 
      dataType: 'text', // what to expect back from the PHP script
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      success: function (response) {
 //alert(response);
      $('#myModal-2').hide();
      $('#AddProfile').hide();
      $('.modal-backdrop').hide();
      //$("#profile_image").attr("src","https://www.odapto.com/user_profile_Image/"+file_data['name']);
      //$("#profile_pic").css("background", "url(https://www.odapto.com/user_profile_Image/"+file_data['name']);
     //reload('./inc/dashboard-menu.php');
         var obj = jQuery.parseJSON(response);
          
          if(obj.result=="TRUE")
          {
              $("#profile_image").attr("src","https://www.odapto.com/user_profile_Image/"+obj.message);
              //alert(obj.message);
          }
     
      }
      });
}
</script>