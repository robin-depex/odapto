<?php 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
	$pageno = $_GET['pno'];	
}else{
	$pageno = 0;
}
$details = $db->getAll('tbl_tmp_board_list_card', $pageno);
$details = json_decode($details, true);
$datas = $details['Result'];
$pager = $details['Pagination'];
$add_temp = "dashboard.php?page=add_boardcards";
$current_link = "dashboard.php?page=boardcards";
?>
<div class="content">

<div class="container-fluid">
<div class="row">

<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title">Template Board List Card</h3>
  </div>
  <div class="col col-xs-6 text-right">
    <a href="<?php echo $add_temp; ?>" class="btn btn-sm btn-primary btn-create">
    <span class="fa fa-plus"></span> Add New Template Board List Card</a>
  </div>
</div>
</div>

<!--  modalpopup ends  -->
<div class="card-content table-responsive">
<table class="table">
    <thead class="text-primary">
    	<th>SN#</th>
    	<th>Card Name</th>
    	<th>Board List Name</th>
    	<th>Card Description</th>
    	<th>Status</th>
		<th>Action</th>
    </thead>
    <tbody>
    <?php  
    if($pager['total'] > 0){
		$sn = 1;
    foreach ($datas as $value) {
    ?>
     <tr>
    	<td><?php echo $sn; ?></td>
    	<td><?php echo $value['card_name']; ?></td>
    	<td><?php $data = $db->get_single('tbl_tmp_board_list', $value['list_id']); echo $data['list_title']; ?></td>
    	<td><?php echo $value['card_description']; ?></td>
    	<td>
		<?php if($value['status'] == '1'){ ?>
    	<button class="btn btn-success btn-sm">
    		Active
    	</button>
    	<?php	
    	}else if(@$value['status'] == '-1'){
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
			<a href="<?php echo $add_temp."&id=".$value['id'] ?>" class="btn btn-xs btn-success" title="Edit User"><span class="fa fa-pencil"></span></a>
			<a href="javascript:void(0)" class="btn btn-xs btn-danger" title="Delete User"><span class="fa fa-trash" id="<?php echo $value['id']; ?>" onclick="return deleteUser(this.id);"></span></a>
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
    $(".poptext").text('do you want to delete this Template');    
    $("#yes").click(function(event) {
        /* Act on the event */
        $.ajax({
            url: 'temp/template_ajax.php',
            type: 'POST',
            data: {
                action: 'deleteboard_cards',
                id: id
            },
            success:function(res){
                var obj = jQuery.parseJSON(res);
                if(obj.result=="TRUE")
                {
                $("#yes").css({'display':'none'});
                $('#no').text('Cancel');
                $(".poptext").text(obj.message);
                  var url = "<?php echo "https://odapto.com/admin/dashboard.php?page=boardcards"; ?>";
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