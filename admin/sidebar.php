<style type="text/css">

   .stick a:hover{
      color: #fff !important;
      background: #9c27b0 !important;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
       }
ul.newDrop li a { 
    color:#f7f7f7 !important; 
    background: #565656;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
}
ul.newDrop li:hover a{ 
    color:#fff !important; 
    background:#333 !important;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
}
.dropdown-menu {
    position: absolute;
    top: 120%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 100%;
    padding: 5px 0;
    margin: 2px 0 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 0px !important;
    border: 0px !important;
    border-radius:0px !important;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
}

    nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
      padding: 0 0px 0 0px;
    }

    .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
      color: #777;
    }

    nav.sidebar{
      width: 200px;
      height: 100%;
      margin-left: -160px;
      float: left;
      margin-bottom: 0px;
    }

    nav.sidebar li {
      width: 100%;
    }

    nav.sidebar:hover{
      margin-left: 0px;
    }

    .forAnimate{
      opacity: 0;
    }
.dropdown-menu1>li>a {
    display: block;
    padding: 8px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333;
    white-space: nowrap;
}
.nav>li>a{
padding: 8px 15px;
}
ul li{list-style:none;
}
ul{
margin:0;
padding:0;
} 
.thr-height{
  display: none;
}
.thr-ver:after{
  display: none;
}
.collapsed .fa-plus-circle:before {
    content: "\f107" !important;
}
.dropdown-toggle .fa-plus-circle:before {
    content: "\f106";
}
/*.sidebar .nav > li > a{
  background: red;
}*/
</style>

<?php  
$home_class = '';
$temp_class = '';
$board_class ='';
$user_class ='';
$addnew_user='';
$temp_catag='';
$temp_board='';
$temp_list='';
$temp_card='';
$sticker_class='';
$board_img_class='';
$users_subscription_class='';
 $board_member_plan_class='';
$all_tempi='';

if(isset($_GET['page'])){
$page = $_GET['page'];
if($page == "home"){
    $home_class = "active";
}else if($page == "user"){
    $user_class = "active";
}else if($page == "adduser"){
    $addnew_user = "active";
}else if($page == "temp"){
    $all_tempi = "active";
}else if($page == "temp_list_cat"){
    $temp_catag = "active"; 
}else if($page == "boards"){
    $temp_board = "active"; 
}else if($page == "temp_blist"){
    $temp_list = "active";    
}else if($page == "boardcards" ){
    $temp_card = "active";
}else if($page == "stickers" ){
    $sticker_class = "active";
}else if($page == "board_img" ){
    $board_img_class = "active";
}else if($page == "board_member_plan" ){
    $board_member_plan_class = "active";
}
else if($page == "users_subscription" ){
    $users_subscription_class = "active";
}
else{
    $home_class = '';
}
}
$dashboard = "dashboard.php?page=home";
$user = "dashboard.php?page=user";
$add_user = "dashboard.php?page=adduser";
$all_temp = "dashboard.php?page=temp";
$list_cat = "dashboard.php?page=temp_list_cat";
$add_cat = "dashboard.php?page=temp_add_cat";
$add_timg = "dashboard.php?page=add_timg";
$add_tboard = "dashboard.php?page=boards";
$add_tblist = "dashboard.php?page=temp_blist";
$add_tblcard = "dashboard.php?page=boardcards";
$board = "dashboard.php?page=boardmaster";
$team = "dashboard.php?page=teammaster";
$stickers= "dashboard.php?page=stickers";
$board_img= "dashboard.php?page=board_img";
$board_member_plan= "dashboard.php?page=board_member_plan";
$users_subscription= "dashboard.php?page=users_subscription";
?>

<div class="sidebar" data-color="purple" data-image="assets/img/sidebar-1.jpg">
<div class="logo">
  <a href="https://www.odapto.com/admin" class="simple-text">
   <img src="https://www.odapto.com/images/logo.png" height="50" width="100" alt="Odapto"> 
    
  </a>
</div>

<div class="sidebar-wrapper">
    <ul class="nav">
        <li class="<?php echo $home_class; ?>">
            <a href="<?php echo $dashboard ?>">
                <i class="material-icons">dashboard</i>
                <p>Dashboard</p>
            </a>
        </li>
        <!--  user menu  -->
        <li class="dropdown ">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="collapse" data-target="#first_one">
           <i class="material-icons">person</i>
                <p>User Manager <i class="fa fa-plus-circle pull-right" aria-hidden="true"></i></p>
           </a>
          <ul id="first_one" class="dropdown-menu1 collapse in newDrop firstShow" role="menu">
            <li class="divider"></li>
            <li class="<?php echo $user_class; ?>"><a href="<?php echo $user ?>"> 
            <i class="fa fa-list" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> All Users</a></li>
            <li class="divider"></li>
            <!--<li class="<?php echo $addnew_user; ?>"><a href="<?php echo $add_user; ?>"><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Add New User</a></li>-->
            <li class="divider"></li>
          </ul>
        </li>     
        
        <!-- template  -->

        <li class="dropdown open">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="collapse" data-target="#second_one">
           <i class="material-icons">person</i>
                <p>Template Manager <i class="fa fa-plus-circle pull-right" aria-hidden="true"></i></p>
           </a>
            <ul id="second_one" class="dropdown-menu1 collapse in newDrop firstShow" role="menu">
                  <li class="divider"></li>

            <li class="<?php echo $temp_catag; ?>"><a href="<?php echo $list_cat; ?>"><span class="thr-height onec">1</span><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template Category</a></li>
            <li class="divider"></li>
            <li class="<?php echo $all_tempi; ?>"><a href="<?php echo $all_temp; ?>"><span class="thr-height onec">2</span><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> All Templates</a></li>
          
           <li class="divider"></li>

           <li class="<?php echo $temp_board; ?> abs-lst thr-ver"><a href="<?php echo $add_tboard; ?>"><span class="thr-height">3</span><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template Boards</a></li>
            <li class="divider"></li>
            <li class="<?php echo $temp_list; ?> abs-lst"><a href="<?php echo $add_tblist; ?>"><span class="thr-height">4</span><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template B.List</a></li>
            <li class="divider"></li>
            <li class="<?php echo $temp_card; ?> abs-lst"><a href="<?php echo $add_tblcard; ?>"><span class="thr-height">5</span><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template BLCards</a></li>
            <li class="divider"></li>
           </ul>
        </li>  

    <!--<li class="stick <?php echo $sticker_class; ?>"><a href="<?php echo $stickers ?>"> 
            <i class="fa fa-certificate" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Stickers</a>
    </li>-->

     <li class="<?php echo $board_img_class; ?>"><a href="<?php echo $board_img ?>"> 
            <i class="fa fa-clone" style="font-size: 16px;position: relative;top: -6px;"></i> Board Images</a>
    </li>
    <li class="<?php echo $board_member_plan_class; ?>"><a href="<?php echo $board_member_plan ?>"> 
            <i class="fa fa-clone" style="font-size: 16px;position: relative;top: -6px;"></i> Members Plan</a>
    </li>
    <li class="<?php echo $users_subscription_class; ?>"><a href="<?php echo $users_subscription ?>"> 
            <i class="fa fa-clone" style="font-size: 16px;position: relative;top: -6px;"></i> Users Subscription</a>
    </li>

     <li>
  <a href="logout.php">
     <i class="material-icons">exit_to_app</i>
        <p>Logout</p>
            </a>
          </li>
      </ul>
  </div>
</div>