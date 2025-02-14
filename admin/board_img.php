<?php 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
    $pageno = $_GET['pno']; 
}else{
    $pageno = 0;
}
$user_details = $db->getAll('tbl_board_img', $pageno);
$details = json_decode($user_details, true);
$user_details = $details['Result'];
$pager = $details['Pagination'];
$add_sticker = "dashboard.php?page=add_board_img";
$current_link = "dashboard.php?page=board_img";
?>
<div class="content">

<div class="container-fluid">
<div class="row">

<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title">Board Image List</h3>
  </div>
  <div class="col col-xs-6 text-right">
    <a href="<?php echo $add_sticker; ?>" class="btn btn-sm btn-primary btn-create">
    <span class="fa fa-plus"></span> Add New Board Image</a>
  </div>
</div>
</div>

<!--  modalpopup ends  -->
<div class="card-content table-responsive">
<table class="table">
    <thead class="text-primary">
        <th>SN#</th>
        <th>image</th>
       
        <th>Action</th>
    </thead>
    <tbody>
    <?php  
    if(sizeof($user_details) > 0){
        $sn = 1;
    foreach ($user_details as $value) {
    ?>
     <tr>
        <td><?php echo $sn; ?></td>
        <td><img class="img-thumbnail" style="width:100px" 
        src="https://odapto.com/board_img/<?php echo $value['bg_img']; ?>" /></td>
    
       
        <td>
            <a href="<?php echo $add_sticker."&id=".$value['id'] ?>" class="btn btn-xs btn-success" title="Edit User"><span class="fa fa-pencil"></span></a>

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
    $(".poptext").text('do you want to delete this Board Image');    
    $("#yes").click(function(event) {
        /* Act on the event */
        $.ajax({
            url: 'temp/template_ajax.php',
            type: 'POST',
            data: {
                action: 'delete_board_img',
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
                  var url = "<?php echo "https://odapto.com/admin/dashboard.php?page=board_img"; ?>";
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