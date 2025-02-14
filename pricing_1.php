<?php  
error_reporting(0);
ini_set('display_errors', 1);
require_once("common/config.php");
session_start();
unset($_SESSION['logintype']);
require_once("DBInterface.php");
$db = new Database();
$db->connect();
if(!empty($_SESSION['auth'])){
$uid = $_SESSION['sess_login_id'];
$result = $db->getUserMeta($uid);
//print_r($result);
}
//print_r($_SESSION);
?>
<html lang="en">
   <head>
      <title>Pricing</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    
   </head>
   <body>
      <div class="container">
         <div class="row">
            <div style="    background:#ffffff;padding: 20px 15px;" class="col-sm-12">
               <ul class="list-inline">
                  <li class="pull-left"><a style="color:#FFF" href="index.php"><img style="width:150px" src="images/logo.png"></a></li>
                 <!--  <li class="pull-right"><a style="color:#FFF" href="#">Go to Your Boards →</a></li> -->
               </ul>
            </div>
            <div class="col-sm-12">
               <div class="layout-centered u-center-text text-center">
                  <div class="layout-centered-content">
                     <h1>See What Odapto Can Do For You</h1>
                     <p> Trusted by millions, Odapto powers teams around the world. <br>Check out which option is right for you. </p>
                  </div>
               </div>
            </div>
            <div class="col-sm-12">
               <div class="u-center-text text-center">
                 <div class="col-sm-4">
                  <div class="pricing-section pricing-section-free">
                     <div class="pricing-section-item">
                        <div class="pricing-section-top">
                           <h1>Free</h1>
                           <p class="pricing-section-item-description" style="margin: 1.75em 1em 1em;"> A simple and powerful way to get things done. </p>
                           <span class="pricing-section-price" style="margin-bottom: 0.7em; display: block;"> $0 </span> 
                          
                             
                        </div>
                        <div class="pricing-section-bottom">
                          <!-- <p style="padding:15px;" class="pricing-section-quiet"> 1 month trial will be free for all after 1 months the Apps will Drive the user to signup for Paid giving benefits of the paid features.</br>But most of the easy features like creation of Boards and lists and cards etc all will be free for the user except the below features will be all paid </p>-->
                           <ul class="pricing-section-list">
                              <!--<li><span>Unlimited boards, lists, cards, members, checklists, and attachments. </span></li>
                              <li><span>One <a href="/power-ups">Power-Up</a> per Board</span></li>
                              <li><span>Attach files up to 10MB from your computer, or link any file from your Google Drive, Dropbox, Box, or OneDrive.</span></li>-->
                              <li>5 Limited boards only. Unlimited cards and Lists</li>
                              <li>Free templates only 3 general</li>
                              <li>2 MB Only free of cost for attachments</li>
                              <li>No Teams boards allowed </li>
                              <li>No Integrate </li>
                              <li>No Support </li>
                              <li>No Videos, No Training, No Manual support </li>
                              <li>No Consultancy advice </li>
                              <li>Chat support only ( This is mandatory for Conversions to paid users) </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                   </div>
                    <div class="col-sm-4">
                  <div class="pricing-section pricing-section-bc">
                     <div class="pricing-section-item">
                        <div class="pricing-section-top">
                           <h2>Business Class</h2>
                           <p class="pricing-section-item-description"> App integrations, team overviews, and more security. </p>
                           <span class="pricing-section-price" style="margin-bottom: 0.7em; display: block;"> $7 </span> 
                           <p class="pricing-section-quiet"> per user/month<!--<br> <span class="small"> (when paid annually) </span>--> </p>
                           <!--<a class="u-link" href="/select-team-to-upgrade" data-track="Pricing - Upgrade"> Upgrade Team </a> -->
                           <?php if(empty($_SESSION['auth'])){ ?>
                     <a class="u-link" href="login.php?logintype=pricing" data-track="Sign Up"> Login </a> 
                           <?php }else{ ?>

 <form class="paypal" action="paypal.php" method="post" id="paypal_form">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="no_note" value="7" />
        <input type="hidden" name="lc" value="USD" />
        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
        <input type="hidden" name="first_name" value="Pooja" />
        <input type="hidden" name="last_name" value="Singh" />
        <input type="hidden" name="payer_email" value="phpdepexdeveloper@gmail.com" />
        <input type="hidden" name="item_number" value="Business Plan" / >
        <input class="u-link" type="submit" name="submit" value="Upgrade Plan"/>
    </form>


                          <!-- <a class="u-link" href="paypal.php?planid=2" data-track="Pricing - Upgrade"> Upgrade Plan </a> -->
                           <?php } ?>
                        </div>
                        <div class="pricing-section-bottom">
                           <ul class="pricing-section-list">
                              <li><span>Unlimited boards</span></li>
                              <li><span> Teams boards</span></li>
                              <li><span>Only 2 Integrations</span></li>
                              <li><span>Attachments upto 1 GB</span></li>
                              <li><span>Templates all can be used by the user</span></li>
                              <li><span>Chat support & Email support ( This is mandatory for Conversions to paid users)</span></li>
                              <li><span>Ticket support for any issue raised  ( This is mandatory for Conversions to paid users)</span></li>
                              
                           </ul>
                        </div>
                     </div>
                  </div>
                 </div> 
                 <div class="col-sm-4">
                  <div class="pricing-section pricing-section-enterprise">
                     <div class="pricing-section-item">
                        <div class="pricing-section-top">
                           <h2>Enterprise</h2>
                           <p class="pricing-section-item-description"> For large companies managing multiple teams across Odapto. </p>
                           <div class="enterprise-price">
                              <span class="pricing-section-price"> $15 </span> 
                              <div class="enterprise-notes">
                               <!--  <p> <a href="" class="show-pricing">or less</a> </p>-->
                              </div>
                           </div>
                           <table class="pricing-table hide">
                              <tbody>
                                 <tr class="pricing-table-headers">
                                    <th class="left-col">Tiers</th>
                                    <th class="right-col">Per user in tier</th>
                                 </tr>
                                 <tr>
                                    <td class="left-col">100-300</td>
                                    <td class="right-col">$20.83</td>
                                 </tr>
                                 <tr>
                                    <td class="left-col">301-500</td>
                                    <td class="right-col">$12.50</td>
                                 </tr>
                                 <tr>
                                    <td class="left-col">501-1,000</td>
                                    <td class="right-col">$8.33</td>
                                 </tr>
                                 <tr>
                                    <td class="left-col">1,000+</td>
                                    <td class="right-col">$4.17</td>
                                 </tr>
                              </tbody>
                           </table> 
                           <p class="pricing-section-quiet"> per user/month<br> <span class="small"> (when paid annually) </span> </p>
                         <!--  <a class="u-link" href="/enterprise#contact" data-track="Learn More - Enterprise"> Contact Us </a> -->
                       <?php if(empty($_SESSION['auth'])){ ?>
                     <a class="u-link" href="login.php?logintype=pricing" data-track="Sign Up"> Login </a> 
                           <?php }else{
//$paypalId='kvs3944-facilitator@gmail.com';
$paypalId='phpdepexdeveloper-facilitator@gmail.com';
//$paypalId='phpdepexdeveloper-facilitator_api1.gmail.com';
                            ?>
                          <!--<form class="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmPayPal1" id="paypal_form">-->
                          <form class="paypal" action="paypal.php" method="post" name="frmPayPal1" id="paypal_form">
     <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="no_note" value="15" />
        <input type="hidden" name="lc" value="USD" />
        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
        <input type="hidden" name="first_name" value="Pooja" />
        <input type="hidden" name="last_name" value="Singh" />
        <input type="hidden" name="payer_email" value="phpdepexdeveloper@gmail.com" />
        <input type="hidden" name="item_number" value="Enterprise Plan" / >
        <input class="u-link" type="submit" name="submit" value="Upgrade Plan"/>

          <!--  <input type="hidden" name="business" value="phpdepexdeveloper-facilitator@gmail.com">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="item_name" value="Enterprise Plan">
                <input type="hidden" name="item_number" value="3">
                <input type="hidden" name="amount" value="15">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="cancel_return" value="https://odapto.com/payment-cancelled.php">

 
                <input type="hidden" name="return" value="https://odapto.com/payment-successful.php">  
          <button class="btn btn-lg btn-block btn-danger" href="#">BUY NOW!</button>-->
    </form>
                           <?php } ?>
                        </div>
                        <div class="pricing-section-bottom">
                           <ul class="pricing-section-list">
                              <li><span>Unlimited boards</span></li>
                              <li><span>Teams boards</span></li>
                              <li><span>All Integrations</span></li>
                              <li><span>Attachments upto 5 GB</span></li>
                              <li><span>Templates all can be used by the user</span></li>
                              <li><span>Videos, training's, manuals</span></li>
                              <li><span>Consultancy / advice</span></li>
                              <li><span>Chat support & Email support </span></li>
                              <li><span>Ticket support for any issue raised</span></li>
                              <li><span>Also Phone Direct support</span></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
    
   </body>
