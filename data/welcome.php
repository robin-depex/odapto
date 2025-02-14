<?php 
session_start();
require_once("common/config.php");
if( $_REQUEST['token']){ 
  if( $_SESSION['user_token'] != $_REQUEST['token'] ){
     
     echo "Invalid"; 
    
  }else{


?>
<?php include("inc/header_1.php"); ?>
  <div class="container" style="margin-top: 200px;">
   <div class="row">
     <div class="col-sm-8 col-sm-offset-2 top">
       <div class="col-sm-12">
          <h2 class="modal-title text-center"><strong><strong>Activate Odapto Account </strong></h2>
        </div>
        <div class="modal-body">

          <p style="text-align: justify;color: #000;margin-top: 50px">
            Welcome to odapto.com, 
            please check Your Email To verify Your Account. <br>
          </p>

        </div>
        <div class="modal-footer">
          <a href="login.php" class="btn btn-success btn-block">Login</a>
        </div>
      </div>
      
    </div>
  </div>

</body>
</html>
<?php } }else{
  header("location:".SITE_URL);
  } ?>