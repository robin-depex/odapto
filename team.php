<?php 
error_reporting(0); 
$tid = $_REQUEST['t']; 
$result = $db->getTeamDetails($tid);
if(isset($_REQUEST['type'])){
  $type = $_REQUEST['type'];
  if( $type == "members"){
     $m_active = "active";
     $m_in = "in";
  }else{
     $active = "active";
     $in = "in";
  }
}else{
  $active = "active";
  $in = "in";
}

//echo json_encode($result);
if(sizeof($result) > 0){
  $team_visibility = $result['team_visibility'];
  $team_admin = $result['team_admin'];

?>

<div class="container">
  <div class="row">
  <div class="col-sm-12 top n-p">
    <span style="color:red" id="useradderror"></span>
<div class="col-sm-6" id="profile">
<h4 style="color:#FFF;margin-top: 0px;" id="team_name1"> <?php echo $result['team_name']; ?> <?php if($team_visibility == "0"){ ?>
<span style="color: #fff !important; font-size: 13px !important; margin-left: 9px"><i class="fa fa-lock" aria-hidden="true"></i> Private</span>  
<?php }else if($team_visibility == "1"){ ?>
<span style="color: #fff !important; font-size: 13px !important; margin-left: 9px"><i class="fa fa-globe" aria-hidden="true"></i> Public</span>  
<?php } ?></h4>

  <?php if(!empty($result['teamDesc'])){ ?>
  <p id="teamDesc" name="teamDesc"><?php echo trim($result['teamDesc']); ?> 
  </p>
  <?php } ?>      
  <a onclick="return editprofile()" href="javascript:void(0)" class=" btn btn-success">Edit Team Profile</a>
  </div>
<div class="col-sm-8" id="edit-pro">
<form action="" method="profile" id="profileForm">
  <div id="error"></div>
  <div class="form-group">
    <label for="email">Name</label>
    <input type="text" class="form-control" id="team_name" name="team_name" value="<?php echo trim($result['team_name']); ?>">
  </div>
  <div class="form-group">
  <label for="comment">Description (optional):</label>
  <textarea class="form-control" rows="5" id="teamDesc" name="teamDesc">
    <?php echo trim($result['teamDesc']); ?>
  </textarea>
  <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken'] ?>">
  <input type="hidden" name="tid" id="tid" value="<?php echo $result['team_id'] ?>">
  
</div>
  <button type="button" onclick="return update_profile()" class="btn btn-default">Save</button>
  <button type="button" class="btn btn-default" onclick=" return closeDiv()">cancel</button>
</form>
</div>
</div>
         
<div class="clearfix"></div>

<ul class="nav nav-tabs pull-right">

  <li class="<?php echo $active; ?>"><a data-toggle="tab" href="#Boards">Boards</a></li>
  <li class="<?php echo $m_active; ?>" ><a data-toggle="tab" href="#Members">Members</a></li>
</ul>
<div class="clearfix"></div> 
<div class="border"></div>
<div class="col-md-12">
  <div class="tab-content">
    <div id="Boards" class="tab-pane fade  <?php echo $active. " " . $in; ?>">
      <h3>Boards</h3>
      <div class="col-md-12 n-p">
      
      <?php  
      $whearteambord = array('team_id'=>$tid,'member_id'=>$_SESSION['sess_login_id']);
         $teamboard = $db->get_data('tbl_board_members',$whearteambord);
      
      foreach ($teamboard as $key => $value1) {
$whearteambord1 = array('board_id'=>$value1['board_id']);
         $value = $db->get_single_data('tbl_user_board',$whearteambord1);

$whearmetaurl = array('board_id'=>$value['board_id'],'meta_key'=>'board_url');
$whearmetakey = array('board_id'=>$value['board_id'],'meta_key'=>'board_key');
        $bordmetaurl = $db->get_single_data('tbl_user_boardmeta',$whearmetaurl);
        $bordmetakey = $db->get_single_data('tbl_user_boardmeta',$whearmetakey);


      $board_title = $value['board_title'];


     if($value['board_star'] == 0){
        $star = "fa fa-star-o";
      }else{
        $star = "fa fa-star";
      }
      $bg_color = $value['bg_color'];
             $bg_img = $value['bg_img'];
      
       if($bg_color!="" AND $bg_img!=""){
        $color="background: url('".$bg_img."') no-repeat;background-size: cover; background-position: center webkit-center";
       }
       elseif($bg_img==""){
        $color="background-color: $bg_color";
       }
       elseif ($bg_img!="") {
          $color="background: url('".$bg_img."') no-repeat;background-size: cover; background-position: center webkit-center";
       }
       else{
        $color="background-color: #CCC";
       }
       if($board_fontcolor){
        $fcolor="color: $board_fontcolor";
       }
       else{
        $fcolor="color: #fff";
       }









      $board_url = $value['board_url'];
      $board_key = $value['board_key'];
      $board_id = $value['board_id'];


       array_push($list_id,$value['board_id']);
      $board_link = "dashboard.php?page=board&b=".$value['board_id']."&t=".$bordmetaurl['meta_value']."&k=".$bordmetakey['meta_value'];
   //   $board_link = SITE_URL."dashboard.php?page=board&b=$board_id&t=$board_url&k=$board_key";

      ?>
          
        <div class="col-sm-3">

   <a href="<?php echo $board_link;?>">
         <div class="col-sm-12 n-p dash-box1"  style="<?=$color?>;min-height:150px">
           
            <div class="col-sm-10"> <h4 class="list-title"  style="<?=$fcolor;?>;"><span><?php echo $value['board_title']; ?></span></h4></div>
             
            <div class="col-sm-2">
            <?php  
            if($value['board_star'] == 0){
               ?>
                <i class="fa fa-star-o top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $value['board_id']."_".$value['board_star']; ?>"></i>
               <?php
            }else{
               ?>
                <i class="fa fa-star top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $value['board_id']."_".$value['board_star']; ?>"></i>
               <?php
            }
            ?>
           
            
            </div>
      <div class="hover-list"></div>
      <div class="hover-list-search">
        <ul class="list-inline icon-hover-list">
      <li>
         <i class="fa fa-eye" aria-hidden="true"></i>
        </li>
       </ul>
      </div>
         </div>
     
         </a>
      </div>
      <?php  
      }
      ?>

       <?php if($userplan!=1){
        $datatarget1 = '#cre-board';
      }else{
        if($owntotal_board<3){
$datatarget1 = '#cre-board';
        }else{
          $datatarget1 = '#cre-board_upgrade';
        }
      } ?>
      <div class="col-sm-3" data-toggle="modal" data-target="<?php echo $datatarget1; ?>" style="z-index:90">
         <div class="col-sm-12 n-p dash-box" style="background-color: #E2E4E6">
             <div class="col-sm-10"> <h4>Create New Board....</h4></div>
         </div>
      </div>
   
   

      </div>
    </div>
    
    <div id="Members" class="tab-pane fade <?php echo $m_active. " ". $m_in; ?>">
     <div class="col-md-12 n-p">
        <div class="col-md-3 n-p">
         <h3 class="heading">Add Members</h3>
          <hr>
          <input type="button" id="inviteTeam" class="my-btn btn-md" value="Add Members by Name or Email">

<!--  Add members to team  -->
<ul id="inviteDiv">
    <li>
      <h4 style="color:#666;text-align: left;" class="text-center mem"> Members
      <span class="fa fa-times close-invite pull-right" style="font-size:16px;"></span>
      </h4>
      
    </li>
    <hr>
     <div class="clearfix"></div>
    <li>
    <input type="hidden" id="tid" value="<?php echo $_GET['t']; ?>">
  <input type="text" id="searchTeamMember" name="searchTeamMember" value="" class="form-control" placeholder="abc@odapto.com" style="width:100%;" onKeyup="return searchTeamMember()">
  <a href="javascript:void(0)" class="pull-right"  style="margin-top:-32px;padding:7px 4px; display: none"> <span class="fa fa-search" style="font-size:18px;display:block;color: #000;"></span> </a>
    </li>
    <div class="clearfix"></div>

    <div id="teamresult"></div>
    <div class="clearfix"></div>
    <li>
    <h5 id="textAdd" style="color:#666; text-align:justify">Search for a person in Odapto by email address, or enter an email address to invite someone new.</h5>
    </li>
    <hr>
    <li>
    <a id="link_team" style="color:#666;font-size: 14px; text-align:justify" href="javascript:void(0)">Invite people by giving them a special invitation link to join this board…</a>  
        </li>
          </ul>
 </div>
        <div class="col-md-8 n-p col-md-offset-1">
          <?php  
            $result_member = $db->getAllTeamMembers($tid);
            foreach ($result_member as $value) {
             // print_r($value);
              $id = $value['member_id'];  
                $team_admindata = $db->get_single_data('tbl_users',array('ID'=>$value['member_id']));
                $result_member = $db->getUserMeta($value['member_id']);
            ?>
          <div class="col-md-12 n-p" style="margin:5px 0px;">  
          <div class="col-sm-8 n-p">
              <h3 class="heading" style="margin: 0px;"> 
          <span id="profile_initials"><?php echo $result_member['initials']; ?></span>
          <span class="heading"><?php echo $result_member['full_name'] . " (" .$team_admindata['Email_ID']; ?>)</span>
            </h3>
          </div>
          <div class="col-sm-2 n-p">
             <a href="javascript:void(0)" class="pull-right list-btn" style="font-size: 14px; display: inline-block;padding:5px 10px;"> <span class="heading"><?php echo $value['type'];?></span>  </a> 
          </div>
         <!-- <div class="col-sm-2 n-p">
          <a href="javascript:void(0)" class="pull-right list-btn" style="font-size: 14px;background-color:rgba(232, 231, 231, 0.6); display: inline-block;padding: 5px 10px;"> <span class="heading">Leave</span> <span class="fa fa-times"></span></a>
          </div>-->
          </div>
        </hr>
            <?php
            }
          ?>
        </div>
     </div>
    </div>

    <div id="Settings" class="tab-pane fade">
      <h3>Settings</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="billing" class="tab-pane fade">
      <h3>Odapto Offers</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
    </div>
  </div>


         </div>
     </div>
 </div> 

