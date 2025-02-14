<?php 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
	$pageno = $_GET['pno'];	
}else{
	$pageno = 0;
}
$getAll = $db->getAll('tbl_tmp_category', $pageno);
//print_r($getAll);
$details_decode = json_decode($getAll, true);
$datas = $details_decode['Result'];
//echo "<pre>";
//print_r($details_decode);
$pager = $details_decode['Pagination'];
//print_r($pager['total']);
$add = "dashboard.php?page=temp_add_cat";
$current_link = "dashboard.php?page=temp_list_cat";
?>
<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title">Template Category</h3>
  </div>
  <div class="col col-xs-6 text-right">
	<a href="<?php echo $add; ?>" class="btn btn-sm btn-primary btn-create">
	<span class="fa fa-plus"></span> Add New Category</a>
  </div>
</div>
</div>
<div class="panel-body">
<table class="table table-bordered table-list">
  <thead>
    <tr>
        <th class="hidden-xs">ID</th>
        <th>Category Name</th>
        <th>Status</th>
        <th><em class="fa fa-cog"></em> Action</th>
    </tr> 
  </thead>
  <tbody>
   <?php 
    if($pager['total'] > 0){
		$sn = 1;
    foreach ($datas as $value) {
    ?>
     <tr>
    	<td><?php echo $sn; ?></td>
    	<td><?php echo $value['cat_name']; ?></td>
    	<td><?php if(@$value['status'] == '1'){
    	?>
    	<button class="btn btn-success btn-sm">Active</button>
    	<?php }else if(@$value['status'] == '-1'){ ?>
        <button class="btn btn-warning btn-sm">Disable</button>
        <?php }else{ ?>
    	<button class="btn btn-danger btn-sm">In-active</button>
		<?php } ?></td>
		<td>
			<a href="<?php echo $add."&id=".$value['id'] ?>" class="btn btn-xs btn-success" title="Edit User"><span class="fa fa-pencil"></span></a>
			<a href="javascript:void(0)" class="btn btn-xs btn-danger" title="Delete User"><span class="fa fa-trash" id="<?php echo $value['id']; ?>" onclick="return delete_temp_cat(this.id);"></span></a>
		</td>
    </tr>
    <?php
    $sn++;
	}
	}else{
		?>
		<tr>
		<td class="text-primary">No More Record Found</td>
		</tr>
		<?php
	}
    ?>
  </tbody>
</table>

</div>
<div class="panel-footer">
<div class="row">
  <div class="col col-xs-8">
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
<script type="text/javascript">
function delete_temp_cat(elem){
    var id = elem;
    $(".Mypopup").animate({top:75}, 800).css({'display':'block'});
    $(".poptext").text('do you want to delete this Template');    
    $("#yes").click(function(event) {
        /* Act on the event */
        $.ajax({
            url: 'temp/template_ajax.php',
            type: 'POST',
            data: {
                action: 'deleteTempCat',
                id: id
            },

            success:function(res){
                var obj = jQuery.parseJSON(res);
                if(obj.result=="TRUE")
                {
                $("#yes").css({'display':'none'});
                $('#no').text('Cancel');
                $(".poptext").text(obj.message);
                  var url = "<?php echo "https://odapto.com/admin/dashboard.php?page=temp_list_cat"; ?>";
                window.location.href = url;
                }else if(obj.result=="FALSE"){ 
                    $("#yes").css({'display':'none'});
                    $('#no').text('Cancel');
                    $(".poptext").text(obj.message);
                }
            }
        })
    });
    $("#no").click(function(event){
        /* Act on the event */
        $(".Mypopup").animate({top:-150}, 800).css({'display':'none'});
    });
    
} 
</script>