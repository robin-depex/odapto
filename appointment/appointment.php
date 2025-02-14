<!DOCTYPE html>
<html lang="en">
<head>
<title>Appointment</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet"  href="css/lightslider.css"/>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,300i,400,500,600,700,800" rel="stylesheet">
<link rel="stylesheet"  href="css/style.css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/lightslider.js"></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body>
<div class="headDate">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
			<div class="backArrow">
				<a style="text-decoration: none;" href="index.php"<i class="fa fa-long-arrow-left fa-3x" aria-hidden="true"></i></a>
			</div>
				<h4><?php echo $_REQUEST['day']; ?> </h4>
                <p><?php echo $_REQUEST['month']; ?> <?php echo $_REQUEST['date']; ?>, <?php echo $_REQUEST['year']; ?><br>
Time zone is <?php echo date_default_timezone_get(); ?></p>
			</div>
		</div>
	</div>
  </div>


<div class="container">
  <div class="row">
     <div class="col-sm-12">
       <div style="margin: 40px 0" class="col-sm-6">
        <h3>Bel afspraak maken</h3>
        <p><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $_REQUEST['time']; ?>, <?php echo $_REQUEST['date']; ?>, <?php echo $_REQUEST['year']; ?></p>
         <p><img style="width: 20px" src="img/bookmark.png"> <?php echo $_REQUEST['country']; ?> Heb je advies nodig? Of wil je meer weten over onze Social Media diensten?</p>
         <p><img style="width: 20px" src="img/target.png"> India</p>
       </div>
       <div style="margin: 20px 0" class="col-sm-6">
       <h3>Fill the information</h3>
         <div class="form-group">
         <label>Username</label>
           <input type="text" name="Username" class="form-control">
         </div>
           <div class="form-group">
           <label>Email Address</label>
           <input type="email" name="Email Address" class="form-control">
         </div>
           <div class="form-group">
           <label>Telephone Number</label>
           <input type="text" name="Email Address" class="form-control">
         </div>
         <div class="form-group">
          <label for="comment">Comment:</label>
          <textarea class="form-control" rows="5" id="comment"></textarea>
          </div>
          <button type="button" class="btn btn-info">Submit</button>
       </div>
     </div>
  </div>
</div>






<script type="text/javascript">
$(document).ready(function(){
$(".timeBtn").click(function(){
$(".timeBtn").css("width" , "100%");
$(".ConfirmBtn").css("display" , "none");
$(this).next().css("display" , "inline-block");
$(this).css("width" , "49%");
});	


$('input[name="time_notation"]').click(function() {
   var hrtime = this.value;

   if(hrtime == 'notation_date_12'){
   	$('.notation_date_24').hide();
   	$('.notation_date_12').show();
   }
   
   if(hrtime == 'notation_date_24'){
   	$('.notation_date_12').hide();
   	$('.notation_date_24').show();	
   }

});

});
</script>
</body>