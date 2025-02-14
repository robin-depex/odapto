 <link rel="stylesheet" href="css/component.css" />
 <script src="js/classie.js"></script>
<script src="js/phoneSlideshow.js"></script>
<?php //error_reporting(0); ?>
<span class="screen"></span>
<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
<input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>"> 
<?php  
require_once("common/config.php");
$uid = $_SESSION['sess_login_id'];
$result = $db->getUserBoard($uid);
$result = json_decode($result, true);

$star_result = $db->getStaredBoard($uid);
$odapto_result = $db->getOdaptoBoard();

//echo json_encode($star_result);
$star_board = json_decode($star_result,true);
$odapto_board = json_decode($odapto_result,true);

$team_board = $db->getUserTeamDetails($uid);

$invited_board_result = $db->getInvitedBoard($uid);
$invited_board = json_decode($invited_board_result,true);

?>

<?php
if(sizeof($star_board) > 0) { ?>

<!-- Star Board -->

<div class="container">
   <div class="row">
     <div class="col-sm-12">
      <div class="clearfix"></div>        
        <div class="col-sm-12"> 
      <h4 style="color:#FFF">
      <i class="fa fa-star" aria-hidden="true"></i> Stared Board</h4>
   </div>
</div>

      <div class="col-sm-12" id="staredBoard"> 
<?php foreach ($star_board['starBoardData'] as $key => $value) {
         $board_url = $value['board_url'];
         $board_key = $value['board_key'];
         $Board_title = $value['title'];
         $bid = $value['board_id'];
         $bstar = $value['board_star'];
?>
      <div class="col-sm-3" id="star_board_<?php echo $bid; ?>">
         <div class="col-sm-12 dash-box1">
            <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">
            <div class="col-sm-10"> <h4><span><?php echo $Board_title; ?></span></h4></div>
            </a> 
            <div class="col-sm-2">
               <i class="fa fa-star top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>"></i>
            </div>
         </div>
      </div>
<?php } ?>
 </div>
  </div>
</div>  

<?php
}    


if(sizeof($invited_board) > 0) { ?>

<!-- Invited Board -->

<div class="container">
   <div class="row">
   <div class="col-sm-12">
      <div class="clearfix"></div>        
   <div class="col-sm-12"> 
      <h4 style="color:#FFF">
      <i class="fa fa-tags" aria-hidden="true"></i> Invited Board</h4>
   </div>
   </div>

      <div class="col-sm-12" id="invitedBoard"> 
      <?php
      
      foreach ($invited_board['invitedBoardData'] as $key => $value) {
         $board_url = $value['board_url'];
         $board_key = $value['board_key'];
         $Board_title = $value['title'];
         $bid = $value['board_id'];
         $bstar = $value['board_star'];

?>
      <div class="col-sm-3" id="star_board_<?php echo $bid; ?>">
         <div class="col-sm-12 n-p dash-box1">
            <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">
            <div class="col-sm-10"> <h4><span><?php echo $Board_title; ?></span></h4></div>
            </a> 
           <div class="col-sm-2">
            <?php  
            if($bstar == 0){
               ?>
                <i class="fa fa-star-o top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>"></i>
               <?php
            }else{
               ?>
                <i class="fa fa-star top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>"></i>
               <?php
            }
            ?>
           </div>
         </div>
      </div>
<?php 

}
?>
 </div>
  </div>
</div>  

<?php
}    
?>


<!-- Personal Boards  -->
<div class="container">
   <div class="row">
   <div class="col-sm-12">
