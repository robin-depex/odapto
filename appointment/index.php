<?php
$workdays = array();
$type = CAL_GREGORIAN;
include('config.php');
$con = dbconnect();
$sql = mysqli_query($con, "select * from users");
$data = mysqli_fetch_object($sql);
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="pingback" href="https://www.99simplify.com/xmlrpc.php">
<title><?php echo $data->admin_title; ?></title>

<link rel='stylesheet' id='font-awesome-css'  href='https://www.99simplify.com/wp-content/plugins/unyson/framework/static/libs/font-awesome/css/font-awesome.min.css?ver=2.7.12' type='text/css' media='all' />
<link rel='stylesheet' id='utouch-theme-style-css'  href='https://www.99simplify.com/wp-content/themes/utouch/css/theme-styles.css?ver=1' type='text/css' media='all' />
<link rel='stylesheet' id='utouch-theme-blocks-css'  href='https://www.99simplify.com/wp-content/themes/utouch/css/blocks.css?ver=1' type='text/css' media='all' />
<link rel='stylesheet' id='utouch-theme-plugins-css'  href='https://www.99simplify.com/wp-content/themes/utouch/css/theme-plugins.css?ver=1' type='text/css' media='all' />
<link rel='stylesheet' id='utouch-theme-widgets-css'  href='https://www.99simplify.com/wp-content/themes/utouch/css/widgets.css' type='text/css' media='all' />
<link rel='stylesheet' id='utouch-color-scheme-css'  href='https://www.99simplify.com/wp-content/themes/utouch/css/color-selectors.css' type='text/css' media='all' />
<link rel='stylesheet' id='utouch-style-css'  href='https://www.99simplify.com/wp-content/themes/utouch/style.css?ver=1' type='text/css' media='all' />

<link rel='stylesheet' id='utouch-theme-font-css'  href='//fonts.googleapis.com/css?family=Nunito%3A300%2C400%2C700%2C900&#038;ver=1.0' type='text/css' media='all' />
<link rel='stylesheet' id='seo-icons-css'  href='https://www.99simplify.com/wp-content/themes/utouch/css/seo-icons.css?ver=1' type='text/css' media='all' />
<link rel='stylesheet' id='child-style-css'  href='https://www.99simplify.com/wp-content/themes/utouch-child/style.css' type='text/css' media='all' />

<link rel='stylesheet' id='kc-animate-css'  href='https://www.99simplify.com/wp-content/plugins/kingcomposer/assets/css/animate.css?ver=2.6.17' type='text/css' media='all' />
<link rel='stylesheet' id='kc-icon-1-css'  href='https://www.99simplify.com/wp-content/plugins/kingcomposer/assets/css/icons.css?ver=2.6.17' type='text/css' media='all' />
  <script type="text/javascript"></script>
  <style type="text/css" id="kc-css-general">.kc-off-notice{display: inline-block !important;}.kc-container{max-width:1170px;}</style>
  <style type="text/css" id="kc-css-render"></style>
  <style>html {margin-top: 0 !important;}</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet"  href="https://www.odapto.com/appointment/css/owl.carousel.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,300i,400,500,600,700,800" rel="stylesheet">
<link rel="stylesheet"  href="https://www.odapto.com/appointment/css/style.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet"  href="https://www.odapto.com/appointment/css/custome.css"/>
<script src="https://www.odapto.com/appointment/js/owl.carousel.min.js"></script> 
<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#exampleModal").modal('show');
        $("#success-alert").hide();

 $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){$("#success-alert").slideUp(500);}); 

    });