</html>

  <style>
         .layout-centered {
         padding: 3em 1em;
         word-break: break-word;
         }
         body{
         font-family: 'Open Sans', sans-serif;
         }
         .layout-centered-content {
         margin: 0 auto;
         max-width: 650px;
         }
.pricing-section-bc .pricing-section-top {
    background: #42548e;
}
.pricing-section-free .pricing-section-top {
    background: #298fca;
}
.pricing-section-enterprise .pricing-section-top {
    background: #36405f;
}
.pricing-section-top {
    color: white;
    padding: 1em;
    border-radius: 6px 6px 0 0;
}
.pricing-section-bottom {
    text-align: left;
    border: 1px solid #d6dadc;
    border-radius: 0 0 6px 6px;
    border-top: none;
    margin-bottom: 2em;
} 
.pricing-section-price {
    font-size: 2em;
    font-weight: bold;
    margin: 0 auto;
    display: block;
}
.u-link {
    color: #36405f;
    border: 2px solid #36405f;
    padding: 7px 26px;
    background: #fff;
    letter-spacing: 1px;
    border-radius: 25px;
    margin-bottom: 50px !important;
    display: block;
    max-width: 200px;
    margin: 50px auto;
    outline:0 !important;
}
.u-link:hover{
    text-decoration: none;
    color: #36405f;
    border: 2px solid #36405f;
    padding: 7px 26px;
    background: #fff;
    letter-spacing: 1px;
    border-radius: 25px;
    margin-bottom: 50px !important;
    display: block;
    max-width: 200px;
    margin: 50px auto;
    outline:0 !important;
  }
  .pricing-section-list li {
    padding: .5em 0;
} 
     
      </style>