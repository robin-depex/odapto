<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<?php
session_start();
error_reporting(0);
$uid = $_SESSION['sess_login_id'];

$bid = $_REQUEST['b'];
$userDetails = $db->getsingledata('tbl_users','id',$uid);

    $admin_d=$db->getsingledata('tbl_user_board','board_id',$bid);
    
    
    /* code by dc to protect board from other users */
     $invited_board_result = $db->getInvitedBoard($uid);
    $invited_board = json_decode($invited_board_result,true);
    if(isset($invited_board) && sizeof($invited_board) > 0) { 
        foreach ($invited_board['invitedBoardData'] as $value) {
            $bord_id = $value['board_id'];
             //echo $bord_id;
           
            if($admin_d['admin_id']!=$uid)
            {
                if($bid !=$bord_id)
                {
                  /*  echo"<script>
                    alert('Access allowed');
                    window.open('dashboard.php','_self');
                    </script>";
                   
                    */
                    
                   
                    
                }else{
                  
                    
                }
                
            }
        }
    
    } 
    
   
    
    
   /*  code end to protect board from other users */
$_SESSION['curent_page'] = $db->site_url.'dashboard.php?page=board&b='.$_REQUEST['b'].'&t='.$_REQUEST['t'].'&k='.$_REQUEST['k'];
$result = $db->getBoardDetails($bid);
$admin = $db->getBoardAdmin($bid);
//echo $admin;
date_default_timezone_set("Asia/Kolkata");
$ud = date("Y-m-d H:i:s");
$data = array("recentuse"=>1,"ud"=>$ud);
$con = array("board_id"=>$bid);
$update = $db->update("tbl_user_board",$data,$con);
$board_id = $result['board_id'];
$board_url = $result['board_url'];
$board_key = $result['board_key'];
$board_visibility = $result['board_visibility'];
$bstar = $result['board_star'];
$teamid = $db->getTeamId($bid);
$teamDetails = $db->getTeamDetailsByBoardId($teamid);
//echo json_encode($teamDetails);
if(isset($teamDetails))
{
    $team_url = "dashboard.php?page=team&t=".$teamDetails['team_id']."&u=".$teamDetails['team_url']."&k=".$teamDetails['team_key'];
}

$url_key = $_REQUEST['k'];
$url_board_url = $_REQUEST['t'];
//if( ($url_key != $board_key) || ($bid != $board_id)){
if($bid != $board_id){
  include("404.php");
}else{

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">

<style type="text/css">
.heading{
  text-align: center !important; 
}
#BoardVisibilityDiv{
 background-color: #fdfdfd;
 width:330px; z-index:9999999;
 position: absolute;
 box-shadow:0 0 5px #333;
}
#teamDiv{
  background-color: #fdfdfd;
 width:330px; z-index:9999999;
 position: absolute;
 box-shadow:0 0 5px #333;
}
.listhover:hover{
  cursor: pointer;
   background: rgba(0, 0, 0, 0.16); 
  }
 .listhover2:hover{
    background: rgba(0, 0, 0, 0.16); 
  } 
.hidechange{
    color: #0c0c0c;
    float: left;
    font-size:14px;
    position: absolute;
    top: 9px;
    width: 16px;
    height: 16px;
    border-radius: 3px;
}
.card-lables{
    min-width: 50px !important;
    color: #fff;
    /* text-shadow: 1px 1px 1px rgb(0, 0, 0, 0.3); */
    margin-right: 5px;
    line-height: 30px;
    text-align: center;
    font-size: 13px;
    border-radius: 4px;
 }
 .card-lables1{
    min-width: 40px !important;
    padding: 4px;
    color: #fff;
    font-size: 14px;
    border-radius: 4px;
    display: inline-block;
    clear: both;
 }
 .img-center{
  margin: 0 auto;
 }
.cardduedatelist, .imagePreviewDb9{
  margin: 0 !important;
}
.second-header{
    background: #184c4326;
    margin-bottom: 15px;
    padding: 10px 0;
    border-top: 1px solid #447169;
    padding-left: 15px;
    padding-right: 15px;
}
#profile_initials {
    width: 26px;
    height: 22px;
    background-color: #656565;
    display: inline-block;
    color: #fff;
    text-align: center;
    font-size: 12px;
    line-height: 22px;
    border-radius: 2px;
}
.all-item{
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
  }
.attachment_div{
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 0 2px #e2e2e2;
    background: #f7f7f7;
    margin-left: 0 !important;
}
.attachment_div > div{
  margin-top: 0 !important;
}  
.attachment_div p{
  margin:0;
}

.cardduedatelist li{
    padding: 2px 5px;
    font-size: 12px;
  }
 .card-Title:hover{
    background: #ececec;
 } 
 .card-Title:hover:before {
    content: '\f040';
    position:absolute;
    right: 10px;
    top: 4px;
    color: #7d7d7d;
    font-family: fontAwesome;
 } 
 .img-responsive{
  max-width: 100% !important;
 }
 .save-board{
  position: relative;
  left: 0;
  width: 100%;
 }
 .task{
  border-radius: 0 !important; 
}
.layout-scroll::-webkit-scrollbar{
  width: 10px;
}
.layout-scroll::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
.layout-scroll::-webkit-scrollbar-thumb {
  background: #333; 
  border-radius: 10px;
}

/* Handle on hover */
.layout-scroll::-webkit-scrollbar-thumb:hover {
  background: #333; 
}

