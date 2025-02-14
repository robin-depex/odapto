
			
		</div>
</div>

</body>

	<!--   Core JS Files   -->
	
<script src="assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
  <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="assets/js/material.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

	<!--  Notifications Plugin    -->
	<script src="assets/js/bootstrap-notify.js"></script>

	

	<!-- Material Dashboard javascript methods -->
	<script src="assets/js/material-dashboard.js"></script>

	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>
<script type="text/javascript">
      $(document).ready(function(){

      // Javascript method's body can be found in assets/js/demos.js
          demo.initDashboardPageCharts();

      });
  </script>  
<script type="text/javascript">

function isValidEmailAddress(emailAddress) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(emailAddress);
}

$(document).ready(function() {

$("#login").click(function(){

  var username = $("#username").val();
  var pass = $("#password").val();
   if(username == ""){
   		$("#username").focus();
        $("#username").attr({'placeholder':'please enter email address'});
    }else if(!isValidEmailAddress(username)){
        $("#username").focus();
        $("#username").attr({'placeholder':'please enter valid email address'});
      }else if(pass == ""){
        $("#username").focus();
        $("#username").attr({'placeholder':'please enter password'});
    }else{

        $.ajax({
        url: "checkAdminLogin.php",
        type: "POST",
        data: {
        	action: 'admin_log',
        	username: username,
        	password: pass
        },
        beforeSend: function(){
        	$("#login").text('authenicating.....');
        },
        success: function(rel){
          //alert(rel);
          var obj = jQuery.parseJSON(rel);
          if(obj.result=="TRUE")
          {
            window.location.href = "<?php echo 'dashboard.php?page=home' ?>";
          }else if(obj.result=="FALSE"){ 
          	$(".alert-warning").css({'display':'block'});
            $(".alert-warning span.result").text(obj.data);
            $("#login").text('Login')
          }
        }
      });        
      return false; 
    }

});
  
$(".close").click(function(event) {
  /* Act on the event */
  $(".alert-warning").css({'display':'none'});
});  
});
</script>
</html>
