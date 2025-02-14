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
                    <h2>Event <small>Edit</small></h2>
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
                    $attributes = array('id' => 'frme','name'=>'frme','class'=>'form-horizontal form-label-left');
                    echo form_open_multipart('event/update/'.$this->uri->segment(3),$attributes); ?>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_event_name" class="form-control col-md-7 col-xs-12" name="txt_event_name" placeholder="Name"  required="required" type="text" value="<?php echo $recored['event_name']; ?>">
                        </div>
                      </div>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="txt_event_add" required="required" name="txt_event_add" class="form-control col-md-7 col-xs-12"><?php echo $recored['event_add']; ?></textarea>
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Event Date <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_event_date" class="form-control col-md-7 col-xs-12"  name="txt_event_date" placeholder="dd/mm/yyyy"  data-inputmask="'mask': '99-99-9999'" required="required" type="text"  value="<?php echo date('d-m-Y',strtotime($recored['event_date'])) ; ?>">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Image <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="fl_event_image" class="col-md-7 col-xs-12" name="fl_event_image" placeholder="Event Date"  type="file" >
                        </div>
                    </div>

                    <?php 
                      $image = "file/event/".$recored['event_image'];
                      if (file_exists($image) && !empty($recored['event_image'])) {
                        echo '<div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="logo"> Delete Image 
                                  </label>
                                  <div class="col-md-1 col-sm-1 col-xs-12 checkbox">
                                    &nbsp;&nbsp;
                                    <input type="checkbox" name="chkdelete_image" value="yes" class="flat">
                                  </div>

                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                    <img src="'.base_url().$image.'" width="150" height="100" alt="Event Image" />
                                  </div>

                                </div>';
                      }
                    ?>


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Event Allow Person <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="txt_event_person" class="form-control col-md-7 col-xs-12" name="txt_event_person" placeholder="Event Person"  required="required" type="text" value="<?php echo $recored['event_person']; ?>" >
                        </div>
                    </div>
                     
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Is Active ? <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <div class="checkbox">
                            <label>
                              <?php $is_act = $recored['event_is_active']; ?>
                              <input type="radio" class="flat" <?php if($is_act == 'yes') echo 'checked'; ?> name="txt_event_is_active" value="yes"> Yes 
                              <input type="radio" class="flat" <?php if($is_act == 'no') echo 'checked'; ?> name="txt_event_is_active" value="no"> No 
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
          <!-- Table End -->
          
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>

        
  </body>
</html>

