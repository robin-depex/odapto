<?php 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
    $pageno = $_GET['pno']; 
}else{
    $pageno = 0;
}
$user_details = $db->getAll('tbl_users_subscriptions', $pageno);
$details = json_decode($user_details, true);
$user_details = $details['Result'];
$pager = $details['Pagination'];
$current_link = "dashboard.php?page=users_subscription";
?>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">

<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>


<script src="//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
    <div class="row">
    <?php 
        if(isset($_SESSION['msg'])){ ?>
    	<div class="alert alert-info alert-dismissible fade in msg" role="alert" i style="padding:15px 30px 10px 20px;"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    	<?php  echo $_SESSION['msg'];	?>
    	
    	</div>
    	<?php }
            unset($_SESSION['msg']);
    ?>
    </div>
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title">NewsLetter/Subscription email List</h3>
  </div>
  <div class="col col-xs-6 text-right">
    
    <!--<span class="fa fa-plus"></span> Add New Template-->
  </div>
</div>
</div>
<div class="panel-body">
<table id="example" class="table table-sm ">

     <thead>
        <th class="hidden-xs">SN#</th>
        <th>Subscribe Email</th>
        <th>Subscribe on</th>
        
        <th><em class="fa fa-cog"></em> Action</th>
    </thead>
 <tbody>
    <?php  
    if($pager['total'] > 0){
        $sn =$pager['offset']+ 1;
    foreach ($user_details as $value) {
    ?>
     <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $value['subscribe_email']; ?></td>
        <td><?php echo date("F jS, Y", strtotime($value['subscribe_on'])); ?></td>
        
        <td>
            <a href="javascript:void(0)" title="Delete User"><span class="fa fa-trash text-danger" id="<?php echo $value['id']; ?>" onclick="return deleteUser(this.id);"></span></a>

        </td>
    </tr>
    <?php
    $sn++;
    }
    }else{
        ?>
        <td class="text-primary">No More Record Found</td>
        
        <?php
    }
    ?>
    </tbody>
</table>

</div>

</div>
</div>
<script type="text/javascript">
		$(document).ready(function() {
		    $('#example').DataTable({
		         dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
		    });
		    
		   
		    
		} );
	</script>
<script type="text/javascript">

//HIDE SUCCESS ALERT
  $(".msg").fadeTo(5000, 500).slideUp(500, function(){
        $(".msg").slideUp(500);
    });
    
function deleteUser(elem){
    var id = elem;
    $(".Mypopup").animate({top:75}, 800).css({'display':'block'});
    $(".poptext").text('do you want to delete this Email');    
    $("#yes").click(function(event) {
        /* Act on the event */
        $.ajax({
            url: 'temp/template_ajax.php',
            type: 'POST',
            data: {
                action: 'deleteSubsEmail',
                id: id
            },
            beforeSend: function(){
                $(this).text('processing...');
            },
            success:function(res){
                var obj = jQuery.parseJSON(res);
                if(obj.result=="TRUE")
                {
                $("#yes").css({'display':'none'});
                $('#no').text('Cancel');
                $(".poptext").text(obj.message);
                
                  var url = "<?php echo "dashboard.php?page=users_subscription"; ?>";
                window.location.href = url;
                }else if(obj.result=="FALSE"){ 
                    $("#yes").css({'display':'none'});
                    $('#no').text('Cancel');
                    $(".poptext").text(obj.message);
                }
            }
        })
    });
    $("#no").click(function(event) {
        /* Act on the event */
        $(".Mypopup").animate({top:-150}, 800).css({'display':'none'});
    });
    
} 
</script>