<div style="width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);position: absolute;top: 0px; display: none" id="screen-invite">
  
<div class="col-md-6  col-md-offset-3" style="background-color: #fff;height: 140px;padding: 25px;border-radius:10px;position: absolute;top:200px;z-index: 99">
  <p style="color: #000;">Anyone can join using this link: <span class="fa fa-times pull-right close-invite" style="cursor:pointer"></span></p>

  <div class="form-group">
    <?php  
    $url = $_SERVER['QUERY_STRING'];
    $uid = $_SESSION['sess_login_id'];
    date_default_timezone_set("Asia/Kolkata");
    $date = date("Ymdhis");
    $salt = "odaptonew";
    $inv_token = md5($salt.$date);
    ?>   
     <input type="hidden" name="bid" id="tid" value="<?php echo $_GET['t']; ?>">
    <input type="hidden" name="burl" id="turl" value="<?php echo $_GET['u']; ?>">
    <input type="hidden" name="bkey" id="tkey" value="<?php echo $_GET['k']; ?>">
    <input type="hidden" name="string" id="string" value="<?php echo $url; ?>">
    <input type="hidden" name="team_inv_token" id="team_inv_token" value="<?php echo $inv_token; ?>">

    <input type="text" id="invite_link" class="form-control" placeholder="" value="">
    <br>
   <a style="color:#666" href="#">Disable this link</a>
  </div>
