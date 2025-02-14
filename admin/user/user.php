<?php 
date_default_timezone_set("Asia/Kolkata"); 
$path = $_SERVER['DOCUMENT_ROOT'];
include('dbconfig.php');
if(!empty($_GET['pno'])){
    $pageno = $_GET['pno']; 
}else{
    $pageno = 0;
}

$user_details = $db->getAllUser($pageno);

$details = json_decode($user_details, true);
$user_details = $details['Result'];
$pager = $details['Pagination'];
//echo "<pre>";print_r($user_details);echo "</pre>";
$add_user = "dashboard.php?page=adduser";
$cpass = "dashboard.php?page=cpass";
?>
<div class="content">

<div class="container-fluid">
<div class="row">
<div class="col-sm-12" style="margin-top:80px;">
<div class="panel panel-default panel-table">
<div class="panel-heading">
<div class="row">
  <div class="col col-xs-6">
    <h3 class="panel-title">User List</h3>
  </div>

</div>
</div> 
<!--  modalpopup ends  -->
<div class="card-content table-responsive">
<table class="table">
    <thead class="text-primary">
        <th>ID#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Membership</th>
        <th>Status</th>
        <th>Join Date</th>
        <th>Privilege</th>
        <th>Action</th>
    </thead>
    <tbody>
    <?php  
    if(sizeof($user_details) > 0){
    foreach ($user_details as $value) {
        //print_r($value);
    ?>
     <tr>
        <td><?php echo $value['id']; ?></td>
        <td><?php echo $value['name']; ?></td>
        <td><?php echo $value['email']; ?></td>
       <td><?php if($value['membership_plan']==1){ 
                   echo 'Free';
                   }else if($value['membership_plan']==2){
                   echo 'Business';
                   $now=time();
                        $expire_on= strtotime($value['expiry_date']);
                        if($expire_on >$now){ 
                            $day_diff = $expire_on - $now;
                            echo "<br><span class='text-danger'>". round($day_diff / (60 * 60 * 24))." days left</span>";
                        }else{
                            echo"<br><span class='text-danger'> Expired</span>";
                        }
                       
                   }else if($value['membership_plan']==3){
                   echo 'Enterprise';
                       $now=time();
                        $expire_on= strtotime($value['expiry_date']);
                        if($expire_on >$now){ 
                            $day_diff = $expire_on - $now;
                            echo "<br><span class='text-danger'>". round($day_diff / (60 * 60 * 24))." days left</span>";
                        }else{
                            echo"<br><span class='text-danger'> Expired</span>";
                        }
                   } 
                   ?>
       
        <?php
            
        ?>
       </td>
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
        <td class="text-primary"><?php echo date("F jS, Y", strtotime($value['addDate'])); ?></td>
        <td><?php if($value['privilege'] == '1'){?> <button class="btn btn-success btn-sm"> Yes </button> <?php } else { ?><button class="btn btn-danger btn-sm"> No </button> <?php } ?></td>
        <td>
            <a href="<?php echo $add_user."&id=".$value['id'] ?>" class="btn btn-xs btn-success" title="Edit User"><span class="fa fa-pencil"></span></a>

          <!--  <a href="<?php echo $cpass."&id=".$value['id'] ?>" class="btn btn-xs btn-warning" title="change password"><span class="fa fa-lock"></span></a>-->

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
        <a href="<?php echo $user ?>" class="btn btn-xs btn-success"><?php echo $page; ?></a> 
    </li>
    <?php    
}else{
    ?>
    <li style="float: left;">
        <a href="<?php echo $user."&pno=".$i ?>" class="btn btn-xs btn-success"><?php echo $page; ?></a> 
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
            url: 'user/userRegister.php',
            type: 'POST',
            data: {
                action: 'deleteUser',
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
                  var url = "<?php echo "https://odapto.com/admin/dashboard.php?page=user"; ?>";
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