<?php  
error_reporting(0);
$path = $_SERVER['DOCUMENT_ROOT'];
include($path.'/admin/'.'dbconfig.php');
$error = '';
?>
    
   
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
            <div class="row">
                 <div class="alert alert-success alert-dismissable" id="s_msg_div" style="position:relative; display:none">
                    <a href="#" class="close1" data-dismiss="alert" aria-label="close">&times;</a>
                    <center><span id="s_msg">  </span>
                    </center>
                  </div>
            </div>
          <div class="row">
              <?php 
                    $plans=$db->membership_plan('tbl_membership_plan');
                   // print_r($plan); die;
                   if(count($plans)>0)
                   {
                       $i=1;
                       foreach($plans as $plan):
                          ?>
                    <div class="col-md-4 ml-auto mr-auto">
                      <div class="card">
                        <div class="card-header card-header-primary" >
                            <!--<h3 class="card-title">Title</h3> -->
                          <input type="text" name="plan_name" value="<?= $plan['plan_name'] ?>" id="plan_<?=$plan['id'] ?>_name" onblur="return editPlan(this.id,this.name);" class="form-control" style="color:#fff; text-align:center; font-size:20px; margin-bottom: 0px !important;"/>
                          <!-- <p class="card-category"> decription </p> -->
                        <input type="text" name="plan_desc" value="<?= $plan['plan_desc'] ?>" id="plan_<?=$plan['id'] ?>_desc" onblur="return editPlan(this.id,this.name);" class="form-control" style="color:#fff; text-align:center;"/> 
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="email" style="color:#fff; text-align:center; font-size:18px;"> $ </label>
                            <div class="col-sm-10">
                               <input type="text" name="plan_price" value="<?= $plan['plan_price'] ?>" id="plan_<?=$plan['id'] ?>_price" onblur="return editPlan(this.id,this.name);" class="form-control" style="color:#fff;  font-size:18px;"/> 
                            </div>
                          </div>
                          <p class="card-category" style="color:#fff; text-align:center;">per/month</p>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive table-upgrade" style="padding-left:5px">
                            
                                  
                                <input type="text" class="form-control" name="feature1" value="<?= $plan['feature1'] ?>" id="plan_<?=$plan['id'] ?>_feature1" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature2" value="<?=  $plan['feature2'] ?>" id="plan_<?=$plan['id'] ?>_feature2" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature3" value="<?=  $plan['feature3'] ?>" id="plan_<?=$plan['id'] ?>_feature3" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature4" value="<?=  $plan['feature4'] ?>" id="plan_<?=$plan['id'] ?>_feature4" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature5" value="<?=  $plan['feature5'] ?>" id="plan_<?=$plan['id'] ?>_feature5" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature6" value="<?=  $plan['feature6'] ?>" id="plan_<?=$plan['id'] ?>_feature6" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature7" value="<?=  $plan['feature7'] ?>" id="plan_<?=$plan['id'] ?>_feature7" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature8" value="<?=  $plan['feature8'] ?>" id="plan_<?=$plan['id'] ?>_feature8" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature9" value="<?=  $plan['feature9'] ?>" id="plan_<?=$plan['id'] ?>_feature9" onblur="return editPlan(this.id,this.name);"/>
                                <input type="text" class="form-control" name="feature10" value="<?=  $plan['feature10'] ?>" id="plan_<?=$plan['id'] ?>_feature10" onblur="return editPlan(this.id,this.name);"/>
                                
                               
                               
                          </div>
                        </div>
                      </div>
                    </div>
                          
                       
                       <?php
                       $i++;
                        endforeach;
                       
                   }else{
                       echo "No record Found";
                   }
                   
                ?>
           
            
            
          </div>
        </div>
      </div>
      
<script type="text/javascript">

    function editPlan(plan,name){
      var card_title = plan;
      var id= plan.split("_");
     plan_id=id['1']; 
     var field_value=$('#'+plan).val();
     //alert(field_value);
     
     $.ajax({
        url: "updateMembershipPlan.php",
        type: "POST",
        data: {action:'update_plan',plan_id:plan_id,field_name:name,field_value:field_value},
        success: function(rel){
          //alert(rel);
          $("#s_msg_div").css('display','block');
          $('#s_msg').html(rel);
          
          //HIDE SUCCESS ALERT
          $("#s_msg_div").fadeTo(3000, 500).slideUp(500, function(){
                $("#s_msg_div").slideUp(500);
           });
        }
        
        
      });        
      return false; 
     
    }
     
     
    
</script>
  
  