</script>
<style type="text/css">
.disabled{pointer-events: none; background: #ccc;}
.card-detalis {
    padding-bottom: 50px !important;
}

</style>
</head>
<body class="page-template page-template-book_appointment page-template-book_appointment-php page page-id-3222 kc-css-system tribe-no-js singular crumina-grid skew-rows utouch">
<a class="skip-link screen-reader-text" href="#primary">Skip to content</a>
    <!-- Header -->
    <header class="header" id="site-header"
            data-pinned="swingInX"
            data-unpinned="swingOutX">
      <div class="header-lines-decoration">
                <span class="bg-secondary-color"></span>
                <span class="bg-blue"></span>
                <span class="bg-blue-light"></span>
                <span class="bg-orange-light"></span>
                <span class="bg-red"></span>
                <span class="bg-green"></span>
                <span class="bg-secondary-color"></span>
            </div>
            <div class="container">
                      <a href="#" id="top-bar-js" class="top-bar-link">
                    <svg class="utouch-icon utouch-icon-arrow-top">
                        <use xlink:href="#utouch-icon-arrow-top"></use>
                    </svg>
                </a>
                  <div class="header-content-wrapper">
                <div class="site-logo">
          <a href="https://www.odapto.com" class="full-block" rel="home"></a><img src="../images/logo.png" alt="99 Simplify" /></div>
                <nav id="primary-menu" class="primary-menu">
                    <!-- menu-icon-wrapper -->
                    <a href='javascript:void(0)' id="menu-icon-trigger" class="menu-icon-trigger showhide">
                        <span class="mob-menu--title">Menu</span>
                        <span id="menu-icon-wrapper" class="menu-icon-wrapper">
                            <svg width="1000px" height="1000px">
                                <path id="pathD"
                                      d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
                                <path id="pathE" d="M 300 500 L 700 500"></path>
                                <path id="pathF"
                                      d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
                            </svg>
                        </span>
                    </a>
<!-- menu-icon-wrapper -->
<!--<ul id="primary-menu-menu" class="primary-menu-menu">
<li id="menu-item-731" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-731"><a href="https://www.99simplify.com/" >99 simplify in 1 hour</a></li>
<li id="menu-item-2077" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2077"><a href="https://www.99simplify.com/templates/" >Template</a></li>
<li id="menu-item-2934" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2934"><a href="https://www.99simplify.com/events/" >Events</a></li>
<li id="menu-item-2110" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2110"><a href="https://www.99simplify.com/authors/" >Creator</a></li>
<li id="menu-item-797" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-797"><a href="https://www.99simplify.com/contact/" >Contact</a></li>
</ul>-->

<!--<ul class="nav-add">
<li class="search search_main"><a href="#" class="js-open-search-popup"><svg class="utouch-icon utouch-icon-search  cd-nav-trigger" viewBox="0 0 512 512">
<path d="m411 203c-12-2-23 5-25 17-3 19-12 35-26 50-14 13-31 22-50 26-10 2-18 13-16 24 2 11 12 19 24 18 27-6 52-19 71-38 20-20 33-45 38-72 3-12-4-22-16-25z m-109-203c-116 0-210 94-210 209 0 32 7 61 19 88l-78 68c-56 58-25 109-9 124 14 15 66 48 124-10l69-78c26 11 54 18 85 18 115 0 209-94 209-210 0-115-94-209-209-209z m-185 452c-10 11-38 29-63 8-7-6-21-36 8-63l72-63c13 18 28 33 45 45z m185-77c-92 0-166-74-166-166 0-91 74-165 166-165 91 0 165 74 165 165 0 92-74 166-165 166z"></path>
</svg></a></li>
</ul>-->
      
<!-- # Overlay Search-->
                </nav>

            </div>
        </div>
    </header>
  <div id="header-spacer" class="header-spacer"></div>
  <div class="search-popup ">
        <a href="#" class="popup-close js-popup-close cd-nav-trigger">
            <svg class="utouch-icon utouch-icon-cancel-1">
                <use xlink:href="#utouch-icon-cancel-1"></use>
            </svg>
        </a>
        <div class="search-full-screen">
            <div class="search-standard">
                <form id="search-header" method="get" action="https://www.99simplify.com/"
                      class="search-inline" name="form-search-header">
                    <input class="search-input" name="s" value=""
                           placeholder="What are you looking for?"
                           autocomplete="off" type="search">
                    <button type="submit" class="form-icon">
                        <svg class="utouch-icon utouch-icon-search">
                            <use xlink:href="#utouch-icon-search"></use>
                        </svg>
                    </button>
                    <span class="close js-popup-clear-input form-icon">
              <svg class="utouch-icon utouch-icon-cancel-1"><use xlink:href="#utouch-icon-cancel-1"></use></svg>
            </span>
                </form>
            </div>
        </div>
    </div>
<!-- ... End Header -->
<div class="clearfix"></div>
<!-- Appointment sheduler -->
<div class="wrapper wrapper_appointment">
<div class="clearfix"></div>
<div id="getDate">
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="appo-line">
<div class="col-sm-6">
<h3 class="heading"><img style="width: 32px" src="img/appointment.png">&nbsp;<?php echo $data->admin_title; ?></h3>
</div>
<div class="col-sm-6 text-right">
<p class="contTime">Time zone is <span class="country_name"></span></p>
</div> 
</div>   
</div>
<?php if(!empty($_REQUEST['order_id'])){ 
  $sql_query = mysqli_query($con, "select * from appointment WHERE order_id='".$_REQUEST['order_id']."'");
  $data_s = mysqli_fetch_object($sql_query);
  if($data_s->payment_status == 'paid'){ ?>

<!-- Modal -->
  <div class="modal fade" id="exampleModal">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Order No. (<?php echo $_REQUEST['order_id']; ?>)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding: 0;">

<div class="alert alert-success" id="success-alert">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>Thank you!</strong>
   Your payment was processed successfully.
</div>

        <div class="col-sm-6 app_detail">
        <p></p>
        <h3>Your appointment Details :- </h3>
        <p></p>
        <p>Name : <?php echo $data_s->name; ?></p>
        <p>Email : <?php echo $data_s->email; ?></p>
        <p>Mobile : <?php echo $data_s->mobile; ?></p>
        <p>Per Order Price : <?php echo $data_s->price.''.$data_s->currency; ?></p>
        <p>Total Price : <?php echo $data_s->order_total.''.$data_s->currency; ?></p>
        <p>Booking Date : <?php echo $data_s->book_date; ?></p>
        <p>Payment Status : <?php echo $data_s->payment_status; ?></p>
        <p>Your Discussion Agenda : <br /></p>
        <p><?php echo $data_s->comment; ?></p>
        </div>
        <div class="col-sm-6 app_detail">
          <h3>Your appointment will be scheduled for these dates and times as below :- </h3>
          <div class="finalData">
            <?php 
            $appoint_dates = explode(",", $data_s->appoint_dates);
            foreach($appoint_dates as $appoint_date){ ?>
                      <div class="col-sm-12 text-center" style="width: 100%;"><?php echo $appoint_date; ?></div>
            <?php } ?>
          </div>

          <div class="clearfix"></div>
          <p class="icon-color"><i class="fa fa-phone-square" aria-hidden="true"></i> <a href="tel:+31629566542">+31629566542</a></p>
          <p class="icon-color"><i class="fa fa-skype" aria-hidden="true"></i> <a href="skype:martinathoy?call">Call Me (martinathoy)</a></p>
        </div>

        <div class="modal-footer"><button type="button" class="btn btn-secondary close_btn" data-dismiss="modal">Close</button></div>
    </div>

  </div>
</div>
</div>
<!-- ################################################ -->
<div class="clearfix"></div>

  <?php }else{ ?>
  <div class="clearfix"></div>
  <div class="col-sm-12 text-center">
  <div class="alert alert-danger">Some thing went wrong.</div>
  </div>
<?php } } ?>

<div class="col-sm-12">
<p class="ribbon"><img src="img/bookmark.png"><?php //echo $data->appointment_desc; ?>You are now going to schedule your appointment with Business / Strategy Consultant Mr. Martin Schoonhoven (founder Hoy, Odapto, MrCanvas, Strategyinoneday). <br /><br /> Please follow the next steps in order to Schedule your appointment(s)</p>
<div>
  <img src="img/target.png" style="float:left;">
  <div class="country_name" style="float: left;line-height: 30px;padding: 0 6px;"></div>
</div>
</div>

</div>
</div>
<div class="container">
 <div class="dateSections">
  <div class="row">
  <div style="padding: 0" class="col-sm-12">
     <h3 class="text-center"><span class="chng-steps">Step - 1</span></h3>
  <h4 class="text-center">Choose a day</h4>
    <div class="selectDate">
   <section id="demos">
      <div class="row">
        <div class="large-12 columns">
          <div class="owl-carousel owl-theme">
             <div class="todayDate">
                <h4 class="text-center">Today</h4>           
<?php
$month = date('n'); // Month ID, 1 through to 12.
$year = date('Y'); // Year in 4 digit 2009 format.
$sl = 0;
for($mc = $year; $mc <= ($year+1); $mc++){
  $tm = $month;
  for($e = $tm; $e <= 12; $e++){
        $cdm = cal_days_in_month($type, $e, $mc);
        for($i1 = 1; $i1 <= $cdm; $i1++){
              $date = $mc.'/'.$e.'/'.$i1; //format date
              $get_name = date('l', strtotime($date)); //get week day
              $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
              $day = date('d', strtotime($date));
              $month_1 = date('M', strtotime($date));
              $today = date('d');
              if($day_name != 'Sun' && $day_name != 'Sat'){ 
                  $class = ($day_name != 'Mon') ? 'disabled' : '';
                if($mc == $year and $e == $month){
                  if($day >= $today){ ?>
                      <div id="<?php echo $day.'_'.$month_1; ?>" class="item <?php echo $class; ?>">
                      <div class="days"><?php echo $get_name; ?></div>
                      <div class="dates"><?php echo $day.' '.$month_1; ?></div>
                      </div>
                      <?php $sl++; if($sl == 1){ ?></div> <?php } 
                  }
                }else{ ?>
                      <div id="<?php echo $day.'_'.$month_1; ?>" class="item <?php echo $class; ?>">
                      <div class="days"><?php echo $get_name; ?></div>
                      <div class="dates"><?php echo $day.' '.$month_1; ?></div>
                      </div>
                <?php      
                }
              }
        }
  $tm++;
  }
$tm = 1;
}
?>
          </div>
        </div>
       </div>
       </section>
      </div>
<div class="display_price">
  <div class="braket_img"><span>Bundle price</span><img src="img/bracket.png" class="bracket" /></div>
  <div class="price_items">
    <ul class="list-inline">
        <li class="price_item" id="first"><span>1 To 2</span><span>$60<em>/each </em></span></li>
        <li class="price_item" id="second"><span>3 To 5</span><span>$58<em>/each </em></span></li>
        <li class="price_item" id="third"><span>6 To 9</span><span>$56<em>/each </em></span></li>
        <li class="price_item" id="four"><span>10 To 12</span><span>$54<em>/each </em></span></li>
        <li class="price_item" id="fifth"><span>13 To 15</span><span>$52<em>/each </em></span></li>
        <li class="price_item" id="six"><span>16 To 20</span><span>$50<em>/each </em></span></li>
    </ul>
  </div>
</div>     
    </div>
   </div>
  </div> 
 </div>
</div>
<div class="clearfix"></div>
 <div id="confirmSection">
 <div class="headDate">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
         <h3 class="text-center"><span class="chng-steps">Step - 2</span></h3>
      </div>
    </div>
  </div>
  </div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <div class="timeSection">
    <div class="col3of5 mbs mobile-centered" style="float: left;width: 100%;"><h4 style="margin-bottom: 30px;float: left;">Choose a time</h4>
<button class="goNext btn btn-info" type="botton">Next</button></div>
    <div class="clearfix"></div>
    <?php 

$hrs12s = explode(',', $data->time_schedule_12);
$hrs24s = explode(',', $data->time_schedule_24);
     ?>
      <div class="notation_date_12" style="display: block;">
      <?php foreach($hrs12s as $hrs12){ ?>
      <?php } ?>
    </div>
      </div>
    </div>
  </div>
</div>
</div>

 <div id="final-pay"> 
    <div class="container">
    <div class="row">
    <div class="col-sm-12">
        <h3 class="text-center"><span class="chng-steps">Step - 3</span></h3>
  <form method="post" id="contact" class="form-horizontal">
  <div style="margin: 20px 0" class="col-sm-6">
<h3>Fill the Payment Information and Pay</h3>
<div class="form-group">
  <div class="input-group col-sm-12" style="padding:0 15px;">
    <span style="width:25%" class="input-group-addon col-sm-3">
      <select name="sal" class="form-control">
        <option selected="selected" value="Mr.">Mr.</option>
        <option value="Mrs.">Mrs.</option>
        <option value="Miss">Miss</option>
      </select>
    </span>
    <div class="col-sm-9" style="padding: 0;">
  <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" style="padding: 12px;min-height: 48px;"><span class="error error_name"></span></div>
  </div>
</div>
<div class="form-group">
<div class="col-sm-6" style="padding-right: 0;"><input type="email" name="email" id="email" class="form-control" placeholder="Email ID"><span class="error error_email"></span></div>
<div class="col-sm-6"><input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number"><span class="error error_mobile"></span></div>
</div>

<div class="form-group">
<div class="col-sm-12"><textarea class="form-control" name="comment" rows="5" id="comment" placeholder="Please input your Discussion Agenda.."></textarea><span class="error error_comment"></span></div>
</div>
    </div>    
<div style="margin: 40px 0;background: #f7f7f7;border-top: 4px solid #000000;" class="col-sm-6">
<h3>Your appointment will be scheduled for these dates and times as below</h3>
<div class="clearfix"></div>
<div class="finalData"></div>
<div class="clearfix"></div>
<!--<p><img style="width: 20px" src="img/bookmark.png"><?php echo $data->appointment_desc; ?></p>-->
<!--<p><img style="width: 20px" src="img/target.png"> <span class="country_name"></span></p>
<p class="icon-color"><i class="fa fa-phone-square" aria-hidden="true"></i> <a href="tel:+31629566542">+31629566542</a></p>
<p class="icon-color"><i class="fa fa-skype" aria-hidden="true"></i> <a href="skype:martinathoy?call">Call Me (martinathoy)</a>
-->
<div class="clearfix"></div>
</p>
<div class="col-sm-12 card-detalis">
<h3>Fill the card details</h3>
<div class="col-sm-10">
<div class="form-group">
<label><input type="radio" checked="checked" name="optradio">Mollie ( taal kiezen etc) <img style="width: 70px" src="img/mollie.png"></label>
</div>
</div>
<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6Lc-FNwUAAAAAOKfPa0pZISKxyvI8qXw480KqYXP"></div>
<div class="clearfix"></div>
<button type="submit" class="btn btn-info pull-right" name="submit" id="submit">Pay Now</button>
</div>
</div>
</form>   
    </div>
    </div>
    </div>
    </div>
</div>
<script>
    function recaptchaCallback() {
    $('#submit').removeAttr('disabled');
};
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".goNext").click(function(){
    $("#confirmSection").hide();
    $("#final-pay").show();
  });
});
</script>
<script>
$(document).ready(function() {
var owl = $('.owl-carousel');
owl.owlCarousel({
margin: 10,
nav: true,
loop: false,
responsive: {
0: {
items: 1
},
600: {
items: 3
},
1000: {
items: 7
}
}
})
$(".owl-next span, .owl-prev span").empty();  
$(".tire-price").hide(); 
$(".closeTire").click(function(){
  $(".tire-price").animate({width: "0px"});
  $(".tire-inner").css("overflow" , "hidden");
});
});

