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

          <?php if($this->session->flashdata('msg') != false){ ?>
           <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>  <i class="icon fa fa-check"></i> Alert!</h4>
              <?php echo $this->session->flashdata('msg'); ?>
          </div>
          <?php } ?>

          <?php if($this->session->flashdata('error') != false){ ?>
           <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4>  <i class="icon fa fa-ban"></i> Error!</h4>
              <?php echo $this->session->flashdata('error'); ?>
          </div>
          <?php } ?>
          
          <!-- Regular Notification -->
          <!-- /Regular Notification -->
          <!-- Table Start -->
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event <small>Webpage</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a><i>&nbsp;</i></a></li>
                      <li>
                        <a href="<?php echo base_url().'index.php/config'; ?>" role="button"><i class="fa fa-mail-reply-all"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <form action="<?php echo base_url(); ?>index.php/config/update/<?php echo $this->uri->segment(3); ?>"  id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" >

                  <div class="row">
                    <div class="col-md-6">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Logo <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="file" id="fl_logo" name="fl_logo" class=" col-md-10 col-xs-12">
                        </div>
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="last-name">Recommended Dimension: Height:140px  Width:140px</label>
                      </div>

                      <?php
                         $image = 'file/config/'.$objconfig['co_logo'];
                        
                         if (file_exists($image) && $objconfig['co_logo'] != '' ) {

                            echo '<div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="logo"> Delete Logo 
                                  </label>
                                  <div class="col-md-1 col-sm-1 col-xs-12 checkbox">
                                    &nbsp;&nbsp;
                                    <input type="checkbox" name="chkdelete_logo" value="yes" class="flat">
                                  </div>

                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                    <img src="'.base_url().$image.'" width="150" height="100" alt="Logo" />
                                  </div>

                                </div>';
                        }
                      ?>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Header Image <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="file" id="fl_header" name="fl_header"  class="col-md-10 col-xs-12">
                        </div>
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="last-name">Recommended Dimension: Height:1200px  Width:500px</label>
                      </div>

                      <?php
                         $image_h = 'file/header/'.$objconfig['co_image'];
                        
                         if (file_exists($image_h) && $objconfig['co_image'] != '' ) {

                            echo '<div class="form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="logo"> Delete Image 
                                  </label>
                                  <div class="col-md-1 col-sm-1 col-xs-12 checkbox">
                                    &nbsp;&nbsp;
                                    <input type="checkbox" name="chkdelete_image" value="yes" class="flat">
                                  </div>

                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                    <img src="'.base_url().$image_h.'" width="350" height="100" alt="Header" />
                                  </div>

                                </div>';
                        }
                      ?>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meta Title</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control col-md-10 col-xs-12" name="txt_meta_title" id="txt_meta_title" value="<?php echo htmlspecialchars($objconfig['meta_title']); ?>" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meta Keyword</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control col-md-10 col-xs-12" name="txt_meta_keyword" id="txt_meta_keyword" value="<?php echo htmlspecialchars($objconfig['meta_keyword']); ?>" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meta Description</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control col-md-10 col-xs-12" name="txt_meta_desc" id="txt_meta_desc" value="<?php echo htmlspecialchars($objconfig['meta_desc']); ?>" />
                        </div>
                      </div>

                    </div>
                    <div class="col-md-6">
                    
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Mobile Number <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" id="mobile_no" name="txt_mobile" required="required" value="<?php echo htmlspecialchars($objconfig['co_mobile']); ?>" class=" form-control col-md-10 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Website Url <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="url" id="txt_url" value="<?php echo htmlspecialchars($objconfig['co_website']); ?>" name="txt_url" required="required" class="form-control col-md-10 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Get Direction </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12" name="txt_direction" ><?php echo htmlspecialchars($objconfig['co_direction']); ?></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hours">Open Hours <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" id="txt_hours" name="txt_hours" required="required" value="<?php echo htmlspecialchars($objconfig['co_open_hours']); ?>"" class="form-control col-md-10 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">About Us</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control col-md-10 col-xs-12" name="txt_about" ><?php echo htmlspecialchars($objconfig['co_about']); ?></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">General Scheduale</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <textarea class="form-control col-md-10 col-xs-12" name="txt_general" id="txt_general" ><?php echo htmlspecialchars($objconfig['co_general']); ?></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Facebook Link</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control col-md-10 col-xs-12" name="txt_fb" id="txt_fb" value="<?php echo htmlspecialchars($objconfig['fb_link']); ?>" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Google Plus Link</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control col-md-10 col-xs-12" name="txt_gg" id="txt_gg" value="<?php echo htmlspecialchars($objconfig['gg_link']); ?>" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Twitter Link</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control col-md-10 col-xs-12" name="txt_tw" id="txt_tw" value="<?php echo htmlspecialchars($objconfig['tw_link']); ?>" />
                        </div>
                      </div>

                    </div>
                    </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-10">
                          
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                      
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
          <!-- Table End -->

          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event <small>Professional Person</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><button type="button" class="btn btn-success" onclick="add_more();">Add More</button></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <form action="<?php echo base_url(); ?>index.php/config/update_profile/<?php echo $this->uri->segment(3); ?>"  id="person_form" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" >

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="row">
                  <?php
                  $c = 1;
                    foreach ($person as $value) {
                        $_SESSION['my_files'][] = $value->p_image;
                         $image = 'file/person/'.$value->p_image;
                        ?>
                        <div class="col-md-6 mar_d" id="dy_<?php echo $c; ?>">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Person Image <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="file"  name="fl_p[]"  class=" col-md-10 col-xs-10" >
                              <label  class="col-md-2 col-xs-2 bg-red" onclick="remove_from(<?php echo $c; ?>);">Delete</label>
                            </div>
                            <label class="control-label col-md-12 col-sm-12 col-xs-12" for="last-name">Recommended Dimension: Height:140px  Width:140px</label>
                          </div>

                          <?php
                            
                             if (file_exists($image) && $value->p_image != '' ) {

                                echo '<div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="logo"> Person Image 
                                      </label>
                                      
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <img src="'.base_url().$image.'" width="150" height="100" alt="Person Image" />
                                      </div>
                                    </div>';
                            }
                          ?>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Person  Name <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="per_name" name="txt_p_name[]" required="required" value="<?php echo htmlspecialchars($value->p_name); ?>" class=" form-control col-md-10 col-xs-12">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Person  Description </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <textarea class="form-control col-md-7 col-xs-12" required="required" name="txt_p_desc[]" ><?php echo $value->p_desc; ?></textarea>
                            </div>
                          </div>
                      </div>
                        <?php
                      $c++;
                    }

                  ?>

                  <div id="person_form_add" ></div>
                </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-10">
                          
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                      
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>



              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event <small>Primisses Photos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><button type="button" class="btn btn-success" onclick="add_more_p();">Add More</button></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <form action="<?php echo base_url(); ?>index.php/config/update_photos/<?php echo $this->uri->segment(3); ?>"  id="photos_form" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" >

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                  <div class="row">
                  <?php
                  $c = 1;
                    foreach ($photos as $value) {
                        $_SESSION['my_photos'][] = $value->pp_image;
                         $image = 'file/photos/'.$value->pp_image;
                        ?>
                        <div class="col-md-6 mar_d_p" id="p_dy_<?php echo $c; ?>">
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="file"  name="fl_pp[]"  class=" col-md-10 col-xs-10" >
                              <label  class="col-md-2 col-xs-2 bg-red" onclick="remove_from_p(<?php echo $c; ?>);" >Delete</label>
                            </div>
                            <label class="control-label col-md-12 col-sm-12 col-xs-12" for="last-name">Recommended Dimension: Height:250px  Width:150px</label>
                          </div>

                          <?php
                            
                             if (file_exists($image) && $value->pp_image != '' ) {

                                echo '<div class="form-group">
                                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="logo"> Image 
                                      </label>
                                      
                                      <div class="col-md-9 col-sm-9 col-xs-12">
                                        <img src="'.base_url().$image.'" width="150" height="100" alt="Image" />
                                      </div>
                                    </div>';
                            }
                          ?>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Image Title <span class="required">*</span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                              <input type="text" id="pp_name" name="txt_pp_name[]" required="required" value="<?php echo htmlspecialchars($value->pp_name); ?>" class=" form-control col-md-10 col-xs-12">
                            </div>
                          </div>
                      </div>
                        <?php
                      $c++;
                    }

                  ?>

                  <div id="photos_form_add" ></div>
                </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-10">
                          
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                      
                    <?php echo form_close(); ?>
                  </div>
                </div>
              </div>
          
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>

      <script type="text/javascript">
        function add_more()
        {
          var numItems = $('.mar_d').length;
          var numItems = numItems+1;
          var my_ff = '<div  class="col-md-6 mar_d" id="dy_'+numItems+'"><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Person Image <span class="required">*</span></label><div class="col-md-9 col-sm-9 col-xs-12"><input type="file"  name="fl_p[]" required="required" class=" col-md-10 col-xs-10"> <label  class="col-md-2 col-xs-2 bg-red" onclick="remove_from('+numItems+');" >Delete</label></div><label class="control-label col-md-12 col-sm-12 col-xs-12" for="last-name">Recommended Dimension: Height:140px  Width:140px</label></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Person  Name <span class="required">*</span></label><div class="col-md-9 col-sm-9 col-xs-12"><input type="text" id="per_name" name="txt_p_name[]" required="required" value="" class=" form-control col-md-10 col-xs-12"></div></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Person  Description </label><div class="col-md-9 col-sm-9 col-xs-12"><textarea class="form-control col-md-7 col-xs-12" required="required" name="txt_p_desc[]" ></textarea></div></div></div>';


          $("#person_form_add").append(my_ff);
          
        }

        function remove_from(nu)
        {
          
          $('#dy_'+nu).remove();
        }


        function add_more_p()
        {
          var numItems = $('.mar_d_p').length;
          var numItems = numItems+1;
          var my_ff = '<div  class="col-md-6 mar_d_p" id="p_dy_'+numItems+'"><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image <span class="required">*</span></label><div class="col-md-9 col-sm-9 col-xs-12"><input type="file"  name="fl_pp[]" required="required" class=" col-md-10 col-xs-10"> <label  class="col-md-2 col-xs-2 bg-red" onclick="remove_from_p('+numItems+');" >Delete</label></div><label class="control-label col-md-12 col-sm-12 col-xs-12" for="last-name">Recommended Dimension: Height:250px  Width:150px</label></div><div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Image Title <span class="required">*</span></label><div class="col-md-9 col-sm-9 col-xs-12"><input type="text" id="per_name" name="txt_pp_name[]" required="required" value="" class=" form-control col-md-10 col-xs-12"></div></div></div>';


          $("#photos_form_add").append(my_ff);
          
        }

        function remove_from_p(nu)
        {
          
          $('#p_dy_'+nu).remove();
        }
      </script>
  </body>
</html>