.form-group.color{
width: 100%;
    max-width: 100%;
    margin: 0;
    top: 0;
    display: flex;
    flex-wrap: wrap;
}

.IconDiv{
    /*display: block;*/
    height: 300px;
    overflow: scroll;
}
.iconImg
{
    width: 10%;
    height: 10%;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: bold;
}
.number {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: white;
    color: black;
    font-weight: bold;
}
.dc_filter_val:hover {
   border-color: black;
}
</style>
<div class="second-header">
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
<ul class="list-inline private" style="display: inline-block !important;">
<li style="position: relative;" class="listhover">
<h4 onClick="return ShowRenameBoard()" id="boardTitle"><?php $page = str_replace("-", " ", $_REQUEST['t']); echo ucfirst($result['board_title']);?></h4>
<div class="col-md-4" id="renameBoardDiv">
      <h6 class="heading">Rename Board
      <span class="fa fa-times pull-right close-invite"></span></h6>
      <hr>
      <form id="renameBoardForm" method="POST">
        <div class="form-group">
          <label>Name</label>
          <input type="hidden" name="boardid" id="boardid" value="<?php echo $bid; ?>">
          <input type="text" class="form-control input-md" name="boardName" id="boardName" value="<?php echo $result['board_title']; ?>">
        </div>
        <div class="form-group">
          <input type="button" name="renameBoard" id="renameBoard" class="list-btn" value="Rename">
        </div>
      </form>
</div>

</li>

<li class="listhover" style="position: relative;">
<h4><?php
if ($bstar == 1) {
?>

<a href="javascript:void(0)" class="fa fa-star" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>" title="Click to star or unstar this board. Starred boards show up at the top of your boards list."></a>
  <?php
}else{
  ?>
  <a href="javascript:void(0)" class="fa fa-star-o" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>" title="Click to star or unstar this board. Starred boards show up at the top of your boards list."></a>
  <?php
}
 ?>
 </h4>
</li>
<?php
if($teamDetails == 0){
  $teamname = "";
  $display = "none";
  ?>
<li style="display:<?php echo $display; ?>" class="listhover">
  <h4><a href="javascript:void(0)"><?php echo $teamname; ?></a></h4>
</li>
  <?php
}else{
  $teamname = $teamDetails['team_name'];

  $display = "inline-block";
  ?>
<li style="display:<?php echo $display; ?>;position: relative;" class="listhover">
  <h4 id="teambtn"><?php echo $teamname; ?></h4>
  <div class="col-md-4" id="teamDiv" style="display: none">
      <div id="list_status_board">
      <h6 class="heading"><?php echo $teamname; ?></h6>
      <span class="fa fa-times pull-right close-invite" onclick="return closeVisibilityDiv()"></span>
      <hr>
      <p>
      <a href="javascript:void(0)" class="btn-block list-btn" onclick="return showChangeTeamDiv()">Change Team...</a></p>
      <p><a href="<?php echo $team_url; ?>" class="btn-block list-btn">View Team Page</a></p>
      </div>
      <div id="selectTeamDiv" style="display: none">
            <h6 class="heading">Change Team</h6>
            <span class="fa fa-arrow-left hidechange" onclick="return hideChangeTeam()"></span>
            <span class="fa fa-times pull-right close-invite" onclick="return closeVisibilityDiv()"></span>
            <hr>
            <div class="col-sm-12 n-p">
                <form method="POST">
                    <div class="form-group ">
                    <label for="teamId">Team</label>
                    <select class="form-control input-sm" name="teamId" id="teamId">
                    <option value="0">none</option>
                    <?php  
                    $result = $db->getTeamList($uid);
                    foreach ($result as $value) { ?>
                     <option value="<?php echo $value['team_id'] ?>"><?php echo $value['team_name']; ?></option>   
                    <?php } ?>
                  </select>
                    </div>
                    <div class="form-group">
                        <input type="button" name="changeTeam" id="changeTeam" value="Change Team" class="list-btn">
                    </div>
                </form>
            </div>
        </div>
          
</div>
</li>
<?php
}
?>


<li class="listhover" style="position: relative;">
<?php if($board_visibility == "0"){ ?>
<h4 class="visibility" id="oldVis"><i class="fa fa-lock" aria-hidden="true"></i> Private</h4>
<?php }else if($board_visibility == "2"){ ?>
<h4 class="visibility" id="oldVis"><i class="fa fa-globe" aria-hidden="true"></i> Public</h4>
<?php }else if($board_visibility == "1"){ ?>
<h4 class="visibility" id="oldVis"><i class="fa fa-users" aria-hidden="true"></i> Team Visible</h4>
<?php } ?>

<div id="resultVisibility"></div>



