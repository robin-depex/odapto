 <div class="container">
  <div class="modal fade" id="cre-board" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center" style="font-size: 16px;">Create Board</h4>
        </div>
        <div class="border"></div>
        <form action="" method="POST" id="boardForm"> 
       
        
        <div class="modal-body modal-body1">
            <div class="col-sm-12 n-p">
            <label style="font-size: 16px;">Board Name</label>
            <input type="text" class="form-control input-sm form-control1" name="boardTitle" id="boardTitle" placeholder="Like “Odapto” ">
            </div>
            <div class="col-sm-12 n-p">
            <label style="font-size: 16px;">Select Team</label>
            <select class="form-control input-sm form-control1" name="teamId" id="teamId">
              <option value="0">No Team</option>
              <?php  
              $result = $db->getTeamList($uid);
              foreach ($result as $value) { ?>
               <option value="<?php echo $value['team_id'] ?>"
               <?php if($value['team_id'] == $_GET['t']){
                echo "selected";
                }?>
               ><?php echo $value['team_name']; ?></option>   
              <?php } ?>
              
            </select>
          </div>
            <div class="col-sm-12 n-p">
            <label style="font-size: 16px;">Select Privacy</label>
            <?php
                $previlage = $db->getUserPrivilage($uid);
            ?>
            <select class="form-control input-sm form-control1" name="board_privacy" id="board_privacy">
              <option value="0">Private</option>
              <?php if($previlage == '1') { ?>
              <option value="1">Public</option>
              <?php } ?>
            </select>
            </div>
            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
  <input value="Create" onclick="return create_board();" type="button" class="btn btn-info top">
        </div>
        </form>
      </div>
    </div>
  </div>
</div>


 <div class="container">
  <div class="modal fade" id="cre-board_upgrade" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center" style="font-size: 16px;">You are right now a free version user and you need to upgrade your account to be able to use these features, so kindly upgrade from the option below</h4>
        </div>
        <button class="btn btn-info top"><a href="pricing.php">Upgrade</a></button>
        <div class="border"></div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="modal fade" id="cre-team" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">Create Personal Team</h4>
       
        
        </div>
        <div class="border"></div>
        <form action="" method="post" id="teamForm">
        <div class="modal-body modal-body1">
        <div id="error"></div>
        <div class="form-group">
           <label>Name</label>
            <input type="text" required="required" class="form-control input-lg form-control1" id="teamname" name="teamname" placeholder="Like “ Odapto”">
            </div>
           <div class="form-group">
            <label>Description (optional)</label>
            <textarea class="form-control form-control1" id="teamDesc" name="teamDesc" required="required" rows="5"></textarea>
          </div>
          <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
          <input value="Create Team" type="button" onclick="return createTeam()" class="btn btn-info">
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <!-- Trigger the modal with a button -->
  <!-- Modal -->
  <div class="modal fade" id="cre-busi" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">Create Business Team</h4>
        </div>
        <div class="border"></div>
        <div class="modal-body modal-body1">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control input-lg form-control1" id="myinput" placeholder="Like “ Odapto”">
            </div>
           <div class="form-group">
           <label>Description (optional)</label>
    
          <textarea class="form-control form-control1" rows="5" id="comment"></textarea>
        </div>
<input value="Create" type="button" class="btn btn-info">
        </div>
      </div>
    </div>
  </div>
</div>


<div style="width: 100%; height: 100%; background-color: rgba(0,0,0,0);position: absolute;top: 0px;left:0px; display: none" id="screen-invite">
  

<div class="col-md-6  col-md-offset-3" style="background-color: #fff;height: 140px;padding: 25px;border-radius:10px;position: absolute;top:45%;z-index: 99;box-shadow: 0px 0px 15px 5px rgba(47, 47, 47, 0.5);">
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
    <input type="hidden" name="bid" id="bid" value="<?php echo $_GET['b']; ?>">
    <input type="hidden" name="burl" id="burl" value="<?php echo $_GET['t']; ?>">
    <input type="hidden" name="bkey" id="bkey" value="<?php echo $_GET['k']; ?>">

    <input type="hidden" name="inv_token" id="inv_token" value="<?php echo $inv_token; ?>">

    <input type="text" id="invite_link" class="form-control" placeholder="" value="">
    <br>
   <a style="color:#666" href="#">Disable this link</a>
  </div>
</div>
  </div>   

<input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['sess_login_id']; ?>">

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="js/toggleMenu.js"></script>
<script src="https://www.odapto.com/js/demo.js"></script>


<!-- push notification -->
<script src="https://www.odapto.com/js/push_notification.js"></script>


