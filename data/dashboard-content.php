<link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
<?php
error_reporting(0);
$uid = $_SESSION['sess_login_id'];
$bid = $_REQUEST['b'];

$result = $db->getBoardDetails($bid);
//echo json_encode($result);
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

$team_url = "dashboard.php?page=team&t=".$teamDetails['team_id']."&u=".$teamDetails['team_url']."&k=".$teamDetails['team_key'];
$url_key = $_REQUEST['k'];
$url_board_url = $_REQUEST['t'];

if( ($url_key != $board_key) || ($bid != $board_id)){
  include("404.php");
}else{


?>
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
    text-shadow: 1px 1px 1px rgb(0, 0, 0, 0.3);
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


</style>
<div class="container">
  <div class="row">
    <div class="col-sn-12">
<ul class="list-inline private" style="display: inline-block !important;">
<li style="position: relative;" class="listhover">
<h4 onClick="return ShowRenameBoard()" id="boardTitle"><?php $page = str_replace("-", " ", $_REQUEST['t']);
    echo ucfirst($page);
  ?>
</h4>
<div class="col-md-4" id="renameBoardDiv">
      <h6 class="heading">Rename Board
      <span class="fa fa-times pull-right close-invite"></span></h6>
      <hr>
      <form id="renameBoardForm" method="POST">
        <div class="form-group">
          <label>Name</label>
          <input type="hidden" name="boardid" id="boardid" value="<?php echo $bid; ?>">
          <input type="text" class="form-control input-md" name="boardName" id="boardName" value="<?php echo $page; ?>">
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
    </div>
  </div>
</div>

<div class="container" >
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
 <div class="col-sm-3 n-p" style="width: 288px !important; padding: 0px;float: right;margin-top: -50px; display:<?php echo $display ?>;">
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

    
    <hr>
     <div class="clearfix"></div>

<!--  main div -->

  <!-- card front -->
     <div class="col-lg-12  n-p" style="width:100%;overflow: auto; overflow-y: hidden">
     <?php 
     
     $list_data = $db->getBoardList($bid);
     $count = sizeof($list_data);
     $width = (288*$count)+50;
     ?>
     <div id="scroll" style="width:<?php echo $width.'px'; ?>">
      <?php
      
      //echo json_encode($list_data);
      if(sizeof($list_data) > 0){
      $i = 1;
      foreach ($list_data as  $value) {

        $listid = $value['list_id'];
        $listname = $value['list_title'];
        $bgimage = $value['bgimage']; 
        $bgcolor = $value['bgcolor'];
        if($bgimage!="" AND $bgcolor!=""){
          $bck="background: url('https://www.odapto.com/images/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
        }
        elseif ($bgimage=="" AND $bgcolor!="") {
           $bck="background-color: $bgcolor";
          } 
          else{
           $bck="background-color: #f7f7f7";
          } 
      ?>
      <style type="text/css">
        .out<?php echo $listid; ?>{
            position:relative;
            width: 288px;
            height: 350px;
            float: left !important;
            }
          .in1<?php echo $listid; ?>{
          width:300px;
          height:400px;
          left:0;
          top:0;
          position: absolute;
          }
          .in2<?php echo $listid; ?>{
          width:300px;
          height:400px;
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
      </style>
      <div class="out<?php echo $listid; ?>">
        
      
      <div class="col-sm-3 n-p in1<?php echo $listid; ?>" id="first<?php echo $listid; ?>" style="width:288px;height:400px;margin-left: 10px;float: left; display: inline-block;">
      <div class="col-sm-12" style="padding-left:0px;">
       <div class="col-sm-12 task" style="<?=$bck;?>; padding:8px 10px;position: relative;">

        <form action="" method="post">
          <input type="text" class="form-control list-Title n-p" id="<?php echo $i."_".$value['list_id']; ?>" onblur="return editListTitle(this.id)" value="<?php echo ucfirst($value['list_title']); ?>" style="height:27px;width: 90%">
        </form>
        <!-- flip -->
        
        <img src="images/right-arrow.png" style="color:#000;position: absolute;right: 10px;top: 10px;cursor: pointer" class="f-move pull-right" onclick="return flipclockwise(this.id)" id="<?php echo $listid; ?>">

          <a href="javascript:void(0)" id="<?php echo $i; ?>" onclick="return addCard(this.id);" class="list-btn">Add a card...</a>

    <div style="height:330px;min-height:30px; padding:5px 5px; margin-top:6px; border:1px solid #fdfdfd" id="list_<?php echo $listid; ?>" class="scrolly">

        <?php

        $card_data = $db->getListCard($listid);

        if(sizeof($card_data) > 0){

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
        <style type="text/css">
          .imagePreview<?php echo $card_id; ?>{
            background-size: cover;
            background-color: #000;
            text-align: -webkit-center;
            margin-bottom: 5px;
           }
           .imagePreview<?php echo $card_id; ?> img{
              height: 120px;
           }
           .imagePreviewDb<?php echo $card_id; ?>{
            background-size: cover;
            background-color: #000;
            text-align: -webkit-center;
            margin-bottom: 5px;
           }
           .imagePreviewDb<?php echo $card_id; ?> img{
              height: 160px;
           }
        </style>
        <div class="imagePreviewDb<?php echo $card_id; ?>"></div>
        <?php  
        $coverimage = $db->getCoverImage($card_id);
        foreach ($coverimage as $key => $valuecover) {
        ?>
        <div class="imagePreview<?php echo $card_id; ?>">
          <img src="<?php echo $valuecover['cover']; ?>" class="img-responsive">
        </div>
        <?php
        }
        ?>
        <div style="margin-bottom: 8px;float:left">
           <strong> <?php echo ucfirst($value['card_title']); ?></strong>
        </div>
        <?php
        if($stickers){
        ?>
        <div style="float: right;"><img src="<?=$stickers?>" style=" width:25px;  height:25px" ></div>
        <?php
        }
        ?>
        <!-- Labels -->
<?php  
$labels = $db->getAllCardLabels($card_id);
//print_r($labels);
if(count($labels) > 0){
?>
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

</style>

<div class="clearfix"></div>

<?php 
foreach ($labels as $value) {
?>

<span style="background: <?php echo $value['labels']; ?>; width:50px !important;" class="card-label1 mod-card-front" title="<?php if(!empty($value['labelname'])){ echo $value['labelname']; }else{ echo "&nbsp;";} ?>"></span>
<?php
}
}
?>
<!-- labels Ends -->
<div class="clearfix"></div>
<!-- Comment Count -->
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
          <div style="display:inline-block;margin-top:5px;">
          <span class="fa fa-comments edit-card"></span>
            <span class="pull-right"><?php echo $count; ?></span>
          </div>
            <?php
          }
          ?>
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
          <span class="fa fa-paperclip edit-card"></span>
            <span class="pull-right"><?php echo $countAtt; ?></span>
          </div>
            <?php
          }
          ?>
          <!--  total attachments ends  -->
        </div>

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
              alert('ok');
            }
        });
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
           <?php
          }

        }
        ?>
         </div>



        <div style="display:none;position: absolute;left: 0px;top:31px;width:100%;background-color: #f1f1f1;height:100px;border-top: 1px solid #f1f1f1;padding:7px;z-index: 9999" id="Boardlist_<?php echo $i ?>" class="col-sm-12 status">
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

     </div>
     </div>
  <div class="col-sm-3 in2<?php echo $listid; ?> n-p" id="second<?php echo $listid; ?>" style="width: 273px;height: 409px;margin-left: 10px;background: #f1f1f1;float: left;display: inline-block;position: relative;margin-top: 20px;border-radius: 5px;background-color: white;text-align: center; padding: 15px !important;"> <img src="images/right-arrow.png" class="s-move pull-right" onclick="return flipanticlockwise(this.id)" id="<?php echo $listid; ?>" style="cursor:pointer;position: absolute;top: 10px; right: 10px;"></span>
    <h4 style="margin-top:20%;font-size: 14px;width: 100%;text-align: center;">Boards <br> <img class="bot-img" src="images/down-arrow.png"> <br> <?php echo str_replace("-"," ", $_GET['t']); ?> <br> <img class="bot-img" src="images/down-arrow.png"> <br> <?php  echo  $listname; ?> </h4>
    <br style="clear: both;">
   <?php
        $card_data = $db->getListCard($listid);
        //echo json_encode($card_data);
        if(sizeof($card_data) > 0){

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

        <div class="card-Title" id="<?php echo $listid."_".$card_id."_".$bid; ?>" onClick="return openCardModal(this.id)" itemid="<?php echo $listid."_".$card_id."_".$bid; ?>" style="z-index:99;display: <?php echo $dis; ?>; height: auto;box-shadow:none;">
        <p style="color: #000; padding-left: 10px;">
            <?php echo ucfirst($value['card_title']) . $list_id;?>
        </p>
        
        </div>
        
        <?php }
        } ?>


  </div>