var count = 0;
var ids;
$(".item").click(function(){
var day = $(this).children().contents().first().text();
var year = $(this).children().contents().last().text();
var ids = $(this).attr('id');
if(!$(this).hasClass("active-circle")){
var fulldate = $(this).children().text();
$(this).toggleClass("active-circle");

$('#confirmSection').css('display', 'block');
$tuesday = '<div class="viewdds" id="viewdds_'+ids+'"><div class="fulldateN"><span class="dayclass">'+day+'</span><span class="yearclass">'+year+'</span></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">9:30 - 10:00</button><button type="button" value="9:30 - 10:00" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">14:00-16:00</button><button type="button" value="14:00-16:00" class="ConfirmBtn">Confirm</button></div></div>';
$friday = '<div class="viewdds" id="viewdds_'+ids+'"><div class="fulldateN"><span class="dayclass">'+day+'</span><span class="yearclass">'+year+'</span></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">10:00 To 13:00</button><button type="button" value="10:00 To 13:00" class="ConfirmBtn">Confirm</button></div></div>';
$everyday = '<div class="viewdds" id="viewdds_'+ids+'"><div class="fulldateN"><span class="dayclass">'+day+'</span><span class="yearclass">'+year+'</span></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">09:30 To 10:00</button><button type="button" value="09:30 To 10:00" class="ConfirmBtn">Confirm</button></div></div>';
$monday = '<div class="viewdds" id="viewdds_'+ids+'"><div class="fulldateN"><span class="dayclass">'+day+'</span><span class="yearclass">'+year+'</span></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">10:00 To 10:30</button><button type="button" value="10:00 To 10:30" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">10:30 To 11:00</button><button type="button" value="10:30 To 11:00" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">11:00 To 11:30</button><button type="button" value="11:00 To 11:30" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">11:30 To 12:00</button><button type="button" value="01:30 To 12:00" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">12:00 To 12:30</button><button type="button" value="12:00 To 12:30" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">12:30 To 13:00</button><button type="button" value="12:30 To 13:00" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">14:00 To 14:30</button><button type="button" value="14:00 To 14:30" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">14:30 To 15:00</button><button type="button" value="14:30 To 15:00" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">15:00 To 15:30</button><button type="button" value="15:00 To 15:30" class="ConfirmBtn">Confirm</button></div><div class="Btns"><button type="button" class="timeBtn" style="width: 100%; background: rgb(255, 255, 255); color: rgb(0, 162, 255);">15:30 To 16:00</button><button type="button" value="15:30 To 16:00" class="ConfirmBtn">Confirm</button></div></div>';
$not_available = '';
$('#final-pay').css('display', 'none');
if(day == 'Monday'){
  $('.notation_date_12').append($monday);
}else{
  $('.notation_date_12').append($not_available);
}

count += 1;
 // first
  if (count >= 1 && count <= 3) {
    $('.price_item').css('background', 'none');
      $('#first').css('background', '#00a2ff4a');
    }
  // second
    if (count >= 3 && count <= 5) {
      //alert(count);
      $('.price_item').css('background', 'none');
      $('#second').css('background', '#00a2ff4a');
    }
  // Third
    if (count >= 6 && count <= 9) {
      $('.price_item').css('background', 'none');
      $('#third').css('background', '#00a2ff4a');
    }
  // four
    if (count >= 10 && count <= 12) {
      $('.price_item').css('background', 'none');
      $('#four').css('background', '#00a2ff4a');
    }
  // fifth
    if (count >= 13 && count <= 15) {
      $('.price_item').css('background', 'none');
      $('#fifth').css('background', '#00a2ff4a');
    }
  // six
    if (count >= 16 && count <= 20) {
      $('.price_item').css('background', 'none');
      $('#six').css('background', '#00a2ff4a');
    }

 }else{
  var viewdds= $('#viewdds_'+ids).remove();
 count -= 1;
// first
if (count == 0) {
  $('.price_item').css('background', 'none');
}

  if (count >= 1 && count <= 3) {
    $('.price_item').css('background', 'none');
      $('#first').css('background', '#00a2ff4a');
    }
  // second
    if (count >= 3 && count <= 5) {
      //alert(count);
      $('.price_item').css('background', 'none');
      $('#second').css('background', '#00a2ff4a');
    }
  // Third
    if (count >= 6 && count <= 9) {
      $('.price_item').css('background', 'none');
      $('#third').css('background', '#00a2ff4a');
    }
  // four
    if (count >= 10 && count <= 12) {
      $('.price_item').css('background', 'none');
      $('#four').css('background', '#00a2ff4a');
    }
  // fifth
    if (count >= 13 && count <= 15) {
      $('.price_item').css('background', 'none');
      $('#fifth').css('background', '#00a2ff4a');
    }
  // six
    if (count >= 16 && count <= 20) {
      $('.price_item').css('background', 'none');
      $('#six').css('background', '#00a2ff4a');
    }

$("#viewdd_"+ids).remove('');
$("#viewdds_"+ids).remove('');
$(this).removeClass("active-circle");
 }

});

