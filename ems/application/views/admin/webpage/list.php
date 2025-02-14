<!DOCTYPE html>
<html lang="en"> 

  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
            
          <!-- /top tiles -->


          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event Embed Scheduling Inline into your Website  <small></small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p>Add the full scheduler directly into your own website for clients to book appointments with you.</p>
                    <p>Embed the scheduler into your website yourself with this HTML code:</p>
                    <textarea class="form-control"><iframe src="<?php echo base_url(); ?>index.php/home" width="100%" height="800" frameBorder="0"></iframe>
                    </textarea>

                    
                    
                  </div>
                </div>
              </div>
              <br>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>E-Mail <small>Configuration</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <?php 
                    $attributes = array('id' => 'frm','name'=>'frm','class'=>'form-horizontal form-label-left');
                    echo form_open('webpage/update_email/'.$this->uri->segment(3),$attributes); ?>
                      <span class="section">Information </span>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Smtp Host Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="txt_name" placeholder="Host Name"  required="required" type="text" value="<?php echo $recored['host_name']; ?>">
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Smtp user Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_user_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="txt_user_name" placeholder="User Name"  required="required" type="text" value="<?php echo $recored['host_user_name']; ?>">
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Smtp user Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input  id="txt_user_pass" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="txt_user_pass" placeholder="Password"  required="required" type="password" value="<?php echo $recored['host_user_pass']; ?>">
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="button" onclick="javascript:window.location.href='<?php echo base_url().'index.php/webpage' ?>'" class="btn btn-primary">Cancel</button>
                          <button id="send"  type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
          <!-- Calendar End -->
        </div>
        <!-- /page content -->
       <?php $this->load->view('admin/include/footer'); ?>
  </body>
</html>

