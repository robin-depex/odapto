<?php 
$bid=$_REQUEST['bid'];
$board_detail=$db->get_temp_detail($bid);
$temp_boards=$db->get_temp_boards($bid);
$user_detail = $db->get_single_data('tbl_users',array('ID'=>$_SESSION['sess_login_id']));
$_SESSION['membership_id'] = $user_detail['membership_plan'];
$countbord = count($temp_boards);
$bg_img= $db->site_url.'admin/temp/images/'.$board_detail[0]['image'];
$sql = "SELECT * FROM tbl_user_template WHERE userid = '".$_SESSION['sess_login_id']."'";
//echo $sql;
$usertem = $db->get_sqldata($sql);
$counttemp = count($usertem);

//echo $counttemp;die;
//echo "<pre>"; print_r($temp_boards);die;
?>

<div class="container">
  <div class="row">
    <div class="col-sm-12 flex-pos">
          <?php include("inc/home-left-bar.php");?>

     <div class="col-sm-9" id="view">
      <div class="col-sm-12">
        <div style="padding:0" class="col-sm-12">
          <div class="banner-bg"></div>
        </div>
     <div style="padding: 0" class="col-sm-12">
     <div class="col-sm-9 left-temp">
      <h1><?php echo $board_detail[0]['name'];?> <!--(<?php if($board_detail[0]['plan_tag']==1){ echo 'Free';}else if($board_detail[0]['plan_tag']==2){ echo 'Business Class';}else if($board_detail[0]['plan_tag']=='3'){ echo 'Enterprise';} ?>)--></h1>
      <!-- <ul class="list-inline">
        <li><a href="#">Product, design, and UX</a></li>
        <li><a href="#">Software Development</a></li>
        <li><a href="#">Software Development</a></li>
      </ul> -->
<p><?php if($board_detail[0]['plan_tag']==1){ echo 'Free';}else if($board_detail[0]['plan_tag']==2){ echo 'Business Class';}else if($board_detail[0]['plan_tag']=='3'){ echo 'Enterprise';} ?> </br>
  <?php echo $board_detail[0]['description'];?></p>
      </div>
      <div class="col-sm-3">
<?php 
if($board_detail[0]['plan_tag']==$_SESSION['membership_id']){
  //echo $counttemp;
if($board_detail[0]['plan_tag']==1){ 
//echo $counttemp;
  ?>
<a class="template-btn <?php if($countbord==0){ echo 'nodata';}?>" style="cursor:pointer;" <?php if($countbord>0){  if($counttemp>=3){ ?> href="javascript:void(0)" data-toggle="modal" data-target="#cre-board_upgrade"  <?php }else{?> onclick="boartcopy(<?=$bid?>)" <?php } ?> <?php } ?>>Use template </a>

<?php }else{ ?>
  <a class="template-btn <?php if($countbord==0){ echo 'nodata';}?>" style="cursor:pointer;" <?php if($countbord>0){ ?> onclick="boartcopy(<?=$bid?>)" <?php } ?>>Use template </a> 
<?php }
 }else{
if($board_detail[0]['plan_tag']==1){ 
//die;
  ?>
 <a class="template-btn <?php if($countbord==0){ echo 'nodata';}?>" style="cursor:pointer;" <?php if($countbord>0){ echo $countbord; if($counttemp>=3){ echo $countbord."2";?> href="javascript:void(0)" data-toggle="modal" data-target="#cre-board_upgrade"  <?php }else{?> onclick="boartcopy(<?=$bid?>)" <?php } ?> <?php } ?>>Use template</a>
<?php }else{ ?>
 <a class="template-btn" href="javascript:void(0)" data-toggle="modal" data-target="#cre-board_upgrade">Use template</a> 
     <!-- <a class="template-btn" href="javascript:void(0)" data-toggle="modal" data-target="cre-board_upgrade">+<?php if($board_detail[0]['plan_tag']==2){ echo 'Business';}else if($board_detail[0]['plan_tag']=='3'){ echo 'Enterprise';} ?></a> -->
  <!-- <a class="template-btn" style="cursor:pointer;" onclick="boartcopy(<?=$bid?>)"><?php if($board_detail[0]['plan_tag']==2){ echo 'Business';}else if($board_detail[0]['plan_tag']=='3'){ echo 'Enterprise';} ?></a>-->
<?php }
 }


 /*if($board_detail[0]['plan_tag']==$_SESSION['membership_id']){ ?>
   <a class="template-btn" style="cursor:pointer;" onclick="boartcopy(<?=$bid?>)">Use template</a>
   <?php }else{ 
if($board_detail[0]['plan_tag']==1){
    ?>
   <a class="template-btn" style="cursor:pointer;" onclick="boartcopy(<?=$bid?>)">Use template</a>
<?php }else{ ?>
    <a class="template-btn" style="cursor:pointer;" onclick="boartcopy(<?=$bid?>)"><?php if($board_detail[0]['plan_tag']==1){ echo 'Free';}else if($board_detail[0]['plan_tag']==2){ echo 'Business Class';}else if($board_detail[0]['plan_tag']=='3'){ echo 'Enterprise';} ?></a>
<?php }*/ ?>

       
      </div>
     </div>
     </div>