$('.goNext').hide();

$(document).on('click','.ConfirmBtn', function (event) { 
$(this).text("Confirmed");
ids = $(this).parent().parent().attr("id");
$('.goNext').show();
var finaltime =  $(this).val();
var cur_day = $('#'+ids+' .dayclass').text();
var cur_mmyy = $('#'+ids+' .yearclass').text();

$('.finalData').append('<div id='+ids+'>'+cur_mmyy+' '+cur_day+' '+finaltime+'<br><input type="hidden" class="appoint_dates" name="appoint_dates[]" value="'+cur_mmyy+' '+cur_day+' '+finaltime+'"></div>');
});

</script>
<script type="text/javascript">
$(document).on('mouseenter','.timeBtn', function (event) {  
$(".timeBtn").css({"width" : "99%", "background" : "#fff", "color" : "#00a2ff", "margin" : "0 0.5%"});
$(".ConfirmBtn").css("display" , "none");
$(this).next().css("display" , "inline-block");
$(this).css({"width" : "49%", "background" : "green", "color" : "#fff", "margin" : "0 0.5%"});
}); 
// 12 hrs and 24 hrs Time Notation changer..
$('input[name="time_notation"]').click(function() {
var hrtime = this.value;
if(hrtime == 'notation_date_12'){
$('.notation_date_24').hide();
$('.notation_date_12').show();
}
if(hrtime == 'notation_date_24'){
$('.notation_date_12').hide();
$('.notation_date_24').show();  
}
});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#submit').click(function(){
$("form#contact").submit(function(){return false;});

