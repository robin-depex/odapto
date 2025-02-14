<?php 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
    $pageno = $_GET['pno']; 
}else{
    $pageno = 0;
}
$user_details = $db->getAll('stickers_images', $pageno);
$details = json_decode($user_details, true);
$user_details = $details['Result'];
$pager = $details['Pagination'];
$add_sticker = "dashboard.php?page=add_sticker";
$current_link = "dashboard.php?page=stickers";
?>
<div class="content">

<div class="container-fluid">
<div class="row">
<div class="container">
<div class="col-md-12">
<div class="col-md-6 pull-right">
  <div class="col col-xs-6 pull-right">
    <a href="<?php echo $add_sticker; ?>" class="btn btn-sm btn-primary btn-create"><span class="fa fa-plus"></span>Add New Sticker</a>
  </div>
</div>
</div>
</div>
<div class="col-md-12">
<div class="card">
<div class="card-header" data-background-color="purple">
<h4 class="title">Stickers List</h4>
<p class="category">Odapto Stickers Lists</p>
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
        src="<?php echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.$value['images']; ?>" /></td>
    
       
        <td>
            <a href="<?php echo $add_sticker."&id=".$value['id'] ?>" class="btn btn-xs btn-success" title="Edit User"><span class="fa fa-pencil"></span></a>

            <a href="javascript:void(0)" class="btn btn-xs btn-danger" title="Delete Sticker"><span class="fa fa-trash" id="<?php echo $value['id']; ?>" onclick="return deleteUser(this.id);"></span></a>

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
    $(".poptext").text('do you want to delete this Sticker');    
    $("#yes").click(function(event) {
        /* Act on the event */
        $.ajax({
            url: 'temp/template_ajax.php',
            type: 'POST',
            data: {
                action: 'deletesticker',
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
                  var url = "<?php echo "https://www.odapto.com/admin/dashboard.php?page=stickers"; ?>";
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