<div class="col-sm-12">
     <div class="col-sm-12">
<div class="all-outer">
       <div class="tp-bar">
        <div class="dots"></div>
        <div class="dots"></div>
        <div class="dots"></div>
       </div>
      
          <div class="inner-sec">

             <?php if($temp_boards){ foreach ($temp_boards as $boards) { ?>
                  <div class="col-sm-6">
                    <div class="tempbgimg" style="background:url('admin/temp/images/<?php echo $boards['bg_img']; ?>');no-repeat;background-size: cover;">
                 
         <div class="list-template">
           <div style="margin:10px 0;color: #fff;">
                  Board<i style="margin-left:13px" class="fa fa-long-arrow-right fa-fw"></i>Lists<i style="margin-left:13px" class="fa fa-long-arrow-right fa-fw"></i>Cards
                   </div>
                  <h3><i class="fa fa-angle-double-right"></i> <?php echo $boards['board_name'];?></h3>
                  <div  style="display: flex; align-items: center; margin-top:-10px; margin-bottom:8px " align="center">
                    
                      <input  type="checkbox" name="board_list" class="b_ckbox" name="b_ckbox[]" id="group<?=$boards['id']?>" value="<?= $boards['id'] ?>" style="zoom:1.8"> <label for="group<?=$boards['id']?>" style="color:#fff; margin-bottom:0">&nbsp;Select to use Board</label>
              
                  </div>
                  
                  <?php $list_detail=$db->get_admin_BoardList($boards['id']);

                  foreach ($list_detail as $list_detail) { ?>
                   <div class="form-group"> <input class="sin-list" type="button" value="<?php echo $list_detail['list_title'];?>" readonly onclick="getcards(<?php echo $list_detail['id'];?>);">
  <div class="card-show" id="cards<?php echo $list_detail['id'];?>" style="display:none" ></div>
 </div>
     <?php  } ?>
                  
                  
                  </div>
                  </div>
                  </div> 
             <?php  }

}
   else{
  echo "<h1 class='text-center no-f'>No data Found</h1>";
} 
?>
          </div>
    </div>
     </div>
 </div>
    </div>
  </div>
</div>

<style type="text/css">
.tempbgimg{
  background-size: cover;
    background-position: center;
}