<div class="col-md-4" id="BoardVisibilityDiv" style="display: none">
      <div  id="list_status_board">
      <h6 class="heading">Board Visibility</h6>
      <span class="fa fa-times pull-right close-invite" onclick="return closeVisibilityDiv()"></span>
      <hr>
      <form id="visibBoardForm" method="POST">
          <div class="listhover2 col-sm-12" id="0" onclick="return changeVisibilivt(this.id)">
            <label for="private" style="font-size: 16px;">
            <i class="fa fa-lock" aria-hidden="true"></i> 
            Private  <?php  
          if($board_visibility == "0"){
            ?>
            <i class="fa fa-check" aria-hidden="true"></i>
            <?php } ?>
            </label>
           <p style="color: #000; font-size:12px;">The board is private. Only people added to the board can view and edit it.</p>
          </div>
          <?php  
          if($board_visibility == "1"){
            ?>
             <div class="listhover2 col-sm-12" id="1">
            <label for="team" style="font-size: 16px;">
            <i class="fa fa-users" aria-hidden="true"></i> 
            Team  <i class="fa fa-check" aria-hidden="true"></i> </label>
            <p style="color: #000; font-size:12px;">The board is visible to members of the team.  Only people added to this board can edit it.  The board must be added to a team to enable this.</p>
          </div>
            <?php
          }else{
           ?>
            <div class="listhover2 col-sm-12" id="1" onclick="return changeVisibilivt(this.id)">
            <label for="team" style="font-size: 16px;">
            <i class="fa fa-users" aria-hidden="true"></i> 
            Team  </label>
            <p style="color: #000; font-size:12px;">The board is visible to members of the team.  Only people added to this board can edit it.  The board must be added to a team to enable this.</p>
          </div>
           <?php 
          }
          ?>
         <?php if($userDetails['previlage'] == '1') { ?>
          <div class="listhover2 col-sm-12" id="2" onclick="return changeVisibilivt(this.id)">
            <label for="public" style="font-size: 16px;">
            <i class="fa fa-globe" aria-hidden="true"></i> 
            Public <?php  
            if($board_visibility == "2"){
            ?>
            <i class="fa fa-check" aria-hidden="true"></i>
            <?php } ?></label>
            <p style="color: #000; font-size: 12px;">The board is public. It's visible to anyone with the link. Only people added to the board can edit it.</p>
          </div>
          <?php } ?>
          </form>
       </div>

       <div id="selectTeamDiv" style="display: none">
            <h6 class="heading">Change Team</h6>
            <span class="fa fa-arrow-left hidechange" onclick="return hideChangeTeam()"></span>
            <span class="fa fa-times pull-right close-invite" onclick="return closeVisibilityDiv()"></span>
            <hr>
            <div class="col-sm-12 n-p">
                <form method="POST">
                    <div class="form-group ">
                    <label for="teamId">Team</label>
                    <select class="form-control input-sm" name="teamId" id="teamId">
                    <option value="0">none</option>
                    <?php  
                    $result = $db->getTeamList($uid);
                    foreach ($result as $value) { ?>
                     <option value="<?php echo $value['team_id'] ?>"><?php echo $value['team_name']; ?></option>   
                    <?php } ?>
                  </select>
                    </div>
                    <div class="form-group">
                        <input type="button" name="changeTeam" id="changeTeam" value="Change Team" class="list-btn">
                    </div>
                </form>
            </div>
        </div>
          
</div>
</li>

</ul>
 <div class="col-sm-3 n-p" style="width: 288px !important; padding: 0px;float: right; display:block">
       <div class="col-sm-12 task clearfix" style=" padding: 10px;margin-top: 0px;">
       <!-- rename list -->
       
          <form action="" method="post" id="listForm" >
             <div class="form-group" style="margin-bottom: 0px;">
               <input type="text" class="form-control input-sm" id="list_name" name="list_name" required="required" style="width:80% !important;" placeholder="Add List...">
               <a href="javascript:void(0)" class="list-btn save_card pull-right" value="Add" onclick="return createList()" style="margin-top: -30px;padding:5px 10px; ">Add</a>
             </div>
    
              <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
              <input type="hidden" name="bid" id="bid" value="<?php echo $bid; ?>">
              <input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
         </form>
        
        
       </div>
     </div>
    </div>
  </div>
</div>
</div>
<div class="container-fluid">
   <div class="row">
   <?php
   $admin = $db->getBoardAdmin($bid);
    if($uid != $admin){
      $display = "none";
    }else{
      $display = "block";
    }
   ?>
<!--  main div  -->

<!-- Category Modal (Hidden Initially) -->
<div id="categoryPopup">
    <label>Select Category:</label>
    <select id="categorySelect">
        <option value="">-- Choose --</option>
        <?php $where = array(); $Tempcategory = $db->get_data('tbl_tmp_category',$where); foreach($Tempcategory as $category) { ?>
        
        <option value="<?php echo $category['id']?>"><?php echo $category['cat_name']?></option>
        <?php } ?>
    </select>
    <button id="confirmCategory">Confirm</button>
</div>
  
     <div class="clearfix"></div>

