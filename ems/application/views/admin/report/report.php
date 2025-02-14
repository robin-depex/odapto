<?php
  $CI =& get_instance();
?>

<!DOCTYPE html>
<html lang="en"> 

  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
            
          <!-- /top tiles -->

           <?php 
              $attributes = array('id' => 'frm','name'=>'frm');
              echo form_open('',$attributes) ?>
                
              <!-- Table Start -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event <small>Report</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                        <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/report/pdf" target="_blank" ><i class="fa fa-plus"></i> Create PDF</a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="booking_report" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Event Name</th>
                          <th>Total Booking Person</th>
                          <th>Booking List</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                          
                          foreach ($recored as $_date) {
                            ?>
                            <tr>
                              <td><?php echo $_date->event_name; ?></td>
                              <td>
                                <?php 
                                   echo $total_order = $CI->get_total_order($_date->event_id);
                                ?>
                              </td>
                              <td>
                                <?php
                                  $all_order = $CI->get_all_order($_date->event_id);
                                  foreach ($all_order as $_order) {
                                    ?>
                                    <span class="badge bg-green" onclick="javascript:order_info('<?php echo $_order->booking_id ?>');"><?php echo $_order->customer_first_name; ?> : <?php echo $_order->person; ?> </span>
                                    <?php
                                  }
                                ?>
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
        <?php echo form_close() ?>  
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>
  </body>
</html>


 <script type="text/javascript">
   
  function order_info(_orderno)
  { 
    var w = 1050;
    var h = 500;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open("<?php echo base_url() ?>index.php/report/order_info/"+_orderno,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }

</script>