<div class="clearfix"></div>        
   <div class="col-sm-12"> <h4 style="color:#FFF"><i class="fa fa-user-o" aria-hidden="true"></i> Personal Boards</h4>
   </div>
   </div>

      <div class="col-sm-12">

     <?php 

      if(sizeof($result) > 0) {
     // echo json_encode($result);
      foreach ($result['BoardData'] as $key => $value) {
         $board_url = $value['board_url'];
         $board_key = $value['board_key'];
         $Board_title = $value['title'];
         $bid = $value['board_id'];
         $bstar = $value['board_star'];
         $bg_color = $value['bg_color'];
         $board_fontcolor = $value['board_fontcolor'];
         $bg_img = $value['bg_img'];
        
         if($bg_color!="" AND $bg_img!=""){
          $color="background: url('https://www.odapto.com/admin/temp/images/".$bg_img."') no-repeat;background-size: cover; background-position: center webkit-center";
         }
         elseif($bg_img==""){
          $color="background-color: $bg_color";
         }
         elseif ($bg_img!="") {
            $color="background: url('https://www.odapto.com/admin/temp/images/".$bg_img."') no-repeat;background-size: cover; background-position: center webkit-center";
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
         ?>
         <div class="col-sm-3">

          <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">
         <div class="col-sm-12 n-p dash-box1"  style="<?=$color?>;">
           
            <div class="col-sm-10"> <h4 class="list-title"  style="<?=$fcolor;?>;"><span><?php echo $Board_title; ?></span></h4></div>
             
            <div class="col-sm-2">
            <?php  
            if($bstar == 0){
               ?>
                <i class="fa fa-star-o top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>"></i>
               <?php
            }else{
               ?>
                <i class="fa fa-star top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>"></i>
               <?php
            }
            ?>
           
            
            </div>
			<div class="hover-list"></div>
			<div class="hover-list-search">
			  <ul class="list-inline icon-hover-list">
			   <li>
			    <i class="fa fa-search" aria-hidden="true"></i>
			  </li>
			  <li>
			   <i class="fa fa-download" aria-hidden="true"></i>
			  </li>
			  <li>
			   <i class="fa fa-trash" aria-hidden="true"></i>
			  </li>
			   </ul>
			</div>
         </div>
		 
         </a>
      </div>
         <?php
      }
      }
      
      ?>
   <div class="col-sm-3 teramBoard" data-id="0" data-toggle="modal" data-target="#cre-board" style="z-index:90">
         <div class="col-sm-12 dash-box" style="background-color:#f7fafd">
             <div class="col-sm-10" style="margin:29px 0px 0px 31px;"> 
             <h4 style="font-size: 14px;font-weight: 600">Create New Board....</h4></div>
         </div>
  </div>
     
 
   </div>
      
   </div>
</div>  

<?php 
if(sizeof($team_board) > 0) { ?>

<!-- Team Board -->
      <?php
      //echo json_encode($team_board);
      foreach ($team_board as  $value) {
         $team_url = $value['team_url'];
         $team_key = $value['team_key'];
         $team_title = $value['team_name'];
         $team_id = $value['team_id'];
         $bid = $db->getboardId($team_id);
         $board = $db->getBoardListByTid($bid);

         $teamurl = SITE_URL."dashboard.php?page=team&t=$team_id&u=$team_url&k=$team_key";
         ?>
  <div class="container">
   <div class="row">
    <div class="col-sm-12">
      <div class="clearfix"></div>        
      <div class="col-sm-12"> 
      <h4 style="color:#FFF">
      <i class="fa fa-users" aria-hidden="true"></i> 
      <?php echo $team_title; ?>
      <a href="<?php echo $teamurl; ?>" style="font-size: 14px;background-color:#8c8c8c; display: inline-block;padding: 5px 8px;margin-left: 10px;">Boards</a>
      <a href="<?php echo $teamurl; ?>&type=members" style="font-size: 14px;background-color:#8c8c8c; display: inline-block;padding: 5px 8px;margin-left: 10px;">Members</a>
      </h4>
   </div>
   </div>

      <div class="col-sm-12" id="staredBoard">    
      <?php 
      $list_id = array(); 
      foreach ($board as $key => $value) {
       

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
      array_push($list_id,$board_id);
      $board_link = SITE_URL."dashboard.php?page=board&b=$board_id&t=$board_url&k=$board_key";

      ?>
        <div class="col-sm-3" id="star_board_<?php echo $board_id; ?>">
         <div class="col-sm-12 dash-box1">
            <a href="<?php echo $board_link; ?>">
            <div class="col-sm-10"> 
            <h4><span><?php echo $board_title; ?></span></h4>
            </div>
            </a> 
            <div class="col-sm-2">
               <i class="fa <?php echo $star; ?> top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $board_id."_".$bstar; ?>"></i>
            </div>
         </div>
		
      </div>
      <?php  
      }
      ?>
      <div class="col-sm-3 teramBoard" data-toggle="modal" data-target="#cre-board" style="z-index:90" data-id="<?php echo $team_id."_".$team_title; ?>">
        <div class="col-sm-12 dash-box" style="background-color:#f7fafd">
             <div class="col-sm-10" style="margin:29px 0px 0px 31px;"> 
             <h4 style="font-size: 14px;font-weight: 600">Create New Board....</h4></div>
         </div>
      </div>
   
   </div>
  </div>
</div>      
<?php 

}
?>


<?php
}    
?>



<div class="container">
   <div class="row">
      <div class="col-md-12" style="margin-top: 50px; margin-bottom: 50px;">
          <a class="create-link" href="javascript:void(0)" data-toggle="modal" data-target="#cre-team">Create Team</a>           
      </div>
   </div>
</div>

<!-- Odapto Example Boards -->
<div class="container">
   <div class="row">
     <div class="col-sm-12">
       <div class="clearfix"></div>        
       <div class="col-sm-12"><h4 style="color:#FFF"><i class="fa fa-star" aria-hidden="true"></i> Odapto Templates </h4> <em style="color:#fff;">( Users can choose any templates as below and these templates are the starting point. Users can also choose not to choose any template and instead create boards and cards on their own. Templates are premade boards and cards set made for user's benefits. Please choose according to your choice OR choose to ignore)</em></div>
     </div>
      <div class="col-sm-12" id="staredBoard"> 
      <?php 

    foreach ($odapto_board as $value) {

	$board_url = $value['board_url'];
         $board_key = $value['board_key'];
         $Board_title = $value['board_name'];
         $bgimage=$value['board_bgimage'];
         $bgcolor=$value['board_bgcolor'];
         // $board_bgcolor = (!empty($value['board_bgcolor']))? 'background-color:'.$value['board_bgcolor'].';' : '';
         // $board_fontcolor = (!empty($value['board_fontcolor']))? 'color:'.$value['board_fontcolor'].';' : '';
         $bid = $value['id']; 

if($bgimage!="" AND $bgcolor!=""){
  $board_bgcolor="background: url('https://www.odapto.com/admin/temp/images/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
}
elseif ($bgimage!="") {
  $board_bgcolor="background: url('https://www.odapto.com/admin/temp/images/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
}
elseif ($bgcolor!="" AND $bgimage =="") {
 $board_bgcolor="background-color: $bgcolor";
}
else{
  $board_bgcolor="background-color: #CCC";
}




		$list_count = $db->getNumRows($bid, "tbl_tmp_board_list");
		$box = json_decode($list_count,true);
    
         ?>
      <div class="col-sm-4" id="star_board_<?php echo $bid; ?>">
      
         <div class="col-sm-12 dash-box1" style="<?php echo $board_bgcolor.' '.$board_fontcolor; ?>">
        
           <!-- <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">  -->
            <a onclick="boartcopy(<?=$bid?>)" class="my_class"> 
            <div class="col-sm-10"><h4><span style="<?php echo $board_fontcolor; ?>"><?php
			
           //datais=getDataById($bid,"tbl_tmp_board_list");
           //echo $datais.'vinay-singh';
	   
           echo $Board_title.' '. $box. ' List Template';
           
		   ?></span></h4></div></a>
           
<div class="col-sm-12">
   <!--  <ul class="list-inline">
	<?php for($l=1; $l<= $box; $l++){ ?>
      <li><i style="font-size : 3em;" class="fa fa-list-alt" aria-hidden="true"></i></li>
	<?php } ?>
</ul> -->

  <div style="min-height:400px" class="col-sm-12">
  <div class="col-sm-4">
    <div class="ms-wrapper ms-effect-1">
        
          
        
            <!-- /ms-object -->

              <?php
            
             for($l=1; $l <= $box; $l++){ 
             
              ?>
			  <button style="display:none;">toggle view</button>        
        <div class="ms-perspective onhovereff" onclick="onhovereffd2()">
          <div class="ms-device">
            <div class="ms-screens">
              <a class="ms-screen-<?=$l?>"></a>
              </div>
			   </div><!-- /ms-device -->
        </div><!-- /ms-perspective -->
              <?php } ?>
         
              
            
      </div><!-- /ms-wrapper -->
      </div>
     </div>

</div>		
         </div>
		 
		 
      </div>
  <?php } ?>
  </div>
  </div>
</div>  


<!-- transorm -->

<!-- <div class="container">
  <div class="row">
  <div style="min-height:500px" class="col-sm-12">
  <div class="col-sm-4">
		<div class="ms-wrapper ms-effect-1">
				<button style="display:none;">toggle view</button>				
				<div class="ms-perspective" id="onhovereff">
					<div class="ms-device">
						<!-- /ms-object -->
						<div class="ms-screens">
							<a class="ms-screen-1"></a>
							<a class="ms-screen-2"></a>
							<a class="ms-screen-3"></a>
							<a class="ms-screen-4"></a>
							<a class="ms-screen-5"></a>
						</div>
					</div><!-- /ms-device -->
				</div><!-- /ms-perspective -->
			</div><!-- /ms-wrapper -->
			</div>
		 </div>
		</div>
  </div> -->


<!-- End Odapto Example Boards -->
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
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          //alert(obj.result);
          
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
  

   $(document).on('click','.teramBoard', function(event){
       event.preventDefault();
       var teamid = $(this).data('id');
       if(teamid != 0){
        var data = teamid.split("_");
       //alert(data[0] + data[1]);
        if(data.length > 0){
          $("#teamId").html("<option value='"+data[0]+"' selected>"+data[1]+"</option>");
        }
       }
       
       
   });
   function boartcopy(id){

var board_type="copy";
    $.ajax({
        url: "create_board.php",
        type: "POST",
        data: {id,board_type},
        success: function(rel){
         
          var obj = jQuery.parseJSON(rel);
          
          
          if(obj.result=="TRUE")
          {
            var redirect = obj.message;
           
            window.location.href = redirect;

          }
          else if(obj.result=="FALSE"){ 
            $("#error").html(obj.message);
          }
        }
      });  
   }
</script>
<script src="js/classie.js"></script>
<script src="js/phoneSlideshow.js"></script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>

// function onhovereffd2(){
  
//     $('button').trigger('click');
// }
			jQuery(document).ready(function () {
				$('button').trigger('click');
				//$('#onhovereff').hover(function(e) {
					//$('button').trigger('click');
				//});
				$('.onhovereff').click(function(e) {
					$(this).siblings('button').trigger('click');
				});
			});
		</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>


<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('082f3cbfe1813c32a88b', {
      cluster: 'ap2',
      encrypted: true
    });
    var my_event='my-event'+<?=$uid?>;
    var my_channel='my-channel'+<?=$uid?>;
     var channel = pusher.subscribe(my_channel);
    channel.bind(my_event, function(data) {
      console.log(data);

    if (!("Notification" in window)) {
      alert("This browser does not support desktop notification");
    }

    else if (Notification.permission === "granted") {
    var notification = new Notification(data.title, {body: data.body,icon: 'https://www.odapto.com/images/logopush.jpg'});
    } 
    else {
      Notification.requestPermission(function (permission) {

      if(!('permission' in Notification)) {
        Notification.permission = permission;
      }
      if (permission === "granted") {
        var notification = new Notification('The New Board', {body: 'this si new Board', icon: 'http://placekitten.com/100/100'});
      }
    });
  }

    });
  </script>