<!--  main div -->

  <!-- card front -->
  <div class="col-sm-12">
     <div class="col-sm-12 layout-scroll" style="width:100%;">
     <?php 
     
     $list_data = $db->getBoardList($bid);
     
     $count = sizeof($list_data);
     $width = (288*$count)+50;
     ?>
     <div id="scroll" class="boardlistitem" style="width:<?php echo $width.'px'; ?>">

      <?php
      
      //echo json_encode($list_data);
      if(sizeof($list_data) > 0){
      $i = 1;
      foreach ($list_data as  $value) {
            
        $listid = $value['list_id'];
        $listname = $value['list_title'];
        $bgimage = ''; 
        $bgcolor = '';
        // $bgimage = $value['bgimage']; 
        // $bgcolor = $value['bgcolor'];
        if($bgimage!="" AND $bgcolor!=""){
          $bck="background: url('https://www.odapto.com/board_img/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
        }
        elseif ($bgimage=="" AND $bgcolor!="") {
           $bck="background-color: $bgcolor";
          } 
          else{
           $bck="background-color: #f7f7f7";
          } 
      ?>
    
      <div class="out<?php echo $listid; ?> " >
        
       
      <div class="col-sm-3 n-p in1<?php echo $listid; ?> dc_filter" id="first<?php echo $listid; ?>" style="width:288px;height:auto;margin-left: 10px;float: left; display: inline-block;">
            
      <div class="col-sm-12" style="padding-left:0px;">
          <?php $list = $db->getListDetailByListId($value['list_id']); ?>
        <div class="board-title-input" style=" background:<?php echo $list['list_color'];?>">
        <form action="" method="post">
        <!--Icon and color-->
            
             <div class="col-md-4 IconDiv" id="IconDiv_<?php echo $value['list_id'];?>" >
          <h6 class="heading">Icons & Colors <span class="fa fa-times pull-right close-invite"></span></h6>
          <hr>
            <input type="hidden" id="list_id" value="<?php echo $value['list_id'];?>">
             
                     <div class="form-group icon">
                         <?php $list_icons = $db->getListIcon(0,100); foreach($list_icons as $icon) { ?>
                             <div class="col-sm-2" onclick="userlistIcon(this.id,<?php echo $value['list_id'];?>)" id="<?php echo $icon['images']; ?>">
                                <img src="<?php echo $icon['images'] ?>" alt="<?php echo htmlspecialchars($icon['name']) ?>" style="width:30px; gap">
                            </div>
                         <?php } ?>
                     </div>
                    
            
          <!--  <h6 class="heading">Color<span class="fa fa-times pull-right close-invite"></span></h6>-->
          <!--<hr>-->
             <div class="form-group color">
                <?php $list_colors = $db->get_data('tbl_background_color',array('status'=>1)); foreach($list_colors as $color) { ?>
                     <div class="col-sm-2" onclick="userlistColor(this.id,<?php echo $value['list_id'];?>)" id="<?php echo $color['color']; ?>">
                        <div style="background:<?php echo $color['color']; ?>" class="col-sm-12 icolor"></div>
                      </div>
                <?php } ?>
            </div>
            
    </div>
       
        <!--Icon and color End -->

        <span class="icon" onClick="return ShowIcon(<?php echo $value['list_id'];?>)" style="display: inline-flex;" >
             <?php if($list['list_icon'] != '') { ?>
        <img src="<?php echo $list['list_icon'];?>" class="iconImg">
        <?php } else { ?>
        <i class="fa fa-plus" style="width:20px; color:#fff"></i>
        <?php } ?>
        <input type="text" class="form-control list-Title n-p  dc_filter_val" id="<?php echo $i."_".$value['list_id']; ?>" onblur="return editListTitle(this.id)" value="<?php echo ucfirst($value['list_title']); ?>" style="height:27px;width: 90%; text-align: center;color:#fff">
        
        </span>
       <span style="display: inline-flex;" >
            <p class="number"> <?php $numberCard = $db->countListCard($listid); echo $numberCard;?> 
        </span>
       
        </form>
        </div>
       <div class="col-sm-12 task" style="<?=$bck;?>; padding:8px 10px;position: relative;">
        
        
        <!-- flip -->
    
    <div style="margin-top:6px; border:1px solid #fdfdfd;" id="list_<?php echo $listid; ?>" class="scrolly">
        
        <script>
            $(document).ready(function () {
            $('#load-more').click(function () {
                let offset = 16;
                var list_id = $('#list_id').val();
                $.ajax({
                    url: 'load_icons.php',
                    method: 'POST',
                    data: { offset: offset, list_id: list_id },
                    success: function (response) {
                        $('.icon').append(response);
                         offset += 16;// Update offset
                    }
                });
            });
        });
        </script>
        
        
        
        <!--code by dc-->
        <script type="text/javascript">
        
               function dragStart(event) {
              event.dataTransfer.setData("image", event.target.id);
              //document.getElementById("demo").innerHTML = "Started to drag the p element";
          }
            function allowDrop(event) {
                  event.preventDefault();
              }
          function drop(event,id) {
            event.preventDefault();
              var data = event.dataTransfer.getData("image");
              var dreag ='stackers';
              var img_url=document.getElementById(data).getAttribute('src');
              event.target.appendChild(document.getElementById(data));
              
              //document.getElementById("demo").innerHTML = "The p element was dropped";
              $.ajax({
                url: "drag_drop.php",
                type: "POST",
                data: {data: img_url,dreag:dreag,id:id},
                success: function(rel){
               //   alert('ok');
                }
            });
        }
        
        
function userlistColor(elem,list_id){
   
    var color = elem;
    var id = list_id;
    var action = 'list_bg_color';
    $.ajax({
      url: 'changeBgColor.php',
      type: 'POST',
      data: {action: action,color:color,id:id},
      success: function(rel){
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
               location.reload();
        
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
      }
    })
 }
 
 function userlistIcon(elem,list_id)
 {
    var icon = elem;
    var id = list_id;
    var action = 'list_bg_icon';
    $.ajax({
      url: 'changeBgColor.php',
      type: 'POST',
      data: {action: action,icon:icon,id:id},
      success: function(rel){
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
               location.reload();
           
        
          }else if(obj.result=="FALSE"){ 
            $(".error").html(obj.message);
          }
      }
    })
 }
        
        
       </script>
    
    
    
     <script type="text/javascript">
                $('.box-item').draggable({
                   helper: "clone"
                });
    
                $('#list_<?php echo $listid; ?>').droppable({
                  tolerance: 'touch',
                  drop: function(event, ui) {
                    var itemid = $(ui.draggable).attr("id");
                    //alert(itemid);
                    var clist = $(this).attr("id");
                    //alert(clist);
                    $('.box-item').each(function() {
    
                        if($(this).attr("itemid") === itemid) {
    
                          $(this).appendTo('#list_<?php echo $listid;?>');
    
                          var data = "drag="+itemid+"&drop="+clist;
                           $.post('drag_drop.php', {data: data}, function(response) {
                              //alert(response);
                              $(".box-item").draggable({
                                helper: 'clone'
                              });
                              $(this).css('min-height' , 'auto');
                          });
                       }
    
                    });
                     }
                  });
    
            </script>
        
        
        
        <!--end code dc-->
        
        <?php

        $card_data = $db->getListCard($listid);

        if(sizeof($card_data) > 0){
          //  echo "<pre>";
 //print_r($card_data);
           foreach($card_data['cardList'] as  $value) {

            $card_id = $value['card_id'];
            $def = $value['def'];
            $del_status = $value['del_status'];
            $stickers = $value['stickers'];
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
   
        <div class="form-control form-contro input-sm card-Title box-item" id="<?php echo $listid."_".$card_id."_".$bid; ?>" onClick="return openCardModal(this.id)" itemid="<?php echo $listid."_".$card_id."_".$bid; ?>" style="z-index:99;display: <?php echo $dis; ?>; height: auto;" ondrop="drop(event,<?=$card_id?>)" ondragover="allowDrop(event)">

        
        <!-- Image Attachments -->
        
        <div class="imagePreviewDb<?php echo $card_id; ?>"></div>

        <?php  
        $coverimage = $db->getCoverImage($card_id);
        if(isset($coverimage)) { foreach ($coverimage as $key => $valuecover) {


        if($valuecover['background']==0)
        {
        $class='div-border';
        }

        ?>

       <!-- <div class="imagePreview<?php echo $card_id; ?>" style="background-color: #<?php echo $valuecover['background'];?>;"> -->
      <img src="attachments/<?php echo $valuecover['cover']; ?>" class="img-responsive" onclick="dropboxapi()"> 
        <!-- </div> -->
        <?php
        } }
        ?>
        <div style="float:left">
          <span class="list-span"><?php echo ucfirst($value['card_title']); ?></span>
        </div>
        <?php
        if($stickers){
        ?>
        <div style="float: right;"><img src="<?=$stickers?>" style=" width:25px;  height:25px" ></div>
        <?php
        }
        ?>
        <!-- Labels -->

<?php $labels = $db->getAllCardLabels($card_id); if(count($labels ?? []) > 0){ ?>

<div class="clearfix"></div>

<?php foreach ($labels as $value) { $label = $db->getLabelText($uid,$value['labels']); $lid = $db->getLabelId($label['label_id']); $lbldata = $db->getLabeldata($label['label_id']); ?>
    <span style="background: <?php echo $lbldata['color']; ?>; width:50px !important;" class="card-label1 mod-card-front" title="<?php if(!empty($label['label_name'])){ echo $label['label_name']; }else{ echo "&nbsp;";} ?>"></span>
<?php } } ?>

<!-- labels Ends -->
<div class="clearfix"></div>
<!-- Comment Count -->
  <div class="all-item">
          <?php $count = $db->getCardCommentsCount($card_id);if($count == "0") { ?>
              <div style="display:none;">
              <span class="fa fa-comments edit-card"><?php echo $count; ?></span>
              </div>
           <?php }else{ ?>
              <div style="display:inline-block;">
              <span class="fa fa-comments edit-card"><?php echo $count; ?></span>
              </div>
            <?php } ?>
          <!--  Comment Count Ends -->
          <!-- total attachemnets -->
          <?php  
          $countAtt = $db->cardImageCount($card_id);
          if($countAtt == "0"){
           ?>
          <div style="display:none;">
          <span class="fa fa-paperclip"></span>
            <span class="pull-right"><?php echo $countAtt; ?></span>
          </div>
           <?php
          }else{
            ?>
          <div style="display:inline-block;margin-left: 10px;">
          <span style="font-size: 16px !important" class="fa fa-paperclip edit-card"></span>
            <span class="label label-success"><?php echo $countAtt; ?></span>
          </div>
            <?php
          }
          ?>

           <?php  
         $countchecklist = $db->gettotalchecklistcount($card_id);
          $countchecklistnew = $db->getchecklistcount($card_id);
          if($countchecklist>0){ ?>
          <div style="display:inline-block;margin-left: 10px;">
          <span class="fa fa-check-square edit-card"></span>
            <span class="pull-right"><?php echo $countchecklistnew; ?> / <?php echo $countchecklist; ?></span>
          </div>
            <?php
          }
          ?>


           <?php  
         $carddesciption = $db->getcarddesciption($card_id);
          if(!empty($carddesciption)){ ?>
          <div style="display:inline-block;">
          <span class="fa fa-file-text edit-card" title="<?php echo $carddesciption; ?>"></span>
          </div>
            <?php
          }
          ?>

          <?php 
$duedatedata = $db->getbordlistduedate($card_id); ?>
<ul class="cardduedatelist list-inline">
  <?php  
  if(count($duedatedata ?? []) > 0){
    if($duedatedata['complete_status']==0){
if($duedatedata['duedate']<date('Y-m-d')){
$background = '#e91515';
}else{
  $background = '#8c8c8c';
}
    }else{
$background = 'green';
    }
  ?>
  

    
    <li style="background: <?php echo $background ?>;"  class="cardduedatelist1">
   
      <span style="color:#fff"><i class="fa fa-clock-o"></i> <?php echo date('d M',strtotime($duedatedata['duedate'])); ?>&nbsp; <?php echo $duedatedata['duetime']; ?></span></li>
    
    <?php
    
  }
  ?>
  </ul>
        


          

           <?php  
         $cardmember = $db->getcardmmber($card_id);
          if(!empty($cardmember)){ ?>
          
          <ul style="margin-bottom: 0" id="show_me1" class="list-inline">

<?php $my_user_id=$db->membersAjax($card_id);
foreach ($my_user_id as $value) {
$result = $db->getUserMeta($value);
?>
 <li class="show_me_<?php echo $value; ?>" id="show_me_<?php echo $value; ?>" style="color: #000;"><span id="profile_initials"><?php echo $result['initials']?></span></li>
 <?php
}
 ?>
  </ul>
        <?php  }
          ?>


          <!--  total attachments ends  -->
        </div>
     </div>
      
           <?php
          }
         

        }
        ?>
   </div>
   

        <div class="save-board">    
     <div style="display:none;position:relative;left: 0px;bottom:0px;width:100%;background-color: #f1f1f1;border-top: 1px solid #f1f1f1;padding:7px;z-index: 99" id="Boardlist_<?php echo $i ?>" class="cardboxnew_<?php echo $listid;?>  col-sm-12 status">
        <div style="width: 100%;">
        <form action="" method="post" id="addCardForm_<?php echo $listid ?>"  enctype="multipart/data">
         <div class="form-group" style="margin-bottom: 0px;">
            <textarea rows="3" id="cardName_<?php echo $listid; ?>" class="form-control" style="height: 50px;"></textarea>
         </div>
         <div class="col-sm-12 n-p">
           <a id="<?php echo $i."_".$listid; ?>" href="javascript:void(0)" class="list-btn save_card" onclick="return createCard(this.id);">Save</a>

           <a href="jabascript:void(0)" id="<?php echo $i."_closeList" ?>" onclick="return close_list(this.id)" style="width:16px; height: 16px;display: inline-block; margin-left: 10px;color: #000"><span class="fa fa-times"></span></a>
         </div>

        </form>
      </div>
    </div>
  </div>  
 <a href="javascript:void(0)" id="<?php echo $i; ?>_addcardbtn"  name="add_card_btn" onclick="return addCard(this.id);" class="list-btn cardsav_<?php echo $listid ?> btn btn-primary" style="display:inline-block"><i class="fa fa-plus" style="font-size:12px"></i>Add a card...</a>

   


       </div>

     </div>
     </div>
 
</div>



      <?php
        $i++;
        }
      }
      ?>

     </div>
     
    </div>
   </div>


