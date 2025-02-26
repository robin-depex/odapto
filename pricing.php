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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Pricing</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="https://www.odapto.com/images/small-logo.png" sizes="16x16">
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
                        <li class="pull-left">
                            <a style="color:#FFF" href="index.php"><img style="width:150px" src="images/logo.png"></a>
                        </li>
                        <?php
                    if(!empty($_SESSION['auth'])){
                        echo '<li class="pull-right"><h3><a  href="dashboard.php">Go to Dashboard →</a></h3></li> ';
                    }else{
                        echo '<li class="pull-right"><h3><a  href="index.php">Home →</a></h3></li> ';
                    }
                  ?>

                    </ul>
                </div>

                <div class="col-sm-12">
                    <div class="layout-centered u-center-text text-center">
                        <div class="layout-centered-content">
                            <h1>See What Odapto Can Do For You</h1>
                            <p> Trusted by millions, Odapto powers teams around the world.
                                <br>Check out which option is right for you. </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="u-center-text text-center">
                        <?php
                        $plan=$db->membership_plan('tbl_membership_plan');
                        
                        if(count($plan)>0)
                        { 
                            foreach($plan as $plans):

                            ?>

                            <div class="col-sm-4">
                                <div class="pricing-section <?php if($plans['id']==1){ echo 'pricing-section-free';}elseif($plans['id']==2){ echo 'pricing-section-bc'; }elseif($plans['id']==3){ echo 'pricing-section-enterprise';} ?>">
                                    <div class="pricing-section-item">
                                        <div class="pricing-section-top">
                                            <h3> <?= $plans['plan_name']; ?></h1>
                                            <p class="pricing-section-item-description" style="margin: 1.75em 1em 1em;">
                                                <?= $plans['plan_desc']; ?>
                                            </p>
                                            <span class="pricing-section-price" style="margin-bottom: 0.7em; display: block;">  $<?= $plans['plan_price']; ?> </span>
                                            <?php
                                                if($plans['id']==1)
                                                {
                                                    echo '<p class="pricing-section-quiet">  Free, forever. </p>';
                                                }elseif($plans['id']==2 || $plans['id']==3){
                                                    echo '<p class="pricing-section-quiet"> Per user/month </p>';
                                                }

                                            ?>

                                            <?php if(empty($_SESSION['auth'])){ ?>
                                                <a class="u-link" href="login.php?logintype=pricing" data-track="Sign Up"> Login </a>
                                                <?php 
                                                    }else{
                                                   if($plans['id']==1)
                                                   {
                                                       echo '<a class="u-link" href="dashboard.php" data-track="Dashboard"> Dashboard </a> ';
                                                   }
                                                   elseif($plans['id']==2 || $plans['id']==3)
                                                   { 
                                                       //$paypalId='kvs3944-facilitator@gmail.com';
                                                        $paypalId='sb-1d8sc34359402@business.example.com';
                                                        //$paypalId='phpdepexdeveloper-facilitator_api1.gmail.com';

                                                   ?>
                                                                     
                                                        <form class="paypal" action="paypal.php" method="post" id="paypal_form">
                                                            <input type="hidden" name="cmd" value="_xclick" />
                                                            <input type="hidden" name="no_note" value="<?= $plans['plan_price'] ?>" />
                                                            <input type="hidden" name="lc" value="USD" />
                                                            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                                            <input type="hidden" name="first_name" value="Depex" />
                                                            <input type="hidden" name="last_name" value="Technology" />
                                                            <input type="hidden" name="payer_email" value="robin.depex@gmail.com" />
                                                            <input type="hidden" name="item_number" value="<?= $plans['id']; ?>" />
                                                            <input class="u-link" type="submit" name="submit" value="Upgrade Plan" />
                                                        </form>

                                                        <?php  }
                                               ?>

                                                            <?php } ?>

                                        </div>
                                        <div class="pricing-section-bottom">

                                            <ul class="pricing-section-list">
   
                                                <?php
                                            if(!empty($plans['feature1'])){
                                                echo '<li>'.$plans['feature1'].'</li>';
                                            }
                                            if(!empty($plans['feature2'])){
                                                echo '<li>'.$plans['feature2'].'</li>';
                                            }
                                            if(!empty($plans['feature3'])){
                                                echo '<li>'.$plans['feature3'].'</li>';
                                            }
                                            if(!empty($plans['feature4'])){
                                                echo '<li>'.$plans['feature4'].'</li>';
                                            }
                                            if(!empty($plans['feature5'])){
                                                echo '<li>'.$plans['feature5'].'</li>';
                                            }
                                            if(!empty($plans['feature6'])){
                                                echo '<li>'.$plans['feature6'].'</li>';
                                            }
                                            if(!empty($plans['feature7'])){
                                                echo '<li>'.$plans['feature7'].'</li>';
                                            }
                                            if(!empty($plans['feature8'])){
                                                echo '<li>'.$plans['feature8'].'</li>';
                                            }
                                            if(!empty($plans['feature9'])){
                                                echo '<li>'.$plans['feature9'].'</li>';
                                            }
                                            if(!empty($plans['feature10'])){
                                                echo '<li>'.$plans['feature10'].'</li>';
                                            }
                                          ?>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                         endforeach;
                        }else{
                            echo "No data Found";
                        }
                   ?>

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
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: #506478;
            font-size: 17px;
        }
        
        .layout-centered-content {
            margin: 0 auto;
            max-width: 650px;
        }
        .pricing-section{
          min-height: 725px;
          margin-top: 20px;
        }
        /*.pricing-section-bc .pricing-section-top {
    background: #42548e;
}
.pricing-section-free .pricing-section-top {
    background: #298fca;
}
.pricing-section-enterprise .pricing-section-top {
    background: #36405f;
}*/
        
        .pricing-section-top {
            color: white;
            padding: 1em;
            border-radius: 6px 6px 0 0;
        }
        

        
        .pricing-section-price {
            font-size: 3.5em;
            font-weight: 300;
            margin: 0 auto;
            display: block;
        }
        .pricing-section-free .pricing-section-item-description,.pricing-section-enterprise .pricing-section-item-description{
          color: #1c5e7d;
        }
        .pricing-section-bc .pricing-section-item-description{
          color: #af4b17;
        }
        
        .u-link {
            color: #fff;
            border: 2px solid #0c1f28;
            padding: 7px 26px;
            background: #0c1f28;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 3px;
            margin-bottom: 0px !important;
            display: block;
            max-width: 171px;
            margin: 22px auto;
            outline: 0 !important;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .u-link:hover {
            background-color: #112e3c;
            border: 2px solid #112e3c;
            color: #fff;
            text-decoration: none;
        }
        .pricing-section-item-description{
          text-transform: uppercase;
          font-size: 14px;
        }
        
        .pricing-section-list {
            padding: 0 15px 15px;
        }
        
        .pricing-section-list li {
            padding: .5em 0;
            list-style: none;
            color: #fff;
            font-size: 14px;
            text-align: center;
        }
        
        .pricing-section-free {
            border-radius: 30px;
            background: linear-gradient(to top, #3aa0d1, #3ad2d1);
        }
        
        .pricing-section-bc {
            border-radius: 30px;
            background: linear-gradient(to top, #e97d68, #e99b68);
        }
        
        .pricing-section-enterprise {
            border-radius: 30px;
            background: linear-gradient(to top, #3aa0d1, #3ad2d1);
        }
    </style>