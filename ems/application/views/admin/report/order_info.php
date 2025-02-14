<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>


<title>Booking Information</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>_template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>_template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>_template/vendors/nprogress/nprogress.css" rel="stylesheet">
    
    <!-- Custom styling plus plugins -->
    <link href="<?php echo base_url(); ?>_template/build/css/custom.min.css" rel="stylesheet">

</head>

    <body>


    <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Booking <small>Information</small></h3>
              </div>

            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Booking <small> Information</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <section class="content invoice">
                      <!-- title row -->
                      <div class="row">
                        <div class="col-xs-12 invoice-header">
                            <h1>
                              <i class="fa fa-calendar"></i> Booking.
                              <small class="pull-right">Date: <?php echo date('d-m-Y',strtotime($order[0]->booking_date)); ?></small>
                            </h1>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                          <h2>User Info</h2>
                          <address>
                              <strong><?php echo $order[0]->customer_first_name; ?></strong>
                              <br><?php echo $order[0]->customer_city; ?>
                              <br><?php echo $order[0]->customer_zipcode; ?>
                              <br>Phone: <?php echo $order[0]->customer_phone; ?>
                              <br>Email: <?php echo $order[0]->customer_email; ?>
                          </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <h2>Event Information</h2>
                          <address>
                              <strong>Name :</strong>
                              <span><?php echo strtoupper($order[0]->event_name); ?></span>
                              <br>
                              <strong>Venue :</strong>
                              <span><?php echo strtoupper($order[0]->event_add); ?></span>
                              <br>
                              <strong>Event Date :</strong>
                              <span><?php echo date('d-m-Y',strtotime($order[0]->event_date)); ?></span>
                              <br>
                              <strong>Book Person :</strong>
                              <span><?php echo strtoupper($order[0]->person); ?></span>
                              <br>
                          </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <b>QR Code </b>
                          <br>
                          <img src="<?php echo base_url(); ?>file/qr/<?php echo $order[0]->booking_id; ?>.png" height="100" width="100"> 
                          <br>
                          
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->


                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
                        <div class="col-xs-12">
                          <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                          
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div


    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>_template/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>_template/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>_template/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>_template/vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>_template/build/js/custom.min.js"></script>
   </body>

</html>