<div style="width: 100%;min-height:100% !important; background-color: rgba(0,0,0,0.5);position: absolute;top: 0px;left: 0px; display: none;padding:0px 20px 20px 20px; z-index: 99" id="cardModal">

  <div class="col-md-4" style="background-color: #f1f1f1;height:auto !important;width:65%;left:17%; padding:20px;border-radius:5px;position:relative;top:10px;z-index:1;">
    <span class="fa fa-times pull-right close-invite"></span>
    <div class="clearfix"></div>

    <div id="cardResult" class="col-md-12 n-p" style="margin-top:0px;"></div>

 <div class="loader" id="loader" style="display:none"></div>
  </div>

</div>


<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
<input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
 <input type="hidden" name="boardid" id="boardid" value="<?php echo $bid; ?>">
 <input type="hidden" id="opencard" value="<?php echo $_SESSION['opencard'] ?? '';?>">
 



 <script type="text/javascript">
 $("#renameBoard").click(function(event) {
   /* Act on the event */
    var boardata = $("#renameBoardForm").serialize();
    //alert(boardata);
    $.post('rename-board.php', {data: boardata }, function(response) {
      //alert(response) ;
      $("#renameBoardDiv").css({'display': 'none'});
      $("#boardTitle").html(response);

    });
 });
 