</div>
<script>

function flipclockwise(elem){
  var id = elem;
  //alert(id);
  $("#first"+id).addClass("rotate");
  $("#first"+id).fadeOut();
  $("#second"+id).addClass("rotate1");
  $("#second"+id).fadein().css({'position': 'absolute','z-index':'99999'});
}
function flipanticlockwise(elem){
  var id = elem;
  //alert(id);
   $("#first"+id).addClass("rotate1");
  $("#first"+id).fadeIn().css({'position': 'absolute','z-index':'99999'});;
  $("#second"+id).removeClass("rotate1");
 
  
}


</script>

      <?php
        $i++;
        }
      }
      ?>

    </div>

     </div>


<div style="width: 100%;min-height:100% !important; background-color: rgba(0,0,0,0.5);position: absolute;top: 0px;left: 0px; display: none;padding:0px 20px 20px 20px; z-index: 99" id="cardModal">

  <div class="col-md-4" style="background-color: #f1f1f1;height:auto !important;width:65%;left:17%; padding:20px;border-radius:5px;position:relative;top:10px;z-index:1;">
    <span class="fa fa-times pull-right close-invite"></span>
    <div class="clearfix"></div>
    <div id="cardResult" class="col-md-12 n-p" style="margin-top:0px;"></div>
  </div>

