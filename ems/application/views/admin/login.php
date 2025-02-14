<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EMS | Login Page </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>_template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>_template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>_template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url(); ?>_template/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>_template/build/css/custom.min.css" rel="stylesheet">
  </head>
 
  <body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          
          <?php if($this->session->flashdata('logout_msg') != false){ ?>
               <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4>  <i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo $this->session->flashdata('logout_msg'); ?>
              </div>
          <?php } ?>

          <?php if($this->session->flashdata('msg') != false){ ?>
             <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4>  <i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo $this->session->flashdata('msg'); ?>
            </div>
          <?php } ?>

              <?php if(validation_errors() != false){ ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    <?php echo validation_errors(); ?>
                </div>
              <?php } ?>
          <section class="login_content">
            <?php 
               $attributes = array('id' => 'frm','name'=>'frm');
              echo form_open('login/check',$attributes); 
            ?>
            
              <h1>Login Form</h1>
              <div>
                <input type="text" name="user_name" class="form-control" placeholder="Username"  />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password"  />
              </div>
              <div>
                <input type="submit"  class="btn btn-default submit" name="login" value="Log in" />
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <!--<h1><img src="<?php echo base_url(); ?>_template/images/appoint.png" height="50" /> EMS</h1>
                  <p>Copyright © 2020 Event Management System</p>-->
                </div>
              </div>
            <?php echo form_close(); ?>
          </section>
        </div>
      </div>
    </div>

     <!-- jQuery -->
    <script src="<?php echo base_url(); ?>_template/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>_template/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

  </body>
</html>
