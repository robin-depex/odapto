<?php
  
  $CI =& get_instance();

?>

<!DOCTYPE html>
<html lang="en"> 

  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          
          <?php if(validation_errors() != false){ ?>
          <br />
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Error!</h4>
                <?php echo validation_errors(); ?>
            </div>
          </div>
          <?php } ?>
          
          <!-- Regular Notification -->
          <!-- /Regular Notification -->
          <!-- Table Start -->
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Booking <small>Add New</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a><i>&nbsp;</i></a></li>
                      <li>
                        <a href="<?php echo base_url().'index.php/booking'; ?>" role="button"><i class="fa fa-mail-reply-all"></i></a>
                        
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url(); ?>index.php/booking/create" method="post">

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="event-name">Select Event <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="event" id="event" required="required" onchange="get_avi(this.value)">
                          <option value="">~~Select Event~~</option>
                          <?php echo $event = $CI->get_event(); ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Select Person <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-7 col-xs-12" name="person" id="person" disabled="disabled" required="required">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="user_name" required="required">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Phone<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="phone" class="form-control col-md-7 col-xs-12" required="required" name="user_phone" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">E-Mail<span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="email" class="form-control col-md-7 col-xs-12" required="required" name="user_email" type="email">
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="button">Cancel</button>
                       
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
          <!-- Table End -->
          
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>

  <script type="text/javascript">
    
    function get_avi(id)
    {
      $.ajax({
       url: '<?php echo base_url() ?>index.php/calendar/get_person/'+id,
       success: function(msg) {

          if(msg != '')
          {
            $('#person').prop('disabled', false);
            $('#person').html(msg);
          }
          else
          {
            alert('That\'s Event in Not Available Person !!!');
            $('#person').prop('disabled', true);
            $('#person').html('');
          }
       }
       });
    }

  </script>
        
  </body>
</html>

