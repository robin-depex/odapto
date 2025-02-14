<!DOCTYPE html>
<html lang="en"> 

  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-calendar"></i> Total Events</span>
              <div class="count"><?php echo $event; ?></div>
              <span class="count_bottom"><i class="green"></i> All Events</span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-calendar"></i> Upcoming Events</span>
              <div class="count green"><?php echo $upcoming_eve; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i> </i> All Upcoming Events</span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-calendar"></i> Outgoing Events</span>
              <div class="count red"><?php echo $outgoing_eve; ?></div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i> </i> All Outgoing Events</span>
            </div>

            
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-calendar"></i> Total Booking</span>
              <div class="count"><?php echo $month; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i> From Month</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-calendar"></i> Total Booking</span>
              <div class="count"><?php echo $year; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i> </i> From Year</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total User</span>
              <div class="count"><?php echo $customer; ?></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i> </i> From All User</span>
            </div>
            
          </div>
          <!-- /top tiles -->

          <div class="row">

          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Today Event <small><?php echo date('d-m-Y'); ?></small></h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <ul class="list-unstyled timeline">
                    <li>
                      <div class="block">
                        <div class="tags">
                          <a href="" class="tag">
                            <span><?php echo date('d-m-Y'); ?></span>
                          </a>
                        </div>
                        <div class="block_content">
                          <h2 class="title">
                              <a>Today All Event Information </a>
                          </h2>
                          <br />
                          <p class="excerpt">
                          <?php
                            foreach ($today_eve as $value) {
                              ?>
                              <div class="row" >
                                <div class="col-xs-6 col-md-6 col-sm-12">
                                  <address>
                                    <strong>Name :</strong>
                                    <?php echo $value->event_name; ?>
                                    <br />
                                    <strong>Address :</strong>
                                    <?php echo $value->event_add; ?>
                                    <br />
                                    <strong>Total Person :</strong>
                                    <?php echo $value->event_person; ?> 
                                  </address>
                                </div>
                                <div class="col-xs-6 col-md-6 col-sm-12">
                                  <img src="<?php echo base_url(); ?>file/event/<?php echo $value->event_image; ?>" height="100" width="200" />
                                </div>

                              </div>
                              
                              <?php
                            }
                          ?>
                          </p>
                        </div>
                      </div>
                    </li>
                    
                  </ul>

                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">

                <div class="row x_title">
                    <h3>Event <small>Graph</small></h3>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div id="chart_plot_01m" class="demo-placeholder"></div>
                </div>
                
                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />
          <div class="row">

                <!-- Start to do list -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Event Booking <small>Last Seven</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="">
                        <ul class="to_do">
                        <?php
                          foreach ($book as $value) {
                            ?>
                            <li onclick="order_info(<?php echo $value->booking_id; ?>);">
                              <p>
                                <?php echo $value->customer_first_name; ?>

                                <span class="pull-right">
                                  <?php echo  date('d-m-Y',strtotime($value->booking_date)); ?>
                                  &nbsp;&nbsp;
                                </span>

                              </p>
                            </li>
                            <?php
                          }
                        ?>
                         
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End to do list -->
                
                <!-- start of weather widget -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2>Event Booking <small>Upcoming 6 Days</small></h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                      <div class="">
                        <ul class="to_do">
                        <?php
                          foreach ($book_up as $value) {
                            ?>
                            <li onclick="order_info(<?php echo $value->booking_id; ?>);">
                              <p>
                                <?php echo $value->customer_first_name; ?>

                                <span class="pull-right">
                                  <?php echo  date('d-m-Y',strtotime($value->booking_date)); ?>
                                  &nbsp;&nbsp;
                                </span>

                              </p>
                            </li>
                            <?php
                          }
                        ?>
                         
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end of weather widget -->
              </div>

          <div class="row">
          <?php 
            $my_c_data = '';
            foreach ($chart as $value) {
              $my_c_data .= $value.',';
            }
            
           // echo $my_c_data;
          ?>
          </div>
          <br />

          <div class="row">
          </div>


          <div class="row">
            
          </div>
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>

    <script type="text/javascript">
      
      var arr_data1 = [
        [gd(2017, 1, 1), 17],
        [gd(2017, 1, 2), 74],
        [gd(2017, 1, 3), 6],
        [gd(2017, 1, 4), 39],
        [gd(2017, 1, 5), 20],
        [gd(2017, 1, 6), 85],
        [gd(2017, 1, 7), 7]
      ];

      var arr_data2 = [
        <?php echo $my_c_data ?>
      ];

      var chart_plot_01_settings = {
          series: {
            lines: {
              show: false,
              fill: true
            },
            splines: {
              show: true,
              tension: 0.4,
              lineWidth: 1,
              fill: 0.4
            },
            points: {
              radius: 0,
              show: true
            },
            shadowSize: 2
          },
          grid: {
            verticalLines: true,
            hoverable: true,
            clickable: true,
            tickColor: "#d5d5d5",
            borderWidth: 1,
            color: '#fff'
          },
          colors: ["rgba(3, 88, 106, 0.38)"],
          xaxis: {
            tickColor: "rgba(51, 51, 51, 0.06)",
            mode: "time",
            tickSize: [1, "day"],
            //tickLength: 10,
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10
          },
          yaxis: {
            ticks: 4,
            tickColor: "rgba(51, 51, 51, 0.06)",
          },
          tooltip: true
        }


      if ($("#chart_plot_01m").length){
        console.log('Plot1');
        
        $.plot( $("#chart_plot_01m"), [ arr_data2 ],  chart_plot_01_settings );
      }


  function order_info(_orderno)
  { 
    var w = 1050;
    var h = 500;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open("<?php echo base_url() ?>index.php/report/order_info/"+_orderno,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }
    </script>

  </body>
</html>
