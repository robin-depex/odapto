<!DOCTYPE html>
<html lang="en"> 

  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
            
          <!-- /top tiles -->

          <!-- Table Start -->
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event <small>List</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a><i>&nbsp;</i></a></li>
                      <li class="dropdown">
                        <a href="<?php echo base_url().'index.php/event/create'; ?>" role="button"><i class="fa fa-plus"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Event Name</th>
                          <th>Address</th>
                          <th>Date</th>
                          <th>Image</th>
                          <th>Active</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>

                      <?php 
                        foreach ( $recored as $_recored ) {
                      ?>
                        <tr>
                          <td><?php echo $_recored->event_name; ?></td>
                          <td><?php echo $_recored->event_add; ?></td>
                          <td><?php echo date('d-m-Y',strtotime($_recored->event_date)); ?></td>
                          <td width="80">
                            <img src="<?php echo base_url(); ?>file/event/<?php echo $_recored->event_image; ?>" height="80" width="80">
                          </td>
                          <td align="middle" >
                            <input type="checkbox" <?php $is_act = 'yes'; if($_recored->event_is_active == 'yes') { echo 'checked'; $is_act = 'no'; }?> onchange="javascript:window.location.href='<?php echo base_url().'index.php/event/active_inactive/'.$_recored->event_id.'/'.$is_act; ?>'" class="js-switch"  /> 
                          </td>
                          <td>
                            <a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'index.php/event/edit/'.$_recored->event_id; ?>" class="action-edit" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'index.php/event/delete/'.$_recored->event_id; ?>" class="action-edit" title="Delete"><i class="fa fa-close"></i></a>
                          </td>
                        </tr>
                      <?php 
                       }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          <!-- Table End -->
          
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>
  </body>
</html>

