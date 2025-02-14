<?php
session_start();
if(empty($_SESSION['appoint_email'])){
  header("Location: auth.php");
}
include('config.php');
$con = dbconnect();

if(isset($_POST['save_setting_basic'])){

if($_POST['admin_title'] != ''){
  $admin_title = "admin_title = '".$_POST['admin_title']."',";
}

if(!empty($_POST['appointment_desc'])){
  $appointment_desc = "appointment_desc ='".$_POST['appointment_desc']."',";  
}

if(!empty($_POST['contactor_currency'])){
  $contactor_currency = "contactor_currency ='".$_POST['contactor_currency']."',";  
}

if(!empty($_POST['contactor_price'])){
  $contactor_price = "contactor_price ='".$_POST['contactor_price']."',";  
}

if(!empty($_POST['contactor_name'])){
  $contactor_name = "contactor_name ='".$_POST['contactor_name']."',";  
}

if(!empty($_POST['contactor_email'])){
  $contactor_email = "contactor_email ='".$_POST['contactor_email']."',";
}

if(!empty($_POST['mobile'])){
  $mobile = "mobile ='".$_POST['mobile']."',";
}

if($_FILES['image']['name'] !=''){

  if($_FILES['image']['error'] > 0) { $image_msg = 'Error during uploading, try again'; }
  $extsAllowed = array('jpg', 'jpeg', 'png', 'gif');
  $extUpload = strtolower(substr(strrchr($_FILES['image']['name'], '.') ,1) ) ;
  if(in_array($extUpload, $extsAllowed)){ 
  $name = "img/{$_FILES['image']['name']}";
  $result = move_uploaded_file($_FILES['image']['tmp_name'], $name);
  if($result){ $image_msg = "<img src='$name' class='img-thumbnail pull-right' />"; }
  }else{ $image_msg = 'File is not valid. Please try again'; }
  
  $image = "image ='".$_FILES['image']['name']."',";  
}

if(!empty($_POST['city'])){
  $city = "city ='".$_POST['city']."',";  
}

if(!empty($_POST['state'])){
  $state = "state ='".$_POST['state']."',";  
}

if(!empty($_POST['country'])){
  $country = "country ='".$_POST['country']."',";  
}

$sql_updt = "UPDATE `users` SET ".$admin_title." ".$appointment_desc." ".$contactor_name." ".$contactor_email." ".$mobile." ".$image." ".$city." ".$state." ".$country." ".$contactor_currency." ".$contactor_price." status='1' WHERE email = '".$_SESSION['appoint_email']."'";

mysqli_query($con, $sql_updt);

}
function value($fields){
global $con;
$sql = mysqli_query($con, "select $fields from users where email= '".$_SESSION['appoint_email']."'");
$data = mysqli_fetch_object($sql);
  if(!empty($_POST[$fields])){
    return $_POST[$fields];
  }else{
    return $data->$fields;
  }
}

$img = value('image');
if($img != ''){
$image_msg = "<img src='img/".value('image')."' style='max-height:250px;' class='img-thumbnail' />";
}

if(isset($_POST['save_time_schedule'])){
  
  if(is_array($_POST['time_schedule_12'])){
    $time_schedule_12 = implode(",", $_POST['time_schedule_12']);

    if($time_schedule_12[0] == ','){
      $time_schedule_12 = ltrim($time_schedule_12, ',');
    }

    $time_schedule_12 = "time_schedule_12 ='".$time_schedule_12."',";
  }

  if(is_array($_POST['time_schedule_24'])){
    $time_schedule_24 = implode(",", $_POST['time_schedule_24']);

    if($time_schedule_24[0] == ','){
      $time_schedule_24 = ltrim($time_schedule_24, ',');
    }

    $time_schedule_24 = "time_schedule_24 ='".$time_schedule_24."',";
  }

  $sql_updt = "UPDATE `users` SET ".$time_schedule_12." ".$time_schedule_24." status='1' WHERE email = '".$_SESSION['appoint_email']."'";
  mysqli_query($con, $sql_updt);

}
if(!empty($_REQUEST['del'])){
    $delete = "delete from appointment where id = '".$_REQUEST['del']."'";
    if(mysqli_query($con, $delete)){
      header("Location: manage-data.php?q=appointments");
    }
}

