<!DOCTYPE html>
<html lang="en"> 

  <?php $this->load->view('admin/include/common'); ?>  

  <?php $this->load->view('admin/include/header'); ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
            
          <!-- /top tiles -->

          <!-- Table Start -->
          <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Client<small>List</small></h2>
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
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Customer Name</th>
                        </tr>
                      </thead>

                      <tbody>

                      <?php 
                        foreach ( $recored as $_recored ) {
                      ?>
                        <tr  onclick="get_all_data('<?php echo $_recored->booking_id; ?>');">
                          <td><?php echo $_recored->customer_first_name; ?></td>
                        </tr>
                      <?php 
                       }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12"  id="my_d_id" >
                  
            </div>
          <!-- Table End -->
          
        </div>
        <!-- /page content -->

       <?php $this->load->view('admin/include/footer'); ?>

      <script type="text/javascript">
          
          $(document).ready(function(){
          });

            function hide_data()
            {
              $("#my_d_id").hide();
            }

             function get_all_data(id)
             {

                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>index.php/ajax/getclientdata/index",
                    data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
                }).done(function( msg ) { 
                    $('#my_d_id').html(msg);
                    $("#my_d_id").show();
                })
             }


             function edit_mode(id)
             {
                 $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>index.php/ajax/getclientedit/index",
                    data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
                }).done(function( msg ) { 
                    $('#my_d_id').html(msg);
                    $("#my_d_id").show();
                })
             }

             function edit_client(book_id,user_id)
             {
              //alert(book_id+'|'+user_id);
                var name = $("#e_edit_name").val();
                var phone = $('#e_edit_phone').val();
                var email = $("#e_edit_email").val();

                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>index.php/ajax/edit_client/index",
                    data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'user_id':user_id,'name':name,'phone':phone,'email':email}
                }).done(function( msg ) { 
                    get_all_data(book_id);
                })
             }

             function add_note(book_id)
             {
                var note = $("#e_edit_note").val();
               
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>index.php/ajax/edit_note/index",
                    data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'book_id':book_id,'note':note}
                }).done(function( msg ) { 
                    get_all_data(book_id);
                })
             }

            function user_ban(book_id,id,action_mode)
            {
              if(action_mode == 'yes')
              {
                var dis = 'Ban';
              }
              else
              {
                var dis = 'Unban';
              }

              if (confirm("Are you sure to "+dis+" This CLient !!!")) 
              {
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>index.php/ajax/getclientdata/ban_client",
                    data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id,'action_mode':action_mode}
                }).done(function( msg ) { 
                    get_all_data(book_id);
                })
              }
            }

            function delete_booking(id)
            {
              if (confirm("Are you sure to Delete !!!")) 
              {
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url() ?>index.php/ajax/getclientdata/delete_data",
                    data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
                }).done(function( msg ) { 
                     location.reload(true);
                })
              }

            }

function PrintElem(id)
{
    

    $.ajax({
        type: "GET",
        url: "<?php echo base_url() ?>index.php/ajax/get_print_data/index",
        data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
    }).done(function( msg ) { 
         
      var mywindow = window.open('', 'PRINT', 'height=800,width=800');
      mywindow.document.write(msg);
     
      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10*/

      mywindow.print();
      mywindow.close();

      return true;

    })

    
}
      </script> 
  </body>
</html>

