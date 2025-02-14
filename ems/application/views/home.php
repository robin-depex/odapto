<?php
  
  $CI =& get_instance();

?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Wizard Tutorial: Add A New Step</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/assets_m/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/assets_m/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>_template/assets_m/css/form-elements.css">

    <!-- bootstrap-datetimepicker -->
    <link href="<?php echo base_url(); ?>_template/vendors/datepicker/datepicker3.css" rel="stylesheet">

    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url(); ?>_template/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="<?php echo base_url(); ?>_template/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

        <link rel="stylesheet" href="<?php echo base_url(); ?>_template/assets_m/css/style.css">

       

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 form-box">
                      <form role="form" action="<?php echo base_url(); ?>index.php/home/add_event_client" method="post" class="f1">
                       <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <h3>Register To EventSYS</h3>
                        <p>Fill in the form to get instant Scheduale</p>
                        <div class="f1-steps">
                          <div class="f1-progress">
                              <div class="f1-progress-line" data-now-value="12.5" data-number-of-steps="3" style="width: 12.5%;"></div>
                          </div>
                          <div class="f1-step active">
                            <div class="f1-step-icon"><i class="fa fa-calendar"></i></div>
                            <p>Choose Event</p>
                          </div>
                          <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                            <p>Your Info</p>
                          </div>
                          <div class="f1-step">
                            <div class="f1-step-icon"><i class="fa fa-question"></i></div>
                            <p>Confirmation</p>
                          </div>
                            
                        </div>
                        
                        <fieldset>

                            <h4>Event Booking:</h4>
                            <div class="form-group">
                              <label>Event</label>
                                <select class="form-control" name="event" id="event" onchange="get_avi(this.value)">
                                  <option value="">~~ Select Event ~~</option>
                                  <?php echo $event = $CI->get_event(); ?>  
                                </select>
                            </div> 

                            <div class="form-group">
                              <label>Select Person</label>
                              <select name="person" id="person" class="form-control" disabled="disabled">
                                <option value="">~~ Select Person ~~</option>
                              </select>
                            </div>

                               <div class="f1-buttons">
                                    <button type="button" id="btn_1" class="btn btn-next">Next</button>
                                </div>
                            </fieldset>

                            <fieldset>
                                <h4>Personal Information:</h4>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text"  name="txt_name" placeholder="Name..." class="form-control" id="txt_name">
                                </div>

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="txt_phone" placeholder="Phone Number..." class="form-control" id="phone_number">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" onblur="check_email(this.value)" name="txt_email" placeholder="Email..." class="form-control" id="email">
                                </div>
                                
                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-previous">Previous</button>
                                    <button type="button" onclick="show_data();" class="btn btn-next">Next</button>
                                </div>
                            </fieldset>
                            
                            <fieldset>
                                
                              <h4>Confirmed!?</h4>

                              <div class="row">
                                <div class="col-md-3">
                                  <span class="image">
                                    <img src="<?php echo base_url(); ?>_template/images/mimg.jpg" alt="Image" />
                                  </span>
                                </div>
                                <div class="col-md-9">
                                  <div class="form-group">
                                      <label class="lable-control" >
                                        <strong>Name: </strong> 
                                        <span id="l_s_name"></span>
                                      </label>
                                      <br />
                                      <label class="lable-control" >
                                        <strong>Phone: </strong> 
                                        <span id="l_s_phone"></span>
                                      </label>
                                      <br />
                                      <label class="lable-control" >  <strong>Email: </strong>
                                      <span id="l_s_email"></span>
                                      </label>
                                  </div>
                                  <div class="form-group">
                                    <label class="lable-control">
                                      <strong>Event Name:
                                      </strong>
                                      <span id="l_s_event"></span>
                                    </label>
                                    <br />
                                    <label class="lable-control">
                                      <strong>Total Person :</strong>
                                      <span id="l_s_person"></span>
                                    </label>

                                  </div>

                                  <div class="form-group">
                                      <button type="button" onclick="javascript:window.location.href='<?php echo base_url().'index.php/home' ?>'" class="btn btn-primary">Cancel</button>
                                      <button id="send" type="submit" class="btn btn-success">Submit</button>
                                  </div>

                                </div>
                              </div>
                            </fieldset>

                      </form>
                    </div>
                </div>
                    
            </div>
        </div>


        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>_template/assets_m/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>_template/assets_m/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>_template/assets_m/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>_template/assets_m/js/retina-1.1.0.min.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script src="<?php echo base_url(); ?>_template/vendors/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>_template/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="<?php echo base_url(); ?>_template/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <!-- bootstrap-datetimepicker -->    
    <script src="<?php echo base_url(); ?>_template/vendors/datepicker/bootstrap-datepicker.js"></script>

        <script src="<?php echo base_url(); ?>_template/assets_m/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets_m/js/placeholder.js"></script>
        <![endif]-->
      <script type="text/javascript">
        $( document ).ready(function() {
          $("#btn_1").prop('disabled',true);
        });

        function get_avi(id)
        {
          $.ajax({
           url: '<?php echo base_url() ?>index.php/calendar/get_person/'+id,
           success: function(msg) {

              if(msg != '')
              {
                $('#person').prop('disabled', false);
                $('#person').html(msg);
                $("#btn_1").prop('disabled',false);
              }
              else
              {
                alert('Event Is Houseful !!!');
                $("#btn_1").prop('disabled',true);
                $('#person').prop('disabled', true);
                $('#person').html('');
              }
           }
           });
        }

         function check_email(email)
         {
          var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
            var comy =(email.match(r) == null) ? false : true;

            if(!comy)
            {
              $('#email').focus();
              $('#email').css('border-color','#29A74A');

            }
            else
            {
              $('#email').css('border-color','#DDDDDD');
            }
         }
         function show_data()
         {
            var user_name = $("#txt_name").val();
            var email = $("#email").val();
            var phone = $("#phone_number").val();
            var event = $("#event").val();
            var person = $("#person").val();
            
            $.ajax({
              url: '<?php echo base_url() ?>index.php/home/get_event_name/'+event,
              success: function(msg) {
                $("#l_s_event").html(msg);
              }
            });

            $("#l_s_name").html(user_name);
            $("#l_s_email").html(email);
            $("#l_s_phone").html(phone);
            $("#l_s_person").html(person);
            
         }

         function add_all_data()
         {
            var user_name = $("#txt_name").val();
            var email = $("#email").val();
            var phone = $("#phone_number").val();
            var event_id = $("#event").val();
             $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>index.php/home/add_event_client",
                data: {'user_name':user_name,'email':email,'phone':phone,'event_id':event_id}
            }).done(function( msg ) { 
                alert(msg);
            })
         }
      </script>
    </body>

</html>