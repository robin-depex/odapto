<?php  
$home_class = '';
$temp_class = '';
$board_class ='';
$user_class ='';
if(isset($_GET['page'])){
$page = $_GET['page'];
if($page == "home"){
    $home_class = "active";
}else if($page == "user" || $page == "adduser" || $page == "cpass"){
    $user_class = "active";
}else if($page == "temp" || $page == "temp_list_cat" || $page == "temp_add_cat" || $page == "add_timg" || $page == "boards" || 
		 $page == "add_tblist" || $page == "add_tblcard"){
    $temp_class = "active";
}else if($page == "board" ){
    $board_class = "active";
}else{
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
?>
<style type="text/css">
ul.newDrop li a { 
    color:#f7f7f7 !important; 
    background:#9c27b0;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
}
ul.newDrop li:hover a{ 
    color:#fff !important; 
    background:#9c27b0 !important;
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
padding:0;}	
</style>
<div class="sidebar" data-color="purple" data-image="assets/img/sidebar-1.jpg">
<div class="logo">
	<a href="https://www.odapto.com" class="simple-text">
		Odapto
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
        <li class="dropdown <?php echo $user_class; ?>">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="collapse" data-target="#first_one">
           <i class="material-icons">person</i>
                <p>User Manager <i class="fa fa-plus-circle pull-right" aria-hidden="true"></i></p>
           </a>
          <ul id="first_one" class="dropdown-menu1 collapse in newDrop firstShow" role="menu">
            <li class="divider"></li>
            <li><a href="<?php echo $user ?>"> 
            <i class="fa fa-list" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> All Users</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $add_user; ?>"><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Add New User</a></li>
            <li class="divider"></li>
          </ul>
        </li>     
        
        <!-- template  -->

        <li class="dropdown open <?php echo $temp_class; ?>">
          <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="collapse" data-target="#second_one">
           <i class="material-icons">person</i>
                <p>Template Manager <i class="fa fa-plus-circle pull-right" aria-hidden="true"></i></p>
           </a>
         <ul id="second_one" class="dropdown-menu1 collapse in newDrop firstShow" role="menu">
            <li class="divider"></li>
            <li><a href="<?php echo $all_temp; ?>"><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> All Templates</a></li>
            <li class="divider"></li>

            <li><a href="<?php echo $list_cat; ?>"><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template Category</a></li>
           <li class="divider"></li>

            <li><a href="<?php echo $add_tboard; ?>"><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template Boards</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $add_tblist; ?>"><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template B.List</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $add_tblcard; ?>"><i class="fa fa-user" style="font-size: 16px;position: relative;top: -6px;color: #fff"></i> Template BLCards</a></li>
            <li class="divider"></li>
           </ul>
        </li>     
  <li class="<?php echo $board_class; ?>">
            <a href="<?php echo $board ?>">
                <i class="material-icons">content_paste</i>
                <p>Board Master</p>
            </a>
  </li>
  <li>
      <a href="<?php echo $team ?>">
                <i class="material-icons">library_books</i>
                <p>Team master</p>
      </a>
  </li>

  <li>
      <a href="<?php echo $stickers ?>">
                <i class="material-icons">library_books</i>
                <p>Add Stickers</p>
      </a>
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