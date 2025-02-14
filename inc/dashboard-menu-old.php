<div class="head-top">
   <div class="container">
      <div class="row">
         <div class="col-sm-12 n-p">
            <div class="col-sm-4">
              <ul class="list-inline">
                 <li> 
                 <div id="dropdown" class="dropdown">
<div id="login" onclick="myFunction()" class="dropbtn less">Boards</div>
  
  <div id="login-panel" class="dropdown-content">
    <a> <input type="text" class="form-control my-input" id="myInput" onkeyup="filterFunction()" placeholder="Find boards by name..."></a>
    <a href="#home">Recent Board</a>
    <a href="javascript:void();" >Personal Boards</a>

    <a href="dashboard1.html">Create new board</a>
    <a href="#about">Always keep the menu open</a>
    <a>See closed boards</a>
  </div>
</div> 
</li>
<li><div class="form-group">
<input type="text" class="form-control form-control1" id="myinput" placeholder="">
<i style="color:white" class="fa fa-search fonto" aria-hidden="true"></i>
</div></li>
      </ul>
         </div>
            <div class="col-sm-3">
              <a href="dashboard.php?page=home"><img src="images/small-logo.png" class="img-responsive auto"></a>
            </div>
              <div class="col-sm-5">
              <ul class="list-inline">
                 <li> <div class="dropdown">
<div id="login1" onclick="myFunction()" class="dropbtn less"><i class="fa fa-plus" aria-hidden="true"></i></div>

<div id="login-panel1" class="dropdown-content str-po">
    <h4 class="text-center">Create</h4>
     <div class="col-xs-12 border"></div>
    
    <a data-toggle="modal" data-target="#cre-board" href="#home">
     <p><small>Create Board...</small></p>
    <p><small>A board is a collection of cards
ordered in a list of lists. Use it to
manage a project, track a collection or
organize anything.</small></p></a>
 <div class="col-xs-12 border"></div>
    <a data-toggle="modal" data-target="#cre-team" href="#home">
     <p><small>Create Personal Team...</small></p>
    <p><small>A team is a group of boards and
people. Use it to group boards in your
company,team, or family.</small></p></a>
 <div class="col-xs-12 border"></div>
<a data-toggle="modal" data-target="#cre-busi" href="#home">
     <p><small>Create Business Team...</small></p>
    <p><small>With Business Class. your team has
more security administrative controls
and superpowers.</small></p></a>
  </div>

</div> </li>
<li> <div class="dropdown">
<div id="login2" onclick="myFunction()" class="dropbtn less"><?php echo $_SESSION['fullname']; ?></div>
  <div id="login-panel2" class="dropdown-content str-po">
    <a href="dashboard.php?page=profile">Profile</a>
    <a href="javascript:void(0)">Cards</a>
         <a href="javascript:void(0)">Create new board</a>
           <a href="javascript:void(0)">Settings</a>
           <a href="javascript:void(0)">Help</a>
           <a href="javascript:void(0)">Shortcuts</a>
           <a href="javascript:void(0)">Change Language</a>
           <a href="logout.php">Log Out</a>
      </div>
</div> </li>

<li> 
<div class="dropdown">
<div id="login4" onclick="myFunction()" class="dropbtn less"><i class="fa fa-question-circle" aria-hidden="true"></i></div>
  <div id="login-panel4" class="dropdown-content str-po">
    <h4 class="text-center">Information</h4>
     <div class="col-xs-12 border"></div>
        <img src="images/short-sett.jpg" class="img-responsive auto">
        <div class="col-sm-8 col-sm-offset-2 check">
        <h5 class="text-center">New to Odapto? Check Out The  Guide</h5>
        <a style="color:#f56d39" class="text-center" href="#">Get a tip</a>
        </div>
        <div class="col-xs-12 border"></div>
        <ul class="list-inline info-list">
         <li><a href="#">Tour</a></li>
         <li><a href="#">Pricing</a></li>
         <li><a href="#">Apps</a></li>
         <li><a href="#">Blog</a></li>
          <li><a href="#">More..</a></li>
        </ul>
    </div>
</div> 
</li>

