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
                    <h2>Configuration <small>List</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Event Name</th>
                          <th>Front Url</th>
                          <th>Action</th>
                        </tr>
                      </thead>

                      <tbody>

                      <?php 
                        foreach ( $recored as $_recored ) {
                      ?>
                        <tr>
                          <td><?php echo $_recored->event_name; ?></td>
                          <td>
                          <a href="<?php echo base_url().'index.php/front/index/'.$_recored->event_id; ?>" target="_blank"><?php echo base_url().'index.php/front/index/'.$_recored->event_id; ?></a>
                          </td>
                          <td>
                            <a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'index.php/config/edit/'.$_recored->co_id; ?>" class="action-edit" title="Edit"><i class="fa fa-edit"></i></a>
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

