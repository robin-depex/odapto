<!DOCTYPE html>
<html lang="en"> 
<style type="text/css">
  .disabled .fc-day-content {
    background-color: #123959;
    color: #FFFFFF;
    cursor: default;
}
</style>
  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
            
          <!-- /top tiles -->

          <!-- Calendar Start -->
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Event Week <small>List</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a><i>&nbsp;</i></a></li>
                      <li class="dropdown">
                        <a href="#" role="button"><i class="fa fa-plus"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id='my_week_calendar'></div>
                  </div>
                </div>
              </div>
          <!-- Calendar End -->
          
        </div>
        <!-- /page content -->

        <!-- calendar modal -->
    <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Set New Event</h4>
          </div>
          <div class="modal-body">

             <?php echo form_open(site_url("a_calendar/add_event"), array("class" => "form-horizontal")) ?>

                 <div class="form-group">
                  <label class="col-sm-3 control-label">Event</label>
                  <div class="col-sm-9">
                    <select name="event_id" class="form-control" id="event_id">
                      <?php
                         $CI =& get_instance();
                         echo $CI->all_event();
                      ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Start Time</label>
                  <div class="col-sm-9">
                    <input type='text' class="form-control " readonly="readonly" name="start_date" id="start_date" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">End Time</label>
                  <div class="col-sm-9">
                    <input type='text' class="form-control" readonly="readonly" id="end_date" name="end_date" />
                  </div>
                </div>

                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Add Event">
                <?php echo form_close() ?>
              </div>

        </div>
      </div>
    </div>
    <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Edit Event</h4>
          </div>
           <?php echo form_open(site_url("a_calendar/edit_event"), array("class" => "form-horizontal")) ?>
          <div class="modal-body">

                <div class="form-group">
                  <label class="col-sm-3 control-label">Event</label>
                  <div class="col-sm-9">
                    <select name="event_id" class="form-control" id="e_event_id">
                      
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Start Time</label>
                  <div class="col-sm-9">
                    <input type='text' class="form-control"  readonly="readonly" name="start_date" id="e_start_date" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">End Time</label>
                  <div class="col-sm-9">
                    <input type='text' class="form-control" readonly="readonly" id="e_end_date" name="end_date" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Delete Event </label>
                  <div class="col-sm-9">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"  name="delete" value="1" class="flat" checked="checked"> 
                      </label>
                    </div>
                  </div>
                </div>

                <input type="hidden" name="avi_id" id="e_avi_id" value="0" />

          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Save">
                <?php echo form_close() ?>
            </div>

        </div>
      </div>
    </div>

    <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
    <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
    <!-- /calendar modal -->


       <?php $this->load->view('admin/include/footer'); ?>

       <script type="text/javascript">
         
         $(document).ready(function() {

              var date = new Date(),
                  d = date.getDate(),
                  m = date.getMonth(), 
                  y = date.getFullYear(),
                  started,
                  categoryClass;
              // page is now ready, initialize the calendar...

              var calendar = $('#my_week_calendar').fullCalendar({
                  header: {
                  left: 'prev,next today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay,listMonth'
                  },
                  selectable: true,
                  selectHelper: true,
                  select: function(start, end, allDay) {

                    var check = moment(start).format('YYYY-MM-DD');
                    var today = moment(new Date()).format('YYYY-MM-DD');
                    if(check < today)
                    {
                        // Previous Day. show message if you want otherwise do nothing.
                        // So it will be unselectable
                        alert('Previous Day !!');

                    }
                    else
                    {
                        // Its a right date
                        // Do something
                        $("#start_date").val(moment(start).format('YYYY/MM/DD hh:mm A'));
                        $("#end_date").val(moment(end).format('YYYY/MM/DD hh:mm A'));
                        $('#fc_create').click();

                    }

                   
                  },

                  eventClick: function(event, jsEvent, view) {
                   
                    $('#e_start_date').val(moment(event.start).format('YYYY/MM/DD HH:mm'));
                    if(event.end) {
                      $('#e_end_date').val(moment(event.end).format('YYYY/MM/DD HH:mm'));
                    } else {
                      $('#e_end_date').val(moment(event.start).format('YYYY/MM/DD HH:mm'));
                    }

                    $.ajax({
                      url:'<?php echo base_url() ?>index.php/a_calendar/all_event/'+event.event_id,
                      success: function(msg) {
                           $('#e_event_id').html(msg);
                       }
                    });

                    $('#e_avi_id').val(event.id);
                   $('#fc_edit').click();
                  },


                  editable: true,
                  defaultView: 'agendaWeek',
                  eventSources: [
                     {
                         events: function(start, end, timezone, callback) {
                             $.ajax({
                             url: '<?php echo base_url() ?>index.php/a_calendar/get_events',
                             dataType: 'json',
                             data: {
                             start: start.unix(),
                             end: end.unix()
                             },
                             success: function(msg) {
                                 var events = msg.events;
                                 callback(events);
                             }
                             });
                         }
                     },
                 ],
                  
                  


              })

          });


          $('#datetimepicker6').datetimepicker({
            format: 'YYYY-MM-DD HH:mm', 
            useCurrent: false,
            stepping: 30,
          });
    
          $('#datetimepicker7').datetimepicker({
              useCurrent: false,
              stepping: 30,
              format:'YYYY-MM-DD HH:mm',
          });
          
          $("#datetimepicker6").on("dp.change", function(e) {
              $('#datetimepicker7').data("DateTimePicker").minDate(e.date.add(30,'minutes'));
          });
          

          $("#datetimepicker7").on("dp.change", function(e) {
              $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
          });




          $('#datetimepicker8').datetimepicker({
            format: 'YYYY-MM-DD HH:mm', 
            enabledHours: [9,10, 11, 12,13, 14, 15, 16,17],
            stepping: 30,
            minDate: new Date(),
          });
    
          $('#datetimepicker9').datetimepicker({
              useCurrent: false,
              enabledHours: [9,10, 11, 12,13, 14, 15, 16,17],
              stepping: 30,
              format:'YYYY-MM-DD HH:mm',
          });
          
          $("#datetimepicker8").on("dp.change", function(e) {
              $('#datetimepicker9').data("DateTimePicker").minDate(e.date.add(30,'minutes'));
          });
          

          $("#datetimepicker9").on("dp.change", function(e) {
              $('#datetimepicker8').data("DateTimePicker").maxDate(e.date);
          });

          
       </script>
  </body>
</html>