if(isset($_POST['save_bundle_price'])){
  $from_prices = $_POST['from_price'];
  $to_prices = $_POST['to_price'];
  $each_prices = $_POST['each_price'];
$p = 0;

foreach($from_prices as $from_price){
    mysqli_query($con, "INSERT INTO `bundle_price` SET `from` = '".$from_price."', `to` = '".$to_prices[$p]."', `price` = '".$each_prices[$p]."'");
$p++;
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo value('admin_title'); ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet"  href="css/owl.carousel.min.css"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,300i,400,500,600,700,800" rel="stylesheet">
<link rel="stylesheet"  href="css/style.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">

<style type="text/css">
.owl-carousel.owl-drag .owl-item{margin-right: 9px !important;}
.error{color:#d22c2ccf; font-size: 11px; position: absolute;}
#section3 .col-sm-4 {width: 33.33333333%;padding-left: 0;padding-right: 8px;}
</style>
</head>
<body>
<header>
<div class="container">
<div class="row">
<div class="col-sm-6"><?php echo value('admin_title'); ?></div>
<div class="col-sm-6">
<ul class="header-ul">
<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="manage-data.php"><?php echo value('contactor_name'); ?> <i class="fa fa-user-circle" aria-hidden="true"></i>
<span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="manage-data.php?q=appointments">All Appointments</a></li>
<li><a href="manage-data.php#section1">Update Profile</a></li>
<li><a href="logout.php">Sign Out</a></li>
</ul>
</li>
</ul></div>
</div> 
</div>
</header>
<div class="data-form">
<div class="col-sm-3 side-bar">
<div class="sideInner">
  <ul class="sidebar-ul">
    <li><a href="manage-data.php#section1">Profile</a></li>
    <!--<li><a href="#section2">Date Scheduler</a></li> -->
    <li><a href="manage-data.php#section3">Time Scheduler</a></li>
    <li><a href="manage-data.php?q=appointments">All Appointments</a></li>
  </ul>
</div>
</div>
<?php if($_REQUEST['q'] == 'appointments'){ ?>
<div class="col-sm-9" style="width:81%;">
<h2>Appointment List </h2>

<table class="table">
    <thead>
      <tr>
        <th>S.N.</th>
        <th>Order Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>mobile</th>
        <th>Payment Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
<?php 
$sql = mysqli_query($con, "select * from appointment");
$ap = 1;
while($aps = mysqli_fetch_object($sql)){ ?>
      <tr>
        <td class="text-center"><?php echo $ap; ?></td>
        <td class="text-center"><?php echo $aps->order_id; ?></td>
        <td class="text-center"><?php echo $aps->name; ?></td>
        <td class="text-center"><?php echo $aps->email; ?></td>
        <td class="text-center"><?php echo $aps->mobile; ?></td>
        <td class="text-center"><?php echo ($aps->payment_status == 'paid') ? '<span style="color:green"><i class="fa fa-check-square-o" aria-hidden="true"></i> '.$aps->payment_status.'</span>' : '<span style="color:red"><i class="fa fa-times" aria-hidden="true"></i> '.$aps->payment_status.'</span>'; ?></td>
        <td><a href="mailto:<?php echo $aps->email; ?>" class="btn btn-info"><i class="fa fa-envelope" aria-hidden="true"></i> Email </a> | <a href="?del=<?php echo $aps->id; ?>" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
      </tr>
<?php 
$ap++;
} ?>      
    </tbody>
  </table>

</div>
<?php }else{ ?>
<div class="col-sm-9">
<!--all basic info-->
<form method="post" enctype="multipart/form-data">
<div style="margin-top:20px" id="section1" class="col-sm-8 ver-line">
<h3 class="text-center admin-head">Basic Info</h3>
<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Admin Title</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" name="admin_title" class="form-control" placeholder="title" value="<?php echo value('admin_title'); ?>" />
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Appointment Description</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" class="form-control" name="appointment_desc" placeholder="Appointment Description" value="<?php echo value('appointment_desc'); ?>" />
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Contactor Name</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" class="form-control" name="contactor_name" placeholder="Locaiton" value="<?php echo value('contactor_name'); ?>" />
</div>
</div>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Contactor Currency</label>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<!--<input type="text" class="form-control" name="contactor_currency" placeholder="Contractor Currency (ex. USD)" value="<?php echo value('contactor_currency'); ?>" />-->
<select name="contactor_currency" class="form-control">
<option>Select Currency</option>
  <?php

  $c_c = value('contactor_currency');;
  $sql_c = mysqli_query($con, "select * from currency");
  while ($dc = mysqli_fetch_object($sql_c)) { ?>
    <option value="<?php echo $dc->code; ?>" <?php if($c_c == $dc->code){ echo 'selected="selected"'; }else{ echo ''; } ?> ><?php echo $dc->code; ?></option>
  <?php } ?>
</select>
</div>
</div>

</div>
<div class="clearfix"></div>

<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Contactor Price</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" class="form-control" name="contactor_price" placeholder="Price (ex. 10.00) only number of decimals" value="<?php echo value('contactor_price'); ?>" />
</div>
</div>
</div>
<div class="clearfix"></div>


<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Email</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="email" class="form-control" name="contactor_email" placeholder="Email" value="<?php echo value('contactor_email'); ?>" />
</div>
</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Mobile Number</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" class="form-control" name="mobile" placeholder="Mobile Number" value="<?php echo value('mobile'); ?>" />
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
<div class="col-sm-4"> <label>Upload Profile picture</label></div>
<div class="col-sm-8">
<div class="form-group">
<div class="input-group">
<span class="input-group-btn">
<span class="btn btn-primary btn-file">
Browse&hellip; <input type="file" name="image" single />
</span>
</span>
<input type="text" class="form-control" readonly />
</div>
</div>
</div>
</div>
<div class="col-sm-12 text-center"><?php echo $image_msg; ?></div>
<div class="clearfix"></div>
<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>City</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" class="form-control" name="city" placeholder="City" value="<?php echo value('city'); ?>" />
</div>
</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>State</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" class="form-control" name="state" placeholder="State" value="<?php echo value('state'); ?>" />
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
<div class="col-sm-4">
<div class="form-group">
<label>Country</label>
</div>
</div>
<div class="col-sm-8">
<div class="form-group">
<input type="text" class="form-control" name="country" placeholder="Country" value="<?php echo value('country'); ?>" />
</div>
</div>
</div>

<div class="col-sm-12 text-right">
<button name="save_setting_basic" type="submit" value="save setting basic" class="btn btn-info">Save Setting</button>  
</div>
<div class="clearfix"></div>
</div>
</form>
<!-- Bundle price start-->
<div id="section4" class="col-sm-8 ver-line sce-step">
<form method="post">
<div class="bundle_price_container col-sm-12">
<h3 class="text-center admin-head">Bundle price</h3>
<div class="clearfix"></div>
<div class="bundle_price">
<div class="col-sm-8">

<div class="form-group"><div class="col-sm-4"><input class="form-control" type="text" placeholder="From Ex. 4" name="from_price[]"></div><div class="col-sm-4"><input class="form-control" type="text" placeholder="To Ex. 9" name="to_price[]"></div><div class="col-sm-4"><input class="form-control" placeholder="price Ex. $10" type="text" name="each_price[]"></div></div>

</div>
<div class="col-sm-4">
<div class="form-group">
<button class="btn btn-sm btn-primary add_more_bundle_price">Add Price</button>
</div>
</div>
<div class="clearfix"></div>
<?php
  $query = mysqli_query($con, "select * from bundle_price");
  while($p_item = mysqli_fetch_object($query)) {
    ?>
    <div class="form-group col-sm-12" style="padding:0;"><div style="padding:0" class="col-sm-3"><input class="form-control" type="text" placeholder="From Ex. 4" name="from_price[]" value="<?php echo $p_item->from; ?>"></div><div class="col-sm-3"><input class="form-control" type="text" placeholder="To Ex. 9" name="to_price[]"  value="<?php echo $p_item->to; ?>" ></div><div class="col-sm-3"><input class="form-control" placeholder="price Ex. $10" type="text" name="each_price[]"  value="<?php echo $p_item->price; ?>"></div><div class="col-sm-3"><a href="#" class="remove_field" style="margin-left:10px;"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div></div>
    <div class="clearfix"></div>
<?php 
  } 
?>
</div>

</div>
<div class="col-sm-12 text-right">
<button name="save_bundle_price" type="submit" value="save Bundle Price" class="btn btn-info">Save Setting</button>  
</div>
</form>
</div>
<!-- Bundle price Close-->

<!-- Time Scheduler start-->
<div id="section3" class="col-sm-8 ver-line sce-step">
<form method="post">
<div class="input_fields_container col-sm-12">
<h3 class="text-center admin-head">Time Scheduler</h3>

<div class="12_hrs">
  <h5>12 Hrs</h5>
  <hr />
  <div class="col-sm-8">
  <div class="form-group">
  <input class="form-control" type="text" name="time_schedule_12[]"></div></div>

  <div class="col-sm-4">
  <div class="form-group">
  <button class="btn btn-sm btn-primary add_more_button_12">Add More Fields (12 Hrs)</button>
  </div>
  </div>
<div class="clearfix"></div>
<?php 
$t12 = value('time_schedule_12');

if(is_array($t12)){
  $time12s = $t12;
}else{
  $time12s = explode(',', $t12);
}

if(is_array($time12s)){
  foreach($time12s as $time12){ 
    if($time12 !=''){
    ?>
    <div style="float:left" class="form-group col-sm-6"><div style="padding:0" class="col-sm-8"><input class="form-control" type="text" name="time_schedule_12[]" value="<?php echo $time12; ?>" /></div><div class="col-sm-4"><a href="#" class="remove_field" style="margin-left:10px;"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div></div>
<?php 
    }
  } 
}

?>
</div>

<div class="clearfix"></div>
<hr />
<div class="clearfix"></div>
<div class="24_hrs">
<h5>24 Hrs</h5>
<hr />
<div class="col-sm-8">
<div class="form-group">
<input class="form-control" type="text" name="time_schedule_24[]"></div></div>
<div class="col-sm-4">
<div class="form-group">
<button class="btn btn-sm btn-primary add_more_button_24">Add More Fields (24 Hrs)</button>
</div>
</div>
<div class="clearfix"></div>
<?php 
$t24 = value('time_schedule_24');

if(is_array($t24)){
  $time24s = $t24;
}else{
  $time24s = explode(',', $t24);
}

if(is_array($time24s)){
  foreach($time24s as $time24){ 
    if($time24 !=''){
    ?>
    <div style="float:left" class="form-group col-sm-6"><div style="padding:0" class="col-sm-8"><input class="form-control" type="text" name="time_schedule_24[]" value="<?php echo $time24; ?>" /></div><div class="col-sm-4"><a href="#" class="remove_field" style="margin-left:10px;"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div></div>
<?php 
    }
  } 
}

?>
</div>

</div>
<div class="col-sm-12 text-right">
<button name="save_time_schedule" type="submit" value="save setting Time" class="btn btn-info">Save Setting</button>  
</div>
</form>
</div>
<!-- Time Scheduler Close-->

</div>
<?php } ?>
</div>



<style>
body{
counter-reset: my-sec-counter;
}
header {
width: 100%;
float: left;
background: #00A2FF;
padding: 20px 0;
color: #fff;
}
header ul{
float: right;
}
.data-form{
background: #f7f7f7;
width: 100%;
float: left;
}
.form-font{
position: absolute;
top: 10px;
right: 10px;
}
.fillDate{
display: none;
}
.header-ul li{
list-style: none;
}
.header-ul > li > a{
color:#fff;
}
.header-ul > li > a:hover, .header-ul > li > a:focus{
text-decoration: none;
}
.ver-line{
    position: relative;
    padding-top: 0 !important;
    padding: 50px 0;
    /* border: 1px solid #dedede; */
    margin-left: 16.66666%;
    box-shadow: 0 0 20px #cacaca;
    margin-bottom: 50px;
}
.admin-head{
     margin-bottom: 20px;
    font-weight: 300;
    background: #616060;
    font-size: 22px;
    color: #fff;
    padding: 15px 0;
    margin-top: 0;
    letter-spacing: 1px;

}
.sce-step{
padding-top: 11px;
position: relative;

}
.remove_field{
color: red;
}
.btn-file {
position: relative;
overflow: hidden;
}
.btn-file input[type=file] {
position: absolute;
top: 0;
right: 0;
min-width: 100%;
min-height: 100%;
font-size: 100px;
text-align: right;
filter: alpha(opacity=0);
opacity: 0;
background: red;
cursor: inherit;
display: block;
}
input[readonly] {
background-color: white !important;
cursor: text !important;
}
.side-bar{
width: 100%;
float: left;
max-width: 250px;
height: 100vh;
padding: 0;
background: #333;
position: sticky;
top: 0;
}
.sidebar-ul {
  margin: 0;
  padding:0;
}
.sidebar-ul li{
  list-style: none;
}
.sidebar-ul li >a {
    color: #a9a9a9;
    display: block;
    border-bottom: 1px solid #424242;
    padding: 10px 15px;
}
.sidebar-ul li >a:hover, .sidebar-ul li >a:focus{
  text-decoration: none;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
$( function() {
$( "#datepicker, #datepicker1" ).datepicker();

} );
$(document).ready(function(){
$("#dates").on('change', function()
{
if(( this.value )==="fillDate"){
$(".fillDate").css("display", "block");
$(".fillDate ").focus();
}
else{
$(".fillDate ").css("display", "none");
}
});
});
</script>
<script>

$(document).ready(function() {
var max_fields_limit      = 20; //set limit for maximum input fields
var x = 1; //initialize counter for text box
// 12 Hrs
$('.add_more_button_12').click(function(e){ //click event on add more fields button having class add_more_button
e.preventDefault();
if(x < max_fields_limit){ //check conditions
x++; //counter increment
$('.input_fields_container .12_hrs').append('<div style="float:left" class="form-group col-sm-6"><div style="padding:0" class="col-sm-8"><input class="form-control" type="text" name="time_schedule_12[]"/></div><div class="col-sm-4"><a href="#" class="remove_field" style="margin-left:10px;"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div></div>'); //add input field
}
});  

// 24 Hrs

$('.add_more_button_24').click(function(e){ //click event on add more fields button having class add_more_button
e.preventDefault();
if(x < max_fields_limit){ //check conditions
x++; //counter increment
$('.input_fields_container .24_hrs').append('<div style="float:left" class="form-group col-sm-6"><div style="padding:0" class="col-sm-8"><input class="form-control" type="text" name="time_schedule_24[]"/></div><div class="col-sm-4"><a href="#" class="remove_field" style="margin-left:10px;"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div></div>'); //add input field
}
});  


$('.input_fields_container').on("click",".remove_field", function(e){ 
//user click on remove text links
e.preventDefault(); $(this).parent('div').parent('.form-group').remove(); x--;
})


// Bundle Price

$('.add_more_bundle_price').click(function(e){ //click event on add more fields button having class add_more_button
e.preventDefault();
if(x < max_fields_limit){ //check conditions
x++; //counter increment
$('.bundle_price_container .bundle_price').append('<div style="float:left" class="form-group col-sm-12"><div style="padding:0" class="col-sm-3"><input class="form-control" type="text" placeholder="From Ex. 4" name="from_price[]"></div><div class="col-sm-3"><input class="form-control" type="text" placeholder="To Ex. 9" name="to_price[]"></div><div class="col-sm-3"><input class="form-control" placeholder="price Ex. $10" type="text" name="each_price[]"></div><div class="col-sm-3"><a href="#" class="remove_price" style="margin-left:10px;color: red;"><i class="fa fa-minus-circle fa-2x" aria-hidden="true"></i></a></div></div>'); //add input field
}
});  


$('.bundle_price_container').on("click",".remove_price", function(e){ 
//user click on remove text links
e.preventDefault(); $(this).parent('div').parent('.form-group').remove(); x--;
})


});


</script>
<script>
$(document).on('change', '.btn-file :file', function() {
var input = $(this),
numFiles = input.get(0).files ? input.get(0).files.length : 1,
label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
$('.btn-file :file').on('fileselect', function(event, numFiles, label) {

var input = $(this).parents('.input-group').find(':text'),
log = numFiles > 1 ? numFiles + ' files selected' : label;

if( input.length ) {
input.val(log);
} else {
if( log ) alert(log);
}

});
});
</script>
</body>
</html>