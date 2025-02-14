 
<?php 

require_once("common/config.php");
require_once("DBInterface.php");
$db = new Database();
$db->connect();

if($_REQUEST['type']=='temp_search')
{
$limit=30;
//print_r($_REQUEST);die;
 $cat_board=$db->search_template($_REQUEST['query'],$limit);

 // print_r($cat_board);
 //  echo 'dsfdsfsdfdsfdsfsdfsdfds';
 //  print_r($cat_board[0]['cat_name']);die;
if($cat_board)
{?>


  <div style="padding: 0" class="col-sm-12">
    <a style="color: #333" herf="#"><h4 style="margin-bottom: 17px;font-weight: bold"><?php echo $cat_board[0]['cat_name'];?>
    <i class="fa fa-angle-right"></i></h4></a>
  </div>
  <?php if($cat_board){foreach ($cat_board as $value) {

         // $board_url = $value['board_url'];
         // $board_key = $value['board_key'];
         $Board_title = $value['name'];
         $bgimage=$value['image'];
         //$bgcolor=$value['board_bgcolor'];
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
      <div class="col-sm-4 half-padding" id="star_board_<?php echo $bid; ?>">
       <a href="dashboard.php?page=single_view&bid=<?php echo $bid;?>" class="my_class"> 
         <div class="col-sm-12 dash-box1" style="<?php echo $board_bgcolor.' '.$board_fontcolor; ?>">
           <div class="over-abs"></div>
           <!-- <a href="<?php echo SITE_URL."dashboard.php?page=board&b=$bid&t=$board_url&k=$board_key" ?>">  -->
            
            <div class="col-sm-10 content-abs"><h4><span style="<?php echo $board_fontcolor; ?>"><?php
      
           //datais=getDataById($bid,"tbl_tmp_board_list");
           //echo $datais.'vinay-singh';
     
          // echo $Board_title.' '. $box. ' List Template';
            echo $Board_title.' List Template';
           
       ?></span></h4></div>
           
<div class="col-sm-12">
   <!--  <ul class="list-inline">
  <?php for($l=1; $l<= $box; $l++){ ?>
      <li><i style="font-size : 3em;" class="fa fa-list-alt" aria-hidden="true"></i></li>
  <?php } ?>
</ul> -->

  <div class="col-sm-12 box-h">
  <div class="col-sm-4">

      </div>
     </div>

</div>    
         </div>
     
     </a>
      </div>
  <?php } }?>
<?php }

else{ ?>
<div class="rounded-big px3 py5 center huge darken2">
  <div class="mb2 quieter">
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" class="icon" style="shape-rendering: geometricPrecision;">
      <path fill-rule="evenodd" class="" fill="currentColor" d="M6.1485,10.2969 C4.1335,10.2969 2.5005,8.6639 2.5005,6.6489 C2.5005,4.6339 4.1335,2.9999 6.1485,2.9999 C8.1635,2.9999 9.7965,4.6339 9.7965,6.6489 C9.7965,8.6639 8.1635,10.2969 6.1485,10.2969 M14.2075,12.6429 L11.0995,9.7069 C11.0555,9.6629 10.9995,9.6419 10.9505,9.6079 C11.4835,8.7459 11.7965,7.7339 11.7965,6.6489 C11.7965,3.5339 9.2635,0.9999 6.1485,0.9999 C3.0335,0.9999 0.5005,3.5339 0.5005,6.6489 C0.5005,9.7629 3.0335,12.2969 6.1485,12.2969 C7.1495,12.2969 8.0885,12.0329 8.9045,11.5739 C8.9455,11.6409 8.9765,11.7129 9.0355,11.7709 L12.1435,14.7069 C12.5335,15.0979 13.1665,15.0979 13.5575,14.7069 L14.2075,14.0569 C14.5975,13.6669 14.5975,13.0339 14.2075,12.6429"></path>
    </svg>
  </div>
  <div class="quiet"><!-- react-text: 6535 -->No results found for <?php echo $_REQUEST['query'];?>
  </div>
</div>
<?php }


}


if($_REQUEST['type']=='temp_cards')
{
  $list_cards=$db->get_admin_Boardcards($_REQUEST['list_id']);
if($list_cards)
{
  foreach ($list_cards as $list_cards) {
   echo $list_cards['card_name'];//$list_cards['id'];
   echo '<br>';
  }
}
else
{
  echo "No Card Found";
}
 //print_r($list_cards);die;
}
 ?>
