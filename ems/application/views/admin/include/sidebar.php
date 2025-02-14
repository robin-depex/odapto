<?php $page_name =  $this->uri->segment(1);  ?>
<!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li <?php if ($page_name == '' || $page_name == 'welcome') { echo 'class="active"'; } ?> >
                    <a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Dashboard </a>
                  </li>

                  <li><a><i class="fa fa-building"></i> Event Management <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'index.php/a_calendar'; ?>">Event Scheduler</a></li>
                      <li><a href="<?php echo base_url().'index.php/calendar'; ?>">Event Calander</a></li>
                      <li><a href="<?php echo base_url().'index.php/customer/create'; ?>">Add Client</a></li>
                      <li><a href="<?php echo base_url().'index.php/event/create'; ?>">Add Event </a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-list"></i> Event Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'index.php/report'; ?>">Event Schedule Report</a></li>
                      <li><a href="<?php echo base_url().'index.php/report/booking_list'; ?>">Event Booking Report</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-globe"></i> Event Webpage <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'index.php/config'; ?>">Event Web Page</a></li>
                    </ul>
                  </li>

                  <li><a href="<?php echo base_url().'index.php/webpage'; ?>"><i class="fa fa-laptop"></i> Event Web <span class="label label-success pull-right">Link</span></a></li>

                  <li><a href="<?php echo base_url().'index.php/booking'; ?>"><i class="fa fa-suitcase"></i> Booking List <span class="label label-success pull-right">Event Wise</span></a></li>
                 
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->