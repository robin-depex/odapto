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
$teamDetails = $db->getTeamDetailsByBoardId($bid);
//echo json_encode($teamDetails);die();
$url_key = $_REQUEST['k'];
$url_board_url = $_REQUEST['t'];

if( ($url_key != $board_key) || ( $url_board_url != $board_url) || ($bid != $board_id)){
  include("404.php");
}else{


?>

<style type="text/css">
.edit-card{
    position: relative;
    display: inline-block;
    width: 20px;
    height: 20px;
    margin: 0px;
    text-align: center;
    line-height: 20px;
    } 
.list-Title:focus{
      border: 0px !important;
      box-shadow: inset 0 0px 0px rgba(0,0,0,0), 0 0 0px rgba(102,175,233,0) !important;
      background: rgba(255, 255, 255, 1) !important;
    }  

</style>
<div class="container">
  <div class="row">
    <div class="col-sn-12">
      <ul class="list-inline private">
<li><h3><?php 
  $page = str_replace("-", " ", $_REQUEST['t']); 
  echo ucfirst($page);
  ?>
  </h3></li>
<li>
<?php 
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
</li>
<?php  
if($teamDetails == 0){
  $teamname = ""; 
  $display = "none";
  ?>
<li style="display:<?php echo $display; ?>">
  <a href=""><?php echo $teamname; ?></a>
</li>
  <?php 
}else{
  $teamname = $teamDetails['team_name'];  
  $display = "inline-block";
  ?>
<li style="display:<?php echo $display; ?>">
  <a href=""><?php echo $teamname; ?></a>
</li>
  <?php 

}
?>

<li>
<?php if($board_visibility == "0"){ ?>
<h5><i class="fa fa-lock" aria-hidden="true"></i> Private</h5>  
<?php }else if($board_visibility == "2"){ ?>
<h5><i class="fa fa-globe" aria-hidden="true"></i> Public</h5>  
<?php }else if($board_visibility == "1"){ ?>
<h5><i class="fa fa-users" aria-hidden="true"></i> Team Visible</h5>  
<?php } ?>
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
      <div class="col-sm-3 n-p" style="width: 288px !important; padding: 0px;float: right;margin-top: -50px; display:<?php echo $display ?>;">
       <div class="col-sm-12 task" style="padding: 10px;margin-top: 0px;">
         <form action="" method="post" id="listForm" >
         <div class="form-group" style="margin-bottom: 0px;">
           <input type="text" class="form-control input-sm" id="list_name" name="list_name" required="required" style="width:80% !important;" placeholder="Add List...">
           <a href="javascript:void(0)" class="list-btn save_card pull-right" value="Add" onclick="return createList()" style="margin-top: -30px;padding:6px 10px; ">Add</a>
         </div>
         
          <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
          <input type="hidden" name="bid" id="bid" value="<?php echo $bid; ?>">
          <input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>"> 
         </form>
       </div>
     </div>
    <hr>
     <div class="clearfix"></div>  
     <div class="col-lg-12 n-p" style="width:100%;overflow: auto; overflow-y: hidden">
     
     <div id="scroll">
      <?php  
      $list_data = $db->getBoardList($bid);
      //echo json_encode($list_data);
      if(sizeof($list_data) > 0){
      $i = 1;
      foreach ($list_data['boardList'] as  $value) {

        $listid = $value['list_id'];
      ?>
      <div class="col-sm-3 n-p"  style="width:288px;height:400px;margin-left: 10px;float: left; display: inline-block;">
      <div class="col-sm-12" style="padding-left:0px;">
       <div class="col-sm-12 task" style="background-color: #f1f1f1; padding:8px 10px;position: relative;">
        <form action="" method="post">
          <input type="text" class="form-control list-Title n-p" id="<?php echo $i."_".$value['list_id']; ?>" onblur="return editListTitle(this.id)" value="<?php echo ucfirst($value['list_title']); ?>" style="height: 20px;">
        </form>
          <a href="javascript:void(0)" id="<?php echo $i; ?>" onclick="return addCard(this.id);" class="list-btn">Add a card...</a> 
    
    <div style="height:330px;min-height:30px; max-height:auto !important;padding:5px 5px; margin-top:6px; border:1px solid #fdfdfd" id="list_<?php echo $listid; ?>">
        <?php  
        $card_data = $db->getListCard($listid);
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
      
        <div class="form-control form-contro input-sm card-Title box-item" id="<?php echo $listid."_".$card_id; ?>" onClick="return openCardModal(this.id)" itemid="<?php echo $listid."_".$card_id; ?>" style="z-index:99;display: <?php echo $dis; ?>; height: auto;">
        <div>
            <?php echo ucfirst($value['card_title']); ?>
            <span style="display: none;" class="fa fa-times pull-right" id="<?php echo $listid."_".$card_id."_ex"; ?>" onClick="deleteCard(this.id)"></span>
        </div>
          <?php  
          $count = $db->getCardCommentsCount($card_id);
          if($count == "0"){
           ?>
           <div style="visibility:hidden;">
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
          
         
        </div>

        <script type="text/javascript">
            $('.box-item').draggable({

              start:function(event, ui){
                $(this).css({'z-index':'9999 !important','position':'relative'});
              },
              cursor: 'move',
              helper: "clone"
            });
             
            $('#list_<?php echo $listid; ?>').droppable({

              drop: function(event, ui) {
                var itemid = $(event.originalEvent.toElement).attr("itemid");
                //alert(itemid);
                var clist = $(this).attr("id");
                //alert(clist);
                $('.box-item').each(function() {
                    if($(this).attr("itemid") === itemid) {
                      $(this).appendTo('#list_<?php echo $listid;?>');
                      var data = "drag="+itemid+"&drop="+clist;
                      
                       $.post('drag_drop.php', {data: data}, function(response) {
                          console.log(response);
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
      <?php 
        $i++; 
        }
      }
      ?>
     
    </div>
     </div>

<div style="width: 100%;min-height:100% !important; background-color: rgba(0,0,0,0.5);position: absolute;top: 0px;left: 0px; display: none;padding:0px 20px 20px 20px; z-index: 99" id="cardModal">
  
  <div class="col-md-4" style="background-color: #f1f1f1;height:auto !important;width:65%;left:17%; padding:20px;border-radius:5px;position:relative;top:10px;z-index:1;">
    <span class="fa fa-times pull-right" id="close-invite" style="cursor:pointer;position: absolute; right: 15px; top: 23px;"></span>
    <div class="clearfix"></div>
    <div id="cardResult" class="col-md-12 n-p" style="margin-top:0px;"></div>
  </div>

</div>  


   </div>
</div>


<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
<input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>">


 <script type="text/javascript">
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
$("#close-invite").click(function(event) {
 $("#cardModal").css({'display':'none'});
});
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