//get the values
var name = $('#name').val();
var email = $('#email').val();
var mobile = $('#mobile').val();
var comment = $('#comment').val();
/*
alert(comment);
$("#contact input[type=text]").each(function() {
 console.log(this.value);
});
*/

if(name ==''){$('.error_name').text('Please Enter Your Name.');return;}
if(email ==''){$('.error_email').text('Please Enter Your Email Id.!');return;}
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(! email.match(mailformat)){$('.error_email').text('Please Enter Correct Email Id.!');}
if(mobile ==''){$('.error_mobile').text('Mobile Number is Required.!');return;}
if(comment ==''){$('.error_comment').text('Please Enter Your comment.');return;}

/*
var items = $("input[name^='appoint_dates']").length;

for (var i = 0; i < items; i++){
  alert(items[i].name);
  //var appoint_dates = $("input[name^='appoint_dates["+i+"]']").val();
  //alert(appoint_dates);
}

*/
//validate the form
if(name != '' && email != '' && mobile != '' && comment !=''){
/*  
  //$.post('ajax.php', {name:name, email:email, mobile:mobile, comment:comment}, function(resp){
  $.post('ajax.php', {data:datastring}, function(resp){
  //console.log(resp);
  var obj = JSON.parse(resp);
  if(obj.checkout_url != ''){
    window.location.replace(obj.checkout_url);
  }
  }); 
*/
     var datastring = $("#contact").serialize();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: datastring,
            success: function(resp) {
              var obj = JSON.parse(resp);
                if(obj.checkout_url != ''){
                  window.location.replace(obj.checkout_url);
                }
            }
        });
} 
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#name').keypress(function(){if(this.value.length > 0){$('.error_name').hide();}else{$('.error_name').show();}});
$('#email').keypress(function(){if(this.value.length > 0){$('.error_email').hide();}else{$('.error_email').show();}});
$('#mobile').keypress(function(){if(this.value.length > 0){$('.error_mobile').hide();}else{$('.error_mobile').show();}});
$('#comment').keypress(function(){if(this.value.length > 0){$('.error_comment').hide();}else{$('.error_comment').show();}});