<script>
 $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group"><div><input id="demo" class="form-control" type="text" name="mytext[]"/><a href="#" class="remove_field"><i class="fa fa-times fonto" aria-hidden="true"></i></a></div><a class="list-btn">add</a></div>')
      
      ; //add input box
        }
    });
    setTimeout(function() {
      $('.error').fadeOut('fast');
    }, 2000);
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>

<script>

$("#link_model").click(function(event) {
  //alert();
  var bid = document.getElementById("bid").value;
  var burl = document.getElementById("burl").value;
  var bkey = document.getElementById("bkey").value;
  var uid = document.getElementById("userid").value;
  var inv_token = document.getElementById("inv_token").value;
  var data = "bid="+bid+"&burl="+burl+"&bkey="+bkey+"&uid="+uid+"&token="+inv_token;
  $.post('./send-invite.php', {data: data}, function(response) {
    $("#screen-invite").css({'display':'block'});
    $("#invite_link").val(response);
  });
  
});
$(".close-invite").click(function(event) {
 $("#screen-invite,#inviteDiv").css({'display':'none'});
 $("#result,#seltoad").css({'display':'none'});
 document.getElementById("searchMember").value = "";
});

$("#inviteBtn").click(function(event) {
  //alert();
  $("#inviteDiv,#textAdd").css({'display':'block'});
  document.getElementById("searchMember").value = "";
});

function searchMember(){
  var email = $("#searchMember").val();
  var bid = $("#bid").val();
  if(email == ""){
    $("#result").html("please enter an email id").css({'color':'red'});  
  }else{
    var type = "board";
    var data = "type="+type+"&email="+email+"&bid="+bid;
    $.post('./add-members.php', {data: data}, function(response) {
        $("#result").css({'display':'block'});
        $("#result").html(response);
        $("#textAdd").css({'display':'none'});
    });
  }
  
}




function filter_cards(){
  var card = $("#filter_cards").val();
  alert(card);
  var bid = $("#bid").val();
  if(email == ""){
    $("#filtercard_result").html("Please Enter Card name").css({'color':'red'});  
  }else{
    var type = "card";
    var data = "type="+type+"&email="+card+"&bid="+bid;
    $.post('./add-members.php', {data: data}, function(response) {
        $("#filtercard_result").css({'display':'block'});
        $("#filtercard_result").html(response);
        //$("#textAdd").css({'display':'none'});
    });
  }
  
}

function mine(){
   var send = document.getElementById("get").value;
   document.getElementById("demo").innerHTML =send;
   document.getElementById("get").value="";
}

var acc = document.getElementsByClassName("accordion");
var i;

for(i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
     panel.style.maxHeight = null;
    } else {
     panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  }
}
</script>
<style>
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.83);
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size:15px;
    color: #fff;
    display: block;
    transition: 0.3s
}

.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<script>



function create_board(){

  var  board_title = document.getElementById('boardTitle').value;
  var  teamId = document.getElementById('teamId').value;
  
  if(board_title == ""){
    $("#boardTitle").attr("placeholder","please enter board title").focus();
  }else{
        var data = $("#boardForm").serialize();
       // alert(data);  
        $.ajax({
        url: "create_board.php",
        type: "POST",
        data: data,
        success: function(rel){
         // alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            
            var redirect = obj.message;
            //alert(redirect);
            window.location.href = redirect;
            
          }else if(obj.result=="FALSE"){ 
            $("#error").html(obj.message);
          }
        }
      });        
      return false;  
  }
   
}

function createTeam(){
  var teamname = document.getElementById("teamname").value;
  var teamDesc = document.getElementById("teamDesc").value;
  if(teamname == ""){
    $("#teamname").attr("placeholder","please enter team name").foucus();
  }else{
     var data = $("#teamForm").serialize();
       // alert(data);  
        $.ajax({
        url: "create_team.php",
        type: "POST",
        data: data,
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            
            var redirect = obj.message;
            //alert(redirect);
            window.location.href = redirect;
            
          }else if(obj.result=="FALSE"){ 
            $("#error").html(obj.message);
          }
        }
      });        
      return false;  
  }
}

function openNav() {
    document.getElementById("mySidenav").style.width = "350px";
    document.getElementById("main").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}

</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
    count_unseen_notifications();
    setInterval(function(){
    		count_unseen_notifications();
    	
    	}, 90000);
    function count_unseen_notifications()
    {
       var user_to=<?php echo $_SESSION['sess_login_id']; ?>;
      
        $.ajax({
    			url:"live_chat/count_unseen_message.php",
    			method:"POST",
    			data :{'notify_user_to':user_to,'action':'unseen_notification'},
    			success:function(data){
    			    //console.log(data);
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
</html>
