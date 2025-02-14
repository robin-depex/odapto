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

          <!-- Calendar Start -->
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Calendar <small>List</small></h2>
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
                    <div id='my_own_calendar'></div>
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
            <h4 class="modal-title" id="myModalLabel">New Event Booking</h4>
          </div>
             <?php echo form_open(site_url("calendar/add_event"), array("class" => "form-horizontal")) ?>
          <div class="modal-body">


                <div class="form-group">
                  <label class="col-md-4 label-heading">User</label>
                  <div class="col-sm-8 ui-front">
                    <select class="form-control" id="User" name="user_name">
                      <?php echo $services = $CI->get_customer($this->session->userdata('userid')); ?> 
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 label-heading">Event</label>
                  <div class="col-sm-8 ui-front">
                    <select class="form-control" id="Event" onchange="get_avail(this.value)" name="event_id">
                      <option value="">~~ Select Event Name ~~</option>
                      <?php echo $services = $CI->get_event(); ?> 
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 label-heading">Total Person</label>
                  <div class="col-sm-8 ui-front">
                    <select class="form-control" id="Person" name="person">
                      
                    </select>
                  </div>
                </div>

                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Add Event">
              </div>
              <?php echo form_close() ?>

        </div>
      </div>
    </div>
    <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel2">Edit Event Booking</h4>
          </div>
           <?php echo form_open(site_url("calendar/edit_event"), array("class" => "form-horizontal")) ?>
          <div class="modal-body">


                <div class="form-group">
                  <label class="col-md-4 label-heading">User</label>
                  <div class="col-sm-8 ui-front">
                    <select class="form-control" id="e_user_name" name="user_name">
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 label-heading">Event</label>
                  <div class="col-sm-8 ui-front">
                    <select class="form-control" id="e_event_id" onchange="get_avail(this.value)" name="event_id">
                      <option value="">~~ Select Event Name ~~</option>
                       
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 label-heading">Total Person</label>
                  <div class="col-sm-8 ui-front">
                    <select class="form-control" id="e_Person" name="person">
                      
                    </select>
                  </div>
                </div>

              
              
           <input type="hidden" name="eventid" id="e_booking_id" value="0" />
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Save">
            </div>
                <?php echo form_close() ?>

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

              var calendar = $('#my_own_calendar').fullCalendar({
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

                    $.ajax({
                     url: '<?php echo base_url() ?>index.php/calendar/get_customer/'+event.user_id,
                     success: function(msg) {
                         $('#e_user_name').append(msg);
                     }
                     });

                    $.ajax({
                     url: '<?php echo base_url() ?>index.php/calendar/get_event/'+event.event_id,
                     success: function(msg) {
                         $('#e_event_id').append(msg);
                     }
                     });

                    $.ajax({
                     url: '<?php echo base_url() ?>index.php/calendar/get_person/'+event.event_id,
                     success: function(msg) {
                         $('#e_Person').append(msg);
                     }
                     });
                    
                   
                    $('#e_booking_id').val(event.id);
                   $('#fc_edit').click();
                  },

                  /*eventClick: function(calEvent, jsEvent, view) {
                  $('#fc_edit').click();
                  $('#title2').val(calEvent.title);

                  categoryClass = $("#event_type").val();

                  $(".antosubmit2").on("click", function() {
                    calEvent.title = $("#title2").val();

                    calendar.fullCalendar('updateEvent', calEvent);
                    $('.antoclose2').click();
                  });

                  calendar.fullCalendar('unselect');
                  },*/
                  editable: true,
                  
                   eventSources: [
                     {
                         events: function(start, end, timezone, callback) {
                             $.ajax({
                             url: '<?php echo base_url() ?>index.php/calendar/get_events',
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


        function get_avail(id)
        {
            $.ajax({
             url: '<?php echo base_url() ?>index.php/calendar/get_person/'+id,
             success: function(msg) {
                 $('#Person').html(msg);
             }
             });
        }


          $('#datetimepicker6').datetimepicker({
            format: 'YYYY-MM-DD HH:mm', 
            enabledHours: [9,10, 11, 12,13, 14, 15, 16,17],
            stepping: 30,
            minDate: new Date(),
          });
    
          $('#datetimepicker7').datetimepicker({
              useCurrent: false,
              enabledHours: [9,10, 11, 12,13, 14, 15, 16,17],
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