function changeVisibilivt(elem){
  var bid = $("#boardid").val();
  var selectedVal = elem;
  var qstring = document.getElementById("qstring").value;
  var redirect = "dashboard.php?"+qstring;
  //alert(selectedVal);
  if( selectedVal == "0" ){  
      var vstatus = selectedVal;
      var visdata = vstatus+"_"+bid;
      $.post('board-privacy.php', {data: visdata }, function(response) {
          //alert(response) ;
          $("#BoardVisibilityDiv,#oldVis").css({'display': 'none'});
          $("#resultVisibility").html(response);
          window.location.href = redirect;
      });
    }else if (selectedVal == "2") {
    // Open the category selection popup
            $("#categoryPopup").show();
        
            // Handle category selection
            $("#confirmCategory").on("click", function () {
                var selectedCategory = $("#categorySelect").val();
                if (!selectedCategory) {
                    alert("Please select a category.");
                    return;
                }
        
                var bid = $("#boardid").val();
                var vstatus = selectedVal;
                var visdata = vstatus + "_" + bid + "_" + "_" + " "+ selectedCategory; // Include category in data
        
                // Hide popup after selection
                $("#categoryPopup").hide();
        
                // Proceed with AJAX call
                $.post('board-privacy.php', { data: visdata }, function (response) {
                    $("#BoardVisibilityDiv,#oldVis").css({ 'display': 'none' });
                    $("#resultVisibility").html(response);
                    window.location.href = redirect;
                });
            });
        }else if(selectedVal == "1"){
        $("#selectTeamDiv").css({'display':'block'});
        $("#list_status_board").css({'display': 'none'});
        window.location.href = redirect;
    }
}