</div>
  </div> 

<script type="text/javascript">
  
  setTimeout(function(){
    $("#error").fadeOut(fast);
  }, 2000);

  function editprofile(){
    document.getElementById('profile').style.display = "none";
    document.getElementById('edit-pro').style.display = "block";
    
  }
  function closeDiv(){
    document.getElementById('edit-pro').style.display = "none";
    document.getElementById('profile').style.display = "block";
  }

$("#inviteTeam").click(function(event) {
  //alert();
  $("#inviteDiv,#textAdd").css({'display':'block'});
  document.getElementById("searchTeamMember").value = "";
});

$("#link_team").click(function(event) {
  //alert();
  var tid = document.getElementById("tid").value;
  var turl = document.getElementById("turl").value;
  var tkey = document.getElementById("tkey").value;
  var uid = document.getElementById("userid").value;
  var inv_token = document.getElementById("team_inv_token").value;
  var data = "bid="+tid+"&burl="+turl+"&bkey="+tkey+"&uid="+uid+"&token="+inv_token+"&type=team";
 // alert(data);
  $.post('./send-invite.php', {data: data}, function(response) {
    $("#screen-invite").css({'display':'block'});
    $("#invite_link").val(response);
  });
  
});

function searchTeamMember(){

  var email = $("#searchTeamMember").val();
  var tid = document.getElementById("tid").value;
  if(email == ""){
    $("#teamresult").html("please enter an email id").css({'color':'red'});  
  }else{
    var type = "team";
    var data = "type="+type+"&email="+email+"&bid="+tid;
    //alert(data);
    $.post('./add-members.php', {data: data}, function(response) {
        $("#teamresult").css({'display':'block'});
        $("#teamresult").html(response);
        $("#textAdd").css({'display':'none'});
    });
  }
  
}


  function update_profile(){

    
    var team_name =document.getElementById('team_name').value;
  //  var short_name =document.getElementById('short_name').value;
  //  var website =document.getElementById('website').value;
    var teamDesc =document.getElementById('teamDesc').value;
      
     
    var data = $("#profileForm").serialize();
        //alert(data);  
        $.ajax({
        url: "update_team.php",
        type: "POST",
        data: data,
        success: function(rel){
       // alert(rel);
          var obj = jQuery.parseJSON(rel);
          // alert('dsbfh');
          if(obj.result=="TRUE")
          {

            $("#teamDesc").html(obj.message);
            $("#team_name1").html(obj.message1);
            $('#edit-pro').css({'display':'none'});
            $('#profile').css({'display':'block'});
          }else if(obj.result=="FALSE"){ 
            $("#error").html(obj.message);
          }
        }
      });        
      return false; 
     
      
  }

   function ShowAddProfile(){
    $("#AddProfile").css({'display':'block','top':'113px','right':'-300px'});
  }

   $(".close-div").click(function(){
    $("#AddProfile").css({'display':'none'});
  }); 
