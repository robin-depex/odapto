<?php $CI =& get_instance(); ?>
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
                <h2>Select <small>Event</small></h2>
              </div>
              <div class="x_content">
                <div>
                  <select class="form-control" id="event" name="event" onchange="get_data(this.value)">
                    <option value="">~~Select Event~~</option>
                    <?php echo $CI->get_event_name(); ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Table Start -->
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Booking <small>List</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a><i>&nbsp;</i></a></li>
                      <li class="dropdown">
                        <a href="<?php echo base_url().'index.php/booking/create'; ?>" role="button"><i class="fa fa-plus"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="product" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Customer Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Person</th>
                          <th>Event Name</th>
                          <th>QR Code</th>
                        </tr>
                      </thead>

                      <tbody>
                      </tbody>

                    </table>
                  </div>
                </div>
              </div>
          <!-- Table End -->
          
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>

    <script type="text/javascript">
      function get_data(id) 
      {
        if ( $.fn.DataTable.isDataTable('#product') ) 
        {
            $('#product').DataTable().destroy();
        }
        $('#product tbody').empty();

        $('#product').dataTable( {
            "bProcessing": false,
            "bServerSide": true,
            "bSort": false,
            "searching": false,
            "paging": false,
            "sAjaxSource": "<?php echo base_url() ?>index.php/report/get_booking/"+id,
            
        });
      }


    </script>   
  </body>
</html>