<li> <div class="dropdown">
<div id="login3" onclick="myFunction()" class="dropbtn less"><i class="fa fa-bell-o" aria-hidden="true"></i></div>
  <div id="login-panel3" class="dropdown-content str-po">
    <h4 class="text-center">Notifications</h4>
     <div class="col-xs-12 border"></div>
      <p class="text-center">No Notification Yet</p>
  </div>
</div> </li>

<li> 
<div class="dropdown">
<div id="login5" onclick="myFunction()" class="dropbtn less"><i class="fa fa-cog" aria-hidden="true"></i></div>
<div id="login-panel5" class="dropdown-content str-po">
    <h4 class="text-center">Notifications</h4>
     <div class="col-xs-12 border"></div>
      <p class="text-center">No Notification Yet</p>
  </div>
</div> </li>

<li> 
<div class="dropdown">
<div id="login5" onclick="openNav()" class="dropbtn less"><i class="fa fa-list" aria-hidden="true"></i></div>
</li>
<!--  side nav-->
<div id="mySidenav" class="sidenav" style="padding-top:0px">

<div class="col-xs-12">
<div class="col-xs-8">
  <h3 style="color:#FFF" class="text-center"><strong>Menu</strong></h3>
</div>
<div class="col-xs-3 pull-right text-center">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
</div>
</div>

<div class="clearfix"></div>
<div class="border"></div>
<div class="col-xs-12">
  <div class="col-xs-4 text-center qa-b"></div>
  <div class="col-xs-8">
      <a href="#home">Invited Members</a>    
  </div>
</div>
  
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>

<div class="col-sm-12">
<div class="col-xs-4 text-center qa-b"></div>
<div class="col-xs-8">
  <a href="#" data-toggle="modal" data-target="#change-bg">Change Background</a>
</div>  
</div>

<div class="clearfix"></div>
<div class="col-sm-12 border"></div>

<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/filter.png"></div> 
  <div class="col-xs-8">
    <a href="#about">Filter Cards</a>
  </div>  
</div>
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>
<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/intigrate.png">
  </div> 
  <div class="col-xs-8">
    <a href="#about">Integrate</a>
  </div>  
</div> 
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>
<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/sticker.png">
  </div> 
  <div class="col-xs-8">
    <a href="#about">Stickers</a>
  </div>  
</div>
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>
<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/ques.png">
  </div> 
  <div class="col-xs-8">
    <a href="#about">Suggest a template</a>
  </div>  
</div>
</div>

      </ul>
     </div>
   </div>
 </div>
</div>
</div>


<!--  side nav-->
<!-- <div id="mySidenav" class="sidenav" style="padding-top:0px">

<div class="col-xs-12">
<div class="col-xs-8">
  <h3 style="color:#FFF" class="text-center"><strong>Menu</strong></h3>
</div>
<div class="col-xs-3 pull-right text-center">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
</div>
</div>

<div class="clearfix"></div>
<div class="border"></div>
<div class="col-xs-12">
  <div class="col-xs-4 text-center qa-b"></div>
  <div class="col-xs-8">
      <a href="#home">Invited Members</a>    
  </div>
</div>
  
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>

<div class="col-sm-12">
<div class="col-xs-4 text-center qa-b"></div>
<div class="col-xs-8">
  <a href="#" data-toggle="modal" data-target="#change-bg">Change Background</a>
</div>  
</div>

<div class="clearfix"></div>
<div class="col-sm-12 border"></div>

<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/filter.png"></div> 
  <div class="col-xs-8">
    <a href="#about">Filter Cards</a>
  </div>  
</div>
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>
<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/intigrate.png">
  </div> 
  <div class="col-xs-8">
    <a href="#about">Integrate</a>
  </div>  
</div> 
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>
<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/sticker.png">
  </div> 
  <div class="col-xs-8">
    <a href="#about">Stickers</a>
  </div>  
</div>
<div class="clearfix"></div>
<div class="col-sm-12 border"></div>
<div class="col-sm-12">
  <div class="col-xs-4 text-center qa-b">
    <img src="images/ques.png">
  </div> 
  <div class="col-xs-8">
    <a href="#about">Suggest a template</a>
  </div>  
</div>
</div>        
 -->    