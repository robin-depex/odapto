 <?php 
 //require_once("common/config.php");
//  ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
//  session_start();
require_once('DBInterface.php');
$db = new Database();
$db->connect();
$uid = $_SESSION['sess_login_id'];
$btn_title = "Update";
$btn_id = "Update";
$path = $_SERVER['DOCUMENT_ROOT'];
?>

<span class="screen"></span>
<input type="hidden" name="token" id="token" value="<?php echo $_SESSION['Tocken']; ?>">
<input type="hidden" name="qstring" id="qstring" value="<?php echo $_SERVER['QUERY_STRING']; ?>"> 
<?php  

$star_result = $db->getStaredBoard($uid);
//echo "<pre>"; print_r($star_result);die;
$star_board = json_decode($star_result,true);
if(isset($star_board) && sizeof($star_board) > 0) { ?>
<!-- Star Board start-->
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
<?php foreach ($star_board['starBoardData'] as $key => $value) { $board_url = $value['board_url'];
         $board_key = $value['board_key'];
         $Board_title = $value['title'];
         $bid = $value['board_id'];
         $_SESSION['board_id']=$bid;
         $bstar = $value['board_star'];
         $bg_color = $value['bg_color'];
         $board_fontcolor = $value['board_fontcolor'];
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
         ?>
         <div class="col-sm-3">

          <a href="dashboard.php?page=board&b=<?php echo $bid;?>&t=<?php echo $board_url;?>&k=<?php echo $board_key;?>">
         <div class="col-sm-12 n-p dash-box1"  style="<?=$color?>;min-height:150px">
           
            <div class="col-sm-10"> <h4 class="list-title"  style="<?=$fcolor;?>;"><span><?php echo $Board_title; ?></span></h4></div>
             
            <div class="col-sm-2">
            <?php  
            if($bstar == 0){
               ?>
                <i class="fa fa-star-o top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>"></i>
               <?php
            }else{
               ?>
                <i style="color:#fff" class="fa fa-star top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $bid."_".$bstar; ?>"></i>
               <?php
            }
            ?>
      </div>
      <div class="hover-list"></div>
        <div class="hover-list-search">
          <ul class="list-inline icon-hover-list">
         <li>
            <a href="dashboard.php?page=board&b=<?php echo $bid;?>&t=<?php echo $board_url;?>&k=<?php echo $board_key;?>">
         <i class="fa fa-eye" aria-hidden="true"></i>
       </a>
        </li>
        </ul>
        </div>
         </div>
     
         </a>
      </div>
         <?php
      } ?>
 </div>
  </div>
</div>  
<!-- Star Board end-->
<?php
}    