.banner-bg{
background-image: url(<?php echo $bg_img; ?>);
height: 200px;
background-position: center center;
background-size: cover;
border-radius: 8px;
}
.template-btn{
    padding: 11px 10px;
    border-radius: 5px;
    display: inline-block;
    margin-top: 20px;
    background: #8b46ff;
    color: #fff;
    font-size: 2rem;
}
.left-temp h1{
    color: #fff;
    font-weight: bold;
    letter-spacing: 1px;
}
.tp-bar{
    position: relative;
    width: 100%;
    border-radius: 15px 15px 0px 0px;
    padding: 7px;
    float: left;
    background: white;
    color: #fff;
}
.dots{
    width: 12px;
    height: 12px;
    background: #ccc;
    float: left;
    border-radius: 50%;
    margin: 0 4px;
}
.inner-sec{
    width: 100%;
    padding-top:0 !important;
    padding: 30px 0px;
    float: left;
    min-height:300px;
    border: 1px solid #ccc;
    background: #f1f2f5;
    display:table;
}
.no-f{
    display:table-cell;
    vertical-align: middle;
}
.list-template{
    width: 100%;
    box-shadow: 1px 5px 9px #ccc;
    border-radius: 5px;
    margin-top: 10px;
    height: 250px;
    padding: 1px 15px;
    border-top: 4px solid #dc6436;
    background: #20202075;
}
.list-template h3{
    font-size: 16px;
    margin-bottom: 15px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
    color: #fff;
}
.sin-list{
    border: 0;
    background: #dc6436;
    padding: 5px 7px;
    width: 100%;
    text-align: center;
    letter-spacing: .5px;
    color: #ffffff;
    display: block;
    border-radius: 5px;
    position:relative;
}
.all-outer{
  margin: 30px 0;
  float: left;
  width: 100%;
}
.card-show{
  text-align:center;
  color: #fff;
}
.list-template .form-group:before {
    content: "\f107";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    text-decoration: inherit;
    color: #f1f2f6;
    font-size: 18px;
    z-index: 999;
    padding-right: 0.5em;
    position: absolute;
    top: 4px;
    right: 0;
}
</style>

  <script type="text/javascript">
   function boartcopy(id){
//alert(id);
   $('#cre-board_upgrade').css('display','none');
   
    var board_type="template";
    var val = [];
        $('.b_ckbox:checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        var card_ids=val.toString();
        if(card_ids=='')
        {
            alert('Please select below boards ');
        }else{
            $.ajax({
                url: "create_board.php",
                type: "POST",
                data: {id:id,board_type:board_type,card_ids:card_ids},
                success: function(rel){
                 //alert(rel);
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
    
    /*
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
      */
   }
</script>

<script type="text/javascript">
function getcards(id)
{
var list_id=id;
//alert(list_id);
     $.ajax({
   url:"ajaxfetch.php",
   method:"POST",
   data:{type:'temp_cards',list_id:list_id},
   success:function(data)
   {
   
     //console.log(data);
    
     $( "#cards"+id).toggle();
    $("#cards"+id).html(data);
   }
  });
 
}

</script>
<script>

$('.nodata').click(function(){
$('.modal-title').html('Board not availbale in this template. Please choose another template');
$('.top').html('Ok');
$('.top').addClass('okcancel');

});


/*$('.template-btn').click(function(){
$('#cre-board_upgrade').css('display','block');

});*/

$('.okcancel').click(function(){
  alert('hfgh tdy');
$('.closemodel').css('display','none');

});

$('.closeplan').click(function(){
 
$('.closemodel').css('display','none');

});


</script>
<!--
  <div class="closemodel modal" id="cre-board_upgrade"  >
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <a class="closeplan">Close</a>
          <h4 class="modal-title text-center" style="font-size: 16px;">You are right now a <?php if($_SESSION['membership_id']==1){ echo 'Free';}else if($_SESSION['membership_id']==2){ echo 'Business';}else if($_SESSION['membership_id']==3){ echo 'Enterprise';} ?> version user and you need to upgrade your account to be able to use these features, so kindly upgrade from the option below</h4>
        </div>
        <button class="btn btn-info top"><a href="pricing.php">Upgrade</a></button>
        <div class="border"></div>
      </div>
    </div>
  </div> -->
  <!-- Modal -->
<div id="cre-board_upgrade" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Upgrade membership Plan</h5>
      </div>
      <div class="modal-body">
         <p style="color:#000;">You are right now a <b><?php if($_SESSION['membership_id']==1){ echo 'Free';}else if($_SESSION['membership_id']==2){ echo 'Business';}else if($_SESSION['membership_id']==3){ echo 'Enterprise';} ?> </b>
         version user and you need to upgrade your account to be able to use these features, so kindly upgrade from the option below</p>
      </div>
      <div class="modal-footer">
       <button class="btn btn-info "><a href="pricing.php">Upgrade</a></button>
      </div>
    </div>

  </div>
</div>


