<?php 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
    $pageno = $_GET['pno']; 
}else{
    $pageno = 0;
}
$user_details = $db->getAll('tbl_templates', $pageno);
$details = json_decode($user_details, true);
$user_details = $details['Result'];
$pager = $details['Pagination'];
$add_temp = "dashboard.php?page=add_temp";
$current_link = "dashboard.php?page=temp";
?>
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
    <h3 class="panel-title">Template List</h3>
  </div>
  <div class="col col-xs-6 text-right">
    <a href="<?php echo $add_temp; ?>" class="btn btn-sm btn-primary btn-create">
    <span class="fa fa-plus"></span> Add New Template</a>
  </div>
</div>
</div>
<div class="panel-body">
<table class="table table-bordered table-list">

     <thead>
        <th class="hidden-xs">SN#</th>
        <th>Name</th>
        <th>Category</th>
        <th>Plan</th>
        <th>Status</th>
        <th>Template Image</th>
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
        <td><?php echo $value['name']; ?></td>
        <td><?php $data = $db->get_single('tbl_tmp_category', $value['cat_id']); echo $data['cat_name']; ?></td>

         <td><?php if($value['plan_tag']==1){ echo 'Free';}else if($value['plan_tag']==2){ echo 'Business';}else if($value['plan_tag']==3){ echo 'Enterprise';} ?></td>
        <td><?php if($value['status'] == '1'){
        ?>
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
        <td class="text-primary"><img class="img-thumbnail" style="width:100px; height:65px" 
        src="temp/images/<?php echo $value['image']; ?>" /></td>
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

</div>
<div class="col-sm-6 col-sm-offset-3">
    <ul style="list-style: none;float: right;">
    <?php  
    $pages = $pager['pages'];
    $j=0;
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
        <a href="<?php echo $current_link."&pno=".$j ?>" class="btn btn-xs btn-success"><?php echo $page; ?></a> 
    </li>
    <?php
}   
$j++;
    
    }
    ?>
    </ul>
</div>
</div>
</div>
<script type="text/javascript">

//HIDE SUCCESS ALERT
  $(".msg").fadeTo(5000, 500).slideUp(500, function(){
        $(".msg").slideUp(500);
    });
    
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
                action: 'deleteTemp',
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
                
                  var url = "<?php echo "dashboard.php?page=temp"; ?>";
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