function showChangeTeamDiv(){
  $("#selectTeamDiv").css({'display':'block'});
  $("#list_status_board").css({'display': 'none'});
}
$("#teambtn").click(function(event) {
  /* Act on the event */
  $("#teamDiv").css({'display':'block'});
});   
$("#changeTeam").click(function(event) {
  /* Act on the event */
  var teamid = $("#teamId").val();
  var vstatus = '1';
  var bid = $("#boardid").val();
  var qstring = document.getElementById("qstring").value;
  //alert(qstring);
  var visdata = vstatus+"_"+bid+"_"+teamid;
  $.post('board-privacy.php', {data:visdata }, function(response) {
        //alert(response) ;
        $("#BoardVisibilityDiv,#oldVis").css({'display': 'none'});
        var redirect = "dashboard.php?"+qstring;
            //alert(redirect);
        window.location.href = redirect;
    });
});

function hideChangeTeam(){
  $("#selectTeamDiv").css({'display':'none'});
  $("#list_status_board").css({'display': 'block'});
} 

function statedBoard(clicked){
      var id = clicked;
      var results = id.split('_');
      var starstatus = results[2];

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
           
            
            if(starstatus==0){
             
$('#'+id).removeClass('fa fa-star-o');
$('#'+id).addClass('fa fa-star');
            }else{
$('#'+id).removeClass('fa fa-star');
$('#'+id).addClass('fa fa-star-o');
            }
         
          }else if(obj.result=="FALSE"){
            $("#error").html(obj.message);
          }
        }
      });
      return false;
   }


function close_list(elem){
  var id = elem;
  var hideId = id.split("_");
  var div = "Boardlist_"+hideId[0];
  var listId = "list_"+hideId[0];
  document.getElementById(div).style.display = "none";
  document.getElementById(hideId[0]).style.display = "inline-block";
  document.getElementById(listId).style.minHeight = "0px";
}

function openCardModal(elem){

  
  var id = elem;
  
//  //$team_url = "dashboard.php?page=team&t=".$teamDetails['team_id']."&u=".$teamDetails['team_url']."&k=".$teamDetails['team_key'];
//   card="&card="+id;
//  alert(card);
 $("#opencard").val(id);

  $.post('./card-details.php', {data: id}, function(response) {
    document.getElementById('cardModal').style.display = "block";
    $("#cardResult").html(response);
  });

}

 var id= $("#opencard").val();
 
 if(id!=''){
  $("#loader").show();

$('#cardModal').toggle(function () {

     $.post('./card-details.php', {data: id}, function(response) {
      $("#loader").hide();
    document.getElementById('cardModal').style.display = "block";
    $("#cardResult").html(response);
  });

  
});
 }

function deleteCard(event){
  var id = event;
  //alert(id);
  $.post('./card-details.php', {data: id}, function(response) {
    document.getElementById('cardModal').style.display = "block";
    $("#cardResult").html(response);
    //var card_listid = "#<php echo $cardID; ?>";
    $(card_listid).css({"display":"none"});
    $("#DelCard_,#alert-msg").css({"display":"block"});
  });
}

$(".close-invite").click(function(event) {


 $.post('./opencard.php', {data: "removesession"}, function(response) {
 
  });

 $("#cardModal,#renameBoardDiv,.IconDiv").css({'display':'none'});
});




function closeVisibilityDiv()
{
  $("#BoardVisibilityDiv,#teamDiv").css({'display':'none'}); 
}

$(".visibility").click(function(event) {
  /* Act on the event */
  $("#BoardVisibilityDiv").css({'display':'block'});
});



function ShowRenameBoard(event){
    //alert();
    $("#renameBoardDiv").css({"display":"block"});
}

function ShowIcon(event){
    $("#IconDiv_"+ event).css({"display":"block"});
    loadImages(event);
    
}
function editListTitle(clicked){
  var id = clicked;
  //alert(id);
  var token = document.getElementById("token").value;
  var list_name = document.getElementById(id).value;
  var data = "name="+list_name+"&token="+token+"&title_id="+id;
 // alert(data);
  $.ajax({
    url: "edit_List_title.php",
    type: "POST",
    data: data,
    success: function(rel){
      var obj = jQuery.parseJSON(rel);
      if(obj.result=="TRUE")
      {
        var title = obj.message;
        $(id).html(title);
      }else if(obj.result=="FALSE"){
        $("#error").html(obj.message);
      }
    }
  });
  return false;
}