</script> 

<script type='text/javascript'>
function preview_image(event) 
{
  var tid= $("#tid").val();
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
      form_data.append('file', file_data,'tid' , tid);

//       var obj = {
//     file: form_data,
//     tid: tid
// };
//       console.log(obj);
      $.ajax({
      url: 'create_team.php', // point to server-side PHP script 
      dataType: 'text', // what to expect back from the PHP script
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      success: function (response) {

      $('#myModal-2').hide();
      $('.modal-backdrop').hide();
      $("#profile_image").attr("src","https://www.odapto.com/images/team_image/"+file_data['name']);
      //$("#profile_pic").css("background", "url(https://www.odapto.com/user_profile_Image/"+file_data['name']);
     //reload('./inc/dashboard-menu.php');
      }
      });
}
</script>  
 <?php }else{
      include("404.php");
  } ?>
 <style type="text/css">
#Members{
  position: relative;
}
  .heading{
    color: #fff;
    font-size: 16px;
  }
  .my-btn{
    background: #f56d39;
    padding: 5px 12px;
    color: #FFF;
    font-size: 12px;
    font-weight:400;
    letter-spacing:1px;
    margin-top:7px;
    display: inline-block;
    cursor: pointer; 
    outline: none;
    border: 0px;
    border-radius: 4px;
  }
  #inviteDiv{
    display:none;position: absolute;top:100px; 
    max-height:500px; 
    background-color:#f1f1f1;padding: 10px;border-radius: 6px;
    list-style: none;
  }
  #profile_initials{
    width:30px;
    height:30px;
    background-color:#024058;
    display: inline-block;
    color: #fff;
    text-align: center;
    line-height: 30px;
    border-radius: 3px;
  }
</style>