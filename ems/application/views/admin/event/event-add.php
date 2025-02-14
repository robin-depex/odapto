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
                    <h2>Event <small>Add</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a><i>&nbsp;</i></a></li>
                      <li>
                        <a href="<?php echo base_url().'index.php/event'; ?>" role="button"><i class="fa fa-mail-reply-all"></i></a>
                        
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm','class'=>'form-horizontal form-label-left');
                  echo form_open_multipart('event/create',$attributes); ?>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_event_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="txt_event_name" placeholder="Event Name"  required="required" type="text" >
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control" name="txt_event_add" required="required"></textarea>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Date <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_event_date" class="form-control col-md-7 col-xs-12" data-inputmask="'mask': '99-99-9999'" name="txt_event_date" placeholder="DD/MM/YYYY"  required="required" type="text" >
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Image <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="fl_event_image" class="col-md-7 col-xs-12" name="fl_event_image" placeholder="Event Date"  required="required" type="file" >
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Allow Person <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_event_person" class="form-control col-md-7 col-xs-12" name="txt_event_person" placeholder="Event Person"  required="required" type="text" >
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Event Is Active ? <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="checkbox">
                            <label>
                              <input type="radio" class="flat" name="txt_event_is_active" value="yes"> Yes 
                              <input type="radio" class="flat" name="txt_event_is_active" value="no"> No 
                            </label>
                          </div>
                        </div>
                      </div>

			               <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="button" onclick="javascript:window.location.href='<?php echo base_url().'index.php/event' ?>'" class="btn btn-primary">Cancel</button>
                          <button id="send" type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
              <?php echo form_close(); ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
	// include footer file
 
 $this->load->view('admin/include/footer.php'); ?>