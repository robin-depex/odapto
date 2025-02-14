<?php 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
	$pageno = $_GET['pno'];	
}else{
	$pageno = 0;
}

$details = $db->getAll('tbl_tmp_board',$pageno);
$de_details = json_decode($details, true);
$data = $de_details['Result'];
$pager = $de_details['Pagination'];
$add = "dashboard.php?page=temp_add_board";
$current_link = "dashboard.php?page=boards";
?>
<div class="content">

<div class="container-fluid">
<div class="row">

<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title">Template Board</h3>
  </div>
  <div class="col col-xs-6 text-right">
    <a href="<?php echo $add; ?>" class="btn btn-sm btn-primary btn-create">
    <span class="fa fa-plus"></span> Add New Template Board</a>
  </div>
</div>
</div>
          
<!--  modalpopup ends  -->
<div class="card-content table-responsive">
<table class="table">
    <thead class="text-primary">
    	<th>ID#</th>
    	<th>Name</th>
        <th>Template</th>
    	<th>Image</th>
    	<th>Status</th>
		<th>Action</th>
    </thead>
    <tbody>
    <?php  
    if($pager['total'] > 0){
    foreach ($data as $value) {
    ?>
     <tr>
    	<td><?php echo $value['id']; ?></td>
    	<td><?php echo $value['board_name']; ?></td>
    	<td><?php $data = $db->get_single('tbl_templates', $value['cat_id']); echo $data['name']; ?></td>
        <td class="text-primary"><a href="https://odapto.com/admin/temp/images/<?php echo $value['board_bgimage']; ?>" target="_blank"><img class="img-thumbnail" style="width:100px" 
        src="temp/images/<?php echo $value['board_bgimage']; ?>" /></a></td>
    	<td><?php if($value['status'] == '1'){
    	?>
    	<button class="btn btn-success btn-sm">
    		Active
    	</button>
    	<?php	
    	}else if($value['status'] == '-1'){
        ?>
        <button class="btn btn-warning btn-sm">
            Disable
        </button>
        <?php
        }else{
    	?>
    	<button class="btn btn-danger btn-sm">
    		In-active
    	</button>
    	<?php
    	} ?></td>
		<td>
			<a href="<?php echo $add."&id=".$value['id'] ?>" class="btn btn-xs btn-success" title="Edit User"><span class="fa fa-pencil"></span></a>
            <!--<a href="<?php echo $add."&id=".$value['id'] ?>" class="btn btn-xs btn-warning" title="change password"><span class="fa fa-lock"></span></a>-->
			<a href="javascript:void(0)" class="btn btn-xs btn-danger" title="Delete User"><span class="fa fa-trash" id="<?php echo $value['id']; ?>" onclick="return deleteUser(this.id);"></span></a>
		</td>
    </tr>
    <?php
    }
	}else{
		?>
		<td class="text-primary">No More Record Found</td>
		
		<?php
	}
    ?>
	</tbody>
</table>
<hr>
<div class="col-sm-6 col-sm-offset-3">
	<ul style="list-style: none;float: right;">
	<?php  
	$pages = $pager['pages'];

	for ($i=0; $i < $pages; $i++) { 
	$page = $i+1;
    if($page==1){
    ?>
    <li style="float: left;">
        <a href="<?php echo $current_link ?>" class="btn btn-xs btn-success"><?php echo $page; ?></a> 
    </li>
    <?php    
}else{
    ?>
    <li style="float: left;">
        <a href="<?php echo $current_link."&pno=".$i ?>" class="btn btn-xs btn-success"><?php echo $page; ?></a> 
    </li>
    <?php
}	
	
	}
	?>
	</ul>
</div>

</div>
</div>
</div>

</div>
</div>
</div>
<script type="text/javascript">
function deleteUser(elem){
    var id = elem;
    $(".Mypopup").animate({top:75}, 800).css({'display':'block'});
    $(".poptext").text('do you want to delete user id: '+id);    
    $("#yes").click(function(event) {
        /* Act on the event */
        $.ajax({
            url: 'temp/template_ajax.php',
            type: 'POST',
            data: {
                action: 'delete_boards',
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
                  var url = "<?php echo "https://odapto.com/admin/dashboard.php?page=boards"; ?>";
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