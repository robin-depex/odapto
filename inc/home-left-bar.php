 
<?php 

//print_r($_SESSION);die;
require_once("common/config.php");
require_once("DBInterface.php");
$db = new Database();
$db->connect();


?>
 <div class="flex-pos" >
     <div style="position:sticky;top:0" class="col-sm-3" >
       <div id="f" class="left-section">
       <div style="padding:0" class="col-sm-2">
         <button style="border-radius: 0" class="form-control"><i class="fa fa-search"></i></button>
       </div>
       <div style="padding: 0" class="col-sm-10">
         <div class="form-group">
           <input  style="background: #f1f3f5;border-radius: 0" type="text" name="search_text" id="search_text" class="form-control" placeholder="Search Templates">
         </div>
       </div>
         <ul id="button">
           <li><a href="dashboard.php?page=home&cat=featured">Featured</a></li>

           <?php $cat_list=$db->all('tbl_tmp_category'); foreach ($cat_list as $cat_list) { // print_r($cat_board);die; ?>
             <li><a href="dashboard.php?page=home&cat=<?php echo $cat_list['id'];?>"><?php echo strtoupper($cat_list['cat_name']);?></a></li>
          <?php }

           ?>
        
         </ul>

      <!--      <input list="countries" name="countries" />
    <datalist id="countries">
        <option value="India">India</option>
        <option value="United States">United States</option>
        <option value="United Kingdom">United Kingdom</option> 
        <option value="Germany">Germany</option> 
        <option value="France">France</option> 
    </datalist> -->
       </div>

     </div>
 <script type="text/javascript">
    /* $('#search_text').keyup(function(){
      var search = $(this).val();
      //alert(search);
      if(search != '')
      {
         $.ajax({
       url:"ajaxfetch.php",
       method:"POST",
       data:{type:'temp_search',query:search},
       success:function(data)
       {
        // alert(data);
         console.log(data);
        //$('#staredBoard').data(data);
        $('#mydiv').html(data);
        $('#view').html(data);
       }
      });
      }
      else
      {
       page.reload();
      }
     });*/
     
     //dc code 
   
    $(document).ready(function(){
        //search and filter templates
      $("#search_text").on("keyup", function() {
        var value = $(this).val().toLowerCase();
       $(".temp_div").filter(function() {
          $(this).toggle($('.temp_head',this).text().toLowerCase().indexOf(value) > -1)
        }); 
      });
     
      
    });
     </script>