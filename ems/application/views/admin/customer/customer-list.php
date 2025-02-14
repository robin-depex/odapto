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
                    <h2>Customer <small>List</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a><i>&nbsp;</i></a></li>
                      <li class="dropdown">
                        <a href="<?php echo base_url().'index.php/customer/create'; ?>" role="button"><i class="fa fa-plus"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Customer Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>City</th>
                          <th>Active</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>

                      <?php 
                        foreach ( $recored as $_recored ) {
                      ?>
                        <tr>
                          <td><?php echo $_recored->customer_first_name; ?></td>
                          <td><?php echo $_recored->customer_email; ?></td>
                          <td><?php echo $_recored->customer_phone; ?></td>
                          <td><?php echo $_recored->customer_city; ?></td>
                          <td align="middle" >
                            <input type="checkbox" <?php $is_act = 'yes'; if($_recored->customer_is_active == 'yes') { echo 'checked'; $is_act = 'no'; }?> onchange="javascript:window.location.href='<?php echo base_url().'index.php/customer/active_inactive/'.$_recored->customer_id.'/'.$is_act; ?>'" class="js-switch"  /> 
                          </td>
                          <td>
                            <a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'index.php/customer/edit/'.$_recored->customer_id; ?>" class="action-edit" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'index.php/customer/delete/'.$_recored->customer_id; ?>" class="action-edit" title="Delete"><i class="fa fa-close"></i></a>
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