</div>


</div>


<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
<input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
 <input type="hidden" name="boardid" id="boardid" value="<?php echo $bid; ?>">

 <script type="text/javascript">
 $("#renameBoard").click(function(event) {
   /* Act on the event */
    var boardata = $("#renameBoardForm").serialize();
    //alert(boardata);
    $.post('rename-board.php', {data: boardata }, function(response) {
      alert(response) ;
      $("#renameBoardDiv").css({'display': 'none'});
      $("#boardTitle").html(response);

    });
 });

function changeVisibilivt(elem){
  var bid = $("#boardid").val();
  var selectedVal = elem;
  //alert(selectedVal);
  if( selectedVal == "0" ){  
      var vstatus = selectedVal;
      var visdata = vstatus+"_"+bid;
      $.post('board-privacy.php', {data: visdata }, function(response) {
          //alert(response) ;
          $("#BoardVisibilityDiv,#oldVis").css({'display': 'none'});
          $("#resultVisibility").html(response);
      });
    }else if(selectedVal == "2"){
        var bid = $("#boardid").val();
        var vstatus = selectedVal;
        var visdata = vstatus+"_"+bid;
        $.post('board-privacy.php', {data: visdata }, function(response) {
            //alert(response) ;
            $("#BoardVisibilityDiv,#oldVis").css({'display': 'none'});
            $("#resultVisibility").html(response);
        });
    }else if(selectedVal == "1"){
        $("#selectTeamDiv").css({'display':'block'});
        $("#list_status_board").css({'display': 'none'});
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
  $.post('./card-details.php', {data: id}, function(response) {
    document.getElementById('cardModal').style.display = "block";
    $("#cardResult").html(response);
  });

}

function deleteCard(event){
  var id = event;
  alert(id);
  $.post('./card-details.php', {data: id}, function(response) {
    document.getElementById('cardModal').style.display = "block";
    $("#cardResult").html(response);
    var card_listid = "#<?php echo $cardID; ?>";
    $(card_listid).css({"display":"none"});
    $("#DelCard_,#alert-msg").css({"display":"block"});
  });
}

$(".close-invite").click(function(event) {
 $("#cardModal,#renameBoardDiv").css({'display':'none'});
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
                window.location.href = url;
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
                window.location.href = url;
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
                window.location.href = url;
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
    document.getElementById(id).style.display = "none";
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
 <?php } ?>