$.getJSON("https://api.ipstack.com/182.69.214.129?access_key=7f991c4347bde02923aa4a027815fdee&format=1", function(data) {
var ip = data.ip;
var country = data.country_name;
$(".country_name").html(country);
});

</script>
<!-- appointment sheduler -->

<div class="clearfix"></div>
<!-- Footer -->
<footer class="footer   font-color-custom" id="site-footer">
  <div class="header-lines-decoration">
    <span class="bg-secondary-color"></span>
    <span class="bg-blue"></span>
    <span class="bg-blue-light"></span>
    <span class="bg-orange-light"></span>
    <span class="bg-red"></span>
    <span class="bg-green"></span>
    <span class="bg-secondary-color"></span>
  </div>
  <div class="container">
    <div class="row">
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
    <div class="widget w-info">
    <div class="heading-text">
    <div class="col-sm-6 f-left"><img class="alignnone size-medium wp-image-2595" src="../images/logo.png" alt="" width="300" height="165" /></div><div class="col-sm-6 s-right"><p>To make things difficult is easy, to make things simple is difficult.<br />The key and magic to success is to ideate as if explaining it to a child.<br />Remember following a plan is good for progress, opportunities are often off-road</p></div><div class="s-icon"><h5>Get In Touch With Us</h5><ul><li><a title="" href="https://twitter.com/MrCanvasB2B" target="_self"><br /><i class="fa-twitter"></i><br /></a></li><li><a title="" href="skype:martinathoy?call" target="_blank" rel="noopener"><br /><i class="fa-skype"></i><br /></a></li><li><a title="" href="https://www.pinterest.com/strategy2day/" target="_self"><br /><i class="fa-pinterest"></i><br /></a></li><li><a title="" href="https://linkedin.com/in/martinschoonhoven" target="_self"><br /><i class="et-linkedin"></i><br /></a></li></ul></div>                </div>
    </div>
    </div>
    </div>
  </div>

  <div class="sub-footer">
      <div class="container  large font-color-custom">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <span class="site-copyright-text">
              © 2020 odapto.com All rights reserved. Powered by <a target="_blank" href="https://www.depextechnologies.com/"> Depex </a></span>
          </div>
        </div>
      </div>
  </div>
</footer>
  </body>
</html>