function createList(){
      var list_name = $("#list_name").val();
      if(list_name == ""){
        $("#list_name").focus();
      }else{
        var data = $("#listForm").serialize();
        $.ajax({
            url: "create_list.php",
            type: "POST",
            data: data,
            success: function(rel){
              var obj = jQuery.parseJSON(rel);
              if(obj.result=="TRUE"){
                var url = obj.url;
              // alert(obj.divwidth);
                $('#list_name').val('');
                $('.boardlistitem').append(obj.msgdata);
                $('.boardlistitem').css('width',obj.divwidth);
               location.reload();
                // window.location.href = url;
              }else if(obj.result=="FALSE"){
                  $("#listTitle").html(obj.message);
              }
            }
        });
        return false;
      }
}
$('#list_name').keypress(function(event){

  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    var list_name = $("#list_name").val();
      if(list_name == ""){
        $("#list_name").focus();
      }else{
        var data = $("#listForm").serialize();
        $.ajax({
            url: "create_list.php",
            type: "POST",
            data: data,
            success: function(rel){
              var obj = jQuery.parseJSON(rel);
              if(obj.result=="TRUE"){
                var url = obj.url;
                $('#list_name').val('');
                $('.boardlistitem').append(obj.msgdata);
                $('.boardlistitem').css('width',obj.divwidth);
               // window.location.href = url;
              }else if(obj.result=="FALSE"){
                  $("#listTitle").html(obj.message);
              }
            }
        });
        return false;
      }
  }

});
function createCard(elem){
    var id = elem;
    var hideId = id.split("_");
    var list_id = hideId[1];
    //alert(list_id);
    var cardid = "cardName_"+list_id;
    var cardname = document.getElementById(cardid).value;
    var token = document.getElementById("token").value;
    var qstring = document.getElementById("qstring").value;
    if(cardname == ""){
      document.getElementById(cardid).focus();
    }else{
      var data = "card_title="+cardname+"&list_id="+list_id+"&token="+token+"&qstring="+qstring;
      //alert(data);
      $.ajax({
            url: "create_card.php",
            type: "POST",
            data: data,
            success: function(rel){
              var obj = jQuery.parseJSON(rel);
              if(obj.result=="TRUE"){
                var url = obj.url;
                 $('#list_'+list_id).append(obj.message);
                 $('#cardName_'+list_id).val('');
                 $('.cardboxnew_'+list_id).css('display','none');
                 $('.cardsav_'+list_id).css('display','inline-block');
                //window.location.href = url;
              }else if(obj.result=="FALSE"){
                  $("#listTitle").html(obj.message);
              }
            }
        });
        return false;
    }

}

function addCard(clicked){

    var id = clicked;
    var results = id.split('_');
      id = results[0];
    document.getElementById(clicked).style.display = "none";
    
    var CurrentBoardList = "Boardlist_"+id;
    var listId = "list_"+id;
    var i;
    for (i = 1; i < 50; i++) {
      var otherBoardList = "Boardlist_"+i;
      if(CurrentBoardList == otherBoardList){
        document.getElementById(CurrentBoardList).style.display = "block";
        document.getElementById(listId).style.minHeight = "0px";
      }else{
          document.getElementById(otherBoardList).style.display = "none";
          document.getElementById(i).style.display = "inline-block";
      }
    }

  }
  
  



</script>

<script>
$(document).ready(function(){
  if( $("#cardModal").css('display') == 'block') { 
      $('body').css('overflow' , 'hidden')
  }
  else  if( $("#cardModal").css('display') == 'none') { 
      $('body').css('overflow' , 'inherit')
  }

});    
</script>




 <?php } ?>
 
 
 <script>
     
     function listBackChange(elem)
     {
         var color = elem;
    var id = $("#userid").val();
    var action = 'list_bg_color';
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
 </script>
 
 

 <style type="text/css">

  .card-label1.mod-card-front {
    float: left;
    height: 10px;
    margin: 5px 3px 3px 5px;
    padding: 0;
    line-height: 75pt;
    border-radius: 5px;
}
.span-class{
  width:100%;
  float:left;
}
.bot-img{
  margin:10px 0;
}
.img-responsive {
    max-width: 100% !important;
    margin-top: 6px;
}
</style>

<style type="text/css">
          .imagePreview<?php echo $card_id; ?>{
            background-size: cover;
            background-color: #000;
            text-align: -webkit-center;
            margin-bottom: 5px;
           }
           .imagePreview<?php echo $card_id; ?> img{
                min-height: 70px !important;
        max-height: 100px !important;
        min-width: 60px !important;
           }
           .imagePreviewDb<?php echo $card_id; ?>{
            background-size: cover;
            background-color: #000;
            text-align: -webkit-center;
            margin-bottom: 0px;
           }
           .imagePreviewDb<?php echo $card_id; ?> img{
              height: 160px;
           }
        </style>

        <style type="text/css">
        .out<?php echo $listid; ?>{
            position:relative;
            width: 288px;
         /*   height: 350px;*/
            float: left !important;
            }
          .in1<?php echo $listid; ?>{
          width:300px;
          /*height:400px;*/
          left:0;
          top:0;
          position: absolute;
          }
          .in2<?php echo $listid; ?>{
          width:300px;
          /*height:400px;*/
          position: absolute;
          left:0;
          top:0;
          z-index:-1;
          -webkit-transform: rotateY(-180deg); /* Safari */
              transform: rotateY(-180deg);

          }
          .rotate{
              -webkit-transform: rotateY(180deg); /* Safari */
              transform: rotateY(180deg);
            transition:all 1s ease-out;
          }
          .rotate1{
            -webkit-transform: rotateY(0deg); /* Safari */
            transform: rotateY(0deg);
            transition:all 1s ease-out;
            z-index: 99 !important;
          }
      .list-Title{
  letter-spacing:1px !important;
  font-family: 'Ubuntu', sans-serif;
}
.board-title-input{
      background: #eaeaea;
      padding: 5px 15px;
}
.task{
  margin-top: 0;
}
.list-Title:focus{
  border:0 !important;
  box-shadow: none !important;
}
.card-Title{
  border:0;
  margin-bottom: 7px; 
}
.card-Title:hover{
  border:0;
}
.save_card:focus, .list-btn:focus{
 color: #fff;
}
.all-item{
  display: flex;
}

#categoryPopup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    z-index: 1051; /* Bootstrap modal z-index is 1050, set higher */
}

/* If using Bootstrap, ensure backdrop is also above */
.modal-backdrop {
    z-index: 1050;
}

      </style>