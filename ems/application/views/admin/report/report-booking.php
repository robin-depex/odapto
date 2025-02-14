<?php
  
  $CI =& get_instance();

  $dateform = '';
  $dateto = '';

  $sendserver = $this->uri->segment(4);
?>

<!DOCTYPE html>
<html lang="en"> 

  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class='x_content'>
                <select class="form-control" name="event" id="event" onchange="ch_res(this.value)">
                  <option value="">~~ Select Event ~~</option>
                  <?php echo $event = $CI->get_event_name($this->uri->segment(3)); ?> 
                </select>
              </div>
            </div>
          </div>

           <?php 
              $attributes = array('id' => 'frm','name'=>'frm');
              echo form_open('',$attributes) ?>
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                      <div class="col-xs-4">
                         <div class='x_content'>
                            <div class="form-group">
                              <label>From:</label>
                               <div class="input-group">
                                <input type="text" name="txtfrom_date" id="txtfrom_date" readonly="readonly" value="<?php echo $this->uri->segment(5); ?>" class="form-control" />
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              </div>
                              <br />
                              <input type="button" value="Today Report" title="Today Report" class="btn btn-<?php if($sendserver == 'today') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/booking_list/'.$this->uri->segment(3).'/today' ?>';" />
                              <input type="button" style="float:right" value="Weekly Report" title="Weekly Report" class="btn btn-<?php if($sendserver == 'weekly') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/booking_list/'.$this->uri->segment(3).'/weekly' ?>';" />
                            </div>
                         </div>
                      </div>
                      <div class="col-xs-4">
                         <div class='x_content'>
                            <div class="form-group">
                              <label>To:</label>
                               <div class="input-group">
                                <input type="text" name="txtto_date" id="txtto_date" readonly="readonly" value="<?php echo $this->uri->segment(6); ?>" class="form-control" />
                                <div class="input-group-addon" ><i class="fa fa-calendar"></i></div>
                              </div>
                              <br />
                              <input type="button" value="Monthly Report" title="Monthly Report" class="btn btn-<?php if($sendserver == 'monthly') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/booking_list/'.$this->uri->segment(3).'/monthly' ?>';" />
                              <input type="button" style="float:right" value="Yearly Report" title="Yearly Report" class="btn btn-<?php if($sendserver == 'yearly') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/booking_list/'.$this->uri->segment(3).'/yearly' ?>';" />
                            </div>
                         </div>
                      </div>
                      <div class="col-xs-4">
                         <div class='x_content'>
                            <div class="form-group">
                              <br />
                              <input type="button" value="Search" title="Search" class="btn btn-primary" onclick="javascript:search_record();" />
                              <input type="button" value="Reset" title="Reset" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url() ?>index.php/report/booking_list'" />
                            </div>
                         </div>
                      </div>
                </div>
              </div>
              <br /><br /> 
              <!-- Table Start -->
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event <small>Report</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                        <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/report/pdf_list/<?php echo $this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6); ?>" target="_blank" ><i class="fa fa-plus"></i> Create PDF</a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="booking_report" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Event Name</th>
                          <th>Booking Date</th>
                          <th>Total Book Person</th>
                          <th>Booking List</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php 
                          
                          foreach ($recored as $_date) {
                            ?>
                            <tr>
                              <td><?php echo $_date->event_name; ?></td>
                              <td><?php echo date('d-m-Y',strtotime($_date->booking_date)); ?></td>
                              <td>
                                <?php 
                                   echo $total_order = $CI->get_total_order($_date->event_id,$_date->booking_date);
                                ?>
                              </td>
                              <td>
                                <?php
                                  $all_order = $CI->get_all_order($_date->event_id,$_date->booking_date);
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
   
  $('#txtfrom_date').datepicker({
    format: 'dd-mm-yyyy'
    });
  $('#txtto_date').datepicker({
    format: 'dd-mm-yyyy'
    });

  function ch_res(id)
  {
    window.location.href = "<?php echo base_url(); ?>/index.php/report/booking_list/"+id;
  }

  function order_info(_orderno)
  { 
    var w = 1050;
    var h = 500;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open("<?php echo base_url() ?>index.php/report/order_info/"+_orderno,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }

  function search_record()
  {
    var dateform = document.getElementById('txtfrom_date').value;
    var dateto = document.getElementById('txtto_date').value;
    if(!String(dateform)==false && !String(dateto)==false){
      window.location.href = "<?php echo base_url() ?>index.php/report/booking_list/<?php echo $this->uri->segment(3); ?>/search/"+dateform+"/"+dateto;
    }
    else
    {
      window.location.href = window.location.href;  
    }
    
  }


 </script>