$invited_board_result = $db->getInvitedBoard($uid);
$invited_board = json_decode($invited_board_result,true);
if(isset($invited_board) && sizeof($invited_board) > 0) { ?>
<!---Invited Board start-->
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
      foreach ($invited_board['invitedBoardData'] as $key => $value) { $board_url = $value['board_url'];
         $board_key = $value['board_key'];
         $Board_title = $value['title'];
         $bid = $value['board_id'];
         $bstar = $value['board_star'];
         $bg_color = $value['bg_color'];
         $board_fontcolor = $value['board_fontcolor'];
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
         ?>
         <div class="col-sm-3">

          <a href="dashboard.php?page=board&b=<?php echo $bid;?>&t=<?php echo $board_url;?>&k=<?php echo $board_key;?>">
         <div class="col-sm-12 n-p dash-box1"  style="<?=$color?>;min-height:150px">
           
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
         <i class="fa fa-download" aria-hidden="true"></i>
        </li>
       </ul>
      </div>
         </div>
     
         </a>
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
<!---Invited Board End-->
<!---Personal Board Start-->
<div class="container">
   <div class="row">
   <div class="col-sm-12">
<div class="clearfix"></div>        
   <div class="col-sm-12"> <h4 style="color:#FFF"><i class="fa fa-user-o" aria-hidden="true"></i> Personal Boards</h4>
   </div>
   </div>

      <div class="col-sm-12">

     <?php 
 $query1 = "select * from tbl_user_board INNER JOIN tbl_board_members ON tbl_user_board.board_id = tbl_board_members.board_id where tbl_board_members.member_id = $uid AND tbl_user_board.team_id = 0 order by tbl_user_board.board_id desc";  
            $personalboard = $db->get_sqldata($query1);
            
     if(!empty($personalboard)) {
    foreach ($personalboard as $key => $pboard) {
        $whearmetaurlp = array('board_id'=>$pboard['board_id'],'meta_key'=>'board_url');
$whearmetakeyp = array('board_id'=>$pboard['board_id'],'meta_key'=>'board_key');
        $bordmetaurlp = $db->get_single_data('tbl_user_boardmeta',$whearmetaurlp);
        $bordmetakeyp = $db->get_single_data('tbl_user_boardmeta',$whearmetakeyp);
         $bg_color = $pboard['bg_color'];
         $board_fontcolor = $pboard['board_fontcolor'];
         $bg_img = $pboard['bg_img'];
        
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
         ?>
         <div class="col-sm-3 board_filter" >
            
     <a href="dashboard.php?page=board&b=<?php echo $pboard['board_id']?>&t=<?php echo $bordmetaurlp['meta_value']; ?>&k=<?php echo $bordmetakeyp['meta_value'] ?>">
         <div class="col-sm-12 n-p dash-box1"  style="<?=$color?>;min-height:150px">
           
            <div class="col-sm-10"> <h4 class="list-title board_filter_val"  style="<?=$fcolor;?>;"><span><?php echo $pboard['board_title']; ?></span></h4></div>
             
            <div class="col-sm-2">
            <?php  
            if($pboard['board_star'] == 0){
               ?>
                <i class="fa fa-star-o top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $pboard['board_id']."_".$pboard['board_star']; ?>"></i>
               <?php
            }else{
               ?>
                <i class="fa fa-star top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $pboard['board_id']."_".$pboard['board_star']; ?>"></i>
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
      }
      
      ?>
      <?php if($userplan!=1){
        $datatarget1 = '#cre-board';
      }else{
        if(count($personalboard ?? [])<5){
        $datatarget1 = '#cre-board';
      }else{
          $datatarget1 = '#cre-board_upgrade';
        }
      } ?>
   <div class="col-sm-3 teramBoard" data-id="0" data-toggle="modal" data-target="<?php echo $datatarget1; ?>" style="z-index:90">
         <div class="col-sm-12 dash-box" style="background-color:#f7fafd">
             <div class="col-sm-10" style="margin:29px 0px 0px 31px;"> 
             <h4 style="font-size: 14px;font-weight: 600">Create New Board...</h4></div>
         </div>
  </div>

 
   </div>
      
   </div>
</div>  

<!---Personal Board End-->
<!---Team Board Start-->
<div class="container">
   <div class="row">
<div class="col-sm-12">
<div class="clearfix"></div>        
   <div class="col-sm-12"> <h4 style="color:#FFF"><i class="fa fa-user-o" aria-hidden="true"></i> Team</h4>
   </div>
   </div>
<?php 
$team_board = $db->getUserTeamDetails1($uid);
if(isset($team_board) && sizeof($team_board) > 0) { ?>

<!-- Team Board -->
      <?php
      //echo json_encode($team_board);
      if(!empty($team_board)) { foreach ($team_board as  $value) {
       
         $teamurl = "dashboard.php?page=team&t=".$value['team_id']."&u=".$value['team_url']."&k=".$value['team_key'];
         ?>
  
    <div class="col-sm-12">
      <div class="clearfix"></div>        
      <div class="col-sm-12"> 
      <h4 style="color:#FFF">
      <i class="fa fa-users" aria-hidden="true"></i> 
      <?php echo $value['team_name']; ?>
      <a href="<?php echo $teamurl; ?>" style="font-size: 14px;background-color:#8c8c8c; display: inline-block;padding: 5px 8px;margin-left: 10px;">Boards</a>
      <a href="<?php echo $teamurl; ?>&type=members" style="font-size: 14px;background-color:#8c8c8c; display: inline-block;padding: 5px 8px;margin-left: 10px;">Members</a>
      </h4>
   </div>
   </div>

      <div class="col-sm-12" id="staredBoard">    
      <?php 
      $list_id = array(); 
        $whearteambord = array('team_id'=>$value['team_id'],'member_id'=>$uid);
         $teamboard = $db->get_data('tbl_board_members',$whearteambord);
      if(!empty($teamboard)) { foreach ($teamboard as $key => $value1) {
         $whearteambord1 = array('board_id'=>$value1['board_id']);
         $value = $db->get_single_data('tbl_user_board',$whearteambord1);
         $whearmetaurl = array('board_id'=>$value1['board_id'],'meta_key'=>'board_url');
        $whearmetakey = array('board_id'=>$value1['board_id'],'meta_key'=>'board_key');
        $bordmetaurl = $db->get_single_data('tbl_user_boardmeta',$whearmetaurl);
        $bordmetakey = $db->get_single_data('tbl_user_boardmeta',$whearmetakey);
      if(!empty($value) && $value['board_star'] == 0){
        $star = "fa fa-star-o";
      }else{
        $star = "fa fa-star";
      }
    //   $bg_color = $value1['bg_color'];
    //          $bg_img = $value1['bg_img'];
    $bg_color = '';
             $bg_img = '';
      
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
        
      array_push($list_id,$value1['board_id']);
      $board_link = "dashboard.php?page=board&b=".$value1['board_id']."&t=".$bordmetaurl['meta_value']."&k=".$bordmetakey['meta_value'];

      ?>
        <div class="col-sm-3">

   <a href="<?php echo $board_link;?>">
         <div class="col-sm-12 n-p dash-box1"  style="<?=$color?>;min-height:150px">
           
            <div class="col-sm-10"> <h4 class="list-title"  style="<?=$fcolor;?>;"><span><?php if(isset($value1['board_title'])) { echo $value1['board_title']; } ?></span></h4></div>
             
            <div class="col-sm-2">
            <?php  
            if(isset($value1['board_star']) && $value1['board_star'] == 0){
               ?>
                <i class="fa fa-star-o top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php echo $value1['board_id']."_".$value1['board_star'];  ?>"></i>
               <?php
            }else{
               ?>
                <i class="fa fa-star top1" onclick="return statedBoard(this.id);" aria-hidden="true" id="star_<?php if(isset($value1['board_star']) && isset($value1['board_id'])) { echo $value1['board_id']."_".$value1['board_star']; } ?>"></i>
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
      } }
      ?>
    
   
   </div>


<?php 
} 

}
}    
?>
  </div>
</div> 
<!---Team Board End-->


<div class="container">
   <div class="row">
      <div class="col-md-12" style="margin-top: 50px; margin-bottom: 50px;">
         <?php if($userplan!=1){
        $datatarget2 = '#cre-team';
      }else{
          $datatarget2 = '#cre-board_upgrade';
      } ?>
      <a class="create-link" href="javascript:void(0)" data-toggle="modal" data-target="<?php echo $datatarget2; ?>">Create Team</a>           
      </div>
   </div>
</div>

<!-- Odapto Example Boards -->
<div class="exp-boards">
<div class="container">
   <div class="row">
     <div class="col-sm-12">
       <div class="clearfix"></div>        
       <div  id="dynamictabstrp" style="margin-bottom:20px" class="col-sm-12"><h4 style="color:#333"><i class="fa fa-star" aria-hidden="true"></i> Odapto Templates </h4> <em style="color:#333;">( Users can choose any templates as below and these templates are the starting point. Users can also choose not to choose any template and instead create boards and cards on their own. Templates are premade boards and cards set made for user's benefits. Please choose according to your choice OR choose to ignore)</em>
       
       </div>
     </div>
    
     <!-- left bar start -->
    <?php include("inc/home-left-bar.php");?>
      <!-- left bar close -->
      <div class="col-sm-9" id="mydiv">
<?php 
 $odapto_result = $db->getOdaptoBoard();
$odapto_board = json_decode($odapto_result,true);
// echo "<pre>";
// print_r($odapto_board); die;
if(isset($_REQUEST['cat']) && $_REQUEST['cat']!='featured')

{ ?>

    <script>
      $(function() {
        $('html, body').animate({
        scrollTop: $("#dynamictabstrp").offset().top
        }, 1000);
      });
    </script>
    <div class="col-sm-12" id="staredBoard" >
    <?php 
    $limit=30;
    $cat_board=$db->cat_board($_REQUEST['cat'],$limit);
 
    if($cat_board)
    {?>


      <div style="padding: 0" class="col-sm-12">
      <a style="color: #333" herf="#"><h4 style="margin-bottom: 17px;font-weight: bold"><?php echo $cat_board[0]['cat_name'];?><i style="margin-left:13px" class="fa fa-long-arrow-right fa-fw"></i></h4></a></div>
      <?php if(isset($cat_board)){foreach ($cat_board as $value) {

         $Board_title = $value['name'] ?? '';
         $bgimage=$value['image'] ?? '';
        $bgcolor = '';
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
      <div class="col-sm-4 half-padding temp_div" id="star_board_<?php echo $bid; ?>">
       <a href="dashboard.php?page=single_view&bid=<?php echo $bid;?>" class="my_class"> 
         <div class="col-sm-12 dash-box1" style="<?php echo $board_bgcolor.' '.$board_fontcolor; ?>">
           <div class="over-abs"></div>
           <!-- <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">  -->
            
            <div class="col-sm-10 content-abs"><h4><span style="<?php echo $board_fontcolor; ?>" class="temp_head" ><?php
      
            echo $Board_title.' List Template';
           
       ?></span>
     </h4>(<?php if($value['plan_tag']==1){ echo 'Free';}else if($value['plan_tag']==2){ echo 'Business Class';}else if($value['plan_tag']=='3'){ echo 'Enterprise';} ?>)</div>
           
<div class="col-sm-12">
 

  <div class="col-sm-12 box-h">
  <div class="col-sm-4">

      </div>
     </div>

</div>    
         </div>
     
     </a>
      </div>
  <?php }  }?>
    <?php }

    else{ ?>
      <div class="rounded-big px3 py5 center huge darken2">
      <div class="mb2 quieter">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" class="icon" style="shape-rendering: geometricPrecision;">
      <path fill-rule="evenodd" class="" fill="currentColor" d="M6.1485,10.2969 C4.1335,10.2969 2.5005,8.6639 2.5005,6.6489 C2.5005,4.6339 4.1335,2.9999 6.1485,2.9999 C8.1635,2.9999 9.7965,4.6339 9.7965,6.6489 C9.7965,8.6639 8.1635,10.2969 6.1485,10.2969 M14.2075,12.6429 L11.0995,9.7069 C11.0555,9.6629 10.9995,9.6419 10.9505,9.6079 C11.4835,8.7459 11.7965,7.7339 11.7965,6.6489 C11.7965,3.5339 9.2635,0.9999 6.1485,0.9999 C3.0335,0.9999 0.5005,3.5339 0.5005,6.6489 C0.5005,9.7629 3.0335,12.2969 6.1485,12.2969 C7.1495,12.2969 8.0885,12.0329 8.9045,11.5739 C8.9455,11.6409 8.9765,11.7129 9.0355,11.7709 L12.1435,14.7069 C12.5335,15.0979 13.1665,15.0979 13.5575,14.7069 L14.2075,14.0569 C14.5975,13.6669 14.5975,13.0339 14.2075,12.6429"></path>
      </svg>
      </div>
      <div class="quiet"><!-- react-text: 6535 -->No results found 
      </div>
      </div>
    <?php }
    ?>

    </div>

<?php }

else if ((isset($_REQUEST['cat']) && $_REQUEST['cat']=='featured')) {
  ?>
<script>
        $(function() {
            $('html, body').animate({
                scrollTop: $("#dynamictabstrp").offset().top
            }, 1000);
         });
    </script>
    <div class="col-sm-12" id="staredBoard"> 
      <?php 
     foreach ($odapto_board as $value) {

         $Board_title = $value['name'];
         $bgimage=$value['image'];
         $bid = $value['id']; 

if($bgimage!="" AND $bgcolor!=""){
  $board_bgcolor="background: url('admin/temp/images/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
}
elseif ($bgimage!="") {
  $board_bgcolor="background: url('admin/temp/images/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
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
      <div class="col-sm-4 half-padding temp_div" id="star_board_<?php echo $bid; ?>">
       <a href="dashboard.php?page=single_view&bid=<?php echo $bid;?>" class="my_class"> 
         <div class="col-sm-12 dash-box1" style="<?php echo $board_bgcolor.' '.$board_fontcolor; ?>">
           <div class="over-abs"></div>
           <!-- <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">  -->
            
            <div class="col-sm-10 content-abs"><h4><span style="<?php echo $board_fontcolor; ?>" class="temp_head"><?php
      
           echo $Board_title.' List Template';
           
       ?></span></h4>(<?php if($value['plan_tag']==1){ echo 'Free';}else if($value['plan_tag']==2){ echo 'Business Class';}else if($value['plan_tag']=='3'){ echo 'Enterprise';} ?>)</div>
           
<div class="col-sm-12">
  <div class="col-sm-12 box-h">
  <div class="col-sm-4">

      </div>
     </div>

</div>    
         </div>
     
     </a>
      </div>
  <?php } ?>

 
  </div>

<?php } else{ ?>
   
      <div class="col-sm-12" id="staredBoard"> 
      <?php 

    if(isset($odapto_board)) { foreach ($odapto_board as $value) {

         $board_url = $value['board_url'] ?? '';
         $board_key = $value['board_key'] ?? '';
         $Board_title = $value['name'];
         $bgimage=$value['image'];
         $bgcolor=$value['board_bgcolor'] ?? '';
        
         $bid = $value['id']; 

if($bgimage!="" AND $bgcolor!=""){
  $board_bgcolor="background: url('admin/temp/images/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
}
elseif ($bgimage!="") {
  $board_bgcolor="background: url('admin/temp/images/".$bgimage."') no-repeat;background-size: cover;background-position: center webkit-center";
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
      <div class="col-sm-4 half-padding temp_div" id="star_board_<?php echo $bid; ?>">
       <a href="dashboard.php?page=single_view&bid=<?php echo $bid;?>" class="my_class"> 
         <div class="col-sm-12 dash-box1" style="<?php echo $board_bgcolor.' '.$board_fontcolor; ?>">
           <div class="over-abs"></div>
           <!-- <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">  -->
            
            <div class="col-sm-10 content-abs"><h4><span style="<?php echo $board_fontcolor; ?>" class="temp_head"><?php
      
            echo $Board_title.' List Template';
           
       ?></span></h4>(<?php if($value['plan_tag']==1){ echo 'Free';}else if($value['plan_tag']==2){ echo 'Business Class';}else if($value['plan_tag']=='3'){ echo 'Enterprise';} ?>)</div>
           
<div class="col-sm-12">
 

  <div class="col-sm-12 box-h">
  <div class="col-sm-4">

      </div>
     </div>

</div>    
         </div>
     
     </a>
      </div>
  <?php } } ?>

 
  </div>

  <?php } ?>

</div>
</div>
  </div>
  </div>
</div>  
</div>



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
 <link rel="stylesheet" href="css/component.css" />
 <style type="text/css">
.icon-hover-list li a{
  color: #fff;
}


 </style>
<script src="js/phoneSlideshow.js"></script>
<script src="js/classie.js"></script>
<script src="js/phoneSlideshow.js"></script>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
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
        var notification = new Notification('The New Board', {body: 'this is new Board', icon: 'http://placekitten.com/100/100'});
      }
    });
  }

    });



</script>


<script type="text/javascript">
function deleteUser(elem){
  alert(elem);
    var id = elem;
    $(".Mypopup").animate({top:75}, 800).css({'display':'block'});
    $(".poptext").text('do you want to delete this Sticker');    
    $("#yes").click(function(event) {
        /* Act on the event */
        $.ajax({
            url: 'board_ajax.php',
            type: 'POST',
            data: {
                action: 'delete_board',
                id: id
            },
            beforeSend: function(){
                $(this).text('processing...');
            },
            success:function(res){
                var obj = jQuery.parseJSON(res);
                if(obj.result=="TRUE")
                {
                $("#yes").css({'display':'none'});
                $('#no').text('Cancel');
                $(".poptext").text(obj.message);
                  var url = "<?php echo "https://www.odapto.com/admin/dashboard.php?page=stickers"; ?>";
                window.location.href = url;
                }else if(obj.result=="FALSE"){ 
                    $("#yes").css({'display':'none'});
                    $('#no').text('Cancel');
                    $(".poptext").text(obj.message);
                }
            }
        })
    });
    $("#no").click(function(event) {
        /* Act on the event */
        $(".Mypopup").animate({top:-150}, 800).css({'display':'none'});
    });
    
} 

</script>


    